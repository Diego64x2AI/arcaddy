<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Juego;
use App\Models\QRLink;
use App\Models\UserQr;
use App\Models\Visita;
use App\Models\Cliente;
use App\Models\ClienteQuiz;
use App\Models\GrupoMiembro;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JuegoResultado;
use App\Models\QuizRespuestas;
use App\Models\ClienteProducto;
use App\Models\ClienteSucursal;
use App\Models\ProductoCanjeado;
use App\Models\RealidadAumentada;
use Illuminate\Support\Facades\DB;
use App\Models\ClienteMarcoGaleria;
use App\Http\Controllers\Controller;
use App\Models\ClienteQRExperiencia;
use App\Models\ClienteQuizRespuesta;
use App\Notifications\RegistroCodigo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyAppClientController extends Controller
{
	public function home()
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.home', compact('clientedatos'));
	}

	public function homeEscaner()
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.escaner', compact('clientedatos'));
	}

	public function homeQr()
	{
		echo QrCode::format('png')
			->size(500)
			->margin(1)
			->color(0, 0, 0)
			->backgroundColor(255, 255, 255)
			->merge('/public/images/qr-logo.png', .3)
			->errorCorrection('H')
			->generate('www.nigmacode.com', public_path('storage/qrregister/alex3.png'));


		//https://www.simplesoftware.io/#/docs/simple-qrcode

		/*echo public_path('storage/qrcodes/alex2.png');
        echo '<br>';
        echo storage_path('app/public/qrcodes');*/

		//storage_path('app/public/qrcodes/' . $cliente->slug . '.png')

		//QrCode::color(255,0,255); //Cambia el color de nuestro codigo
		//QrCode::backgroundColor(255,255,0); //Le añade el color al background del codigo
		//QrCode::margin(100); //Le añade la propiedad margin al codigo
		// /var/www/html/storage/app/public/qrcodes
		/*
        // Path to the project's root folder
            echo base_path();

            // Path to the 'app' folder
            echo app_path();

            // Path to the 'public' folder
            echo public_path();

            // Path to the 'storage' folder
            echo storage_path();

            // Path to the 'storage/app' folder
            echo storage_path('app');
        */
	}

	public function checkIn()
	{
		/*return view('my-app-client.check-in');*/
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.check-in2', compact('clientedatos'));
	}

	public function checkIn2()
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.check-in2', compact('clientedatos'));
	}

	public function checkInValidar($codigo)
	{
		$codigo = UserQr::where('codigo', $codigo)->first();
		if ($codigo) {
			if ($codigo->usado == 0) {
				$codigo->usado = 1;
				$codigo->save();
				return response([
					'status' => 'ok',
					'nombre' => $codigo->user->name,
					'email' => $codigo->user->email,
				]);
			} else {
				return response([
					'status' => 'no',
					'nombre' => $codigo->user->name,
					'email' => $codigo->user->email,
				]);
			}
		} else { /*No exixte en la BD*/
			return response([
				'status' => 'no found',
				'nombre' => '',
				'email' => '',
			]);
		}
	}

	public function reporteActivaciones()
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.reporte-activaciones', compact('clientedatos'));
	}

	public function reporteRedenciones()
	{
		//echo Auth::user()->name
		$parametros = NULL;
		if (!isset($_GET['buscar'])) {
			$productos = ClienteProducto::where('cliente_id', auth()->user()->cliente_id)
				->where('regalado', 1)
				->get();
			$gruposIds = GrupoMiembro::where('cliente_id', auth()->user()->cliente_id)->select('grupo_id')->pluck('grupo_id')->toArray();
			if (!empty($gruposIds)) {
				$clientesIds = GrupoMiembro::whereIn('grupo_id', $gruposIds)->where('cliente_id', '!=', auth()->user()->cliente_id)->select('cliente_id')->pluck('cliente_id')->toArray();
				array_push($clientesIds, auth()->user()->cliente_id);
				$productos = ClienteProducto::where('regalado', 1)
				->whereIn('cliente_id', $clientesIds)
				->get();
				// dd(auth()->user()->cliente_id, $productos);
			}
		} else {
			$parametros['buscar'] = $_GET['buscar'];
			$productos = ClienteProducto::where('cliente_id', auth()->user()->cliente_id)
				->where('regalado', 1)
				->where('nombre', 'like', '%' . $_GET['buscar'] . '%')
				->get();
			$gruposIds = GrupoMiembro::where('cliente_id', auth()->user()->cliente_id)->select('grupo_id')->pluck('grupo_id')->toArray();
			if (!empty($gruposIds)) {
				$clientesIds = GrupoMiembro::whereIn('grupo_id', $gruposIds)->where('cliente_id', '!=', auth()->user()->cliente_id)->select('cliente_id')->pluck('cliente_id')->toArray();
				array_push($clientesIds, auth()->user()->cliente_id);
				$productos = ClienteProducto::where('regalado', 1)
				->where('nombre', 'like', '%' . $_GET['buscar'] . '%')
				->whereIn('cliente_id', $clientesIds)
				->get();
				// dd($productos->toSql());
			}
		}
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.reporte-redenciones', compact('productos', 'parametros', 'clientedatos'));
	}

	public function productoRedencion($producto_id)
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.producto-redencion2', compact('clientedatos', 'producto_id'));
	}

	public function productoRedencionValidar($codigo, $producto_id, $usuario_id)
	{
		$codigoExiste = ProductoCanjeado::where('codigo', $codigo)
			->where('producto_id', $producto_id)
			->first();
		$usuario = User::find($usuario_id);
		$producto = ClienteProducto::where('id', $producto_id)
			->where('regalado', 1)
			->first();
		if ($producto) {
			if ($codigoExiste) {
				return response([
					'status' => 'no',
					'nombre' => $usuario->name,
					'nombre_producto' => $producto->name,
				]);
			} else {
				$canje = ProductoCanjeado::create([
					'cliente_id' => $producto->cliente_id,
					'user_id' => $usuario->id,
					'evento_id' => 1,
					'codigo' => $codigo,
					'producto_id'  => $producto_id,
				]);
				return response([
					'status' => 'ok',
					'nombre' => $usuario->name,
					'nombre_producto' => $producto->name,
					'precio_producto' => $producto->precio,
					'img_producto' => asset('storage/' . $producto->imagenes[0]->archivo)
				]);
			}
		} else {
			return response([
				'status' => 'no found',
				'nombre' => $usuario->name
			]);
		}
	}

	public function reporteBaseUsuarios()
	{
		$parametros = NULL;
		if (!isset($_GET['buscar'])) {
			$usuarios = DB::table('users')
				->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
				->where('cliente_id', auth()->user()->cliente_id)
				->where('role_id', 3)
				->get();
		} else {
			$parametros['buscar'] = $_GET['buscar'];
			$usuarios = DB::table('users')
				->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
				->where('cliente_id', auth()->user()->cliente_id)
				->where('role_id', 3)
				->where(function ($query) {
					$query->where('name', 'like', '%' . $_GET['buscar'] . '%')
						->orWhere('email', 'like', '%' . $_GET['buscar'] . '%');
				})
				->get();
		}
		$cliente_id = auth()->user()->cliente_id;
		$usuariosTotales = DB::table('users')
			->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
			->where('cliente_id', auth()->user()->cliente_id)
			->where('role_id', 3)
			->count();
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		return view('my-app-client.reporte-base-usuarios', compact('usuarios', 'parametros', 'cliente_id', 'clientedatos', 'usuariosTotales'));
	}


	public function reenviarAcceso($clienteid, $usuarioid)
	{
		$user = User::find($usuarioid);
		$cliente = Cliente::find($clienteid);
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$userQr = UserQr::where('cliente_id', $clienteid)
			->where('user_id', $user->id)
			->first();
		try {
			$user->notify(new RegistroCodigo($user, $cliente, $userQr->codigo));
		} catch (\Exception $e) {
		}
		return response([
			'status' => 'ok',
			'email' => $user->email
		]);
	}

	public function reporteEstadisticas()
	{
		$clientedatos = Cliente::find(auth()->user()->cliente_id);
		$cliente = $clientedatos;
		$lang = strtolower($clientedatos->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$visitas = Visita::select('id', 'url', 'cliente_id', 'model', 'model_id', DB::raw('count(*) as total'))->where('cliente_id', $cliente->id)->groupBy('url')->orderBy('total', 'desc')->take(10)->get();
		$qrlinks = QRLink::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$realidades = RealidadAumentada::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$sucursales = ClienteSucursal::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$marcos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->inRandomOrder()->take(9)->get();
		$marcos_compartidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->where('compartida', 1)->count();
		$marcos_subidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->count();
		$totales = [
			'visitas' => Visita::where('cliente_id', $cliente->id)->count(),
			'usuarios' => User::where('cliente_id', $cliente->id)->count(),
			'redenciones' => ProductoCanjeado::where('cliente_id', $cliente->id)->count(),
			'productos' => ClienteProducto::where('cliente_id', $cliente->id)->count(),
			'admisiones' => UserQr::where('cliente_id', $cliente->id)->where('usado', 1)->count(),
			'activaciones' => ClienteQRExperiencia::where('cliente_id', $cliente->id)->sum('visitas'),
		];
		$juegos = Juego::where('cliente_id', $cliente->id)->where('activo', 1)->orderBy('id', 'desc')->get();
		$games = [];
		foreach ($juegos as $juego) {
			$games[] = [
				'id' => $juego->id,
				'nombre' => $juego->nombre,
				'visitas' => Visita::where('cliente_id', $cliente->id)->where('model', '\App\Models\Juego')->where('model_id', $juego->id)->count(),
				'scores' => JuegoResultado::where('juego_id', $juego->id)->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->take(10)->get(),
			];
		}
		$quiz = ClienteQuiz::where('cliente_id', $cliente->id)->where('activa', 1)->orderBy('id', 'desc')->first();
		$quiz_totales = 0;
		$quiz_respuestas = [];
		if ($quiz !== NULL) {
			if ($quiz->preguntas->first() !== NULL) {
				$quiz_totales = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $quiz->preguntas->first()->id)->count();
			}
			$preguntas = QuizRespuestas::where('quiz_id', $quiz->id)->groupBy('pregunta_id')->select('id', 'user_id', 'pregunta_id', 'tipo', 'respuesta_id')->get();
			foreach ($preguntas as $pregunta) {
				$quiz_respuestas[$pregunta->pregunta->id]['pregunta'] = $pregunta->pregunta;
				$quiz_respuestas[$pregunta->pregunta->id]['respuesta'] = $pregunta->respuesta;
				if ($pregunta->pregunta->tipo === 'open') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
				} elseif ($pregunta->pregunta->tipo === 'level') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
					// calculate average
					$quiz_respuestas[$pregunta->pregunta->id]['promedio'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->avg('puntos');
				} elseif ($pregunta->pregunta->tipo === 'like') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					// calculate percentage of each answer
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$quiz_respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
					}
				} elseif ($pregunta->pregunta->tipo === 'versus') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					// calculate percentage of each answer
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$quiz_respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
					}
				} elseif ($pregunta->pregunta->tipo === 'option' || $pregunta->pregunta->tipo === 'multi') {
					// $quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = ClienteQuizRespuesta::where('pregunta_id', $pregunta->pregunta->id)->get();
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$value->total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->where('respuesta_id', $value->id)->groupBy('respuesta_id')->count();
						$value->porcentaje = ($value->total / $total) * 100;
					}
					$quiz_respuestas[$pregunta->pregunta->id]['dataset'] = [
						'labels' => $quiz_respuestas[$pregunta->pregunta->id]['respuestas']->pluck('respuesta')->toArray(),
						'data' => $quiz_respuestas[$pregunta->pregunta->id]['respuestas']->pluck('total')->toArray(),
					];
				}
			}
		}
		return view('my-app-client.reporte-estadisticas', compact('clientedatos', 'cliente', 'visitas', 'qrlinks', 'realidades', 'sucursales', 'marcos', 'marcos_compartidos', 'marcos_subidos', 'totales', 'games', 'quiz', 'quiz_totales', 'quiz_respuestas'));
	}
}
