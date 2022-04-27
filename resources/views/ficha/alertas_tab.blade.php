
<section>
	<div class="container-fluid">
		<div class="card p-4 shadow-sm">
			
		<h4><img src="/img/ico-alertas.svg" width="30px" height="30px"/> Alerta(s) Vigentes</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
					<tr>
						<th>Fecha Creación</th>
						<th>Alerta Territorial</th>
						<th>Estado Alerta</th>
						<th>Usuario Creación</th>
					</tr>
					</thead>
					<tbody>
					
					@foreach ($alertasVigentes as $value)

					@php 
						$originalDate = $value->ale_man_fec; 
						$newDate = date("d-m-Y", strtotime($originalDate)); 
						$usuario = $value->nombres." ".$value->apellido_paterno." ".$value->apellido_materno;
					@endphp

						<tr>
							<td>{{$newDate}}</td>
							<td>{{$value->ale_tip_nom}}</td>
							<td>{{$value->est_ale_nom}}</td>
							<td>{{$usuario}}</td>
						</tr>

					@endforeach

					</tbody>
				</table>
			</div>

			<hr>

		   <h4><span class="oi oi-timer"></span> Chile Crece Contigo </h4>

		   <table class="table table-bordered table-hover table-striped">
					<thead>
					<tr>
						<th>POR DEFINIR</th>
						<th>POR DEFINIR</th>
						<th>POR DEFINIR</th>
						<th>POR DEFINIR</th>
					</tr>
					</thead>
					<tbody>
						
						<tr>
							<td>POR DEFINIR</td>
							<td>POR DEFINIR</td>
							<td>POR DEFINIR</td>
							<td>POR DEFINIR</td>
						</tr>
					</tbody>
				</table>

		   	<br>
        </div>
	</div>
</div>