<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        info($request);
        return Product::create($request->only([
            'title',
            'description',
            'image',
            'price',
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only([
            'title',
            'description',
            'image',
            'price',
        ]));

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
    public function frontend()
    {
        if ($products = \Cache::get('products_frontend')) {
            return $products;
        }
        $products = Product::all();
        \Cache::set('products_frontend', $products, 30 * 60);
        return $products;
    }
    public function backend()
    {
        $products = \Cache::remember('products_frontend', 30 * 60, function () {
            return Product::paginate();
        });
        return $products;
    }
}
