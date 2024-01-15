<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemInStorage;
use App\Models\Storage;
use App\Models\Record;

use App\Http\Requests\StoreStorageRequest;
use App\Http\Requests\UpdateStorageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storages = Storage::orderBy('name')->get();
        foreach($storages as $storage) {
            $storage->amount = ItemInStorage::where('storage_id', $storage->id)->sum('count');
        }
        return view('storage.index', [
            'title' => 'Gudang',
            'page_title' => '<span class="flex-start"><i class="fas fa-warehouse mr-3"></i>Gudang</span>',
            'modal_storage' => true,
            'items' => Item::orderBy('name')->get(),
            'itemInStorages' => ItemInStorage::orderByDesc('updated_at')->get(),
            'storages' => $storages,
            'records' => Record::orderByDesc('created_at')->get(),
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
    public function store(StoreStorageRequest $request)
    {
        $storage = Storage::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect('/storage')->with('success', "Gudang berhasil didaftarkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Storage $storage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storage $storage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStorageRequest $request, Storage $storage)
    {
        $storage->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect('/storage')->with('success', "Data gudang berhasil diperbaharui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($storage_id)
    {
        ItemInStorage::where('storage_id', $storage_id)->delete();
        $storage = Storage::find($storage_id)->delete();
        return redirect('/storage')->with('success', "Data gudang berhasil dihapus");
    }
}
