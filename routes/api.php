<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskGroupController;

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
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('users',[AuthController::class,'index']);


// task group controller route links

Route::get('/tasks_group' , [ TaskGroupController::class , 'index']);
Route::post('/tasks_group/create' , [ TaskGroupController::class , 'store']);
Route::post('/tasks_group/edit/{id}' , [ TaskGroupController::class , 'edit']);
Route::delete('/tasks_group/delete/{id}' , [ TaskGroupController::class , 'delete']);



// task controller route links

Route::get('/tasks' , [ TaskController::class , 'index']);
Route::post('/tasks/create' , [ TaskController::class , 'store']);
Route::post('/tasks/edit/{id}' , [ TaskController::class , 'edit']);
Route::delete('/tasks/delete/{id}' , [ TaskController::class , 'delete']);











Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::post('/logout',[AuthController::class,'logout']);

});
