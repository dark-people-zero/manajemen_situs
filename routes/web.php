<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\configController;
use App\Http\Livewire\Home;
use App\Http\Livewire\User;
use App\Http\Livewire\Situs;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware(['auth','user-role'])->group(function () {
    Route::get('/', Home::class);
    Route::get('/user', User::class);
    Route::get('/data-situs', Situs::class);
});

// Route::get('/config/{$id}', [configController::class, "index"]);
Route::get('/config/{id}', [configController::class, 'index']);

Route::get('/underconstruction', function () {
    return view('pages.underconstruction');
});

Route::get('zia_togel', function () {
    return view('situs.zia_togel.desktop.index');
});

Route::get('zia_togel/m', function () {
    return view('situs.zia_togel.mobile.index');
});

Route::get('/permision', function () {
    $active = auth()->user()->aksesMenu->where('status', true)->first();
    return view('pages.permision', [
        "data" => $active
    ]);
});
