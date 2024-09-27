<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteSucursalRequest extends FormRequest
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
			'nombre' => 'required|string|max:255',
			'telefono' => 'required|string|max:15',
			'direccion' => 'required|string|max:255',
			'ciudad' => 'required|string|max:100',
			'horario' => 'nullable|sometimes|string|max:100',
			'link_titulo' => 'nullable|sometimes|string|max:255',
			'link' => 'nullable|sometimes|string|max:255',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		];
	}
}
