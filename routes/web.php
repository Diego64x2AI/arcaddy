<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ClienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
	Route::prefix('dashboard')->group(function () {
		Route::get('/', [ClienteController::class, 'index'])->name('dashboard');
		Route::resource('/clientes', ClienteController::class);
	});
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [HomeController::class, 'cliente'])->name('cliente');
