<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('category')->get()
            ->map(fn ($c) => [
                'id' => $c->category_id,
                'name' => $c->category,
                'products_count' => $c->products_count,
            ]);
        return response()->json(['data' => $categories]);
    }
}