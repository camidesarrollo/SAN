<br>
<br>
<br>
<br>
<br>
<br>
<br>

<table class="table table-striped table-hover" cellspacing="0" id="tabla_alertas_chcc_por_nna">
	<thead>
	<tr>
		<th>Tipos de Alerta Territorial</th>
		<th>Nombre NNA</th>
		<th>RUN</th>
		<th>Edad</th>
		<th>Sexo</th>
		<th>Comuna</th>
		<th>Región</th>
		<th>Sectorialista</th>
		<th>Sector</th>
		<th>Fecha Alerta</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($registros AS $registro)
			<tr>
				<td>{{$registro->ale_chcc_ind}}</td>
				<td>{{$registro->nombre_nna}}</td>
				<td>{{$registro->nna_run_con_formato}}</td>
				<td>{{$registro->per_ani}}</td>
				<td>{{$registro->ale_man_nna_sexo}}</td>
				<td>{{$registro->com_nom}}</td>
				<td>{{$registro->reg_nom}}</td>
				<td>{{$registro->nombre_usuario}}</td>
				<td>{{$registro->sector}}</td>
				<td>{{$registro->ale_chcc_fec_ing}}</td>
			</tr>
		@endforeach
	</tbody>
</table>

