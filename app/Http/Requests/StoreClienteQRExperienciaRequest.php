<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteQRExperienciaRequest extends FormRequest
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
			'titulo' => 'required|string|max:255',
			'url' => 'required|url|string|max:255',
			'tipo' => 'required|string|in:video,imagen,link',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		];
	}
}
