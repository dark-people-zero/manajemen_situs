<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\configController;
use App\Http\Controllers\GitPullController;
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

Route::middleware(['auth', 'user-role'])->group(function () {
    Route::get('/', Home::class);
    Route::get('/user', User::class);
    Route::get('/data-situs', Situs::class);
    Route::get('/gitpull', [configController::class, 'git']);
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

Route::get('dingdong_togel', function () {
    return view('situs.dingdong_togel.desktop.index');
});

Route::get('fia_togel', function () {
    return view('situs.fia_togel.desktop.index');
});

Route::get('fia_togel/m', function () {
    return view('situs.fia_togel.mobile.index');
});

Route::get('yok_togel', function () {
    return view('situs.yok_togel.desktop.index');
});

Route::get('geng_togel', function () {
    return view('situs.geng_togel.desktop.index');
});

Route::get('maria_togel/m', function () {
    return view('situs.maria_togel.mobile.index');
});

Route::get('indra_togel/m', function () {
    return view('situs.indra_togel.mobile.index');
});

Route::get('yowes_togel/m', function () {
    return view('situs.yowes_togel.mobile.index');
});

Route::get('udin_togel/m', function () {
    return view('situs.udin_togel.mobile.index');
});

Route::get('togel_on/m', function () {
    return view('situs.togel_on.mobile.index');
});

Route::get('situs_toto/m', function () {
    return view('situs.situs_toto.mobile.index');
});

Route::get('pwvip4d/m', function () {
    return view('situs.pwvip4d.mobile.index');
});

Route::get('pro_togel/m', function () {
    return view('situs.pro_togel.mobile.index');
});

Route::get('patih_toto/m', function () {
    return view('situs.patih_toto.mobile.index');
});

Route::get('partai_togel/m', function () {
    return view('situs.partai_togel.mobile.index');
});

Route::get('oppa_toto/m', function () {
    return view('situs.oppa_toto.mobile.index');
});

Route::get('nanas_toto/m', function () {
    return view('situs.nanas_toto.mobile.index');
});

Route::get('/permision', function () {
    $active = auth()->user()->aksesMenu->where('status', true)->first();
    return view('pages.permision', [
        "data" => $active
    ]);
});
