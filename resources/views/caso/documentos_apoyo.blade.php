@extends('layouts.main')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h5><i class="fa fa-file-pdf-o"></i><b>  Documentación de Apoyo</b></h5>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4 shadow-sm">
        <div class="row">
            <div class="form-group">
                <h5>  Descargar Documentación</h5>
            </div>
            <ul  class="w-100">
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">Documento de Apoyo para la Gestión del Sistema Alerta Ninñez 2019-2020</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/Gestión_del_Sistema_Alerta_Ninñez_2019-2020.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">Documento de Apoyo para la aplicación del instrumento de diagnóstico y evaluación de la OLN 2020</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/Documento_de_Apoyo_para_la_aplicación_del_instrumento_de_diagnóstico_y_evaluación_de_la_OLN_2020.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">Documento de apoyo para la Gestión de Casos 2020</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/Documento_de_apoyo_para_la_Gestión_de_Casos_2020.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">Manual de trabajo para Terapeutas Familiares OLN 2020</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/Manual_de_trabajo_para_Terapeutas_Familiares_OLN_2020.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">OOTT OLN 2020</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/OOTT_OLN_2020.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row p-2">
                        <div class="col-9">
                            <label for="">Documento de apoyo para la Gestión Comunitaria.</label>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/documentos/Documento_de_apoyo_para_la_Gestión_Comunitaria.pdf"><button type="button" onclick="" class="btn btn-success" ><i class="fa fa-file-pdf-o"></i>  <b>Descargar</b></button></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@stop