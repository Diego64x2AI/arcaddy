<?php

use App\Models\User;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Notifications\PedidoCreado;
use App\Notifications\RegistroCodigo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\CuponesController;
use App\Http\Controllers\Admin\PedidosController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\UsuariosController;

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
Route::prefix('carrito')->group(function () {
	Route::get('/', [CarritoController::class, 'carrito'])->name('carrito');
	Route::get('/agregar/{producto}', [CarritoController::class, 'agregar'])->name('agregar_carrito');
	Route::get('/eliminar/{producto}', [CarritoController::class, 'eliminar'])->name('agregar_eliminar');
	Route::post('/actualizar', [CarritoController::class, 'actualizar'])->name('actualizar_carrito');
	Route::get('/pagar', [CarritoController::class, 'pagar'])->name('pagar')->middleware('auth');
	Route::post('/pagar/charge', [CarritoController::class, 'charge'])->name('charge')->middleware('auth');
	Route::get('/gracias', [CarritoController::class, 'gracias'])->name('gracias')->middleware('auth');
});
Route::prefix('digital')->group(function () {
	Route::get('/{cupon}', [HomeController::class, 'digital'])->name('digital');
	Route::get('/share/{cupon}', [HomeController::class, 'digital_share'])->name('digital_share');
	Route::get('/canjear/{cupon}', [HomeController::class, 'canjear'])->name('digital_canjear');
});
Route::get('/notification', function () {
	/*$pedido = Pedido::find(2);
	return (new PedidoCreado($pedido))->toMail($pedido->user);*/
	$cliente = Cliente::find(2);
	$user = User::find(8);
	return (new RegistroCodigo($user, $cliente))->toMail($user);
});

Route::middleware('role:admin')->group(function () {
	Route::prefix('dashboard')->group(function () {
		Route::get('/', [ClienteController::class, 'index'])->name('dashboard');
		Route::resource('/clientes', ClienteController::class);
		Route::prefix('usuarios')->group(function () {
			Route::get('/{cliente}', [UsuariosController::class, 'index'])->name('usuarios.index');
		});
		Route::prefix('cupones')->group(function () {
			Route::get('/', [CuponesController::class, 'index'])->name('cupones.index');
			Route::get('/delete/{cupon}', [CuponesController::class, 'destroy'])->name('cupones.destroy');
		});
		Route::prefix('pedidos')->group(function () {
			Route::get('/', [PedidosController::class, 'index'])->name('pedidos.index');
			Route::get('/delete/{pedido}', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
		});
		Route::prefix('productos')->group(function () {
			Route::get('/create/{cliente}', [ProductoController::class, 'create'])->name('productos.create');
			Route::get('/edit/{cliente}/{producto}', [ProductoController::class, 'edit'])->name('productos.edit');
			Route::put('/edit/{producto}', [ProductoController::class, 'update'])->name('productos.update');
			Route::delete('/delete/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
			Route::get('/qrcode/{producto}', [ProductoController::class, 'qrcode'])->name('productos.qrcode');
			Route::post('/store/{cliente}', [ProductoController::class, 'store'])->name('productos.store');
		});
		// Route::resource('/productos', ProductoController::class);
	});
});

require __DIR__.'/auth.php';
Route::get('/registro/{cliente}', [HomeController::class, 'registro'])->name('registro')->middleware('auth');
Route::get('/{slug}', [HomeController::class, 'cliente'])->name('cliente');
