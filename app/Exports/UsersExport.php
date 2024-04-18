<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ClienteUserField;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromView, ShouldAutoSize
{

	private $cliente = null;

	public function __construct($cliente)
	{
		$this->cliente = $cliente;
	}

	public function view(): View
	{
		return view('dashboard.usuarios.exportar', [
			'cliente' => $this->cliente,
			'fields' => ClienteUserField::where('cliente_id', $this->cliente->id)->where('activo', 1)->get(),
			'usuarios' => User::with(['qr'])->where('cliente_id', $this->cliente->id)->get(),
		]);
	}
}
