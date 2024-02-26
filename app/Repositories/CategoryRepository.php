<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected $appendableNames = [
        'inator',
        'itron',
        'atron',
        'inizer',
    ];
    protected $strippableNames = [
        'ics',
        'ers',
        'ials',
        'ical Components',
    ];

    /**
     * Create a Category record using either the data array or just the string name
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

        return Category::create($data);
    }

    public function find($id)
    {
        return Category::find($id);
        // We could override the find method globally here
        // for example to a findOrFail, should there be a business requirement for this
    }

    public function findBy($field, $search)
    {
        return Category::where($field, $search)->first();
    }

    /**
     * Find an existing record by name or create
     * the category if it doesn't exist yet
     * 
     * @param string|array
     */
    public function findOrCreate(string|array $data)
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return Category::firstOrCreate($data);
    }

    /**
     * Create a bot name using the name of a category
     * Name can be pulled from a Category instance
     * Or the string for the name itself
     * 
     * @param string|Category $data
     */
    public function createBotName(string|Category $data): string
    {
        if ($data instanceof Category) {
            $data = $data->name;
        }
        
        // Remove any unwanted name endings
        foreach($this->strippableNames as $toStrip) {
            $data = str_replace($toStrip, "", $data);
        }

        // Pick a random appendableName
        $id = rand(0,count($this->appendableNames)-1);

        // Build the name
        $data = $data.$this->appendableNames[$id];

        return $data;
    }
}