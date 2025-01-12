<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic products',
        ]);
        Category::create([
            'name' => 'Clothes',
            'description' => 'Clothing products',
        ]);
        Category::create([
            'name' => 'Books',
            'description' => 'Book products',
        ]);
        Category::create([
            'name' => 'Furniture',
            'description' => 'Furniture products',
        ]);
        Category::create([
            'name' => 'Toys',
            'description' => 'Toy products',
        ]);
    }
}
