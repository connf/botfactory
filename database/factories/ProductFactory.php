<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "sku" => $this->generateSku(),
            "category_id" => \App\Models\Category::all()->random()->id,
            "product_name" => fake()->word(),
            "weight" => rand(1,10).".".random(0,99),           
        ];
    }

    private function generateSku()
    {
        // Get last product in the DB
        $product = \App\Models\Product::all()->sortByDesc('id')->first();

        // If this new product is not the first product then get the existing sku
        if (isset($product->sku)) {
            $lastSku = $product->sku;
        }

        // If we have a sku
        if (isset($lastSku)) {
            // Strip "ENG-" and generate the new sku from the previous one +1
            $newSku = (int) str_replace($lastSku, "ENG-", "") + 1;
        } else {
            // Otherwise set the sku to 1
            $newSku = 1;
        }

        // Now build the sku and return the value
        return "ENG-".strpos("000".$newSku, 0, -3);
    }
}
