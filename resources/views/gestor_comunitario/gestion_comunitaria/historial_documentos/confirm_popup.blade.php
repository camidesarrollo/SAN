<!-- INICIO CZ SPRINT 67 -->
<meta name="_token" content="{{ csrf_token() }}">
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar la eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <div class="modal-body">
                <p>Está a punto de borrar una documento, este procedimiento es irreversible.</p>
                <p>¿Quieres continuar?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar-modal-confirm">Cancel</button>
                <button type="button" class="btn btn-danger" id ="btn-ok" onclick="">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
function eliminarDocumentos(id,tipo,proceso,tipo_gestion){
    bloquearPantalla();
    let data = new Object();
    data.tip_id = tipo;
    data.id = id;
    data.id_pro_an_id = proceso;
    data.tipo_gest = tipo_gestion;
    $.ajaxSetup({
			    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
    $.ajax({
            type:"post",
            url: "{{route('eliminarDocumento')}}",
            data: data
        }).done(function(resp){
            desbloquearPantalla();
            if(resp.estado == 1){
                $('#confirm-delete').modal('hide');
                toastr.success(resp.mensaje);    
                if(tipo == 5){
                    gethistorialData({{ config('constantes.tip_acta_listas_asistencias') }});
                }else if( tipo == 6){
                    gethistorialData({{ config('constantes.tip_materiales') }});
                }else if( tipo == 7){
                    gethistorialData({{ config('constantes.tip_asentamientos_consentimientos') }});
                }        
            }
            
        }).fail(function(objeto, tipoError, errorHttp){            
            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);

            return false;
        });
}
</script>
<!-- FIN CZ SPRINT 67 -->