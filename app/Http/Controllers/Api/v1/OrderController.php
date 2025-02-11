<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get all orders for the logged-in user with pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $orders = $request->user()->orders()
                ->with(['items.variant.product']) // Eager load related data
                ->select('id', 'user_id', 'total_amount', 'order_status', 'created_at') // Select specific columns for performance
                ->paginate(10); // Pagination

            return response()->json($orders, 200);
        } catch (\Throwable $th) {
            Log::error("Error fetching orders: " . $th->getMessage(), [
                "stack" => $th->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Error fetching orders', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a new order from the user's cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;

        // Check if cart exists and is not empty
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty or not found'], 400);
        }

        DB::beginTransaction();

        try {
            // Create the order based on the cart's items and other details
            $order = $user->orders()->create([
                'total_amount' => $cart->items->sum(fn($item) => $item->quantity * $item->unit_price),
                'order_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
            ]);

            // Process each cart item and create the corresponding order item
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);

                // Decrement stock quantity for the ordered variant
                $item->variant->decrement('stock_quantity', $item->quantity);
            }

            // Clear the cart after order creation
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Return the created order with items and product data
            return response()->json($order->load('items.variant.product'), 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error creating order: " . $th->getMessage(), [
                "stack" => $th->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Error creating order', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Get a specific order by ID.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            // Fetch the order with related items and their variants and products
            $order = Order::with('items.variant.product')->findOrFail($id);

            // Check if the user has permission to view the order
            if (! Gate::allows('user-view-order', $order)) {
                return response()->json(['message' => 'Sorry, You dont have access to this resource'], 403);
            }

            return response()->json($order, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Error fetching order: " . $e->getMessage(), [
                "stack" => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Order not found'], 404);
        } catch (\Throwable $th) {
            Log::error("Error fetching order: " . $th->getMessage(), [
                "stack" => $th->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Error fetching order', 'error' => $th->getMessage()], 500);
        }
    }
}
