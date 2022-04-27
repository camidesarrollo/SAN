<!-- //CZ SPRINT 73 -->
<div id="formBitacoraTerapia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formBitacoraTerapia"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <div class="row">
                    <div class="col-11 text-center">
                        <h5 class="modal-title"><b>Bitácora de Estados de Terapia</b></h5>
                    </div>
                    <div class="col-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div><br>
                <div class="row pl-3">
                    <label>RUN NNA:</label>&nbsp
                    <p id="run_nna_bitacora_estado_terapia"></p>
                </div>
                <hr>

                <table class="table table-bordered table-hover table-striped w-100" cellspacing="0"
                    id="tabla_bitacora_terapia">
                    <thead>
                        <tr>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Descripción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <hr>

                <div class="text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    function abrirModalBitacoraTerapia(cas_id, run_con_formato){
			let run = esconderRut(run_con_formato, "{{ config('constantes.ofuscacion_run') }}");

			$("#run_nna_bitacora_estado_terapia").text(run);

			let data_bitacora = $('#tabla_bitacora_terapia').DataTable();

			data_bitacora.clear().destroy(); 

			data_bitacora =	$('#tabla_bitacora_terapia').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"paging"    : false,
				"ordering"  : false,
				"searching" : false,
				"info"		: false,
				"ajax"		: {
		            "url" :	"{{ route('casos.bitacora.terapia') }}"+"/"+cas_id
			    },
			    "columnDefs": [ 
					{
						"targets": 		0,
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					        $(td).css("word-break", "break-word");
					     
					    }
					},
					{
						"targets": 		1,
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					        $(td).css("word-break", "break-word");
					     
					    }
					},
					{
						"targets": 		2,
						"className": 	'dt-head-center dt-body-left',
						"createdCell": function (td, cellData, rowData, row, col) {
					     
					    }
					}
				],
				"columns"	: [
					{
					 "data": 		"est_tera_nom",
					 "name": 		"est_tera_nom",
					 "width": 		"150px"
					},
					{
					 "data": 		"tera_est_tera_fec",
					 "name": 		"tera_est_tera_fec",
					 "width": 		"70px"
					},
					{
						"data": 		"tera_est_tera_des",
					 	"name": 		"tera_est_tera_des",
						"render" : function (data, type, full, meta){
							let descripcion = "";

							if (data != "" && typeof data != "undefined" && data != null){
								descripcion = data;
							
							}

					 		return '<div style="width: 350px;height: 80px;overflow: auto;">'+ descripcion +'</div>';
						}
					}
				],
			});

			$('#tabla_bitacora_terapia').find("thead th").removeClass("sorting_asc");
			
			$('#formBitacoraTerapia').modal('show');
		}
</script>
<!-- //CZ SPRINT 73 -->