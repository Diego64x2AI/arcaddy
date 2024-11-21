<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campos;
use App\Models\Cliente;
use App\Models\ClienteBlog;
use App\Models\ClienteMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClienteBanner;
use App\Models\ClienteLibres;
use App\Models\ClienteBanner2;
use App\Models\ClienteGaleria;
use App\Models\ClienteFlotante;
use App\Models\ClientePlaylist;
use App\Models\ClienteSecciones;
use App\Models\ClienteUserField;
use App\Models\ClienteExperiencia;
use App\Http\Controllers\Controller;
use App\Models\ClienteColaboradores;
use Illuminate\Support\Facades\File;
use App\Models\ClientePatrocinadores;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\ClienteBannerSucursal;
use App\Models\ClienteCartelera;
use App\Models\ClienteMarco;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ClienteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.clientes.index', [
			'clientes' => Cliente::paginate(50),
			'q' => '',
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$cliente = new Cliente();
		$cliente->registro_base = false;
		return view('dashboard.clientes.create', [
			'cliente' => $cliente,
			'campos' => Campos::all(),
		]);
	}

	public function search(Request $request)
	{
		$data = $request->validate([
			'q' => 'required|string|min:3',
		]);
		$clientes = Cliente::where("cliente", "like", "%{$data['q']}%")->OrWhere("slug", "like", "%{$data['q']}%")->paginate(50);
		return view('dashboard.clientes.index', [
			'clientes' => $clientes,
			'q' => $data['q'],
		]);
	}

	public function crop(Request $request)
	{
		$data = $request->validate([
			'croppedImage' => 'required|image',
			'id' => 'required|integer',
			'tipo' => 'required|string',
		]);
		if ($data['tipo'] === 'banners') {
			ClienteBanner::where('id', $data['id'])->update([
				'archivo' => $data['croppedImage']->store('clientes/banners', 'public'),
			]);
			return response()->json([
				'status' => true,
				'message' => 'Imagen recortada correctamente.',
			]);
		}
		return response()->json([
			'status' => false,
			'message' => 'No se pudo recortar la imagen, el tipo no es soportado.',
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreClienteRequest $request)
	{
		$campos = $request->validated();
		unset($campos['logo'], $campos['registro_img'], $campos['imagen_background']);
		$campos['slug'] = Str::slug($campos['slug']);
		$campos['logo'] = $request->file('logo')->store('clientes/images', 'public');
		$campos['registro'] = $request->boolean('registro');
		$campos['login_bloqueo'] = $request->boolean('login_bloqueo');
		$campos['btn_registro_en_login'] = $request->boolean('btn_registro_en_login');
		$campos['registro_sucursal'] = $request->boolean('registro_sucursal');
		$campos['sucursales_mapa'] = $request->boolean('sucursales_mapa');
		if ($request->hasFile('registro_img')) {
			$campos['registro_img'] = $request->file('registro_img')->store('clientes/images', 'public');
		}
		if ($request->hasFile('imagen_background')) {
			$campos['imagen_background'] = $request->file('imagen_background')->store('clientes/images', 'public');
		}
		if ($request->hasFile('sucursales_pin')) {
			$campos['sucursales_pin'] = $request->file('sucursales_pin')->store('clientes/pin', 'public');
		}
		// dd($campos);
		$cliente = Cliente::create($campos);
		// secciones orden
		if (isset($campos['secciones']) && count($campos['secciones']) > 0) {
			foreach ($campos['secciones'] as $key => $seccion) {
				ClienteSecciones::updateOrCreate(
					[
						'cliente_id' => $cliente->id,
						'seccion' => $seccion,
					],
					[
						'orden' => $key,
						'titulo' => $request->input("titulos.{$seccion}"),
						'activa' => $request->boolean($seccion . '-activo'),
						'mostrar_titulo' => $request->boolean($seccion . '-activo2'),
						'login' => $request->boolean($seccion . '-login'),
						'random' => $request->boolean($seccion . '-random'),
						'timer' => isset($campos[$seccion . '-timer']) ? $campos[$seccion . '-timer'] : 0,
					]
				);
			}
		}
		// flotantes
		if (isset($campos['flotantes_texto']) && count($campos['flotantes_texto']) > 0) {
			ClienteFlotante::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['flotantes_texto'] as $key => $texto) {
				ClienteFlotante::insert([
					'cliente_id' => $cliente->id,
					'texto' => $texto,
					'link' => $campos['flotantes_link'][$key],
					'icono' => $campos['flotantes_icono'][$key],
					'color' => $campos['flotantes_color'][$key],
					'posicion' => $campos['flotantes_posicion'][$key],
					'target' => $campos['flotantes_target'][$key],
				]);
			}
		}
		// cartelera
		if (isset($campos['cartelera_cat_nombre']) && count($campos['cartelera_cat_nombre']) > 0) {
			// ClienteBanner::where('cliente_id', $cliente->id)->delete();
			ClienteCartelera::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['cartelera_cat_nombre'] as $key => $categoria_nombre) {
				$categoria_nombre = strtolower($categoria_nombre);
				foreach ($campos['cartelera_item_titulo'][$key] as $key2 => $nombre) {
					$archivo = NULL;
					// archivo viejo
					if ($request->filled('cartelera_item_old.'.$key.'.'.$key2)) {
						$archivo = $request->input('cartelera_item_old.'.$key.'.'.$key2);
					}
					if ($request->hasFile('cartelera_item_img.'.$key.'.'.$key2) && $request->file('cartelera_item_img.'.$key.'.'.$key2)->isValid()) {
						$archivo = $request->file('cartelera_item_img.'.$key.'.'.$key2)->store('clientes/cartelera', 'public');
					}
					ClienteCartelera::insert([
						'cliente_id' => $cliente->id,
						'categoria' => $categoria_nombre,
						'archivo' => $archivo,
						'titulo' => $nombre,
						'expositor' => $campos['cartelera_item_expositor'][$key][$key2],
						'descripcion' => $campos['cartelera_item_descripcion'][$key][$key2],
						'hora' => $campos['cartelera_item_hora'][$key][$key2],
						'fecha' => $campos['cartelera_item_fecha'][$key][$key2],
						'lugar' => $campos['cartelera_item_lugar'][$key][$key2],
						'inter' => $request->boolean('cartelera_item_inter.'.$key.'.'.$key2),
					]);
				}
			}
		}
		// menu
		if (isset($campos['menu_cat_nombre']) && count($campos['menu_cat_nombre']) > 0) {
			// ClienteBanner::where('cliente_id', $cliente->id)->delete();
			ClienteMenu::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['menu_cat_nombre'] as $key => $categoria_nombre) {
				$categoria_nombre = strtolower($categoria_nombre);
				foreach ($campos['menu_item_nombre'][$key] as $key2 => $nombre) {
					$archivo = NULL;
					// archivo viejo
					if ($request->filled('menu_item_old.'.$key.'.'.$key2)) {
						$archivo = $request->input('menu_item_old.'.$key.'.'.$key2);
					}
					if ($request->hasFile('menu_item_img.'.$key.'.'.$key2) && $request->file('menu_item_img.'.$key.'.'.$key2)->isValid()) {
						$archivo = $request->file('menu_item_img.'.$key.'.'.$key2)->store('clientes/menu', 'public');
					}
					ClienteMenu::insert([
						'cliente_id' => $cliente->id,
						'archivo' => $archivo,
						'nombre' => $nombre,
						'cantidad' => $campos['menu_item_cantidad'][$key][$key2],
						'precio' => $campos['menu_item_precio'][$key][$key2],
						'categoria' => $categoria_nombre,
						'boton_titulo' => $campos['menu_item_boton_titulo'][$key][$key2],
						'boton_link' => $campos['menu_item_boton_link'][$key][$key2],
						'canje_texto' => $campos['menu_item_canje_texto'][$key][$key2],
						'descripcion' => $campos['menu_item_descripcion'][$key][$key2],
					]);
				}
			}
		}
		// Marcos
		if (isset($campos['marco_id']) && count($campos['marco_id']) > 0) {
			// delete marco if not in the list
			$marcos = ClienteMarco::whereNotIn('id', $campos['marco_id'])->where('cliente_id', $cliente->id)->get();
			// walk the list and delete local files
			foreach ($marcos as $marco) {
				Storage::delete($marco->archivo);
				$marco->delete();
			}
			foreach ($campos['marco_id'] as $key => $id) {
				$id = (int) $id;
				$archivo = NULL;
				// archivo viejo
				if ($request->filled('marco_old.' . $key)) {
					$archivo = $request->input('marco_old.' . $key);
				}
				if ($request->hasFile('marco_img.' . $key) && $request->file('marco_img.' . $key)->isValid()) {
					$archivo = $request->file('marco_img.' . $key)->store('clientes/marco', 'public');
				}
				if ($archivo !== NULL) {
					if ($id > 0) {
						$marco = ClienteMarco::findOrFail($id);
						$marco->update([
							'archivo' => $archivo,
							'titulo' => $campos['marco_titulo'][$key],
						]);
					} else {
						ClienteMarco::insert([
							'cliente_id' => $cliente->id,
							'archivo' => $archivo,
							'titulo' => $campos['marco_titulo'][$key],
						]);
					}
				}
			}
		}
		// banners
		if (isset($campos['banners_img']) && count($campos['banners_img']) > 0) {
			ClienteBanner::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners_img'] as $key => $file) {
				ClienteBanner::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/banners', 'public'),
					'titulo' => $campos['banners_titulo'][$key],
					'link' => $campos['banners_link'][$key],
					'activo' => $campos['banners_activo'][$key],
				]);
			}
		}
		// colaboradores
		if (isset($campos['colaboradores_img']) && count($campos['colaboradores_img']) > 0) {
			ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['colaboradores_img'] as $key => $file) {
				ClienteColaboradores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/colaboradores', 'public'),
					'nombre' => $campos['colaboradores_titulo'][$key],
					'talento' => $campos['colaboradores_talento'][$key],
					'descripcion' => $campos['colaboradores_descripcion'][$key],
				]);
			}
		}
		// patrocinadores
		if (isset($campos['patrocinadores_img']) && count($campos['patrocinadores_img']) > 0) {
			ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['patrocinadores_img'] as $key => $file) {
				ClientePatrocinadores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/patrocinadores', 'public'),
					'titulo' => $campos['patrocinadores_titulo'][$key],
					'link' => $campos['patrocinadores_link'][$key],
				]);
			}
		}
		// galeria
		if (isset($campos['galeria_img']) && count($campos['galeria_img']) > 0) {
			ClienteGaleria::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['galeria_img'] as $key => $file) {
				ClienteGaleria::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/galeria', 'public'),
					'titulo' => $campos['galeria_titulo'][$key],
				]);
			}
		}
		// libres
		if (isset($campos['libres_img']) && count($campos['libres_img']) > 0) {
			ClienteLibres::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['libres_img'] as $key => $file) {
				ClienteLibres::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/libres', 'public'),
					'titulo' => $campos['libres_titulo'][$key],
					'link' => $campos['libres_link'][$key],
				]);
			}
		}
		// blog
		if (isset($campos['blog_img']) && count($campos['blog_img']) > 0) {
			ClienteBlog::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['blog_img'] as $key => $file) {
				ClienteBlog::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/blog', 'public'),
					'titulo' => $campos['blog_titulo'][$key],
					'link' => $campos['blog_link'][$key],
					'descripcion' => $campos['blog_descripcion'][$key],
				]);
			}
		}
		// playlist
		if (isset($campos['playlist_img']) && count($campos['playlist_img']) > 0) {
			ClientePlaylist::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['playlist_img'] as $key => $file) {
				ClientePlaylist::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/playlist', 'public'),
					'plataforma' => $campos['playlist_plataforma'][$key],
					'link' => $campos['playlist_link'][$key],
				]);
			}
		}
		// experiencia
		if (isset($campos['experiencia_img']) && count($campos['experiencia_img']) > 0) {
			ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['experiencia_img'] as $key => $file) {
				ClienteExperiencia::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/experiencias', 'public'),
					'titulo' => $campos['experiencia_titulo'][$key],
					'link' => $campos['experiencia_link'][$key],
					'descripcion' => $campos['experiencia_instrucciones'][$key],
					'texto_boton' => $campos['experiencia_btn'][$key],
				]);
			}
		}
		if (!is_dir(storage_path('app/public/qrcodes'))) {
			File::makeDirectory(storage_path('app/public/qrcodes'));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug, storage_path('app/public/qrcodes/' . $cliente->slug . '.png'));
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/register/' . $cliente->id, storage_path('app/public/qrcodes/' . $cliente->slug . '_registro.png'));
		// dd($campos);
		return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente)
	{
		$cliente->registro_base = Storage::disk('local')->exists("registro/{$cliente->id}.xlsx");
		// dd($cliente);
		return view('dashboard.clientes.create', [
			'cliente' => $cliente,
			'campos' => Campos::all(),
		]);
	}

	public function registrodb_delete(Cliente $cliente)
	{
		if (Storage::disk('local')->exists("registro/{$cliente->id}.xlsx")) {
			Storage::disk('local')->delete("registro/{$cliente->id}.xlsx");
		}
		return redirect()->back()->with('success', 'Base de datos eliminada correctamente.');
	}

	public function upload_editor(Request $request)
	{
		$request->validate([
			'file' => 'required|file',
		]);
		$filename = $request->file('file')->store('clientes/editor', 'public');
		return response()->json([
			'location' => url("storage/{$filename}"),
			'title' => $request->file('file')->getClientOriginalName(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteRequest  $request
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateClienteRequest $request, Cliente $cliente)
	{

		$campos = $request->validated();
		unset($campos['logo'], $campos['registro_img'], $campos['imagen_background'], $campos['registro_base']);
		$campos['slug'] = Str::slug($campos['slug']);
		if ($request->hasFile('logo')) {
			if ($cliente->logo !== NULL) {
				Storage::delete($cliente->logo);
			}
			$campos['logo'] = $request->file('logo')->store('clientes/images', 'public');
		}
		if ($request->hasFile('registro_img')) {
			if ($cliente->registro_img !== NULL) {
				Storage::delete($cliente->registro_img);
			}
			$campos['registro_img'] = $request->file('registro_img')->store('clientes/images', 'public');
		}
		if ($request->hasFile('imagen_background')) {
		  if ($cliente->imagen_background !== NULL) {
				Storage::delete($cliente->imagen_background);
			}
			$campos['imagen_background'] = $request->file('imagen_background')->store('clientes/images', 'public');
		}
		if ($request->hasFile('registro_base')) {
			$request->file('registro_base')->storeAs('registro', "{$cliente->id}.xlsx", 'local');
		}
		if ($request->hasFile('sucursales_pin')) {
			if ($cliente->sucursales_pin !== NULL) {
				Storage::delete($cliente->sucursales_pin);
			}
			$campos['sucursales_pin'] = $request->file('sucursales_pin')->store('clientes/pin', 'public');
		}
		$campos['registro'] = $request->boolean('registro');
		$campos['login_bloqueo'] = $request->boolean('login_bloqueo');
		$campos['btn_registro_en_login'] = $request->boolean('btn_registro_en_login');
		$campos['registro_sucursal'] = $request->boolean('registro_sucursal');
		$campos['sucursales_mapa'] = $request->boolean('sucursales_mapa');
		$cliente->update($campos);
		// secciones orden
		if (isset($campos['secciones']) && count($campos['secciones']) > 0) {
			foreach ($campos['secciones'] as $key => $seccion) {
				ClienteSecciones::updateOrCreate(
					[
						'cliente_id' => $cliente->id,
						'seccion' => $seccion,
					],
					[
						'orden' => $key,
						'titulo' => $request->input("titulos.{$seccion}"),
						'activa' => $request->boolean($seccion . '-activo'),
						'mostrar_titulo' => $request->boolean($seccion . '-activo2'),
						'login' => $request->boolean($seccion . '-login'),
						'random' => $request->boolean($seccion . '-random'),
						'timer' => isset($campos[$seccion . '-timer']) ? $campos[$seccion . '-timer'] : 0,
					]
				);
			}
		}
		// dd($request->all());
		// campos
		if (isset($campos['campos']) && count($campos['campos']) > 0) {
			foreach ($campos['campos'] as $key => $nombre) {
				// echo $key."-".$nombre."-".$request->boolean('campos_activo.'.$key);
				ClienteUserField::updateOrCreate([
					'cliente_id' => $cliente->id,
					'campo_id' => $key,
				], [
					'nombre' => $nombre,
					'activo' => $request->boolean('campos_activo.'.$key),
				]);
			}
		}
		// flotantes
		if (isset($campos['flotantes_texto']) && count($campos['flotantes_texto']) > 0) {
			ClienteFlotante::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['flotantes_texto'] as $key => $texto) {
				ClienteFlotante::insert([
					'cliente_id' => $cliente->id,
					'texto' => $texto,
					'link' => $campos['flotantes_link'][$key],
					'icono' => $campos['flotantes_icono'][$key],
					'color' => $campos['flotantes_color'][$key],
					'posicion' => $campos['flotantes_posicion'][$key],
					'target' => $campos['flotantes_target'][$key],
				]);
			}
		}
		else{
			ClienteFlotante::where('cliente_id', $cliente->id)->delete();
		}
		// menu
		if (isset($campos['menu_cat_nombre']) && count($campos['menu_cat_nombre']) > 0) {
			// dd($campos['menu_item_nombre']);
			ClienteMenu::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['menu_cat_nombre'] as $key => $categoria_nombre) {
				$categoria_nombre = strtolower($categoria_nombre);
				// dd($campos['menu_item_nombre'][$key], $campos['menu_item_nombre'][$key+1]);
				foreach ($campos['menu_item_nombre'][$key] as $key2 => $nombre) {
					$archivo = NULL;
					// archivo viejo
					if ($request->filled('menu_item_old.'.$key.'.'.$key2)) {
						$archivo = $request->input('menu_item_old.'.$key.'.'.$key2);
					}
					if ($request->hasFile('menu_item_img.'.$key.'.'.$key2) && $request->file('menu_item_img.'.$key.'.'.$key2)->isValid()) {
						// $archivo = $request->file('menu_item_img.'.$key.'.'.$key2)->store('clientes/menu', 'public');
						$size = explode('x', $campos['menu_item_size'][$key][$key2]);
						$filename = uniqid() . '.jpg';
						$archivo = $request->file('menu_item_img.'.$key.'.'.$key2)->storeAs('clientes/menu', $filename, 'public');
						// resize image
						$manager = new ImageManager(Driver::class);
						$manager->read('storage/' . $archivo)->resize($size[0], $size[1], function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						})->save('storage/' . $archivo);
					}
					ClienteMenu::insert([
						'cliente_id' => $cliente->id,
						'archivo' => $archivo,
						'nombre' => $nombre,
						'orden' => $key,
						'cantidad' => $campos['menu_item_cantidad'][$key][$key2],
						'precio' => $campos['menu_item_precio'][$key][$key2],
						'categoria' => $categoria_nombre,
						'boton_titulo' => $campos['menu_item_boton_titulo'][$key][$key2],
						'boton_link' => $campos['menu_item_boton_link'][$key][$key2],
						'canje_texto' => $campos['menu_item_canje_texto'][$key][$key2],
						'descripcion' => $campos['menu_item_descripcion'][$key][$key2],
					]);
				}
			}
		}
		// cartelera
		if (isset($campos['cartelera_cat_nombre']) && count($campos['cartelera_cat_nombre']) > 0) {
			ClienteCartelera::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['cartelera_cat_nombre'] as $key => $categoria_nombre) {
				$categoria_nombre = strtolower($categoria_nombre);
				foreach ($campos['cartelera_item_titulo'][$key] as $key2 => $nombre) {
					$archivo = NULL;
					// archivo viejo
					if ($request->filled('cartelera_item_old.'.$key.'.'.$key2)) {
						$archivo = $request->input('cartelera_item_old.'.$key.'.'.$key2);
					}
					if ($request->hasFile('cartelera_item_img.'.$key.'.'.$key2) && $request->file('cartelera_item_img.'.$key.'.'.$key2)->isValid()) {
						$archivo = $request->file('cartelera_item_img.'.$key.'.'.$key2)->store('clientes/cartelera', 'public');
					}
					ClienteCartelera::insert([
						'cliente_id' => $cliente->id,
						'categoria' => $categoria_nombre,
						'archivo' => $archivo,
						'titulo' => $nombre,
						'expositor' => $campos['cartelera_item_expositor'][$key][$key2],
						'descripcion' => $campos['cartelera_item_descripcion'][$key][$key2],
						'hora' => $campos['cartelera_item_hora'][$key][$key2],
						'fecha' => $campos['cartelera_item_fecha'][$key][$key2],
						'lugar' => $campos['cartelera_item_lugar'][$key][$key2],
						'inter' => $request->boolean('cartelera_item_inter.'.$key.'.'.$key2),
					]);
				}
			}
		}
		// Marcos
		if (isset($campos['marco_id']) && count($campos['marco_id']) > 0) {
			// delete marco if not in the list
			$marcos = ClienteMarco::whereNotIn('id', $campos['marco_id'])->where('cliente_id', $cliente->id)->get();
			// walk the list and delete local files
			foreach ($marcos as $marco) {
				Storage::delete($marco->archivo);
				$marco->delete();
			}
			foreach ($campos['marco_id'] as $key => $id) {
				$id = (int) $id;
				// archivo viejo
				if ($request->filled('marco_old.' . $key)) {
					$archivo = $request->input('marco_old.' . $key);
				}
				if ($request->hasFile('marco_img.' . $key) && $request->file('marco_img.' . $key)->isValid()) {
					$archivo = $request->file('marco_img.' . $key)->store('clientes/marco', 'public');
				}
				if ($id > 0) {
					$marco = ClienteMarco::findOrFail($id);
					$marco->update([
						'archivo' => $archivo,
						'titulo' => $campos['marco_titulo'][$key],
					]);
				} else {
					ClienteMarco::insert([
						'cliente_id' => $cliente->id,
						'archivo' => $archivo,
						'titulo' => $campos['marco_titulo'][$key],
					]);
				}
			}
		}
		// banners
		// dd($campos);
		if (isset($campos['banners_titulo']) && count($campos['banners_titulo']) > 0) {
			/*
			foreach ($cliente->banners as $banner) {
				Storage::delete($banner->archivo);
			}
			*/
			ClienteBanner::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('banners_old.' . $key)) {
					$archivo = $request->input('banners_old.' . $key);
				}
				if ($request->hasFile('banners_img.' . $key) && $request->file('banners_img.' . $key)->isValid()) {
					$archivo = $request->file('banners_img.' . $key)->store('clientes/banners', 'public');
				}
				$banner = ClienteBanner::create([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['banners_link'][$key],
					'activo' => $request->boolean('banners_activo.'.$key),
				]);
				$sucursales = isset($campos['banners_sucursales'][$key]) ? $campos['banners_sucursales'][$key] : [];
				foreach ($sucursales as $sucursal) {
					ClienteBannerSucursal::create([
						'banner_id' => $banner->id,
						'sucursal_id' => $sucursal,
					]);
				}
			}
		}
		// dd($campos);
		// banners 2
		if (isset($campos['banners2_titulo']) && count($campos['banners2_titulo']) > 0) {
			/*
			foreach ($cliente->banners2 as $banner) {
				Storage::delete($banner->archivo);
			}
			*/
			ClienteBanner2::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners2_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('banners2_old.' . $key)) {
					$archivo = $request->input('banners2_old.' . $key);
				}
				if ($request->hasFile('banners2_img.' . $key) && $request->file('banners2_img.' . $key)->isValid()) {
					$archivo = $request->file('banners2_img.' . $key)->store('clientes/banners', 'public');
				}
				ClienteBanner2::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['banners2_link'][$key],
				]);
			}
		}
		// colaboradores
		if (isset($campos['colaboradores_titulo']) && count($campos['colaboradores_titulo']) > 0) {
			/*
			foreach ($cliente->colaboradores as $colaborador) {
				Storage::delete($colaborador->archivo);
			}
			*/
			ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['colaboradores_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('colaboradores_old.' . $key)) {
					$archivo = $request->input('colaboradores_old.' . $key);
				}
				if ($request->hasFile('colaboradores_img.' . $key) && $request->file('colaboradores_img.' . $key)->isValid()) {
					$archivo = $request->file('colaboradores_img.' . $key)->store('clientes/colaboradores', 'public');
				}
				ClienteColaboradores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'nombre' => $titulo,
					'talento' => $campos['colaboradores_talento'][$key],
					'descripcion' => $campos['colaboradores_descripcion'][$key],
				]);
			}
		}
		// patrocinadores
		if (isset($campos['patrocinadores_titulo']) && count($campos['patrocinadores_titulo']) > 0) {
			/*
			foreach ($cliente->patrocinadores as $patrocinador) {
				Storage::delete($patrocinador->archivo);
			}
			*/
			ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['patrocinadores_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('patrocinadores_old.' . $key)) {
					$archivo = $request->input('patrocinadores_old.' . $key);
				}
				if ($request->hasFile('patrocinadores_img.' . $key) && $request->file('patrocinadores_img.' . $key)->isValid()) {
					$archivo = $request->file('patrocinadores_img.' . $key)->store('clientes/patrocinadores', 'public');
				}
				ClientePatrocinadores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['patrocinadores_link'][$key],
				]);
			}
		}
		// galeria
		if (isset($campos['galeria_titulo']) && count($campos['galeria_titulo']) > 0) {
			/*
			foreach ($cliente->galeria as $galeria) {
				Storage::delete($galeria->archivo);
			}
			*/
			ClienteGaleria::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['galeria_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('galeria_old.' . $key)) {
					$archivo = $request->input('galeria_old.' . $key);
				}
				if ($request->hasFile('galeria_img.' . $key) && $request->file('galeria_img.' . $key)->isValid()) {
					$archivo = $request->file('galeria_img.' . $key)->store('clientes/galeria', 'public');
				}
				ClienteGaleria::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
				]);
			}
		}
		// libres
		if (isset($campos['libres_titulo']) && count($campos['libres_titulo']) > 0) {
			/*
			foreach ($cliente->libres as $libre) {
				Storage::delete($libre->archivo);
			}
			*/
			ClienteLibres::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['libres_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('libres_old.' . $key)) {
					$archivo = $request->input('libres_old.' . $key);
				}
				if ($request->hasFile('libres_img.' . $key) && $request->file('libres_img.' . $key)->isValid()) {
					$archivo = $request->file('libres_img.' . $key)->store('clientes/libres', 'public');
				}
				ClienteLibres::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['libres_link'][$key],
				]);
			}
		}
		// blog
		if (isset($campos['blog_titulo']) && count($campos['blog_titulo']) > 0) {
			/*
			foreach ($cliente->blog as $blog) {
				Storage::delete($blog->archivo);
			}
			*/
			ClienteBlog::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['blog_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('blog_old.' . $key)) {
					$archivo = $request->input('blog_old.' . $key);
				}
				if ($request->hasFile('blog_img.' . $key) && $request->file('blog_img.' . $key)->isValid()) {
					$archivo = $request->file('blog_img.' . $key)->store('clientes/blog', 'public');
				}
				ClienteBlog::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['blog_link'][$key],
					'descripcion' => $campos['blog_descripcion'][$key],
				]);
			}
		}
		// playlist
		if (isset($campos['playlist_plataforma']) && count($campos['playlist_plataforma']) > 0) {
			/*
			foreach ($cliente->playlist as $playlist) {
				Storage::delete($playlist->archivo);
			}
			*/
			ClientePlaylist::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['playlist_plataforma'] as $key => $plataforma) {
				// archivo viejo
				if ($request->filled('playlist_old.' . $key)) {
					$archivo = $request->input('playlist_old.' . $key);
				}
				if ($request->hasFile('playlist_img.' . $key) && $request->file('playlist_img.' . $key)->isValid()) {
					$archivo = $request->file('playlist_img.' . $key)->store('clientes/playlist', 'public');
				}
				ClientePlaylist::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'plataforma' => $plataforma,
					'link' => $campos['playlist_link'][$key],
				]);
			}
		}
		// experiencia
		if (isset($campos['experiencia_titulo']) && count($campos['experiencia_titulo']) > 0) {
			/*
			foreach ($cliente->experiencias as $experiencia) {
				Storage::delete($experiencia->archivo);
			}
			*/
			ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['experiencia_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('experiencia_old.' . $key)) {
					$archivo = $request->input('experiencia_old.' . $key);
				}
				if ($request->hasFile('experiencia_img.' . $key) && $request->file('experiencia_img.' . $key)->isValid()) {
					$archivo = $request->file('experiencia_img.' . $key)->store('clientes/experiencias', 'public');
				}
				ClienteExperiencia::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $campos['experiencia_link'][$key],
					'descripcion' => $campos['experiencia_instrucciones'][$key],
					'texto_boton' => $campos['experiencia_btn'][$key],
				]);
			}
		}
		if (!is_dir(storage_path('app/public/qrcodes'))) {
			File::makeDirectory(storage_path('app/public/qrcodes'));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug, storage_path('app/public/qrcodes/' . $cliente->slug . '.png'));
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/register/' . $cliente->id, storage_path('app/public/qrcodes/' . $cliente->slug . '_registro.png'));
		return redirect()->back()->with('success', 'Cliente editado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente)
	{
		foreach ($cliente->patrocinadores as $patrocinador) {
			Storage::delete($patrocinador->archivo);
		}
		foreach ($cliente->galeria as $galeria) {
			Storage::delete($galeria->archivo);
		}
		foreach ($cliente->libres as $libre) {
			Storage::delete($libre->archivo);
		}
		foreach ($cliente->blog as $blog) {
			Storage::delete($blog->archivo);
		}
		foreach ($cliente->playlist as $playlist) {
			Storage::delete($playlist->archivo);
		}
		foreach ($cliente->experiencias as $experiencia) {
			Storage::delete($experiencia->archivo);
		}
		foreach ($cliente->banners as $banner) {
			Storage::delete($banner->archivo);
		}
		foreach ($cliente->colaboradores as $colaborador) {
			Storage::delete($colaborador->archivo);
		}
		Storage::delete($cliente->logo);
		ClienteSecciones::where('cliente_id', $cliente->id)->delete();
		ClienteBanner::where('cliente_id', $cliente->id)->delete();
		ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
		ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
		ClienteGaleria::where('cliente_id', $cliente->id)->delete();
		ClienteLibres::where('cliente_id', $cliente->id)->delete();
		ClienteBlog::where('cliente_id', $cliente->id)->delete();
		ClientePlaylist::where('cliente_id', $cliente->id)->delete();
		ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
		$cliente->delete();
		return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
	}
}
