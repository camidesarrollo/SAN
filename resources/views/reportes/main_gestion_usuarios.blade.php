@extends('layouts.main')
@section('contenido')
    <section class=" p-3">
        <div class="container-fluid">
            <section class="p-1 cabecera">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h5><i class="{{$icono}}"></i> Gestión de Usuarios</h5>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card shawdow-sm p-4">
                <div class="row accesos justify-content-center">                
                    <div class="col-lg-3">
                        <a href="{{ route('reportes.usuarios.perfil') }}">
                            <div class="card shadow-sm p-3 btn btn-block">                                 
                                <h5><span class="fa fa-user" style="color:#6495ED;"></span> Usuarios por Perfil</h5>                                
                            </div>
                        </a>
                    </div>
    
                    <div class="col-lg-3">
                        <a href="{{ route('reportes.usuarios.oln')}}">
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-user" style="color:#6495ED;"></span> Usuarios por OLN</h5>
                            </div>
                        </a>
                    </div>
                    
                    <!-- INICIO DC -->
                    <div class="col-lg-3">
                        <a href="{{ route('gestionar.usuarios.oln')}}">
                            <div class="card shadow-sm p-3 btn btn-block"> 
                                <h5><span class="fa fa-user-plus" style="color:#6495ED;"></span> Gestionar Usuarios</h5>
                            </div>
                        </a>
                    </div>
                    <!-- FIN DC -->
                    {{-- <div class="col-lg-3">
                        <a href="{{ route('gestion.proceso.anual').'?tipo_gestion=1' }}">
                            <div class="shadow-sm p-3 btn-outline-secondary border-primary btn btn-block"> 
                                <h3><span class="fa fa-folder-open"></span></h3>
                                <h5>Administrador de Usuarios</h5>
                                <small></small>
                            </div>
                        </a>
                    </div>             --}}
                </div>
            </div>

@stop