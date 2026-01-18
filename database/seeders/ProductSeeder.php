<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();

        // If no categories or users exist, create some
        if ($categories->isEmpty()) {
            $categories = Category::factory()->count(5)->create();
        }

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        // Create 50 products with random categories and users
        Product::factory()->count(50)->create([
            'category_id' => $categories->random()->id,
            'user_id' => $users->random()->id,
        ]);
    }
}
