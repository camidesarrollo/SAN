<form class="form-horizontal" id="frmGrabarParametro" role="form" method="post" action="{{asset('/administrador/mantenedores/parametros/grabar/')}}">    
{{ csrf_field() }}
<input type="hidden" value="{{$oParametro->id}}" name="id" id="IDid" />
<input type="hidden" value="{{$oParametro->id_padre}}" name="id_padre" id="IDpadre" />
<div class="panel-body">

    <div class="row">
            <div class="col-sm-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="apat">Nombre: </label>
                <div class="col-lg-4"><input type="text" class="form-control" id="IDnombre" name="nombre" placeholder="Nombre" value="{{@$oParametro->nombre}}" ></div>
                <label class="col-lg-2 control-label" for="amat">Valor: </label>
                <div class="col-lg-4"><input type="text" class="form-control" id="IDvalor" name="valor" placeholder="Valor" value="{{@$oParametro->valor}}" ></div>
            </div>
            </div>
    </div>
    <br>
    <div class="row">
            <div class="col-sm-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="Institucion">Estado: </label>
                <div class="col-lg-4">
                    <select class="form-control" id="IDid_estado" name="id_estado" >
                       <option  value="0" >Seleccione Estado:</option>
                         @foreach($lstEstado as $o)
                                @if(@$oParametro->id_estado==$o->valor)
                                    <option value="{{$o->valor}}" selected="selected" >{{$o->nombre}}</option>
                                @else
                                    <option value="{{$o->valor}}">{{$o->nombre}}</option>
                                @endif
                        @endforeach                        
                    </select>
                </div>

                <label class="col-lg-2 control-label" for="amat">Orden: </label>
                <div class="col-lg-4"><input type="text" class="form-control" id="IDorden" name="orden" placeholder="Orden" value="{{@$oParametro->valor}}" ></div>

            </div>
            </div>
    </div>
</div>
</form>