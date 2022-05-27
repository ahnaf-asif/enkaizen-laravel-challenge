<?php

use App\Events\ImageUploadNotification;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/broadcast', function(){
   broadcast(new ImageUploadNotification());
});

Route::controller(AuthController::class)->group(function(){
   Route::post('/login', 'login');
   Route::post('/register', 'register');
   Route::post('/logout', 'logout');
});
Route::middleware('auth:sanctum')->group(function(){
    Route::controller(ImageController::class)->group(function(){
        Route::get('/images', 'images');
        Route::post('/images/upload', 'upload');
    });
});

//Route::get('/job/exceptions/{id}', function($id){
//   return DB::table('failed_jobs')->select('exception')->where('id', $id)->get();
//});
