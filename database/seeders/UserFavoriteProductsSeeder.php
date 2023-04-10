<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;
use App\Models\UserFavoriteProduct;
use Illuminate\Database\Seeder;

class UserFavoriteProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all users and products
        $users = User::all();
        $products = Product::all();

        // Create random favorites for each user
        $faker = Faker::create();
        foreach ($users as $user) {
            $favorites = $faker->randomElements($products, rand(1, 5));
            foreach ($favorites as $favorite) {
                UserFavoriteProduct::create([
                    'user_id' => $user->id,
                    'product_id' => $favorite->id,
                ]);
            }
        }
    }
}
