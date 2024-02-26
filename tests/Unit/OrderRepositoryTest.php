<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repo;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();

        $this->repo = new OrderRepository();

        // All orders need a customer
        Customer::create(["name" => "Test Customer"]);
    }
    
    public function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

    public function testCanCreateOrder(): void
    {
        $saved = $this->repo->create(1); // Can we create using the customer created in setUp
        $saved2 = $this->repo->create(["customer_id" => 1]); // Can we create by array data

        $found = Order::find(1);
        $found2 = Order::find(2);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($found2->id, $saved2->id);
    }

    public function testCanFindOrder(): void
    {
        $saved = $this->repo->create(1);
        $found = $this->repo->find($saved->id);

        $this->assertEquals($saved->id, $found->id);
    }

    public function testCanFindOrderByFieldname(): void
    {
        $saved = $this->repo->create(1);
        $found = $this->repo->findBy("id", 1);
        $found2 = $this->repo->findBy("customer_id", 1);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($saved->id, $found2->id);
    }

    public function testCanFindOrCreateOrder(): void
    {
        $saved = $this->repo->findOrCreate(1, 1);
        $saved2 = $this->repo->findOrCreate(1, 1); // Save same record twice

        $this->assertEquals($saved->id, $saved2->id);
    }
}
