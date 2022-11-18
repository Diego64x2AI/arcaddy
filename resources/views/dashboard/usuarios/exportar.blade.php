<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
	<thead class="text-white">
		<tr class="bg-teal-400">
			<th style="font-weight: bold; text-align: center;">ID</th>
			<th style="font-weight: bold; text-align: center;">Nombre</th>
			<th style="font-weight: bold; text-align: center;">Email</th>
			@foreach ($fields as $field)
			<th style="font-weight: bold; text-align: center;">{{ $field->nombre }}</th>
			@endforeach
			<th style="font-weight: bold; text-align: center;">Fecha de registro</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($usuarios as $usuario)
		<tr>
			<td style="text-align: center;">{{ $usuario->id }}</td>
			<td style="text-align: center; width: 250px;">{{ $usuario->name }}</td>
			<td style="text-align: center; width: 250px;">{{ $usuario->email }}</td>
			@foreach ($fields as $field)
			<td style="text-align: center; width: 250px;">{{ $usuario->campos()->where('campo_id', $field->id)->first()->valor }}</td>
			@endforeach
			<td style="text-align: center; width: 250px;">{{ $usuario->created_at }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
