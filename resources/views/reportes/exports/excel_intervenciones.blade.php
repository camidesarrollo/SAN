<br>
<br>
<br>
<br>
<br>
<br>
<br>

<table class="table table-striped table-hover" cellspacing="0" id="tabla_intervenciones_por_fecha">
	<thead>
	<tr>
		<th style="text-align: center;">R.U.N</th>
		<th style="text-align: center;">Caso</th>
		<th style="text-align: center;">Comuna</th>
		<th style="text-align: center;">Estado Caso</th>
		<th style="text-align: center;">Gestor</th>
		<th style="text-align: center;">Objetivos</th>
		<th style="text-align: center;">Tarea</th>
		<th style="text-align: center;">Estado Tarea</th>
		<th style="text-align: center;">Fecha Sesión</th>
		<th style="text-align: center;">Comentario</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($registros AS $registro)
			<tr>
				<td>{{$registro->rut_completo}}</td>
				<td>{{$registro->cas_id}}</td>
				<td>{{$registro->com_nom}}</td>
				<td>{{$registro->est_cas_nom}}</td>
				<td>{{$registro->nombres}} {{$registro->apellido_paterno}}</td>
				<td>{{$registro->obj_nom}}</td>
				<td>{{$registro->tar_descripcion}}</td>
				<td>{{$registro->est_tar_nom}}</td>
				<td>{{$registro->fecha}}</td>
				<td>{{$registro->comentario}}</td>
			</tr>
		@endforeach
	</tbody>
</table>

