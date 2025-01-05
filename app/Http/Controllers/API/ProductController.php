<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\ProductImage;
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

            $product = Product::create([
                'shop_id' => $request->shop_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);

            if ($request->hasFile('images')) {
                $images = $request->file('images');

                if (count($images) > 5) {
                    return new ResponseJsonResource(null, 'You can only upload a maximum of 5 images', 422);
                }

                foreach ($images as $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                    ]);
                }
            }

            return new ResponseJsonResource($product->load('images'), 'Product created successfully', 201);
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    public function getProductsForUser(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', 10);

            $query = Product::with(['images', 'category'])
                        ->where('shop_id', $shopId);

            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $products = $query->paginate($perPage);
            return new ResponseJsonResource($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to get product: ' . $e->getMessage(), 500);
        }
    }

    public function index()
    {
        try {
            $shopId = auth()->user()->shops()->first()->id;
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', 10);
            $products = Product::with(['images', 'category'])
                           ->where('shop_id', $shopId)
                           ->get();
            return new ResponseJsonResource($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with(['images', 'category'])->findOrFail($id);
            
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
            $product = Product::with('images')->findOrFail($id);

            if ($request->has('category_id')) {
                $category = \App\Models\Category::find($request->category_id);
                if (!$category) {
                    return new ResponseJsonResource(null, 'Invalid category ID', 422);
                }
            }

            $product->update($request->only(['name', 'description', 'price', 'stock', 'shop_id', 'category_id']));

            if ($request->hasFile('images')) {
                $images = $request->file('images');

                if (count($images) > 5) {
                    return new ResponseJsonResource(null, 'You can only upload a maximum of 5 images', 422);
                }

                if ($product->images) {
                    foreach ($product->images as $image) {
                        Storage::disk('public')->delete($image->image);
                        $image->delete();
                    }
                }

                foreach ($images as $image) {
                    $imagePath = $image->store('products', 'public');
                    $product->images()->create(['image' => $imagePath]);
                }
            }

            return new ResponseJsonResource($product->load('images'), 'Product updated successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to update product: ' . $e->getMessage(), 500);
        }
    }



    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if (!$product) {
                return new ResponseJsonResource(null, 'Product not found', 404);
            }

            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }

            $product->delete();

            return new ResponseJsonResource(null, 'Product deleted successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to delete product: ' . $e->getMessage(), 500);
        }
    }

    public function destroyImage($id)
    {
        $productImage = ProductImage::find($id);

        if (!$productImage) {
            return new ResponseJsonResource(null, 'Image not found', 404);
        }

        if (Storage::exists($productImage->image)) {
            Storage::delete($productImage->image);
        }

        $productImage->delete();

        return new ResponseJsonResource(null, 'Image deleted successfully');
    }
}
