<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
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

    public function testCanCreateCategory(): void
    {
        $name = "testing create category";

        $repo = new CategoryRepository();
        $saved = $repo->create($name); // Can we create by name
        $saved2 = $repo->create(["name" => $name]); // Can we create by array data

        $found = Category::find(1);
        $found2 = Category::find(2);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($found2->id, $saved2->id);
    }

    public function testCanFindCategory(): void
    {
        $name = "testing find";
        $saved = Category::create(['name' => $name]);

        $repo = new CategoryRepository();
        $found = $repo->find($saved->id);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($name, $found->name); // Sanity check
    }

    public function testCanFindCategoryByFieldname(): void
    {
        $name = "testing findBy";
        $saved = Category::create(['name' => $name]);

        $repo = new CategoryRepository();
        $found = $repo->findBy("name", $name);

        $this->assertEquals($saved->id, $found->id);
        $this->assertEquals($name, $found->name); // Sanity check
    }

    public function testCanFindOrCreateCategory(): void
    {
        $name = "testing category";

        $repo = new CategoryRepository();
        $saved = $repo->findOrCreate($name); // Can we create by name
        $saved2 = $repo->findOrCreate(["name" => $name]); // Can we create by array data

        $found = Category::find(1);

        $this->assertEquals($found->id, $saved->id);
        $this->assertEquals($saved->id, $saved2->id);
    }
}
