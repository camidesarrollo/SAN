<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="table table-striped table-hover" cellspacing="0" id="tabla_caso_terapia">
	<thead>
	<tr>
		<th rowspan="2" style="text-align: center;width: 20%">Comuna</th>
		<th rowspan="2" style="text-align: center;width: 20%">Región</th>
		<th colspan="2" style="text-align: center;width: 20%">N° Casos en GC</th>
		<th colspan="2" style="text-align: center;width: 20%">N° Casos en TF</th>
	</tr>

	<tr>
		<th style="text-align: center;width: 20%">Cantidad de NNA</th>
		<th style="text-align: center;width: 20%">Cantidad de Familias</th>
		<th style="text-align: center;width: 20%">Cantidad de NNA</th>
		<th style="text-align: center;width: 20%">Cantidad de Familias</th>
	</tr>

	</thead>
	<tbody>
		@foreach ($registros AS $c1 => $v1)
			<tr>
				<td>{{$c1}}</td>
				@foreach ($v1 AS $c2 => $v2)
					<td style="text-align: left;">{{$c2}}</td>
					@foreach ($v2 AS $c3 => $v3)
						@foreach ($v3 AS $c4 => $v4)
							<td style="text-align: right;">{{$v4}}</td>
						@endforeach
					@endforeach
				@endforeach
			</tr>
		@endforeach
	</tbody>
	
</table>
				


