<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new CustomerRepository();
    }

    public function getCustomers()
    {
        $customers = $this->repository->getCustomers();

        return response()->json($customers);
    }

    public function showCustomerOrders($customerId)
    {
        return view('customer-orders')->with([
            "customer" => $this->repository->find($customerId)
        ]);
    }

    public function getCustomerOrders($customerId)
    {
        $orders = $this->repository->find($customerId)->orders;

        return response()->json($orders);
    }
}
