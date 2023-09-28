<?php

use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('admin/')->name('admin.')->group(function () {
    //* TRASH

    Route::get('apartments/trash', [AdminApartmentController::class, 'trash'])->name('apartments.trash');
    Route::delete('apartments/dropAll', [AdminApartmentController::class, 'dropAll'])->name('apartments.dropAll');
    Route::patch('apartments/{project}/restore', [AdminApartmentController::class, 'restore'])->name('apartments.restore');
    Route::delete('apartments/{project}/drop', [AdminApartmentController::class, 'drop'])->name('apartments.drop');

    //# Resources
    Route::resource('apartments', AdminApartmentController::class);
});

require __DIR__ . '/auth.php';
