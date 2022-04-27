<div id="objetivoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="objetivoModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">

				<div class="modal-header">
					<h5 class="modal-title" id="form_familiar_tit"><strong>Modificar Objetivo</strong></h5>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
					</button>
				</div>

				<!-- HIDDEN -->
				<input type="hidden" id="obj_id">
				<input type="hidden" id="tar_id">
				@php $grupoFam = Helper::get_grupoFamiliarGestorCaso($caso_id,$run); @endphp
				<!-- HIDDEN -->

				<div class="modal-body">
					<div class="row mb-3">
						<div class="form-group col-12">
							<label for="obj_nom">Objetivo:</label>
							<input type="text" maxlength="1000" onkeypress='return caracteres_especiales(event)' required  name="obj_nom" id="obj_nom" class="form-control "  placeholder="Nombre del objetivo" onBlur="guardarDescripcionObjetivo();"
							>
							<p id="val_frm_obj_nom" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el nombre del objetivo.</p>
						</div>
					</div>	

					<div class="card pt-3 row mb-3" id="contenedor_tareas_paf">
						<div class="col-12">
							<h5 class="text-center smb-2"><strong>Listado de Tareas</strong></h5>
							@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true) 
							<div class="text-right mb-2">
								<a href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" onclick="agregarTarea();" id="btn_agregar_tarea">+ Crear</a>
							</div>
							@endif
							<div class="table-responsive">	
								<table width="100%" class="table table-bordered table-hover table-striped" id="tabla_tareas">
									<thead>
										<tr>
											<th>Id Tarea</th> 
											<th>Tarea</th> 
											<th>Plazos <br>(Semanas)</th>
											<th>Resultados esperados</th>
											<th>Responsable(s)</th>
											@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true) 
												<th>Acciones</th>
											@endif
										</tr>
									</thead>
								</table>
							</div>	
						</div>
					</div>

					<div class="row card p-3" id="contenedor_formulario_tareas_paf">
						<h5 class="text-center"><strong id="nombre_formulario_tareas"></strong></h5>
						<div class="form-group">
							<label for="tar_descripcion">Tarea:</label>
							<input maxlength="100" onkeypress='return caracteres_especiales(event)' required type="text" name="tar_descripcion" id="tar_descripcion" class="form-control "  placeholder="Tarea">
							<p id="val_frm_tar_descripcion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar la descripción.</p>
						</div>

						<div class="form-group">
							<label for="tar_plazo">Plazo <small class="text-muted"></small>:</label>
							<select class="form-control w-25" id="tar_plazo" name="tar_plazo" placeholder="Plazo">
								@for($i = 1; $i <= 16; $i++)
									<option value="{{$i}}" >Semana {{$i}}</option>
								@endfor
							</select>
							{{-- <input maxlength="2" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required type="text" name="tar_plazo" id="tar_plazo" class="form-control w-25"  placeholder="Plazo"> --}}
							<p id="val_frm_tar_plazo" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el plazo.</p>
						</div>

						<div class="form-group">
							<label>Responsable:</label><br>
								@foreach($grupoFam as $value)
								     <input class="mb-3" type="checkbox" id="responsable[]" name="responsable[]" value="{{$value->gru_fam_id}}-{{$value->perfil}}"> &nbsp;{{$value->gru_fam_nom}} <br/>
								@endforeach
							<p id="val_frm_tar_responsable" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe seleccionar el responsable.</p>
						</div>

						<div class="form-group">
							<label for="tar_observacion">Resultados esperados:</label>
					      	<textarea maxlength="1000" onkeypress='return caracteres_especiales(event)'  onKeyUp="valTextAreaobservacion()" onKeyDown="valTextAreaobservacion()" class="form-control " rows="7" id="tar_observacion"></textarea>
					      	<div class="row">
								<div class="col">
									<h6><small class"form-text text-muted">Mínimo 3 y máximo 1000 caracteres.</small></h6>
								</div>
								<div class="col text-left">
									<h6><small class"form-text text-muted">N° de caracteres: <strong id="cant_carac_tar_observacion" style="color: #000000;">0</strong></small></h6>
								</div>

							</div>

					      	<div class="row">
								<p id="val_frm_tar_observacion" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe escribir la observación.</p>
					      	</div>
					    </div>

						<div class="text-right">
							@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true) 
							<button type="button" id="btn_guardar_tarea" class="btn btn-success btn-sm" onclick="actualizarTarea();">Guardar</button>
							@endif
							<button type="button" class="btn btn-secondary btn-sm" onclick="$('#contenedor_formulario_tareas_paf').hide().fadeOut(1000); $('#contenedor_tareas_paf').show().fadeIn(1000);">Volver</button>
						</div>
					</div>

					<div class="text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="vincularModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="objetivoModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
				<div class="modal-header">
        <h5 class="modal-title">Vincular Alerta al Objetivo </h5>
        <button type="button" class="close btnCerrar" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<div class="form-group col-12">
						<!-- INICIO DC -->
							<h6><b>Vincular Alertas Territoriales (Validadas o Incorporadas) al Objetivo: <span id="nomObjetivo"></span></b></h6>
						<!-- FIN DC -->
							<br>
							<table class="table table-striped table-hover w-100" cellspacing="0" id="tabla_alertas_detectadas2">
                                <thead>
                                    <tr>
                                        <th style="width:15%">Tipo de alerta</th>
                                        <th style="width:45%">Cantidad</th>
                                        <th style="width:15%">Acciones</th>    
                                        <th style="width:45%">Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>                   
						</div>
					</div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCerrar" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">
	function mostrarTareas(obj_id){
		let listarTablaTareas = $('#tabla_tareas').DataTable();
        listarTablaTareas.clear().destroy();

		let data = new Object();
		data.obj_id = obj_id;

		listarTablaTareas = $('#tabla_tareas').DataTable({
			//"fixedHeader": { header:true },
			//"dom": '<lf<t>ip>',
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"colReorder": true,
			//"processing": true,
			"serverSide": false,
			"paging"    : true,
			"ordering"  : false,
			"searching" : false,
			"info"		: true,
			"lengthChange": false,
			"ajax"		: 
				{ 
					"url" :	"{{ route('casos.listarTareas') }}", 
					"type": "GET",  
					"data": data ,
				},
			"columnDefs": [ 
				{
					"targets": 		0,
					"visible": 		false
				},
				{
					"targets": 		1,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		2,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				{
					"targets": 		3,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
						$(td).css("vertical-align", "middle");
				       $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"targets": 		4,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				     
				    }
				},
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)
					{
						"targets": 		5,
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					     
					    }
					}
				@endif
			],
			"columns":[
				{
					"data": 		"tar_id",
					"name": 		"tar_id"
				}, 
				{																		
					"data": 		"tar_descripcion",
					"name": 		"tar_descripcion"
				},  
				{																		
					"data": 		"tar_plazo",
					"name": 		"tar_plazo"
				},  
				{
					"data": 	'tar_observacion',
					"render": function (data, type, row, meta){
						if (data == null) data = '';

						let html = '<div style="height: 160px;overflow: auto;">'+data+'</div>';

						return html;
					}
				},
				{																		
					"data": 		"nombre_responsable",
					"name": 		"nombre_responsable",
					"render": function (data, type, row, meta){

						var cadena = data.replace(/\-/g, "<br>"+"- ");

						let html = "<p>"+cadena+"</p>";
						
						return html;
					}
				},
				@if ($modo_visualizacion == 'edicion' || $habilitar_funcion == true)  
					{
						"data": 		"",
						"render" : function (data, type, row){
							let html = '<button type="button" style="width:100%;" class="btn btn-outline-primary btn-sm" onclick="accionesTarea(1,'+row.tar_id+');">Editar <span class="oi oi-pencil"></span></button>';
							return html;
						}
					}
				@endif
			]
		});
	}
</script>