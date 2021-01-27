<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index() {
        return Category::all();
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
