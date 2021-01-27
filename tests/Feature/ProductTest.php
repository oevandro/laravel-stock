<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    private $route_path = '/products/';

    public function test_can_create_product()
    {
        $product = factory(Product::class)->make()->toArray();

        Product::create($product);

        $this->post($this->route_path, $product)
            ->assertStatus(201)
            ->assertJson($product);
    }


    public function test_can_update_product()
    {

        $product = factory(Product::class)->create()->toArray();
        $product_update = factory(Product::class)->make()->toArray();

        $this->put($this->route_path.$product['id'], $product_update)
            ->assertStatus(200)
            ->assertJson($product_update);
    }


    public function test_can_show_product() {

        $product = factory(Product::class)->create()->toArray();

        $this->get($this->route_path.$product['id'])
            ->assertStatus(200);
    }


    public function test_can_delete_product() {

        $product = factory(Product::class)->create()->toArray();

        $this->delete($this->route_path.$product['id'])
            ->assertStatus(204);
    }


    public function test_can_list_products() {
        $fields = ['id', 'name', 'description', 'price'];
        $products = factory(Product::class, 3)->create()->map(function ($product, $fields) {
            return $product->only($fields);
        });

        $this->get($this->route_path)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => $fields,
            ]);
    }


 }
