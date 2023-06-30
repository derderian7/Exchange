<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\percentage_of_category_controller;
use App\Http\Controllers\percentage_of_location_controller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\imageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Middleware\AdminMiddleware;

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
    Route::post('login_admin', 'login_admin');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('refresh', 'refresh');
});
////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////
//Route::post('forgot-password',[AuthController::class,'forgotPassword']);
//Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth']], function () {
Route::get('post_status/{id}',[PostController::class,'edit_post_status']);
Route::get('VisitedUserPosts/{id}',[PostController::class,'VisitedUserPosts']);
Route::get('Userposts_id/{id}',[UserController::class,'usersPost_id']);
Route::get('Userposts_login',[UserController::class,'usersPost_login']);


//Route::post('updateUserProfile', [UserController::class, 'updateUserProfile']);



Route::post('updateUserProfile',[UserController::class,'updateUserProfile']);

Route::post('updateProfileImage',[UserController::class,'updateProfileImage']);//work
Route::get('ShowUserProfile',[UserController::class,'ShowUserProfile']);
Route::delete('destroy/{id}',[UserController::class,'destroy']);
Route::delete('deleteImage/{id}',[UserController::class,'deleteImage']);
//Route::post('updateProfileImage/{id}',[UserController::class,'updateProfileImage']);
//Route::get('showProfile',[UserController::class,'showProfile']);
Route::get('getmyprofile',[UserController::class,'getmyprofile']);//work
Route::get('getuserprofile/{id}',[UserController::class,'getuserprofile']);





Route::post('report', [ReportController::class, 'store']);

Route::post('exchange', [ExchangeController::class,'exchange']);

Route::post('messages', [MessageController::class, 'store']);
Route::get('CountMsg', [MessageController::class, 'CountMsg']);

Route::post('feedback', [FeedbackController::class, 'store']);
Route::get('rating/{userId}', [FeedbackController::class, 'getRating']);
Route::get('getMyRating', [FeedbackController::class, 'getMyRating']);

//Route::post('posts/{postId}/exchange', [PostController::class,'exchange']);
Route::post('posts/{postId}/acceptExchange', [PostController::class,'acceptExchange']);
Route::post('posts/{postId}/complete-exchange', [PostController::class,'completeExchange']);
Route::get('MarkAsRead_all',[PostController::class,'MarkAsRead_all']);
Route::get('unreadNotifications_count', [PostController::class,'unreadNotifications_count']);
Route::get('unreadNotifications', [PostController::class,'unreadNotifications']);
Route::resource('posts',PostController::class);

Route::get('image', [imageController::class,'sendimage']);
});

Route::group(['middleware' => ['isAdmin']], function () {
  Route::get('show_report', [ReportController::class, 'index']);
  Route::get('report_count', [ReportController::class, 'getPosts']);
 
  Route::get('countPostsByMonth',[PostController::class,'countPostsByMonth']);
  Route::get('RecentTransactions',[PostController::class,'RecentTransactions']);
  Route::get('countPosts',[PostController::class,'countPosts']);
 
  Route::get('GetAdmin',[UserController::class,'GetAdmin']);
  Route::get('NewUsers',[UserController::class,'NewUsers']);
  Route::get('NewUsers2',[UserController::class,'NewUsers2']);
  Route::get('visitors',[UserController::class,'visitors']);

  Route::get('percentage_of_locations', [percentage_of_location_controller::class, 'percentage_of_locations']);
  Route::get('percentage_of_categories', [percentage_of_category_controller::class, 'percentage_of_categories']);
  
  });
  
//Route::get('addToWishlist/{post_id}', [WishlistController::class,'addToWishlist']);