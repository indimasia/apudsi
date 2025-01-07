<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $orders = Order::with('user', 'product', 'product.images')
                ->whereHas('product', function ($query) {
                    $query->where('shop_id', auth()->user()->shops()->first()->id);
                })
                ->where('status', $request->status)
                ->get();
            return new ResponseJsonResource($orders, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to retrieve orders: ' . $e->getMessage(), 500);
        }
    }

    public function getOrdersForUser()
    {
        $orders = Order::with('product', 'product.images')
            ->where('user_id', auth()->user()->id)
            ->get();
        return new ResponseJsonResource($orders, 'Orders retrieved successfully');
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);
            $totalPrice = $product->price * $request->quantity;
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'kurir' => $request->kurir,
                'notes' => $request->notes,
                'ordered_at' => $request->ordered_at ?? now(),
            ]);
            return new ResponseJsonResource($order, 'Order created successfully', 201);
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to create order: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with('user', 'product', 'product.images')
                ->whereHas('product', function ($query) {
                    $query->where('shop_id', auth()->user()->shops()->first()->id);
                })
                ->findOrFail($id);

            return new ResponseJsonResource($order, 'Order retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to retrieve order: ' . $e->getMessage(), 500);
        }
    }

    public function showForUser($id)
    {
        try {
            $order = Order::with('product', 'product.images')
                ->where('user_id', auth()->user()->id)
                ->findOrFail($id);

            return new ResponseJsonResource($order, 'Order retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to retrieve order: ' . $e->getMessage(), 500);
        }
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $product = Product::findOrFail($request->product_id);
            $totalPrice = $product->price * $request->quantity;
            $order->update([
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'kurir' => $request->kurir,
                'notes' => $request->notes,
                'ordered_at' => $request->ordered_at ?? now(),
            ]);
            return new ResponseJsonResource($order, 'Order updated successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to update order: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return new ResponseJsonResource(null, 'Order deleted successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to delete order: ' . $e->getMessage(), 500);
        }
    }
}
