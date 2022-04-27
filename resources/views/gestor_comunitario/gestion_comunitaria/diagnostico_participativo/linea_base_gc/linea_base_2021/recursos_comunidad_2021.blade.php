<!-- INICIO CZ SPRINT 70 -->
<div class="row">
	<div class="w-100">
		<!-- <div class="datatable_encabezado_lb">3.1 Respecto a Bienes Comunitarios</div>-->
		<div class="datatable_encabezado_lb">En caso de ser afirmativa la respuesta marca el checkbox.</div> 
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_bienes_comunitarios_2021_linea_base">
			<thead>
				<tr>
					<th>3.1. Respecto a Bienes Comunitarios de acceso gratuito</th>
                    <th>¿Es importante que exista en la comunidad?<br><br>Indicar SI o NO</th>
                    <th>¿Conoces en tu sector?<br><br>Indicar SI o NO</th>
					<th>¿Está cercano a tu vivienda? (a menos de 15 min. caminando)<br><br>Indicar SI o NO</th>
					<th>¿Alguien de tu hogar o tú lo han utilizado?<br><br>Indicar SI o NO</th>
					<th>¿Cuándo fue la última vez? (presencial o virtual)<br><br>Indicar mes y año Si no recuerda (NR)</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>3.1.6 Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="ser_ser_sec_linea_base" name="ser_ser_sec_linea_base" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="">
                
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="w-100">
		<!-- <div class="datatable_encabezado_lb">3.2 Respecto a Organizaciones Comunitarias</div>-->
		<div class="datatable_encabezado_lb">En caso de ser afirmativa la respuesta marca el checkbox.</div> 
		<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_org_sec_2021_linea_base">
			<thead>
				<tr>
					<th>3.2 Respecto a Organizaciones Comunitarias <br><br>Indicar SI o NO</th>
                    <th>¿Es importante su presencia en la comunidad? <br><br>Indicar SI o NO</th>
                    <th>¿Conoces en la comuna? <br><br>Indicar SI o NO</th>
                    <th>¿Participas o has participado en ella? <br><br>Indicar SI o NO</th>
                    <th>¿Cuándo fue la última vez que participaste? (presencial o virtual) <br><br>Indicar mes y año Si no recuerda (NR)</th>
                    <th>¿La organización funciona cerca de tu vivienda? (a menos de 15 min. caminando) <br><br>Indicar SI o NO</th>
                    <th>¿Conoces a alguno(a) de sus dirigentes? <br><br>Indicar SI o NO</th>
				</tr>
			</thead>
			<tbody></tbody>
        </table>
        <div class="form-group row p-4">        
            <div class="col-sm-6">
                <label for="" class=""><b>3.1.11 Otro ¿Cual?:</b></label>              
                <input maxlength="100" id="bien_org_otr_linea_base" name="bien_org_otr_linea_base" onkeypress="return caracteres_especiales(event)" type="input" class="form-control" onblur="()">
                <p id="val_bien_org_otr_linea_base" style="display:none;font-size: 14px; color: rgb(220, 53, 69); margin: 5px 0px 0px;">* Debe Ingresar una organización.</p>            
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">

    function listaPreBienesComunitarios_2021(){
        let tabla_servicios = $('#tabla_bienes_comunitarios_2021_linea_base').DataTable();
        tabla_servicios.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 0;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();
		data.pro_an_id 	= {{$pro_an_id}};
		data.tipo_linea = 1;

        tabla_servicios = $('#tabla_bienes_comunitarios_2021_linea_base').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.servicios_2021') }}",
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
								let html = '<div class="form-check"><input id="org_'+row.lb_pre_id+'_'+1+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(1,'+row.lb_pre_id+',null,3);"';

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
								let html = '<div class="form-check"><input id="org_'+row.lb_pre_id+'_'+2+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(2,'+row.lb_pre_id+',null,3);"';
                                    
									if (row.resp2 == 1){
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
								let html = '<div class="form-check"><input id="org_'+row.lb_pre_id+'_'+3+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,3);"';
                                    
									if (row.resp3 == 1){
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
								let html = '<div class="form-check"><input id="org_'+row.lb_pre_id+'_'+5+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(5,'+row.lb_pre_id+',null,3);"';
                                    
									if (row.resp4 == 1){
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
								$(function(){	
									//Date expire input
									$(".expire").keypress(function(event){
									if(event.charCode >= 48 && event.charCode <= 57){
									if($(this).val().length === 1){
										$(this).val($(this).val() + event.key + " / ");
									}else if($(this).val().length === 0){
										if(event.key == 1 || event.key == 0){
										month = event.key;
										return event.charCode;
										}else{
										$(this).val(0 + event.key + " / ");
										}
									}else if($(this).val().length > 2 && $(this).val().length < 9){
										var mes = $(this).val().split("/");
										var numeromes = parseInt(mes[0]);
										if(numeromes >12){
											$(this).val("12 / ");
										}else{
											return event.charCode;
										}
									}
									}
									return false;
								}).keyup(function(event){
									$(".date_value").html($(this).val());
									if(event.keyCode == 8 && $(".expire").val().length == 4){
									$(this).val(month);
									}
									
									if($(this).val().length === 0){
									$(".date_value").text("MM / YYYY");
									}
								}).keydown(function(){
									$(".date_value").html($(this).val());
								}).focus(function(){
									$(".date_value").css("color", "white");
								});
								});

								let html = "";
								// CZ SPRINT 76
								if(row.sp_mesyear == "N/R"){
									html += '<div class="form-check form-check-inline"><input class="form-control expire" style="margin-right: 10px;" value="" id="expire_'+row.lb_pre_id+'_'+3+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeyup="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeydown="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);"/>';		
									html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_3" value="N/R" onclick="agregarRepuestaLineaBase_2021(4,${row.lb_pre_id},'check',3)"><label class="form-check-label">N/R</label></div>`;					
								}else if(row.sp_mesyear == null){
									html = '<div class="form-check form-check-inline"><input style="margin-right: 10px;" class="form-control expire" value="" id="expire_'+row.lb_pre_id+'_'+3+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeyup="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeydown="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);"/>';									
									html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_3" value="N/R" onclick="agregarRepuestaLineaBase_2021(4,${row.lb_pre_id},'check',3)"><label class="form-check-label">N/R</label></div>`;						

								}else{
									html += '<div class="form-check form-check-inline"><input style="margin-right: 10px;" class="form-control expire" value="'+row.sp_mesyear+'" id="expire_'+row.lb_pre_id+'_'+3+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeyup="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);" onkeydown="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,3);"/>';		
									html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_3" value="N/R" onclick="agregarRepuestaLineaBase_2021(4,${row.lb_pre_id},'check',3)" checked><label class="form-check-label">N/R</label></div>`;						

									// CZ SPRINT 76
								}
								return html;
							}
						}
						
					]
		});
    }
    function listaPreOrganizaciones_2021(){
        let tabla_org_sec = $('#tabla_org_sec_2021_linea_base').DataTable();
        tabla_org_sec.clear().destroy();

        let data = new Object();
		data.pre_tip 	= 4;
        data.lin_bas_id = $("#lin_bas_id").val();
        data.accion = $("#accion").val();
		data.pro_an_id 	= {{$pro_an_id}};
		data.tipo_linea = 1;
        tabla_org_sec = $('#tabla_org_sec_2021_linea_base').DataTable({
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"ordering": 	false,
			"lengthChange": false,
			"info": 		false,
			"searching": 	false,
			"paging":   	false,
			"ajax": {
    			"url": "{{ route('listar.preguntas.servicios_2021') }}",
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
								let html = '<div class="form-check"><input id="org_org_'+row.lb_pre_id+'_'+1+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(1,'+row.lb_pre_id+',null,4);"';

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
								let html = '<div class="form-check"><input id="org_org_'+row.lb_pre_id+'_'+2+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(2,'+row.lb_pre_id+',null,4);"';

									if (row.resp2 == 1){
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
								let html = '<div class="form-check"><input id="org_org_'+row.lb_pre_id+'_'+3+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);"';

									if (row.resp3 == 1){
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
								$(function(){	
									//Date expire input
									$(".expire").keypress(function(event){
									if(event.charCode >= 48 && event.charCode <= 57){
									if($(this).val().length === 1){
										$(this).val($(this).val() + event.key + " / ");
									}else if($(this).val().length === 0){
										if(event.key == 1 || event.key == 0){
										month = event.key;
										return event.charCode;
										}else{
										$(this).val(0 + event.key + " / ");
										}
									}else if($(this).val().length > 2 && $(this).val().length < 9){
										var mes = $(this).val().split("/");
										var numeromes = parseInt(mes[0]);
										if(numeromes >12){
											$(this).val("12 / ");
										}else{
											return event.charCode;
										}
									}
									}
									return false;
								}).keyup(function(event){
									$(".date_value").html($(this).val());
									if(event.keyCode == 8 && $(".expire").val().length == 4){
									$(this).val(month);
									}
									
									if($(this).val().length === 0){
									$(".date_value").text("MM / YYYY");
									}
								}).keydown(function(){
									$(".date_value").html($(this).val());
								}).focus(function(){
									$(".date_value").css("color", "white");
								});
								});
								let html = "";
								// CZ SPRINT 76
									if(row.org_mesyear == "N/R"){
										html = '<div class="form-check form-check-inline"><input class="form-control expire" style="margin-right: 10px; width: 100px;"  value="" id="expire_'+row.lb_pre_id+'_'+4+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeyup="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeydown="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);"/>';				
										html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_4"  value="N/R" onclick="agregarRepuestaLineaBase_2021(3,${row.lb_pre_id},'check',4);" checked><label class="form-check-label">N/R</label></div>`;										
									}else if(row.org_mesyear == null){
										html = '<div class="form-check form-check-inline"><input class="form-control expire" style="margin-right: 10px;width: 100px;"  value="" id="expire_'+row.lb_pre_id+'_'+4+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeyup="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeydown="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);"/>';	
										html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_4" value="N/R" onclick="agregarRepuestaLineaBase_2021(3,${row.lb_pre_id},'check',4)"><label class="form-check-label">N/R</label></div>`;																		
								}else{
										html = '<div class="form-check form-check-inline"><input class="form-control expire" style="margin-right: 10px; width: 100px;"  value="'+row.org_mesyear+'" id="expire_'+row.lb_pre_id+'_'+4+'" type="text" placeholder="MM / YYYY" onkeypress="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeyup="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);" onkeydown="agregarRepuestaLineaBase_2021(3,'+row.lb_pre_id+',null,4);"/>';				
										html += `<input class="form-check-input" type="checkbox" id="no_recuerda_${row.lb_pre_id}_4" value="N/R" onclick="agregarRepuestaLineaBase_2021(3,${row.lb_pre_id},'check',4)"><label class="form-check-label">N/R</label></div>`;										
								}
									// CZ SPRINT 76
								return html;
							}
						},
						{ //ETAPA ACTUAL
							"data": "",
							"className": "text-center",
							"render": function(data, type, row){
								let html = '<div class="form-check"><input id="org_org_'+row.lb_pre_id+'_'+4+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(4,'+row.lb_pre_id+',null,4);"';

									if (row.resp4 == 1){
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
								let html = '<div class="form-check"><input id="org_org_'+row.lb_pre_id+'_'+5+'" class="form-check-input" type="checkbox" onclick="agregarRepuestaLineaBase_2021(5,'+row.lb_pre_id+',null,4);"';

									if (row.resp5 == 1){
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
<!-- FIN CZ SPRINT 70 -->