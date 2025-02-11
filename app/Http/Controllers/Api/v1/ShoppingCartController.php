<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShoppingCartController extends Controller
{
    /**
     * Get the user's active cart and calculate the total
     */
    public function index(Request $request)
    {
        try {
            $cart = $this->getUserCart($request->user());

            // Calculate total price for the cart items
            $total = $cart->items->sum(fn($item) => $item->quantity * $item->variant->price);

            return response()->json([
                'cart_items' => $cart->items,
                'total' => $total
            ]);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'Error fetching cart', 500);
        }
    }

    /**
     * Add a product variant to the user's cart
     */
    public function add(AddProductToCartRequest $request)
    {
        // Validation is already handled by the AddProductToCartRequest class
        $validatedData = $request->validated();

        try {
            // Fetch the product variant to be added
            $variant = ProductVariant::with('product')->findOrFail($validatedData['product_variant_id']);
            
            // Fetch the user's active cart
            $cart = $this->getUserCart($request->user());

            // Check if the quantity exceeds available stock
            if ($validatedData['quantity'] > $variant->stock_quantity) {
                return response()->json([
                    'message' => 'Quantity exceeds available stock',
                ], 422);
            }

            // Check if the product variant already exists in the cart
            $existingItem = $cart->items()->where('product_variant_id', $validatedData['product_variant_id'])->first();
            if ($existingItem) {
                return response()->json([
                    'message' => 'Variant already in cart!',
                ], 422);
            }

            // Create the cart item
            $cartItem = $cart->items()->create([
                'product_variant_id' => $validatedData['product_variant_id'],
                'quantity' => $validatedData['quantity'],
                'unit_price' => $variant->product->price,
            ]);

            // Load the related variant for the cart item
            $cartItem->load('variant');

            return response()->json([
                'message' => 'Item added to cart successfully',
                'cart_item' => $cartItem
            ], 201);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'Error adding item to cart', 500);
        }
    }

    /**
     * Update the quantity of a cart item
     */
    public function update(UpdateCartItemRequest $request, $id)
    {
        // Validation is handled by UpdateCartItemRequest
        $validatedData = $request->validated();

        try {
            $cartItem = $this->findCartItem($id);

            $variant = ProductVariant::findOrFail($cartItem->product_variant_id);
            if ($validatedData['quantity'] > $variant->stock_quantity) {
                return response()->json([
                    'message' => 'Quantity exceeds available stock',
                ], 422);
            }

            // Update cart item quantity
            $cartItem->update(['quantity' => $validatedData['quantity']]);

            // Load the related variant after update
            $cartItem->load('variant');

            return response()->json([
                'message' => 'Cart item updated successfully',
                'cart_item' => $cartItem
            ], 200);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'Error updating cart item', 500);
        }
    }

    /**
     * Remove a cart item
     */
    public function destroy($id)
    {
        try {
            $cartItem = $this->findCartItem($id);
            $cartItem->delete();

            return response()->json([
                'message' => 'Item removed from cart'
            ], 200);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'Error removing item from cart', 500);
        }
    }

    /**
     * Get the current user's active cart (or create it if not exists)
     */
    private function getUserCart($user)
    {
        // We use `firstOrCreate` to ensure an active cart is returned or created
        return $user->cart()->firstOrCreate(['status' => 'created']);
    }

    /**
     * Find a specific cart item by ID
     */
    private function findCartItem($id)
    {
        Log::info("Searching for cart item with ID: {$id} for user ID: " . Auth::id());

        $cartItem = CartItem::where('id', $id)
            ->whereHas('cart', fn($query) => $query->where('user_id', Auth::id()))
            ->first();

        if (!$cartItem) {
            Log::warning("Cart item not found with ID: {$id} for user ID: " . Auth::id());
            throw new ModelNotFoundException("Cart item not found");
        }

        Log::info("Cart item found: ", ['cart_item' => $cartItem]);
        return $cartItem;
    }

    /**
     * Centralized exception handling
     */
    private function handleException(\Throwable $e, string $message, int $statusCode)
    {
        Log::error("{$message}: " . $e->getMessage(), [
            "stack" => $e->getTraceAsString(),
        ]);
        return response()->json([
            'message' => $message,
            'error' => $e->getMessage()
        ], $statusCode);
    }
}
