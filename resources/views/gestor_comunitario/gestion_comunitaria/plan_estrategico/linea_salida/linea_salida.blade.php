{{ csrf_field() }}


<div class="form-group">
    <table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_linea_salida">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Linea Salida</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table><br>
    <a class="btn btn-success" href="{{route('reporte.lineabase').'/'.$pro_an_id.'/2'}}"><i class="fa fa-download"></i>Descargar Linea de Salida</a>
</div>
@includeif('gestor_comunitario.gestion_comunitaria.plan_estrategico.linea_salida.modal_linea_salida')
<input id="lin_bas_id" type="hidden" value="">
<input id="lb_fas_id" type="hidden" value="">
<input id="accion" type="hidden" value="0">
<style type="text/css">
	.datatable_encabezado_lb{
		background-color: #e6f3fd;
    	text-align: center;
    	font-weight: 800;
    	text-transform: uppercase;
    	padding: 6px 0;
	}
</style>
<script type="text/javascript">
    
    let respuestaPreguntas2 = new Array();

    function listarPreguntas2(opcion,id=''){

        $("#lin_bas_id").val(id);
        $("#accion").val(opcion);

        respuestaPreguntas2.length = 0;
        $("#identificacion2").collapse('show');
        $("#servicio_prestaciones2").collapse('hide');
        $("#organizacion_comunitaria2").collapse('hide');
        $("#derecho_part_nna2").collapse('hide');
        listaPreServiciosLs();
        listaPreProgramasLs();
        listaPreServicios2Ls();
        listaPreBienesLs();
        listaPreOrganizacionesLs();
        listaPreParticipacionLs();

        $('#linea_rut2').rut({
			fn_error: function(input){
				if (input.val() != ''){
					$('#linea_rut2').attr("data-val-run", false);
                    mensajeTemporalRespuestas(0, "* RUN Inválido.");
					$("#val_linea_rut2").show();
				}
			},
			fn_validado: function(input){
				$('#linea_rut2').attr("data-val-run", true);
				$("#val_linea_rut2").hide();

                autoCompletarNombre();

			}
		});
    }

    function listarLineaSalida(){

        let tabla_linea_salida = $('#tabla_linea_salida').DataTable();

        tabla_linea_salida.clear().destroy();

        let data = new Object();
		data.pro_an_id 	= {{$pro_an_id}};

        tabla_linea_salida = $('#tabla_linea_salida').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.linea.salida') }}",
    			"type": "GET",
				"data": data
  			},
			"columnDefs": [
            	{ //RUT
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //NOMBRES
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //EDAD
					"targets": 2,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //TELEFONO
					"targets": 3,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //CORREO
					"targets": 4,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //LLINEA DE SALIDA inicio ch
					"targets": 5,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},//fin ch
                { //DESCARGAR inicio ch
					"targets": 6,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				}
				}//fin ch
    		],				
			"columns": [
						{ //RUT
							"data": "lin_bas_rut",
							"className": "text-center"
						},
						{ //NOMBRES
							"data": "lin_bas_nom",
							"className": "text-center"
						},
						{ //EDAD
							"data": "lin_bas_eda",
							"className": "text-center"
						},
						{ //TELEFONO
							"data": "lin_bas_tel",
							"className": "text-center"
						},
						{ //CORREO
							"data": "lin_bas_cor",
							"className": "text-center"
						},
						{ //LINEA SALIDA
							"data": "lin_bas_id",
							"className": "text-center",
                            "render": function(data, type, row){
                                    let html ='';
                                    if( row.lb_fas_id == 2){
                                        //html+= ' <button type="button" class="btn btn-danger" onclick="eliminarLineaBase('+data+')"><i class=""></i>  <b>Eliminar</b></button>';
										
                                        html = '<p class="text-success"><b><i class="fas fa-check-circle"></i>Linea Salida</b></p>';
									}else{
										html = '<button type="button" class="btn btn-outline-success" onclick="editarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-plus-circle"></i> <b>Linea Salida</b></button>';
                                    }
                                    return html;
                            }
						},
                        { //Descargar 
							"data": "lin_bas_id",
							"className": "text-center",
                            "render": function(data, type, row){//inicio ch
                                    let html ='';
                                    
                                    if( row.lb_fas_id == 2){
                                        
                                        html = '<button type="button" class="btn btn-primary" onclick="descargarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }else{
                                        html = '<button type="button" class="btn btn-primary disabled" disabled="true" onclick="descargarLineaSalida('+data+');limpiarfrmValidadiones();"><i class="fa fa-download"></i> <b>Descargar</b></button>';
                                    }
										return html;
						    }
						}// FIN CH
					]
		});
    }

    function descargarLineaSalida(id){
        window.open( `/descargarLineaSalida/${id}`, '_blank');
    }


    function agregarRepuestaLineaSalida(tipo, id, opcion = ''){
            
        respuestaPreguntas2[opcion+id]          = Object();
        respuestaPreguntas2[opcion+id].id        = id;
        respuestaPreguntas2[opcion+id].tipo     = tipo;
        if($("#preg11_"+opcion+id).prop('checked')){
            respuestaPreguntas2[opcion+id].resp11  = 1;
        }else{
            respuestaPreguntas2[opcion+id].resp11  = 0;
        }

        if($("#preg21_"+opcion+id).prop('checked')){
            respuestaPreguntas2[opcion+id].resp21  = 1;
        }else{
            respuestaPreguntas2[opcion+id].resp21  = 0;
        }

        if(tipo == 4){
            if($("#preg31_"+id).prop('checked')){
                respuestaPreguntas2[id].resp31  = 1;
            }else{
                respuestaPreguntas2[id].resp31  = 0;
            }
        }else{
            respuestaPreguntas2[opcion+id].resp31  = 0;
        }        


    }

    function recolectarSelLineaSalida(){

        let data = new Object();

        data.preguntas = respuestaPreguntas2;
        data.ser_niv_com2    = $("#ser_niv_com2").val();
        data.ser_pro_soc2    = $("#ser_pro_soc2").val();
        data.ser_ser_sec2    = $("#ser_ser_sec2").val();
        data.bie_com2        = $("#bie_com2").val();
        data.bien_org_otr2   = $("#bien_org_otr2").val();
        data.bien_org_part2  = $("#bien_org_part2").val();
        
        return data;
    }

    function guardarLineaSalida(){

        let respuesta2 = validarfrmIdentificacionLS();
        console.log(respuesta2);
        if(!respuesta2){
            $("#identificacion2").collapse('hide');
            $("#servicio_prestaciones2").collapse('hide');
            $("#organizacion_comunitaria2").collapse('hide');
            $("#derecho_part_nna2").collapse('hide');
            mensaje = "Faltaron Campos Por Responder";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        respuesta2 = verificarfrmDerechoParticipacionLs();
        if(!respuesta2){
            $("#derecho_part_nna2").collapse('show');
            $("#identificacion2").collapse('hide');
            $("#servicio_prestaciones2").collapse('hide');
            $("#organizacion_comunitaria2").collapse('hide');
            mensaje = "Completar Derechos y Participacion NNA";
            mensajeTemporalRespuestas(0, mensaje);
            return false;
        }

        bloquearPantalla();

        let data = new Object();

        data.lin_bas_id = $("#lin_bas_id").val();
        data.iden       = recolectarDataIdentificacionLS();
        data.preg       = recolectarSelLineaSalida();
        data.part       = recolectarfrmDerechoParticipacionLs();
        data.pro_an_id  = {{$pro_an_id}};
        
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: "POST",
            url: "{{route('guardar.linea.salida')}}",
            data: data
        }).done(function(resp){
            
            if(resp.estado == 1){
                mensajeTemporalRespuestas(1, resp.mensaje);
                listarLineaBase(); 
                listarLineaSalida();
                //$('#tabla_linea_base').DataTable().ajax.reload();
            }

            if(resp.estado == 0){
                mensajeTemporalRespuestas(0, resp.mensaje);
            }
            $('#frmlineabase2').modal('hide');
            desbloquearPantalla();

        }).fail(function(objeto, tipoError, errorHttp){
                desbloquearPantalla();

                manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

                return false;
        });

    }

    function eliminarLineaBase(id){

        let confirmacion = confirm("¿Esta seguro que desea eliminar el registro?");
		
		if (confirmacion == false) return false;

        let data = new Object();
        data.id = id;
        bloquearPantalla();
        $.ajax({
            type: "GET",
            url: "{{route('eliminar.linea.base')}}",
            data: data
        }).done(function(resp){

            if(resp.estado == 1){
                mensajeTemporalRespuestas(0, resp.mensaje);
                $('#tabla_linea_salida').DataTable().ajax.reload();
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

    function editarLineaSalida(id){
        $("#btn_lb_guardar").show();
        listarPreguntas2(1,id);
        getDataIdentificacionLs(id);
        $('#frmlineabase2').modal('show');
        //INICIO DC
        if('{{ Session::get('perfil') }}' == 2){
        	$('.btn_lb_guardar').attr('disabled', 'disabled');
        }        
        //FIN DC
    }
    //INICIO DC
    function calculaEdad(fnac){
    	let birth_year = fnac.substr(0,4);
    	let birth_month = fnac.substr(4,2);
    	let birth_day = fnac.substr(6,2);
    	today_date = new Date();
          today_year = today_date.getFullYear();
          today_month = today_date.getMonth();
          today_day = today_date.getDate();
          age = today_year - birth_year;

          if (today_month < (birth_month - 1)) {
            age--;
          }
          if (((birth_month - 1) == today_month) && (today_day < birth_day)) {
            age--;
          }
          return age;
    }
	//FIN DC
    function autoCompletarNombre(){
		let respuesta 	= "";
		let run 		= $("#linea_rut2").val();

        if (rutEsValido(run)){
        	obtenerInformacionRunificador(run).then(function (data){
        		console.log(data);
        		if (data.estado == 1){
        			$("#linea_nom2").val(data.respuesta.Nombres+' '+data.respuesta.ApellidoPaterno+' '+data.respuesta.ApellidoMaterno);
					//INICIO DC
					let edad = calculaEdad(data.respuesta.FechaNacimiento);
					$('#linea_edad2').val(edad);
					//FIN DC
        		}else if (data.estado == 0){
        			console.log(data.mensaje);

        		}
        	}).catch(function (error){
        		console.log(error);
        	});
        }
	}
</script>