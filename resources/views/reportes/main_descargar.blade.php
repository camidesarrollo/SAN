@extends('layouts.main')

@section('contenido')
    <section class=" p-3">
        <div class="container-fluid">
            <section class="p-1 cabecera">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h5><i class="{{$icono}}"></i> Descargar</h5>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card shadow-sm p-4">
                <div class="row accesos justify-content-center">                
                    <div class="col-lg-4">
                        @if(config('constantes.reporte_mensual'))
                        <a href="#" onclick="listarReporte(0)">
                        @else
                        <a href="{{route('reportes.objetivos.tareas')}}">
                        @endif
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-file text-success"></span> Objetivos y Tareas PAF</h5>
                            </div>
                        </a>
                    </div>
    
                    <div class="col-lg-4">
                        @if(config('constantes.reporte_mensual'))
                        <a href="#" onclick="listarReporte(1)">
                        @else
                        <a href="{{route('reportes.resultados.ncfas')}}">
                        @endif
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-file text-success"></span> Resultados NCFAS-G</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        @if(config('constantes.reporte_mensual'))
                        <a href="#" onclick="listarReporte(2)">
                        @else
                        <a href="{{route('reportes.respuestas.terapiafamiliar')}}">
                        @endif
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-file text-success"></span> Respuesta Evaluación TF</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-5">
                        @if(config('constantes.reporte_mensual'))
                        <a href="#" onclick="listarReporte(3)">
                        @else
                        <a href="{{route('reportes.integrantes.gfamiliar')}}">
                        @endif
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-file text-success"></span> Integrantes Grupo Familiar por Caso</h5>
                            </div>
                        </a>
                    </div>
                    {{-- <div class="col-lg-3">
                        <a href="#">
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-file text-success"></span> Gestión de PTF</h5>
                            </div>
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- MODAL DE LISTADO DE REPORTES MENSUAL -->
                <div id="frmlistadoRepoteMensual" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-xl" role="document">
						<div class="modal-content p-4">
							<div class="modal-header">
								<div style="margin: 0 auto;"><h5><label id="modal_titulo_reporte"></label></h5></div>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">
								<div class="table-responsive">

									<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_reporte_mensual">			
										<thead>			
											<tr>
												<th class="text-center">Nombre del Reporte</th>
												<th class="text-center">Fecha de Creacion</th>
												<th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer" style="background-color: white;">								
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div>
				</div>
            <!-- MODAL DE LISTADO DE REPORTES MENSUAL -->

@stop

@section('script')
    <script type="text/javascript">

    function listarReporte(opcion){

        let tabla_reporte_mensual = $('#tabla_reporte_mensual').DataTable();
        tabla_reporte_mensual.clear().destroy();	

        let data = new Object();
        data.opcion = opcion;
        
        tabla_reporte_mensual = $('#tabla_reporte_mensual').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
			"info": 		false,
			"searching":	false,
            "order": [[ 0, "desc" ]],
            "ajax": {
                "url": "{{route('descargar.reportes.mensual')}}",
                "data": data
            },
            "columnDefs": [
                { //NOMBRE DEL REPORTE
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //FECHA DE CREACION
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ACCIONES
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //NOMBRE DEL REPORTE
                            "data": "nombre",
                            "className": "text-center"
                        },
                        { //FECHA DE CREACION
                            "data": "fecha",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "ruta",
                            "className": "text-center",
                            "render": function(data, type, row){
                                
                                let ruta = "";
                                switch(opcion){
                                    case 0:
                                        ruta = "{{route('reportes.objetivos.tareas')}}"+'/'+row.nombre;
                                    break;

                                    case 1:
                                        ruta = "{{route('reportes.resultados.ncfas')}}"+'/'+row.nombre;
                                    break;

                                    case 2:
                                        ruta = "{{route('reportes.respuestas.terapiafamiliar')}}"+'/'+row.nombre;
                                    break;
                                    
                                    case 3:
                                        ruta = "{{route('reportes.integrantes.gfamiliar')}}"+'/'+row.nombre;
                                    break;
                                }
                                
										//let html = '<button type="button" onclick="descargarReporte(\''+row.nombre+'\','+row.opcion+')" class="btn btn-success"><i class="fas fa-download"></i> Descargar</button>';
										let html = '<a href="'+ruta+'" class="btn btn-success"><i class="fas fa-download"></i> Descargar</a>';
										return html;
                                    }
                        }
                    ]
            });
            let titulo = "";
            switch(opcion){
                case 0:
                    titulo = "Objetivos y Tareas PAF";
                break;

                case 1:
                    titulo = "Resultados NCFAS-G";
                break;

                case 2:
                    titulo = "Respuesta Evaluación TF";
                break;
                
                case 3:
                    titulo = "Integrantes Grupo Familiar por Caso";
                break;
            }console.log(titulo);
            $("#modal_titulo_reporte").html(titulo);
            $("#frmlistadoRepoteMensual").modal('show');
    }

    function descargarReporte(nombre, opcion){
        let ruta = "";
        let data = new Object();
        data.nombre = nombre;
        switch(opcion){
            case 0:
                ruta = "{{route('reportes.objetivos.tareas')}}";
            break;

            case 1:
                ruta = "{{route('reportes.resultados.ncfas')}}";
            break;

            case 2:
                ruta = "{{route('reportes.respuestas.terapiafamiliar')}}";
            break;
            
            case 3:
                ruta = "{{route('reportes.integrantes.gfamiliar')}}";
            break;
        }
        console.log(opcion,ruta);
        $.ajax({
            type: "GET",
            url: ruta,
            data: data
        }).done(function(resp){

            mensajeTemporalRespuestas(1, "Accion Realizada!");

        }).fail(function(objeto, tipoError, errorHttp){
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
		});

    }
    </script>
@endsection