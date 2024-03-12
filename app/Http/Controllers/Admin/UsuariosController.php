<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\ClienteUserField;
use App\Http\Controllers\Controller;
use App\Imports\CumbresImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class UsuariosController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		return view('dashboard.usuarios.index', [
			'cliente' => $cliente,
			'fields' => ClienteUserField::where('cliente_id', $cliente->id)->where('activo', 1)->get(),
			'usuarios' => User::where('cliente_id', $cliente->id)->get(),
		]);
	}

	public function ajax(Cliente $cliente, Request $request)
	{
		if ($request->ajax()) {
			$fields = ClienteUserField::where('cliente_id', $cliente->id)->where('activo', 1)->get();
			$query = User::where('cliente_id', $cliente->id)->select('id', 'name', 'email', 'nacimiento', 'created_at');
			// busqueda
			setlocale(LC_CTYPE, 'es_ES');
			$q = trim($request->input('search.value', ''));
			$q = mb_convert_encoding($q, 'UTF-8', mb_detect_encoding($q));
			$q2 = preg_replace("/[^A-Za-z0-9 ]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $q));
			// dd($q, $q2);
			if ($q !== '') {
				// raw query where on name
				$query->where(function ($query) use ($q, $q2) {
					$query->where('name', 'LIKE', "%{$q}%")
						->orWhere('name', 'LIKE', "%{$q2}%");
				});
				// raw query where on email
				$query->orWhere(function ($query) use ($q, $q2) {
					$query->where('email', 'LIKE', "%{$q}%")
						->orWhere('email', 'LIKE', "%{$q2}%");
				});
			}
			// dd($query->toSql());
			$data = $query->get();
			// dd($data);
			return DataTables::of($data)
				->addIndexColumn()
				->setRowId('id')
				->addColumn('campo_1', function (User $user) {
					return $user->campos()->where('campo_id', 1)->first()?->valor;
				})
				->addColumn('campo_2', function (User $user) {
					return $user->campos()->where('campo_id', 2)->first()?->valor;
				})
				->addColumn('campo_3', function (User $user) {
					return $user->campos()->where('campo_id', 3)->first()?->valor;
				})
				->addColumn('campo_4', function (User $user) {
					return $user->nacimiento;
				})
				->editColumn('created_at', function (User $user) {
					return $user->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('action', function (User $user) use ($cliente) {
					$actionBtn = '
					<form action="'. route('usuarios.destroy', ['cliente' => $cliente->id, 'user' => $user->id]) .'" method="POST" style="display: inline-block">
						<input type="hidden" name="_token" value="'.csrf_token().'">
						<button type="button" class="delete-item text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
					</form>';
					return $actionBtn;
				})
				->rawColumns(['action'])
				->make(true);
		}
	}

	public function destroy(Cliente $cliente, User $user)
	{
		$user->delete();
		return redirect()->route('usuarios.index', $cliente->id)->with('success', 'Usuario eliminado correctamente');
	}

	public function export(Cliente $cliente)
	{
		// dd($cliente);
		return Excel::download(new UsersExport($cliente), 'usuarios.xlsx');
	}

	public function import(Cliente $cliente)
	{
		// dd($cliente);
		Excel::import(new CumbresImport($cliente), base_path('cumbres.xlsx'));
	}
}
