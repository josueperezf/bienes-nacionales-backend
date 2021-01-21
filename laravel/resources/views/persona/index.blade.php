<table border="1" align="center" width="100%">
	<thead>
		<tr>
			<th>Cedula</th>
			<th>Apellidos</th>
			<th>Nombres</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($personas as $persona)
			<tr>
				<td>{!! $persona->cedula !!}</td>
				<td>{{ $persona->apellidos  }}</td>
				<td>{{ $persona->nombres  }}</td>
				<td>
				 	 @if($persona->estatus)
				 	 	{{ 'Activo' }}
				 	 @endif()
				</td>
				<td></td>
			</tr>
		@endforeach()
	</tbody>
</table>