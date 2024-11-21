<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRealidadAumentadaRequest extends FormRequest
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
			'descripcion' => 'nullable|sometimes|string',
			'imagen' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif',
			'glb' => 'nullable|sometimes|file',
			'usdz' => 'nullable|sometimes|file',
		];
	}
}
