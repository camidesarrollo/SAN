<br>
<br>
<br>
<br>
<br>
<br>
<br>

<table class="table table-striped table-hover" cellspacing="0" id="tabla_alertas_territoriales_por_nna">
	<thead>
	<tr>
		<th>R.U.N</th>
		<th>Alerta Territorial</th>
		<th>Estado Alerta</th>
		<th>Usuario de Creación</th>
		<th>Fecha Creación</th>
		<th>Caso</th>
		<th>Estado Caso</th>
		<th>En Nómina</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($registros AS $registro)
			<tr>
				<td>{{$registro->rut_completo}}</td>
				<td>{{$registro->ale_tip_nom}}</td>
				<td>{{$registro->est_ale_nom}}</td>
				<td>{{$registro->usuario}}</td>
				<td>{{$registro->ale_man_fec}}</td>
				@if ($registro->cas_id == null)
				<td>Sin Caso</td>
				@else
				<td>{{$registro->cas_id}}</td>
				@endif
				@if ($registro->est_cas_nom == null)
				<td>Sin Estado</td>
				@else
				<td>{{$registro->est_cas_nom}}</td>
				@endif
				@if ($registro->run == null)
				<td>NO</td>
				@else
				<td>NO</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

