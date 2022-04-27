<table>
	<thead>
		<tr>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
		<tr>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
		<tr>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
		<tr>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
		<tr>
			<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
	<tr>
		<th>Alerta Territorial</th>
		<th>Componente</th>
		<th>Programa</th>
		<th>Sector</th>
		<th>Institución</th>
		<th>Responsable</th>
		<th>Oportunidad de acceso</th>
		<th>Horario de Atenci&oacute;n</th>
		<th>Cupos</th>
	</tr>
	</thead>
	<tbody>
	    @if ($respuesta["estado"] == false)
             <tr>
				 <td colspan="9">{{ $respuesta["respuesta"] }}</td>
			 </tr>

		@elseif ($respuesta["estado"] == true)

			@foreach($respuesta["respuesta"] as $c01 => $v01)
				@foreach($v01 as $c02 => $v02)
						@foreach ($v02 as $c03 => $v03)
							<tr>
							 <!-- @ if ($c03 == 0)
								 <td rowspan="{ { count($v02) }}">{ { $c02 }}</td>
							  @ endif-->

							  <td>{{ $c02 }}</td>

								 <td>{{ $v03["ofe_nom"] }}</td>
								 <td>{{ $v03["pro_nom"] }}</td>
								 <td>{{ $v03["dim_nom"] }}</td>
								 <td>{{ $v03["inst_nom"] }}</td>
								 <td>{{ $v03["resp_nom"] }}</td>
								 <td>{{ $v03["opo_acc"] }}</td>
								 <td>{{ $v03["ofe_hor_ate"] }}</td>
								 <td>{{ $v03["ofe_cup"] }}</td>
							</tr>
						@endforeach
				@endforeach
			@endforeach

		@endif
	</tbody>
</table>