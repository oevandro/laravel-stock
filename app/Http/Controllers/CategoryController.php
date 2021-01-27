<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{

    public function index() {

        $cacheKey = Cache::get('categories');

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $categoriesObject = Category::all();

        $categories = CategoryResource::collection($categoriesObject);

        Cache::put($cacheKey, $categories, now()->addMinutes(5));

        return $categories;

    }


    public function show(Category $category) {
        return $category;
    }


    public function store(Request $request) {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }


    public function update(Request $request, Category $category) {

        $validatedData = self::validateFields($request->all());

        $category->update($validatedData);
        return response()->json($category);
    }


    public function destroy(Category $category) {
        $category->delete();
        return response()->json(null, 204);
    }

    private static function validateFields($input)
    {
        $rules = [
            'name' => 'required|min:3|max:255',
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
