<link rel="stylesheet" href="{{ env('APP_URL') }}/css/vis.min.css" >
<link rel="stylesheet" href="{{ env('APP_URL') }}/css/vis-network.min.css" >

<div class="container">
	<div class="row">
		<div class="col">
				<h5 >
					<b><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSItMjcgMCA1MTIgNTEyIiB3aWR0aD0iNTEycHgiPjxwYXRoIGQ9Im0xODggNDkyYzAgMTEuMDQ2ODc1LTguOTUzMTI1IDIwLTIwIDIwaC04OGMtNDQuMTEzMjgxIDAtODAtMzUuODg2NzE5LTgwLTgwdi0zNTJjMC00NC4xMTMyODEgMzUuODg2NzE5LTgwIDgwLTgwaDI0NS44OTA2MjVjNDQuMTA5Mzc1IDAgODAgMzUuODg2NzE5IDgwIDgwdjE5MWMwIDExLjA0Njg3NS04Ljk1NzAzMSAyMC0yMCAyMC0xMS4wNDY4NzUgMC0yMC04Ljk1MzEyNS0yMC0yMHYtMTkxYzAtMjIuMDU0Njg4LTE3Ljk0NTMxMy00MC00MC00MGgtMjQ1Ljg5MDYyNWMtMjIuMDU0Njg4IDAtNDAgMTcuOTQ1MzEyLTQwIDQwdjM1MmMwIDIyLjA1NDY4OCAxNy45NDUzMTIgNDAgNDAgNDBoODhjMTEuMDQ2ODc1IDAgMjAgOC45NTMxMjUgMjAgMjB6bTExNy44OTA2MjUtMzcyaC0yMDZjLTExLjA0Njg3NSAwLTIwIDguOTUzMTI1LTIwIDIwczguOTUzMTI1IDIwIDIwIDIwaDIwNmMxMS4wNDI5NjkgMCAyMC04Ljk1MzEyNSAyMC0yMHMtOC45NTcwMzEtMjAtMjAtMjB6bTIwIDEwMGMwLTExLjA0Njg3NS04Ljk1NzAzMS0yMC0yMC0yMGgtMjA2Yy0xMS4wNDY4NzUgMC0yMCA4Ljk1MzEyNS0yMCAyMHM4Ljk1MzEyNSAyMCAyMCAyMGgyMDZjMTEuMDQyOTY5IDAgMjAtOC45NTMxMjUgMjAtMjB6bS0yMjYgNjBjLTExLjA0Njg3NSAwLTIwIDguOTUzMTI1LTIwIDIwczguOTUzMTI1IDIwIDIwIDIwaDEwNS4xMDkzNzVjMTEuMDQ2ODc1IDAgMjAtOC45NTMxMjUgMjAtMjBzLTguOTUzMTI1LTIwLTIwLTIwem0zNTUuNDcyNjU2IDE0Ni40OTYwOTRjLS43MDMxMjUgMS4wMDM5MDYtMy4xMTMyODEgNC40MTQwNjItNC42MDkzNzUgNi4zMDA3ODEtNi42OTkyMTggOC40MjU3ODEtMjIuMzc4OTA2IDI4LjE0ODQzNy00NC4xOTUzMTIgNDUuNTU4NTk0LTI3Ljk3MjY1NiAyMi4zMjQyMTktNTYuNzU3ODEzIDMzLjY0NDUzMS04NS41NTg1OTQgMzMuNjQ0NTMxcy01Ny41ODU5MzgtMTEuMzIwMzEyLTg1LjU1ODU5NC0zMy42NDQ1MzFjLTIxLjgxNjQwNi0xNy40MTAxNTctMzcuNDk2MDk0LTM3LjEzNjcxOS00NC4xOTE0MDYtNDUuNTU4NTk0LTEuNS0xLjg4NjcxOS0zLjkxMDE1Ni01LjMwMDc4MS00LjYxMzI4MS02LjMwMDc4MS00Ljg0NzY1Ny02Ljg5ODQzOC00Ljg0NzY1Ny0xNi4wOTc2NTYgMC0yMi45OTYwOTQuNzAzMTI1LTEgMy4xMTMyODEtNC40MTQwNjIgNC42MTMyODEtNi4zMDA3ODEgNi42OTUzMTItOC40MjE4NzUgMjIuMzc1LTI4LjE0NDUzMSA0NC4xOTE0MDYtNDUuNTU0Njg4IDI3Ljk3MjY1Ni0yMi4zMjQyMTkgNTYuNzU3ODEzLTMzLjY0NDUzMSA4NS41NTg1OTQtMzMuNjQ0NTMxczU3LjU4NTkzOCAxMS4zMjAzMTIgODUuNTU4NTk0IDMzLjY0NDUzMWMyMS44MTY0MDYgMTcuNDEwMTU3IDM3LjQ5NjA5NCAzNy4xMzY3MTkgNDQuMTkxNDA2IDQ1LjU1ODU5NCAxLjUgMS44ODY3MTkgMy45MTAxNTYgNS4zMDA3ODEgNC42MTMyODEgNi4zMDA3ODEgNC44NDc2NTcgNi44OTg0MzggNC44NDc2NTcgMTYuMDkzNzUgMCAyMi45OTIxODh6bS00MS43MTg3NS0xMS40OTYwOTRjLTMxLjgwMDc4MS0zNy44MzIwMzEtNjIuOTM3NS01Ny05Mi42NDQ1MzEtNTctMjkuNzAzMTI1IDAtNjAuODQzNzUgMTkuMTY0MDYyLTkyLjY0NDUzMSA1NyAzMS44MDA3ODEgMzcuODMyMDMxIDYyLjkzNzUgNTcgOTIuNjQ0NTMxIDU3czYwLjg0Mzc1LTE5LjE2NDA2MiA5Mi42NDQ1MzEtNTd6bS05MS42NDQ1MzEtMzhjLTIwLjk4ODI4MSAwLTM4IDE3LjAxMTcxOS0zOCAzOHMxNy4wMTE3MTkgMzggMzggMzggMzgtMTcuMDExNzE5IDM4LTM4LTE3LjAxMTcxOS0zOC0zOC0zOHptMCAwIiBmaWxsPSIjMDAwMDAwIi8+PC9zdmc+Cg==" height="20px" /> Resumen TF </b>
				</h5>
		</div>

			 <!-- BOTON DE TERAPIA PTF -->
		<!-- <div class="col text-right" style="margin-left:350px;">
			<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"
			onclick="terapiaPtf({{$nna_teparia->tera_id}});">
			Plan de Terapia Familiar
			</button>
		</div>

		<div class="col text-right">
			<button type="button" class="btn btn-danger btn-sm btnRechEst" data-dismiss="modal"  onclick="comentarioEstadoTerapia({{ $nna_teparia->est_tera_id }});">
				Desestimar Terapia
			</button>
		</div> -->
	</div>
</div>
<hr>

<!-- COMPOSICION DEL HOGAR -->
<div class="card colapsable shadow-sm">
	<a class="btn text-left p-0" id="sec_pauta_trabajo_familiar_ingreso"  data-toggle="collapse" data-target="#seccion_grupo_familiar_san" aria-expanded="true" aria-controls="seccion_grupo_familiar_san">
		<div class="card-header p-3">
				<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Composición Familiar"><i class="fa fa-info"></i></button>&nbsp;&nbsp;Composición del hogar</h5>
		</div>
	</a>
	<div class="collapse" id="seccion_grupo_familiar_san">
			<div class="card-body">
        		
				<div id="diagrama-hogar" class="p-2">
				<!-- <div class="row">
					<div class="col">
					<h6>Composición del hogar</h6>
					</div>
				</div> -->
				<div class="row">
					<div class="col-12 text-center">
					<div id="animation_container"></div>   
					</div>
				</div>
				<div class="row">
					<div class="col-12">
					<table class="table table-sm">
					<tbody>
					<tr>
					<td><small style="border: 3px solid #ff0000"><span style="color: #fff">_</span></small></td>
					<td><small>NNA objeto del caso</small></td>
					<td><small style="border: 3px solid #ffa500"><span style="color: #fff">_</span></small></td>
					<td><small>NNA con alertas</small></td>
					<td><small style="border: 3px solid #cccccc"><span style="color: #fff">_</span></small></td>
					<td><small>Integrantes del hogar</small></td>
					<td><small style="border: 3px solid #ffff00; background-color: #ffff00"><span style="color: #ffff00">_</span></small></td>
					<td><small>Selección según filtro</small></td>
					</tr>
					</tbody>
					</table>
					</div>
				</div>
				</div>


    		</div>
    </div>
</div>
<!-- FIN COMPOSICION DEL HOGAR -->

<!-- NCFAS - G -->
<div class="card colapsable shadow-sm">
	<a class="btn text-left p-0" id="sec_pauta_trabajo_familiar_ingreso"  data-toggle="collapse" data-target="#seccion_ncfasg" aria-expanded="false" aria-controls="seccion_ncfasg">
		<div class="card-header p-3">
				<h5 class="mb-0"><button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="NCFAS-G"><i class="fa fa-info"></i></button>&nbsp;&nbsp;NCFAS-G</h5>
		</div>
	</a>
	<div class="collapse" id="seccion_ncfasg">
		<div class="card-body">

			<div class="row">
				<div class="col-md-12 text-center">
					<button type="button" class="btn btn-info" onclick="$('#ncfasModal').modal('show');">Visualizar NCFAS-G</button>
		      	</div>
      		</div>

		</div>
	</div>
</div>

