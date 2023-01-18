<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\ClienteProductoDigital;
use Illuminate\Support\Facades\Cookie;
use App\Models\VotacionesParticipantes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function votar(Request $request){
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

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cliente($slug = '')
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
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
		return view('cliente', [
			'cliente' => $cliente,
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function zipcode(Cliente $cliente, Request $request)
	{
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
		if (!is_dir(storage_path('app/public/qrcodesr'))) {
			File::makeDirectory(storage_path('app/public/qrcodesr'));
		}
		// dd(storage_path('app/public/'.$cliente->logo)); '/storage/app/public/'.$cliente->logo
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/'.$cliente->slug.'?user='.Auth::user()->id, storage_path('app/public/qrcodesr/' . Auth::user()->id . '.png'));
		return view('registro', [
			'cliente' => $cliente,
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
}
