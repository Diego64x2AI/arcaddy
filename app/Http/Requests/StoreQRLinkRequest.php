<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQRLinkRequest extends FormRequest
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
			'titulo' => 'required|string',
			'slug' => 'required|string',
			'texto' => 'required|string',
			'boton_texto' => 'nullable|sometimes|string',
			'boton_link' => 'nullable|sometimes|string',
			'banners_titulo.*' => 'nullable|string|max:255',
			'banners_link.*' => 'nullable|string',
			'banners_img.*' => 'required|image|mimes:jpeg,png,jpg,gif',
		];
	}
}
