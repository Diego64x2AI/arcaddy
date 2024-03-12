<?php

use App\Models\User;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Notifications\PedidoCreado;
use App\Notifications\RegistroCodigo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\CuponesController;
use App\Http\Controllers\Admin\PedidosController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\VotacionesController;
use App\Http\Controllers\Admin\MyAppClientController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\UsuariosClienteController;

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
Route::get('/guardar-en-calendario/{clienteid}/{eventoid}', [HomeController::class, 'guardarEnCalendario'])->name('guardar-en-calendario');

Route::get('/registro-de-usuario/{clienteid}', [RegisteredUserController::class, 'registroDeUsuario'])->name('registro-de-usuario');
Route::get('/prueba-qr/revisar', [HomeController::class, 'pruebaQR'])->name('pruebaQR');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/votar', [HomeController::class, 'votar'])->name('votar')->middleware('votacionthrottle:1,1440');
Route::post('/acceso/{cliente}', [HomeController::class, 'acceso'])->name('acceso');
Route::post('/zipcode/{cliente}', [HomeController::class, 'zipcode'])->name('zipcode');
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
/*
Route::get('/notification', function () {
	$cliente = Cliente::find(2);
	$user = User::find(8);
	return (new RegistroCodigo($user, $cliente))->toMail($user);
});
*/

Route::middleware('role:client')->group(function () {
	Route::prefix('my-app-client')->group(function () {
		Route::get('/home', [MyAppClientController::class, 'home'])->name('my-app-client.home');
		Route::get('/reporte-activaciones', [MyAppClientController::class, 'reporteActivaciones'])->name('my-app-client.reporte-activaciones');
		Route::get('/reporte-redenciones', [MyAppClientController::class, 'reporteRedenciones'])->name('my-app-client.reporte-redenciones');
		Route::get('/reporte-base-usuarios', [MyAppClientController::class, 'reporteBaseUsuarios'])->name('my-app-client.reporte-base-usuarios');
		Route::get('/reporte-estadisticas', [MyAppClientController::class, 'reporteEstadisticas'])->name('my-app-client.reporte-estadisticas');
		Route::get('/home-qr', [MyAppClientController::class, 'homeQr'])->name('my-app-client.home-qr');
		Route::get('/home-escaner', [MyAppClientController::class, 'homeEscaner'])->name('my-app-client.home-escaner');
		Route::get('/check-in', [MyAppClientController::class, 'checkIn'])->name('my-app-client.check-in');
		Route::get('/check-in2', [MyAppClientController::class, 'checkIn2'])->name('my-app-client.check-in2');
		Route::get('/check-in-validar/{codigo}', [MyAppClientController::class, 'checkInValidar'])->name('my-app-client.check-in-validar');
		Route::get('/producto-redencion/{producto_id}', [MyAppClientController::class, 'productoRedencion'])->name('my-app-client.producto-redencion');
		Route::get('/producto-redencion-validar/{producto_id}/{codigo}/{usuario_id}', [MyAppClientController::class, 'productoRedencionValidar'])->name('my-app-client.producto-redencion-validar');
		Route::get('/reenviar-acceso/{clienteid}/{usuarioid}', [MyAppClientController::class, 'reenviarAcceso'])->name('my-app-client.reenviar-acceso');
		/*Registro de usuario en la app de client*/
		Route::get('/registro-interno-de-usuario/{clienteid}', [RegisteredUserController::class, 'registroInternoDeUsuario'])->name('registro-interno-de-usuario');
		Route::post('/recibe-registro-interno-de-usuario/{clienteid}', [RegisteredUserController::class, 'recibeRegistroInternoDeUsuario'])->name('recibe-registro-interno-de-usuario');
	});
});
Route::middleware('role:admin')->group(function () {
	Route::prefix('dashboard')->group(function () {
		Route::get('/', [ClienteController::class, 'index'])->name('dashboard');
		Route::post('/clientes/crop', [ClienteController::class, 'crop'])->name('clientes.crop');
		Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
		Route::get('/clientes/registrodb/delete/{cliente}', [ClienteController::class, 'registrodb_delete'])->name('clientes.registrodb.delete');
		Route::resource('clientes', ClienteController::class);
		Route::resource('votaciones', VotacionesController::class, [
			'except' => ['update']
		]);
		Route::resource('cliente.quiz', QuizController::class)->except(['create', 'show']);
		Route::prefix('cliente')->group(function () {
			Route::prefix('{cliente}')->group(function () {
				Route::prefix('quiz/{quiz}')->group(function () {
					Route::get('/stats', [QuizController::class, 'stats'])->name('clientes.quiz.stats');
					Route::post('/atributo', [QuizController::class, 'updatea'])->name('cliente.quiz.updatea')->where('quiz', '[0-9]+')->where('cliente', '[0-9]+');
				});
			});
		});
		Route::prefix('votaciones')->group(function () {
			Route::post('/{votacione}/atributo', [VotacionesController::class, 'updatea'])->name('votaciones.updatea');
			Route::prefix('categorias')->group(function () {
				Route::get('/{votacione}', [VotacionesController::class, 'categorias'])->name('votaciones.categorias');
				Route::post('/{votacione}', [VotacionesController::class, 'categorias_store'])->name('votaciones.categorias.store');
				Route::delete('/{categoria}', [VotacionesController::class, 'categorias_destroy'])->name('votaciones.categorias.destroy');
				//Route::post('/{categoria}/atributo', [VotacionesController::class, 'categorias_updatea'])->name('votaciones.categorias.updatea');
			});
			Route::prefix('participantes')->group(function () {
				Route::get('/{votacione}', [VotacionesController::class, 'participantes'])->name('votaciones.participantes');
				Route::post('/{votacione}/search', [VotacionesController::class, 'participantes_search'])->name('votaciones.participantes.search');
				Route::post('/{votacione}', [VotacionesController::class, 'participantes_store'])->name('votaciones.participantes.store');
				Route::delete('/{participante}', [VotacionesController::class, 'participantes_destroy'])->name('votaciones.participantes.destroy');
				Route::post('/{participante}/atributo', [VotacionesController::class, 'participantes_updatea'])->name('votaciones.participantes.updatea');
			});
		});
		Route::prefix('usuarios')->group(function () {
			Route::get('/{cliente}', [UsuariosController::class, 'index'])->name('usuarios.index');
			Route::get('/{cliente}/ajax', [UsuariosController::class, 'ajax'])->name('usuarios.ajax');
			Route::post('/{cliente}/{user}/delete', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
			Route::get('/{cliente}/exportar', [UsuariosController::class, 'export'])->name('usuarios.export');
			Route::get('/{cliente}/importar', [UsuariosController::class, 'import'])->name('usuarios.import');
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
		Route::resource('/usuarios-cliente', UsuariosClienteController::class);
		Route::resource('/games', GameController::class);
		Route::get('/games/borrar/{juegoid}', [GameController::class, 'borrar'])->name('games.borrar');
	});
});

require __DIR__.'/auth.php';
Route::get('/registro/{cliente}', [HomeController::class, 'registro'])->name('registro')->middleware('auth');
Route::get('/{slug}', [HomeController::class, 'cliente'])->name('cliente');
Route::get('/{slug}/start-game/{claveJuego}', [HomeController::class, 'startGame'])->name('cliente.start-game');
Route::get('/{slug}/marco', [HomeController::class, 'cliente_marco'])->name('cliente.marco');

Route::middleware('auth')->group(function () {
	Route::post('/{slug}/save-game/{claveJuego}', [HomeController::class, 'saveGame'])->name('cliente.save-game');
});

Route::post('/{cliente}/quiz', [HomeController::class, 'quiz_respuesta'])->name('cliente.quiz.respuesta');
