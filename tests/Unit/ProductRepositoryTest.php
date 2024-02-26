<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();

        // We need a category for each product to insert
        Category::create(["name" => "Test Category"]);
    }
    
    public function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

    public function testCanCreateProduct(): void
    {
        $name = "Test Product";
        $sku = "TST-001";
        $weight = 5;

        $repo = new ProductRepository();
        $saved = $repo->create(
            [
                "product_name" => $name,
                "category_id" => 1,
                "sku" => $sku,
                "weight" => $weight,
            ]
        );

        $found = Product::find(1);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($found->product_name, $name);
        $this->assertEquals($found->sku, $sku);
        $this->assertEquals($found->weight, $weight);
    }

    public function testCanFindProduct(): void
    {
        $name = "Test Find Product";
        $sku = "FND-001";
        $weight = 3;

        $saved = Product::create(
            [
                "product_name" => $name,
                "category_id" => 1,
                "sku" => $sku,
                "weight" => $weight,
            ]
        );

        $repo = new ProductRepository();
        $found = $repo->find($saved->id);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($found->product_name, $name);
        $this->assertEquals($found->sku, $sku);
        $this->assertEquals($found->weight, $weight);
    }

    public function testCanFindProductByFieldname(): void
    {
        $name = "Test FindBy Product";
        $sku = "FBY-001";
        $weight = 1.05;

        $saved = Product::create(
            [
                "product_name" => $name,
                "category_id" => 1,
                "sku" => $sku,
                "weight" => $weight,
            ]
        );

        $repo = new ProductRepository();
        $found = $repo->findBy("product_name", $name);
        $found2 = $repo->findBy("sku", $sku);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($saved->id, $found2->id);
        $this->assertEquals($name, $found->product_name); // Sanity check
        $this->assertEquals($sku, $found->sku); // Sanity check
        $this->assertEquals($weight, $found->weight); // Sanity check
        $this->assertEquals($name, $found2->product_name); // Sanity check
        $this->assertEquals($sku, $found2->sku); // Sanity check
        $this->assertEquals($weight, $found2->weight); // Sanity check
    }

    public function testCanFindOrCreateProduct(): void
    {
        $name = "Test FindOrCreate Product";
        $sku = "FOC-001";
        $weight = 2.5;

        $repo = new ProductRepository();
        $saved = $repo->findOrCreate(
            [
                "product_name" => $name,
                "category_id" => 1,
                "sku" => $sku,
                "weight" => $weight,
            ]
        ); // Can we create by name
        $saved2 = $repo->findOrCreate(
            [
                "product_name" => $name,
                "category_id" => 1,
                "sku" => $sku,
                "weight" => $weight,
            ]
        ); // Can we find if we create the same record

        $found = Product::find(1);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($saved->id, $saved2->id);
    }
}
