<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="table table-striped table-hover" cellspacing="0" id="tabla_registros">
	<thead>
		<tr>
			<th rowspan="2" style="text-align: center;width: 20%">Terapia Familiar</th>
			<th rowspan="2" style="text-align: center;width: 20%">Cobertura Inicial</th>
			<th colspan="2" style="text-align: center;width: 20%">Casos Asignados</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_invitacion}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_diagnostico}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_ejecucion}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_seguimiento}}</th>
			<th colspan="2" style="text-align: center;width: 20%">Casos en Terapia</th>
			<th rowspan="2" style="text-align: center;width: 20%">N° de Encuestas de Satisfacción</th>
			<th rowspan="2" style="text-align: center;width: 20%">Total de Casos Egresados</th>
		</tr>

		<tr>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
		</tr>
		</thead>
	<tbody>
		@foreach ($registros AS $c1 => $v1)
			<tr>
				<td>{{$c1}}</td>

				@foreach ($v1 AS $c2 => $v2)

					@if ($c2 == 'Cobertura Inicial')
						<td style="text-align: right;">{{$v2}}</td>
					@endif

					@if ($c2 == 'Casos Asignados' || $c2 == 'Invitación' || $c2 == 'Diagnóstico' || $c2 == 'Ejecución' || $c2 == 'Seguimiento' || $c2 == 'Total Atendidos')

						@foreach ($v2 AS $c3 => $v3)
							<td style="text-align: right;">{{$v3}}</td>
						@endforeach

					@endif

					@if ($c2 == 'N° de Encuestas de Satisfacción')
						<td style="text-align: right;">{{$v2}}</td>
					@endif

					@if ($c2 == 'Total de Casos Egresados')
						<td style="text-align: right;">{{$v2}}</td>
					@endif

				@endforeach

			</tr>
		@endforeach
	</tbody>
</table>


