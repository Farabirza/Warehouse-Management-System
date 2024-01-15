<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemInStorage;
use App\Models\Storage;
use App\Models\Category;
use App\Models\Record;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'page_title' => '<span class="flex-start"><i class="bx bxs-dashboard mr-2"></i>Dashboard</span>',
            'users' => User::orderBy('name')->get(),
            'items' => Item::orderBy('name')->get(),
            'storages' => Storage::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'records' => Record::orderByDesc('created_at')->get(),
            'itemIn' => Transaction::where('type', 'in')->sum('count'),
            'itemOut' => Transaction::where('type', 'out')->sum('count'),
        ]);
    }
}
