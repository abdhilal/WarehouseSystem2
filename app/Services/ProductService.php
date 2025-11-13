<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function getProducts(Request $request = null)
    {
        $query = Product::query()->with(['factory', 'warehouse']);
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }
        return $query->latest()->paginate(20);
    }

    public function applySearch($query, string $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhereHas('factory', function ($f) use ($term) {
                  $f->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('warehouse', function ($w) use ($term) {
                  $w->where('name', 'LIKE', "%{$term}%");
              });
        });
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }
}