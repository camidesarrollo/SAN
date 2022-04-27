<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="table table-striped table-hover" cellspacing="0" id="tabla_desestimacion_caso_terapeuta">
	<thead>
	<tr>
		<th style="text-align: center;width: 20%">Gestor</th>
		<th style="text-align: center;width: 20%">Visita Domiciliaria</th>
		<th style="text-align: center;width: 20%">Entrevista en Oficina</th>
		<th style="text-align: center;width: 20%">Contacto Telefónico</th>
		<th style="text-align: center;width: 20%">Familia inubicable</th>
		<th style="text-align: center;width: 20%">Total Casos</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($registrosCasos AS $c1 => $v1)
			<tr>
				<td>{{$v1->nombre_gestor}}</td>
				<td>{{$v1->total_visita_domiciliaria}}</td>
				<td>{{$v1->total_entrevista}}</td>
				<td>{{$v1->total_contacto_telefonico}}</td>
				<td>{{$v1->fam_inu}}</td>
				<td>{{$v1->total_casos}}</td>
			</tr>
		@endforeach
	</tbody>
</table>

