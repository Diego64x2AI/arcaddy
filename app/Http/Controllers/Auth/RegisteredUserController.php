<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserQr;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Notifications\Welcome;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\ClienteUserField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ClienteUserFieldValue;
use App\Notifications\RegistroCodigo;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisteredUserController extends Controller
{
	/**
	 * Display the registration view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create(Cliente $cliente)
	{
		$sinlogin = 0;
		return view('auth.register', compact('cliente', 'sinlogin'));
	}

	/*Esta funcion es para registrar usuario sin que se haga el login, es apra que otra persona registre usuarios*/
	public function registroDeUsuario($clienteid)
	{
		$sinlogin = 1;
		$cliente = Cliente::find($clienteid);
		return view('auth.register', compact('cliente', 'sinlogin'));
	}

	public function registroInternoDeUsuario($clienteid)
	{
		$cliente = Cliente::find($clienteid);
		return view('registro-interno-de-usuario', compact('cliente'));
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$campos = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'campos.*' => 'required|string|max:255',
			'cliente_id' => ['required', 'numeric', 'exists:clientes,id'],
			'nacimiento' => ['nullable', 'sometimes', 'date']
		]);
		/*	if($request->cliente_id == 2){
		    //dd($campos);


            Para convertir cualquier formato al que deseamos
            $fechaEnCualquierFormato = $campos['nacimiento'];
            $formatosPosibles = [
                'Y-m-d', 'm/d/Y', 'd-m-Y', // Agrega aquí más formatos según tus necesidades
            ];
            $fechaFormateada = null;
            foreach ($formatosPosibles as $formato) {
                $fechaObj = DateTime::createFromFormat($formato, $fechaEnCualquierFormato);

                if ($fechaObj !== false) {
                    $fechaFormateada = $fechaObj->format('Y-m-d');
                    break;
                }
            }
		}*/
		$permitirRegistro = true;
		// validar si esta lleno el campo 3 que es el identificador (este no va a ser optimo por las prisas alex jaja)
		if (ClienteUserField::where('cliente_id', $request->cliente_id)->where('campo_id', 3)->where('activo', 1)->exists()) {
			$idsUsuarios = User::where('cliente_id', $request->cliente_id)->select('id', 'cliente_id')->pluck('id');
			$identificadores = array_map('intval', ClienteUserFieldValue::where('campo_id', 3)->whereIn('user_id', $idsUsuarios)->pluck('valor')->toArray());
			if (in_array(intval($campos['campos'][3]), $identificadores)) {
				return redirect()->back()->withInput()->withErrors(['Ya existe un registro con este identificador.']);
			}
		}
		// validar si existe base de datos de validacion y realizar comprobaciones necesarias
		if (Storage::disk('local')->exists("registro/{$request->cliente_id}.xlsx")) {
			$permitirRegistro = false;
			$rows = Excel::toArray('', "registro/{$request->cliente_id}.xlsx", 'local');
			foreach ($rows[0] as $x => $row) {
				$identificador = (int) $row[0];
				$columnas = count($row);
				if ($identificador > 0 && $identificador === intval($campos['campos'][3])) {
					// si existe una segunda columna como minimo quiere decir que tenemos fecha de nacimiento, validar la fecha tambien
					if ($request->filled('nacimiento') && $columnas >= 2) {
						$fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $row[1]));
						$nacimiento = Carbon::parse($request->nacimiento);
						if ($fecha->format('Y-m-d') === $nacimiento->format('Y-m-d')) {
							$permitirRegistro = true;
						}
					} else { // no tenemos como minimo fecha de nacimiento, entonces se debe validar solo el identificador, que ya lo hicimos anteriormente
						$permitirRegistro = true;
					}
				}
			}
		}
		if (!$permitirRegistro) {
			return redirect()->back()->withInput()->withErrors(['Tu fecha de nacimiento o el identificador no coinciden con nuestra base de datos.']);
		}
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'cliente_id' => $request->cliente_id,
			'password' => Hash::make($request->password),
		]);
		if (isset($request->nacimiento)) {
			$user->nacimiento = $request->nacimiento;
		}
		$user->save();
		$user->assignRole('user');
		/*if (!$user->hasStripeId()) {
			$user->createAsStripeCustomer([
				'metadata' => ['user_id' => $user->id],
			]);
		}*/
		event(new Registered($user));
		if ($request->sinlogin == 0) {
			Auth::login($user);
		}
		$cliente = Cliente::find($request->cliente_id);
		if ($cliente->registro) {
			$elCodigo = $cliente->id . '-1-' . $user->id . '-' . date('YmdHis');
			/*QR ALEX*/
			QrCode::format('png')
				->size(500)
				->margin(1)
				->color(0, 0, 0)
				->backgroundColor(255, 255, 255)
				/*->merge('/public/images/qr-logo.png', .3)*/
				->errorCorrection('H')
				->generate($elCodigo, public_path('storage/qrregister/' . $elCodigo . '.png'));
			$userQr = UserQr::create([
				'cliente_id' => $cliente->id,
				'user_id' => $user->id,
				'evento_id' => 1,
				'codigo' => $elCodigo,
				'usado'  => 0,
			]);
			/*FIN QR ALEX*/
			/*if (!is_dir(storage_path('app/public/qrcodes'))) {
				File::makeDirectory(storage_path('app/public/qrcodesr'));
			}
			QrCode::format('png')->size(500)->merge(storage_path('app/public/'.$cliente->logo), .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug, storage_path('app/public/qrcodesr/' . $user->id . '.png'));*/
			// campos
			if (isset($campos['campos']) && count($campos['campos']) > 0) {
				foreach ($campos['campos'] as $key => $nombre) {
					// echo $key."-".$nombre."-".$request->boolean('campos_activo.'.$key);
					ClienteUserFieldValue::updateOrCreate([
						'user_id' => $user->id,
						'campo_id' => $key,
					], [
						'valor' => $nombre,
					]);
				}
			}
			try {
				$user->notify(new RegistroCodigo($user, $cliente, $elCodigo));
			} catch (\Exception $e) {
			}
		} else {
			try {
				$user->notify(new Welcome($user));
			} catch (\Exception $e) {
			}
		}
		// dd($campos['campos']);
		if ($request->sinlogin == 0) {
			return redirect()->route('registro', ['cliente' => $request->cliente_id]);
		} else {
			return view('registro2', [
				'cliente' => $cliente,
				'userQr' => $userQr,
				'ver' => 0,
				'user' => $user
			]);
		}
	}

	/*RECIBE LOS REGISTROS INTERNOS DESDE MY APP CLIENT*/
	public function recibeRegistroInternoDeUsuario(Request $request)
	{
		$campos = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'campos.*' => 'required|string|max:255',
			'cliente_id' => ['required', 'numeric', 'exists:clientes,id'],
		]);
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'cliente_id' => $request->cliente_id,
			'password' => Hash::make($request->password),
		]);
		if (isset($request->nacimiento)) {
			$user->nacimiento = $request->nacimiento;
			$user->save();
		}
		$user->assignRole('user');
		/*if (!$user->hasStripeId()) {
			$user->createAsStripeCustomer([
				'metadata' => ['user_id' => $user->id],
			]);
		}*/
		event(new Registered($user));
		$cliente = Cliente::find($request->cliente_id);
		if ($cliente->registro) {
			$elCodigo = $cliente->id . '-1-' . $user->id . '-' . date('YmdHis');
			/*QR ALEX*/
			QrCode::format('png')
				->size(500)
				->margin(1)
				->color(0, 0, 0)
				->backgroundColor(255, 255, 255)
				/*->merge('/public/images/qr-logo.png', .3)*/
				->errorCorrection('H')
				->generate($elCodigo, public_path('storage/qrregister/' . $elCodigo . '.png'));
			$userQr = UserQr::create([
				'cliente_id' => $cliente->id,
				'user_id' => $user->id,
				'evento_id' => 1,
				'codigo' => $elCodigo,
				'usado'  => 0,
			]);
			/*FIN QR ALEX*/
			if (isset($campos['campos']) && count($campos['campos']) > 0) {
				foreach ($campos['campos'] as $key => $nombre) {
					ClienteUserFieldValue::updateOrCreate([
						'user_id' => $user->id,
						'campo_id' => $key,
					], [
						'valor' => $nombre,
					]);
				}
			}
			try {
				$user->notify(new RegistroCodigo($user, $cliente, $elCodigo));
			} catch (\Exception $e) {
			}
		}
		return view('qr-registro-interno-de-usuario', [
			'cliente' => $cliente,
			'userQr' => $userQr,
			'ver' => 0,
			'user' => $user
		]);
	}
}
