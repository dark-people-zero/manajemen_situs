<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/underconstruction', function () {
    return view('pages.underconstruction');
});

Route::get('/data-situs', function (Request $request) {
    $q = $request->q;
    $data = json_decode(File::get("situs/data-situs.json"), false);

    if ($q) return collect($data)->filter( function($e) use ($q) {
        return false !== stristr($e->name, $q);
    })->values();

    return $data;
});


Route::get('/zia_togel_mobile', function () {
    return view('situs.zia_togel.mobile.index');
});
Route::get('/zia_togel_web', function () {
    return view('situs.zia_togel.desktop.index');
});

