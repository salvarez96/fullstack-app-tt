<?php

namespace App\Services;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductService {
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProducts()
    {
        return $this->product->with('category')->paginate(10);
    }

    public function getProduct(int $id)
    {
        return $this->product->with('category')->find($id);
    }

    public function createProduct(Product $data)
    {
        return $this->product->create([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price,
            'image' => $this->getExternalImage(),
            'category_id' => $data->category_id,
        ]);
    }

    public function updateProduct(Request $request, Product $product)
    {
        $updatedProduct = [...$product->toArray(), ...$request->all()];
        return $product->update($updatedProduct);
    }

    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }

    public function getExternalImage() {
        $randomNumber = rand(1, 5);
        $url = "https://picsum.photos/v2/list?page={$randomNumber}";
        $client = new Client();

        $responseBody = $client->get($url)->getBody()->getContents();
        $imageUrl = json_decode($responseBody)[rand(0, 30)]->download_url;

        return $imageUrl;
    }
}
