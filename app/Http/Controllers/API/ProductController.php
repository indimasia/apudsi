<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'shop_id' => $request->shop_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'data' => $product], 201);
    }

    public function index()
    {
        $products = Product::all();
        return response()->json(['success' => true, 'data' => $products]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        
        
        $request->validate([
            'shop_id' => 'sometimes|required|exists:shops,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->only(['name', 'description', 'price', 'stock', 'shop_id']));

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
    }
}
