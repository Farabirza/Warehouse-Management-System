<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemInStorage;
use App\Models\Storage;
use App\Models\Category;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderBy('name')->get();
        foreach($items as $item) {
            $item->amount = ItemInStorage::where('item_id', $item->id)->sum('count');
        }
        return view('item.index', [
            'title' => 'Stok',
            'page_title' => '<span class="flex-start"><i class="bx bx-package mr-2"></i>Stok Barang</span>',
            'modal_item' => true,
            'items' => $items,
            'storages' => Storage::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
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
    public function store(StoreItemRequest $request)
    {
        $item = Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
        return redirect('/item')->with('success', "Jenis barang baru berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
        return redirect('/item')->with('success', "Data barang berhasil diperbaharui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($item_id)
    {
        $item = Item::find($item_id);
        if(count($item->inStorage) > 0) {
            ItemInStorage::where('item_id', $item->id)->delete();
        }
        $item->delete();
        return redirect('/item')->with('success', "Barang berhasil dihapus");
    }
}
