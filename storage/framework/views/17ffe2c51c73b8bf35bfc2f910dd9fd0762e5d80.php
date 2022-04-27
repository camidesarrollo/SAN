
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/moment-with-locales.min.js"></script>

<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/main.js?v=<?php echo e(date("YmdHis")); ?>"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/bootstrap-multiselect.js"></script>

<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/dataTables.rowsGroup.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/dataTables.rowGroup.min.js"></script>

<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/jquery-ui.js"></script>

<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/bootstrap.bundle.js"></script>

<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/jquery.rut.chileno.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/navegador.class.js"></script>

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>-->
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/toastr.min.js"></script>

<!--<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>-->
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/sum().js"></script>

<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/data.js"></script>
<script type="text/javascript" src="<?php echo e(env('APP_URL')); ?>/js/exporting.js"></script>


<script src="<?php echo e(env('APP_URL')); ?>/js/fullcalendar-4.3.1/packages/core/main.min.js"></script>
<script src="<?php echo e(env('APP_URL')); ?>/js/fullcalendar-4.3.1/packages/daygrid/main.min.js"></script>
<script src="<?php echo e(env('APP_URL')); ?>/js/fullcalendar-4.3.1/packages/interaction/main.min.js"></script>
<script src="<?php echo e(env('APP_URL')); ?>/js/fullcalendar-4.3.1/packages/timegrid/main.min.js"></script>



<script type="text/javascript">

	$(document).ready(function () {

        Highcharts.setOptions({
            colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            lang: {
                contextButtonTitle: "Opciones",
                viewFullscreen: "Ver en Pantalla Completa",
                downloadJPEG: "Descargar como imagen JPEG",
                downloadPDF: "Descargar como documento PDF",
                downloadPNG: "Descargar como imagen PNG",
                downloadSVG: "Descargar como vector de imagen SVG",
                printChart: "Imprimir Gráfico"
            },
            credits: {
                enabled: false
            }
        });

        //Disable paste class
		// $('.copypaste').on("paste",function(e) {
		// $('.copypaste').on("cut copy paste",function(e) {
  		//     		e.preventDefault();
  		//  });



   		//Disable paste all input document o 'textarea'
    // $(document).on('paste', function (e) {
    //     e.preventDefault();
    // });

		// $('#sidebarCollapse').on('click', function () {
		// 	$('#sidebar').toggleClass('active');
		// });

		$('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
			if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
				$('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
			}
		});
		//this code segment will activate parent modal dialog
		//after child modal box close then scroll problem will automatically fixed

		toastr.options = {
				"closeButton": true,
				"debug": true,
				"newestOnTop": true,
				"progressBar": false,
				"positionClass": "toast-top-center",
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "0",
				"hideDuration": "0",
				"timeOut": "50000",
				"extendedTimeOut": "3000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
		};


	$( "#btn_busqueda" ).on( "click", function() {

		if($("#nna_busqueda").val()!=""){
			 $.ajax({
				 url: "<?php echo e(route('casos.busquedaInteractiva')); ?>"+"/"+$("#nna_busqueda").val(),
				 type: "GET"
			 }).done(function(resp){

			 	var contenido_nna = "";
				var urlFichaCompleta = $("#ruta_ficha").val();

			 	if (resp.error=="1"){
			 		contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN incorrecto</div>";
					toastr.warning(contenido_nna);
			 	}else{
				 	if (resp.run_correcto=="0"){
				 		contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN incorrecto</div>";
						toastr.warning(contenido_nna);
				 	}else{
				 		if (resp.coincidencia=="1"){
							urlFichaCompleta+='/'+resp.run;
							var botonFichaCompleta = '<a class="btn btn-primary" href="'+urlFichaCompleta+'"><span class="align-middle"><font size="2px">Ficha NNA</font></span></a>';
							contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN: " + resp.nna_run_con_formato + "  "+botonFichaCompleta+"</div>";
							toastr.success(contenido_nna);
				 		}else{
				 			contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN no existe</div>";
							toastr.error(contenido_nna);
				 		}
				 	}		 		
			 	}
			 })
			 .fail(function(obj){
				toastr.info("Ocurrió un error inesperado, intente nuevamente.");
			    console.log(obj);
			 });		
			

		}

	});	

	});
	// tooltip
	/*$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})*/

	function caracteres_especiales(e) {
		//onkeypress='return caracteres_especiales(event)'
	    tecla = (document.all) ? e.keyCode : e.which;

	    //Tecla de retroceso para borrar, siempre la permite
	    if (tecla == 8) {
	        return true;
	    }

	    // parentesis (, siempre lo permite
	    if (tecla == 40) {
	        return true;
	    }

	    // parentesis ), siempre lo permite
	    if (tecla == 41) {
	        return true;
	    }

	    //coma, siempre lo permite
	    if (tecla == 44) {
	        return true;
	    }

	    //guión, siempre lo permite
	    if (tecla == 45) {
	        return true;
	    }

	    //punto, siempre lo permite
	    if (tecla == 46) {
	        return true;
	    }


	    // Patron de entrada, en este caso solo acepta numeros y letras
	    patron = /[A-Za-z0-9,ñ,Ñ,áéíóúÁÉÍÓÚ ]/;
	    tecla_final = String.fromCharCode(tecla);
	    return patron.test(tecla_final);
	}

	function caracteres_especiales_fecha(e) {
		return false;
	}

	function listadoHistorialPausaCaso(cas_id = null){
		let dataHistorialPausa = $('#listado_pausa_caso').DataTable();

		dataHistorialPausa.destroy();

		let data = new Object();
		data.cas_id = cas_id;

		dataHistorialPausa =	$('#listado_pausa_caso').DataTable({
			"language"	: { "url": "<?php echo e(route('index')); ?>/js/dataTables.spanish.json"},
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { 
				"url" :	"<?php echo e(route('listar.pausar.caso')); ?>",  
				"data": data 
			},
			"columnDefs": [ 
				{
					"width":      "25%",
					"targets": 		0,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"width":      "20%",
					"targets": 		1,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"width":      "15%",
					"targets": 		2,
					"className": 	'dt-head-center dt-body-center',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("vertical-align", "middle");
				        $(td).css("word-break", "break-word");
				     
				    }
				},
				{
					"width":      "40%",
					"targets": 		3,
					"className": 	'dt-head-center dt-body-left',
					"createdCell": function (td, cellData, rowData, row, col) {
				        $(td).css("word-break", "break-word");
				     
				    }
				}
			],
			"columns"	: [
				{
					"data": "fec_ing"
				},
				{
					"data": "nombre"
				},
				{
					"data": "estado",
					"render": function(data, type, row, dataIndex){
						if (data == 1){
							return "Iniciado";
						}else{
							return "Pausado";

						}
					}
				},
				{
					"data": "comentario"
				}
			]
		});

		$('#listado_pausa_caso').find("thead th").removeClass("sorting_asc");
	}

</script>