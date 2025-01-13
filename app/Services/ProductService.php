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

    public function getProducts(Request $request)
    {
        if (count($request->all())) {
            $query = $this->product->query();

            if ($request->has('name')) {
                $query->where('name', 'like', "%{$request->name}%");
            }

            if ($request->has('min-price') && $request->has('max-price')) {
                $query->whereBetween('price', [$request['min-price'], $request['max-price']]);
            }

            if ($request->has('category-id')) {
                $query->where('category_id', $request['category-id']);
            }

            return $query->with('category')->paginate(10);
        }

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

    public function updateOrReplaceProduct(Request $request, Product $product)
    {
        return $product->update($request->all());
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
