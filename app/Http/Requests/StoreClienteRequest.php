<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
		/*$user = Auth::user();
		return $user->can('cards.create');*/
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
			'slug' => 'required|string|max:100|unique:clientes,slug',
			'color' => 'required|string|max:55',
			'logo' => 'required|image|mimes:jpeg,png,jpg',
			'titulo' => 'nullable|string|max:255',
			'subtitulo' => 'nullable|string|max:255',
			'descripcion' => 'nullable|string',
			'fecha' => 'nullable|string|max:255',
			'facebook_live' => 'nullable|string|max:255',
			'facebook' => 'nullable|string|max:255',
			'instagram' => 'nullable|string|max:255',
			'twitter' => 'nullable|string|max:255',
			'banners_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'banners_titulo.*' => 'required|string|max:255',
			'colaboradores_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'colaboradores_titulo.*' => 'nullable|string|max:255',
			'colaboradores_talento.*' => 'nullable|string|max:255',
			'colaboradores_descripcion.*' => 'nullable|string',
			'secciones.*' => 'required|string',
			'patrocinadores_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'patrocinadores_titulo.*' => 'required|string|max:255',
			'galeria_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'galeria_titulo.*' => 'required|string|max:255',
			'libres_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'libres_titulo.*' => 'required|string|max:255',
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
