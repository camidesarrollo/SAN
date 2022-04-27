<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">1. ¿CUÁL DE LOS SERVICIOS PÚBLICOS CONOCE A NIVEL COMUNAL? </div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_nivel_comunal">
			<thead>
				<tr>
					<th>Servicios</th>
                    <th>Marque aquellos que usted conoce a nivel Comunal</th>
                    <th>Marque aquellos que utiliza usted o una persona de su familia</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>1.1. Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="ser_niv_com" name="ser_niv_com" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_ser_niv_com" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>            
            </div>
        </div> 
    </div>
</div>
<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">2. DE LOS SIGUIENTES PROGRAMAS SOCIALES Y PRESTACIONES ¿CUÁLES CONOCE USTED A NIVEL DE SU COMUNA?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_programa_sociales">
			<thead>
				<tr>
					<th>Programas sociales y prestaciones</th>
                    <th>Marque aquellos que usted conoce a nivel Comunal</th>
                    <th>Marque aquellos que utiliza usted o una persona de su familia</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>2.1. Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="ser_pro_soc" name="ser_pro_soc" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_ser_pro_soc" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>            
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">3. ¿CUÁL DE LOS SIGUIENTES SERVICIOS SE ENCUENTRAN EN SU SECTOR?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_servicios">
			<thead>
				<tr>
					<th>Servicios</th>
                    <th>Marque aquellos que usted conoce a nivel Comunal</th>
                    <th>Marque aquellos que utiliza usted o una persona de su familia</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>3.1. Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="ser_ser_sec" name="ser_ser_sec" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
    

    function listaPreServicios(){

        let tabla_nivel_comunal = $('#tabla_nivel_comunal').DataTable();
            tabla_nivel_comunal.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 1;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_nivel_comunal = $('#tabla_nivel_comunal').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.servicios') }}",
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
					"className": 'dt-head-center dt-body-left'
				},
                { //CHECK
					"targets": 2,
					"className": 'dt-head-center dt-body-left'
				}
    		],				
			"columns": [
						{ //SERVICIOS
							"data": "lb_pre_nom",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input id="preg1_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(1,'+row.lb_pre_id+');"';

									if (row.resp1 == 1){
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
								let html = '<div class="form-check"><input id="preg2_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(1,'+row.lb_pre_id+');"';

									if (row.resp2 == 1){
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

    function listaPreProgramas(){
        let tabla_programa_sociales = $('#tabla_programa_sociales').DataTable();
        tabla_programa_sociales.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 2;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_programa_sociales = $('#tabla_programa_sociales').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.servicios') }}",
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
					"className": 'dt-head-center dt-body-left'
				},
                { //CHECK
					"targets": 2,
					"className": 'dt-head-center dt-body-left'
				}
    		],				
			"columns": [
						{ //SERVICIOS
							"data": "lb_pre_nom",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input id="preg1_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(2,'+row.lb_pre_id+');"';

									if (row.resp1 == 1){
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
								let html = '<div class="form-check"><input id="preg2_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(2,'+row.lb_pre_id+');"';

									if (row.resp2 == 1){
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

    function listaPreServicios2(){

        let tabla_servicios = $('#tabla_servicios').DataTable();
            tabla_servicios.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 0;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();


        tabla_servicios = $('#tabla_servicios').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.servicios') }}",
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
					"className": 'dt-head-center dt-body-left'
				},
                { //CHECK
					"targets": 2,
					"className": 'dt-head-center dt-body-left'
				}
    		],				
			"columns": [
						{ //SERVICIOS
							"data": "lb_pre_nom",
							"className": "text-center"
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input id="preg1_100'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(0,'+row.lb_pre_id+',100);"';

									if (row.resp1 == 1){
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
								let html = '<div class="form-check"><input id="preg2_100'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase(0,'+row.lb_pre_id+',100);"';
                                    
									if (row.resp2 == 1){
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
       

</script>