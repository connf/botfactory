<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function find($id)
    {
        return Customer::find($id);
        // We could override the find method globally here
        // for example to a findOrFail, should there be a business requirement for this
    }

    public function findBy($field, $search)
    {
        return Customer::where($field, $search)->first();
    }

    /**
     * Find an existing record by name or create
     * the Customer if it doesn't exist yet
     * 
     * @param string|array
     */
    public function findOrCreate(string|array $data)
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return Customer::firstOrCreate($data);
    }

    /**
     * Create a Customer record using either the data array or just the string name
     * 
     * @param string|array
     */
    public function create(string|array $data)
    {
        if (is_string($data)) {
            // If the user is creating by string then build the required array
            $data = [
                "name" => $data
            ];
        }

        return Customer::create($data);
    }
}