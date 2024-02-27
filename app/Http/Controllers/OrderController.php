<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBotNameRequest;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    public function getOrders()
    {
        $orders = $this->repository->getOrders();

        return response()->json($orders);
    }

    public function getOrdersFor($customerId)
    {
        $orders = $this->repository->getOrdersFor($customerId);

        return response()->json($orders);
    }

    public function getOrder($id)
    {
        $order = $this->repository->find($id);

        if (is_null($order->bot_name)) {
            // Generate bot name here
            $this->repository->generateBotName($order);
            $order->refresh();
        }

        // These are all relationships on the model that need initialising
        // to pass back with the api data
        foreach ($order->items as $item) { // initialise items
            $item->product; // initialise products
        }
        // initialise calculate total weight
        $order->totalWeight = $this->repository->calculateTotalWeight($order); 

        return response()->json($order);
    }

    public function showOrder($orderId)
    {
        return view('order')->with([
            "order" => $this->repository->find($orderId)
        ]);
    }

    public function updateBotName(UpdateBotNameRequest $request)
    {
        $order = $this->repository->find($request->order_id);
        $order->bot_name = $request->bot_name;
        return $order->update();
    }
}
