
<!-- PRESENTACION DE INFORME -->
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
            <h5 class="mb-0 p-2">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;Presentación del informe
            </h5>
		</div>
	</div>
	<div class="card-body">
        @if($est_pro_id != config('constantes.plan_estrategico'))
        <!-- INICIO CZ -->
		<textarea name="info_intro" id="info_intro" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo1()" onKeyDown="valTextAreaInfo1()" class="form-control presentacion_informe" cols="30" rows="5" style="resize: none"  onblur="registrarInforme()" placeholder="Realizar presentación del informe, contexto, objetivos, fuentes de información utilizadas, incluyendo Línea de Base"></textarea>
            <div class="row">
                <div class="col">
                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                </div>
                <div class="col text-left">
                    <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_info_intro" class="cant_carac_presentacion_informe" style="color: #000000;">0</strong></small></h6>
                </div>        
            </div>
            <p id="val_info_intro" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una introducción.</p>
        <!-- FIN CZ -->
        @else
            <label id="info_intro" for=""></label>
        @endif
    </div>
</div>
<!-- PRESENTACION DE INFORME -->

<!--  VINCULACION DE LA OLN A LA COMUNIDAD -->
<div class="card shadow-sm">
	<div class="card-header p-3">
		<div class="row">
            <h5 class="mb-0 p-2">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp;Vinculación de la OLN a la Comunidad
            </h5>
		</div>
	</div>
	<div class="card-body">
        @if($est_pro_id != config('constantes.plan_estrategico'))
            <textarea name="intro_vinculacion" id="intro_vinculacion" maxlength="3000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaInfo2()" onKeyDown="valTextAreaInfo2()" class="form-control" cols="30" rows="5" style="resize: none"  onblur="registrarInforme()" placeholder="Breve descripción del proceso de inserción del Gestor/a Comunitario/a a la comunidad, identificando estrategias, hitos, facilitadores y obstaculizadores"></textarea>
            <div class="row">
                <div class="col">
                    <h6><small class="form-text text-muted">Mínimo 3 y máximo 3000 caracteres.</small></h6>
                </div>
                <div class="col text-left">
                    <h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_intro_vinculacion" style="color: #000000;">0</strong></small></h6>
                </div>        
            </div>
            <p id="val_intro_vinculacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar Vinculación de la OLN a la Comunidad.</p>
        @else
            <label id="intro_vinculacion" for=""></label>
        @endif
    </div>
</div>
<!--  VINCULACION DE LA OLN A LA COMUNIDAD -->

<!-- CARACTERISTICAS GENERALES -->
<div class="card colapsable shadow-sm" id="contenedor_intro_caracteristicas">
    <a class="btn text-left p-0 collapsed" id="desplegar_intro_caracteristicas" data-toggle="collapse" data-target="#intro_caracteristicas" aria-expanded="false" aria-controls="intro_caracteristicas" onclick="if($(this).attr('aria-expanded') == 'false') listarInformeCaractGenerales();">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp; Características Generales
            </h5>
        </div>
    </a>

    <div class="collapse" id="intro_caracteristicas">
        <div class="card-body">
            <br>
            <div class="form-group">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_intro_caracteristicas">
                    <thead>
                        <tr>
                            <th>Actores clave presentes en la comunidad:</th>
                            <th>Organizaciones funcionales (formales y no formales) presentes en la comunidad</th>
                            <th>Instituciones, ONG y programas presentes en la comunidad</th>
                            <th>Participación de los NNA en la comunidad</th>
                            <th>Bienes comunes presentes en la comunidad</th>
                            @if($est_pro_id != config('constantes.plan_estrategico'))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                {{-- <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#frmCaracteristicaGeneral" onclick="limpiarFrmCaractGenerales();"><i class="fa fa-plus-circle"></i> Agregar Característica</button>                                 --}}
            </div>                     
        </div>
    </div>
</div>
<!-- CARACTERISTICAS GENERALES -->

<!-- HIDDEN -->
<input type="hidden" name="hid_car_gen_id" id="hid_car_gen_id" value="">
<!-- HIDDEN -->

<!-- MODAL DE INTEGRANTES GRUPO FAMILIAR -->
@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.informe_dpc.modal_caracteristicas')
<!-- MODAL DE INTEGRANTES GRUPO FAMILIAR -->

<script type="text/javascript"> 

    function listarInformeCaractGenerales(){
        let tabla_intro_caracteristicas = $('#tabla_intro_caracteristicas').DataTable();
        tabla_intro_caracteristicas.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_intro_caracteristicas = $('#tabla_intro_caracteristicas').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.informe.caracteristicas') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //ACTORES CLAVE
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //ORGANIZACIONES FUNCIONALES
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //INSTITUCIONES, ONG, PROGRAMAS
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //PARTICIPACION NNA
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                },
                { //BIENES COMUNES
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
                        { //ACTORES CLAVE
                            "data": "iden_nom_rep",
                            "className": "text-center"
                        },
                        { //ORGANIZACIONES FUNCIONALES
                            "data": "organizacion",
                            "className": "text-center"
                        },
                        { //INSTITUCIONES, ONG, PROGRAMAS
                            "data": "instituciones",
                            "className": "text-center"
                        },
                        { //PARTICIPACION NNA
                            "data": "iden_num_nna",
                            "className": "text-center"
                        },
                        { //BIENES COMUNES
                            "data": "bienes",
                            "className": "text-center"
                        }@if($est_pro_id != config('constantes.plan_estrategico'))
                            ,
                            { //ACCIONES
                                "data": "",
                                "className": "text-center",
                                "visible"	: 	false,
                                "render": function(data, type, row){
                                    console.log(row);
                                            let html = '<button type="button" class="btn btn-warning" onclick="limpiarFrmCaractGenerales();editarCaractGenerales();"><i class="fas fa-pen"></i> Editar</button>';
                                            html+= ' <button type="button" class="btn btn-danger" onclick="eliminarCaractGenerales()"><i class="fa fa-remove"></i> Eliminar</button>';
                                            return html;
                                        }
                            }
                        @endif
                    ]
        });
    }

    function limpiarFrmCaractGenerales(){

        $("#intro_caract_actores").val("");
        $("#intro_caract_organizaciones").val("");
        $("#intro_caract_instituciones").val("");
        $("#intro_caract_participacion").val("");
        $("#into_caract_bienes").val("");
        $("#hid_car_gen_id").val("");
        limpiarValidacionCaracteristicas();
    }

    function limpiarValidacionCaracteristicas(){
        $("#val_intro_caract_actores").hide();
        $("#intro_caract_actores").removeClass("is-invalid");  

        $("#val_intro_caract_organizaciones").hide();
        $("#intro_caract_organizaciones").removeClass("is-invalid");  

        $("#val_intro_caract_instituciones").hide();
        $("#intro_caract_instituciones").removeClass("is-invalid");  

        $("#val_intro_caract_participacion").hide();
        $("#intro_caract_participacion").removeClass("is-invalid");  

        $("#val_into_caract_bienes").hide();
        $("#into_caract_bienes").removeClass("is-invalid");            
    }

    function validaInformeCaractGenerales(){

        let intro_caract_actores = $("#intro_caract_actores").val();
        let intro_caract_organizaciones = $("#intro_caract_organizaciones").val();
        let intro_caract_instituciones = $("#intro_caract_instituciones").val();
        let intro_caract_participacion = $("#intro_caract_participacion").val();
        let into_caract_bienes = $("#into_caract_bienes").val();
        let respuesta = true;

        if (intro_caract_actores == "" || typeof intro_caract_actores === "undefined"){
            respuesta = false;
            $("#val_intro_caract_actores").show();
            $("#intro_caract_actores").addClass("is-invalid");
        }else{
            $("#val_intro_caract_actores").hide();
            $("#intro_caract_actores").removeClass("is-invalid");            
        }

        if (intro_caract_organizaciones == "" || typeof intro_caract_organizaciones === "undefined"){
            respuesta = false;
            $("#val_intro_caract_organizaciones").show();
            $("#intro_caract_organizaciones").addClass("is-invalid");
        }else{
            $("#val_intro_caract_organizaciones").hide();
            $("#intro_caract_organizaciones").removeClass("is-invalid");            
        }

        if (intro_caract_instituciones == "" || typeof intro_caract_instituciones === "undefined"){
            respuesta = false;
            $("#val_intro_caract_instituciones").show();
            $("#intro_caract_instituciones").addClass("is-invalid");
        }else{
            $("#val_intro_caract_instituciones").hide();
            $("#intro_caract_instituciones").removeClass("is-invalid");            
        }

        if (intro_caract_participacion == "" || typeof intro_caract_participacion === "undefined"){
            respuesta = false;
            $("#val_intro_caract_participacion").show();
            $("#intro_caract_participacion").addClass("is-invalid");
        }else{
            $("#val_intro_caract_participacion").hide();
            $("#intro_caract_participacion").removeClass("is-invalid");            
        }
        

        if (into_caract_bienes == "" || typeof into_caract_bienes === "undefined"){
            respuesta = false;
            $("#val_into_caract_bienes").show();
            $("#into_caract_bienes").addClass("is-invalid");
        }else{
            $("#val_into_caract_bienes").hide();
            $("#into_caract_bienes").removeClass("is-invalid");            
        }

        return respuesta;
    }

    function registrarInformeCaractGenerales(){
        let resp = validaInformeCaractGenerales();
        if(!resp) return false;

        let data = new Object();
        data.car_id = $("#hid_car_gen_id").val();
        data.actores = $("#intro_caract_actores").val();
        data.organizaciones = $("#intro_caract_organizaciones").val();
        data.instituciones = $("#intro_caract_instituciones").val();
        data.participacion = $("#intro_caract_participacion").val();
        data.bienes = $("#into_caract_bienes").val();
        data.pro_an_id = {{ $pro_an_id }};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('registrar.informe.caracteristicas')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();

            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                $('#tabla_intro_caracteristicas').DataTable().ajax.reload();
                $("#frmCaracteristicaGeneral").modal('hide');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
    }

    function editarCaractGenerales(car_gen_id){
        bloquearPantalla();
        let data = new Object()
        data.car_gen_id = car_gen_id;
        
        $.ajax({
            type: "GET",
            url: "{{route('editar.informe.caracteristicas')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            
            let int = resp.data;
            if(resp.estado == 1){
                $("#hid_car_gen_id").val(int.car_gen_id);
                $("#intro_caract_actores").val(int.car_gen_act);
                $("#intro_caract_organizaciones").val(int.car_gen_org);
                $("#intro_caract_instituciones").val(int.car_gen_int);
                $("#intro_caract_participacion").val(int.car_gen_par);
                $("#into_caract_bienes").val(int.car_gen_bie);
                $("#frmCaracteristicaGeneral").modal('show');
            
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);

            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    function eliminarCaractGenerales(car_gen_id){
        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");		
        if (confirmacion == false) return false;

        bloquearPantalla();
        let data = new Object();
        data.car_gen_id = car_gen_id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('eliminar.informe.caracteristicas')}}",
            data: data,
        }).done(function(resp){
            desbloquearPantalla();
            
            let int = resp.data;
            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_intro_caracteristicas').DataTable().ajax.reload();
            }else if (resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();

            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });

    }

    let cont_intro = "";
    // INICIO CZ
    function valTextAreaInfo1(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $(".presentacion_informe").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $(".presentacion_informe").val(cont_intro);

       }else{ 
          cont_intro = $(".presentacion_informe").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $(".cant_carac_presentacion_informe").css("color", "#ff0000"); 

       }else{ 
          $(".cant_carac_presentacion_informe").css("color", "#000000");

       } 

      
       $(".cant_carac_presentacion_informe").text($(".presentacion_informe").val().length);
   }
//    FIN CZ

    let cont_vinc = "";
    function valTextAreaInfo2(){
      num_caracteres_permitidos   = 3000;

      num_caracteres = $("#intro_vinculacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#intro_vinculacion").val(cont_vinc);

       }else{ 
          cont_vinc = $("#intro_vinculacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_intro_vinculacion").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_intro_vinculacion").css("color", "#000000");

       } 

      
       $("#cant_carac_intro_vinculacion").text($("#intro_vinculacion").val().length);
   }

    let cont_act = "";
    function valTextAreaInfo3(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#intro_caract_actores").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#intro_caract_actores").val(cont_act);

       }else{ 
          cont_act = $("#intro_caract_actores").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_intro_caract_actores").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_intro_caract_actores").css("color", "#000000");

       } 

      
       $("#cant_carac_intro_caract_actores").text($("#intro_caract_actores").val().length);
   }
    
    let cont_org_car = "";
    function valTextAreaInfo4(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#intro_caract_organizaciones").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#intro_caract_organizaciones").val(cont_org_car);

       }else{ 
          cont_org_car = $("#intro_caract_organizaciones").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_intro_caract_organizaciones").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_intro_caract_organizaciones").css("color", "#000000");

       } 

      
       $("#cant_carac_intro_caract_organizaciones").text($("#intro_caract_organizaciones").val().length);
    }

    let cont_int_car = "";
    function valTextAreaInfo5(){
      num_caracteres_permitidos   = 2000;
    
      num_caracteres = $("#intro_caract_instituciones").val().length;
        
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#intro_caract_instituciones").val(cont_int_car);

       }else{ 
          cont_int_car = $("#intro_caract_instituciones").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_intro_caract_instituciones").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_intro_caract_instituciones").css("color", "#000000");

       } 

      
       $("#cant_carac_intro_caract_instituciones").text($("#intro_caract_instituciones").val().length);
   }

   let cont_part_car = "";
    function valTextAreaInfo6(){
      num_caracteres_permitidos   = 2000;

      num_caracteres = $("#intro_caract_participacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#intro_caract_participacion").val(cont_part_car);

       }else{ 
          cont_part_car = $("#intro_caract_participacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_intro_caract_participacion").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_intro_caract_participacion").css("color", "#000000");

       } 

      
       $("#cant_carac_intro_caract_participacion").text($("#intro_caract_participacion").val().length);
    }

    let cont_bienes_car = "";
    function valTextAreaInfo7(){
      num_caracteres_permitidos   = 2000;
    
      num_caracteres = $("#into_caract_bienes").val().length;
        
       if (num_caracteres > num_caracteres_permitidos){ 
            $("#into_caract_bienes").val(cont_bienes_car);

       }else{ 
          cont_bienes_car = $("#into_caract_bienes").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_into_caract_bienes").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_into_caract_bienes").css("color", "#000000");

       } 

      
       $("#cant_carac_into_caract_bienes").text($("#into_caract_bienes").val().length);
   }
</script>