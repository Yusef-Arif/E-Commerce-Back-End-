<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [new Middleware('auth:sanctum',except:['index','show'])];
    }

    public function index(){
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $imagePath = "";
        if($request->hasFile("image")){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            $image->move(public_path('/storage/productImage'),$imageName);
            $imagePath = "/storage/productImage/" . $imageName;
        }

        $product = $request->user()->products()->create([
            'name' => $fields['name'],
            'price' => $fields['price'],
            'description' => $fields['description'],
            'image' => $imagePath,
            'category_id' => $fields['category_id']
        ]);
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $imagePath =  $product->image;
        if($request->hasFile('image')){
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('/storage/productImage'),$imageName);
            $imagePath = "/storage/productImage/" . $imageName;
        }

        $product->update([
            'name' => $fields['name'],
            'price' => $fields['price'],
            'description' => $fields['description'],
            'image' => $imagePath,
            'category_id' => $fields['category_id']
        ]);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return ['masseg'=>"product is deleted"];
    }
}
