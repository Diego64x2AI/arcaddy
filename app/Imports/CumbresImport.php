<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserQr;
use Illuminate\Support\Facades\Hash;
use App\Models\ClienteUserFieldValue;
use Maatwebsite\Excel\Concerns\ToModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class CumbresImport implements ToModel, WithHeadingRow, WithBatchInserts
{

	private $cliente = null;

	public function __construct($cliente)
	{
		$this->cliente = $cliente;
	}

	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		$user = User::create([
			'name' => $row['nombre'],
			'email' => $row['email'],
			'cliente_id' => $this->cliente->id,
			'password' => Hash::make("cumbre200"),
		]);
		$user->save();
		$user->assignRole('user');
		$elCodigo = $this->cliente->id . '-1-' . $user->id . '-' . date('YmdHis');
		QrCode::format('png')
			->size(500)
			->margin(1)
			->color(0, 0, 0)
			->backgroundColor(255, 255, 255)
			->merge('/public/images/qr-logo.png', .3)
			->errorCorrection('H')
			->generate($elCodigo, public_path('storage/qrregister/' . $elCodigo . '.png'));
		UserQr::create([
			'cliente_id' => $this->cliente->id,
			'user_id' => $user->id,
			'evento_id' => 1,
			'codigo' => $elCodigo,
			'usado'  => 0,
		]);
		ClienteUserFieldValue::updateOrCreate([
			'user_id' => $user->id,
			'campo_id' => 2,
		], [
			'valor' => $row['telefono'],
		]);
		return $user;
	}

	public function batchSize(): int
	{
		return 1;
	}
}
