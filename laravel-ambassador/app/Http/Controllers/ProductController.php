<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function backend(Request $request)
    {
        $page = $request->input('page', 1);
        $products = \Cache::remember(
            'products_backend',
            30 * 60,
            fn () => Product::all()
        );

        if ($s = $request->input('s')) {
            $products = $products->filter(
                fn (Product $product) => Str::contains($product->title, $s) || Str::contains($product->description, $s)
            );
        }
        $total = $products->count();

        $sort = $request->input('sort');
        if ($sort === 'asc') {
            $products = $products->sortBy('price');
        }
        if ($sort === 'desc') {
            $products = $products->sortByDesc('price');
        }

        return [
            'data' => $products->forPage($page, 9)->values(),
            'meta' => [
                'total' => $total,
                'page' => $page,
                'last_page' => ceil($total / 9),
            ]
        ];
    }
}
