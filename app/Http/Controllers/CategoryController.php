<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Category::where('name', $request->name)->first()) {
            return back()->with('error', "Kategori ini sudah pernah didaftarkan");
        }
        $category = Category::create(['name' => $request->name]);
        return redirect('/item')->with('success', "Kategori berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if(Category::where('name', $request->name)->first()) {
            return back()->with('error', "Kategori ini sudah pernah didaftarkan");
        }
        $update_category = $category->update(['name' => $request->name]);
        return redirect('/item')->with('success', "Kategori berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if(Item::where('category_id', $category->id)->first()) {
            $general = Category::where('name', 'General')->first();
            if(!$general) {
                $general = Category::create(['name' => 'General']);
            }
            $update_item = Item::where('category_id', $category->id)->update([
                'category_id' => $general->id,
            ]);
        }
        $category->delete();
        return redirect('/item')->with('success', $category->name." berhasil dihapus");
    }
}
