<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => factory(Category::class),
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'price' => rand(100,1000)
    ];
});
