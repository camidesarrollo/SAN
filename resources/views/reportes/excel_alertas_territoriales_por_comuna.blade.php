<img source="">

<table>
	<thead>
	<tr>
		<th>Comuna</th>
		<th>Total</th>
	</tr>
	</thead>
	<tbody>

		@foreach($registros_reporte as $registro)
		<tr>
			<td>{{ $registro->com_nom }}</td>
			<td>{{ $registro->total }}</td>
		</tr>
		@endforeach

	</tbody>
</table>