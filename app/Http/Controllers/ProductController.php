<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataLayers\Product;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::getProducts();
        return response()->json([
            "products" => $products
        ], 200);
    }

    public function submit(Request $request)
    {
        Product::saveProduct($request);
        $products = Product::getProducts();
        return response()->json([
            "products" => $products
        ], 200);
    }

    public function update(Request $request)
    {
        Product::updateProduct($request);
        $products = Product::getProducts();
        return response()->json([
            "products" => $products
        ], 200);
    }
}
