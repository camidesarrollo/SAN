@extends('layouts.main')

@section('contenido')
	
	<section class=" p-1 cabecera">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h5>Casos Asignados</h5>
				</div>
			</div>
		</div>
	</section>
	
	<section>
		<div class="container-fluid">
			<div class="card p-4 shadow-sm">
						<div>
							<!-- <div class="float-left">
								<h5>Predictivos <span class="badge badge-secondary">{{ @$numeroPredictivos }}</span> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
							</div>
							<div class="float-left">
								<h5 >Manuales <span class="badge badge-secondary">{{ @$numeroManuales }}</span> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
							</div>
							<div class="float-left">
								<h5 >Experto <span class="badge badge-secondary"> 0</span> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
							</div> -->
							<div class="clearfix"></div>
						</div>
						
						<table id="tabla_asignados" class="table table-striped table-hover" attr2="{{route('coordinador.caso.ficha')}}" >
							<thead>
								<tr>
									<th colspan="7">
										<div class="row">
											<div class="col">
												<select title="Dimensiones" class="form-control" id="dim_id" name="dim_id">
													<option value="">Dimensión</option>
													@foreach($dimensiones as $dimension)
														<option value="{{ $dimension->dim_nom }}">{{ $dimension->dim_nom }}</option>
													@endforeach
												</select>
											</div>
											<div class="col">
												<select title="Estados del Caso" class="form-control" id="estados" name="estados">
													<option value="">Estado del Caso</option>
													@foreach($estados as $estado)
														<option value="{{ $estado->est_cas_nom }}">{{ $estado->est_cas_nom }}</option>
													@endforeach
												</select>
											</div>
											<div class="col">
												{{ Form::select('origen', [''=>'Origen del Caso']+config('constantes.caso_origen'), null, ['title'=>'Origen del Caso','id'=>'origen','class'=>'form-control']) }}
											</div>
											<div class="col">
											
											</div>
										</div>
									</th>
								</tr>
								<tr>
									<th>Run</th>
									<th>Prioridad</th>
									<th>Manual</th>
									<th>Origen</th>
									<th>Estado</th>
									<th>Facilitador</th>
									<th>Gestión</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

			</div>
		</div>
	</section>
	
	@include('ficha.resumen')

@endsection

@section('script')
<script>
	$(document).ready( function () {

		setTimeout(function(){

			let asignados = $('#tabla_asignados');

			let tabla_asignados = asignados.DataTable( {
							"language": {
            	"decimal": "",
                "emptyTable": "No hay información",
        		"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        		"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
        		"infoFiltered": "(Filtrado de _MAX_ total entradas)",
        		"infoPostFix": "",
        		"thousands": ",",
        		"lengthMenu": "Mostrar _MENU_ Entradas",
       	 		"loadingRecords": "Cargando...",
        		"processing": "Procesando...",
        		"search": "Buscar:",
        		"zeroRecords": "Sin resultados encontrados",
        		"paginate": {
            		"first": "Primero",
            		"last": "Ultimo",
            		"next": "Siguiente",
            		"previous": "Anterior"
        			}
        		},
				"order":[
					[1, "desc"]
				],
				"ajax":{
					"url":"{{route('data.casos.asignados')}}",
					"data": function ( d ) {
						d.origen = $('#origen').val();
					}
				},
				"columns":[
					{
					 "data":'run',
					 "name":"run",
					 "render": function(data, type, row){ return formatearRun(data); }
					},
					{
						"data":'color',
						"name":'color',
						"className": "text-center",
						"searchable": false
					},
					{
					 "data":'dimension',
					 "name":"dimension",
					 "className": "text-center",
					 "searchable": false
					},
					{"data":'origen',"name":"cas_ori","visible": false,"searchable": false},
					{"data":'estado',"name":"estado","visible": true},
					{"data":'ter_nom',"name":"ter_nom"},
					{
						"data":null,
						"orderable":false,
						"className": "text-center",
						"render":function(data,type,row){

							let urlFichaCompleta = $("#tabla_asignados").attr("attr2");
							urlFichaCompleta+='/2/'+row.per_run;
							let botonFichaCompleta = '<a class="dropdown-item" href="'+urlFichaCompleta+'">Ficha Completa</a>';

							//let urlFichaRapida = $("#tabla_asignados").attr("attr1");
							//urlFichaRapida+='/2/'+row.per_run;
							let botonFichaRapida = "";
							botonFichaRapida+= '<a href="#" ' +
								'class="dropdown-item boton-vista-rapida" ' +
								'data-toggle="modal" data-target="#testModal" data-ficha-rapida="{{ route('casos.ficha.rapida') }}/'+full.run+'" onclick="completarVistaRapida(this)">Vista Rápida</a>';

							let dropb =	'<div class="dropdown">';
							dropb+= '<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones </button>';
							dropb+= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
							dropb+=	botonFichaCompleta+botonFichaRapida;
							dropb+= '</div></div>';
							return dropb;
						},
						"searchable": false
					}
				],

				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				"drawCallback": function () {
					$(".boton-vista-rapida").click(function(){

						let url = $(this).attr('data1');

						$.get(url, function( data ) {

							let calle = data.calle;
							let numero = data.numero;
							let num_depto = data.depto;

							let direccion_final = "";

							if (calle!=null){
								direccion_final.concat(" "+calle);
							}
							if (numero!=null){
								direccion_final.concat(" "+numero);
							}
							if(num_depto!=null){
								direccion_final.concat("depto/casa n°"+num_depto);
							}

							$("#vr_nombre").text(data.nombre);
							$("#vr_run").text(data.run);
							$("#vr_edad").text(data.edad);
							$("#vr_direccion").text(direccion_final);
							$("#vr_region").text(data.region);
							$("#vr_provincia").text(data.provincia);
							$("#vr_comuna").text(data.comuna);
						});
					});
				}
			});

			// Oculta la columna Terapeutas en caso que el perfil sea terapeuta
			@if(session('perfil')==4)
			tabla_asignados.column(8).visible(false);
			@endif

			//Filtro de dimensiones
			$("#dim_id").on('change', function () {
				let val = $.fn.dataTable.util.escapeRegex($(this).val());
				tabla_asignados.column(4).search(val ? val : '', true, false).draw();
			});

			// Filtro de estados
			$("#estados").on('change', function () {
				let val = $.fn.dataTable.util.escapeRegex($(this).val());
				tabla_asignados.column(7).search(val ? val : '', true, false).draw();
			});

			// Filtro de Origen
			$("#origen").on('change', function () {
				tabla_asignados.draw();
			});
		});
		},300);



</script>

@endsection
