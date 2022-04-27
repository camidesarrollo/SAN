<br>
<br>
<br>
<br>
<br>
<br>
<br>

<table class="table table-striped table-hover" cellspacing="0" id="tabla_registros_seguimiento_terapia">
	<thead>
		<tr>
			<th rowspan="2" style="text-align: center;width: 20%">Nombre Terapeuta</th>
			<th colspan="4" style="text-align: center;width: 20%">Seguimiento</th>
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
				<td>{{$c1}}</td>

				@foreach ($v1 AS $c2 => $v2)
					<td style="text-align: right;">{{$v2}}</td>
				@endforeach

			</tr>
		@endforeach
	</tbody>
	
</table>


