<div id="verPafModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarTerapeutaModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="card p-4 shadow-sm">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3><span class="oi oi-briefcase"></span> Resumen PAF</h3>

				<!--<p>RUT: { { number_format($caso->run,0,",",".")."-".($caso->dig)  }}</p>-->

				<hr>

				<!--@ php $cont=0;-->

               <!-- if (isset($caso->cas_id) && $caso->cas_id != ""){
					$alertas = Helper::get_alertas($caso->cas_id);

					$ofertas = Helper::get_ofertas($alertas);

					@ endphp-->
					<!--@ foreach ($alertas as $ale_tip)

							@ php $ cont++; @ endphp

							<table class="table table-bordered table-hover dataTable no-footer">
							<thead>
								<tr role="row">
									<th aria-controls="tabla_alertas" colspan="2"><h4><b>Alerta Territorial { {$cont}} </b></h4></th>
									</tr>
									 </thead>
										<tbody>
										<td class=" text-left" colspan="2"> - { {$ale_tip->ale_tip_nom}}</td>
										</tr>
										<tr role="row">
									<th aria-controls="tabla_alertas" colspan="2">Ofertas Asociadas:</th>
									</tr>

							@ if(in_array($ale_tip->ale_tip_id, $tip_array))

									@ foreach ($alertaManualTipOfe as $ofe)

												@ if(($ofe->ale_tip_id)==($ale_tip->ale_tip_id))
													<tr role="row" class="odd">
														<td class=" text-left">{ {$ofe->ofe_nom}}</td>
													</tr>
												@ endif
									@ endforeach

							@ else

								<tr role="row" class="odd">
									<td class=" text-left" >
										<span style="color:red">No existen ofertas para esta alerta.</span>
									</td>
								</tr>

							@ endif

									</thead>
								</tr>
							</tbody>
							</table>

							<hr>
					@ endforeach
                @ php } @ endphp-->


	       	    <div class="modal-body">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label><b>Terapeuta Asignado: Sin Terapeuta.</b></label>
							<br />
						</div>
					</div>

				</div>

				<hr>

				<div class="modal-footer" style="background:#cde9ef;">
				<button type="button" class="btn btn-primary float-right" data-dismiss="modal" aria-label="Close">
					Cerrar
				</button>
				</div>
			</form>
		</div>
	</div>
</div>
