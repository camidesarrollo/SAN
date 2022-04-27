<!-- INICIO CZ SPRINT 77 -->
@extends('layouts.main')


@section('contenido')
<meta name="_token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-12 pt-2">
            <h5><i class="{{$icono}}" style="margin-right: 10px;"></i>Agrupar NNA</h5>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div id="tabs" class="card p-4 shadow-sm w-100">
            <div id="tabs-1">
                <h4>Caso  a prevalecer</h4> 
                <br>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Elije comuna</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select id="comuna" name="comuna" class="form-control" style="color: #858796;">
                            <!-- CZ SPRINT 76  -->
                            @php $getComunas = Helper::getComunas(); @endphp
                            <option value="">Seleccione la comuna</option>
                            @foreach($getComunas AS $c1 => $v1)
                            <!-- CZ SPRINT 76  -->
                            <option value="{{$v1->com_cod}}">{{$v1->com_nom}}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Seleccione Gestor</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="tipo_1">

                        </select>
                    </div>
                </div>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label for="inputPassword" class="col-form-label">
                            <b>Caso Indice</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="prueba">

                        </select>
                    </div>

                </div>
                <div id="select_comunas_rep" class="form-group row">
                    <div class="col-sm-3">
                        <label  class="col-form-label">
                            <b>Detalle de los caso a traspasar</b>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <label class="detalle_caso_traspasar"></label>
                    </div>

                </div>
                <div class="row tabla" style="display:none">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary" onclick="limpiarFormulario();">Limpiar</button>
                        <button type="submit" class="btn btn-success" id="btn-confirm">Confirmar Agrupación</button>
                    </div>
                </div>
                <br>

                <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />

                <div id="tabla-casos">
                    <table id="registrados" class="table table-hover table-striped w-100"
                        attr2="{{route('coordinador.caso.ficha')}}" style="display:none">
                        <thead>
                            <tr>
                                <th colspan="9">
                                    <div id="filtros-table"></div>
                                </th>
                            </tr>
                            <tr>
                                <th>Caso</th>
                                <th >R.U.N</th>
                                <th>Nombre NNA</th>
                                <th>Gestor</th>
                                <th>Estado Gesti&oacute;n Caso</th>
                                <th>Estado Terapia Familiar</th>
                                <th style="display:none">RUNSINFORMATO</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
    id="mi-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">¿Esta seguro que desea Agrupar los NNA?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center">Detalle de la agrupación</h5>
                <br>
                <h6>Al caso índice <strong class="col-form-label indice_cas"></strong> Se agruparán los siguientes NNA:
                    <strong class="col-form-label casos_agrup"></strong>
                </h6>
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
    // limpiarFormulario();
    bloquearPantalla();

    $(".tabla").css('display', 'none');
    let data = new Object();
    data.com_cod = $('select[name=chkcomuna] option').filter(':selected').val();
    data.id_perfil = 3;
    $.ajax({
        type: "GET",
        url: "{{route('obtenerUsuario')}}",
        data: data
    }).done(function(resp) {
        if (resp.estado == 1) {
            var html = '<option value ="">Seleccione ' + $('select[name=perfil] option').filter(':selected')
                .text() + '</option>';
            for (var i = 0; i < resp.data.length; i++) {
                html += '<option value = "' + resp.data[i].id + '">' + resp.data[i].nombres + ' ' + resp.data[i]
                    .apellido_paterno + ' ' + resp.data[i].apellido_materno + '</option>';
            }
            $("#tipo_1").html(html);
            $("#tipo_2").html(html);
            $(".tabla").css('display', 'block');
        } else {
            var html = '<option value="">Seleccione </option>';
            $("#tipo_1").html(html);
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
    data.id_perfil = 3;
    data.usuario_id = this.value;
    data.comuna = $('#comuna').val();
    $.ajax({
        type: "GET",
        url: "{{route('listarCaso')}}",
        data: data
    }).done(function(resp) {
        if (resp.estado == 1) {
            var html = '';
            html += '<option value = "0">Seleccione</option>';
            for (var i = 0; i < resp.data.length; i++) {
                var id = resp.data[i].cas_id + " - " + resp.data[i].run + " - " +  resp.data[i].nna_nombre_completo;
                html += '<option value = "' + id + '">' + resp.data[i].cas_id + '-' + resp.data[i]
                    .nna_nombre_completo + '</option>';
            }
            $("#prueba").html('');
            $("#prueba").html(html);
        }
        desbloquearPantalla();
    }).fail(function(objeto, tipoError, errorHttp) {

        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });

})

$("#prueba").on('change', function() {
    if ($('select[name=prueba] option').filter(':selected').val() != "0") {
        $(".tabla").css('display', 'block');
        filtrarTabla();
    }

})
$('#comuna').on('change', function() {
    if ($('select[name=comuna] option').filter(':selected').val() != "") {
        // limpiarFormulario();
        bloquearPantalla();

        $(".tabla").css('display', 'none');
        let data = new Object();
        data.com_cod = $('select[name=comuna] option').filter(':selected').val();
        data.id_perfil = 3;
        $.ajax({
            type: "GET",
            url: "{{route('obtenerUsuario')}}",
            data: data
        }).done(function(resp) {
            if (resp.estado == 1) {
                var html = '<option value ="">Seleccione </option>';
                for (var i = 0; i < resp.data.length; i++) {
                    html += '<option value = "' + resp.data[i].id + '">' + resp.data[i].nombres + ' ' +
                        resp.data[i]
                        .apellido_paterno + ' ' + resp.data[i].apellido_materno + '</option>';
                }
                $("#tipo_1").html(html);
                $("#tipo_2").html(html);
            } else {

            }
            desbloquearPantalla();
        }).fail(function(objeto, tipoError, errorHttp) {

            desbloquearPantalla();
            manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
            return false;
        });

    } else {
        $("#tipo_1").html(html);
    }
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
        if (a[i].style.display != 'none') {
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
            if (option1[i].innerText == option2[j].innerText) {
                $("#tabla2 option[value='" + option1[i].innerText + "']").remove();
            }
        }
    }
}

function todosDestino() {
    var selectValue = '';
    div = document.getElementById("dato_tipo_1");
    a = div.getElementsByTagName("option");
    for (i = 0; i < a.length; i++) {
        if (a[i].style.display != 'none') {
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
            if (option1[i].innerText == option2[j].innerText) {
                $("#dato_tipo_1 option[value='" + option1[i].innerText + "']").remove();
            }
        }
    }


}

function confirmarTraspaso() {
    bloquearPantalla();
    let data = new Object();
    let casos = [];
    let caso_indice = $("#prueba").val().split("-");
    data.casos = val;
    data.caso_indice = caso_indice[0];
    data.run_indice = caso_indice[1];

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "{{route('administar.unificarCaso')}}",
        data: data
    }).done(function(resp) {
        console.log(resp);
        if (resp.estado == 1) {
            toastr.success(resp.mensaje);
        }
        desbloquearPantalla();
        filtrarTabla();
        limpiarFormulario();
    }).fail(function(objeto, tipoError, errorHttp) {

        desbloquearPantalla();
        manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
        return false;
    });
}

function validarAgrupacion() {

    if(val.length == 0){
        return false;
    }

    return true;
}

function limpiarFormulario() {
    bloquearPantalla();
    $("#tipo_2 option").prop("disabled", false);
    $(".indice_cas").html("");
    $(".casos_agrup").html("");
    $("#prueba").html("");
    $(".detalle_caso_traspasar").html("");
    $("#comuna option[value='']").attr("selected", true);
    $("#prueba option[value='']").attr("selected", true);
    $("#tipo_1 option[value='']").attr("selected", true);
    // let dataTable_casos = $('#registrados').DataTable();
    // dataTable_casos.clear().destroy();
    $(".tabla").css("display", "none");
    desbloquearPantalla();
    

}

function limpiarInputBusqueda() {
    $("#chkcomuna option:selected").prop('selected', false);
    $("#perfil option:selected").prop('selected', false);
    $("#tipo_2 option").prop("disabled", false);
    $("#dato_tipo_1").html("");
    $("#tabla2").html("");
    $("#tipo_1 option[value='']").attr("selected", true);
    $("#tipo_2 option[value='']").attr("selected", true);
    $(".tabla").css("display", "none");
}

function filterFunction(tipo) {
    if (tipo == 1) {
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
    } else {
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

var modalConfirm = function(callback) {

    $("#btn-confirm").on("click", function() {
        if (validarAgrupacion() == true) {
            $(".indice_cas").html($("#prueba").val());
            $("#mi-modal").modal('show');
        }else{
            toastr.error('No se ha seleccionado ningun caso para agrupar.');
        }
    });

    $("#modal-btn-si").on("click", function() {
        callback(true);
        $("#mi-modal").modal('hide');
    });

    $("#modal-btn-no").on("click", function() {
        callback(false);
        $("#mi-modal").modal('hide');
    });
};

modalConfirm(function(confirm) {
    if (confirm) {
        //Acciones si el usuario confirma
        confirmarTraspaso();
    } else {
        //Acciones si el usuario no confirma
        $("#result").html("NO CONFIRMADO");
    }
});
var val = [];

var html = '';

function filtrarTabla() {
    bloquearPantalla();
    let chkcomuna = new Array();
    $.each($('#comuna option:selected'), function() {
        chkcomuna.push($(this).val());
    });
    let casoIndice =  $("#prueba").val().split("-");
    chkcomuna = chkcomuna.join(',');
    comunas = chkcomuna;
    let data = new Object();
    data.comunas = comunas;
    data.caso_indice = casoIndice[0];
    let dataTable_casos = $('#registrados').DataTable();
    dataTable_casos.clear().destroy();
    dataTable_casos = $('#registrados').DataTable({
        //"fixedHeader": { header:true },
        "dom": '<lf<t>ip>',
        "order": [
            //[2, "desc"],
            [0, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('get.casosComuna')}}",
            "data": data
        },
        "rowCallback": function( row, data ) {
            for(var i = 0; i < selected.length; i++){
                if(data.nna_run_con_formato == selected[i]){
                    $(row).addClass('selected');
                }
                
            }
        },
        "rowGroup": {
            startRender: function(rows, group) {
                return "Caso " + group;
            },
            dataSrc: "cas_id"
        },
        "columns": [

            {
                "data": "cas_id",
                "name": "cas_id",
                "className": "text-center",
                "visible": false
            },
            {
                "data": "nna_run_con_formato",
                "name": "nna_run_con_formato",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, row) {
                    let rut = esconderRut(data, "{{ config('constantes.ofuscacion_run') }}");
                    return rut;
                }
            },
            {
                "data": "nna_nombre_completo",
                "name": "nna_nombre_completo",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "render": function(data, type, full, meta) {
                    let formato = formateoNombres(full.nna_nom, full.nna_ape_pat);
                    return '<label data-toggle="tooltip" data-html="true" title="R.U.N.: ' + full
                        .nna_run_con_formato + '<br />Nombre completo:<br />' + full
                        .nna_nombre_completo + '">' + formato.nombre + ' ' + formato.ape_pat +
                        '</label>';
                }
            },
            {
				 "data": "usuario_nomb",
				 "className": "text-left"
			},
            {
                "name": "est_cas_nom",
                "className": "text-center",
                "orderable": true,
                "render": function(data, type, row) {
                    let html = row.est_cas_nom;
                    if (row.cas_est_pau == 0) html +=
                        '<br><i class="far fa-pause-circle fa-2x" style="color:red;" title="Caso Pausado"></i>';

                    return html;

                }
            },
            {
                "data": "est_tera_nom",
                "name": "est_tera_nom",
                "className": "text-center",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "data": "nna_run",
                "name": "nna_run",
                "className": "text-center",
                "visible": false
            },
        ],
        "language": {
            "url": "{{ route('index') }}/js/dataTables.spanish.json"
        },
        "drawCallback": function(settings) {
            $("#totalNNA").text(settings._iRecordsTotal);
            $('[data-toggle="tooltip"]').tooltip();
            $("#registrados").css("display", "table");
        },
    });


    desbloquearPantalla();
}

var selected = [];

html = "";

let arrayObjet = new Array();
    $('#registrados tbody').on('click', 'tr', function () {
        let guardar_temporal = new Object();
        html = "";
        val = [];
        var run = $(this)[0].cells[0].innerText;
        var id = $(this)._DT_RowIndex;
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            selected.splice( selected.indexOf($(this)[0].cells[0].innerText), 1 );

            $.each(arrayObjet, function(i){
                if(arrayObjet[i].run === run) {
                    console.log(i)
                    arrayObjet.splice(i,1);
                    return false;
        }
    });


        }else{
            $(this).addClass('selected');
            selected.push( $(this)[0].cells[0].innerText );

            let dataTable_casos = $('#registrados').DataTable();
            let rows = dataTable_casos.rows();
                rows.every(function(rowIdx, tableLoop, rowLoop){
                if(rows.data().length > 0 ) {
                    var data = this.data();  
                    if(run == data.nna_run_con_formato){
                        guardar_temporal.run = data.nna_run_con_formato;
                        guardar_temporal.cas_id = data.cas_id;
                        guardar_temporal.html = data.cas_id + " - " +data.nna_run_con_formato+" - " +  data.nna_nombre_completo;
                        arrayObjet.push( guardar_temporal);
                        // html += data.cas_id + " - " +data.nna_run_con_formato+" - " +  data.nna_nombre_completo + ", ";
                    }
            
                }
            
            });
}

        console.log(arrayObjet);

        for(var i = 0; i <arrayObjet.length; i ++){
            html += arrayObjet[i].html + ", ";
            val.push(arrayObjet[i].cas_id);

        }
        const str2 = html.substring(0, html.length - 2);
        $(".casos_agrup").html(str2);
        $(".detalle_caso_traspasar").html(str2);

      
    } );
</script>
@endsection
<!-- FIN CZ SPRINT 66 -->
