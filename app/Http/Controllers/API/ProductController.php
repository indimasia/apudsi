<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ResponseJsonResource;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        try {
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

            return new ResponseJsonResource($product, 'Product created successfully', 201);
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    public function getProductsForUser()
    {
        try {
            $products = Product::all();
            return new ResponseJsonResource($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to get product: ' . $e->getMessage(), 500);
        }
    }

    public function index()
    {
        try {
            $shopId = auth()->user()->shops()->first()->id;
            $products = Product::where('shop_id', $shopId)->get();
            return new ResponseJsonResource($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if (!$product) {
                return new ResponseJsonResource(null, 'Product not found', 404);
            }

            return new ResponseJsonResource($product, 'Product retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to show product: ' . $e->getMessage(), 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if (!$product) {
                return new ResponseJsonResource(null, 'Product not found', 404);
            }

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $product->image = $request->file('image')->store('products', 'public');
            }

            $product->update($request->only(['name', 'description', 'price', 'stock', 'shop_id']));

            return new ResponseJsonResource($product, 'Product updated successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to update product: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // if (!$product) {
            //     return new ResponseJsonResource(null, 'Product not found', 404);
            // }

            $product->delete();

            return new ResponseJsonResource(null, 'Product deleted successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to delete product: ' . $e->getMessage(), 500);
        }
    }
}
