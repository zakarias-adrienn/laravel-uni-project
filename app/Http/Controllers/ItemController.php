<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function showAll() {
        $items = Item::all();
        $categories = Category::all();
        return view('items', compact('items', 'categories'));
    }

    public function showDeleted() {
        $items = Item::onlyTrashed()->get();
        return view('deleted-items', compact('items'));
    }

    public function restore($id){
        $item = Item::onlyTrashed()->find($id);
        $item->restore();
        return redirect()->route('deleted.item')->with('item_restored', true);
    }

    public function new() {
        $categories = Category::all();
        return view('new-item', compact('categories'));
    }

    public function add(AddItemRequest $request) {
        $data = $request->all();

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $hashName = $file->hashName();
            Storage::disk('public')->put('images/item_images/'.$hashName, file_get_contents($file)); // fájl elmentése
            $data['image_url'] = $hashName; // modell hogy keresse
        }

        $item = Item::create($data);
        $item->categories()->attach($data['categories']);
        $item->save();

        return redirect()->route('items')->with('item_added', true);
    }

    public function edit($id){
        $item = Item::withTrashed()->find($id);
        if($item->deleted_at!==null){
            return redirect()->route('deleted.item')->with('cannot_edit', true);
        }
        if($item === null){
            return redirect()->route('items');
        }
        $categories = Category::all();
        if($item->categories!==null){
            $category_ids = $item->categories->pluck('id')->toArray();
        } else {
            $category_ids = [];
        }
        return view('edit-item', compact('item', 'categories', 'category_ids'));
    }

    public function modify(AddItemRequest $request, $id){
        $data = $request->all();
        $item = Item::find($id);
        if($item === null){
            return redirect()->route('items');
        }

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $hashName = $file->hashName();
            Storage::disk('public')->put('images/item_images/'.$hashName, file_get_contents($file)); // fájl elmentése
            $data['image_url'] = $hashName; // modell hogy keresse
        }

        $item->update($data);
        $item->categories()->sync($data['categories']);

        return redirect()->route('items')->with('item_updated', true);
    }

    public function delete($id){
        $item = Item::find($id);
        if($item === null){
            return redirect()->route('items');
        }
        $item->delete();

        return redirect()->route('items')->with('item_deleted', true);
    }

}
