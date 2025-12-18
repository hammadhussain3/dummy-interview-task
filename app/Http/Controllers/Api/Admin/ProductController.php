<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{   
    public function store(Request $request)
    {
        $product = Product::create($request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'quantity'=>'required|integer',
            'status'=>'boolean'
        ]));

        return response()->json($product, 201);
    }


    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message'=>'Deleted']);
    }
}

