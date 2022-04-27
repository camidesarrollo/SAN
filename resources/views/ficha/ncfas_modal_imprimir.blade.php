
<div id="ncfasModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ncfasModalImprimir" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="width:200%;margin-left:-250px;" >
			<div class="card p-4 shadow-lg" >
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="position: absolute; right: 5px; top: 5px; width: 23px; height: 23px; padding: 0; margin: 0;">&times;</span>
				</button>

				<div class="row pt-3 pl-3 pr-3">
  					<div class="col">
  						<p>
  							<b>Nombre:</b> {{$data->nombre}}
  							<br>
  							<b>Run:</b> <?php print_r(Helper::devuelveRutX(number_format($data->run,0,",",".")."-".($data->dig)));?></p>
  					</div>

  					<div class="col" align="right">
  						<p><b>Fecha:</b> {{date("d/m/Y")}}</p>
  					</div>
				</div>

				<hr class="bg-dark">

				<div class="container-fluid">
				
					@foreach($array_ncfas as $ncfas)
					<div class="row w-100">
						<div class="col-2 text-ncfas-dimension">
					  		<p class="text-ncfas-dimension-parrafo">{{$ncfas['dim_enc_nom']}}</p>
					  	</div>

					  	@foreach($ncfas['pregunta'] as $preg)
							
							<div class="col p-0 m-1 text-ncfas-pregunta">
						  		<p class="text-ncfas-pregunta-parrafo">{{$preg['nom_var']}}</p>
						  	</div>

						@endforeach

					</div>

					<div class="row w-100">

						 <div class="col-2 text-ncfas-fase">
						  	<p class="text-ncfas-fase-parrafo text-center"><img src="/img/icono-in-out-01.svg" width="12" height="12">Ingreso PAF</p>
						 </div>

							@foreach($ncfas['res_fase_uno'] as $fase_uno)

		    					@php $fondo_color=""; @endphp

		    					<?php if($fase_uno['alt_val']=='N/A') $fondo_color="#c5c5c5"; ?>
		    					<?php if($fase_uno['alt_val']=='+2')  $fondo_color="#009B0E";  ?>
		    					<?php if($fase_uno['alt_val']=='+1')  $fondo_color="#4db506";  ?>
		    					<?php if($fase_uno['alt_val']=='0')   $fondo_color="#8ACB17";  ?>
		    					<?php if($fase_uno['alt_val']=='-1')  $fondo_color="#fed719";  ?>
		    					<?php if($fase_uno['alt_val']=='-2')  $fondo_color="#FD7D0C";  ?>
		    					<?php if($fase_uno['alt_val']=='-3')  $fondo_color="#DF021A";  ?>
		    					<?php if($fase_uno['alt_val']=='D')   $fondo_color="#c5c5c5";  ?>

		    					 <div class="col m-1 val-ncfas-fase-1" style="background-color:<?php echo $fondo_color; ?>;">
						  			<b>{{$fase_uno['alt_val']}} </b>
						 		</div>
		    				
		     				@endforeach

					</div>

					

		    			<div class="row w-100">
						 <div class="col-2 text-ncfas-fase">
						  	<p class="text-ncfas-fase-parrafo text-center"><img src="/img/icono-in-out-02.svg" width="12" height="12">Cierre PAF</p>
						 </div>

							@foreach($ncfas['res_fase_dos'] as $fase_dos)

		    					@php $fondo_color=""; @endphp

		    					<?php if($fase_dos['alt_val']=='N/A') $fondo_color="#c5c5c5"; ?>
		    					<?php if($fase_dos['alt_val']=='+2')  $fondo_color="#009B0E";  ?>
		    					<?php if($fase_dos['alt_val']=='+1')  $fondo_color="#4db506";  ?>
		    					<?php if($fase_dos['alt_val']=='0')   $fondo_color="#8ACB17";  ?>
		    					<?php if($fase_dos['alt_val']=='-1')  $fondo_color="#fed719";  ?>
		    					<?php if($fase_dos['alt_val']=='-2')  $fondo_color="#FD7D0C";  ?>
		    					<?php if($fase_dos['alt_val']=='-3')  $fondo_color="#DF021A";  ?>
		    					<?php if($fase_dos['alt_val']=='D')   $fondo_color="#c5c5c5";  ?>

		    					<div class="col m-1 val-ncfas-fase-2" style="background-color:<?php echo $fondo_color; ?>;">
						  			<b>{{$fase_dos['alt_val']}}</b>
						 		</div>
		    				
		    				@endforeach
		    			</div>
		    			<br>

		    			<!-- COMENTARIOS X FASE -->
		    			<div class="row w-100 mb-3" style="padding-left: 12px;">
							 <div class="col-12 p-0 text-ncfas-comentario">
							 	<b>Comentario Ingreso PAF:</b>
							 </div>

							 <div class="col-12 p-1 val-ncfas-comentario">
							 	<p>{{$ncfas['comentario']}}</p>
							 </div>
						</div>
						

							<div class="row w-100" style="padding-left: 12px;">
								<div class="col-12 p-0 text-ncfas-comentario">
								 	<b>Comentario Cierre PAF:</b>
								 </div>

								 <div class="col-lg-12 p-1 val-ncfas-comentario">
								 	<p>{{$ncfas['comentario_fase_dos']}}</p>
								 </div>
							</div>
						<!-- COMENTARIOS X FASE -->

						<!-- NOTAS -->
						@if ($ncfas['dim_enc_id'] == 2 || $ncfas['dim_enc_id'] == 3 || $ncfas['dim_enc_id'] == 4 || $ncfas['dim_enc_id'] == 5)
						<div class="row w-100" style="padding-left: 12px;">
							<div class="col-12 p-0 text-ncfas-nota">
								@if ( $ncfas['dim_enc_id'] == 2 )
			    					<p><b>Nota: esta sección se refiere al progenitor(es). Si está presente, o el cuidador(es) es actual.</b></p>

			    				@elseif ( $ncfas['dim_enc_id'] == 3 || $ncfas['dim_enc_id'] == 4 )
			    					<p><b>Nota: esta sección se refiere a miembros de la familia viviendo en el mismo o diferentes hogares.</b></p>

			    				@elseif ( $ncfas['dim_enc_id'] == 5 )
			    					<p><b>Nota: esta sección es pertinente para todos los niños en la familia. Si hay más de un niño/a, pueden tener problemas distintos. Puntúe a la familia de tal forma que si cualquier niño tiene, por ejemplo, un problema de conducta, la familia como un todo experimenta ese problema. De esta forma, todos los niños en la familia pueden contribuir a los puntajes en un único registro.</b></p>
			    				@endif
							 </div>
						</div>
						@endif
						<!-- NOTAS -->
						<br>
						<hr class="bg-secondary">

					@endforeach
				</div>

	<div class="container">
				<div class="col-md-10 offset-md-1">

					<div class="row">
						<div class="col text-ncfas-simbologia-1">Desconocido</div>
						<div class="col text-ncfas-simbologia-1">Problema Serio</div>
						<div class="col text-ncfas-simbologia-1">Problema Moderado</div>
						<div class="col text-ncfas-simbologia-1">Problema Leve</div>
						<div class="col text-ncfas-simbologia-1">Linea Base Adecuado</div>
						<div class="col text-ncfas-simbologia-1">Leve Fortaleza</div>
						<div class="col text-ncfas-simbologia-1">Clara Fortaleza</div>
						<div class="col text-ncfas-simbologia-1">No Aplica</div>
					</div>

					<div class="row">
						<div class="col" style="background-color:#c5c5c5;height:5px;"></div>
						<div class="col" style="background-color:#DF021A;height:5px;"></div>
						<div class="col" style="background-color:#FD7D0B;height:5px;"></div>
						<div class="col" style="background-color:#fed719;height:5px;"></div>
						<div class="col" style="background-color:#8ACB17;height:5px;"></div>
						<div class="col" style="background-color:#4db506;height:5px;"></div>
						<div class="col" style="background-color:#009B0E;height:5px;"></div>
						<div class="col" style="background-color:#c5c5c5;height:5px;"></div>
					</div>

					<div class="row">
						<div class="col text-ncfas-simbologia-2">D</div>
						<div class="col text-ncfas-simbologia-2">-3</div>
						<div class="col text-ncfas-simbologia-2">-2</div>
						<div class="col text-ncfas-simbologia-2">-1</div>
						<div class="col text-ncfas-simbologia-2">0</div>
						<div class="col text-ncfas-simbologia-2">+1</div>
						<div class="col text-ncfas-simbologia-2">+2</div>
						<div class="col text-ncfas-simbologia-2">N/A</div>
					</div>

				</div>
	</div>			
				<br>

				<div class="col-lg-12" align="right">
					<a type="button" onclick="printDiv('areaImprimir')" id="btn-etapa-diagnostico" class="btn btn-success btnEtapa" ><strong>Imprimir</strong></a>
				</div>

			</div>
		</div>
	</div>
<style type="text/css">
	.text-ncfas-comentario{
		text-align: left; 
		font-size: 11px;
	}	

	.val-ncfas-comentario{
		text-align:left; 
		border:1pt solid #dddfeb;
		font-size: 11px;
	}

	.text-ncfas-nota{
		text-align:left;
		font-size: 11px;
	}

	.text-ncfas-dimension{
		/*background-color:white;
		vertical-align:top;*/
		/*font-size:13px;*/
		font-size: 15px;
		font-weight: 800;
		/*text-align:left;*/
		/*width: 12.499999995%*/
		display: table; 
     	height: 80px;
	}

	.text-ncfas-dimension-parrafo{
		display: table-cell;
    	vertical-align: middle;
	}

	.text-ncfas-pregunta{
		/*border-bottom:3px solid #fff;*/
		/*border-right:12px solid #fff;*/
		/*font-size: 8px;*/
		/*font-size: 10px;*/
		font-size: 11px;
		text-align:center;
		width:10%;
		word-break: break-word;
		font-weight: 800;
		display: table; 
     	height: 80px;
	}

	.text-ncfas-pregunta-parrafo{
		display: table-cell;
    	vertical-align: middle;
	}

	.text-ncfas-fase{
		font-size:11px;
		/*width:10%;*/
		/*width: 12.499999995%;*/
		text-align: right;
		display: table; 
     	height: 20px;
	}

	.text-ncfas-fase-parrafo{
		display: table-cell;
    	vertical-align: middle;
	}

	.val-ncfas-fase-1{
		color:white;
		/*border-bottom:3px solid #fff;*/
		/*border-right:12px solid #fff;*/
		height:20px;
		font-size: 14px;
		text-align:center;
		/*width:10%;*/
	}

	.val-ncfas-fase-2{
		color:white;
		/*border-bottom:3px solid #fff;
		border-right:12px solid #fff;*/
		height:20px;
		font-size: 14px;
		text-align:center;
		/*width:10%;*/
	}

	.text-ncfas-simbologia-1{
		font-size: 11px;
		text-align: center;
	}

	.text-ncfas-simbologia-2{
		text-align: center;
	}
</style>
</div>

<script>

	function printDiv(nombreDiv=null) {
     
	     var contenido= document.getElementById('ncfasModal').innerHTML;
	     var contenidoOriginal= document.body.innerHTML;

	     document.body.innerHTML = contenido;

	     window.print();

	     location.reload();

	    // document.body.innerHTML = contenidoOriginal;
	
	}

</script>

