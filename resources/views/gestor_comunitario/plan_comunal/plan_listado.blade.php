@extends('layouts.main')
@section('contenido')
<div class="wrapper" >
	<!-- MAIN  -->
	
	<main id="content">
		@if(session()->has('success'))
		    <div class="alert alert-success">
		        {{ session()->get('success') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
		    </div>
		@endif
		@if(session()->has('danger'))
		    <div class="alert alert-danger">
		        {{ session()->get('danger') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
		    </div>
        @endif
        
        <section>
            <div class="container-fluid">
              <div id="ficha-nna">
                
              	<!-- MENU MAIN  -->
                  <ul class="nav nav-tabs sticky-top" id="menu-ficha-acciones" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show" href="">Plan Comunal</a>
                    </li>
                  </ul>
                <!-- FIN MENU MAIN  -->

                  <!-- SUB-MENU MAIN  -->                
				<ul class="nav nav-pills mt-0 p-1 sticky-top" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" id="territorial-tab" data-toggle="tab" href="#territorial" role="tab" aria-controls="territorial" aria-selected="false">Bitacora</span></a>
                    </li>                    
                  </ul>
                <!-- FIN SUB-MENU MAIN  -->
                
                <!-- LISTADO BITACORA -->
                    <div class="card shadow p-4 ">
                    
                        <div class="tab-content" id="myTabContent">
                            
                            <div class="tab-pane active show fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                {{$estado}}
                                @includeif('gestor_comunitario.bitacora.listar_bitacora')
                            </div>
                            
                        </div>
                    </div>
                   
                <!-- LISTADO BITACORA -->
				    
			  </div>
			</div>
        </section>

	</main>
	<!-- FIN MAIN -->
</div>
@stop
@section('script')

	<script type="text/javascript">
		$(document).ready( function () {
			
			$('#tabla_list_bitacora').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"ajax": "{{ route('bitacora.listar') }}",
				"columns": [
					{ "data": "created_at", "className": "text-center" },
					{ "data": "procesoanual.pro_an_nom", "className": "text-center"  },
					{ "data": "usuarios.nombre_completo", "className": "text-center"  },
					{ "data": "usu_pro_id", "className": "text-center"  },
					{ "data": "usu_pro_per", "className": "text-center"  },
					{
						"data": null, "className": "dt-center", "orderable": false,
						"render": function (data, type, full, meta) {
							return '<a href="{{ route('procesoanual.ver') }}/'+ full.pro_an_id +'" class="btn btn-primary" >' +
								'Ver' +
								'</a>';
						}
					},
				]
			});
			
		});

		public function crearBitacora(){

            

        }	

	</script>

@endsection