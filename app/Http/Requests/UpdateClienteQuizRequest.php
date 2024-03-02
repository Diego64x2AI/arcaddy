<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteQuizRequest extends FormRequest
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
			'tipo.*' => 'required|string|in:multi,like,open,option,level,versus',
			'pregunta.*' => 'required|string',
			'valor.*' => 'required|numeric',
			'iconos.*' => 'nullable|sometimes',
			'like-text.*' => 'required_if:tipo.*,like',
			'dislike-text.*' => 'required_if:tipo.*,like',
			'like-correcta.*' => 'required_if:tipo.*,like|in:1,2|numeric',
			'level-low.*' => 'required_if:tipo.*,level',
			'level-high.*' => 'required_if:tipo.*,level',
			'versus1-text.*' => 'required_if:tipo.*,versus',
			'versus2-text.*' => 'required_if:tipo.*,versus',
			'versus-correcta.*' => 'required_if:tipo.*,versus|in:1,2|numeric',
			'correcta.*' => 'required_if:tipo.*,option|numeric',
			'respuesta.*.*' => 'required_if:tipo.*,option',
			'correcta2.*' => 'required_if:tipo.*,multi|array',
			'respuesta2.*.*' => 'required_if:tipo.*,multi',
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array<string, mixed>
	 */
	public function messages()
	{
		return [
			'tipo.*.required' => 'El tipo de pregunta es requerido.',
			'tipo.*.in' => 'El tipo de pregunta no es válido.',
			'like-text.*.required_if' => 'El texto de la opción LIKE es requerido.',
			'dislike-text.*.required_if' => 'El texto de la opción dislike es requerido.',
			'like-correcta.*.required_if' => 'La opción correcta es requerida.',
			'level-low.*.required_if' => 'El valor bajo es requerido.',
			'level-high.*.required_if' => 'El valor alto es requerido.',
			'versus1-text.*.required_if' => 'El texto de la opción 1 es requerido.',
			'versus2-text.*.required_if' => 'El texto de la opción 2 es requerido.',
			'versus-correcta.*.required_if' => 'La opción correcta es requerida.',
			'correcta.*.required_if' => 'La opción correcta es requerida.',
			'respuesta.*.*.required_if' => 'El texto de la respuesta es requerido.',
			'correcta2.*.required_if' => 'La opción correcta es requerida.',
			'respuesta2.*.*.required_if' => 'El texto de la respuesta es requerido.',
		];
	}
}
