<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private function transformProduct($product)
    {
        // Decode 'other_attributes' and return the transformed product
        $product->other_attributes = json_decode($product->other_attributes, true);
        return $product;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $products = Product::with('variants')->paginate($perPage);

            if ($products->isEmpty()) {
                return response()->json(['message' => 'Products Not Found'], 404);
            }

            // Transform each product (decode 'other_attributes')
            $products->transform(fn($product) => $this->transformProduct($product));

            return response()->json($products, 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching products: ' . $th->getMessage(), [
                'stack' => $th->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Error fetching products',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $product = Product::with('variants')->findOrFail($id);
            return response()->json($this->transformProduct($product), 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Error fetching product: ' . $e->getMessage(), [
                'product_id' => $id,
                'stack' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Throwable $th) {
            Log::error('Error fetching product: ' . $th->getMessage(), [
                'stack' => $th->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Error fetching product',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $productData = $request->only(['name', 'description', 'price', 'other_attributes']);
            $product = Product::create($productData);

            // Create variants if provided
            if ($request->has('variants')) {
                $variants = $request->input('variants');
                foreach ($variants as $variant) {
                    $variant['product_id'] = $product->id;
                    ProductVariant::create($variant);
                }
            }

            DB::commit();

            // Transform product data before returning
            return response()->json($this->transformProduct($product->load('variants')), 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error creating product and variants: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $product = Product::with('variants')->findOrFail($id);
            $product->update($request->only(['name', 'description', 'price', 'other_attributes']));
            
            // Update variants if any
            if ($request->has('variants')) {
                $variants = $request->input('variants');
                foreach ($variants as $variant) {
                    if (isset($variant['id'])) {
                        $existingVariant = ProductVariant::findOrFail($variant['id']);
                        $existingVariant->update($variant);
                    } else {
                        $variant['product_id'] = $product->id;
                        ProductVariant::create($variant);
                    }
                }
            }

            return response()->json($this->transformProduct($product->load('variants')), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error updating product',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->variants()->delete(); // Deleting associated variants
            $product->delete();

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting product',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Product::with('variants');

            // Apply filters
            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->input('min_price'));
            }

            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->input('max_price'));
            }

            if ($request->has('attributes') && $request->has('value')) {
                $attributes = $request->input('attributes');
                $value = $request->input('value');
                $query->where('other_attributes', 'like', '%\"' . $attributes . '\":\"%' . $value . '%\"%');
            }

            if ($request->has('color') || $request->has('size')) {
                $query->whereHas('variants', function ($q) use ($request) {
                    if ($request->has('color')) {
                        $q->where('color', $request->color);
                    }
                    if ($request->has('size')) {
                        $q->where('size', $request->size);
                    }
                });
            }

            $products = $query->paginate();
            $products->transform(fn($product) => $this->transformProduct($product));

            return response()->json($products, 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching filtered products: ' . $th->getMessage(), [
                'stack' => $th->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Error fetching filtered products',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
