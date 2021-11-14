<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function showAll() {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }

    public function new() {
        return view('new-category');
    }

    public function add(AddCategoryRequest $request) {
        $data = $request->all();
        $category = Category::create($data);
        $category->save();

        return redirect()->route('categories')->with('category_added', true);
    }

    public function edit($id){
        $category = Category::find($id);
        if($category === null){
            return redirect()->route('categories');
        }
        return view('edit-category', compact('category'));
    }

    public function modify(AddCategoryRequest $request, $id){
        $data = $request->all();
        $category = Category::find($id);
        if($category === null){
            return redirect()->route('categories');
        }
        $category->name = $data['name'];
        $category->update($data);

        return redirect()->route('categories')->with('category_updated', true);
    }

    public function delete($id){
        $category = Category::find($id);
        if($category === null){
            return redirect()->route('categories');
        }
        $category->delete();
        return  redirect()->route('categories')->with('category_deleted', true);
    }
}
