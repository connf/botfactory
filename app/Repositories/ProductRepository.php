<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * Create a Product record using an array of name, sku and weight
     * We also need a category ID following the creation of a category
     * 
     * @param array
     */
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function find($id)
    {
        return Product::find($id);
        // We could override the find method globally here
        // for example to a findOrFail, should there be a business requirement for this
    }

    public function findBy($field, $search)
    {
        return Product::where($field, $search)->first();
    }

    /**
     * Find an existing record by name or create
     * the Product if it doesn't exist yet
     * 
     * @param string|array
     */
    public function findOrCreate(string|array $data)
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return Product::firstOrCreate($data);
    }
}