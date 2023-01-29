<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(9);
        return view('auth.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::get();
        return view('auth.products.form', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')){
            $params['image'] = $request->file('image')->store('products');
        }

        Product::create($params);
        return redirect()->route('products.index');
    }


    public function show(Product $product)
    {
        return view('auth.products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = Category::get();
        return view('auth.products.form', compact('product', 'categories'));
    }


    public function update(ProductRequest $request, Product $product)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($product->image);
            $params['image'] = $request->file('image')->store('products');
        }

        foreach (['new', 'hit', 'recommend'] as $fieldName) {
            if (!isset($params[$fieldName])) {
                $params[$fieldName] = 0;
            }
        }
        $product->update($params);
        return redirect()->route('products.index');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
