<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Cliente;
use App\Models\GrupoMiembro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
	/**
	 * Display the login view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create(Cliente $cliente, Request $request)
	{
		$lang = strtolower($cliente->idioma);
		if ($lang === NULL) {
			$lang = 'es';
		}
		\Illuminate\Support\Facades\App::setLocale($lang);
		$groupExists = $request->groupExists;
		$email = htmlentities(strip_tags($request->email));
		$grupo = NULL;
		if ($groupExists === 'yes') {
			$gruposIds = GrupoMiembro::where('cliente_id', $cliente->id)->select('grupo_id')->pluck('grupo_id')->toArray();
			if (!empty($gruposIds)) {
				$grupo = GrupoMiembro::whereIn('grupo_id', $gruposIds)->with('grupo')->first()->grupo;
				// dd($grupo);
			}
		}
		return view('auth.login', compact('cliente', 'groupExists', 'email', 'grupo'));
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Cliente $cliente, LoginRequest $request)
	{
		//dd($cliente);
		$request->authenticate();
		$request->session()->regenerate();
		if ($cliente->id !== NULL) {
			if (\Cart::isEmpty() === false) {
				return redirect()->route('carrito');
			}
			return redirect()->route('cliente', ['slug' => $cliente->slug]);
		}
		$cliente = Cliente::find($cliente->id);
		if ($cliente) {
			//auth()->user()->logo = $cliente->logo;
			//dd(auth()->user()->logo);
			// Obtener el usuario actualmente autenticado
			//$user = auth()->user();
			// Agregar un valor personalizado al objeto User en la sesión
			session()->put('logo', $cliente->logo);
			// Obtener el valor personalizado del objeto User desde la sesión
			//$miValor = session()->get('logo');
			// Agregar el valor personalizado al objeto User
			//$user->logo = $miValor;
			//auth()->user()->logo = $miValor;
		}
		//dd(auth()->user()->logo);
		return redirect()->intended(RouteServiceProvider::HOME);
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Cliente $cliente, Request $request)
	{
		Auth::guard('web')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		if ($cliente->id !== NULL) {
			return redirect()->route('cliente', ['slug' => $request->cliente->slug]);
		}
		return redirect('/');
	}
}
