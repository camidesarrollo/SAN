{{ csrf_field() }}
@if($est_pro_id != config('constantes.plan_estrategico'))
<div class="card colapsable shadow-sm" id="contenedor_info_anexos_documentos">
    <a class="btn text-left p-0 collapsed" id="desplegar_info_anexos_documentos" data-toggle="collapse" data-target="#info_anexos_documentos" aria-expanded="false" aria-controls="info_anexos_documentos" >
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Anexos Informe Diagnóstico Participativo
			</h5>
		</div>
	</a>

	<div class="collapse" id="info_anexos_documentos">
            <div class="card-body">
                <div class="input-group mb-3">
                    <!-- <form enctype="multipart/form-data" id="adj_info_anex" method="post" onsubmit="cargarInformeAnexos();">
                        <div class="custom-file" style="z-index:0;">
                                <input type="file" class="custom-file-input " name="doc_anex" id="doc_anex" onchange="$('#adj_info_anex').submit();">
                                <label class="custom-file-label" for="doc_anex" aria-describedby="inputGroupFileAddon01">Cargar archivo</label>
                        </div>
                    </form> -->
                    
                    <form method="post" action="#" enctype="multipart/form-data" id="adj_anexoDiag">
                        <div class="custom-file" style="z-index:0;">
                                    <input type="file" class="custom-file-input" name="doc_anexoDiag" id="doc_anexoDiag">
                                    <label class="custom-file-label" for="doc_anexoDiag" aria-describedby="inputGroupFileAddon02">Cargar archivo</label>
                            </div>
										
                    </form>
                </div>
                <div style="margin-top: -15px; margin-left: 2px;"><small>Sólo subir archivos con las siguientes extensiones: ".pdf", ".doc" y ".docx".</small></div>
                <br>
                <div class="alert alert-success alert-dismissible fade show" id="alert-doc-anexo" role="alert" style= "display:none">
                    Documento Guardado Exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-anexo" role="alert" style="display: none;">
                    Error al momento de guardar el registro. Por favor intente nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="alert-err-doc-ext-anexo" role="alert" style="display: none;">
                    EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: ".pdf", ".doc" y ".docx"
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>                
                <br>
            </div>
	</div>
</div>

@endif
<div class="card colapsable shadow-sm">
	<a class="btn text-left p-0" id="btn_despliegue_historial_enexos"  data-toggle="collapse" data-target="#listar_historial_anexos"aria-expanded="false" aria-controls="listar_historial_anexos" onclick="if($(this).attr('aria-expanded') == 'false') listarInformeAnexos();">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;Historial de Anexos
			</h5>
		</div>
	</a>
	<div class="container-fluid collapse" id="listar_historial_anexos">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table"  style="width: 100%;" id="tabla_info_anexos" >
					<thead>
						<tr>
							<th>Fecha Creación</th>
							<th>Documento</th>
							<th>Acciones</th>
						</tr>
					</thead>
				    <tbody></tbody>
			    </table>
		    </div>
	    </div>
    </div>
</div>
<!-- INICIO CZ SPRINT 67 -->
<meta name="_token" content="{{ csrf_token() }}">
<div class="modal fade" id="eliminarAnexo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar la eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p>Está a punto de borrar una documento, este procedimiento es irreversible.</p>
                <p>¿Quieres continuar?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar-modal-confirm">Cancel</button>
                <button type="button" class="btn btn-danger" id ="btnConfimAnexo" onclick="">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
function eliminar(id, proceso,){
    let data = new Object();
    data.id = id;
    data.id_pro_an_id = proceso;
    $.ajaxSetup({
			    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
    $.ajax({
            type:"post",
            url: "{{route('eliminarAnexo')}}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){
                $('#eliminarAnexo').modal('hide');
                toastr.success(resp.mensaje);    
                listarInformeAnexos();   
            }
        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
}
</script>
<!-- FIN CZ SPRINT 67 -->

<script type="text/javascript">
// INICIO CZ SPRINT 67
function eliminarDocAnexo(id, pro_an_id, tipo){
    if(tipo == 'dpc'){
        document.getElementById('btnConfimAnexo').setAttribute('onclick','eliminar('+id+','+pro_an_id+')');
    }
   
}
// FIN CZ SPRINT 67
    function listarInformeAnexos(){

        let tabla_info_anexos = $('#tabla_info_anexos').DataTable();
        tabla_info_anexos.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_info_anexos = $('#tabla_info_anexos').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.informe.anexos') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //FECHA DE CREACION
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //NOMBRE DEL DOCUMENTO
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
                        { //FECHA DE CREACION
                            "data": "created_at",
                            "className": "text-center"
                        },
                        { //NOMBRE DEL DOCUMENTO
                            "data": "anex_nom",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "anex_nom",
                            "className": "text-center",
                            "render": function(data, type, row){
                                    // INICIO CZ SPRINT 67
                                    var tipo =  'dpc';
                                    let html = `<a download href="${row.ruta}"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</button></a><button type="button" class="btn btn-danger" OnClick="eliminarDocAnexo(${row.anex_id},${row.pro_an_id}, '${tipo}')" data-toggle="modal" data-target="#eliminarAnexo" style="margin-left:5px">Eliminar</button>`;   
                                    // FIN CZ SPRINT 67
                                      //INICIO CZ SPRINT 67 correccion
                                      if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                            $('.btn-danger').attr('disabled', 'disabled');
                                        }
                                    //FIN CZ SPRINT 67 correccion  
                                        return html;
                                    }
                        }
                    ]
        });
        
    }

    function cargarInformeAnexos(){      
        bloquearPantalla();  

        // agrego la data del form a formData
        var form = document.getElementById('adj_info_anex');
        let formData = new FormData(form);
        formData.append('pro_an_id', {{$pro_an_id}});
        formData.append('_token', $('input[name=_token]').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('cargar.documento.anexos') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){
                desbloquearPantalla();

                if (resp.estado == 1){

                    $("#alert-err-doc").hide();
                    $("#alert-err-doc-ext").hide();
                    $("#alert-doc").show();
                    listarInformeAnexos();
                
                    setTimeout(function(){ 
                        $("#alert-doc").hide();
                    }, 3000);                    

                }else if (resp.estado == 0){
                    $("#alert-err-doc").show();
                    setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
                }else{
                    $("#alert-err-doc-ext").show();
                    setTimeout(function(){ $("#alert-err-doc-ext").hide(); }, 5000);
                }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            $("#alert-err-doc-ext").show();
            setTimeout(function(){ $("#alert-err-doc").hide(); }, 5000);
            setTimeout(function(){ $("#alert-err-doc-ext").hide(); }, 5000);

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });


    }

</script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

<script>
$(document).ready(function() {
	$("#doc_anexoDiag").change(function(e) {
			$("#adj_anexoDiag").submit();
	});

	$("#adj_anexoDiag").submit(function(e){
		bloquearPantalla();  		

	// evito que propague el submit
	e.preventDefault();

		var form = document.getElementById('adj_anexoDiag');
                
		var formData = new FormData(form);
		  formData.append('tipo', $("#adj_anexoDiag").val());
		  formData.append('_token', $('input[name=_token]').val());
		formData.append('_token', $('input[name=_token]').val());
        formData.append('pro_an_id', {{$pro_an_id}});
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
		});

        $.ajax({
            url: '{{ route("cargar.documento.anexos") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
				console.log(response);
                desbloquearPantalla();

                if (response.estado == 1){
                    $("#alert-doc-anexo").css('display', 'block')
                    $("#alert-err-doc-anexo").css('display', 'none');
                    $("#alert-err-doc-ext-anexo").css('display', 'none');
                    listarInformeAnexos();

                    setTimeout(function(){ 
                        $("#alert-doc-anexo").css('display', 'none');
                    }, 3000);                    

                }else if (response.estado == 0){
                    $("#alert-err-doc-anexo").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-anexo").css('display', 'none'); }, 5000);
                }else{
                    $("#alert-err-doc-ext-anexo").css('display', 'block');
                    setTimeout(function(){ $("#alert-err-doc-ext-anexo").css('display', 'none'); }, 5000);
                }
            },
			error: function(jqXHR, text, error){
                desbloquearPantalla();

                $("#alert-err-doc-ext-anexo").css('display', 'block');
                setTimeout(function(){ $("#alert-doc-anexo").css('display', 'none'); }, 5000);
                setTimeout(function(){ $("#alert-err-doc-ext-anexo").css('display', 'none'); }, 5000);

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

			}
        });
        return false;
	});
});
</script>
