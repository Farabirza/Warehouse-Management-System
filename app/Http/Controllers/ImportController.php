<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Imports\ItemImport;
use App\Imports\CategoryImport;
use App\Imports\StorageImport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function import_item(Request $request)
    {
        $import = Excel::import(new ItemImport,request()->file('file'));
        if(!$import) {
            return back()->with('error', "Data stok barang gagal diimport");
        }
        return back()->with('success', "Data stok barang berhasil diimport");
    }
    public function import_category(Request $request)
    {
        $import = Excel::import(new CategoryImport,request()->file('file'));
        if(!$import) {
            return back()->with('error', "Data kategori barang gagal diimport");
        }
        return back()->with('success', "Data kategori barang berhasil diimport");
    }
    public function import_storage(Request $request)
    {
        $import = Excel::import(new StorageImport,request()->file('file'));
        if(!$import) {
            return back()->with('error', "Data gudang gagal diimport");
        }
        return back()->with('success', "Data gudang barang berhasil diimport");
    }
}
