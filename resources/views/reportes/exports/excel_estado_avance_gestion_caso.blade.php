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
			<th rowspan="2" style="text-align: center;width: 20%">Gestión de Casos</th>
			<th rowspan="2" style="text-align: center;width: 20%">Cobertura Inicial</th>
			<th colspan="2" style="text-align: center;width: 20%">Casos Asignados</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_prediagnostico}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_diagnostico}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_elaboracion_paf}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_ejecucion_paf}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_evaluacion_paf}}</th>
			<th colspan="2" style="text-align: center;width: 20%">{{$titulo_seguimiento_paf}}</th>
			<th colspan="2" style="text-align: center;width: 20%">Casos en gestión</th>
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
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
			<th style="text-align: center;width: 20%">N° Casos</th>
			<th style="text-align: center;width: 20%">N° NNA</th>
		</tr>
		</thead>
	<tbody>
		@foreach ($registros AS $c1 => $v1)
			<tr>
				<td>{{$v1->nombre_gestor}}</td>
				<td>{{config('constantes.cobertura_inicial_gestor')}}</td>
				<td>{{$v1->cant_casos}}</td>
				<td>{{$v1->cant_nna}}</td>
				<td>{{$v1->cant_casos_pre_diag}}</td>
				<td>{{$v1->cant_nna_pre_diag}}</td>
				<td>{{$v1->cant_casos_diag}}</td>
				<td>{{$v1->cant_nna_diag}}</td>
				<td>{{$v1->cant_casos_elab_paf}}</td>
				<td>{{$v1->cant_nna_elab_paf}}</td>
				<td>{{$v1->cant_casos_ejec_paf}}</td>
				<td>{{$v1->cant_nna_ejec_paf}}</td>
				<td>{{$v1->cant_casos_cierre_paf}}</td>
				<td>{{$v1->cant_nna_cierre_paf}}</td>
				<td>{{$v1->cant_casos_seg_paf}}</td>
				<td>{{$v1->cant_nna_seg_paf}}</td>
				<td>{{$v1->cant_casos_gestion}}</td>
				<td>{{$v1->cant_nna_gestion}}</td>

				<td>{{$v1->cant_encuenta_satif}}</td>
				<td>{{$v1->cant_egresados}}</td>


			</tr>
		@endforeach
	</tbody>
</table>
