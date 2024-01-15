<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ItemStorageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'home'])->name('home')->middleware('auth');
Route::get('/blank', function () { return view('blank'); });

// Resource
Route::group([
    'middleware' => ['auth']
    ], function () {
    Route::resource('/item', ItemController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/storage', StorageController::class);
});
Route::get('/item/{item_id}/delete', [ItemController::class, 'destroy']);
Route::get('/storage/{storage_id}/delete', [StorageController::class, 'destroy']);

// item storage
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'itemStorage',
    ], function () {
    Route::get('/{itemStorage_id}/delete', [ItemStorageController::class, 'delete']);
    Route::post('/update', [ItemStorageController::class, 'update']);
    Route::post('/transfer', [ItemStorageController::class, 'transfer']);
});
Route::get('/transaction', [ItemStorageController::class, 'index'])->middleware('auth');
Route::post('/transaction', [ItemStorageController::class, 'transaction'])->middleware('auth');

// import
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'import',
    ], function () {
    Route::post('/item', [ImportController::class, 'import_item']);
    Route::post('/category', [ImportController::class, 'import_category']);
    Route::post('/storage', [ImportController::class, 'import_storage']);
});

// export
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'export',
    ], function () {
    Route::get('/item', [ExportController::class, 'export_item']);
    Route::get('/transfer', [ExportController::class, 'export_transfer']);
});

// Users
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'store']);