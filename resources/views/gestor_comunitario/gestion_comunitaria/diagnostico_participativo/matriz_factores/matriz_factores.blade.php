<div class="card colapsable shadow-sm" id="contenedor_matriz_factores">
    <a class="btn text-left p-0 collapsed" id="desplegar_matriz_factores" data-toggle="collapse" data-target="#matriz_factores" aria-expanded="false" aria-controls="matriz_factores">
        <div class="card-header p-3">
            <h5 class="mb-0">
                <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
                &nbsp;&nbsp; MATRIZ DE FACTORES PROTECTORES
            </h5>
        </div>
    </a>


	<!--INICIO DC SPRINT 67-->
    <div class="collapse" id="matriz_factores">
        <div class="card-body">
            <br>
            <div class="form-group">
                <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_matrices_factores">
                    <thead>
                        <tr>
                            <th>Factores protectores</th>
                            <th>A nivel familiar</th>
                            <th>A nivel escolar</th>
                            <th>A nivel comunitario</th>
                            <th>A nivel institucional</th>
                            <th>Otros</th>
                                <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!-- INICIO DC -->
                <button type="button" class="btn btn-outline-success btnAddMatPri" data-toggle="modal" data-target="#frmmatrizfactores" onclick="limpiarfrmMatrizFac()"><i class="fa fa-plus-circle"></i> Agregar Matriz</button>                
                <a href="{{route('reporte.matriz.factores').'/'.$pro_an_id}}"><button type="button" class="btn btn-success matFact"><i class="fa fa-file-excel-o"></i> Descargar Matriz</button></a>
                <!-- FIN DC -->
            </div>                          
        </div>
    </div>
	<!--FIN DC SPRINT 67-->
</div>

<!-- MODAL DE LA MATRIZ DE FACTORES -->
@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.matriz_factores.modal_matriz_factores')

<input id="mat_fac_id" type="hidden" value="">

<script type="text/javascript">
	//INICIO DC SPRINT 67
    function listarMatrizFactores(){

        let tabla_matrices_factores = $('#tabla_matrices_factores').DataTable();
        tabla_matrices_factores.clear().destroy();

        let data = new Object();
        data.pro_an_id 	= {{$pro_an_id}};

        tabla_matrices_factores = $('#tabla_matrices_factores').DataTable({
            "language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            "lengthChange": false,
            "info": 		false,
            "ajax": {
                "url": "{{ route('listar.matriz.factores') }}",
                "type": "GET",
                "data": data
            },
            "columnDefs": [
                { //FACTORES PROTECTORES
                    "targets": 0,
                    "className": 'dt-head-center dt-body-center',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                    }
                },
                { //A NIVEL FAMILIAR
                    "targets": 1,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                    }
                },
                { //A NIVEL ESCOLAR
                    "targets": 2,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                    }
                },
                { //A NIVEL COMUNITARIO
                    "targets": 3,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                    }
                },
                { //A NIVEL INSTITUCIONAL
                    "targets": 4,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                    }
                },
                { //OTROS
                    "targets": 5,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                        $(td).css("word-break", "break-word");
                    
                }
                },
                { //ACCIONES
                    "targets": 6,
                    "className": 'dt-head-center dt-body-left',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css("vertical-align", "middle");
                    
                    }
                }
            ],				
            "columns": [
                        { //FACTORES PROTECTORES
                            "data": "mat_fac_pro",
                            "className": "text-center"
                        },
                        { //A NIVEL FAMILIAR
                            "data": "mat_fac_fam",
                            "className": "text-center"
                        },
                        { //A NIVEL ESCOLAR
                            "data": "mat_fac_esc",
                            "className": "text-center"
                        },
                        { //A NIVEL COMUNITARIO
                            "data": "mat_fac_com",
                            "className": "text-center"
                        },
                        { //A NIVEL INSTITUCIONAL
                            "data": "mat_fac_ins",
                            "className": "text-center"
                        },
                        { //OTROS
                            "data": "mat_fac_otros",
                            "className": "text-center"
                        },
                        { //ACCIONES
                            "data": "mat_fac_id",
                            "className": "text-center",
                            "render": function(data, type, row){
                                        console.log("este es del row");
                                        //INICIO DC SPRINT 67
                                        if(ObjectLength(row) > 0){
                                        let html = '';
                                        if($('#desestimado').val() == 1 || $('#est_pro_id').val() == 3){
                                        html = '<button type="button" class="btn btn-warning" onclick="editarMatrizFactores('+data+');limpiarfrmMatrizFacVal();"><i class="fas fa-pen"></i> Editar</button>';
                                        	html+= ' <button disabled="disabled" type="button" class="btn btn-danger" onclick="eliminarMatrizFactores('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                        }else{
                                        if('{{ Session::get('perfil') }}' == 2){
                                        	html = '<button disabled="disabled" type="button" class="btn btn-warning" onclick="editarMatrizFactores('+data+');limpiarfrmMatrizFacVal();"><i class="fas fa-pen"></i> Editar</button>';
                                        	html+= ' <button disabled="disabled" type="button" class="btn btn-danger" onclick="eliminarMatrizFactores('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                        }else{
                                        	html = '<button type="button" class="btn btn-warning" onclick="editarMatrizFactores('+data+');limpiarfrmMatrizFacVal();"><i class="fas fa-pen"></i> Editar</button>';
                                        html+= ' <button type="button" class="btn btn-danger" onclick="eliminarMatrizFactores('+data+')"><i class="fa fa-remove"></i> Eliminar</button>';
                                        }
                                        //INICIO CZ SPRINT 67 correccion
                                        if($("#est_pro_id").val() == {{ config('constantes.finalizado') }} || $("#est_pro_id").val() == {{ config('constantes.desestimado') }} ){
                                                $('.btn-danger').attr('disabled', 'disabled');
                                        }
                                            //FIN CZ SPRINT 67 correccion                                       
										}											
                                        return html;
                                        }else{
                                            return "";
                                        }
                                    }
                        }
                    ]
            });
    }
    //FIN DC SPRINT 67

    function ObjectLength( object ) {
    var length = 0;
        for( var key in object ) {
            if( object.hasOwnProperty(key) ) {
                ++length;
            }
        }
    return length;
    };

    function validarfrmMatFac(){
        limpiarfrmMatrizFacVal();
        let respuesta = 0;
        
        let mat_fac = $("#mat_fac").val();
        let mat_fam = $("#mat_fam").val();
        let mat_esc = $("#mat_esc").val();
        let mat_com = $("#mat_com").val();
        let mat_ins = $("#mat_ins").val();

        if(mat_fac == '' || typeof mat_fac === 'undefined'){
            $("#val_mat_fac").show();
            $("#mat_fac").addClass('is-invalid');
            respuesta = 1;
        }else if(mat_fac.length < 3){
            $("#val_mat_fac").show();
            $("#mat_fac").addClass('is-invalid');
            respuesta = 2;
        }

        if(mat_fam == '' || typeof mat_fam === 'undefined'){
            $("#val_mat_fam").show();
            $("#mat_fam").addClass('is-invalid');
            respuesta = 1;
        }else if(mat_fam.length < 3){
            $("#val_mat_fam").show();
            $("#mat_fam").addClass('is-invalid');
            respuesta = 2;
        }

        if(mat_esc == '' || typeof mat_esc === 'undefined'){
            $("#val_mat_esc").show();
            $("#mat_esc").addClass('is-invalid');
            respuesta = 1;
        }else if(mat_esc.length < 3){
            $("#val_mat_esc").show();
            $("#mat_esc").addClass('is-invalid');
            respuesta = 2;
        }

        if(mat_com == '' || typeof mat_com === 'undefined'){
            $("#val_mat_com").show();
            $("#mat_com").addClass('is-invalid');
            respuesta = 1;
        }else if(mat_com.length < 3){
            $("#val_mat_com").show();
            $("#mat_com").addClass('is-invalid');
            respuesta = 2;
        }

        if(mat_ins == '' || typeof mat_ins === 'undefined'){
            $("#val_mat_ins").show();
            $("#mat_ins").addClass('is-invalid');
            respuesta = 1;
        }    else if(mat_ins.length < 3){
            $("#val_mat_ins").show();
            $("#mat_ins").addClass('is-invalid');
            respuesta = 2;
        }

        return respuesta;

    }

    function limpiarfrmMatrizFacVal(){

        $("#mat_fac").removeClass("is-invalid");
        $("#mat_fam").removeClass("is-invalid");
        $("#mat_esc").removeClass("is-invalid");
        $("#mat_com").removeClass("is-invalid");
        $("#mat_ins").removeClass("is-invalid");

        $("#val_mat_fac").hide();
        $("#val_mat_fam").hide();
        $("#val_mat_esc").hide();
        $("#val_mat_com").hide();
        $("#val_mat_ins").hide();

    }

	//INICIO DC SPRINT 67
    function limpiarfrmMatrizFac(){
        limpiarfrmMatrizFacVal();
        $("#mat_fac_id").val("");
        $("#mat_fac").val("");
        $("#mat_fam").val("");
        $("#mat_esc").val("");
        $("#mat_com").val("");
        $("#mat_ins").val("");
        $("#mat_otros").val("");
    }
    //FIN DC SPRINT 67

    function guardarMatrizFactores(){
        
        let valid = validarfrmMatFac();
        if(valid == 1){
            mensaje = "Completar los Campos faltantes."
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }else if(valid == 2){
            mensaje = "Contenido Minimo es de 3 caracteres."
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        bloquearPantalla();

        let data = new Object();

        data.pro_an_id = {{$pro_an_id}};
        data.mat_fac_id = $("#mat_fac_id").val();

        data.mat_fac = $("#mat_fac").val();
        data.mat_fam = $("#mat_fam").val();
        data.mat_esc = $("#mat_esc").val();
        data.mat_com = $("#mat_com").val();
        data.mat_ins = $("#mat_ins").val();
        data.mat_otros = $("#mat_otros").val();
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: "POST",
            url: "{{route('guardar.matriz.factores')}}",
            data: data
        }).done(function(resp){
            console.log(resp);
            if(resp.estado == 1){

                desbloquearPantalla();
                $("#frmmatrizfactores").modal('hide');
                listarMatrizFactores();
                $("#btn-mat-fac-pro").attr('disabled',false);
                //$('#tabla_matrices_factores').DataTable().ajax.reload();
                mensajeTemporalRespuestas(1, resp.mensaje);

            }else{

                desbloquearPantalla();
                mensajeTemporalRespuestas(0, resp.mensaje);
            }

        }).fail(function(objeto, tipoError, errorHttp){

                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;

        });
        
    }

    function editarMatrizFactores(id){

        $("#mat_fac_id").val(id);

        let data = new Object();
        data.mat_fac_id = id;

        $.ajax({
            type: "GET",
            url: "{{route('editar.matriz.factores')}}",
            data: data
        }).done(function(resp){

            mat_fac = $.parseJSON(resp.mat_fac);

            $('#mat_fac').val(mat_fac.mat_fac_pro);
            $('#mat_fam').val(mat_fac.mat_fac_fam);
            $('#mat_esc').val(mat_fac.mat_fac_esc);
            $('#mat_com').val(mat_fac.mat_fac_com);
            $('#mat_ins').val(mat_fac.mat_fac_ins);
            $('#mat_otros').val(mat_fac.mat_fac_otros);

            $("#frmmatrizfactores").modal('show');

        }).fail(function(objeto, tipoError, errorHttp){
            
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;

        });

    }

    function eliminarMatrizFactores(id){

        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");		
		if (confirmacion == false) return false;
        bloquearPantalla();

        let data = new Object();
        data.mat_fac_id = id;

        $.ajax({
            type: "GET",
            url: "{{route('eliminar.matriz.factores')}}",
            data: data
        }).done(function(resp){

            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_matrices_factores').DataTable().ajax.reload();
            }

            if(resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            desbloquearPantalla();

        }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();
                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
                return false;
        });

    }
</script>