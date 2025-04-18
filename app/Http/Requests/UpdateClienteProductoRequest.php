<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteProductoRequest extends FormRequest
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
			'cliente' => 'required|numeric|min:1|exists:clientes,id',
			'precio' => 'required|numeric',
			'digital' => 'sometimes',
			'descuento' => 'required|numeric|min:0|max:100',
			'nombre' => 'required|string|max:255',
			'sku' => 'required|string|max:255',
			'descripcion' => 'required|string',
			'banners_img.*' => 'required|image|mimes:jpeg,png,jpg',
			'banners_titulo.*' => 'required|string|max:255',
			'cantidad' => 'required|numeric',
		];
	}
}
