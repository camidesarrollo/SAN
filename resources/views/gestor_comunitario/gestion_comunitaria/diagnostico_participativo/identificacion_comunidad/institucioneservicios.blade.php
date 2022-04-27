<div class="table-responsive">
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_instuciones_servicios">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de Institución <br>o <br>Servicio</th>
                <th>Acceso a Servicios</th>
                @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody></tbody>
    </table>


    @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
        @foreach ($acciones as $accion)
            @if ($accion->cod_accion == "GCM12")
            <button type="button" class="btn btn-success" onclick=" bloquearPantalla(); {{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i> {{ $accion->nombre }}</button>
            @endif
        @endforeach
    @endif
</div>
<!-- INICIO CZ SPRINT 67 -->
<div id="frmInstitucion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="formComponentesLabel"><b>Agregar Institución</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>      
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Nombre:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="ins_ser_nom" name="ins_ser_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_ins_ser_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Institución.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Tipo de Institución:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ins_ser_tip" name="ins_ser_tip" onchange="habilitarInputOtros(3,this)">
                                <option value="" >Seleccione una opcion</option>
                            </select>
                            <p id="val_ins_ser_tip" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar un Tipo de Institución.</p>
                        </div>    
                    </div>
                    <div id="cont_ins_tip_otr" class="form-group row" style="display: none">
                        <label for="" class="col-sm-3 col-form-label"><b>Otro Tipo de Institución:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="ins_tip_otr" name="ins_tip_otr" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_ins_tip_otr" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Institución.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Acceso:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ins_ser_acc" name="ins_ser_acc" >
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
                            <p id="val_ins_ser_acc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe seleccionar un valor de acceso.</p>
                        </div>    
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-success" id="registrar_inst_servicios">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>
<input type="hidden" id="elem_inst" nombre="elem_inst" value="0">
<style type="text/css">
    .btn_inst_serv{
        display: inline-block;
    }
</style>
<script type="text/javascript">
    let instituciones_servicios_add = new Array();

    function dataInstServicios(){
        $.ajax({
            type: "GET",
            url: "{{route('instituciones.servicios')}}"
        }).done(function(resp){


            ins_ser_tip = $.parseJSON(resp.ins_ser_tip);

            $.each(ins_ser_tip, function(i, item){
                $('#ins_ser_tip').append('<option value="'+ item.tip_int_id +'">'+item.tip_int_nom+'</option>');    
            });
            

        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function limpiarfrmInsServicios(){

        $("#ins_ser_nom").val("");
        $("#ins_ser_tip").prop('selectedIndex', 0);
        $("#ins_ser_acc").val("");
        $('#ins_tip_otr').val("");
        $('#cont_ins_tip_otr').hide();

        $("#ins_ser_nom").removeAttr('disabled');
        $("#ins_ser_acc").removeAttr('disabled');
        $("#ins_ser_tip").removeAttr('disabled');
        $('#ins_tip_otr').removeAttr('disabled');
    }

    function limpiarfrmInsServValidaciones(){

        $("#val_ins_ser_nom").hide();
        $("#val_ins_ser_tip").hide();
        $("#val_ins_ser_acc").hide();
        $("#val_ins_tip_otr").hide();

        $("#ins_ser_nom").removeClass("is-invalid");
        $("#ins_ser_tip").removeClass("is-invalid");
        $("#ins_ser_acc").removeClass("is-invalid");
        $("#ins_tip_otr").removeClass("is-invalid");

    }

    function validarfrmInstServicios(){
        let respuesta = true;
        limpiarfrmInsServValidaciones()
        
        let ins_ser_nom =  $("#ins_ser_nom").val();
        let ins_ser_tip =  $("#ins_ser_tip option:selected").val();
        let ins_ser_otr =  $('#ins_tip_otr').val();
        let ins_ser_acc =  $("#ins_ser_acc").val();

        if (ins_ser_nom == "" || typeof ins_ser_nom === "undefined"){
            respuesta = false;
            $("#val_ins_ser_nom").show();
            $("#ins_ser_nom").addClass("is-invalid");
        } 
        
        if (ins_ser_tip == "" || typeof ins_ser_tip === "undefined"){
            respuesta = false;
            $("#val_ins_ser_tip").show();
            $("#ins_ser_tip").addClass("is-invalid");
        }else if(ins_ser_tip == 17){
            if (ins_ser_otr == "" || typeof ins_ser_otr === "undefined"){
                respuesta = false;
                $("#val_ins_tip_otr").show();
                $("#ins_tip_otr").addClass("is-invalid");
            }
        }
        
        
        if (ins_ser_acc == "" || typeof ins_ser_acc === "undefined"){
            respuesta = false;
            $("#val_ins_ser_acc").show();
            $("#ins_ser_acc").addClass("is-invalid");
        }        
        
        return respuesta;
    }

    function listarInstitucionesServicios(){
		let tabla_instuciones_servicios = $('#tabla_instuciones_servicios').DataTable();
        tabla_instuciones_servicios.clear().destroy();	

        let proceso = {{$pro_an_id}}

  		tabla_instuciones_servicios = $('#tabla_instuciones_servicios').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"lengthChange": false,
			"ajax": "{{ route('listar.instituciones.data') }}/" + proceso,
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
							"data": "dg_ins_nom",
							"className": "text-center",
						},
						{ //TIPO DE INSTITUCION
							 "data": "dg_ins",
							 "className": "text-center",
						},
						{ //ACCESO
							"data": "dg_ins_acc",
							"className": "text-center"
						},
                        @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
						{ //ACCIONES
							"data": "dg_ins_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                let html = "";

                                @foreach ($acciones as $accion)
                                    @if ($accion->cod_accion == "GCM13")
                                        html += '<button type="button" class="btn btn-warning w-100 mb-1" data-dg-ins-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> {{ $accion->nombre }}</button>';
                                    @endif

                                    @if ($accion->cod_accion == "GCM14")
                                        html += '<button type="button" class="btn btn-danger w-100 mb-1" data-dg-ins-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> {{ $accion->nombre }}</button>';
                                    @endif

                                    @if ($accion->cod_accion == "GCM15")
                                        html += '<button type="button" class="btn btn-info w-100 mb-1" data-dg-ins-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> {{ $accion->nombre }}</button>';
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

    function agregarInstServicios(opc, id = null){
        let val_frm = validarfrmInstServicios();
        // INICIO CZ SPRINT 67
            let iden_com_pri = $("#iden_com_pri").val();
            if (iden_com_pri == "" || typeof iden_com_pri === "undefined"){
                $("#iden_com_pri").show();
                $("#iden_com_pri").addClass("is-invalid");
                alert("Debe ingresar la identificación de la comunidad priorizada")
                return false;
            }
        // FIN CZ SPRINT 67
        if (val_frm == false) return false;

        bloquearPantalla();

        let data = new Object();
        data.opc = opc;

        if (opc == 1){ //AGREGAR
            data.dg_ins_id = id;
        }

        data.info = recolectarInstServicios();

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });
        
        $.ajax({
            type: "POST",
            url: "{{route('registrar.instituciones.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                listarInstitucionesServicios();
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#iden_num_ins").val(resp.cont);

                $("#frmInstitucion").modal('hide');
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function eliminarFrmInstServicios(_this){
       bloquearPantalla(); 

       let data = new Object();

        data.dg_ins_id = $(_this).attr("data-dg-ins-id");
        data.pro_an_id = {{$pro_an_id}};

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.instituciones.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                listarInstitucionesServicios();
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#iden_num_ins").val(resp.cont); 

            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function recolectarInstServicios(){
        let data_serv = new Object();
        
        data_serv.ins_ser_nom =  $("#ins_ser_nom").val();
        data_serv.ins_ser_tip =  $("#ins_ser_tip option:selected").val();
        data_serv.ins_ser_otr =  $('#ins_tip_otr').val();
        data_serv.ins_ser_acc =  $("#ins_ser_acc").val();
        data_serv.pro_an_id   =  {{$pro_an_id}};
        return data_serv;
    }


    function editarInstServicios(_this){
        bloquearPantalla();

        let data = new Object();
        data.dg_ins_id = $(_this).attr("data-dg-ins-id");

        $.ajax({
            type: "GET",
            url: "{{ route('buscar.instituciones.data') }}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){
                cambiarModoFormularioInstServicios(1, resp);
               
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

    function visualizarInstServicios(_this){
        bloquearPantalla();

        let data = new Object();
        data.dg_ins_id = $(_this).attr("data-dg-ins-id");

        $.ajax({
            type: "GET",
            url: "{{ route('buscar.instituciones.data') }}",
            data: data
        }).done(function(resp){
            if(resp.estado == 1){
                cambiarModoFormularioInstServicios(2, resp);
               
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

    function cambiarModoFormularioInstServicios(opc, resp = null){
        limpiarfrmInsServicios();
        limpiarfrmInsServValidaciones();

        $('#ins_ser_tip').html('<option value="">Seleccione una opcion</option>');   

        dataInstServicios();

        if (opc == 0){ //AGREGAR
            $("#registrar_inst_servicios").show();
            $("#registrar_inst_servicios").attr("onclick", "agregarInstServicios(0);");
            setTimeout(function(){ desbloquearPantalla(); }, 2000);

        }else if (opc == 1 || opc == 2){ //EDITAR - VISUALIZAR
            $("#ins_ser_nom").val(resp.respuesta.dg_ins_nom);
            $("#ins_ser_acc").val(resp.respuesta.dg_ins_acc);
            
            setTimeout(function(){ $("#ins_ser_tip").prop('selectedIndex', resp.respuesta.tip_int_id); }, 2000);
            if (resp.respuesta.tip_int_id == 17){
                $('#cont_ins_tip_otr').show();
                $('#ins_tip_otr').val(resp.respuesta.dg_ins_otr);

            }

            if (opc == 1){ //EDITAR
                $("#registrar_inst_servicios").show();
                $("#registrar_inst_servicios").attr("onclick", "agregarInstServicios(1, "+resp.respuesta.dg_ins_id+");");

            }else if (opc == 2){ //VISUALIZAR
                $("#registrar_inst_servicios").hide();
                $("#registrar_inst_servicios").removeAttr("onclick");
            
                $("#ins_ser_nom").prop('disabled', true);
                $("#ins_ser_acc").prop('disabled', true);
                $("#ins_ser_tip").prop('disabled', true);
                $('#ins_tip_otr').prop('disabled', true);
            }    
            
            setTimeout(function(){ desbloquearPantalla(); }, 2000);
        }

        $("#frmInstitucion").modal('show');
    }
</script>