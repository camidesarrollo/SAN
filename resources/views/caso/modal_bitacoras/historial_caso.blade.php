<!-- //CZ SPRINT 73 -->
<div id="formBitacoraCaso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formBitacoraCaso"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="card p-4 shadow-sm">
                <div class="row">
                    <div class="col-11 text-center">
                        <h5 class="modal-title" id="titulo_modal_bitacora_estados"><b>Bitácora de Estados del Caso</b>
                        </h5>
                    </div>
                    <div class="col-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div><br>
                <div class="row pl-3">
                    <label>RUN NNA:</label>&nbsp
                    <p id="run_nna_bitacora_estado"></p>
                </div>
                <hr>

                <table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="tabla_bitacora">
                    <thead>
                        <tr>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Fecha</th>
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
        function abrirModalBitacora(cas_id,run_con_formato){
			let run = esconderRut(run_con_formato, "{{ config('constantes.ofuscacion_run') }}");

			$("#run_nna_bitacora_estado").text(run);

			let data_bitacora = $('#tabla_bitacora').DataTable();

			data_bitacora.clear().destroy(); 

			data_bitacora =	$('#tabla_bitacora').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"paging"    : false,
				"ordering"  : false,
				"searching" : false,
				"info"		: false,
				"ajax"		: {
		            "url" :	"{{ route('casos.bitacoraCaso') }}"+"/"+cas_id
			    },
				"columns"	: [
					{
					 "data": 		"estado_caso",
					 "name": 		"estado_caso",
					 "width": 		"150px"
					},
					{
						"render" : function (data, type, full, meta){

							let descripcion = full.descripcion_bitacora;

							if (descripcion==null){
								descripcion='';
							}

					 		return '<div style="width: 350px;height: 80px;overflow: auto;">'+ descripcion +'</div>';
						}
					},
					{
					 "data": 		"fecha_bitacora",
					 "name": 		"fecha_bitacora",
					 "width": 		"70px"
					}
				],
			});

			$('#tabla_bitacora').find("thead th").removeClass("sorting_asc");
			
			$('#formBitacoraCaso').modal('show');
		}

</script>
<!-- //CZ SPRINT 73 -->