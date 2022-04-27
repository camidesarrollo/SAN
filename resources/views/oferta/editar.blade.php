<div class="border-left-primary">

    <div class="modal-header">
        <h5 class="modal-title" id="advertmodalLabel">
            <i class="fa fa-edit text-primary"></i> Editar Oferta
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="overflow-y:auto;">

        <form name="oferta_form" id="oferta_form" method="post" action="{{ route('ofertas.actualizar') }}">
            {{ csrf_field() }}

            <input type="hidden" id="url_rut" value="{{ route('alertas.rut') }}">

            <input type="hidden" id="ofe_id" name="ofe_id" value="{{$ofertas->ofe_id}}">

            <section class="">
                <div class="container-fluid">
                    

                        <nav>
                            <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Oferta</a>

                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Responsable</a>

                                <a class="nav-item nav-link" id="nav-alert-tab" data-toggle="tab" href="#nav-alert" role="tab" aria-controls="nav-alert" aria-selected="false">Alertas</a>

                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">

                            <!-- TABS OFERTA -->
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <div class="row card bg-light p-4">
                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Programas:</b></label>
                                            <select title="Responsable" class="form-control" id="prog_id" name="prog_id">

                                                <option value="">Seleccione Programa</option>

                                                <optgroup label="Local">
                                                    @foreach($programas as $programa) @if($programa->pro_tip==0)
                                                    <option value="{{ $programa->prog_id }}" <?php if($ofertas->prog_id==$programa->prog_id ){ echo"selected"; } ?>> {{ $programa->pro_nom }}
                                                    </option>
                                                    @endif @endforeach
                                                </optgroup>

                                                <optgroup label="Nacional">
                                                    @foreach($programas as $programa) @if($programa->pro_tip==1)
                                                    <option value="{{ $programa->prog_id }}" <?php if($ofertas->prog_id==$programa->prog_id ){ echo"selected"; } ?> > {{ $programa->pro_nom }}
                                                    </option>
                                                    @endif @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6><b>Nombre de la Prestación o Componente:</b></h6></label>
                                            <input required type="text" class="form-control " name="ofe_nom" id="ofe_nom" placeholder="Nombre" value="{{$ofertas->ofe_nom}}" onkeypress='return caracteres_especiales(event)'>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6><b>Descripci&oacute;n de la Prestación o Componente:</b></h6></label>
                                            <textarea required class="form-control " name="ofe_des" id="ofe_des" onkeypress='return caracteres_especiales(event)' placeholder="Descripción">{{$ofertas->ofe_des}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="col form-group">
                                                <labe>
                                                    <h6><b>Horarios de atenci&oacute;n:</b></h6></labe>
                                                <div class="input-group date" id="time_start" data-target-input="nearest">
                                                    <input type="text" name="hora_ini" class="form-control datetimepicker-input " data-target="#time_start" value="{{@$hora_ini}}" />
                                                    <div class="input-group-append" data-target="#time_start" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#time_start').datetimepicker({
                                                    format: 'LT'
                                                });
                                            });
                                        </script>
                                        <div class="col-md-4">
                                            <div class="col form-group">
                                                </br>
                                                <div class="input-group date" id="time_end" data-target-input="nearest">
                                                    <input type="text" name="hora_fin" class="form-control datetimepicker-input " data-target="#time_end" value="{{@$hora_fin}}" />
                                                    <div class="input-group-append" data-target="#time_end" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#time_end').datetimepicker({
                                                    format: 'LT'
                                                });
                                            });
                                        </script>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6><b>Poblaci&oacute;n objetivo:</b></h6></label>
                                            <textarea required class="form-control " name="ofe_pob_obj" id="ofe_pob_obj" onkeypress='return caracteres_especiales(event)' placeholder="Población objetivo">{{$ofertas->ofe_pob_obj}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Cupos Comunales:</b></label>
                                            <input required type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="number" class="form-control " name="ofe_cup" maxlength="3" id="ofe_cup" min="1" value="{{$ofertas->ofe_cup}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="col form-group">
                                                <labe>
                                                    <h6><b>Fecha Inicio:</b></h6></labe>
                                                <div class="input-group date" id="fecha_ini" data-target-input="nearest">
                                                    <input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_ini" class="form-control datetimepicker-input " data-target="#fecha_ini" value="{{$ofertas->ofe_fec_ini}}" />
                                                    <div class="input-group-append" data-target="#fecha_ini" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#fecha_ini').datetimepicker({
                                                    format: 'DD/MM/Y'
                                                });
                                            });
                                        </script>
                                        <div class="col-md-4">
                                            <div class="col form-group">
                                                <labe>
                                                    <h6><b>Fecha Termino:</b></h6></labe>
                                                <div class="input-group date" id="fecha_ter" data-target-input="nearest">
                                                    <input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="fecha_ter" class="form-control datetimepicker-input " data-target="#fecha_ter" value="{{$ofertas->ofe_fec_ter}}" />
                                                    <div class="input-group-append" data-target="#fecha_ter" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#fecha_ter').datetimepicker({
                                                    format: 'DD/MM/Y'
                                                });
                                            });
                                        </script>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Estado:</b></label>
                                            <select title="Activo" class="form-control" id="ofe_est" name="ofe_est">
                                                <option value="">Selecione Estado</option>
                                                <option value="1" <?php if($ofertas->ofe_est==1){ echo"selected"; } ?>>Activo</option>
                                                <option value="0" <?php if($ofertas->ofe_est==0){ echo"selected"; } ?>>Inactivo</option>
                                                <select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Tiempo de Respuesta:</b></label>
                                            <input required type="number" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control " name="ofe_tie_res" maxlength="4" id="ofe_tie_res" value="{{$ofertas->ofe_tie_res}}">
                                        </div>
                                    </div>

                               

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Establecimiento:</b></label>
                                             <input type="text" id="ofe_estab" name="ofe_estab" class="form-control " value="{{$ofertas->ofe_estab}}" onkeypress='return caracteres_especiales(event)' placeholder="Ingrese Establecimiento" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Dirección:</b></label>
                                             <input type="text" id="ofe_direc" name="ofe_direc" class="form-control " value="{{$ofertas->ofe_direc}}" onkeypress='return caracteres_especiales(event)' placeholder="Ingrese Dirección" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Cantidad de meses ejecución del programa y/o iniciativa:</b></label>
                                             <input type="text" id="ofe_cant_mes" maxlength="2" name="ofe_cant_mes" class="form-control" value="{{$ofertas->ofe_cant_mes}}" placeholder="Ingrese Cantidad de Meses" />
                                             <!-- <input type="text" id="ofe_cant_mes" name="ofe_cant_mes" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="{{$ofertas->ofe_cant_mes}}" placeholder="Ingrese Cantidad de Meses" /> -->
                                        </div>
                                    </div>

                             
                                   <!--  <div class="col-md-6">  -->   
                                        <div class="row">
                                            <div class="col form-group">
                                                <labe>
                                                    <h6><b>Fecha próximo proceso de postulación:</b></h6></labe>
                                                <div class="input-group date" id="ofe_fec_prox_pos" data-target-input="nearest">
                                                    <input onkeypress='return caracteres_especiales_fecha(event)' type="text" name="ofe_fec_prox_pos" class="col-md-4 form-control datetimepicker-input "  data-target="#ofe_fec_prox_pos" value="{{$ofertas->ofe_fec_prox_pos}}" />
                                                    <div class="input-group-append" data-target="#ofe_fec_prox_pos" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#ofe_fec_prox_pos').datetimepicker({
                                                    format: 'DD/MM/Y'
                                                });
                                            });
                                        </script>
         

                                     <div class="row">
                                        <div class="col form-group">
                                            <b><label>Tipo de Beneficio:</label></b></label>

                                            <select  class="form-control" id="id_tip_ben" name="id_tip_ben">
                                                <option value="">Seleccione Tipo de Beneficio</option>
                                                    @foreach($tip_benf as $value) 
                                                    <option value="{{ $value->id_tip_ben }}"
                                                    <?php if($value->id_tip_ben==$ofertas->id_tip_ben ){ echo"selected"; } ?>>
                                                    {{ $value->nombre }}
                                                    </option>
                                                    @endforeach
                                             </select>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col form-group">
                                            <b><label>Fuente Financiamiento</label></b></label>

                                            <select  class="form-control" id="id_fuen_de_financ" name="id_fuen_de_financ">
                                                <option value="">Seleccione Fuente Financiamiento</option>
                                                    @foreach($fuent_finz as $value) 
                                                    <option value="{{ $value->id_fuen_de_financ }}" <?php if($value->id_fuen_de_financ==$ofertas->id_fuen_de_financ ){ echo"selected"; } ?>>
                                                    {{ $value->nombre }}
                                                    </option>
                                                    @endforeach
                                             </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row align-items-center">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-success btnNext" onclick="$('#nav-contact-tab').trigger('click')">
                                                Siguiente <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- FIN TABS OFERTA -->

                            <!-- TABS RESPONSABLE -->

                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                                <div class="row card bg-light p-4">

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6><b>Nombre:</b></h6></label>
                                            <input type="hidden" id="buscarres" nombre="buscarres" value="{{ route('buscar.responsable') }}">
                                            <select title="Responsable" class="form-control" id="responsable" name="responsable" onchange="selecionarRes();">
                                                <option value="0">Seleccione Responsable</option>
                                                @foreach($responsables as $responsable)
                                                <option <?php if($responsable->id==$ofertas->usu_resp) { echo"selected"; } ?> value="{{ $responsable->id }}"> {{ $responsable->nombres }} {{ $responsable->apellido_paterno }} {{ $responsable->apellido_materno }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6>Telefono:</h6></label>
                                            <input required readonly type="text" class="form-control" name="res_tel" id="res_tel" placeholder="Telefono" value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col form-group">
                                            <label>
                                                <h6>Correo:</h6></label>
                                            <input required readonly type="text" class="form-control" name="res_cor" id="res_cor" placeholder="Correo" value="">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row align-items-center">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-secondary btnNext" onclick="$('#nav-home-tab').trigger('click')">
                                                <i class="fa fa-chevron-left"></i> Atrás
                                            </button>
                                            <button type="button" class="btn btn-success btnNext" onclick="$('#nav-alert-tab').trigger('click')">
                                                Siguiente <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- FIN TABS RESPONSABLE -->

                            <!-- TABS ALERTAS -->

                            <div class="tab-pane fade" id="nav-alert" role="tabpanel" aria-labelledby="nav-alert-tab">

                                <div class="row card bg-light p-4">

                                    <div class="row">
                                        <div class="col form-group">
                                            <label><b>Comuna:<b></label>
    												<select class="form-control comuna" id="id_comuna" name="id_comuna">
    												@foreach($comunas as $ci => $cv)
    												<div class="form-check">
    												<option class="form-check-input" type="checkbox" value="{{$cv->com_id}}" id="com_{{$ci}}" name="pro_com[]" {{$cv->checked}} > {{$cv->com_nom}} 
    												</option>
    												</div>
    												@endforeach	
    												</select>
    										 </div>
    									</div>

    									<div class="row">
    											<div class="col form-group">
    												<label><b>Alertas Territoriales:</b></label>
                                            @foreach($alerta_tipo as $ai => $av)
                                            <p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{$av->ale_tip_id}}" id="ale_{{$ai}}" name="tip_ale[]" {{$av->checked}}>
                                                        <label class="form-check-label" for="ale_{{$ai}}">{{$av->ale_tip_nom}}</label>
                                                    </div>
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row align-items-center">
                                        <div class="col-md-12 text-center">

                                            <button type="button" class="btn btn-secondary btnNext" onclick="$('#nav-contact-tab').trigger('click')">
                                                <i class="fa fa-chevron-left"></i> Atrás
                                            </button>

                                            <button type="button" class="btn btn-success btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#oferta_form', '', 'actualizarOferta', '');">
                                                Modificar Programa <i class="fa fa-check-circle"></i>
                                            </button>

                                        </div>
                                    </div>

                                </div>

                                <!-- FIN TABS ALERTAS -->

                            </div>

                        

                    </div>
                </div>
            </section>

        </form>

    </div>

</div>

<script>
    $(document).ready(function() {

        selecionarRes();

    });

    function selecionarRes() {

        if ($('#responsable').val() == 0) {
            $('#res_tel').val("");
            $('#res_cor').val("");
            $('#res_ins').val("");
            $('#res_run').val("");
            return false;
        }

        let url = $('#buscarres').val();

        let id = $('#responsable').val();

        // Convertir a objeto
        var data = {};
        data.id = id;

        $.ajax({
            type: "GET",
            url: url + '/' + id,
            //data: JSON.stringify(sesion),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success: function(obj) {
                console.log(obj[0].run);
                if (obj) {

                    $('#res_tel').val(obj[0].telefono);
                    $('#res_cor').val(obj[0].email);
                    $('#res_ins').val(obj[0].id_institucion);
                    $('#res_run').val(obj[0].res_run);

                } else {
                    alert('El Usuario No se Encuentra Registrado');
                }
            }
        });

    }

    function cargaComuna() {

        // $('select option').remove();
        $('#id_comuna').empty();
        // alert($("input[name=prog]:checked").data('id'));
        var off_com_user = $("input[name=prog]:checked").val();

        $.ajax({
                url: "{{route('ofertas.listar')}}/" + off_com_user, //ruta donde tengas la funcion listar areas
                type: 'get',
                dataType: 'json'
            })
            .done(function(respuesta) {
                var response = respuesta;
                for (let i = response.length - 1; i >= 0; i--) {
                    $('#id_comuna').append('<option value="' + response[i].com_id + '">' + response[i].com_nom + '</option>');
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
</script>