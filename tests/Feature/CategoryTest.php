<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;


    private $route_path = '/categories/';


    public function test_can_create_category()
    {
        $category = factory(Category::class)->make()->toArray();

        $this->post($this->route_path, $category)
            ->assertStatus(201)
            ->assertJson($category);
    }


    public function test_can_update_category()
    {
        $category = factory(Category::class)->create()->toArray();
        $category_update = factory(Category::class)->make()->toArray();

        $this->put($this->route_path.$category['id'], $category_update)
            ->assertStatus(200)
            ->assertJson($category_update);
    }


    public function test_can_show_category()
    {

        $category = factory(Category::class)->create()->toArray();

        $this->get($this->route_path.$category['id'])
            ->assertStatus(200);
    }


    public function test_can_delete_category()
    {

        $category = factory(Category::class)->create()->toArray();

        $this->delete($this->route_path.$category['id'])
            ->assertStatus(204);
    }


    public function test_can_list_categorys()
    {
        $categories = factory(Category::class, 3)->create()->map(function ($category) {
            return $category->only(['id', 'name']);
        });

        $this->get($this->route_path)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name'],
            ]);
    }
}
