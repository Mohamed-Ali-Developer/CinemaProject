<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMoviesController;
use App\Http\Controllers\Admin\AdminHallsController;
use App\Http\Controllers\Admin\AdminShowtimesController;
use App\Http\Controllers\Admin\AdminBookingsController;

Route::get('/Admin/Login',[LoginController::class,'show'])
->name('Login');

Route::post('/Admin/login',[LoginController::class,'store'])
->name('LoginSubmit');

Route::middleware(['auth', 'Role:admin'])->group(function () {
    Route::get('/Admin/Home',[AdminController::class ,'index'])->name('MainAdmin');


    Route::get('/Admin/Movies',[AdminMoviesController::class ,'index'])->name('AdminMovies');
    Route::get('/Admin/Movies/AddMovie',[AdminMoviesController::class ,'show'])->name('AdminAddMovies');
    Route::post('/Admin/Movies/AddMovie',[AdminMoviesController::class ,'store'])->name('AdminStoreMovies');
    Route::put('/Admin/Movies/Edit/{movie}',[AdminMoviesController::class ,'update'])->name('AdminupdateMovies');
    Route::get('/Admin/Movies/Edit/{movie}', [AdminMoviesController::class, 'edit'])->name('AdminMoviesEdit');
    Route::delete('/Admin/Movies/{movie}',[AdminMoviesController::class, 'destroy'])->name('AdminMoviesDestroy');


    Route::get('/Admin/Halls',[AdminHallsController::class ,'index'])->name('AdminHalls');
    Route::get('/Admin/Halls/AddHall',[AdminHallsController::class ,'show'])->name('AdminAddHalls');
    Route::post('/Admin/Halls/AddHall',[AdminHallsController::class ,'store'])->name('AdminstoreHalls');
    Route::get('/Admin/Halls/Edit/{hall}',[AdminHallsController::class ,'edit'])->name('AdmineditHalls');
    Route::put('/Admin/Halls/Edit/{hall}',[AdminHallsController::class ,'update'])->name('AdminupdateHalls');
    Route::delete('/Admin/Halls/{hall}',[AdminHallsController::class ,'destroy'])->name('AdmindestroyHalls');


    Route::get('/Admin/Showtimes',[AdminShowtimesController::class ,'index'])->name('AdminShowtimes');
    Route::get('/Admin/Showtimes/AddShowtime',[AdminShowtimesController::class ,'show'])->name('AdminAddShowtimes');
    Route::post('/Admin/Showtimes/AddShowtime',[AdminShowtimesController::class ,'store'])->name('AdminstoreShowtimes');
    Route::get('/Admin/Showtimes/EditShowtime/{time}',[AdminShowtimesController::class ,'edit'])->name('AdmineditShowtimes');
    Route::put('/Admin/Showtimes/EditShowtime/{time}',[AdminShowtimesController::class ,'update'])->name('AdminupdateShowtimes');
    Route::delete('/Admin/Showtimes/{time}',[AdminShowtimesController::class ,'destroy'])->name('AdmindestroyShowtimes');


    Route::get('/Admin/Bookings',[AdminBookingsController::class ,'index'])->name('AdminBookings');
    Route::delete('/Admin/Bookings/{booking}',[AdminBookingsController::class ,'destroy'])->name('AdmindestroyBookings');


    Route::post('/Admin/Logout', [LoginController::class, 'logout'])->name('Logout');
});


