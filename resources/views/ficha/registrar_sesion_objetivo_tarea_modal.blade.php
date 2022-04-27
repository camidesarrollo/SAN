<div id="objetivoModalRegistrarSesion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="objetivoModalRegistrarSesion" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content p-4">
			<div class="card p-4 shadow-sm">					
				<div class="modal-header">
					<div style="margin: 0 auto;"><h5><b>Registrar Sesión</b></h5></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; margin: 0; top: 5px; right: 33px;">
						<span aria-hidden="true">&times;</span>
					</button>
				</div><br>
				<div class="form-group">
					<input type="hidden" id="tar_id" name="tar_id" value="" >

					<label for="nom_tar_paf">Tarea:</label><br/>
					<label><div id="nom_tar_paf" name="nom_tar_paf">Tarea test 1</div></label>
				</div>
				<div class="form-group">
					<label for="fecha_ses_tar">Fecha:</label>
					<div class="input-group date-pick w-25" id="fecha_ses_tar" data-target-input="nearest">
						<input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fec_ses_tar" class="form-control datetimepicker-input "  data-target="#fecha_ses_tar" id="fec_ses_tar"  value="">
						<div class="input-group-append" data-target="#fecha_ses_tar" data-toggle="datetimepicker">
							<div class="input-group-text"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
					<p id="val_fec_ses_tar" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar una fecha valida.</p>
				</div>
				<div class="form-group">
					<label for="tar_sesion_ejecucion_paf">Comentario:</label>
				   	<textarea  maxlength="2000" onkeypress='return caracteres_especiales(event)' onKeyUp="valTextAreaComSes()" onKeyDown="valTextAreaComSes()" class="form-control " rows="7" id="tar_sesion_ejecucion_paf"></textarea>
				   	<p id="val_ses_tar" style="font-size: 14px; color: #dc3545; margin: 5px 0 0 0; display:none;">* Debe ingresar el minimo de caracteres.</p>
					<div class="row">
						<div class="col">
							<h6><small class="form-text text-muted">Mínimo 3 y máximo 2000 caracteres.</small></h6>
						</div>
						<div class="col text-left">
							<h6><small class="form-text text-muted">N° de caracteres: <strong id="cant_carac_tar_sesion_ejecucion_paf" style="color: #000000;">0</strong></small>
							</h6>
						</div>
					</div>
				</div>

				<div class="form-group text-right">
					<button id="btn_agregar_tarea" onclick="guardarSesionesObjTarPaf();" type="button" class="btn btn-success">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- </div> -->
<!-- </div> -->

<script type="text/javascript">

	$(function() {
		$('.date-pick').datetimepicker({
			maxDate: $.now(),
			minDate: new Date('2019/01/01'),
			format: 'DD/MM/Y'
		});
	});
	
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})

	contenido_textarea_com_ses = "";
  	function valTextAreaComSes(){

  	 	num_caracteres_permitidos = 2000;

	    num_caracteres = $("#tar_sesion_ejecucion_paf").val().length;

	    if (num_caracteres > num_caracteres_permitidos){ 
	    	$("#tar_sesion_ejecucion_paf").val(contenido_textarea_com_ses);
	    }else{ 
	    	contenido_textarea_com_ses = $("#tar_sesion_ejecucion_paf").val(); 
	    }

	    if (num_caracteres >= num_caracteres_permitidos){ 
	    	$("#cant_carac_tar_sesion_ejecucion_paf").css("color", "#ff0000"); 
	    }else{ 
	    	$("#cant_carac_tar_sesion_ejecucion_paf").css("color", "#000000");
	    } 
	      
	    $("#cant_carac_tar_sesion_ejecucion_paf").text($("#tar_sesion_ejecucion_paf").val().length);
   }


</script>