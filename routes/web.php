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
$router->group(['prefix' => 'api'], function ($router) {
	$router->post('/upload_video_file', [ImageController::class, 'create_images_from_video_file']);

    $router->post('/view-image/{id}', [ImageController::class, 'get_single_image']);

    $router->get('/random', [ImageController::class, 'get_random_image']);

    $router->post('/upload_caption_file', [VideoCaptionController::class, 'action_list_caption']);

    $router->post('/search', [SearchController::class, 'search']);

    $router->get('/get_near_images/{id}', [ImageController::class, 'get_near_images']);
});

$router->get('/{any}', [SinglePageController::class, 'index'])->where('any', '.*');



