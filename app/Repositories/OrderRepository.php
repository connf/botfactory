<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository
{
    /**
     * Create an Order record using a customer ID or data array
     * 
     * @param int|array
     */
    public function create(int|array $data)
    {
        if (is_int($data)) {
            // If the user is creating by string then build the required array
            $data = [
                "customer_id" => $data
            ];
        }

        return Order::create($data);
    }

    public function find($id)
    {
        return Order::find($id);
        // We could override the find method globally here
        // for example to a findOrFail, should there be a business requirement for this
    }

    public function findBy($field, $search)
    {
        return Order::where($field, $search)->first();
    }

    /**
     * Find an existing order by ID or data array
     * Or create the Order if it doesn't exist
     * 
     * @param int $orderId
     * @param int $customerId
     */
    public function findOrCreate(int $orderId, int $customerId)
    {
        return Order::firstOrCreate(['id' => $orderId, 'customer_id' => $customerId]);
    }

    /**
     * Find an existing item record by order_id, sku and quantity
     * or create the OrderItem if it doesn't exist yet
     * 
     * @param array
     */
    public function addOrderItem(array $data)
    {
        return OrderItem::firstOrCreate($data);
    }
}