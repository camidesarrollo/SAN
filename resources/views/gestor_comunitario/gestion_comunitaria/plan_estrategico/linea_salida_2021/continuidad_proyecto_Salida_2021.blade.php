<!-- INICIO CZ SPRINT 70 -->
<div class="row">

	<div class="w-100">
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_continuidad_proyectos_2021">
			<thead>
				<tr>
					<th>Marca con X su respuesta, identificando su nivel de acuerdo con las siguientes afirmaciones:</th>
                    <th>Muy en desacuerdo</th>
                    <th>En desacuerdo</th>
                    <th>De acuerdo</th>
                    <th>Muy de acuerdo</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
	</div>
</div>
<script type="text/javascript">

function listaPreParticipacion_Salida_2021(){
        let tabla_derecho_participacion = $('#tabla_continuidad_proyectos_2021').DataTable();
        tabla_derecho_participacion.clear().destroy();

        let data = new Object();
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();
		data.pro_an_id 	= {{$pro_an_id}};
		data.tipo_linea = 2;
        tabla_derecho_participacion = $('#tabla_continuidad_proyectos_2021').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.continuidad_proyecto_2021') }}",
    			"type": "GET",
                "data": data
  			},
			"columnDefs": [
            	{ //SERVICIOS
					"targets": 0,
					"className": 'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //CHECK
					"targets": 1,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //CHECK
					"targets": 2,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //CHECK
					"targets": 3,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
                { //CHECK
					"targets": 4,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
    		],				
			"columns": [
						{ //SERVICIOS
							"data": "lb_cont_nom",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_cont_linea_salida_'+row.lb_cont_id+'" value="1"';
								if(row.resp == 1){
									html += ' checked="true"></div>';
								}else{
									html += '></div>';
								}
								return html;
							}
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_cont_linea_salida_'+row.lb_cont_id+'" value="2"';
								if(row.resp == 2){
									html += ' checked="true"></div>';
								}else{
									html += '></div>';
								}
								return html;
							}
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_cont_linea_salida_'+row.lb_cont_id+'" value="3"';
								if(row.resp == 3){
									html += ' checked="true"></div>';
								}else{
									html += '></div>';
								}
								return html;
							}
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_cont_linea_salida_'+row.lb_cont_id+'" value="4"';
								if(row.resp == 4){
									html += ' checked="true"></div>';
								}else{
									html += '></div>';
								}
								return html;
							}
						}
            ]
		});
    }

    function verificarfrmContinuidadProyecto_linea_salida(){

        let respuesta = true;

        let lb_cont_res1 = $("input:radio[name ='lb_cont_linea_salida_1']:checked").val();
        let lb_cont_res2 = $("input:radio[name ='lb_cont_linea_salida_2']:checked").val(); 
        let lb_cont_res3 = $("input:radio[name ='lb_cont_linea_salida_3']:checked").val();
        let lb_cont_res4 = $("input:radio[name ='lb_cont_linea_salida_4']:checked").val();
        let lb_cont_res5 = $("input:radio[name ='lb_cont_linea_salida_5']:checked").val();
        let lb_cont_res6 = $("input:radio[name ='lb_cont_linea_salida_6']:checked").val();
        let lb_cont_res7 = $("input:radio[name ='lb_cont_linea_salida_7']:checked").val();

        if (lb_cont_res1 == "" || typeof lb_cont_res1 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res2 == "" || typeof lb_cont_res2 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res3 == "" || typeof lb_cont_res3 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res4 == "" || typeof lb_cont_res4 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res5 == "" || typeof lb_cont_res5 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res6 == "" || typeof lb_cont_res6 === "undefined"){
            respuesta = false;
        }

        if (lb_cont_res7 == "" || typeof lb_cont_res7 === "undefined"){
            respuesta = false;
        }
        return respuesta;
    }

    function recolectarfrmContinuidadProyecto_linea_salida(){
        let data = new Object();

        data.lb_cont_res1 = $("input:radio[name ='lb_cont_linea_salida_1']:checked").val();
        data.lb_cont_res2 = $("input:radio[name ='lb_cont_linea_salida_2']:checked").val(); 
        data.lb_cont_res3 = $("input:radio[name ='lb_cont_linea_salida_3']:checked").val();
        data.lb_cont_res4 = $("input:radio[name ='lb_cont_linea_salida_4']:checked").val();
        data.lb_cont_res5 = $("input:radio[name ='lb_cont_linea_salida_5']:checked").val();
        data.lb_cont_res6 = $("input:radio[name ='lb_cont_linea_salida_6']:checked").val();
        data.lb_cont_res7 = $("input:radio[name ='lb_cont_linea_salida_7']:checked").val();
		console.log(data);
        return data;
    }
</script>
<!-- FIN CZ SPRINT 70 -->