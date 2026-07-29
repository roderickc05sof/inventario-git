<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
     public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::orderBy('id', 'desc')->get() 
        ]);
    }
     public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', 
        ]);

        Category::create($validated);
        return redirect()->back();
    }
        public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->back();
    }

}


