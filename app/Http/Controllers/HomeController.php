<?php

namespace App\Http\Controllers;

use DateInterval;
use App\Models\Juego;
use App\Models\UserQr;
use DateTimeImmutable;
use App\Models\Cliente;
use App\Models\ClienteQuiz;
use App\Models\ClienteRally;
use App\Models\GrupoMiembro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\JuegoResultado;
use App\Models\QuizRespuestas;
use App\Models\ClienteCartelera;
use App\Models\ProductoCanjeado;
use App\Models\ClienteMarcoGaleria;
use App\Models\ClienteProducto;
use App\Models\ClienteQuizPregunta;
use App\Models\ClienteQRExperiencia;
use Eluceo\iCal\Domain\Entity\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use App\Models\ClienteRallyUbicacion;
use App\Models\ClienteProductoDigital;
use Illuminate\Support\Facades\Cookie;
use App\Models\VotacionesParticipantes;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Domain\ValueObject\Alarm;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use App\Models\ClienteRallyUbicacionCompletados;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;

class HomeController extends Controller
{
	public function rally_completed($slug, ClienteRally $rally, ClienteRallyUbicacion $ubicacion)
	{
		// check if is ajax request
		if (!request()->ajax()) {
			abort(404);
		}
		$data = request()->validate([
			'distancia' => 'required|numeric|min:0|max:' . $ubicacion->distancia,
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		]);
		// log the rally completed
		if (!ClienteRallyUbicacionCompletados::where('ubicacion_id', $ubicacion->id)->where('user_id', auth()->id())->exists()) {
			ClienteRallyUbicacionCompletados::create([
				'ubicacion_id' => $ubicacion->id,
				'user_id' => auth()->id(),
				'distancia' => (float) $data['distancia'],
				'lat' => (float) $data['lat'],
				'lng' => (float) $data['lng'],
				'ip' => request()->ip(),
				'referer' => request()->header('referer'),
				'user_agent' => request()->header('user-agent'),
			]);
			$ubicacion->increment('completados');
		}
		return response()->json([
			'status' => true,
			'image' => $ubicacion->imagen,
			'link' => $ubicacion->btn_link,
			'message' => 'Ubicación completada.',
		]);
	}

	public function qr_experiencia($slug, ClienteQRExperiencia $qrexperiencia)
	{
		// incrementar las visitas
		$qrexperiencia->increment('visitas');
		if ($qrexperiencia->tipo === 'link') {
			return redirect($qrexperiencia->url);
		}
	}

	public function guardarEnCalendario($clienteid, $eventoid)
	{
		date_default_timezone_set('America/Mexico_City');
		switch ($eventoid) {
			case 1:
				$titulo = "Humanos vs Máquinas";
				$archivo = "evento-humanos-vs-maquinas";
				$descripcion = "Lic. Jair Ramírez: Dueño y fundador de la Academia Nacional de Emprendedores y Presidente de la Comisión de Inteligencia Artificial en el Estadod e México.";
				$inicio = date('Ymd\THis', strtotime('2023-11-23 09:30:00'));
				$fin = date('Ymd\THis', strtotime('2023-11-23 10:15:00'));
				break;
			case 2:
				$titulo = "Habilidades y Herramientas para aplicar la Inteligencia Artificial en el Desarrollo Personal y Profesional";
				$archivo = "evento-habilidades-y-herramientas";
				$descripcion = "Ing. Nancy Salazar: Ingeniería en Tecnologías de la Información, egresada de la Universidad Tecnológica de León y estudiante de Maestríaen Administración de Tecnologías de la Información en el Tec de Monterrey.";
				$inicio = date('Ymd\THis', strtotime('2023-11-23 10:30:00'));
				$fin = date('Ymd\THis', strtotime('2023-11-23 11:15:00'));
				break;
			case 3:
				$titulo = "IA Emprendedora: Innovando en la Creación de Startups con Inteligencia Artificial";
				$archivo = "evento-ia-emprendedora";
				$descripcion = "Leonardo Estrada: Co Funder y CEO de Hola Cash, Regional Partnerships Manager de UBER.";
				$inicio = date('Ymd\THis', strtotime('2023-11-23 11:30:00'));
				$fin = date('Ymd\THis', strtotime('2023-11-23 12:15:00'));
				break;
			case 4:
				$titulo = "Amigos digitales";
				$archivo = "evento-amigos-digitales";
				$descripcion = "Francisco Alonso Herrera: PMP Profesional en la Dirección de Proyectos por el PMI (Project Management Institute).";
				$inicio = date('Ymd\THis', strtotime('2023-11-23 11:00:00'));
				$fin = date('Ymd\THis', strtotime('2023-11-23 12:15:00'));
				break;
			case 5:
				$titulo = "Transformación Empresarial con Inteligencia Artificial: Perspectivas y Prácticas Actuales";
				$archivo = "evento-transformacion-empresarial";
				$descripcion = "Antonio Andrade: Ayuda a las empresas a definir estrategias realmente efectivas de Transformación Digital.";
				$inicio = date('Ymd\THis', strtotime('2023-11-23 09:00:00'));
				$fin = date('Ymd\THis', strtotime('2023-11-23 10:00:00'));
				break;
			default:
				echo "Opción no válida";
		}



		$contenido_ics = "BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
UID:unique-id-" . $eventoid . "
DTSTAMP:" . date('Ymd\THis') . "Z
DTSTART:" . $inicio . "
DTEND:" . $fin . "
SUMMARY:" . $titulo . "
DESCRIPTION:" . $descripcion . "
LOCATION:Tec de Monterrey Campus Sinaloa
END:VEVENT
END:VCALENDAR";

		// Crear una respuesta HTTP
		$response = new Response($contenido_ics);

		// Configurar encabezados para que el navegador reconozca el archivo .ics
		$response->header('Content-type', 'text/calendar; charset=utf-8');
		$response->header('Content-Disposition', 'attachment; filename=' . $archivo . '.ics');

		return $response;
	}

	public function cliente_evento($slug, ClienteCartelera $ClienteCartelera)
	{
		// 1. Create Event domain entity.
		$event = new Event();
		$event->setSummary($ClienteCartelera->titulo);
		if (trim($ClienteCartelera->descripcion) !== '') {
			$event->setDescription($ClienteCartelera->descripcion);
		}
		$event->setLocation(
			(new Location($ClienteCartelera->lugar)) //->withGeographicPosition(new GeographicPosition(47.557579, 10.749704))
		)
			->setOccurrence(
				new TimeSpan(
					new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "{$ClienteCartelera->fecha->format('Y-m-d')} " . \Carbon\Carbon::parse($ClienteCartelera->hora)->format('H:i:s')), true),
					new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "{$ClienteCartelera->fecha->format('Y-m-d')} " . \Carbon\Carbon::parse($ClienteCartelera->hora)->addHour()->format('H:i:s')), true)
				)
			)
			->addAlarm(
				new Alarm(
					new Alarm\DisplayAction('Evento en 15 minutos'),
					(new Alarm\RelativeTrigger(DateInterval::createFromDateString('-15 minutes')))->withRelationToEnd()
				)
			)
		;
		// 2. Create Calendar domain entity.
		$calendar = new Calendar([$event]);
		// 3. Transform domain entity into an iCalendar component
		$componentFactory = new CalendarFactory();
		$calendarComponent = $componentFactory->createCalendar($calendar);
		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="evento-arcaddy-' . $ClienteCartelera->id . '.ics"');
		echo $calendarComponent;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function pruebaQR()
	{
		$elCodigo = 'X-1-5-' . date('YmdHis');

		/*QR ALEX*/
		QrCode::format('png')
			->size(500)
			->margin(1)
			->color(0, 0, 0)
			->backgroundColor(255, 255, 255)
			->merge('/public/images/qr-logo.png', .3)
			->errorCorrection('H')
			->generate($elCodigo, public_path('storage/qrregister/' . $elCodigo . '.png'));

		echo '1---' . public_path('storage/qrregister/' . $elCodigo . '.png');
	}

	public function index()
	{
		return view('welcome');
	}

	public function votar(Request $request)
	{
		$request->validate([
			'id' => 'required|numeric|min:1|exists:\App\Models\VotacionesParticipantes,id'
		]);
		$participante = VotacionesParticipantes::where('id', (int) $request->id)->first();
		if (!$participante->votacion->votar) {
			return response()->json([
				'message' => 'Las votaciones están desactivadas.',
			], 500);
		}
		$participante->increment('votos');
		return response()->json([
			'message' => 'Gracias por tu voto.',
			'votos' => $participante->votos
		]);
	}

	public function cliente_marco($slug = '')
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$seccion = $cliente->secciones()->where('seccion', 'marco')->firstOrFail();
		// if is not active redirect to the client page
		if (!$seccion->activa) {
			return redirect()->route('cliente', $cliente->slug);
		}
		return view('marco', [
			'cliente' => $cliente,
		]);
	}

	public function cliente_marco_store($slug = '', Request $request)
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$seccion = $cliente->secciones()->where('seccion', 'marco')->firstOrFail();
		// if is not active redirect to the client page
		if (!$seccion->activa) {
			abort(404);
		}
		$data = $request->validate([
			'imagen' => 'required|image',
			'compartir' => 'required|numeric|min:0|max:1',
			'token' => 'required',
		]);
		// dd(env('RECAPTCHA_SECRET_KEY'), $data['token']);
		// validate recaptcha make a http request to google
		/*
		$response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret' => env('RECAPTCHA_SECRET_KEY'),
			'response' => $data['token'],
			'remoteip' => $request->ip(),
		]);
		// if the response is not ok
		if (!$response->ok()) {
			return response()->json([
				'status' => false,
				'message' => 'Error al validar el captcha.',
			]);
		}
		$json = $response->json();
		// validate the score and success
		if (!$json['success'] || $json['score'] < 0.7) {
			return response()->json([
				'status' => false,
				'message' => 'Lo sentimos tu IP es posiblemente de un BOT.',
			]);
		}
		*/
		$filename = uniqid() . '.jpg';
		$imagen = $data['imagen']->storeAs('clientes/marcos', $filename, 'public');
		// resize image
		$manager = new ImageManager(Driver::class);
		$manager->read('storage/' . $imagen)->resize(1024, 1024, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		})->save('storage/' . $imagen);
		ClienteMarcoGaleria::create([
			'cliente_id' => $cliente->id,
			'user_id' => $request->user()?->id,
			'archivo' => $imagen,
			'aprobada' => false,
			'compartida' => (bool) $data['compartir'],
		]);
		// response json
		return response()->json([
			'status' => true,
			'message' => 'Tu foto ha sido subida correctamente',
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cliente($slug = '')
	{
		//$dominio = $_SERVER['HTTP_HOST'];
		if (strpos($_SERVER['HTTP_HOST'], 'oce-geli-ra.mx') !== false && $slug !== 'gelicart') {
			header("Location: https://oce-geli-ra.mx/gelicart");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'cumbre200.mundoejecutivo.com.mx') !== false && $slug !== 'cumbre200') {
			header("Location: https://cumbre200.mundoejecutivo.com.mx/cumbre200");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'oce-eg-ra.mx') !== false && $slug !== 'enterogermina') {
			header("Location: https://oce-eg-ra.mx/enterogermina");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'oce-all-ra.mx') !== false && $slug !== 'allegra') {
			header("Location: https://oce-all-ra.mx/allegra");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'aadistrito26.com') !== false && $slug !== 'aa') {
			header("Location: https://aadistrito26.com/aa");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'weliveendurance.com') !== false && $slug !== 'weliveendurance') {
			header("Location: https://weliveendurance.com/weliveendurance");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'oce-plb-ra.mx') !== false && $slug !== 'pulmonarom') {
			header("Location: https://oce-plb-ra.mx/pulmonarom");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'pananews.panama.com.mx') !== false && $slug !== 'panama') {
			header("Location: https://pananews.panama.com.mx/panama");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'stitch.betterware.com.mx') !== false && $slug !== 'stitch') {
			header("Location: https://stitch.betterware.com.mx/stitch");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'chandrany.com') !== false && $slug !== 'chandrany') {
			header("Location: https://chandrany.com/chandrany");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'juramamx.com') !== false && $slug !== 'jurama') {
			header("Location: https://juramamx.com/jurama");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'lacasitasagrada.mx') !== false && $slug !== 'lupita') {
			header("Location: https://lacasitasagrada.mx/lupita");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'lacasitasagrada.com.mx') !== false && $slug !== 'lupita') {
			header("Location: https://lacasitasagrada.com.mx/lupita");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'lacasitasagrada.com') !== false && $slug !== 'lupita') {
			header("Location: https://lacasitasagrada.com/lupita");
			exit();
		} elseif (strpos($_SERVER['HTTP_HOST'], 'malefica.betterware.com.mx') !== false && $slug !== 'malefica') {
			header("Location: https://malefica.betterware.com.mx/malefica");
			exit();
		}
		/*elseif(strpos($_SERVER['HTTP_HOST'], 'oce-eg-ra.mx') !== false && $slug == 'gelicart'){

	    }*/
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		if ($cliente->password !== NULL && trim($cliente->password) !== '' && Cookie::get('cpass') !== $cliente->password) {
			return view('cliente-password', [
				'cliente' => $cliente,
			]);
		}
		// Geo Bloqueo Automatico
		if ($cliente->geo_bloqueo === 1 && Cookie::get('geo_bloqueo') !== 'autorizado') {
			return view('cliente-gps', [
				'cliente' => $cliente,
			]);
		}
		// Geo Bloqueo Manual
		if ($cliente->geo_bloqueo === 2 && Cookie::get('geo_bloqueo') !== 'autorizado') {
			return view('cliente-zip', [
				'cliente' => $cliente,
			]);
		}
		if ($cliente->login_bloqueo) {

			if (auth()->check()) {
				return view('cliente', [
					'cliente' => $cliente,
				]);
			} else {
				// Usuario no autenticado, redirige al formulario de inicio de sesión
				return redirect()->route('login', $cliente->id)->with('message', 'Inicia sesión para acceder.');
			}
		} else {
			return view('cliente', [
				'cliente' => $cliente,
			]);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function zipcode(Cliente $cliente, Request $request)
	{
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$request->validate([
			'zip' => 'required|min:5'
		]);
		$zip_codes = explode(",", $cliente->geo_codes);
		if (!in_array($request->zip, $zip_codes)) {
			return redirect()->back()->withErrors(['zip' => 'Este código postal no está permitido.']);
		}
		Cookie::queue('geo_bloqueo', 'autorizado', 60);
		return redirect()->route('cliente', $cliente->slug);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function acceso(Cliente $cliente, Request $request)
	{
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$request->validate([
			'password' => 'required|string|min:1'
		]);
		if ($cliente->password !== $request->password) {
			return redirect()->back()->withErrors(['password' => 'La contraseña es incorrecta.']);
		}
		Cookie::queue('cpass', $request->password, (60 * 24 * 30));
		return redirect()->route('cliente', $cliente->slug);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function registro(Cliente $cliente)
	{
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		/*if (!is_dir(storage_path('app/public/qrcodesr'))) {
			File::makeDirectory(storage_path('app/public/qrcodesr'));
		}*/
		// dd(storage_path('app/public/'.$cliente->logo)); '/storage/app/public/'.$cliente->logo
		/*QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/'.$cliente->slug.'?user='.Auth::user()->id, storage_path('app/public/qrcodesr/' . Auth::user()->id . '.png'));*/
		/*$userQr = UserQr::create([
				'cliente_id' => $cliente->id,
				'user_id' => $user->id,
				'evento_id' => 1,
				'codigo' => $elCodigo,
				'usado'  => 0,
			]);*/
		$ver = 0;
		if (isset($_GET['ver']) && $_GET['ver'] == 1) {
			$ver = 1;
		}
		$userQr = UserQr::where('user_id', Auth::user()->id)
			->where('cliente_id', $cliente->id)
			->first();
		if ($userQr === null) {
			$elCodigo = $cliente->id . '-1-' . Auth::user()->id . '-' . date('YmdHis');
			/*QR ALEX*/
			QrCode::format('png')
				->size(500)
				->margin(1)
				->color(0, 0, 0)
				->backgroundColor(255, 255, 255)
				->merge('/public/images/qr-logo.png', .3)
				->errorCorrection('H')
				->generate($elCodigo, public_path('storage/qrregister/' . $elCodigo . '.png'));
			$userQr = UserQr::updateOrCreate(
				[
					'cliente_id' => $cliente->id,
					'user_id' => Auth::user()->id,
				],
				[
					'evento_id' => 1,
					'codigo' => $elCodigo,
					'usado'  => 0,
				]
			);
			//return redirect()->route('cliente', $cliente->slug);
		}
		// where('user_id', Auth::user()->id)
		$canjeados = ProductoCanjeado::where('cliente_id', $cliente->id)->where('user_id', Auth::user()->id)->groupBy('producto_id')->pluck('producto_id')->toArray();
		if (empty($canjeados)) {
			array_push($canjeados, 0);
		}
		$productos = $cliente->productos()->where('regalado', 1)->whereNotIn('id', $canjeados);
		$productos2 = $cliente->productos()->where('regalado', 1)->whereIn('id', $canjeados);
		$gruposIds = GrupoMiembro::where('cliente_id', $cliente->id)->select('grupo_id')->pluck('grupo_id')->toArray();
		if (!empty($gruposIds)) {
			$clientesIds = GrupoMiembro::whereIn('grupo_id', $gruposIds)->where('cliente_id', '!=', $cliente->id)->select('cliente_id')->pluck('cliente_id')->toArray();
			$productos = ClienteProducto::whereRaw('(cliente_id IN (' . implode(',', $clientesIds) . ') AND id NOT IN (' . implode(',', $canjeados) . ') AND grupos=1 AND regalado=1) OR (cliente_id=' . $cliente->id . ' AND id NOT IN (' . implode(',', $canjeados) . ') AND regalado=1)');
			$productos2 = ClienteProducto::whereRaw('(cliente_id IN (' . implode(',', $clientesIds) . ') AND id IN (' . implode(',', $canjeados) . ') AND grupos=1 AND regalado=1) OR (cliente_id=' . $cliente->id . ' AND id IN (' . implode(',', $canjeados) . ') AND regalado=1)');
			// dd($productos->toSql());
		}
		// dd($productos->get());
		return view('registro', [
			'cliente' => $cliente,
			'userQr' => $userQr,
			'ver' => $ver,
			'canjeados' => $canjeados,
			'productos' => $productos,
			'productos2' => $productos2,
		]);
	}

	/**
	 * Show the form reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function digital(ClienteProductoDigital $cupon)
	{
		// dd($cupon);
		return view('digital', [
			'cupon' => $cupon,
		]);
	}

	/**
	 * Show the share reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function digital_share(ClienteProductoDigital $cupon)
	{
		// dd($cupon);
		return view('digital_share', [
			'cupon' => $cupon,
		]);
	}

	/**
	 * reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function canjear(ClienteProductoDigital $cupon)
	{
		$cupon->update([
			'canjeado' => true,
			'canjeado_at' => now(),
		]);
		return redirect()->back()->with('success', 'Cupón canjeado con éxito');
	}

	public function startGame($slug, $claveJuego)
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$juego = Juego::with(['categoria'])->where('clave', $claveJuego)->firstOrFail();
		if ($juego) {
			return view('games.' . $juego->categoria->slug, compact('juego', 'cliente', 'slug', 'claveJuego'));
		} else {
			return redirect()->route('cliente', $slug);
		}
	}

	public function saveGame($slug, $claveJuego, Request $request)
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$data = $request->validate([
			'tiempo' => 'numeric|min:1',
			'aciertos' => 'numeric|min:0',
			'errores' => 'numeric|min:0',
		]);
		$juego = Juego::where('clave', $claveJuego)->firstOrFail();
		if ($juego) {
			JuegoResultado::updateOrCreate([
				'user_id' => $request->user()->id,
				'juego_id' => $juego->id,
			], [
				'tiempo' => $data['tiempo'],
				'errores' => $data['errores'],
				'aciertos' => $data['aciertos'],
				'puntos' => $data['aciertos'] - $data['errores'],
				'activo' => 1,
				'borrado' => 0,
			]);
			return response()->json([
				'status' => true,
				'message' => 'Score actualizado.',
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'El juego no existe.',
			]);
		}
	}

	public function quiz_respuesta(Cliente $cliente, Request $request)
	{
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$data = $request->validate([
			'quiz' => 'required|numeric|min:1|exists:\App\Models\ClienteQuiz,id',
			'pregunta' => 'required|numeric|min:1|exists:\App\Models\ClienteQuizPregunta,id',
			'respuesta' => 'required|numeric|min:1|exists:\App\Models\ClienteQuizRespuesta,id',
			'otra' => 'nullable|sometimes|string',
		]);
		$quiz = $cliente->quiz()->where('id', $data['quiz'])->firstOrFail();
		$pregunta = $quiz->preguntas()->where('id', $data['pregunta'])->firstOrFail();
		$respuesta = $pregunta->respuestas()->where('id', $data['respuesta'])->firstOrFail();
		// if the quiz is not active
		if (!$quiz->activa) {
			return response()->json([
				'status' => false,
				'message' => 'El quiz no está activo.',
			]);
		}
		// check if the user is logged and the quiz requires login
		if (!Auth::check() && $quiz->login) {
			return response()->json([
				'status' => false,
				'message' => 'Debes iniciar sesión para continuar.',
			]);
		}
		// revisar si es una respuesta abierta
		if (($respuesta->tipo === 'open' || ($respuesta->tipo === 'option' && $respuesta->respuesta === 'Otra...') || ($respuesta->tipo === 'multi' && $respuesta->respuesta === 'Otra...')) && ($data['otra'] === null || $data['otra'] === '')) {
			return response()->json([
				'status' => false,
				'message' => 'No llenaste el texto de campo.',
			]);
		}
		// dd($respuesta);
		$puntos = 0;
		if (($quiz->score || $quiz->calificacion) && $respuesta->correcta) {
			$puntos = $pregunta->valor;
		}
		if ($pregunta->tipo === 'level') {
			$range = (int) $request->input('range', 0);
			if ($range < 0 || $range > 10) {
				return response()->json([
					'status' => false,
					'message' => 'El rango no es válido.',
				]);
			}
			$puntos = $range;
		}
		if ($pregunta->tipo === 'multi') {
			$data = $request->validate([
				'quiz' => 'required|numeric|min:1|exists:\App\Models\ClienteQuiz,id',
				'pregunta' => 'required|numeric|min:1|exists:\App\Models\ClienteQuizPregunta,id',
				'respuesta' => 'required|numeric|min:1|exists:\App\Models\ClienteQuizRespuesta,id',
				'otra' => 'nullable|sometimes|string',
				'multi' => 'required|array|min:1',
			]);
			foreach ($data['multi'] as $value) {
				$respuesta = $pregunta->respuestas()->where('id', $value)->firstOrFail();
				$puntos = 0;
				if (($quiz->score || $quiz->calificacion) && $respuesta->correcta) {
					$puntos = $pregunta->valor;
				}
				// check if the user is logged
				if (!Auth::check()) {
					QuizRespuestas::create([
						'quiz_id' => $quiz->id,
						'pregunta_id' => $pregunta->id,
						'respuesta_id' => $respuesta->id,
						'respuesta' => ($respuesta->respuesta === 'Otra...') ? $data['otra'] : $respuesta->respuesta,
						'tipo' => $pregunta->tipo,
						'correcta' => $respuesta->correcta,
						'puntos' => $puntos,
					]);
				} else {
					QuizRespuestas::updateOrCreate(
						[
							'user_id' => $request->user()->id,
							'quiz_id' => $quiz->id,
							'pregunta_id' => $pregunta->id,
							'respuesta_id' => $respuesta->id,
						],
						[
							'puntos' => $puntos,
							'respuesta' => ($respuesta->respuesta === 'Otra...') ? $data['otra'] : $respuesta->respuesta,
							'tipo' => $pregunta->tipo,
							'correcta' => $respuesta->correcta,
						]
					);
				}
			}
			return response()->json([
				'status' => true,
				'message' => 'Siguiente pregunta.',
			]);
		}
		// check if the user is logged
		if (!Auth::check()) {
			QuizRespuestas::create([
				'quiz_id' => $quiz->id,
				'pregunta_id' => $pregunta->id,
				'respuesta_id' => $respuesta->id,
				'respuesta' => ($pregunta->tipo === 'open' || ($pregunta->tipo === 'option' && $pregunta->respuesta === 'Otra...')) ? strtolower($data['otra']) : $respuesta->respuesta,
				'tipo' => $pregunta->tipo,
				'correcta' => $respuesta->correcta,
				'puntos' => $puntos,
			]);
		} else {
			QuizRespuestas::updateOrCreate(
				[
					'user_id' => $request->user()?->id,
					'quiz_id' => $quiz->id,
					'pregunta_id' => $pregunta->id,
					'respuesta_id' => $respuesta->id,
				],
				[
					'puntos' => $puntos,
					'respuesta' => ($pregunta->tipo === 'open' || ($pregunta->tipo === 'option' && $pregunta->respuesta === 'Otra...')) ? strtolower($data['otra']) : $respuesta->respuesta,
					'tipo' => $pregunta->tipo,
					'correcta' => $respuesta->correcta,

				]
			);
		}
		return response()->json([
			'status' => true,
			'message' => 'Siguiente pregunta.',
		]);
	}
}
