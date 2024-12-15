<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;

class ProductRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_and_time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user' => User::factory(),
            'product' => Product::factory(), 
            'rating' => $this->faker->numberBetween(1, 5),
            'note' => $this->faker->sentence(15),
            'provider' => $this->faker->numberBetween(1, 5),
        ];
    }
}
