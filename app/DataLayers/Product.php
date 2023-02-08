<?php

namespace App\DataLayers;

use Carbon\Carbon;

class Product
{
    public static function getProducts()
    {
        $path = storage_path() . "/json/products.json"; 
        $json = json_decode(file_get_contents($path), true); 
        return $json;
    }

    public static function saveProduct($request)
    {
        $path = storage_path() . "/json/products.json"; 
        $products = json_decode(file_get_contents($path), true); 

        $product = [
            "name" => $request->name,
            "qty" => $request->qty,
            "price" => $request->price,
            "total_value" => $request->qty * $request->price,
            "submitted_at" => Carbon::now()
        ];

        $products[] = $product;

        file_put_contents($path, json_encode($products));

    }

    public static function updateProduct($request)
    {
        $path = storage_path() . "/json/products.json"; 
        $products = json_decode(file_get_contents($path), true); 
        $products[$request->index] = [
            "name" => $request->name,
            "qty" => $request->qty,
            "price" => $request->price,
            "total_value" => $request->qty * $request->price,
            "submitted_at" => $products[$request->index]["submitted_at"],
        ];

        file_put_contents($path, json_encode($products));

    }
}

