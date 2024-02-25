<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order_id" => rand(1,10),
            "customer_id" => \App\Models\Customer::all()->random()->id,
            "sku" => \App\Models\Product::all()->random()->sku,
            "quantity" => rand(1,5)
        ];
    }
}
