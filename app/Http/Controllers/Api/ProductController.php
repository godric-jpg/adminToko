<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);

        $products = Product::with('category')
            ->filter($request->only(['search', 'category_id', 'min_price', 'max_price', 'in_stock']))
            ->sortBy($request->query('sort'))
            ->paginate($perPage)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $userId = $request->user()?->id ?? 1;   
        $product = Product::create([
            ...collect($data)->except('img')->all(),
            'user_id' => $userId,
            'img' => $request->hasFile('img')
                ? $request->file('img')->store('products', 'public')
                : null,
            'slug' => $this->uniqueSlug($data['name']),
        ]);

        return (new ProductResource($product->load('category')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id)
    {
        return new ProductResource(Product::with('category')->findOrFail($id));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        // Catatan: Pastikan Policy Gate mengizinkan update
        Gate::authorize('update', $product);

        $data = collect($request->validated())->except('img')->all();

        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->getKey());
        }

        if ($request->hasFile('img')) {
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        $product->update($data);

        return new ProductResource($product->load('category'));
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);

        if ($product->img) {
            Storage::disk('public')->delete($product->img);
        }
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    private function uniqueSlug(string $name, mixed $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        $keyName = (new Product())->getKeyName();

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where($keyName, '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}