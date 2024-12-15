<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Product;
use \App\Models\ProductRating;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Product::truncate();
        ProductRating::truncate();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123!'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        $users = User::factory(5)->create(); 

        $product1 = Product::create([
            'name' => 'Laptop',
        ]);

        $product2 = Product::create([
            'name' => 'Smartphone',
        ]);

        $product3 = Product::create([
            'name' => 'Headphones',
        ]);

        $rating1 = ProductRating::create([
            'date_and_time' => now(),
            'user' => $users[0]->id,
            'product' => $product1->id,
            'rating' => 5,
            'note' => 'Excellent laptop, very fast and reliable!',
            'provider' => 1,
        ]);

        $rating2 = ProductRating::create([
            'date_and_time' => now(),
            'user' => $users[1]->id,
            'product' => $product2->id,
            'rating' => 4,
            'note' => 'Great smartphone, but battery life could be better.',
            'provider' => 2,
        ]);

        $rating3 = ProductRating::create([
            'date_and_time' => now(),
            'user' => $users[2]->id,
            'product' => $product3->id,
            'rating' => 5,
            'note' => 'Amazing sound quality, worth every penny!',
            'provider' => 1,
        ]);

        Product::factory(10)->create(); 
        ProductRating::factory(20)->create();
    }
}
