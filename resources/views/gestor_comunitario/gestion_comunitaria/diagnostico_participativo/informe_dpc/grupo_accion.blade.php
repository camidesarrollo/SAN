<!--  CONFORMACION DEL GRUPO DE ACCION -->
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
            <h5 class="mb-0 p-2">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;Conformación del Grupo de Acción
            </h5>
		</div>
	</div>
	<div class="card-body">
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <textarea name="grupo_conf" id="grupo_conf" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo8()" onKeyDown="valTextAreaInfo8()" class="form-control" cols="30" rows="5" style="resize: none" onblur="registrarInforme();" placeholder="Breve descripción del proceso de conformación del Grupo de Acción, identificando estrategias, hitos, facilitadores y obstaculizadores. "></textarea>
            <div class="row">
                <div class="col">
                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                </div>
                <div class="col text-left">
                    <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_grupo_conf" style="color: #000000;">0</strong></small></h6>
                </div>        
            </div>
            <p id="val_grupo_conf" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una Conformación del Grupo de Acción.</p>
        @else
            <label id="grupo_conf" for=""></label>
        @endif
    </div>
</div>

<!--  CONFORMACION DEL GRUPO DE ACCION -->

<!-- INTEGRANTES DE GRUPO DE ACCION -->
<div class="card colapsable shadow-sm" id="contenedor_intro_caracteristicas_int">
    <a class="btn text-left p-0 collapsed" id="desplegar_intro_caracteristicas_int" data-toggle="collapse" data-target="#intro_caracteristicas_int" aria-expanded="false" aria-controls="intro_caracteristicas_int" onclick="listarIntegrantesGrupo();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp; Integrantes del Grupo de Acción
            </h5>
        </div>
    </a>

    <div class="collapse" id="intro_caracteristicas_int">
        <div class="card-body">
            <br>
            <label for=""> Caracterizar a cada uno de los integrantes del Grupo de Acción. </label>
            <br>
            <div class="form-group">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_grupo_accion">
                    <thead>
                        <tr>
                            <th>Nombres y Apellidos</th>
                            <th>Rut</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Rol en el grupo de acción </th>
                            @if($est_pro_id != config('constantes.plan_estrategico'))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!-- INICIO DC -->
                <button type="button" class="btn btn-outline-success btnAddGA" data-toggle="modal" data-target="#frmintegrantesgrupo" onclick="limpiarIntegrantesfrm();"><i class="fa fa-plus-circle"></i> Agregar Integrante</button>                                
            	<!-- FIN DC -->
            </div>                          
        </div>
    </div>
</div>
<!-- INTEGRANTES DE GRUPO DE ACCION -->

<!-- PLANIFICACION DE ACTIVIDADES DPC -->
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
            <h5 class="mb-0 p-2">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;Planificación de actividades del Diagnóstico Participativo Comunitario
            </h5>
		</div>
	</div>
	<div class="card-body">
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <textarea name="grupo_plan" id="grupo_plan" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo9()" onKeyDown="valTextAreaInfo9()" class="form-control" cols="30" rows="5" style="resize: none" onblur="registrarInforme();" placeholder="Describir brevemente el proceso de planificación del DPC junto al Grupo de Acción, indicando "></textarea>
            <div class="row">
                <div class="col">
                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                </div>
                <div class="col text-left">
                    <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_grupo_plan" style="color: #000000;">0</strong></small></h6>
                </div>        
            </div>
            <p id="val_grupo_plan" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una Planificación de actividades.</p>
        @else
            <label id="grupo_plan" for=""></label>
        @endif
    </div>
</div>
<!-- PLANIFICACION DE ACTIVIDADES DPC -->

 <!-- HIDDEN -->
    <input type="hidden" name="hid_int_id" id="hid_int_id" value="">
    <input type="hidden" name="hid_rut_val" id="hid_rut_val" value="0">
 <!-- HIDDEN -->

<!-- MODAL DE INTEGRANTES GRUPO FAMILIAR -->
@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.modal_grupo_accion')
<!-- MODAL DE INTEGRANTES GRUPO FAMILIAR -->

<script type="text/javascript">

    function listarIntegrantesGrupo(){

        let tabla_grupo_accion = $('#tabla_grupo_accion').DataTable();
        tabla_grupo_accion.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_grupo_accion = $('#tabla_grupo_accion').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.informe.integrantes') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //NOMBRES Y APELLIDOS
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //RUT
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //TELEFONO
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //CORREO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ROL
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }@if($est_pro_id != config('constantes.plan_estrategico'))
                    ,
                    { //ACCIONES
                        "targets": 5,
                        "className": 'dt-head-center dt-body-left',
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).css("vertical-align", "middle");
                        
                        }
                    }
                @endif
            ],				
            "columns": [
                        { //NOMBRES Y APELLIDOS
                            "data": "int_info_nom",
                            "className": "text-center"
                        },
                        { //RUT
                            "data": "int_info_rut",
                            "className": "text-center"
                        },
                        { //TELEFONO
                            "data": "int_info_tel",
                            "className": "text-center"
                        },
                        { //CORREO
                            "data": "int_info_cor",
                            "className": "text-center"
                        },
                        { //ROL
                            "data": "int_info_rol",
                            "className": "text-center"
                        }@if($est_pro_id != config('constantes.plan_estrategico'))
                            ,
                            { //ACCIONES
                                "data": "int_id",
                                "className": "text-center",
                                "render": function(data, type, row){
                                	//INICIO DC
                                	let html = '';
                                	if('{{ Session::get('perfil') }}' == 2){
                                		html = '<button disabled="disabled" type="button" class="btn btn-warning" onclick="limpiarIntegrantesfrm();editarIntegrante('+data+');"><i class="fas fa-pen"></i> Editar</button>';
                                    	html+= ' <button disabled="disabled" type="button" class="btn btn-danger" onclick="eliminarIntegrantes('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                	}else{
                                		html = '<button type="button" class="btn btn-warning" onclick="limpiarIntegrantesfrm();editarIntegrante('+data+');"><i class="fas fa-pen"></i> Editar</button>';
                                            html+= ' <button type="button" class="btn btn-danger" onclick="eliminarIntegrantes('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                	}
                                	//FIN DC                                	
                                            return html;
                                        }
                            }
                        @endif
                    ]
        });
    }

    function validarIntegrantesfrm(){

        let grupo_nom = $("#grupo_nom").val();
        let grupo_rut = $("#grupo_rut").val();
        let grupo_tele = $("#grupo_tele").val();
        let grupo_cor = $("#grupo_cor").val();
        let grupo_rol = $("#grupo_rol").val();
        let rut_val = $("#hid_rut_val").val();
        let respuesta = true;

        if (grupo_nom == "" || typeof grupo_nom === "undefined"){
            respuesta = false;
            $("#val_grupo_nom").show();
            $("#grupo_nom").addClass("is-invalid");
        }else{
            $("#val_grupo_nom").hide();
            $("#grupo_nom").removeClass("is-invalid");            
        }

        if (grupo_rut == "" || typeof grupo_rut === "undefined"){
            respuesta = false;
            $("#val_grupo_rut").show();
            $("#grupo_rut").addClass("is-invalid");
        }else if(rut_val == 1){
            respuesta = false;
            $("#val_grupo_rut").show();
            $("#grupo_rut").addClass("is-invalid");
        }else{
            $("#val_grupo_rut").hide();
            $("#grupo_rut").removeClass("is-invalid");            
        }

        // INICIO CZ Sprint 55
        // if (grupo_tele == "" || typeof grupo_tele === "undefined"){
        //     respuesta = false;
        //     $("#val_grupo_tele").show();
        //     $("#grupo_tele").addClass("is-invalid");
        // }else{
        //     $("#val_grupo_tele").hide();
        //     $("#grupo_tele").removeClass("is-invalid");            
        // }

        // if (grupo_cor == "" || typeof grupo_cor === "undefined"){
        //     // respuesta = false;
        //     // $("#val_grupo_cor").show();
        //     // $("#grupo_cor").addClass("is-invalid");
        // }else{
        //     let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        //     if(!regex.test(grupo_cor)){
        //         respuesta = false;
        //         $("#val_grupo_cor").show();
        //         $("#grupo_cor").addClass("is-invalid");
        //     }else{
        //         $("#val_grupo_cor").hide();
        //         $("#grupo_cor").removeClass("is-invalid");            
        //     }
        // }
        //FIN CZ Sprint 55

        if(grupo_cor !=""){
            console.log("aqui");
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(grupo_cor)){
                respuesta = false;
                $("#val_grupo_cor").show();
                $("#grupo_cor").addClass("is-invalid");
            }else{
                $("#val_grupo_cor").hide();
                $("#grupo_cor").removeClass("is-invalid");            
            }
        }

        if (grupo_rol == "" || typeof grupo_rol === "undefined"){
            respuesta = false;
            $("#val_grupo_rol").show();
            $("#grupo_rol").addClass("is-invalid");
        }else{
            $("#val_grupo_rol").hide();
            $("#grupo_rol").removeClass("is-invalid");            
        }

        return respuesta;
    }

    function limpiarValIntegrantes(){
        $("#grupo_nom").removeClass('is-invalid');
        $("#grupo_rut").removeClass('is-invalid');
        $("#grupo_tele").removeClass('is-invalid');
        $("#grupo_cor").removeClass('is-invalid');
        $("#grupo_rol").removeClass('is-invalid');

        $("#val_grupo_nom").hide();
        $("#val_grupo_rut").hide();
        $("#val_grupo_tele").hide();
        $("#val_grupo_cor").hide();
        $("#val_grupo_rol").hide();
    }

    function limpiarIntegrantesfrm(){
        limpiarValIntegrantes();

        $("#grupo_nom").val("");
        $("#grupo_rut").val("");
        $("#grupo_tele").val("");
        $("#grupo_cor").val("");
        $("#grupo_rol").val("");
        $("#hid_int_id").val("");

        integrantesRut();        
    }

    function registrarIntegrantes(){
        
        let val = validarIntegrantesfrm();
        if(!val) return false;

        let data = new Object();
        data = recolectarDataIntegrantes();
        data.pro_an_id = {{$pro_an_id}};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('registrar.informe.integrantes')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $('#tabla_grupo_accion').DataTable().ajax.reload();
                $("#frmintegrantesgrupo").modal('hide');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });


    }

    function recolectarDataIntegrantes(){
        
        let data = new Object();
        data.int_id = $("#hid_int_id").val();
        data.grupo_nom = $("#grupo_nom").val();
        data.grupo_rut = $("#grupo_rut").val();
        data.grupo_tele = $("#grupo_tele").val();
        data.grupo_cor = $("#grupo_cor").val();
        data.grupo_rol = $("#grupo_rol").val();

        return data;

    }

    function editarIntegrante(int_id){
        bloquearPantalla();
        let data = new Object()
        data.int_id = int_id;
        
        $.ajax({
            type: "GET",
            url: "{{route('editar.informe.integrantes')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            
            let int = resp.data;
            if(resp.estado == 1){
                $("#hid_int_id").val(int.int_id);
                $("#grupo_nom").val(int.int_info_nom);
                $("#grupo_rut").val(int.int_info_rut);
                $("#grupo_tele").val(int.int_info_tel);
                $("#grupo_cor").val(int.int_info_cor);
                $("#grupo_rol").val(int.int_info_rol);
                $("#frmintegrantesgrupo").modal('show');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    function eliminarIntegrantes(int_id){
        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");		
        if (confirmacion == false) return false;

        bloquearPantalla();
        let data = new Object();
        data.int_id = int_id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.informe.integrantes')}}",
            data: data,
        }).done(function(resp){
            desbloquearPantalla();
            
            let int = resp.data;
            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_grupo_accion').DataTable().ajax.reload();
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    function integrantesRut(){
        $('#grupo_rut').rut({
			fn_error: function(input){
				if (input.val() != ''){
					$('#grupo_rut').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
					$("#val_grupo_rut").show();
                    $("#hid_rut_val").val(1);
				}
			},
			fn_validado: function(input){
				$('#grupo_rut').attr("data-val-run", true);
				$("#val_grupo_rut").hide();
                $("#hid_rut_val").val(0);
			}
		});
    }

    let cont_conf_grup = "";
    function valTextAreaInfo8(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#grupo_conf").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#grupo_conf").val(cont_conf_grup);

       }else{ 
          cont_conf_grup = $("#grupo_conf").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_grupo_conf").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_grupo_conf").css("color", "#000000");

       } 

      
       $("#cant_carac_grupo_conf").text($("#grupo_conf").val().length);
   }

    let cont_plan_frup = "";
    function valTextAreaInfo9(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#grupo_plan").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#grupo_plan").val(cont_plan_frup);

       }else{ 
          cont_plan_frup = $("#grupo_plan").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_grupo_plan").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_grupo_plan").css("color", "#000000");

       } 

       $("#cant_carac_grupo_plan").text($("#grupo_plan").val().length);
   }
</script>