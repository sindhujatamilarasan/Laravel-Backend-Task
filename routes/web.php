<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('login');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('product/create', [HomeController::class, 'create'])->name('product.create');
    Route::post('product', [HomeController::class, 'store'])->name('product.store');
    Route::get('product/{id}/edit', [HomeController::class, 'edit'])->name('product.edit');
    Route::put('product/{id}', [HomeController::class, 'update'])->name('product.update');
    Route::delete('product/{id}/delete',[HomeController::class, 'delete'])->name('product.delete');

});



