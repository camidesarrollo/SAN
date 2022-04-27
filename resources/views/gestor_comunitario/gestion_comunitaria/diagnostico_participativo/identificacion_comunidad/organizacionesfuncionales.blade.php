<div class="table-responsive">
    <table class="table table-striped table-hover" cellspacing="0" id="tabla_organizaciones_funcionales">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de Organización</th>
                <th>Grado de Formalización</th>
                <th>Nombre Representante</th>
                <th>Teléfono Representante</th>
                <th>Correo Representante</th>
                @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
		

        <!-- <tbody style="font-weight: 100;"></tbody> -->
        <tbody></tbody>
    </table>
    @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
        @foreach ($acciones as $accion)
            @if ($accion->cod_accion == "GCM11")
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#frmorgfuncionales" onclick="bloquearPantalla(); {{ $accion->ruta }}"><i class="{{ $accion->clase }}"></i> {{ $accion->nombre }}</button>
            @endif
        @endforeach
    @endif
</div>
<!-- INICIO CZ SPRINT 67 -->
<div id="frmorgfuncionales" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formComponentesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- FIN CZ SPRINT 67 -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <h5 class="modal-title text-center" id="formComponentesLabel"><b>Agregar Organización</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
                </button>
                <br>
                <form>      
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Nombre de la Organización:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_nom_org" name="org_nom_org" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_org_nom_org" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una Oragnizacion.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Tipo de Organización:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="org_tip_org" name="org_tip_org" onchange="habilitarInputOtros(1,this);" >
                                <option value="" >Seleccione una opción</option>
                            </select>
                            <p id="val_org_tip_org" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar un Tipo de Orgaización.</p>
                        </div>    
                    </div>
                    <div id="cont_org_tip_otr" class="form-group row" style="display: none">
                        <label for="" class="col-sm-3 col-form-label"><b>Otro Tipo de Organización:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_tip_otr" name="org_tip_otr" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_org_tip_otr" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un tipo de organización.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><b>Grado de Formalización:</b></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="org_gra_for" name="org_gra_for" onchange="habilitarInputOtros(2,this)">
                                <option value="" >Seleccione una opción</option>
                            </select>
                            <p id="val_org_gra_for" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Seleccionar el grado de formalización.</p>
                        </div>    
                    </div>
                    <div id="cont_org_gra_otr" class="form-group row" style="display: none">
                        <label for="" class="col-sm-3 col-form-label"><b>Otro Grado de Formalización:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_gra_otr" name="org_gra_otr" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_org_gra_otr" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un grado de formalización.</p>
                        </div>                              
                    </div>
                    <br>
                    <br>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Nombre de Representante:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_rep_nom" name="org_rep_nom" onkeypress="return caracteres_especiales(event)" type="input" class="form-control">
                            <p id="val_org_rep_nom" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un nombre.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Teléfono:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_rep_tel" name="org_rep_tel" onkeypress="return soloNumeros(event)" type="input" class="form-control">
                            <p id="val_org_rep_tel" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar una teléfono.</p>
                        </div>                              
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"><b>Correo:</b></label>
                        <div class="col-sm-9">
                            <input maxlength="100" id="org_rep_cor" name="org_rep_cor" onkeypress="" type="input" class="form-control">
                            <p id="val_org_rep_cor" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe ingresar un correo.</p>
                        </div>                              
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-success" id="btn_guardar_org">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>					
            </div>                
        </div>
    </div>
</div>

<input type="hidden" id="elem_org" nombre="elem_org" value="0">
<script type="text/javascript">
    let organizacion_funcionales_add = new Array();

    function dataOrgFuncionales(){

        $.ajax({
            type: "GET",
            url: "{{route('organizacion.funcionales')}}"
        }).done(function(resp){


            tip_org = $.parseJSON(resp.tip_org);
            gra_for = $.parseJSON(resp.gra_for);

            $.each(gra_for, function(i, item){
                $('#org_gra_for').append('<option value="'+ item.gra_for_id +'">'+item.gra_for_nom+'</option>');                                           
            });

            $.each(tip_org, function(i, item){
                $('#org_tip_org').append('<option value="'+ item.tip_org_id +'">'+item.tip_org_nom+'</option>');    
            });
            

        }).fail(function(objeto, tipoError, errorHttp){            

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }    

    function limpiarfrmOrgFuncionales(){
        $("#org_nom_org").val("");
        $("#org_tip_org").prop('selectedIndex', 0);
        $("#org_gra_for").prop('selectedIndex', 0);
        $("#org_rep_nom").val("");
        $("#org_rep_tel").val("");
        $("#org_rep_cor").val("");
        $("#org_tip_otr").val("");        
        $("#org_gra_otr").val("");
        $('#cont_org_tip_otr').hide();
        $('#cont_org_gra_otr').hide();

        $("#org_nom_org").removeAttr("disabled");
        $("#org_tip_org").removeAttr("disabled");
        $("#org_gra_for").removeAttr("disabled");
        $("#org_rep_nom").removeAttr("disabled");
        $("#org_rep_tel").removeAttr("disabled");
        $("#org_rep_cor").removeAttr("disabled");
        $("#org_tip_otr").removeAttr("disabled");        
        $("#org_gra_otr").removeAttr("disabled");
    }

    function limpiarfrmOrgValidaciones(){

        $("#val_org_nom_org").hide();
        $("#val_org_tip_org").hide();
        $("#val_org_gra_for").hide();
        $("#val_org_rep_nom").hide();
        $("#val_org_rep_tel").hide();
        $("#val_org_rep_cor").hide();
        $("#val_org_tip_otr").hide();
        $("#val_org_gra_otr").hide();
        
        $("#org_nom_org").removeClass("is-invalid");
        $("#org_tip_org").removeClass("is-invalid");
        $("#org_gra_for").removeClass("is-invalid");
        $("#org_rep_nom").removeClass("is-invalid");
        $("#org_rep_tel").removeClass("is-invalid");
        $("#org_rep_cor").removeClass("is-invalid");
        $("#org_tip_otr").removeClass("is-invalid");        
        $("#org_gra_otr").removeClass("is-invalid");
    }

    function validarfrmOrgFuncionales(){
        let respuesta = true;
        limpiarfrmOrgValidaciones()       
        let org_nom =  $("#org_nom_org").val();
        let org_tip =  $("#org_tip_org option:selected").val();
        let org_tip_ot  =  $("#org_tip_otr").val();
        let org_gra =  $("#org_gra_for option:selected").val();
        let org_gra_ot  =  $("#org_gra_otr").val();
        let org_rep =  $("#org_rep_nom").val();
        let org_tel =  $("#org_rep_tel").val();
        let org_cor =  $("#org_rep_cor").val();

        if (org_nom == "" || typeof org_nom === "undefined"){
            respuesta = false;
            $("#val_org_nom_org").show();
            $("#org_nom_org").addClass("is-invalid");
        } 
        
        if (org_tip == "" || typeof org_tip === "undefined"){
            respuesta = false;
            $("#val_org_tip_org").show();
            $("#org_tip_org").addClass("is-invalid");
        }else if (org_tip == 17){
            if (org_tip_ot == "" || typeof org_tip_ot === "undefined"){
                respuesta = false;
                $("#val_org_tip_otr").show();
                $("#org_tip_otr").addClass("is-invalid");
            }
        }
        
        if (org_gra == "" || typeof org_gra === "undefined"){
            respuesta = false;
            $("#val_org_gra_for").show();
            $("#org_gra_for").addClass("is-invalid");
        }else if (org_gra == 5){
            if (org_gra_ot == "" || typeof org_gra_ot === "undefined"){
                respuesta = false;
                $("#val_org_gra_otr").show();
                $("#org_gra_otr").addClass("is-invalid");
            }
        }
        
        if (org_rep == "" || typeof org_rep === "undefined"){
            respuesta = false;
            $("#val_org_rep_nom").show();
            $("#org_rep_nom").addClass("is-invalid");
        }
        
        if (org_tel == "" || typeof org_tel === "undefined"){
            respuesta = false;
            $("#val_org_rep_tel").show();
            $("#org_rep_tel").addClass("is-invalid");
        }
        
        // INICIO CZ SPRINT 67  
        // if (org_cor == "" || typeof org_cor === "undefined"){
        //     respuesta = false;
        //     $("#val_org_rep_cor").show();
        //     $("#org_rep_cor").addClass("is-invalid");
        // }
        // FIN CZ SPRINT 67
        
        return respuesta;
    }

    function listarOrganizacionesFuncionales(){
		let organizaciones_funcionales = $('#tabla_organizaciones_funcionales').DataTable();
        organizaciones_funcionales.clear().destroy();	

        let proceso = {{$pro_an_id}}

  		organizaciones_funcionales = $('#tabla_organizaciones_funcionales').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"lengthChange": false,
			"ajax": "{{ route('listar.organizacion.data') }}/" + proceso,
			"columnDefs": [
            	{ //NOMBRE DE ORGANIZACIÓN
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //TIPO DE ORGANIZACIÓN
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //GRADO DE FORMALIZACIÓN
					"targets": 2,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //NOMBRE DE REPRESENTANTE
					"targets": 3,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //TELÉFONO
					"targets": 4,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //CORREO
					"targets": 5,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
    				{ //ACCIONES
    					"targets": 6,
    					"className": 'dt-head-center dt-body-center',
    					"createdCell": function (td, cellData, rowData, row, col) {
    				        $(td).css("vertical-align", "middle");
    				     
    				    }
    				},
                @endif
    		],				
			"columns": [{ //NOMBRE DE ORGANIZACIÓN
							"data": "dg_org_nom",
							"className": "text-center",
						},
						{ //TIPO DE ORGANIZACIÓN
							 "data": "tip_org",
							 "className": "text-center",
						},
						{ //GRADO DE FORMALIZACIÓN
							"data": "gra_for",
							"className": "text-center"
						},
						{ //NOMBRE DE REPRESENTANTE
							"data": "dg_org_nom_rep",
							"className": "text-center"
						},
						{ //TELÉFONO
							"data": "dg_org_telf",
							"className": "text-center"
						},
						{ //CORREO
							"data": "dg_org_cor",
							"className": "text-center"
						},
                        @if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario'))
        						{ //ACCIONES
        							"data": "dg_org_id",
                                    "className": "text-center",
                                    "render": function(data, type, row){
                                        let html = "";

                                        @foreach ($acciones as $accion)
                                            @if ($accion->cod_accion == "GCM08")
                                                html += '<button type="button" class="btn btn-warning w-100 mb-1" data-dg-org-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Editar</button>';
                                            @endif

                                            
                                            @if ($accion->cod_accion == "GCM09")
                                                html += '<button type="button" class="btn btn-danger w-100 mb-1 eliminar" data-dg-org-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Eliminar</button>';
                                            @endif
                                            

                                            @if ($accion->cod_accion == "GCM10")
                                                html += '<button type="button" class="btn btn-info w-100 mb-1" data-dg-org-id="'+data+'" onclick="{{ $accion->ruta }}"><span class="{{ $accion->clase }}"></span> Visualizar</button>';
                                            @endif
                                        @endforeach
                                            //INICIO CZ SPRINT 67 correccion
                                            if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                                $('.eliminar').attr('disabled', 'disabled');
                                            }
                                            //FIN CZ SPRINT 67 correccion
                                        return html;
                					}
        						}
                        @endif
					]
		});
	}

    function agregarOrganizacionFuncional(opc, id = null){
        let val_frm = validarfrmOrgFuncionales();
        if (val_frm == false) return false;
        // INICIO CZ SPRINT 67
        let iden_com_pri = $("#iden_com_pri").val();
        if (iden_com_pri == "" || typeof iden_com_pri === "undefined"){
            $("#iden_com_pri").show();
            $("#iden_com_pri").addClass("is-invalid");
            alert("Debe ingresar la identificación de la comunidad priorizada")
            return false;
        }
        // FIN CZ SPRINT 67

        let data = new Object();

        data.opc = opc;

        if (opc == 1){ //EDITAR
            data.dg_org_id = id;

        }

        data.info = recolectarOrgFuncional();

        bloquearPantalla();

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });
        
        $.ajax({
            type: "GET",
            url: "{{route('registrar.organizacion.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                listarOrganizacionesFuncionales();
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#iden_num_org").val(resp.cont);

                $("#frmorgfuncionales").modal('hide');
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            
            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();
            
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function eliminarFrmOrganizacion(_this){
        bloquearPantalla();    

        let data = new Object();
        data.dg_org_id = $(_this).attr("data-dg-org-id");
        data.pro_an_id = {{$pro_an_id}};

        $.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	 		}
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.organizacion.data')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                listarOrganizacionesFuncionales()
                mensajeTemporalRespuestas(1, resp.mensaje);
                $("#iden_num_org").val(resp.cont);

            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function recolectarOrgFuncional(){
        let data_org = new Object();        
        
        data_org.org_nom     =  $("#org_nom_org").val();
        data_org.org_tip_id  =  $("#org_tip_org option:selected").val();
        data_org.org_tip_ot  =  $("#org_tip_otr").val();
        data_org.org_gra_id  =  $("#org_gra_for option:selected").val();
        data_org.org_gra_ot  =  $("#org_gra_otr").val();
        data_org.org_rep     =  $("#org_rep_nom").val();
        data_org.org_tel     =  $("#org_rep_tel").val();
        data_org.org_cor     =  $("#org_rep_cor").val();
        data_org.pro_an_id   =  {{$pro_an_id}}

        return data_org;
    }


    function editarOrgFuncional(_this){
        let data = new Object();
        data.dg_org_id = $(_this).attr("data-dg-org-id");

        bloquearPantalla();

        $.ajax({
            type: "GET",
            url: "{{route('buscar.organizacion.data')}}",
            data: data
        }).done(function(resp){
            if (resp.estado == 1){
                cambiarFuncionFormularioOrg(1, resp);
                
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

    function visualizarFrmOrganizacion(_this){
        let data = new Object();
        data.dg_org_id = $(_this).attr("data-dg-org-id");

        bloquearPantalla();

        $.ajax({
            type: "GET",
            url: "{{route('buscar.organizacion.data')}}",
            data: data
        }).done(function(resp){
            if (resp.estado == 1){
                cambiarFuncionFormularioOrg(2, resp);
                
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

    function cambiarFuncionFormularioOrg(opc, resp = null){
        limpiarfrmOrgFuncionales();
        limpiarfrmOrgValidaciones();

        $('#org_gra_for').html('<option value="">Seleccione una opción</option>');                                           
        $('#org_tip_org').html('<option value="">Seleccione una opción</option>');    

        dataOrgFuncionales();

        if (opc == 0){ //AGREGAR
            $("#btn_guardar_org").show();
            $("#btn_guardar_org").attr("onclick", "agregarOrganizacionFuncional(0);");
             setTimeout(function(){ desbloquearPantalla(); }, 2000);
        
        }else if (opc == 1 || opc == 2){ //EDITAR - VISUALIZAR
            $("#org_nom_org").val(resp.respuesta.dg_org_nom);

            setTimeout(function(){ $("#org_tip_org").prop('selectedIndex', resp.respuesta.tip_org_id); }, 2000);
            if (resp.respuesta.tip_org_id == 17){
                $("#org_tip_otr").val(resp.respuesta.tip_org_otr);
                $("#cont_org_tip_otr").show();
            }

            setTimeout(function(){ $("#org_gra_for").prop('selectedIndex', resp.respuesta.gra_for_id); }, 2000);    
            if (resp.respuesta.gra_for_id == 5){
                $("#org_gra_otr").val(resp.respuesta.gra_for_otr);
                $("#cont_org_gra_otr").show();
            }

            $("#org_rep_nom").val(resp.respuesta.dg_org_nom_rep);
            $("#org_rep_tel").val(resp.respuesta.dg_org_telf);
            $("#org_rep_cor").val(resp.respuesta.dg_org_cor);

            if (opc == 1){ //EDITAR
                $("#btn_guardar_org").show();
                $("#btn_guardar_org").attr("onclick", "agregarOrganizacionFuncional(1, "+resp.respuesta.dg_org_id+");");

            }else if (opc == 2){ //VISUALIZAR
                $("#btn_guardar_org").hide();
                $("#btn_guardar_org").removeAttr("onclick");

                $("#org_nom_org").prop('disabled', true);
                $("#org_tip_org").prop('disabled', true); 
                if (resp.respuesta.tip_org_id == 17){
                    $("#org_tip_otr").prop('disabled', true);
                
                }

                $("#org_gra_for").prop('disabled', true);   
                if (resp.respuesta.gra_for_id == 5){
                    $("#org_gra_otr").prop('disabled', true);
                
                }

                $("#org_rep_nom").prop('disabled', true);
                $("#org_rep_tel").prop('disabled', true);
                $("#org_rep_cor").prop('disabled', true);
            }

            setTimeout(function(){ desbloquearPantalla(); }, 2000);
        
        }

        $("#frmorgfuncionales").modal('show');
    }
</script>