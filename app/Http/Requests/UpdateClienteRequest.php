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
			'cliente' => 'required|string|max:255',
			'slug' => 'required|string|max:100|unique:clientes,slug,'.$this->route('cliente')->id,
			'color' => 'required|string|max:55',
			'color_bg' => 'required|string|max:55',
			'color_base' => 'required|string|max:55',
			'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg',
			'titulo' => 'nullable|string|max:255',
			'subtitulo' => 'nullable|string|max:255',
			'descripcion' => 'nullable|string',
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
			'registro_img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg',
			'registro_descripcion' => 'nullable|string',
			'geo_bloqueo' => 'required|integer',
			'geo_codes' => 'nullable|string',
			'flotantes_icono.*' => 'nullable|string',
			'flotantes_texto.*' => 'nullable|string',
			'flotantes_target.*' => 'required|string|max:255',
			'flotantes_link.*' => 'required|string|max:255',
			'flotantes_color.*' => 'required|string|max:255',
			'flotantes_posicion.*' => 'required|string|max:255',
			'menu_cat_nombre.*' => 'required|string|max:255',
			'menu_item_img.*.*' => 'required|image|mimes:jpeg,png,jpg',
			'menu_item_old.*.*' => 'nullable|string',
			'menu_item_nombre.*.*' => 'required|string',
			'menu_item_cantidad.*.*' => 'nullable|string',
			'menu_item_precio.*.*' => 'nullable|string',
			'menu_item_boton_titulo.*.*' => 'nullable|string',
			'menu_item_boton_link.*.*' => 'nullable|string',
			'menu_item_canje_texto.*.*' => 'nullable|string',
			'menu_item_descripcion.*.*' => 'nullable|string',
			'banners_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'banners_titulo.*' => 'required|string|max:255',
			'banners_link.*' => 'nullable|string',
			'banners2_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'banners2_titulo.*' => 'required|string|max:255',
			'banners2_link.*' => 'nullable|string',
			'colaboradores_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'colaboradores_titulo.*' => 'nullable|string|max:255',
			'colaboradores_talento.*' => 'nullable|string|max:255',
			'colaboradores_descripcion.*' => 'nullable|string',
			'secciones.*' => 'required|string',
			'patrocinadores_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'patrocinadores_titulo.*' => 'required|string|max:255',
			'patrocinadores_link.*' => 'nullable|string',
			'galeria_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'galeria_titulo.*' => 'required|string|max:255',
			'libres_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'libres_titulo.*' => 'required|string|max:255',
			'libres_link.*' => 'nullable|string',
			'blog_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'blog_titulo.*' => 'nullable|string|max:255',
			'blog_link.*' => 'nullable|string|max:255',
			'blog_descripcion.*' => 'nullable|string',
			'playlist_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'playlist_plataforma.*' => 'nullable|string|max:255',
			'playlist_link.*' => 'nullable|string|max:255',
			'experiencia_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'experiencia_titulo.*' => 'nullable|string|max:255',
			'experiencia_link.*' => 'nullable|string|max:255',
			'experiencia_instrucciones.*' => 'nullable|string',
		];
	}
}
