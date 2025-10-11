<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->query('q'), function($q) use ($request){
                $term = $request->query('q');
                $q->where(function($qq) use ($term){
                    $qq->where('name', 'like', "%{$term}%")
                       ->orWhere('sku', 'like', "%{$term}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json(['status' => 'success', 'data' => $products]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'sku' => 'required|string|max:60|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);
        $product = Product::create($validated);
        return response()->json(['status' => 'success', 'data' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json(['status' => 'success', 'data' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'sku' => 'sometimes|required|string|max:60|unique:products,sku,' . $product->id,
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string'
        ]);
        $product->update($validated);
        return response()->json(['status' => 'success', 'data' => $product]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['status' => 'success', 'message' => 'Product deleted']);
    }
}
