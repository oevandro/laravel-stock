<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        foreach ( $categories as $category) {
            factory(Product::class, 2)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
