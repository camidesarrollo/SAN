@extends('layouts.main')

@section('contenido')

	<section class=" p-1 cabecera">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-bell"></span> Asignar NNA</h2>
				</div>
			</div>
		</div>
	</section>

	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	@if(Session::has('danger'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('danger') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if ($errors->any())
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<section>
		<div class="container">
			<h3>NNA sin asignar</h3>

			<div class="card p-4">
				<h5>Total NNA <span class="badge badge-secondary" id="totalNNA">0</span></h5>

							<div class="row pb-3">
				<div class="col">
					<select title="regiones" class="form-control" id="regiones" name="regiones">
							<option value="0">Seleccione</option>
							@foreach($regiones as $region)
								<option value="{{ $region->reg_id }}">{{ $region->reg_nom }}</option>
							@endforeach
					</select>
				</div>
				<div class="col">
					<select title="Dimensiones" class="form-control" id="dim_id" name="dim_id">
						<option value="">Comuna</option>
						<option value="region">comuna</option>
					</select>
				</div>
				<div class="col">
							
				</div>
			</div>

				<div id="filtros-table" style="background-color: #e6e6e6; padding: 0 15px; margin-bottom: 15px;"></div>

				<div class="row">
					<div class="col-sm-7">
						<table id="table_nna" class="table table-striped" attr1="{{route('caso.ficha.rapida')}}" attr2="{{route('coordinador.caso.ficha')}}"  >
							<thead>
							<tr>
								<th>R.U.N</th>
								<th>Fecha</th>
								<th>Score</th>
								<th>Gestión</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="col-sm-5">
						<table id="table_gestor" class="table table-striped" style="width: 100%;">
							<thead>
							<tr>
								<th>R.U.N</th>
								<th>Nombre</th>
								<th>N° de Casos Asignados</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<!--<button id="botonAsignar" name="botonAsignar" type="button" class="btn btn-info" data-toggle="modal" data-target="#asignarModal" >
					Asignar Terapeuta
				</button>-->
			</div>
		</div>
	</section>

    @include('ficha.resumen')

	<!-- Modal para asignar, con checkbox -->
	<div id="asignarModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="diagnosticarModal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content p-4">
				<div class="card p-3 bg-celeste">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h3><span class="oi oi-circle-check"></span> Asignación Masiva </h3>
					<hr>
					<div class="table-wrapper-scroll-y">
						<table class="table table-hover table-sm table-condensed" id="casosChecados" >
							<thead>
							<tr>
								<th >ID CASO</th>
								<th >RUN PERSONA</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<form name="asignacion_formulario" method="post" action="{{route('coordinador.caso.asignacion.masiva')}}" >
						{{ csrf_field() }}

						<!-- @ if ($terapeutas) -->
							<select class="form-control form-control" style="height: auto;" name="terapeuta_id" required>
								<option value="" >Seleccione terapeuta</option>

								<!--@ foreach ($terapeutas as $terapeuta) -->

								<!--<option value="$terapeuta->id" >$terapeuta->nombre</option>-->



							</select>
						<!-- @ endif -->
						<br>
						<div class="form-group">
							<textarea name="comentario" type="text" class="form-control" required  placeholder="Comentario" aria-label="Comentario"></textarea>
						</div>
						<div id="arrayCasos" ></div>
						<br>
						<input type="submit" class="btn btn-primary btn-lg" value="Asignar terapeuta">
					</form>
				</div>
			</div>
		</div>
	</div>
@stop

@section('css')
	<style>
		[draggable] {
			-moz-user-select: none;
			-khtml-user-select: none;
			-webkit-user-select: none;
			user-select: none;
			/* Required to make elements draggable in old WebKit */
			-khtml-user-drag: element;
			-webkit-user-drag: element;
		}

		#table_nna{
			cursor: move;
		}

	</style>
@endsection

@section('script')
	<script type="text/javascript" >
		$( document ).ready(function(){
			var	table_nna = $('#table_nna').DataTable({
				"fixedHeader": { header: true },
				"dom": '<lf<t>ip>',
				"order":[],
				"processing": true,
				"serverSide": true,
				"ajax":{"url":"{{route('data.casos.administracion')}}"},
				"createdRow": function( row, data, dataIndex ) {
					$(row).attr('data-run-sin-digito', data.per_run);
					$(row).attr('data-run-completo', data.run);
					$(row).attr('draggable', 'true');
					$(row).attr('ondragstart', 'drag(event)');
					$(row).attr('ondragend', 'dragEnd(event)');
				},
				"columns":[{ //COLUMNA RUN
					  "data":'run',
					  "className": "text-center",
					  "render": function(data, type, row){
							let run = "";
							let s_guion = data.split("-");

						    s_puntos = s_guion[0].replace(/\./g,'');

						    if (s_puntos.indexOf(",")>=0) s_puntos = s_puntos.substring(0, s_puntos.indexOf(","));

							for (var j, i = s_puntos.length - 1, j = 0; i >= 0; i--, j++){
								run = s_puntos.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + run;
							}

							run = run+"-"+s_guion[1];

						    return run;
					        }
				    },{ //COLUMNA FECHA
					  "data"		: 'fecha',
					  "className"	: "text-center"
				    },{ //COLUMNA COLOR
					  "data":'color',
					  "className": "text-center",
					  "orderable":true,
					  "visible": true,
					  "searchable": false
					},{ //COLUMNA ALERTAS
					    "data":null,
						"orderable":false,
						"className": "text-center",
					    "render":function(data,type,row){
					    	
							let urlFichaCompleta = $("#table_nna").attr("attr2");

							urlFichaCompleta+='/2/'+row.per_run;
							let botonFichaCompleta = '<a class="dropdown-item" href="'+urlFichaCompleta+'">Ficha Completa</a>';

							let urlFichaRapida = $("#table_nna").attr("attr1");
							urlFichaRapida+='/2/'+row.per_run;
							let botonFichaRapida = "";
							botonFichaRapida+= '<a href="#" ' +
								'class="dropdown-item boton-vista-rapida" ' +
								'data-toggle="modal" data-target="#testModal" data1="'+urlFichaRapida+'" >Vista Rápida</a>';

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
				//"language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"drawCallback": function (settings) {

				$(".boton-vista-rapida").click(function(){

					var url = $(this).attr('data1');

					$.get(url, function( data ) {

						var calle = data.calle;
						var numero = data.numero;
						var num_depto = data.depto;

						var direccion_final = "";

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

			$('#table_nna').addClass("headerTablas");

			var	table_gestor = $('#table_gestor').DataTable({
				"fixedHeader": { header: true },
				"dom": '<lf<t>ip>',
				"order":[],
				"searching": false,
				"paging": false,
				"info": false,
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{"url":"{{route('data.casos.administracion.gestor')}}"},
				"createdRow": function( row, data, dataIndex ){
                    let nombre_completo = "";
                    nombre_completo = data.nombres+" "+data.apellido_paterno+" "+data.apellido_materno;

					$(row).attr('data-id-gestor', data.id);
					$(row).attr('data-nombre-gestor', nombre_completo);
					$(row).attr('ondrop', 'drop(event)');
					$(row).attr('ondragover', 'allowDrop(event)');
					$(row).attr('ondragleave', 'removeFC(event)');

					//ondragleave="myFunction(event)"
				},
				"columns":[{
							"data":'run',
							"className": "text-center",
							"visible": true
				           },
					       {
						    "data":'nombres',
						    "className": "text-center",
						    "visible": true,
						    "render": function(data, type, row){
						    	let nombre_completo = "";
						    	nombre_completo = data+" "+row.apellido_paterno+" "+row.apellido_materno;
							    return nombre_completo;
						    }
					       },
						   {
						   	"data":'total_casos_asignados',
						    "className": "text-center",
						    "visible": true
						   }
				],
				//"language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"drawCallback": function (settings) {}
			});

			$('#table_gestor').addClass("headerTablas");
		});

		// $('#regiones').change(function(){ 
  //  		 var value = $(this).val();

  //  		 alert(value);

		// });

		function drag(ev) {
			let data_transfer = "";
			data_transfer = ev.target.dataset.runCompleto+","+ev.target.dataset.runSinDigito;

			ev.target.id = "arrastrar_tmp";
			$("#arrastrar_tmp").css("opacity", "0.4");

			ev.dataTransfer.effectAllowed = 'move';
			ev.dataTransfer.setData('text', data_transfer);
		}

		function dragEnd(ev){
			$("#arrastrar_tmp").css("opacity", "1");
			$("#arrastrar_tmp").removeAttr("id");

			$("#soltar_tmp").css("opacity", "1");
			$("#soltar_tmp").removeAttr("id");
		}

		function allowDrop(ev) {
			ev.preventDefault();

			$(ev.target).parent().attr("id", "soltar_tmp");
			$("#soltar_tmp").css('opacity', '0.4');
		}

		function removeFC(ev){
		    $("#soltar_tmp").css("opacity", "1");
		    $("#soltar_tmp").removeAttr("id");

		}

		function drop(ev){
			ev.preventDefault();
			let data = ev.dataTransfer.getData("text");
			data = data.split(",");
			data.push($("#soltar_tmp").attr('data-id-gestor'));
			data.push($("#soltar_tmp").attr('data-nombre-gestor'));

			let msg = "¿Esta seguro que desea realizar la siguiente asignación?\n\n";
			msg += "Asignar NNA\n";
			msg += "R.U.N: "+data[0]+"\n\n";
			msg += "Al Gestor Comunal\n";
			msg += "Nombre: "+data[3]+"\n";

			var opcion = confirm(msg);
			if (opcion) {
				$.ajax({
					url: "{{route('casos.administracion.asignargestor')}}",
					cache: false,
					data: {
						   nna: data[1],
						   id_usu: data[2]
					      }
				}).done(function(resp) {
					alert(resp.mensaje);

					if (resp.estado == 1){
						$('#table_nna').DataTable().ajax.reload();
						$('#table_gestor').DataTable().ajax.reload();
					}
				}).fail(function(obj) {
					console.log(obj);
					alert("Error al momento de asignar NNA a Gestor, Por favor intente nuevamente.");

				});

			}
		}
	</script>
@endsection