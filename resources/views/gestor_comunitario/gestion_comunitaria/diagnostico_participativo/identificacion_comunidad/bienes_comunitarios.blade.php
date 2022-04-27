<div class="table-responsive">
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_bienes_comunes">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de Bienes</th>
                <th>Acceso a Bienes Comunes</th>
                @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
        @foreach ($acciones as $accion)
            @if ($accion->cod_accion == "GCM16")
             <button type="button" class="btn btn-success" onclick="bloquearPantalla(); {{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i> {{ $accion->nombre }}</button>
            @endif
        @endforeach
    @endif
</div>
<!-- INICIO CZ SPRINT 67 -->
<div id="frmBienesComunes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="formComponentesLabel"><b>Agregar Bienes Comunes</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>      
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Nombre:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="bien_com_nom" name="bien_com_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_bien_com_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Institución.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Tipo de Bienes:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="bien_com_tip" name="bien_com_tip" onchange="habilitarInputOtros(4,this)">
                            </select>
                            <p id="val_bien_com_tip" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar un Tipo de Bienes.</p>
                        </div>    
                    </div>
                    <div id="cont_bien_com_otr" class="form-group row" style="display: none">
                        <label for="" class="col-sm-3 col-form-label"><b>Otro Tipo de Bienes:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="bien_com_otr" name="bien_com_otr" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_bien_com_otr" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un un tipo de bienes.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Acceso:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="bien_com_acc" name="bien_com_acc" >
                                <option value="" >Seleccione una opcion</option>
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                                <option value="6" >6</option>
                                <option value="7" >7</option>
                            </select>
                            <small class="text-muted">(Evaluar acceso de 1 a 7)</small>
                            <p id="val_bien_com_acc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe seleccionar un valor de acceso.</p>
                        </div>    
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-success" id="registrar_bienes_comunes">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>
<input type="hidden" id="elem_bienes" nombre="elem_bienes" value="0">
<style type="text/css">
    .btn_bns_com{
        display: inline-block;
    }
</style>
<script type="text/javascript">
    let bienes_comunes_add = new Array();

    function dataBienesComunes(){
        $.ajax({
            type: "GET",
            url: "{{route('bienes.comunes')}}"
        }).done(function(resp){
            bien_com_tip = $.parseJSON(resp.bien_com_tip);

            $.each(bien_com_tip, function(i, item){
                $('#bien_com_tip').append('<option value="'+ item.bien_id +'">'+item.bien_nom+'</option>');    
            });
            

        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function limpiarfrmBienesComunales(){

        $("#bien_com_nom").val("");
        $("#bien_com_tip").prop('selectedIndex', 0);
        $("#bien_com_acc").val("");
        $('#bien_com_otr').val("");
        $('#cont_bien_com_otr').hide();

        $("#bien_com_nom").removeAttr('disabled');
        $("#bien_com_tip").removeAttr('disabled');
        $('#bien_com_otr').removeAttr('disabled');
        $("#bien_com_acc").removeAttr('disabled');
    }

    function limpiarfrmBienesComValidaciones(){

        $("#val_bien_com_nom").hide();
        $("#val_bien_com_tip").hide();
        $("#val_bien_com_acc").hide();
        $("#val_bien_com_otr").hide();

        $("#bien_com_nom").removeClass("is-invalid");
        $("#bien_com_tip").removeClass("is-invalid");
        $("#bien_com_acc").removeClass("is-invalid");
        $("#bien_com_otr").removeClass("is-invalid");

    }

    function validarfrmBienesComunes(){
        let respuesta = true;
        limpiarfrmBienesComValidaciones()
        
        let bien_com_nom =  $("#bien_com_nom").val();
        let bien_com_tip =  $("#bien_com_tip option:selected").val();
        let bien_com_otr =  $('#bien_com_otr').val();
        let bien_com_acc =  $("#bien_com_acc").val();

        if (bien_com_nom == "" || typeof bien_com_nom === "undefined"){
            respuesta = false;
            $("#val_bien_com_nom").show();
            $("#bien_com_nom").addClass("is-invalid");
        } 
        
        if (bien_com_tip == "" || typeof bien_com_tip === "undefined"){
            respuesta = false;
            $("#val_bien_com_tip").show();
            $("#bien_com_tip").addClass("is-invalid");
        }else if(bien_com_tip == 6){
            if (bien_com_otr == "" || typeof bien_com_otr === "undefined"){
                respuesta = false;
                $("#val_bien_com_otr").show();
                $("#bien_com_otr").addClass("is-invalid");
            }
        }
        
        
        if (bien_com_acc == "" || typeof bien_com_acc === "undefined"){
            respuesta = false;
            $("#val_bien_com_acc").show();
            $("#bien_com_acc").addClass("is-invalid");
        }        
        
        return respuesta;
    }

    function listarBienesComunes(){
		let tabla_bienes_comunes = $('#tabla_bienes_comunes').DataTable();
        tabla_bienes_comunes.clear().destroy();	

        let proceso = {{$pro_an_id}}

  		tabla_bienes_comunes = $('#tabla_bienes_comunes').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"lengthChange": false,
			"ajax": "{{ route('listar.bienes.data') }}/" + proceso,
			"columnDefs": [
            	{ //NOMBRE DE LA INSTITUCION
                    "width": "40%",
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //TIPO DE INSTITUCION
                    "width": "35%",
					"targets": 1,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //ACCESO
                    "width": "20%",
					"targets": 2,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
				{ //ACCIONES
                    "width": "5%",
					"targets": 3,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                @endif
    		],				
			"columns": [{ //NOMBRE DE LA INSTITUCION
							"data": "dg_bn_nom",
							"className": "text-center",
						},
						{ //TIPO DE INSTITUCION
							 "data": "dg_bn",
							 "className": "text-center",
						},
						{ //ACCESO
							"data": "dg_bn_acc",
							"className": "text-center"
						},
                        @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ACCIONES
							"data": "dg_bn_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = "";

                                @foreach ($acciones as $accion)
                                    @if ($accion->cod_accion == "GCM17")
                                        html += '<button type="button" class="btn btn-warning w-100 mb-1" data-dg-bn-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Editar</button>';
                                    @endif

                                    
                                    @if ($accion->cod_accion == "GCM18")
                                        html += '<button type="button" class="btn btn-danger w-100 mb-1" data-dg-bn-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Eliminar</button>';
                                    @endif
                                    

                                    @if ($accion->cod_accion == "GCM19")
                                        html += '<button type="button" class="btn btn-info w-100 mb-1" data-dg-bn-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Visualizar</button>';
                                    @endif
                                @endforeach
                                            //INICIO CZ SPRINT 67 correccion
                                            if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                                $('.btn-danger').attr('disabled', 'disabled');
                                            }
                                            //FIN CZ SPRINT 67 correccion
                                return html;
        						}
						},
                        @endif
					]
		});
	}

    function agregarBienesComunes(opc, id = null){
        let val_frm = validarfrmBienesComunes();
        if (val_frm == false) return false;

        bloquearPantalla();

        let data = new Object();
        if (opc == 1){ //AGREGAR
            data.dg_bn_id = id;
        }

        data.opc    = opc;
        data.info   = recolectarBienesComunes();

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });
        
        $.ajax({
            type: "POST",
            url: "{{route('registrar.bienes.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                listarBienesComunes();
                $("#frmBienesComunes").modal('hide');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function eliminarFrmBienesComunes(_this){
       let data = new Object();

       bloquearPantalla();

        data.dg_bn_id = $(_this).attr("data-dg-bn-id");

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.bienes.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                listarBienesComunes();
                mensajeTemporalRespuestas(1, resp.mensaje);

            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function recolectarBienesComunes(){
        let data_bienes = new Object();
        
        data_bienes.bien_com_nom =  $("#bien_com_nom").val();
        data_bienes.bien_com_tip =  $("#bien_com_tip option:selected").val();
        data_bienes.bien_com_otr =  $('#bien_com_otr').val();
        data_bienes.bien_com_acc =  $("#bien_com_acc").val();
        data_bienes.pro_an_id   = {{$pro_an_id}};

        return data_bienes;
    }

    function editarBienesComunes(_this){
        bloquearPantalla();

        let data = new Object();
        data.dg_bn_id = $(_this).attr("data-dg-bn-id");

        $.ajax({
            type: "GET",
            url: "{{ route('buscar.bienes.data') }}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){
                cambiarFuncionFormularioBienesComunes(1, resp);
               
            }else if (resp.estado == 0){
                desbloquearPantalla();

                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function visualizarFrmBienesComunes(_this){
        bloquearPantalla();

        let data = new Object();
        data.dg_bn_id = $(_this).attr("data-dg-bn-id");

        $.ajax({
            type: "GET",
            url: "{{ route('buscar.bienes.data') }}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){
                cambiarFuncionFormularioBienesComunes(2, resp);
               
            }else if (resp.estado == 0){
                desbloquearPantalla();

                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function cambiarFuncionFormularioBienesComunes(opc, resp = null){
        limpiarfrmBienesComunales();
        limpiarfrmBienesComValidaciones();

        $('#bien_com_tip').html('<option value="">Seleccione una opcion</option>');

        dataBienesComunes();

        if (opc == 0){ //AGREGAR
            $("#registrar_bienes_comunes").show();
            $("#registrar_bienes_comunes").attr("onclick", "agregarBienesComunes(0);");
            setTimeout(function(){ desbloquearPantalla(); }, 2000);

        }else if (opc == 1 || opc == 2){ //EDITAR - VISUALIZAR
            $("#bien_com_nom").val(resp.respuesta.dg_bn_nom);

            setTimeout(function(){ $("#bien_com_tip").prop('selectedIndex', resp.respuesta.bien_id); }, 2000);
            if (resp.respuesta.bien_id == 6){
                $('#cont_bien_com_otr').show();
                $('#bien_com_otr').val(resp.respuesta.dg_bn_otr);

            }    

            $("#bien_com_acc").val(resp.respuesta.dg_bn_acc);

            if (opc == 1){ //EDITAR
                $("#registrar_bienes_comunes").show();
                $("#registrar_bienes_comunes").attr("onclick", "agregarBienesComunes(1, "+resp.respuesta.dg_bn_id+");");
                

            }else if (opc == 2){ //VISUALIZAR
                $("#registrar_bienes_comunes").hide();
                $("#registrar_bienes_comunes").removeAttr("onclick");
            
                $("#bien_com_nom").prop('disabled', true);
                $("#bien_com_tip").prop('disabled', true);
                
                if (resp.respuesta.bien_id == 6){
                    $('#bien_com_otr').prop('disabled', true);

                }
                
                $("#bien_com_acc").prop('disabled', true);

            }    

            setTimeout(function(){ desbloquearPantalla(); }, 2000);
        }

        $("#frmBienesComunes").modal('show');
    }
</script>