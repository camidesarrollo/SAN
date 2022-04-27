<br>
<br>
<br>
<br>
<br>
<br>
<br>

<table class="table table-striped table-hover" cellspacing="0" id="tabla_registros_seguimiento_caso">
	<thead>
		<tr>
			<th rowspan="2" style="text-align: center;width: 20%">Nombre Gestor</th>
			<th colspan="3" style="text-align: center;width: 20%">Seguimiento</th>
			<th rowspan="2" style="text-align: center;width: 20%">Total de casos egresados</th>
		</tr>

		<tr>
			<th style="text-align: center;width: 20%">Llamado Telefónico</th>
			<th style="text-align: center;width: 20%">Visita Domiciliaria</th>
			<th style="text-align: center;width: 20%">Revisión Plataforma</th>
			<th style="text-align: center;width: 20%">Total</th>
		</tr>
		</thead>
	<tbody>
		@foreach ($registros AS $c1 => $v1)
			<tr>
				<td>{{ $v1->nombre_gestor}}</td>
				<td>{{ $v1->llamadas}}</td>
				<td>{{ $v1->visitas}}</td>
				<td>{{ $v1->revision}}</td>
				<td>{{ $v1->total}}</td>
				<td>{{ $v1->casos_egresados}}</td>
			</tr>
		@endforeach
	</tbody>
	
</table>



