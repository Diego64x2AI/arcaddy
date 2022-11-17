<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Notifications\Welcome;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\ClienteUserFieldValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RegistroCodigo;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
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
		return view('auth.register', compact('cliente'));
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
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'cliente_id' => $request->cliente_id,
			'password' => Hash::make($request->password),
		]);
		$user->assignRole('user');
		if (!$user->hasStripeId()) {
			$user->createAsStripeCustomer([
				'metadata' => ['user_id' => $user->id],
			]);
		}
		event(new Registered($user));
		Auth::login($user);

		$cliente = Cliente::find($request->cliente_id);
		if ($cliente->registro) {
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
				$user->notify(new RegistroCodigo($user, $cliente));
				return redirect()->route('registro', ['cliente' => $request->cliente_id]);
			} catch(\Exception $e) {
				return redirect()->route('registro', ['cliente' => $request->cliente_id]);
			}
		} else {
			try {
				$user->notify(new Welcome($user));
			} catch(\Exception $e) {

			}
		}
		// dd($campos['campos']);
		return (\Cart::isEmpty()) ? redirect()->route('cliente', ['slug' => $cliente->slug]) : redirect()->route('carrito');
	}
}
