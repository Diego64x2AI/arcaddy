<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ProductoController;

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

Route::middleware('role:admin')->group(function () {
	Route::prefix('dashboard')->group(function () {
		Route::get('/', [ClienteController::class, 'index'])->name('dashboard');
		Route::resource('/clientes', ClienteController::class);
		Route::prefix('productos')->group(function () {
			Route::get('/create/{cliente}', [ProductoController::class, 'create'])->name('productos.create');
			Route::get('/edit/{cliente}/{producto}', [ProductoController::class, 'edit'])->name('productos.edit');
			Route::delete('/delete/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
			Route::post('/store/{cliente}', [ProductoController::class, 'store'])->name('productos.store');
		});
		// Route::resource('/productos', ProductoController::class);
	});
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [HomeController::class, 'cliente'])->name('cliente');
