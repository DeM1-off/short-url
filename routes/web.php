<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShortLinkController;


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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [ShortLinkController::class, 'index']);
Route::post('/', [ShortLinkController::class, 'store']);
   
Route::get('{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');
