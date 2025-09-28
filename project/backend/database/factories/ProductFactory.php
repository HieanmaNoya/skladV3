<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' ' . $this->faker->word,
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->numberBetween(100, 5000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
        ];
    }
}
