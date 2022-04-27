<form class="form-horizontal" id="frmGrabarMantenedor" role="form" method="post" action="{{asset('/administrador/mantenedores/mantenedor/grabar/')}}">    
{{ csrf_field() }}
<div class="panel-body">

    <div class="row">
            <div class="col-sm-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="apat">Nombre Mantenedor: </label>
                <div class="col-lg-4"><input type="text" class="form-control" value="" id="IDnombreM" name="nombre" placeholder="Nombre del Mantenedor"></div>
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
            </div>
            </div>
    </div>
</div>
</form>