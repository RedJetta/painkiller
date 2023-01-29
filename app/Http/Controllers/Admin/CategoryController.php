<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::get();
        return view('auth.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('auth.categories.form');
    }

    public function store(CategoryRequest $request)
    {
        $params = $request->all();
        unset($params['image']);
        if($request->has('image')){
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }

        Category::create($params);
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        return view('auth.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('auth.categories.form', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($category->image);
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }

        $category->update($params);
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
