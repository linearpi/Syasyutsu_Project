<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    //
public function index(){

	return view('index');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $imageName = time().'.'.$request->image->extension();
    $request->image->move(public_path('images'), $imageName);
    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->image = 'images/'.$imageName;
    $product->save();
    //return redirect()->route('index')->with('success', 'Product created successfully.');
    return redirect("/index");
}

}
