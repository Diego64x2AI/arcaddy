<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\ClienteMarcoGaleria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteMarcoGaleriaRequest;
use App\Http\Requests\UpdateClienteMarcoGaleriaRequest;
use App\Models\UserBeneficio;

class MarcoGaleriaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente, Request $request)
	{
		$compartida = $request->filled('compartida') ? $request->boolean('compartida') : false;
		//dd($compartida);
		return view('dashboard.marcos-galerias.index', compact('cliente', 'compartida'));
	}

	/**
	 * Create a zip file with all images from a client
	 * @param  \App\Models\Cliente  $cliente
	 */
	public function zip(Cliente $cliente)
	{
		$files = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->get();
		$zip = new \ZipArchive();
		$zipFileName = 'galeria-'.$cliente->slug.'.zip';
		$zipFilePath = storage_path('app/public/'.$zipFileName);
		if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
			foreach ($files as $file) {
				$zip->addFile(storage_path('app/public/'.$file->archivo), $file->archivo);
			}
			$zip->close();
		}
		return response()->download($zipFilePath)->deleteFileAfterSend(true);
	}

	/**
	 * Delete all images from a client
	 * @param  \App\Models\Cliente  $cliente
	 */
	public function delete_all(Cliente $cliente)
	{
		$files = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->get();
		foreach ($files as $file) {
			Storage::delete($file->archivo);
			$file->delete();
		}
		return redirect()->route('cliente.galerias.index', ['cliente' => $cliente->id])->with('success', 'Imágenes eliminadas correctamente.');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteMarcoGaleriaRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreClienteMarcoGaleriaRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ClienteMarcoGaleria  $clienteMarcoGaleria
	 * @return \Illuminate\Http\Response
	 */
	public function show(ClienteMarcoGaleria $clienteMarcoGaleria)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ClienteMarcoGaleria  $clienteMarcoGaleria
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ClienteMarcoGaleria $clienteMarcoGaleria)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteMarcoGaleriaRequest  $request
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteMarcoGaleria  $galeria
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateClienteMarcoGaleriaRequest $request, Cliente $cliente, ClienteMarcoGaleria $galeria)
	{
		if ($request->filled('aprobada')) {
			$galeria->update(['aprobada' => $request->boolean('aprobada')]);
		}
		return response()->json([
			'result' => true,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteMarcoGaleria  $galeria
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, ClienteMarcoGaleria $galeria)
	{
		// delete from storage
		Storage::delete($galeria->archivo);
		$galeria->delete();
		return redirect()->route('cliente.galerias.index', ['cliente' => $cliente->id])->with('success', 'Imagen eliminada correctamente.');
	}

	public function beneficio(Cliente $cliente, User $user)
	{
		UserBeneficio::create([
			'user_id' => $user->id,
			'cliente_id' => $cliente->id,
		]);
		return redirect()->route('cliente.galerias.index', ['cliente' => $cliente->id])->with('success', 'Beneficio regalado correctamente.');
	}

	public function ajax(Cliente $cliente, Request $request)
	{
		$compartida = $request->filled('compartida') ? $request->boolean('compartida') : false;
		if ($request->ajax()) {
			$query = ClienteMarcoGaleria::where('cliente_id', $cliente->id)
			->has('user');
			$query->where('compartida', $compartida);
			$data = $query->get();
			// dd($data);
			return DataTables::of($data)
				->addIndexColumn()
				->setRowId('id')
				->editColumn('archivo', function (ClienteMarcoGaleria $galeria) {
					return '<a href="'.asset('storage/'.$galeria->archivo).'" target="_blank"><img src="'.asset('storage/'.$galeria->archivo).'" class="w-full h-auto inline-block" style="max-width: 3rem;"></a>';
				})
				->editColumn('aprobada', function (ClienteMarcoGaleria $galeria) {
					$checked = $galeria->aprobada ? ' checked' : '';
					return '<label for="aprobada_'.$galeria->id.'" class="flex flex-row items-center cursor-pointer">
					<div class="relative mx-auto">
						<input id="aprobada_'.$galeria->id.'" name="aprobada_'.$galeria->id.'" data-id="'.$galeria->id.'" data-campo="aprobada" type="checkbox" class="update-aprobada sr-only"'.$checked.' />
						<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
						<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
					</div>
				</label>';
				})
				->editColumn('user_id', function (ClienteMarcoGaleria $galeria) {
					return $galeria->user_id !== NULL ? "{$galeria->user->name}#{$galeria->user->id}" : '';
				})
				->addColumn('action', function (ClienteMarcoGaleria $galeria) use ($cliente) {
					// <a href="'. route('usuarios.edit', ['cliente' => $cliente->id, 'user' => $user->id]) .'" class="text-sky-500"><i class="fas fa-edit"></i></a>
					$actionBtn = '
					<a href="'. route('cliente.galerias.beneficio', ['cliente' => $cliente->id, 'user' => $galeria->user->id]) .'" class="text-sky-500 regalar-beneficio"><i class="fas fa-gift"></i></a>
					<form action="'. route('cliente.galerias.destroy', ['cliente' => $cliente->id, 'galeria' => $galeria->id]) .'" method="POST" style="display: inline-block">
						<input type="hidden" name="_token" value="'.csrf_token().'">
						<input type="hidden" name="_method" value="DELETE">
						<button type="button" class="delete-item text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
					</form>';
					return $actionBtn;
				})
				->rawColumns(['action', 'archivo', 'aprobada'])
				->make(true);
		}
	}
}
