<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    public function index() {

        $cacheKey = Cache::get('products');

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $productObject = (new Product)->select(
            'products.*',
            'categories.name as category_name',
            'categories.id as category_id'
            )
            ->join('categories', 'categories.id', 'products.category_id')
            ->get();

        $products = ProductResource::collection($productObject);

        Cache::put($cacheKey, $products, now()->addMinutes(30));
        return $products;
    }


    public function show(Product $product) {
        return $product;
    }


    public function store(Request $request) {

        $validatedData = self::validateFields($request->all());

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }


    public function update(Request $request, Product $product) {

        $validatedData = self::validateFields($request->all());

        $product->update($validatedData);
        return response()->json($product);
    }


    public function destroy(Product $product) {
        $product->delete();
        return response()->json(null, 204);
    }

    private static function validateFields($input)
    {
        $rules = [
            'category_id' => 'required|integer',
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'price' => 'required|integer',
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails())
        {
            return response()->make((object) $validation->messages(), 400);
        }
        $validatedData = $validation->validated();

        return $validatedData;
    }


}
