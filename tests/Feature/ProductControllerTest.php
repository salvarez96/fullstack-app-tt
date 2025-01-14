<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_index()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertViewIs('products');
    }

    public function test_show()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/v1/products');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'image',
                    'category_id',
                ]
            ]
        ]);
    }

    public function test_showProduct()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/v1/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image,
            'category_id' => $product->category_id,
        ]);
    }

    public function test_create()
    {
        $category = Category::factory()->create();
        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/v1/products', $productData);
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Product created successfully',
            'data' => [
                'name' => 'Test Product',
                'description' => 'Test Description',
                'price' => 100,
                'category_id' => $category->id,
            ]
        ]);
    }

    public function test_update()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 200,
            'category_id' => $category->id,
        ];

        $response = $this->patchJson("/api/v1/products/{$product->id}", $updateData);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product updated successfully',
            'data' => [
                'name' => 'Updated Product',
                'description' => 'Updated Description',
                'price' => 200,
                'category_id' => $category->id,
            ]
        ]);
    }

    public function test_replace()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $replaceData = [
            'name' => 'Replaced Product',
            'description' => 'Replaced Description',
            'price' => 300,
            'category_id' => $category->id,
        ];

        $response = $this->putJson("/api/v1/products/{$product->id}", $replaceData);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product replaced successfully',
            'data' => [
                'name' => 'Replaced Product',
                'description' => 'Replaced Description',
                'price' => 300,
                'category_id' => $category->id,
            ]
        ]);
    }

    public function test_destroy()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->deleteJson("/api/v1/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product deleted successfully',
        ]);
    }
}
