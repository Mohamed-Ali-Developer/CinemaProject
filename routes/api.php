<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\MoviesController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\AIModelController;


Route::post('/Login',[LoginController::class,'update'])->name("UserLoggedin");
Route::post('/Regester',[LoginController::class,'store'])->name("Regestrered");


Route::middleware(['auth:sanctum', 'isAdmin:user'])->group(function () {

    Route::get('/Movies',[MoviesController::class,'index'])->name("UserMovies");
    Route::get('/Movies/{movie}',[MoviesController::class,'show'])->name("UserViewMovie");

    Route::post('/MyList/{movie}', [MoviesController::class, 'store'])->name('UserAddToMyList');
    Route::get('/MyList', [MoviesController::class, 'myList'])->name('UserMyList');
    Route::delete('/MyList/{movie}', [MoviesController::class, 'destroy'])->name('UserRemoveFromMyList');

    Route::post('/bookings/Confirm', [BookingController::class, 'confirm'])->name('UserConfirmBookings');
    Route::get('/bookings/{movie}', [BookingController::class, 'Booking'])->name('UserChooseShowtime');
    Route::get('/bookings/{hall}/{showtime}', [BookingController::class, 'show'])->name('UserStartBookings');
    Route::post('/bookings', [BookingController::class, 'store'])->name('UserMakeBookings');
    Route::get('/bookings', [BookingController::class, 'index'])->name('UserBookings');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('UserCancelBooking');
     
    Route::post('/AI/Recommendations',[AIModelController::class,'show'])->name("AIRecommendation");
    Route::post('/AI/chat/{movie}',[AIModelController::class,'chat'])->name("AIChat");

    Route::delete('/Logout',[LoginController::class,'destroy'])->name("UserLogout");
});