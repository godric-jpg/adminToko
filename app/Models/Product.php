<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id',
        'price',
        'img',
        'stock',
        'slug',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeFilter(Builder $query, array $f): Builder
    {
        return $query
            ->when($f['search'] ?? null, fn ($q, $s) => $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            }))
            ->when($f['category_id'] ?? null, fn ($q, $c) => $q->where('category_id', $c))
            ->when($f['min_price'] ?? null, fn ($q, $p) => $q->where('price', '>=', $p))
            ->when($f['max_price'] ?? null, fn ($q, $p) => $q->where('price', '<=', $p))
            ->when(isset($f['in_stock']) && filter_var($f['in_stock'], FILTER_VALIDATE_BOOLEAN),
                fn ($q) => $q->where('stock', '>', 0));
    }
    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        $allowed = ['name', 'price', 'stock', 'created_at'];
        $dir = 'asc';
        if ($sort && str_starts_with($sort, '-')) {
            $dir = 'desc';
            $sort = substr($sort, 1);
        }
        return in_array($sort, $allowed, true)
            ? $query->orderBy($sort, $dir)
            : $query->latest();
    }
}