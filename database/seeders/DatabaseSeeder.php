<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Category::factory(5)->create();
        \App\Models\Product::factory(10)->create();

        // \App\Models\Customer::factory()->create([
        //     'name' => 'Test Customer',
        //     'email' => 'test@example.com',
        // ]);
    }
}
