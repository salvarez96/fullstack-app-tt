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

    public function index()
    {
        return view('products');
    }

    public function show()
    {
        try {
            $products = $this->productService->getProducts();

            if ($products->isEmpty()) {
                return $this->jsonResponse('No products found', 404);
            }

            return ProductResource::collection($products);
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to get products',
                500,
                null,
                $e->getMessage()
            );
        }
    }

    public function showProduct(int $id)
    {
        try {
            $product = $this->productService->getProduct($id);

            if (!$product) {
                return $this->jsonResponse('Product not found', 404);
            }

            return $product;
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to get product',
                500,
                null,
                $e->getMessage()
            );
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

            return $this->jsonResponse('Product created successfully', 201, $newProduct);
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to create product',
                500,
                null,
                $e->getMessage()
            );
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
                return $this->jsonResponse('Product not found', 404);
            }

            $updatedProduct = $this->productService->updateOrReplaceProduct($request, $product);

            if ($updatedProduct) {
                return $this->jsonResponse(
                    'Product updated successfully',
                    200,
                    $product
                );
            }

            throw new Exception('Failed to update product');

        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to update product',
                500,
                null,
                $e->getMessage()
                );
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
                return $this->jsonResponse('Product not found', 404);
            }

            $replacedProduct = $this->productService->updateOrReplaceProduct($request, $product);

            if ($replacedProduct) {
                return $this->jsonResponse(
                    'Product replaced successfully',
                    200,
                    $product
                );
            }

            throw new Exception('Failed to replace product');
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to replace product',
                500,
                null,
                $e->getMessage()
                );
        }
    }

    public function destroy(int $id) {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->jsonResponse('Product not found', 404);
            }

            $isProductDeleted = $this->productService->deleteProduct($product);

            return $isProductDeleted
                ? $this->jsonResponse('Product deleted successfully', 200)
                : $this->jsonResponse('Failed to delete product', 500);
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to delete product',
                500,
                null,
                $e->getMessage()
                );
        }
    }

    private function jsonResponse(string $message, int $code, $data = null, $errorMessage = null)
    {
        $response = [
            'code' => $code,
            'message' => $message,
        ];

        if ($data) $response['data'] = $data;
        if ($errorMessage) $response['errorMessage'] = $errorMessage;

        return response()->json($response, $code);
    }
}
