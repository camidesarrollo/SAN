<div class="row">

	<div class="w-100">
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_derecho_participacionls">
			<thead>
				<tr>
					<th>Afirmación</th>
                    <th>1. Muy en desacuerdo</th>
                    <th>2. En desacuerdo</th>
                    <th>3. Ni en desacuerdo / ni de acuerdo</th>
                    <th>4. De acuerdo</th>
                    <th>5. Muy de acuerdo</th>
<!-- inicio ch	 --><th>6. No corresponde</th> <!-- fin ch -->
				</tr>
			</thead>
			<tbody></tbody>
        </table>
	</div>
</div>
<script type="text/javascript">

function listaPreParticipacionLs(){
        let tabla_derecho_participacionls = $('#tabla_derecho_participacionls').DataTable();
        tabla_derecho_participacionls.clear().destroy();

        let data = new Object();
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_derecho_participacionls = $('#tabla_derecho_participacionls').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.participacionls') }}",
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
                { //CHECK
					"targets": 5,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{ //CHECK inicio ch
					"targets": 6,
					"className": 'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				}// fin ch
    		],				
			"columns": [
						{ //SERVICIOS
							"data": "lb_par_nom",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="1"';

									if (row.resp == 1){
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
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="2"';

									if (row.resp == 2){
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
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="3"';

									if (row.resp == 3){
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
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="4"';

									if (row.resp == 4){
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
								let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="5"';

									if (row.resp == 5){
									 html += ' checked="true"></div>';

									}else{
									 html += '></div>';

									}

								return html;
							}
							},
							{ //ETAPA ACTUAL inicio ch
								"data": "",
								"className": "text-center",
								"render": function(data, type, row){
									let html = '<div class="form-check"><input class="form-check-input" type="radio" name="lb_par_'+row.lb_par_id+'" value="6"';

										if (row.resp == 6){
										html += ' checked="true"></div>';

										}else{
										html += '></div>';

										}

									return html;
								}
							}//fin ch
					]
		});
    }

    function verificarfrmDerechoParticipacionLs(){

        let respuesta2 = true;

        let lin_bas_res1_1 = $("input:radio[name ='lb_par_1']:checked").val();
        let lin_bas_res2_1 = $("input:radio[name ='lb_par_2']:checked").val(); 
        let lin_bas_res3_1 = $("input:radio[name ='lb_par_3']:checked").val();
        let lin_bas_res4_1 = $("input:radio[name ='lb_par_4']:checked").val();
        let lin_bas_res5_1 = $("input:radio[name ='lb_par_5']:checked").val();
        let lin_bas_res6_1 = $("input:radio[name ='lb_par_6']:checked").val();
        let lin_bas_res7_1 = $("input:radio[name ='lb_par_7']:checked").val();

        if (lin_bas_res1_1 == "" || typeof lin_bas_res1_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res2_1 == "" || typeof lin_bas_res2_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res3_1 == "" || typeof lin_bas_res3_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res4_1 == "" || typeof lin_bas_res4_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res5_1 == "" || typeof lin_bas_res5_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res6_1 == "" || typeof lin_bas_res6_1 === "undefined"){
            respuesta2 = false;
        }

        if (lin_bas_res7_1 == "" || typeof lin_bas_res7_1 === "undefined"){
            respuesta2 = false;
        }
        return respuesta2;
    }

    function recolectarfrmDerechoParticipacionLs(){
        let data = new Object();

        data.lin_bas_res1_1 = $("input:radio[name ='lb_par_1']:checked").val();
        data.lin_bas_res2_1 = $("input:radio[name ='lb_par_2']:checked").val(); 
        data.lin_bas_res3_1 = $("input:radio[name ='lb_par_3']:checked").val();
        data.lin_bas_res4_1 = $("input:radio[name ='lb_par_4']:checked").val();
        data.lin_bas_res5_1 = $("input:radio[name ='lb_par_5']:checked").val();
        data.lin_bas_res6_1 = $("input:radio[name ='lb_par_6']:checked").val();
        data.lin_bas_res7_1 = $("input:radio[name ='lb_par_7']:checked").val();

        return data;
    }
</script>