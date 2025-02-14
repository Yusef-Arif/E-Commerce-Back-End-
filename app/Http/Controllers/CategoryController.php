<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [new Middleware('auth:sanctum',except:['index','show'])];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title'=>'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255'
        ]);

        $imagePath = "";
        if($request->hasFile("image")){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            $image->move(public_path('/storage/categoryImage'),$imageName);
            $imagePath = "/storage/categoryImage/" . $imageName;
        }

        $category = Category::create([
            'title'=> $fields['title'],
            'image' => $imagePath,
            'description' =>  $fields['description']]);
        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $fields = $request->validate([
            'title'=>'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255'
        ]);

        $imagePath = $category->image;
        if($request->hasFile("image")){
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            $image->move(public_path('/storage/categoryImage'),$imageName);
            $imagePath = "/storage/categoryImage/" . $imageName;
        }

        $category->update([
            'title'=> $fields['title'],
            'image' => $imagePath,
            'description' =>  $fields['description']]);

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return ['message'=>'category deleted'];
    }
}
