<?php

use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Guest\ApartmentController as GuestApartmentController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// home
Route::get('/', function () {
    return view('welcome');
});


// dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// controlls
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// guest
Route::prefix('guest/')->name('guest.')->group(function () {
    //# Resources
    Route::resource('apartments', GuestApartmentController::class);
});


// admin
Route::prefix('admin/')->name('admin.')->group(function () {
    //* archive

    Route::get('apartments/archive', [AdminApartmentController::class, 'archive'])->name('apartments.archive');
    Route::delete('apartments/dropAll', [AdminApartmentController::class, 'dropAll'])->name('apartments.dropAll');
    Route::patch('apartments/{project}/restore', [AdminApartmentController::class, 'restore'])->name('apartments.restore');
    Route::delete('apartments/{project}/drop', [AdminApartmentController::class, 'drop'])->name('apartments.drop');

    //# Resources apartment
    Route::resource('apartments', AdminApartmentController::class);

    //# Resources sponsors
    Route::post('sponsors/payment', [SponsorController::class, 'payment'])->name('sponsors.payment');

    Route::resource('sponsors', SponsorController::class);
});


require __DIR__ . '/auth.php';
