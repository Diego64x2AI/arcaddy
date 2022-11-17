<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cliente;
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
	public function create(Cliente $cliente)
	{
		// dd($cliente);
		return view('auth.login', compact('cliente'));
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Cliente $cliente, LoginRequest $request)
	{
		// dd($cliente);
		$request->authenticate();
		$request->session()->regenerate();
		if ($cliente->id !== NULL) {
			if (\Cart::isEmpty() === false) {
				return redirect()->route('carrito');
			}
			return redirect()->route('cliente', ['slug' => $cliente->slug]);
		}
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
