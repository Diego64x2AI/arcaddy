<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVotacionesRequest extends FormRequest
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
			'cliente_id' => 'required|numeric|min:1|exists:clientes,id',
			'nombre' => 'required|string|max:255',
			'votar' => 'sometimes',
			'finalistas' => 'sometimes',
			'activa' => 'sometimes',
		];
	}
}
