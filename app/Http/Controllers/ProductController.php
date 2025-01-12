<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show()
    {
        try {
            $products = $this->productService->getProducts();

            if ($products->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => 'No products found',
                ], 404);
            }

            return ProductResource::collection($products);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to get products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showProduct(int $id)
    {
        try {
            $product = $this->productService->getProduct($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return $product;
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to get product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_id' => 'required|integer|exists:categories,id',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;

            $newProduct = $this->productService->createProduct($product);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => $newProduct
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, int $id) {
        try {
            $request->validate([
                'name' => 'string',
                'description' => 'string',
                'price' => 'numeric',
                'category_id' => 'integer|exists:categories,id',
            ]);

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $updatedProduct = $this->productService->updateOrReplaceProduct($request, $product);

            if ($updatedProduct) {
                return response()->json([
                    'message' => 'Product updated successfully',
                    'data' => $product
                ], 200);
            }

            throw new Exception('Failed to update product');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function replace(Request $request, int $id) {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_id' => 'required|integer|exists:categories,id',
            ]);

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $replacedProduct = $this->productService->updateOrReplaceProduct($request, $product);

            if ($replacedProduct) {
                return response()->json([
                    'message' => 'Product replaced successfully',
                    'data' => $product
                ], 200);
            }

            throw new Exception('Failed to replace product');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to replace product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id) {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $isProductDeleted = $this->productService->deleteProduct($product);

            return $isProductDeleted
                ? response()->json(['message' => 'Product deleted successfully'], 200)
                : response()->json(['message' => 'Failed to delete product'], 500);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
