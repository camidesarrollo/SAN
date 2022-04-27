<div class="row"> 
	<div class="w-100">
		<div class="datatable_encabezado_lb">1. ¿CUÁL DE LOS SIGUIENTES BIENES COMUNITARIOS CONOCES EN TU SECTOR?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_bienes_com_ls">
			<thead>
				<tr>
					<th>Bienes</th>
					<!-- inicio ch -->
                    <th>Marque aquellos que usted conoce en su sector</th>
					<!-- fin ch -->
                    <th>Marque aquellos que utiliza usted o una persona de su familia</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>1.1. Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="bie_com2" name="bie_com2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_bie_com2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar un bien comunitario.</p>            
            </div>
        </div> 
    </div>
</div>
<div class="row">
	<div class="w-100">
		<div class="datatable_encabezado_lb">2. ¿CUÁL DE LAS SIGUIENTES ORGANIZACIONES CONOCE EN SU SECTOR?</div>
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_org_secls">
			<thead>
				<tr>
					<th>Organizaciones</th>
					<!-- inicio ch -->
                    <th>Marque aquellos que usted conoce en su sector</th>
					<!-- fin ch -->
                    <th>Marque aquellos que utiliza usted o una persona de su familia</th>
                    <th>Marque aquellas de las cuales usted conoce a sus dirigentes</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>2.1. Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="bien_org_otr2" name="bien_org_otr2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_bien_org_otr2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una organización.</p>            
            </div>
        </div>
        <div class="form-group row p-4">        
            <div class="col-sm-12">
                <label for="" class=""><b>2.2 SI USTED NO PARTICIPA EN NINGUNA ORGANIZACIÓN, ¿LE GUSTARÍA PARTICIPAR EN ALGUNA ORGANIZACIÓN?:</b></label>              
                <input maxlength="100" id="bien_org_part2" name="bien_org_part2" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                <p id="val_bien_org_part2" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una respuesta.</p>            
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">

    function listaPreBienesLs(){

        let tabla_bienes_com_ls = $('#tabla_bienes_com_ls').DataTable();
        tabla_bienes_com_ls.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 3;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_bienes_com_ls = $('#tabla_bienes_com_ls').DataTable({
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
								let html = '<div class="form-check"><input id="preg11_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(3,'+row.lb_pre_id+');"';

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
								let html = '<div class="form-check"><input id="preg21_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(3,'+row.lb_pre_id+');"';

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

    function listaPreOrganizacionesLs(){
        let tabla_org_secls = $('#tabla_org_secls').DataTable();
        tabla_org_secls.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 4;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();

        tabla_org_secls = $('#tabla_org_secls').DataTable({
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
								let html = '<div class="form-check"><input id="preg11_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(4,'+row.lb_pre_id+');"';

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
								let html = '<div class="form-check"><input id="preg21_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(4,'+row.lb_pre_id+');"';

									if (row.resp21 == 1){
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
								let html = '<div class="form-check"><input id="preg31_'+row.lb_pre_id+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaSalida(4,'+row.lb_pre_id+');"';

									if (row.resp31 == 1){
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