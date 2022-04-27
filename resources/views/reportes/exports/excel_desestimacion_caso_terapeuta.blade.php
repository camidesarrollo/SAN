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
		@foreach ($titulosMotivosDesestimacion AS $c1 => $v1)
			<th style="text-align: center;">{{$v1}}</th>
		@endforeach
	</tr>
	</thead>
	<tbody>
		@foreach ($registrosCasosDesestimados AS $c1 => $v1)
			<tr>
				<td>{{$c1}}</td>
				@foreach ($v1 AS $c2 => $v2)
					<td style="text-align: right;">{{$v2}}</td>
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>
