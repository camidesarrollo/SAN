<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="table table-striped table-hover" cellspacing="0" id="tabla_desestimacion_caso_gestor">
	<thead>
	<tr>
		<th style="text-align: center;width: 20%">Gestor</th>
		@foreach ($titulosMotivosDesestimacion AS $c1 => $v1)
			<th style="text-align: center;">{{$v1->est_cas_nom}}</th>
		@endforeach
	</tr>
	</thead>
	<tbody>
		@foreach ($registrosCasosDesestimados AS $c1 => $v1)
			<tr>
			<td>{{$v1->nombre_gestor}}</td>
			<td>{{$v1->rech_por_fami}}</td>
			<td>{{$v1->desc_gest}}</td>
			<td>{{$v1->direc_incon}}</td>
			<td>{{$v1->direc_desact}}</td>
			<td>{{$v1->program_senam}}</td>
			<td>{{$v1->vulner_derec}}</td>
			<td>{{$v1->medi_protec}}</td>
			<td>{{$v1->fam_no_aplic}}</td>
			<td>{{$v1->fam_inu}}</td>
			<td>{{$v1->fam_rec_oln}}</td>
			<td>{{$v1->fam_renun_oln}}</td>
			<td>{{$v1->dere_cont_del}}</td>
			<td>{{$v1->dere_no_cont_del}}</td>
			</tr>
		@endforeach
	</tbody>
</table>

