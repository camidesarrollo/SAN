<div class="row text-dark">
	<div class="w-100">
		<div class="datatable_encabezado_lb">1. ¿CUÁL DE LOS SERVICIOS PÚBLICOS CONOCE A NIVEL COMUNAL? </div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_nivel_comunalls">
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
                <input maxlength="100" id="ser_niv_com2" name="ser_niv_com2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_ser_niv_com2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>            
            </div>
        </div> 
    </div>
</div>
<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">2. DE LOS SIGUIENTES PROGRAMAS SOCIALES Y PRESTACIONES ¿CUÁLES CONOCE USTED A NIVEL DE SU COMUNA?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_programa_socialesls">
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
                <input maxlength="100" id="ser_pro_soc2" name="ser_pro_soc2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_ser_pro_soc2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una dirección.</p>            
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">3. ¿CUÁL DE LOS SIGUIENTES SERVICIOS SE ENCUENTRAN EN SU SECTOR?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_serviciosls">
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
                <input maxlength="100" id="ser_ser_sec2" name="ser_ser_sec2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
    

    function listaPreServiciosLs(){

        let tabla_nivel_comunalls = $('#tabla_nivel_comunalls').DataTable();
            tabla_nivel_comunalls.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 1;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_nivel_comunalls = $('#tabla_nivel_comunalls').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.serviciosls') }}",
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
								let html = '<div class="form-check"><input id="preg11_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(1,'+row.lb_pre_id+');"';

									if (row.resp11 == 1){
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
								let html = '<div class="form-check"><input id="preg21_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(1,'+row.lb_pre_id+');"';

									if (row.resp21 == 1){
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

    function listaPreProgramasLs(){
        let tabla_programa_socialesls = $('#tabla_programa_socialesls').DataTable();
        tabla_programa_socialesls.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 2;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_programa_socialesls = $('#tabla_programa_socialesls').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.serviciosls') }}",
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
							"data": "lb_fas_id",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input id="preg11_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(2,'+row.lb_pre_id+');"';
								
									if (row.resp11 == 1){
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
								let html = '<div class="form-check"><input id="preg21_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(2,'+row.lb_pre_id+');"';

									if (row.resp21 == 1){
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

    function listaPreServicios2Ls(){

        let tabla_serviciosls = $('#tabla_serviciosls').DataTable();
            tabla_serviciosls.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 0;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();


        tabla_serviciosls = $('#tabla_serviciosls').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.serviciosls') }}",
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
								let html = '<div class="form-check"><input id="preg11_100'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(0,'+row.lb_pre_id+',100);"';

									if (row.resp11 == 1){
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
								let html = '<div class="form-check"><input id="preg21_100'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(0,'+row.lb_pre_id+',100);"';
                                    
									if (row.resp21 == 1){
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