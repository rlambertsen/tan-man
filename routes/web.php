<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoCaptionController;
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
    return view('welcome');
});


Route::post('/upload', [VideoCaptionController::class, 'action_list_caption']);
Route::post('/search', [VideoCaptionController::class, 'search']);


Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
