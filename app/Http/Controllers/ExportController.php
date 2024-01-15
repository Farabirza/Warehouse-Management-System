<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemInStorage;
use App\Models\Record;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export_item()
    {
        $items = Item::orderBy('name')->get();
        foreach($items as $item) {
            $item->amount = ItemInStorage::where('item_id', $item->id)->sum('count');
        }
        return view('export.export_items', [
            'title' => 'Dashboard | Export Item',
            'items' => $items,
        ]);
    }
    public function export_transfer()
    {
        return view('export.export_transfer', [
            'title' => 'Dashboard | Export Transfer Records',
            'records' => Record::orderByDesc('created_at')->get(),
        ]);
    }
}
