<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }
    
    public function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

    public function testCanCreateCustomer(): void
    {
        $name = "testing create Customer";

        $repo = new CustomerRepository();
        $saved = $repo->create($name); // Can we create by name
        $saved2 = $repo->create(["name" => $name]); // Can we create by array data

        $found = Customer::find(1);
        $found2 = Customer::find(2);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($found2->id, $saved2->id);
    }

    public function testCanFindCustomer(): void
    {
        $name = "testing find";
        $saved = Customer::create(['name' => $name]);

        $repo = new CustomerRepository();
        $found = $repo->find($saved->id);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($name, $found->name); // Sanity check
    }

    public function testCanFindCustomerByFieldname(): void
    {
        $name = "testing findBy";
        $email = "findby@test.com";
        $saved = Customer::create(['name' => $name, 'email' => $email]);

        $repo = new CustomerRepository();
        $found = $repo->findBy("name", $name);
        $found2 = $repo->findBy("email", $email);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($saved->id, $found2->id);
        $this->assertEquals($name, $found->name); // Sanity check
        $this->assertEquals($email, $found->email); // Sanity check
    }

    public function testCanFindOrCreateCustomer(): void
    {
        $name = "testing Customer";

        $repo = new CustomerRepository();
        $saved = $repo->findOrCreate($name); // Can we create by name
        $saved2 = $repo->findOrCreate(["name" => $name]); // Can we create by array data

        $found = Customer::find(1);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($saved->id, $saved2->id);
    }
}
