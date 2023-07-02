<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\imageController;
use App\Http\Controllers\AdminController;;

use App\Http\Controllers\WishlistController;
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

// Auth Controller

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('login_admin', 'login_admin');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['auth']], function () {

// Admin Controller 
  Route::get('showAllUsersProfile',[AdminController::class,'showAllUsersProfile']);
  Route::get('GetAdmin',[AdminController::class,'GetAdmin']);
  Route::get('NewUsers',[AdminController::class,'NewUsers']);
  Route::get('CountAllUsers',[AdminController::class,'CountAllUsers']);
  Route::get('getadminprofile',[AdminController::class,'getadminprofile']);
  

  // User Controller
  Route::post('updateUserProfile',[UserController::class,'updateUserProfile']);
  Route::delete('destroy/{id}',[UserController::class,'destroy']);
  Route::get('getmyprofile',[UserController::class,'getmyprofile']);
  Route::get('getuserprofile/{id}',[UserController::class,'getuserprofile']);


// Post Controller
Route::resource('posts',PostController::class);


// Image Controller
Route::delete('deleteImage/{id}',[UserController::class,'deleteImage']);
Route::post('updateProfileImage',[UserController::class,'updateProfileImage']);


// Report Controller
Route::post('report', [ReportController::class, 'store']);


//Message Controller
Route::post('messages', [MessageController::class, 'store']);

// Feedback Controller
Route::post('feedback', [FeedbackController::class, 'store']);
Route::get('rating/{userId}', [FeedbackController::class, 'getRating']);
Route::get('getMyRating', [FeedbackController::class, 'getMyRating']);

//Wishlist Controller
Route::post('addToWishlist/{post_id}', [WishlistController::class,'addToWishlist']);
Route::get('getWishlist', [WishlistController::class,'index']);

//Report Controller
Route::get('show_report', [ReportController::class, 'index']);
Route::get('report_count', [ReportController::class, 'CountReport']);
Route::get('store', [ReportController::class, 'store']);

//Location Controller
Route::get('percentage_of_locations', [LocationController::class, 'percentage_of_locations']);
Route::get('Count_of_locations', [LocationController::class, 'Count_of_locations']);


//Category Controller
Route::get('percentage_of_categories', [CategoryController::class, 'percentage_of_categories']);
Route::get('CountAllCategories', [CategoryController::class, 'CountAllCategories']);

//Message Controller
Route::get('CountMsg', [MessageController::class, 'CountMsg']);
Route::get('store', [MessageController::class, 'store']);








});






  

  
  
  


  


