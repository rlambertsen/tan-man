<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoCaptionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SinglePageController;
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


Route::get('/{any}', [SinglePageController::class, 'index'])->where('any', '.*');

Route::post('/upload_video_file', [ImageController::class, 'create_images_from_video_file']);
Route::post('/view-image/{id}', [ImageController::class, 'get_single_image']);
Route::post('/upload_caption_file', [VideoCaptionController::class, 'action_list_caption']);
Route::post('/search', [SearchController::class, 'search']);
