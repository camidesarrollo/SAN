<!-- INICIO CZ SPRINT 66 -->
@extends('layouts.main')
@section('contenido')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">	
.multiselect-container>li {
	width:200px;
	padding:0px;
	margin:0px;
}
.fecha_asign{
    width:200px;
}
#tabs{
    width:1000px;
}
.selReportes{
    width: 500px;
}
</style>
<meta name="_token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-12 pt-2">
            <h5><i class="{{$icono}}" style="margin-right: 10px;"></i>Revertir Estados</h5>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div id="tabs" class="card p-4 shadow-sm w-100">
            <div id="tabs-1">
                <br>
                <!-- <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Seleccione revertir caso o terapia</b>
                        </label>
                    </div>
                    <div class="col-sm-6"  >
                        <select class="form-control form-control" style="height: auto;" name="terapeuta_id" required>
                            <option value="" >Desea revertir...</option>
                            <option value="" >Caso</option>
                            <option value="" >Terapia</option>
                        </select>
                    </div>								
                </div> -->
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Elije la(s) comuna(s)</b>
                        </label>
                    </div>
                    <div class="col-sm-6"  >
                        <!-- CZ SPRINT 76  -->
                        <select id="chkcomuna" name="chkcomuna" class="form-control" style="color: #858796;">																		
                        @php $getComunas = Helper::getComunas(); @endphp																	
                            @foreach($getComunas AS $c1 => $v1)
                             <!-- CZ SPRINT 76  -->
                                <option value="{{$v1->com_cod}}"
                                    @if(Session::get('perfil') != 7 && Session::get('com_id')==$v1->com_id)
                                        {{ "selected" }}
                                    @endif
                                    >{{$v1->com_nom}}</option>
                            @endforeach
                        </select>
                    </div>								
                </div>
                <!-- CZ SPRINT 77 -->
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Estado del caso</b>
                        </label>
                    </div>
                    <div class="col-sm-6"  >
                        <!-- CZ SPRINT 76  -->
                        <select id="estado_caso" name="estado_caso" class="form-control" style="color: #858796;">																		
                        <option value="0">En Gestion</option>
                        <option value="1">Egresado</option>
                        <option value="2">Desestimado</option>
                        </select>
                    </div>								
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-success" onclick="filtrarTabla()">Filtrar</button>
                    <button type="submit" class="btn btn-primary" onclick="limpiarFormulario();">Limpiar</button>
                </div>

            </div>	
            <br>
            <div id="tabla-casos">
                <table id="registrados" class="table table-hover table-striped w-100" attr2="{{route('coordinador.caso.ficha')}}"  >
					<thead>
						<tr>
							<th colspan="9"><div id="filtros-table"></div></th>
						</tr>
						<tr>
							<th style="display: none;">R.U.N</th>
							<th>Nombre NNA</th>
							<th>Estado Gesti&oacute;n Caso</th>
							<th>Estado Terapia Familiar</th>
							<th>Gestión Caso</th>
                            <th>Gestión terapia</th>
							<th style="display:none">RUNSINFORMATO</th>
							<th style="display:none">Caso</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
            </div>
            <div id="tabla-terapia">
            </div>
        </div>
    </div>
</div>
@include('administrador_central.modal_revertir_estado')

@endsection

@section('script')
<script type="text/javascript">

    $(function() {
        $('.chkveg').multiselect({
            includeSelectAllOption: false     
        });
    });
    function filtrarTabla(){
        bloquearPantalla();
		let chkcomuna	= new Array();
		$.each($('#chkcomuna option:selected'), function(){ chkcomuna.push($(this).val()); });
		chkcomuna		= chkcomuna.join(',');
        comunas = chkcomuna;
        let data = new Object();
        data.comunas = comunas;
        // CZ SPRINT 77
        data.estado =$("#estado_caso").val();
        let registrados = $('#registrados').DataTable();
        registrados.clear().destroy();
        dataTable_casos = $('#registrados').DataTable({
			//"fixedHeader": { header:true },
			"dom": '<lf<t>ip>',
			"order":[
				//[2, "desc"],
				[6, "desc"]
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
                // CZ SPRINT 7
				"url":"{{route('data.casos.listarCasosGestion')}}", 
                "data": data
			},
			"rowGroup": {
				startRender: function ( rows, group ) {
                	return "Caso " + group;
				},
            	dataSrc: "cas_id"
        	},
			"columns":[
			{
			  "data": 			"nna_run_con_formato",
			  "name":           "nna_run_con_formato",
			  "className": 		"text-center",
			  "visible": 		false,
			  "orderable": 		true,
			  "searchable": 	true,
			  "render": function(data, type, row){ 
				let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
				return rut;
			 }
			},
			{
				"data"		: "nna_nombre_completo",
				"name"		: "nna_nombre_completo",
                "className": 		"text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true,
				"render" : function (data, type, full, meta){
					let formato = formateoNombres(full.nna_nom, full.nna_ape_pat);
					return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full.nna_run_con_formato + '<br />Nombre completo:<br />' + full.nna_nombre_completo + '">' + formato.nombre + ' ' + formato.ape_pat + '</label>';
				}
			}, 
			/*{																		
				"data": 		"score",
				"name": 		"score",
				"className": 	"text-center",
				"orderable": 	true,
				"searchable": 	false
			},*/ 
			/*{																				
				"data": 		"est_cas_nom",
				"name": 		"est_cas_nom",
				"className": 	"text-left",
				"orderable": 	true
			},*/ 
			{
				"name": 		"est_cas_nom",
                "className": 		"text-center",
				"orderable": 	true,
				"render": 		function(data,type,row){
					let html = row.est_cas_nom;
					if(row.cas_est_pau == 0) html += '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';
						
					return html;

				}	
			},
			{
				"data"		: "est_tera_nom",
				"name"		: "est_tera_nom",
				"className"	: "text-center",
				"visible"	: true,
				"orderable"	: true,
				"searchable": true
			},
			{																					
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
                    var botonFichaCompleta = '<div class="col-12 text-center" style="display: flex; justify-content: center;">';
                    let urlFichaCompleta = $("#registrados").attr("attr2");
                    if(row.es_cas_id != 10){
                        botonFichaCompleta += `<button type="submit" class="btn btn-primary" style="margin-left: 10px; margin-right: 10px;" onclick="revertir(1, '${row.nna_run_con_formato}','${row.cas_id}',  '${row.est_cas_nom}', '${row.es_cas_id}')">Revertir Caso</button>`; 
                    }
                    return botonFichaCompleta;
				}
			},
            {																					
				"className": 	"text-center",
				"orderable": 	false,
				"searchable": 	false,
				"render": 		function(data,type,row){
                    var botonFichaCompleta = '<div class="col-12 text-center" style="display: flex; justify-content: center;">';
                    let urlFichaCompleta = $("#registrados").attr("attr2");
                    if(row.tera_id != null){
                        if(row.est_tera_id != 3){
                            botonFichaCompleta += `<button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right: 10px;" onclick="revertir(2, '${row.nna_run_con_formato}','${row.tera_id}','${row.est_tera_nom}', '${row.est_tera_id}')">Revertir Terapia</button></div>`;
                        }
                    } 
                    return botonFichaCompleta;
				}
			},
			{
				 "data": 		"nna_run",
				 "name": 		"nna_run",
				 "className": 	"text-center",
				 "visible": 	false
			},
			{
				"data": 		"cas_id",
				"name": 		"cas_id",
			 	"className": 	"text-center",
			 	"visible":      false
			}
			],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"drawCallback": function (settings){
				$("#totalNNA").text(settings._iRecordsTotal);
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

        desbloquearPantalla();
    }
    function revertir(tipo, run, caso, estado, id_estado){
        bloquearPantalla();
        let data = new Object();
        
        if(tipo == 1){
            $("#title").text("Caso: Revertir Estado")
            $("#run_nna").text(run);
            $("#label_tipo_nna").text("Caso: ");
            $("#tipo_nna").text(caso);
            $("#estado_actual").text(estado);
            $("#id_estado_actual").text(id_estado);
            data.cas_id = caso;
            $.ajax({
            type: "GET",
            url: "{{route('estadoCaso')}}",
            data: data
            }).done(function(resp){
                if(resp.estado == 1){
                    var html = '<option value=""> Seleccione estado a cambiar</option>';
                    for(var i = 0; i < resp.data.length; i++) {
                        if(resp.data[i].est_cas_id != id_estado){
                            if(resp.data[i].est_cas_id == 10){
                                html +='<option value = "' + resp.data[i].est_cas_id + '">' + resp.data[i].est_cas_nom + '</option>'; 
                            }else{
                                if(resp.data[i].est_cas_id < id_estado){
                                    html +='<option value = "' + resp.data[i].est_cas_id + '">' + resp.data[i].est_cas_nom + '</option>';
                                }
                            }
                            
                        }
                    }
                    $("#estado_cambiar").html(html);
                }
                
            desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
            });
            $("#btn_cambio_estado").attr("onclick","cambiarEstadoCaso()");
        }else{
            $("#title").text("Terapia: Revertir Estado")
            $("#run_nna").text(run);
            $("#label_tipo_nna").text("Terapia: ");
            $("#tipo_nna").text(caso);
            $("#estado_actual").text(estado);
            $("#id_estado_actual").text(id_estado);
            data.tera_id = caso;
            $.ajax({
            type: "GET",
            url: "{{route('estadoTerapia')}}",
            data: data
            }).done(function(resp){
                if(resp.estado == 1){
                    var html = '<option value=""> Seleccione estado a cambiar</option>'
                    for(var i = 0; i < resp.data.length; i++) {
                        if(resp.data[i].est_tera_id != id_estado){
                            if(resp.data[i].est_tera_id < id_estado){
                                html +='<option value = "' + resp.data[i].est_tera_id + '">' + resp.data[i].est_tera_nom + '</option>';
                            }
                        } 
                    }
                    $("#estado_cambiar").html(html);
                }
                
            desbloquearPantalla();
            }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
            });
            $("#btn_cambio_estado").attr("onclick","cambiarEstadoTerapia()");
        }
			$('#formBitacoraTerapia').modal('show');
    }
    function cambiarEstadoCaso($cas_id){
        let data = new Object();
        data.cas_id = $("#tipo_nna").text();
        data.est_cas_id_actual = $("#id_estado_actual").text();
        data.est_cas_id = $("#estado_cambiar").val();
        var r = confirm("¿Está seguro que desea realizar cambio de estado al caso?");
        if (r == true) {
            $.ajaxSetup({
			    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
            $.ajax({
                type: "POST",
                url: "{{route('revertir_estado_caso')}}",
                data: data
                }).done(function(resp){
                    alert(resp.mensaje);
                    $("#btn_cerrar_modal").click();
                    filtrarTabla();

                }).fail(function(objeto, tipoError, errorHttp){
                    desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
            });
        } 
    }
    function cambiarEstadoTerapia(){
        let data = new Object();
        data.id_tera = $("#tipo_nna").text();
        data.est_tera_id_actual = $("#id_estado_actual").text();
        data.est_tera_id = $("#estado_cambiar").val();
        var r = confirm("¿Está seguro que desea realizar cambio a la terapia?");
        if (r == true) {
            $.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
		});
        $.ajax({
            type: "POST",
            url: "{{route('revertir_estado_terapia')}}",
            data: data
            }).done(function(resp){
                alert(resp.mensaje);
                $("#btn_cerrar_modal").click();
                filtrarTabla();

            }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
        }
        
    }
    function limpiarFormulario(){
        let registrados = $('#registrados').DataTable();
        registrados.clear().destroy();
        $("#chkcomuna option:selected").prop('selected', false);

    }
</script>
@endsection
<!-- FIN CZ SPRINT 66 -->