<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClienteProductoDigital;
use Illuminate\Support\Facades\Storage;

class CuponesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.cupones.index', [
			'cupones' => ClienteProductoDigital::paginate(20),
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ClienteProductoDigital  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ClienteProductoDigital $cupon)
	{
		Storage::delete(storage_path("app/public/qrcodes/{$cupon->id}.png"));
		$cupon->delete();
		return redirect()->route('cupones.index')->with('success', 'Cupón eliminado correctamente.');
	}
}
