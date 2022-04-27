<!-- //CZ SPRINT 74 -->

@if(Session::get('perfil') == config('constantes.perfil_gestor') || Session::get('perfil') == config('constantes.perfil_terapeuta'))
<div class="modal" id="ModalNotificaciones" tabindex="-1" aria-labelledby="ModalNotificacionesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notificaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
				<div class="card colapsable shadow-sm" >
					<a class="btn text-left p-0" id="btn_casos_asignados" data-toggle="collapse" data-target="#casos_asignados" aria-expanded="false" aria-controls="casos_asignados">
						<div class="card-header p-3"> 
						<h5 class="mb-0">
						@if(Session::get('perfil') == config('constantes.perfil_gestor'))

							Casos Asignados 
						@elseif(Session::get('perfil') == config('constantes.perfil_terapeuta'))
							Terapias Asignadas
						@endif
						<span class="badge badge-danger" id="txt_numeroNotiCaso">{{ Session::get('cantidad_asignacion')}}</span></h5>
						</div>
					</a>
					<div class="collapse" id="casos_asignados">
						<div class="card-body">
						<table class="table table-bordered table-hover table-striped w-100" cellspacing="0" id="historial_CasoAsignado">
								<thead>
									<tr>
										<th  class="text-center"></th>
									</tr>
								</thead>
								<tbody></tbody> 
						</table>
						</div>
					</div>
				</div>
            </div>

        </div>
    </div>
</div>
<!-- //CZ SPRINT 74 -->
@endif