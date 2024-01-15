<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemInStorage;
use App\Models\Storage;
use App\Models\Record;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemStorageController extends Controller
{
    public function index()
    {
        return view('item.transaction', [
            'title' => 'Transaksi',
            'page_title' => '<span class="flex-start"><i class="fas fa-exchange-alt mr-3"></i>Transaksi Barang</span>',
            'items' => Item::orderBy('name')->get(),
            'storages' => Storage::orderBy('name')->get(),
            'transactions' => Transaction::orderByDesc('updated_at')->get(),
            'itemIn' => Transaction::where('type', 'in')->sum('count'),
            'itemOut' => Transaction::where('type', 'out')->sum('count'),
        ]);
    }
    public function transaction(Request $request)
    {
        $get_count = $request->count;
        $count = ($request->type == 'in') ? $request->count : $request->count *= -1;
        $itemStorage = ItemInStorage::where('item_id', $request->item_id)->where('storage_id', $request->storage_id)->first();
        if(!$itemStorage) {
            if($count < 0) {
                return back()->with('error', "Jumlah barang di gudang tidak mencukupi");
            }
            ItemInStorage::create([
                'item_id' => $request->item_id,
                'storage_id' => $request->storage_id,
                'count' => $count,
            ]);
        } else {
            $total = $itemStorage->count += $count;
            if($total < 0) {
                return back()->with('error', "Jumlah barang di gudang tidak mencukupi");
            }
            $itemStorage->update([
                'item_id' => $request->item_id,
                'storage_id' => $request->storage_id,
                'count' => $total,
            ]);
        }
        Transaction::create([
            'count' => $get_count,
            'type' => $request->type,
            'description' => $request->description,
            'item_id' => $request->item_id,
            'storage_id' => $request->storage_id,
        ]);
        return redirect('/transaction')->with('success', "Transaksi berhasil");
    }
    public function transfer(Request $request)
    {
        $itemStorageFrom = ItemInStorage::find($request->itemStorage_id);
        $total = $itemStorageFrom->count -= $request->count;
        if($itemStorageFrom->storage_id == $request->storage_id) {
            return back()->with('error', "Tidak dapat mengirimkan barang ke gudang yang sama");
        }
        if($total < 0) {
            return back()->with('error', "Jumlah barang dari gudang asal tidak mencukupi");
        }
        $itemStorageTo = ItemInStorage::where('item_id', $itemStorageFrom->item_id)->where('storage_id', $request->storage_id)->first();
        if(!$itemStorageTo) {
            $itemStorageTo = ItemInStorage::create([
                'item_id' => $itemStorageFrom->item_id,
                'storage_id' =>  $request->storage_id,
                'count' => 0,
            ]);
        }
        $itemStorageFrom->update(['count' => $total]);
        $itemStorageTo->update(['count' => $itemStorageTo->count += $request->count]);
        Record::create([
            'item_id' => $itemStorageFrom->item_id,
            'storage_from' => $itemStorageFrom->storage_id,
            'storage_to' => $request->storage_id,
            'count' => $request->count,
            'description' => $request->description,
        ]);
        return redirect('/storage')->with('success', "Transfer barang berhasil");
    }
    public function update(Request $request)
    {
        $count = ($request->count) ? $request->count : 0;
        $itemStorage = ItemInStorage::where('item_id', $request->item_id)->where('storage_id', $request->storage_id)->first();
        if(!$itemStorage) {
            if($count < 0) {
                return back()->with('error', "Jumlah barang tidak bisa negatif");
            }
            ItemInStorage::create([
                'item_id' => $request->item_id,
                'storage_id' => $request->storage_id,
                'count' => $count,
            ]);
        } else {
            $total = $itemStorage->count += $count;
            if($total < 0) {
                return back()->with('error', "Jumlah barang tidak bisa negatif");
            }
            $itemStorage->update([
                'item_id' => $request->item_id,
                'storage_id' => $request->storage_id,
                'count' => $total,
            ]);
        }
        return redirect('/storage')->with('success', "Barang dalam gudang berhasil diperbaharui");
    }
    public function delete($itemStorage_id)
    {
        $itemStorage = ItemInStorage::find($itemStorage_id)->delete();
        return redirect('/storage')->with('success', "Data barang dalam gudang berhasil dihapus");
    }
}
