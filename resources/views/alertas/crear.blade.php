<div class="modal-body" style="overflow-y:auto;">

    @if (isset($dimension->dim_id))
    <form name="dimension_form" id="dimension_form" method="post" action="{{ route('dimension.actualizar') }}">
        @else
        <form name="dimension_form" id="dimension_form" method="post" action="{{ route('dimension.insertar') }}">
            @endif {{ csrf_field() }}

            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        @if (isset($alerta->ale_id))
                        <h4>Modificar Alerta</h4> @else
                        <h4>Nueva Alerta</h4> @endif

                        <div class="row card bg-light p-4">

                            @if (isset($alerta->ale_id))
                            <div class="row">
                                <div class="col form-group">
                                    <label>
                                        <h6>Id</h6></label>
                                    <label class="form-control">{{$alerta->ale_id}}</label>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col form-group">
                                    <label>
                                        <h6>RUN</h6></label>
                                    <input onkeypress='return caracteres_especiales(event)' required type="text" class="form-control" name="ale_run" id="ale_run" placeholder="Run" value="{{@$alerta->ale_run}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col form-group">
                                    <label>
                                        <h6>Nombre</h6></label>
                                    <input onkeypress='return caracteres_especiales(event)' required type="text" class="form-control" name="ale_nom" id="ale_nom" placeholder="Nombre" value="{{@$alerta->ale_nom}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col form-group">
                                    <label>Problem&aacute;tica</label>
                                    <select class="form-control" name="pro_id" id="pro_id">
                                        @foreach ($problematicas as $pi => $pv)
                                        <option value="{{@$pv->pro_id}}" @if ($pv->pro_id == $alerta->pro_id) selected @endif>{{@$pv->pro_nom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6 text-right">
                                    @if (isset($dimension->dim_id))
                                    <button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#dimension_form', '', 'actualizarDimension', '');">
                                        Modificar Dimensi&oacute;n
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-primary btn-lg" id="btnGuardar" onclick="enviaFormSerialize('#dimension_form', '', 'insertarDimension', '');">
                                        Registrar Dimensi&oacute;n
                                    </button>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </form>
</div>