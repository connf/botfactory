<?php

namespace App\Http\Controllers;

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

        return response()->json($order);
    }

    public function showOrder($orderId)
    {
        return view('order')->with([
            "order" => $this->repository->find($orderId)
        ]);
    }
}
