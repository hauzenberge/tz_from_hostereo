<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LinksController;
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

Route::get('/', function () {
    return redirect('register');
});

Route::prefix('/rand')->group(function () {
    Route::get('/{link}', 'LinksController@index');
    Route::get('/{id}/render', 'LinksController@render');
    Route::get('/{id}/disable', 'LinksController@disable');
    Route::post('/{id}/lucky', 'LinksController@lucky');

    Route::post('/{id}/history', 'LinksController@history');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
