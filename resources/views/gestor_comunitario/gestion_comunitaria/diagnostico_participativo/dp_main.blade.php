<div class="card colapsable shadow-sm" id="contenedor_listar_bitacora">
    <a class="btn text-left p-0 collapsed" id="desplegar_listar_bitacora" data-toggle="collapse" data-target="#desplegar_factores" aria-expanded="false" aria-controls="desplegar_factores">
		<div class="card-header p-3">
			<h5 class="mb-0">
				<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-info"></i></button>
				&nbsp;&nbsp;V. FACTORES DE RIESGO Y FACTORES PROTECTORES 
			</h5>
		</div>
	</a>

	<div class="collapse" id="desplegar_factores">
		<div class="card-body">
    		@includeif('gestor_comunitario.gestion_comunitaria.diagnostico_participativo.factores_riesgo_protectores')	
		</div>
	</div>
</div>
@section('script')
<script type="text/javascript">
	$( document ).ready(function() {

	});
</script>
@endsection