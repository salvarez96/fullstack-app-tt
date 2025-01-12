<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function show() {
        try {
            $categories = $this->categoryService->getCategories();

            if ($categories->isEmpty()) {
                return $this->jsonResponse('No categories found', 404);
            }

            return $categories;
        } catch (Exception $e) {
            return $this->jsonResponse(
                'Failed to get categories',
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
