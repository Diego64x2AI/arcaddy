<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'idioma' => 'required',
			'show_logo' => 'required|boolean',
			'cliente' => 'required|string|max:255',
			'slug' => 'required|string|max:100|unique:clientes,slug,' . $this->route('cliente')->id,
			'color' => 'required|string|max:55',
			'color_bg' => 'required|string|max:55',
			'color_base' => 'required|string|max:55',
			'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif',
			'sucursales_pin' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif',
			'sucursales_max' => 'nullable|sometimes|numeric|min:0',
			'titulo' => 'nullable|string|max:255',
			'subtitulo' => 'nullable|string|max:255',
			'descripcion' => 'nullable|string',
			'font' => 'nullable|string',
			'font_titulo' => 'nullable|string',
			'size1' => 'nullable|numeric|min:0',
			'size2' => 'nullable|numeric|min:0',
			'size3' => 'nullable|numeric|min:0',
			'negrita' => 'nullable|numeric|min:0',
			'metadescription' => 'nullable|string',
			'fecha' => 'nullable|string|max:255',
			'facebook_live' => 'nullable|string|max:255',
			'facebook' => 'nullable|string|max:255',
			'instagram' => 'nullable|string|max:255',
			'twitter' => 'nullable|string|max:255',
			'tiktok' => 'nullable|string|max:255',
			'whatsapp' => 'nullable|string|max:255',
			'password' => 'nullable|string|max:255',
			'password_titulo' => 'nullable|string|max:255',
			'password_descripcion' => 'nullable|string|max:255',
			'registro_img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif',
			'registro_base' => 'nullable|sometimes|file|mimes:xlsx',
			'registro_descripcion' => 'nullable|string',
			'geo_bloqueo' => 'required|integer',
			'geo_codes' => 'nullable|string',
			'campos.*' => 'required|string|max:255',
			'flotantes_icono.*' => 'nullable|string',
			'flotantes_texto.*' => 'nullable|string',
			'flotantes_target.*' => 'required|string|max:255',
			'flotantes_link.*' => 'required|string|max:255',
			'flotantes_color.*' => 'required|string|max:255',
			'flotantes_posicion.*' => 'required|string|max:255',
			'menu_cat_nombre.*' => 'required|string|max:255',
			'menu_item_img.*.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'menu_item_old.*.*' => 'nullable|string',
			'menu_item_nombre.*.*' => 'required|string',
			'menu_item_size.*.*' => 'required|string|in:800x800,800x600,600x800',
			'menu_item_id.*.*' => 'required|numeric|min:0',
			'menu_item_cantidad.*.*' => 'nullable|string',
			'menu_item_precio.*.*' => 'nullable|string',
			'menu_item_boton_titulo.*.*' => 'nullable|string',
			'menu_item_boton_link.*.*' => 'nullable|string',
			'menu_item_canje_texto.*.*' => 'nullable|string',
			'menu_item_descripcion.*.*' => 'nullable|string',
			'banners_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'banners_titulo.*' => 'nullable|string|max:255',
			'banners_link.*' => 'nullable|string',
			'banners_sucursales.*' => 'nullable|sometimes',
			'marco_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'marco_titulo.*' => 'nullable|string|max:255',
			'marco_id.*' => 'required|numeric|min:0',
			'banners2_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'banners2_titulo.*' => 'nullable|string|max:255',
			'banners2_link.*' => 'nullable|string',
			'colaboradores_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'colaboradores_titulo.*' => 'nullable|string|max:255',
			'colaboradores_talento.*' => 'nullable|string|max:255',
			'colaboradores_descripcion.*' => 'nullable|string',
			'secciones.*' => 'required|string',
			'patrocinadores_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'patrocinadores_titulo.*' => 'nullable|string|max:255',
			'patrocinadores_link.*' => 'nullable|string',
			'galeria_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'galeria_titulo.*' => 'nullable|string|max:255',
			'libres_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'libres_titulo.*' => 'nullable|string|max:255',
			'libres_link.*' => 'nullable|string',
			'blog_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'blog_titulo.*' => 'nullable|string|max:255',
			'blog_link.*' => 'nullable|string|max:255',
			'blog_descripcion.*' => 'nullable|string',
			'playlist_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'playlist_plataforma.*' => 'nullable|string|max:255',
			'playlist_link.*' => 'nullable|string|max:255',
			'experiencia_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
			'experiencia_titulo.*' => 'nullable|string|max:255',
			'experiencia_link.*' => 'nullable|string|max:255',
			'experiencia_instrucciones.*' => 'nullable|string',
			'experiencia_btn.*' => 'nullable|string|max:100',
			'cartelera_cat_nombre.*' => 'required|string|max:255',
			'cartelera_item_titulo.*' => 'required',
			'cartelera_item_img.*.*' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif',
			'cartelera_item_old.*.*' => 'nullable|sometimes',
			'cartelera_item_expositor.*.*' => 'nullable',
			'cartelera_item_hora.*.*' => 'nullable',
			'cartelera_item_fecha.*.*' => 'nullable',
			'cartelera_item_lugar.*.*' => 'nullable',
			'cartelera_item_descripcion.*.*' => 'nullable',
			'cartelera_item_inter.*.*' => 'nullable|sometimes',
		];
	}
}
