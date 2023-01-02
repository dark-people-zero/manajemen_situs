<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\configController;
use App\Http\Controllers\GitPullController;
use App\Http\Livewire\Home;
use App\Http\Livewire\User;
use App\Http\Livewire\Situs;
use App\Http\Livewire\Site;
use App\Http\Livewire\FormElement;
use App\Http\Livewire\FormFitur;


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

Route::middleware(['auth', 'user-role'])->group(function () {
    Route::get('/', Home::class);
    Route::get('/user', User::class);
    Route::get('/data-situs', Situs::class);
    Route::get('/gitpull', [configController::class, 'git']);
    Route::get('/site', Site::class);
    Route::get('/form-element', FormElement::class);
    Route::get('/form-fitur', FormFitur::class);
});

Route::get('/config/{id}', [configController::class, 'index']);
Route::get('/situs/{name}/{type}', [configController::class, 'situs']);

Route::get('/underconstruction', function () {
    return view('pages.underconstruction');
});

Route::get('/error404', function () {
    return view('pages.error404');
});

Route::get('/permision', function () {
    $active = auth()->user()->aksesMenu->where('status', true)->first();
    return view('pages.permision', [
        "data" => $active
    ]);
});

Route::get('/testing', [configController::class, 'testing']);
