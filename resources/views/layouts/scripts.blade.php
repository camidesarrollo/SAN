<script type="text/javascript" src="{{asset('/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/moment-with-locales.min.js')}}"></script>
{{-- libreria calendario para bootstrap 4 --}}
<script type="text/javascript" src="{{asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/main.js')}}?v={{ date("YmdHis") }}" ></script>
<script type="text/javascript" src="{{asset('/js/dataTables.fixedHeader.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.rowsGroup.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.rowGroup.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap.bundle.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.rut.chileno.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/navegador.class.js')}}"></script>


<script type="text/javascript" src="{{asset('/js/toastr.min.js')}}"></script>

<script type="text/javascript" src="{{asset('/js/sum().js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.blockUI.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/data.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/exporting.js')}}"></script>

<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>


{{-- fullcalendar.io --}}
<script src="{{asset('/js/fullcalendar-4.3.1/packages/core/main.min.js')}}"></script>
<script src="{{asset('/js/fullcalendar-4.3.1/packages/daygrid/main.min.js')}}"></script>
<script src="{{asset('/js/fullcalendar-4.3.1/packages/interaction/main.min.js')}}"></script>
<script src="{{asset('/js/fullcalendar-4.3.1/packages/timegrid/main.min.js')}}"></script>




<script type="text/javascript">
//CZ SPRINT 74 -->
	function showNotification() {
		let idNotificacion = new Array();
		$.ajax({
			url: "{{ route('data.notificacionAsignacionToastr') }}",
			type: "GET",
		}).done(function(resp){
			console.log("/**************************OBTENIENDO NOTIFICACIONES**********************************************/")
			console.log(resp);
			var html = "";	
			for(var i = 0; i<resp.length; i++){
				idNotificacion.push(resp[i].id_notificacion);
				mensaje = resp[i].descripcion;
				tituloNotificacion = 'Nueva asignaci??n';
				toastr.info(mensaje, tituloNotificacion);	
			}
			// if(resp.length > 0){
			// 	// console.log("realizar cambio");
			// 	cambiarEstadoNotificacion(idNotificacion);
			// }
		}).fail(function(obj){
			console.log("Error notificaciones del toastr");
		});
	}

	//FUNCION PARA OBTENER LOS DATOS DE NOTIFICACION CASO Y TERAPIA 
	function datosTablaCaso(){
		
		let tablaHistoria = $('#historial_CasoAsignado').DataTable();

		tablaHistoria.clear().destroy(); 

		tablaHistoria =	$('#historial_CasoAsignado').DataTable({
				"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
				"paging"    : true,
				"ordering"  : false,
				"searching" : false,
				"info"		: false,
				"bLengthChange" : false,
				"pageLength": 5,
				"iDisplayLength": 5,
				"ajax"		: {
		            "url" :	"{{ route('data.notificacionAsignacionTabla') }}",
					"error": function (xhr, error, code)
            		{
						console.log(xhr);
						console.log(code);
            		}
			    },
			    "columnDefs": [ 
					{
						"targets": 		0,
						"className": 	'dt-head-center dt-body-center',
						"createdCell": function (td, cellData, rowData, row, col) {
					        $(td).css("vertical-align", "middle");
					        $(td).css("word-break", "break-word");
					     
					    }
					},
				],
				"columns"	: [
					{
						"data": 		"titulo",
					 	"name": 		"titulo",
						"render" : function (data, type, full, meta){
							let date = new Date(full.fecha);

							let day = date.getDate()
							let month = date.getMonth() + 1
							let year = date.getFullYear()

							if(month < 10){
								var fecha = `${day}-0${month}-${year}`;
							}else{
								var fecha =`${day}-${month}-${year}`;
							}
							var html = "";
							mensaje = full.descripcion;
							var urlCaso = "{{ route('coordinador.caso.ficha') }}/"+full.per_run+"/"+full.id;
							tituloNotificacion = 'Nueva asignaci??n';
							html+=`<h4 style="color: #777; font-size: 16px; margin-top: 3px;">${tituloNotificacion}</h4>`;
							html+=`<div class='notifications-item col-12' onclick="cambiarEstadoNotificacion(${full.id_notificacion}, '${urlCaso}');"   style='cursor: pointer;'>`; 
								html+=`<div class="text col-3">`;
								html+=`<p>${fecha}</p>`;
								html+=`</div>`;
								html+=`<div class="text col-9">`;
								html+=`<p>${mensaje}</p>`;
								html+=`</div>`;	
							html+=`</div>`;
							return html;	
						}
					}
				],
			});
			$('#historial_CasoAsignado').find("thead th").removeClass("sorting_asc");
			$(".dataTables_length").css("display", "none")
			
			// $('#formBitacoraTerapia').modal('show');
	}

	//FUNCION PARA CAMBIAR EL ESTADO DE LA NOTIFICACION 
	function cambiarEstadoNotificacion(idNotificacion, urlCaso = null){
		if(idNotificacion != 0){
			let data = Object();
			data.notificacion = idNotificacion;
			console.log("imprimir data: ");
			console.log(data);
			$.ajax({
				type: "GET",
				url: "{{route('cambiarEstadoNotificacion')}}",
				data: data
				}).done(function(resp){
					console.log(resp);
					if(urlCaso != null){
						bloquearPantalla();
						irCaso(urlCaso);
					}
				}).fail(function(objeto, tipoError, errorHttp){
					desbloquearPantalla();
					manejoPeticionesFailAjax(objeto, tipoError, errorHttp);
					return false;
			});
		}else{
			if(urlCaso != null){
				bloquearPantalla();
				irCaso(urlCaso);
			}
		}

	}

	//CZ SPRINT 74 -->
	$(document).ready(function () {
		@if(Session::get('perfil') == config('constantes.perfil_gestor') || Session::get('perfil') == config('constantes.perfil_terapeuta'))
		@if(Session::get('nowlogin') == true)
			console.log("/**********USUARIO LOGEADO*****************/");
		showNotification();
			<?php
				session()->put('nowlogin',false);
			?>
	@endif
		@endif
        Highcharts.setOptions({
            colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            lang: {
                contextButtonTitle: "Opciones",
                viewFullscreen: "Ver en Pantalla Completa",
                downloadJPEG: "Descargar como imagen JPEG",
                downloadPDF: "Descargar como documento PDF",
                downloadPNG: "Descargar como imagen PNG",
                downloadSVG: "Descargar como vector de imagen SVG",
                printChart: "Imprimir Gr??fico"
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
				 url: "{{ route('casos.busquedaInteractiva') }}"+"/"+$("#nna_busqueda").val(),
				 type: "GET"
			 }).done(function(resp){
			 	var contenido_nna = "";
				var urlResumenNNA = $("#ruta_resumenNNA").val();

			 	if (resp.error=="1"){
			 		contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN incorrecto</div>";
					toastr.warning(contenido_nna);
			 	}else{
				 	if (resp.run_correcto=="0"){
				 		contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN incorrecto</div>";
						toastr.warning(contenido_nna);
				 	}else{
				 		if (resp.coincidencia=="1"){
							urlResumenNNA+='/'+resp.run;
							var botonFichaCompleta = '<a class="btn btn-primary" href="'+urlResumenNNA+'"><span class="align-middle"><font size="2px">Resumen NNA</font></span></a>';
							contenido_nna = "<div class='estilo_div_busqueda_dinamica'>RUN: " + resp.nna_run_con_formato + "  "+botonFichaCompleta+"</div>";
							console.log(contenido_nna);
							toastr.success(contenido_nna);
				 		}else{
				 			contenido_nna = "<div class='estilo_div_busqueda_dinamica'>No existen registros en SAN para el RUT Indicado</div>";
							toastr.error(contenido_nna);
				 		}
				 	}		 		
			 	}
			 })
			 .fail(function(obj){
				toastr.info("Ocurri?? un error inesperado, intente nuevamente.");
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

	    //gui??n, siempre lo permite
	    if (tecla == 45) {
	        return true;
	    }

	    //punto, siempre lo permite
	    if (tecla == 46) {
	        return true;
	    }


	    // Patron de entrada, en este caso solo acepta numeros y letras
	    patron = /[A-Za-z0-9,??,??,???????????????????? ]/;
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
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
			"paging"    : false,
			"ordering"  : false,
			"searching" : false,
			"info"		: false,
			"ajax"		: { 
				"url" :	"{{ route('listar.pausar.caso') }}",  
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