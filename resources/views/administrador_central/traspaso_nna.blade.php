<!-- INICIO CZ SPRINT 66 -->

@extends('layouts.main')
<style>
.main-wrapper {
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-flex-wrap: nowrap;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-align-content: stretch;
    -ms-flex-line-pack: stretch;
    align-content: stretch;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.item {
    -webkit-order: 0;
    -ms-flex-order: 0;
    order: 0;
    -webkit-flex: 0 1 auto;
    -ms-flex: 0 1 auto;
    flex: 0 1 auto;
    -webkit-align-self: center;
    -ms-flex-item-align: center;
    align-self: center;
}

.multiple-select-value {
    display: block;
    margin-bottom: 20px;
    text-align: center;
    min-height: 30px;

}

.wrapper {
    width: 200px;
    margin: 0 auto;
    overflow: hidden;

}

.select-wrapper {
    border: 1px solid #2196F3;
    border-radius: 10px;
    overflow: hidden;
}

.multiple-select {
    display: block;
    margin: -1px 0;
    overflow: hidden;
    border: none;
    font-family: 'Roboto', sans-serif;
    font-size: 1em;

    option {
        display: block;
        padding: 10px 25px;

        &:checked,
        &:hover {
            background-color: #2196F3;
            color: #fff;
        }

    }


}

select.form-control[size],
select.form-control[multiple] {
    height: 300px !important;
}

.box {
    display: flex;
    justify-content: space-between;
}
</style>
@section('contenido')
<meta name="_token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-12 pt-2">
            <h5><i class="{{$icono}}" style="margin-right: 10px;"></i>Traspaso NNA</h5>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div id="tabs" class="card p-4 shadow-sm w-100">
            <div id="tabs-1">
                <br>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Elije la(s) comuna(s)</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select id="chkcomuna" name="chkcomuna" class="form-control" style="color: #858796;">
                         <!-- CZ SPRINT 76  -->
                        @php $getComunas = Helper::getComunas(); @endphp	  
                        @foreach($getComunas AS $c1 => $v1)
                         <!-- CZ SPRINT 76  -->
                            <option value="{{$v1->com_cod}}" @if(Session::get('perfil') !=7 &&
                                Session::get('com_id')==$v1->com_id)
                                {{ "selected" }}
                                @endif
                                >{{$v1->com_nom}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Elije</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select id="perfil" name="perfil" class="form-control" style="color: #858796;">
                            @foreach($perfil AS $c1 => $v1)
                            <option value="{{$v1->id}}">{{$v1->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-success" onclick="filtrar()">Filtrar</button>
                    <button type="submit" class="btn btn-primary" onclick=" limpiarInputBusqueda();">Limpiar</button>
                </div>
            </div>
            <div id="tabs-1" class="tabla" style="display:none">
                <div class="main-wrapper">
                    <div class="item">
                        <div class="multiple-select-value"></div>
                        <div class="wrapper">
                            <div>
                                <div class="box">
                                    <div><label>Origen</label></div>
                                    <div><button type="button" class="btn btn-info" title="Origen"><span
                                                class="fa fa-info-circl"></button></div>
                                </div>
                                <div style="text-align: end !important;">
                                
                                    <select class="form-control" id="tipo_1">

                                    </select>
                                </div>
                                <br>
                                <div class="select-wrapper">
                                <input type="text" placeholder="Buscador.." id="myInput" onkeyup="filterFunction(1)" class="form-control">
                                    <select multiple class="form-control" id="dato_tipo_1">
                                    </select>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <button type="button" class="btn btn-success" title="Todos los NNA traspasar a destino"
                                    onclick="todosDestino()"><span class="fa fa-plus"></button>
                                    <br>
                                <button type="button" class="btn btn-success" title="Traspasar NNA a destino"
                                    onclick="traspasoNNA()"><span class="fa fa-share"></button>
                                    <br>
                                <button type="button" class="btn btn-danger" title="Todos los NNA traspasar a origen"
                                    onclick="todosOrigen()"><span class="fa fa-minus"></button>
                                    <br>
                                <button type="button" class="btn btn-danger" title="Devolver NNA origen"
                                    onclick="devolverNNA()"><span class="fa fa-reply"></button>
                                    <br>
                            </div>
                            <div>
                                <div class="box">
                                    <div><label>Destino</label></div>
                                    <div><button type="button" class="btn btn-info" title="Destino"><span
                                                class="fa fa-info-circl"></button></div>
                                </div>
                                <div style="text-align: end !important;">
                                    <select class="form-control" id=tipo_2>

                                    </select>

                                </div>
                                <br>
                                <div class="select-wrapper">
                                    <input type="text" placeholder="Buscador.." id="myInput2" onkeyup="filterFunction(2)" class="form-control">
                                    <select multiple class="form-control" id="tabla2">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row tabla" style="display:none">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-success" id="btn-confirm">Confirmar Traspaso</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">¿Esta seguro que desea traspasar los NNA?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<div class="alert" role="alert" id="result"></div>
@endsection
@section('script')
<script>
$(".multiple-select").mousedown(function(e) {

    var self = e.target;
    $(self).prop("selected", $(self).prop('selected') ? false : true).toggleClass("selected");
    return false;

});

$(".multiple-select-button").click(function(e) {

    var selectValue = $(".multiple-select").val();

    if (selectValue !== null) {
        selectValue = $.map(selectValue, function(val, i) {
            return val = " " + val;
        });

        $(".multiple-select-value").html("Selected values is: " + selectValue);
    } else {
        $(".multiple-select-value").html("Make your choice please!");
    }

})

function filtrar() {
    limpiarFormulario();
    bloquearPantalla();

    $(".tabla").css('display', 'none');
    let data = new Object();
    data.com_cod = $('select[name=chkcomuna] option').filter(':selected').val();
    data.id_perfil = $('select[name=perfil] option').filter(':selected').val();

    $.ajax({
        type: "GET",
        url: "{{route('obtenerUsuario')}}",
        data: data
    }).done(function(resp) {
        if(resp.estado == 1){
            var html = '<option value ="">Seleccione '+$('select[name=perfil] option').filter(':selected').text()+'</option>';
            for (var i = 0; i < resp.data.length; i++) {
                html += '<option value = "' + resp.data[i].id + '">' + resp.data[i].nombres + ' ' + resp.data[i]
                    .apellido_paterno + ' ' + resp.data[i].apellido_materno + '</option>';
            }
            $("#tipo_1").html(html);
            $("#tipo_2").html(html);
            $(".tabla").css('display', 'block');
        }else{

        }
        desbloquearPantalla();
    }).fail(function(objeto, tipoError, errorHttp) {

        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });

}

$('#tipo_1').on('change', function() {
    bloquearPantalla();

    $("#tipo_2 option").prop("disabled", false);

    $('#tipo_2 option[value=' + this.value + ']').attr("disabled", true);
    
    let data = new Object();
    data.id_perfil = $('select[name=perfil] option').filter(':selected').val();
    data.usuario_id = this.value;
    data.comuna =   $('#chkcomuna').val();
    $.ajax({
        type: "GET",
        url: "{{route('listarCaso')}}",
        data: data
    }).done(function(resp) {
        console.log()
        if(resp.estado == 1){
            var html = '';
            for (var i = 0; i < resp.data.length; i++) {
                var id = resp.data[i].cas_id + '-' + resp.data[i].nna_nombre_completo;
                html += '<option value = "' + id + '">' + resp.data[i].cas_id + '-' + resp.data[i]
                    .nna_nombre_completo + '</option>';
            }
            $("#dato_tipo_1").html('');
            $("#dato_tipo_1").html(html);
        }
        desbloquearPantalla();
    }).fail(function(objeto, tipoError, errorHttp) {

        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });

})

function traspasoNNA() {
    var selectValue = $("#dato_tipo_1").val();
    var text = $("#dato_tipo_1 option:selected").text();

    if (selectValue !== null) {
        var html = $("#tabla2").html();
        for (var i = 0; i < selectValue.length; i++) {
            $("#dato_tipo_1 option[value='" + selectValue[i] + "']").each(function() {

                $(this).remove();
            });
            html += '<option value = "' + selectValue[i] + '">' + selectValue[i] + '</option>';
        }
        $("#tabla2").html(html)
    } else {
        $(".multiple-select-value").html("Make your choice please!");
    }
}

function devolverNNA() {
    var selectValue = $("#tabla2").val();
    var text = $("#tabla2 option:selected").text();

    if (selectValue !== null) {
        var html = $("#dato_tipo_1").html();
        for (var i = 0; i < selectValue.length; i++) {
            $("#tabla2 option[value='" + selectValue[i] + "']").each(function() {

                $(this).remove();
            });
            html += '<option value = "' + selectValue[i] + '">' + selectValue[i] + '</option>';
        }
        $("#dato_tipo_1").html(html)
    } else {
        $(".multiple-select-value").html("Make your choice please!");
    }
}

function todosOrigen() {
    var selectValue = '';
    div = document.getElementById("tabla2");
    a = div.getElementsByTagName("option");
    for (i = 0; i < a.length; i++) {
        if(a[i].style.display != 'none'){
            selectValue += a[i].outerHTML;
           
        }
    }
    var datos = $("#dato_tipo_1").html(); 
    datos = datos + selectValue;
    $("#dato_tipo_1").html(datos); 

    selcet1 = document.getElementById("tabla2");
    option1 = selcet1.getElementsByTagName("option");
    select2 = document.getElementById("dato_tipo_1"); 
    option2 = select2.getElementsByTagName("option");
    for (i = 0; i < option1.length; i++) {
        for (j = 0; j < option2.length; j++) {
            if(option1[i].innerText == option2[j].innerText){
                $("#tabla2 option[value='"+option1[i].innerText+"']").remove();
            }
        }
    }
}

function todosDestino() {
    var selectValue = '';
    div = document.getElementById("dato_tipo_1");
    a = div.getElementsByTagName("option");
    for (i = 0; i < a.length; i++) {
        if(a[i].style.display != 'none'){
            selectValue += a[i].outerHTML;
           
        }
    }
    var datos = $("#tabla2").html();
    datos = datos + selectValue;
    $("#tabla2").html(datos);

    selcet1 = document.getElementById("dato_tipo_1");
    option1 = selcet1.getElementsByTagName("option");
    select2 = document.getElementById("tabla2");
    option2 = select2.getElementsByTagName("option");
    for (i = 0; i < option1.length; i++) {
        for (j = 0; j < option2.length; j++) {
            if(option1[i].innerText == option2[j].innerText){
                $("#dato_tipo_1 option[value='"+option1[i].innerText+"']").remove();
            }
        }
    }

    
}

function confirmarTraspaso(){
        bloquearPantalla();
        let data = new Object();
        let casos = []
        var elements = document.getElementById("tabla2").options;

        for (var i = 0; i < elements.length; i++) {
            elements[i].selected = true;
        }
        data.casosSplit = $("#tabla2").val();

        for (var i = 0; i < data.casosSplit.length; i++) {
            var split = data.casosSplit[i].split("-");
            console.log(split[0]);
            casos.push(split[0]);
        }

        data.casos = casos;
        data.usu_id = $("#tipo_2").val();
        data.nombre_usuario = $("#tipo_2 option:selected").text();
        data.tipo = $("#perfil").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{route('traspasar_nna')}}",
            data: data
        }).done(function(resp) {
            console.log(resp);
            if(resp.estado == 1){
                toastr.success('Traspaso de NNA realizado satisfactoriamente');
                limpiarFormulario();
            }
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp) {

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });
}
function validaciontraspaso(){

    var gestorOrigen = document.getElementById("tipo_1").value;
    if(gestorOrigen == 0){
        toastr.error('Debe ingresar gestor de origen', 'Error!<br>', {timeOut: 5000});
        return false;
    }

    var elements = document.getElementById("tabla2").options;
    if(elements.length == 0){
        var datosOrigen = document.getElementById("dato_tipo_1").options;
        if(datosOrigen.length == 0){
            toastr.error('Debe existen datos a traspasar', 'Error!<br>', {timeOut: 5000});
            return false;
        }else{
            toastr.error('Debe ingresar datos en la tabla de destino', 'Error!<br>', {timeOut: 5000});
            return false;
        }
    }

    var gestorDestino = document.getElementById("tipo_2").value;
    
    if(gestorDestino == ""){
        toastr.error('Debe ingresar el destinatario', 'Error!<br>', {timeOut: 5000});
        return false;
    }
    return true;
}
function limpiarFormulario(){
    bloquearPantalla();
    $("#tipo_2 option").prop("disabled", false);
    $("#dato_tipo_1").html("");
    $("#tabla2").html("");
    $("#tipo_1 option[value='']").attr("selected", true);
    $("#tipo_2 option[value='']").attr("selected", true);
    $(".tabla").css("display","none");
    desbloquearPantalla();
}

function limpiarInputBusqueda(){
    $("#chkcomuna option:selected").prop('selected', false);
    $("#perfil option:selected").prop('selected', false);
    $("#tipo_2 option").prop("disabled", false);
    $("#dato_tipo_1").html("");
    $("#tabla2").html("");
    $("#tipo_1 option[value='']").attr("selected", true);
    $("#tipo_2 option[value='']").attr("selected", true);
    $(".tabla").css("display","none");
}

function filterFunction(tipo) {
    if(tipo == 1){
        var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("dato_tipo_1");
    a = div.getElementsByTagName("option");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
        } else {
        a[i].style.display = "none";
        }
        }
    }else{
        console.log("aqui");
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput2");
        filter = input.value.toUpperCase();
        div = document.getElementById("tabla2");
        a = div.getElementsByTagName("option");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }

}

var modalConfirm = function(callback){
  
  $("#btn-confirm").on("click", function(){
    if(validaciontraspaso() == true){
        $("#mi-modal").modal('show');
    }
  });

  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    confirmarTraspaso();
  }else{
    //Acciones si el usuario no confirma
    $("#result").html("NO CONFIRMADO");
  }
});

</script>
@endsection
<!-- FIN CZ SPRINT 66 -->