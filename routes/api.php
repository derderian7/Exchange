<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\percentage_of_category_controller;
use App\Http\Controllers\percentage_of_location_controller;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::resource('posts',PostController::class);
Route::get('post_status/{id}',[PostController::class,'edit_post_status']);
Route::get('VisitedUserPosts/{id}',[PostController::class,'VisitedUserPosts']);
Route::get('countPostsByMonth',[PostController::class,'countPostsByMonth']);
Route::get('RecentTransactions',[PostController::class,'RecentTransactions']);
Route::get('countPosts',[PostController::class,'countPosts']);



Route::get('Userposts',[UserController::class,'usersPost']);
Route::put('updateUserProfile/{id}',[UserController::class,'updateUserProfile']);
Route::get('NewUsers',[UserController::class,'NewUsers']);
Route::get('NewUsers2',[UserController::class,'NewUsers2']);
Route::get('visitors',[UserController::class,'visitors']);
Route::get('ShowUserProfile',[UserController::class,'ShowUserProfile']);
Route::delete('destroy/{id}',[UserController::class,'destroy']);



Route::post('percentage_of_location/{Location}', [percentage_of_location_controller::class, 'percentage_of_location']);
Route::post('percentage_of_categories/{categories_id}', [percentage_of_category_controller::class, 'percentage_of_categories']);


Route::post('report', [ReportController::class, 'store']);
Route::get('show_report', [ReportController::class, 'index']);
Route::get('report_count/{id}', [ReportController::class, 'report_count']);

Route::post('messages', [MessageController::class, 'store']);