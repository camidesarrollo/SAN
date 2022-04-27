@extends('layouts.main')

@section('contenido')
    <section class=" p-3">
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <span class="fa fa-warning mr-3"></span> Bienvenido <strong>{{ session()->all()['nombre_usuario'] }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row accesos justify-content-center">
                <div class="col-lg-4">
                    <a href="{{ route('vista.casos.registrados') }}">
                        <div class="shadow-sm p-3 btn-outline-secondary border-primary btn btn-block"> 
                            <h3><span class="fa fa-inbox"></span></h3>
                            <h5> Mi nómina</h5>
                            <small>Revisa todos los NNA asignados</small>
                        </div>
                    </a>
                </div>

                <!--<div class="col">
                    <a href="{{ route('alertas.listar') }}">
                        <div class="shadow-sm p-3 btn-outline-secondary border-warning btn btn-block"> 
                            <h3><span class="fa fa-exclamation-circle"></span></h3>
                            <h5>Alertas Territoriales </h5>
                            <small>Alertas creadas por Sectorialistas</small>
                        </div>
                    </a>
                </div>-->
                <!--<div class="col">
                    <a href="{{ route('vista.casos.asignados') }}">
                        <div class="shadow-sm p-3 btn-outline-secondary border-info btn btn-block"> 
                            <h3><span class="fa fa-clipboard"></span></h3>
                            <h5> Casos Asignados </h5>
                            <small>Casos (NNA) validados a la fecha</small>
                        </div>
                    </a>
                </div>-->
            </div>
            
            <!-- <h6><b>Reportes:</b></h6> -->

            <!--  <div class="row accesos"> -->


                <!--<div class="col">
                    <a href="{{ route('alertas.listar') }}">
                        <div class="shadow-sm p-3 btn-outline-secondary border-warning btn btn-block"> 
                            <h3><span class="fa fa-exclamation-circle"></span></h3>
                            <h5>Alertas Territoriales </h5>
                            <small>Alertas creadas por Sectorialistas</small>
                        </div>
                    </a>
                </div>-->
                <!--<div class="col">
                    <a href="{{ route('vista.casos.asignados') }}">
                        <div class="shadow-sm p-3 btn-outline-secondary border-info btn btn-block"> 
                            <h3><span class="fa fa-clipboard"></span></h3>
                            <h5> Casos Asignados </h5>
                            <small>Casos (NNA) validados a la fecha</small>
                        </div>
                    </a>
                </div>-->
   <!--          </div> -->

            <hr>

                    <div class="row d-none">
                        <div class="col-12">
                            <div class="card shadow-sm ">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header p-3">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="m-2">Estadísticas de tu gestión</h6>
                                        </div>
                                        <div class="col">
                                            <a href="ficha-caso.php" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Detalles</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                
                                <div class="card-body">
                                    <div class="row">
                                                <div class="col-3">
                                                    <h6>Asignaciones</h6>
                                                    <p>Ejecutadas: <strong>67%</strong></p>
                                                    <div class="progress">
                                                      <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 67%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <hr>
                                                    <p>En proceso: <strong>33%</strong></p>
                                                    <div class="progress">
                                                      <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 33%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <h6>Terapia Familiar</h6>
                                                    <canvas id="pie-chart2" width="200" height="150"></canvas>
                                                    <ul>
                                                        <li><p>NNA en Terapia Familiar: <a href=""><strong>30</strong><small> <span class="fa fa-external-link"></span></small></a> </p></li>
                                                        <li><p>NNA que rechazan Terapia Familiar: <a href=""><strong>11</strong></a></p></li>
                                                    </ul>
                                                </div>
                                                <div class="col-3">
                                                    <h6>Alertas Territoriales</h6> 
                                                    <canvas id="pie-chart3" width="200" height="150"></canvas>
                                                    <ul>
                                                        <li><p>NNA solo con Alerta territorial: <a href=""><strong>19</strong><small> <span class="fa fa-external-link"></span></small></a> </p></li>
                                                        <li><p>NNA en Terapia Familiar y con Alerta territorial: <a href=""><strong>24</strong></a></p></li>
                                                    </ul>
                                                </div>
                                                <div class="col-3">
                                                    <h6>Porcentaje de NNA por prioridad</h6>
                                                    <canvas id="pie-chart4" width="200" height="150"></canvas>
                                                    <ul>
                                                        <li><p>NNA solo con Alerta territorial: <a href=""><strong>19</strong><small> <span class="fa fa-external-link"></span></small></a> </p></li>
                                                        <li><p>Total de NNA en Terapia Familiar y con Alerta territorial: <a href=""><strong>24</strong></a></p></li>
                                                    </ul>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    
   
    <!-- <section class="p-1">
        <div class="container panel">
            <h4 class="text-center">Puede realizar las siguientes tareas</h4>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 p-3">
                            <div class="card p-3 text-center ">
                                <h3><span class="oi oi-bell"></span></h3>
                                <a href="{{ route('vista.casos.registrados') }}"><h4>Mis asignaciones</h4></a>
                                <p>Revisa el listado de nuevos NNA asignados</p>
                            </div>
                        </div>

                        <div class="col-6 p-3">
                            <div class="card p-3 text-center  ">
                                <h3><span class="oi oi-warning"></span></h3>
                                <a href="{{ route('alertas.listar') }}"><h4>Alerta Manual</h4></a>
                                <p>Puedes ingresar una Alerta Manual para que sea atendido</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">

                        <div class="col-6 p-3">
                            <div class="card p-3 text-center ">
                                <h3><span class="oi oi-clipboard"></span></h3>
                                <a href="{{ route('vista.casos.asignados') }}"><h4>Casos Asignados a Facilitador</h4></a>
                                <p>Revisa el listado de casos (NNA) validados a la fecha</p>
                            </div>
                        </div>

						<div class="col-6 p-3">
							<div class="card p-3 text-center  ">
								<h3><span class="oi oi-bar-chart"></span></h3>
								<a href="{{--route('coordinador.caso.reporte')--}}"><h4>Cuadro de Mando</h4></a>
								<p>Reportes Varios.</p>
							</div>
						</div>
						
                    </div>
                </div>
            </div>
        </div>
    </section> -->

<script>
new Chart(document.getElementById("pie-chart2"), {
    type: 'pie',
    data: {
      labels: ["Dato 1", "Dato 1"],
      datasets: [{
        label: "Population (millions)",
        backgroundColor: ["#57c7d4", "#fb9678",],
        data: [2478,5267]
      }]
    },
    options: {
      // title: {
      //   display: true,
      //   text: 'Predicted world population (millions) in 2050'
      // }
    }
});

new Chart(document.getElementById("pie-chart3"), {
    type: 'pie',
    data: {
      labels: ["Dato 1", "Dato 1"],
      datasets: [{
        label: "Population (millions)",
        backgroundColor: ["#ffaf00","#e8c3b9",],
        data: [734,784]
      }]
    },
    options: {
      // title: {
      //   display: true,
      //   text: 'Predicted world population (millions) in 2050'
      // }
    }
});
new Chart(document.getElementById("pie-chart4"), {
    type: 'pie',
    data: {
      labels: ["Dato 1", "Dato 1"],
      datasets: [{
        label: "Population (millions)",
        backgroundColor: ["#57c7d4", "#fb9678",],
        data: [2478,5267]
      }]
    },
    options: {
      // title: {
      //   display: true,
      //   text: 'Predicted world population (millions) in 2050'
      // }
    }
});

</script>

@stop