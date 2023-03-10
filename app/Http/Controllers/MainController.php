<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request)
    {
        $productsQuery = Product::query();

        if($request->filled('price_from')){
            $productsQuery->where('price', '>=', $request->price_from);
        }

        if($request->filled('price_to')){
            $productsQuery->where('price', '<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field ) {
            if ($request->has($field)){
                $productsQuery->where($field, 1);
            }
        }

        $products = $productsQuery->paginate(9)->withPath("?" . $request->getQueryString());
        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('category', compact('category'));
    }

    public function product($category,  $product)
    {
        return view('product', compact('product'));
    }


}
