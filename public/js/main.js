//Carga numero de Notificaciones.
$(document).ready(function() {
    cargarNotificaciones(1);

	//SE CREACION LOCALSTORAGE PARA VALIDACION MENU LATERAL

	var estadoMenu = localStorage.getItem('Numero');

	if(estadoMenu==1) {
    		$(".est_men_izq").addClass("active");
    		//document.cookie = "estadoMenu=1";
    		localStorage.setItem("Numero", 1);
   	}else { 
    		$(".est_men_izq").removeClass("active");
    		//document.cookie = "estadoMenu=0";
   			localStorage.setItem("Numero", 0);
   	}

	$('#sidebarCollapse').on('click', function () {
			$('#sidebar').toggleClass('active');
	});
	
	$.fn.dataTable.ext.errMode = 'none';
});
$(function() {

  $('.no-cerrar').on('click', function(event) {
    $('#contenedor-notificaciones').slideToggle();
    event.stopPropagation();
  });
  
});

$('.wrapper').click(function(event){
  // check if the clicked element is a descendent of navigation 
  $("#contenedor-notificaciones").slideUp("fast");
});

window.setInterval("cargarNotificaciones(1)", 100000);

/*

id      : #id del modal
titulo  : titulo del modal
url     : url que se cargará con ajax en el body del modal
fnc     : funcion JS que se ejecutará cuando termine de cargar el ajax anterior
btn     : 1 -> boton aceptar (cierra modal) 2 -> botones cancelar y guardar, 3  -> botones cancelar y eliminar
btnfnc  : funcion JS que ejecutará el clic del boton guardar
chico   : tamaño del showmodal 0-> normal , 1 -> chico
*/
function showModalzAjax(url, titulo, fnc, chico, datos) {
	
	let id = "#zModal";
	chico = chico || 0;
	datos = datos || {};

	var blockear_mod ="";

	blockear_mod = $('#blockear_mod').val();

	if(blockear_mod!=""){
		$('#zModal').modal({backdrop: 'static', keyboard: false});
	}

	$(id + ' .modal-dialog').addClass('modal-lg');
	if (chico) {
		$(id + ' .modal-dialog').removeClass('modal-lg');
		$(id + ' .modal-dialog').addClass('modal-sm');
	}
	
	$.ajax({
		url: url,
		cache: false,
		data: datos
	}).done(function( html ) {
		$(id).modal('show');
		$(id + ' .modal-content').html(html);
		if (titulo !== '') $(id + ' .modal-title').html(titulo);
		
		if (fnc!=="") {
			eval(fnc);
		}
	}).fail(function(obj) {
		let resp = JSON.parse(obj.responseText)
		//let errores = resp.errors

		if (resp.mensaje){
			$('#msjInfo').empty();
			$('#msjInfo').html(resp.mensaje);
			$('#modalMsj').modal('show');
		}
		else
		{
			$(id + ' .modal-footer').hide();
			$(id + ' .modal-header .close').hide();
			$(id).modal('hide');

			$('#msjInfo').empty();
			$('#msjInfo').html('Ocurrio un Error Inesperado');
			$('#modalMsj').modal('show');
		}
	});
}

function enviaFormSerialize(frm,div,fnc, fnc2)
{

	$(div).hide();
	let datos = false;
	if (window.FormData){
		datos = new FormData($('form')[0]);
	}
	
	let funciones = [enviaFormSerializeOk]
	if (fnc!='') {
		funciones = [enviaFormSerializeOk, eval(fnc)]
	}
	
	$.ajax({
		cache: false,
		processData: false,
		contentType: false,
		type: "POST",
		url: $(frm).attr('action'),
		data: datos ? datos : $(frm).serialize(),
		dataType:'json',
		//success: [enviaFormSerializeOk,eval(fnc)],
		success: funciones,
		error: function(obj) {
		console.log(obj)
			let resp = JSON.parse(obj.responseText)
			let errores = resp.errors

			if (resp.errors) {
				let txt = "<ul>"
				for (x in errores) {
					for (y in errores[x]) {
						txt += '<li>' + errores[x][y] + '</i>'
						console.log(errores[x][y])
					}
				}
				txt += "</ul>"

				$('#msjInfo').empty();
				$('#msjInfo').html(txt);
				$('#modalMsj').modal('show');
			} else {
				if (resp.mensaje) {
					$('#msjInfo').empty();
					$('#msjInfo').html(resp.mensaje);
					$('#modalMsj').modal('show');
				}
				else {
					$('#msjInfo').empty();
					$('#msjInfo').html('Ocurrio un Error Inesperado');
					$('#modalMsj').modal('show');
				}
			}
		}
	});
}

function enviaFormSerializeOk(obj){
	//console.log('hola2 enviaFormSerializeOk')
	if (obj.estado == '1') {
		$('#msjInfo').empty();
		$('#msjInfo').html(obj.mensaje);
		$('#modalMsj').modal('show');

		if(obj.datatable){
			$(obj.datatable).DataTable().ajax.reload();
		}
		//console.log('hola')
		/*if (fnc!=="") {
			//funcion =
			//eval(fnc+'('+obj+')');
			console.log('hola2')
			/!*respuesta = JSON.stringify(obj.data);
			console.log(respuesta)
			console.log(JSON.parse(respuesta))
			eval(fnc + "(" + obj.data + ")");*!/
		}*/
	}/* else {
		if (fnc2!=="") {
			eval(fnc2 + "('" + obj.mensaje + "')");
		}
	}*/
}

function enviaFormJson(frm,div,fnc, fnc2)
{

	$(div).hide();

	$.ajax({
		type: "POST",
		url: $(frm).attr('action'),
		data: $(frm).serialize(),
		dataType:'json',
		success: function(obj)
		{
			$(div).show();
			$(div).html(obj.mensaje); //
			$(div).addClass('alert-danger');

			if (obj.estado == '1') {
				$(div).removeClass('alert-danger');
				$(div).addClass('alert-success');
				eval(fnc);
			}
			else {
				eval(fnc2 + "('" + obj.mensaje + "')" );
			}
		}
	});
}

/*

id      : #id del modal
titulo  : titulo del modal
url     : url que se cargará con ajax en el body del modal
fnc     : funcion JS que se ejecutará cuando termine de cargar el ajax anterior
btn     : 1 -> boton aceptar (cierra modal) 2 -> botones cancelar y guardar, 3  -> botones cancelar y eliminar
btnfnc  : funcion JS que ejecutará el clic del boton guardar
chico   : tamaño del showmodal 0-> normal , 1 -> chico
*/
function showModalAjax(id, titulo, url, fnc , btn, btnfnc, chico) {
    chico = chico || 0;

    $(id + ' .modal-dialog').addClass('modal-lg');
    if (chico) {
        $(id + ' .modal-dialog').removeClass('modal-lg');
        $(id + ' .modal-dialog').addClass('modal-sm');
    }

    $(id + ' .modal-footer').show();
    $(id + ' .modal-header .close').show();

    if (titulo != '')
        $(id + ' .modal-title').html(titulo);
    
    $(id + ' .modal-body').html('Cargando, espere por favor...');
    $(id + ' .modal-footer').html('');

    if (btn == 1) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-primary" data-dismiss="modal" id="IDaceptar" >Aceptar</button>');
    }
    if (btn == 2) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="btnGuardarModal" class="btn btn-primary" onclick="' + btnfnc + '">Guardar</button>');
    }
    if (btn == 22) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="btnGuardarModal2" class="btn btn-primary" onclick="' + btnfnc + '">Guardar</button>');
    }    
    if (btn == 3) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary" onclick="' + btnfnc + '">Eliminar</button>');
    }
    if (btn == 4) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary" onclick="' + btnfnc + '">Aceptar</button>');
    }
    if (btn == 5) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><input  type="submit" class="btn btn-primary" data-loading-text="Guardando..." id="btnAceptar" value="Guardar">');
    }
    if (btn == 6) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="btnGuardarModal" class="btn btn-primary" onclick="' + btnfnc + '">Deshabilitar</button>');
    }   
    if (btn == 7) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="btnGuardarModal" class="btn btn-primary" onclick="' + btnfnc + '">Habilitar</button>');
    }               
    if (btn == 222) {
        $(id + ' .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="btnGuardarModal" class="btn btn-primary" onclick="' + btnfnc + '">Publicar</button>');
    }     
    $(id).modal('show');

    $.ajax({
        url: url,
        cache: false
    }).done(function( html ) {

        $(id + ' .modal-content').html( html );

        eval(fnc);
    });
}



function enviaFormModal(frm,div,fnc, fnc2) {

	$(div).hide();

	$.ajax({
		type: "POST",
		url: $(frm).attr('action'),
		data: $(frm).serialize(),
		dataType:'json',
		success: function(obj)
		{
			$(div).show();
			$(div).html(obj.msg); //
			$(div).addClass('alert-danger');

			if (obj.estado == '1') {
				$(div).removeClass('alert-danger');
				$(div).addClass('alert-success');
				eval(fnc);
			}
			else {
				eval(fnc2 + "('" + obj.msg + "')" );
			}
		}
	});
}

function btnGuardando(btn){
	
	$(btn).text('Guardando...');
	$(btn).attr('disabled',1);
	
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    esnum = !(charCode > 31 && (charCode < 48 || charCode > 57));

    if (!esnum) {
        if (charCode === 75 || charCode === 107)
            return  true;
    }

    return esnum;
}

function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { 
        //modalMsj("<p>RUT Incompleto</p>");
        return false;
    }
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { 
        //modalMsj("<p>RUT inválido</p>");
        return false;
    }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

function Valida_Rut( Objeto )
{
    var tmpstr = "";
    var intlargo = Objeto.value
    if (intlargo.length> 0)
    {
        crut = Objeto.value
        largo = crut.length;
        if ( largo <2 )
        {
            //modalMsj("<p>rut inválido</p>");
            Objeto.focus()
            return false;
        }
        for ( i=0; i <crut.length ; i++ )
        if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' )
        {
            tmpstr = tmpstr + crut.charAt(i);
        }
        rut = tmpstr;
        crut=tmpstr;
        largo = crut.length;
 
        if ( largo> 2 )
            rut = crut.substring(0, largo - 1);
        else
            rut = crut.charAt(0);
 
        dv = crut.charAt(largo-1);
 
        if ( rut == null || dv == null )
        return 0;
 
        var dvr = '0';
        suma = 0;
        mul  = 2;
 
        for (i= rut.length-1 ; i>= 0; i--)
        {
            suma = suma + rut.charAt(i) * mul;
            if (mul == 7)
                mul = 2;
            else
                mul++;
        }
 
        res = suma % 11;
        if (res==1)
            dvr = 'k';
        else if (res==0)
            dvr = '0';
        else
        {
            dvi = 11-res;
            dvr = dvi + "";
        }
 
        if ( dvr != dv.toLowerCase() )
        {
            modalMsj("<p>El Rut Ingreso es Invalido</p>");
            Objeto.focus()
            return false;
        }
        
        Objeto.focus()
        return true;
    }
}

function modalMsj(mensaje) {
    $('#msjInfo').empty();
    $('#msjInfo').html(mensaje);
    $('#modalMsj').modal('show');
}

function rutEsValido(rut) {

	rut = rut.toLowerCase();
	//console.log("asdasdas");
	//console.log(typeof rut);
	if(typeof rut === 'number'){
		rut = rut.toString();
		//console.log(rut);
	}
	if (!rut || rut.trim().length < 3) return false;
	const rutLimpio = rut.replace(/[^0-9kK-]/g, "");

	if (rutLimpio.length < 3) return false;

	const split = rutLimpio.split("-");
	if (split.length !== 2) return false;

	const num = parseInt(split[0], 10);
	const dgv = split[1];

	const dvCalc = calculateDV(num);
	return dvCalc === dgv;
}

function calculateDV(rut) {
	const cuerpo = `${rut}`;
	// Calcular Dígito Verificador
	let suma = 0;
	let multiplo = 2;

	// Para cada dígito del Cuerpo
	for (let i = 1; i <= cuerpo.length; i++) {
		// Obtener su Producto con el Múltiplo Correspondiente
		const index = multiplo * cuerpo.charAt(cuerpo.length - i);

		// Sumar al Contador General
		suma += index;

		// Consolidar Múltiplo dentro del rango [2,7]
		if (multiplo < 7) {
			multiplo += 1;
		} else {
			multiplo = 2;
		}
	}

	// Calcular Dígito Verificador en base al Módulo 11
	const dvEsperado = 11 - (suma % 11);
	if (dvEsperado === 10) return "k";
	if (dvEsperado === 11) return "0";
	return `${dvEsperado}`;
}
function ponerMayuscula(str){
	let respuesta = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});
	return respuesta;
}

function completarVistaRapida(_this){
	console.log("entra aca");
	let url = $(_this).attr("data-ficha-rapida");

	if (url != "" && url != null){
		$.getJSON(url, function( data ){
			if (data.estado == 1){
				ultimosBeneficiosSociales(data.respuesta.datos_basicos.run);
				posiblesBeneficiosSociales(data.respuesta.datos_basicos.run);
				historicoBeneficiosSociales(data.respuesta.datos_basicos.run);

				let direccion = data.respuesta.datos_basicos.dir_calle_1+" #"+data.respuesta.datos_basicos.dir_num_1;
				let url_rsh = $("#vr_url_rsh").val();

				/*if (data.respuesta.datos_basicos.dir_dep != "" && data.respuesta.datos_basicos.dir_dep != null){
					direccion += ", Depto/Casa "+data.respuesta.datos_basicos.dir_dep;
				}*/

				$("#vr_nombre").text(data.respuesta.datos_basicos.nombre);
				$("#vr_run").text(data.respuesta.datos_basicos.rut);
				$("#vr_edad").text(data.respuesta.datos_basicos.edad_ani+" Años");
				$("#vr_direccion").text("Dirección: "+direccion);
				$("#vr_comuna").text("Comuna: "+data.respuesta.datos_basicos.dir_com_nom_1);
				//$("#vr_provincia").text("Provincia: "+data.respuesta.datos_basicos.pro_nom);
				//$("#vr_region").text("Región: "+data.respuesta.datos_basicos.reg_nom);
				$("#vr_rsh").attr("onclick", "window.open('"+url_rsh+"/"+data.respuesta.datos_basicos.run+"');");
				$("#vr_ultimos_beneficios").attr("data-run", data.respuesta.datos_basicos.run);

			}else{
				console.log(obj);
				alert("Error al momento de visualizar vista rápida de ficha. Por favor intente nuevamente.");
			}
		});
	}else{
		console.log(obj);
		alert("Error al momento de visualizar vista rápida de ficha. Por favor intente nuevamente.");
	}
}

function ultimosBeneficiosSociales(run){
	let url = $("#ultimos_beneficios_sociales").attr("data-ultimos-beneficios-href");
	
	$.getJSON(+url+'/'+run, function( data ){
		if (data.EstadoConsulta == 1){
			if (data.Estado == 1){
				$.each(data.beneficios, function( index, value ) {
					let html = '';
					html = '<li class="list-group-item" style="border: none;"><span class="oi oi-check" style="color: #00a1b9; margin-right: 8px;"></span>'+value.nombre_programa+'</li>';

					$('#ultimos_beneficios_sociales').html(html);
				});
			}else{
				let html = '';
				html = '<li class="list-group-item" style="border: none;"><span class="oi oi-x" style="color: #dc3545; margin-right: 8px;"></span>La persona consultada no tiene beneficios registrados.</li>';

				$('#ultimos_beneficios_sociales').html(html);
			}
		}else{
			let html = '';
			html = '<li class="list-group-item" style="border: none;"><span class="oi oi-x" style="color: #dc3545; margin-right: 8px;"></span>'+data.Mensaje+'</li>';

			$('#ultimos_beneficios_sociales').html(html);
		}
	});
}

function historicoBeneficiosSociales(run){
	let url = $("#historico_beneficios_sociales").attr("data-historico-beneficios-href");

	$.getJSON(url+'/'+run, function( data ){
		if (data.EstadoConsulta == 1){
			if (data.Estado == 1){
				$.each(data.beneficios, function( index, value ) {
					let html = '';
					html = '<li class="list-group-item" style="border: none;"><span class="oi oi-check" style="color: #00a1b9; margin-right: 8px;"></span>'+value.nombre_programa+'</li>';

					$('#historico_beneficios_sociales').html(html);
				});
			}else{
				let html = '';
				html = '<li class="list-group-item" style="border: none;"><span class="oi oi-x" style="color: #dc3545; margin-right: 8px;"></span>La persona consultada no tiene histórico de beneficios.</li>';

				$('#historico_beneficios_sociales').html(html);
			}
		}else{
			let html = '';
			html = '<li class="list-group-item" style="border: none;"><span class="oi oi-x" style="color: #dc3545; margin-right: 8px;"></span>'+data.Mensaje+'</li>';

			$('#historico_beneficios_sociales').html(html);
		}
	});
}


/**
 * Función que retorna RUN formateado con separador de miles y guion
 *
 * @param RUN sin formato
 * @returns Run con puntos y guion
 */
function formatearRun(value, useThousandsSeparator = "-"){
	let respuesta = "";

	let rutAndDv = dividirRut(value);
	let cRut = rutAndDv[0];
	let cDv = rutAndDv[1];

	if(!(cRut && cDv)) { return cRut || value; }

	let rutF = "";
	let thousandsSeparator = useThousandsSeparator ? "." : "";

	while (cRut.length > 3) {
		rutF = thousandsSeparator + cRut.substr(cRut.length - 3) + rutF;
		cRut = cRut.substring(0, cRut.length - 3);
	}

	respuesta = cRut + rutF + "-" + cDv;
	return respuesta;
}

function dividirRut(rut) {
	let cValue = limpiarFormatoRun(rut);

	if(cValue.length === 0) { return [null, null]; }
	if(cValue.length === 1) { return [cValue, null]; }

	let cDv = cValue.charAt(cValue.length - 1);
	let cRut = cValue.substring(0, cValue.length - 1);

	return [cRut, cDv];
}

function limpiarFormatoRun(value) {
	return value.replace(/[\.\-]/g, "");
}


/**
 * Función que retorna digito verificador de un RUN
 *
 * @param RUN sin digito verificador
 * @returns Digito verificador
 */
function obtenerDv(run){
	let respuesta = "";

	if (typeof run != "undefined" && run != "" && run != null){
		let M=0;
		let S=1;

		for (;run; run = Math.floor(run/10)){
			S = (S + run % 10 * (9 - M++ %6)) % 11;
		}

		if (S <= 0){
			respuesta = 'k'

		}else if (S => 1){
			respuesta = S-1;

		}
	}

	return respuesta;
}


/**
 * Función que retorna html con icono y cantidad de alertas de un NNA para ser listado en un DataTable
 *
 * @param Cantidad de alertas
 * @returns HTML
 */
function listarIconoAlerta(alertas){
	let respuesta = "";

	if (typeof alertas != "undefined" && alertas != "" && alertas != null){
		if (alertas == 0){
			respuesta = '<b style="font-size: 14px;">'+alertas+'</b>';

		}else{
			// respuesta = '<img src="/img/ico-alertas.svg" width="29px" height="29px" /><b style="font-size: 14px;"> '+alertas+'</b>';
			respuesta = '<b style="font-size: 14px;"> '+alertas+'</b>';
			
		}
	}else{
		respuesta = '<b style="font-size: 14px;">0</b>';
	}

	return respuesta;
}


/**
 * Función que retorna html con color correpondiente del score según puntuación para ser listado en un DataTable
 *
 * @param score
 * @returns HTML
 */
function aplicarColor(score){
    let respuesta = '';

	if (typeof score != "undefined" && score != "" && score != null){
		let claseCss  = '';

		if (score >= 0 && score <= 20){			claseCss	= "alarmaUno";		}
		else if (score >= 21 && score <= 40){	claseCss	= "alarmaDos";		}
		else if (score >= 41 && score <= 60){	claseCss	= "alarmaTres";		}
		else if (score >= 61 && score <= 80){	claseCss	= "alarmaCuatro";	}
		else if (score >= 81 && score <= 100){	claseCss	= "alarmaCinco";	}

		respuesta = '<div class="circulo '+claseCss+'">'+score+'</div>';
	}

	return respuesta;
}

function guardarFechaPreDiagnostico(caso, tipo, valor){
	let url = $("#url_guardar_fecha_prediagnostico").val();
	let data = new Object();
    data.caso_id = caso;
    data.tipo = tipo;
	data.valor = valor;
	
    toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "0",
            "hideDuration": "0",
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

	$.ajax({
			url: url,
			type: "GET",
			data: data
		}).done(function(resp){
			toastr.success('Información almacenada satisfactoriamente');
		}).fail(function(obj){
			toastr.error('Ocurrió un error al guardar la información');
			console.log(obj);
		});
}

function guardarObsPreDiagnostico(caso, tipo, valor){
	let url = $("#url_guardar_obs_prediagnostico").val();
	let data = new Object();
    data.caso_id = caso;
    data.tipo = tipo;
	data.valor = valor;

    toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "0",
            "hideDuration": "0",
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


	$.ajax({
			url: url,
			type: "GET",
			data: data
		}).done(function(resp){
			toastr.success('Información almacenada satisfactoriamente');
		}).fail(function(obj){
			toastr.error('Ocurrió un error al guardar la información');
			console.log(obj);
		});
}

function cambioBitacoraTerapia(option, tera_id, comentario){
	limpiarModalMsgEstadosTerapia();

	let url = $('#url_cambiar_bitacora_terapia').val();
	let data = new Object();
    data.option = option;
    data.tera_id = tera_id;
	data.comentario = comentario;


	$.ajax({
		url: url,
		type: "GET",
		data: data
	}).done(function(resp){
		let html= resp.mensaje;

		$("#cambiar_estado").hide();
		$("#contenedor_comentario_estado").hide();
		$("#contenedor_rechazo_estado_persona").hide();

		$("#msg_cambioEstado_body").html(html);
		$("#msg_cambioEstado_body").show();
		$('#msgCambioEstadoTerapia').modal('show');

	}).fail(function(obj){
		let html = "Error al momento de realizar la actualización de bitácora de terapia. Por favor intente nuevamente.";

		console.log(obj);

		$("#cambiar_estado").hide();
		$("#contenedor_comentario_estado").hide();
		$("#contenedor_rechazo_estado_persona").hide();

		$("#msg_cambioEstado_body").html(html);
		$("#msg_cambioEstado_body").show();
		$('#msgCambioEstadoTerapia').modal('show');

	});

}

function cambioEstadoCaso(option, caso, comentario){
	limpiarModalMsgEstados();
	bloquearPantalla();
	 let egreso = $("#est_egre_cons").val();
	let url = $("#url_finalizar_caso").val();
	let data = new Object();
    data.option = option;
    data.caso_id = caso;
	data.comentario = comentario;

	$.ajax({
		url: url,
		type: "GET",
		data: data
	}).done(function(resp){
		let html= resp.mensaje;
		desbloquearPantalla();
		if (resp.estado == 1){
			if (option == 1 || option == 2 || option == 8 || option == 9 || option == 20 || option == 21 || option == 22 || 
			option == 23 || option == 24 || option == 25 || option == 26  || option == 27 || option == 28 || option == 29 || option == 30){ //Rechazado x familia o gestor
			
				$(".btnEtapa").attr("disabled", "true");
				$(".btnRechEst").attr("disabled", "true");
				$(".txtAreEtapa").attr("disabled", "true");

			}else if (option == 12){ //Egreso
				$("#btn-etapa-egreso").attr("disabled", "true");

			}

			$("#cambiar_estado").hide();
			$("#contenedor_comentario_estado").hide();
			$("#contenedor_rechazo_estado_persona").hide();

			$("#msg_cambioEstado_body").html(html);
			$("#msg_cambioEstado_body").show();
			$('#msgCambioEstado').modal('show');
	// 		//INICIO DC
			obtienePlazo();
	// 		//FIN DC
			//obtenerNotificacionesTiempo();
			// INICIO CZ SPRINT 74
			
			obtenerCantidadNotificacion();
			// CZ SPRINT 74
		}
	}).fail(function(obj){
		let html = "Error al momento de realizar la actualización del estado del caso. Por favor intente nuevamente.";
		desbloquearPantalla();
		console.log(obj);
		$("#cambiar_estado").hide();
		$("#contenedor_comentario_estado").hide();
		$("#contenedor_rechazo_estado_persona").hide();

		$("#msg_cambioEstado_body").html(html);
		$("#msg_cambioEstado_body").show();
		$('#msgCambioEstado').modal('show');
	});
}
// CZ SPRINT 74
function obtenerCantidadNotificacion(){

	var url = $("#url_cantidad_notificacion").val();
	console.log(url);
	$.ajax({
	url:url,
	type: "GET",
	}).done(function(resp){
		console.log(resp);
		$("#circle").html(resp);
	}).fail(function(obj){
		console.log("Error obtener la cantidad de las notificaciones ");
	});
}

function obtenerNotificacionesTiempo(){
	let tablaHistoria = $('#table_id').DataTable();
	var url = $("#url_tabla_notificacion_Intervencion").val();
	var urlSpanish = $("#url_dataTables_spanish").val();
	var url_caso = $("#url_caso").val();
	console.log(urlSpanish);
		tablaHistoria.clear().destroy(); 

		tablaHistoria =	$('#table_id').DataTable({
				"language"	: urlSpanish,
				"paging"    : true,
				"ordering"  : false,
				"searching" : false,
				"info"		: false,
				"bLengthChange" : false,
				"pageLength": 5,
				"iDisplayLength": 5,
				"ajax"		: {
		            "url" :	url,
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
						"data": 		"tituloNotificacion",
					 	"name": 		"tituloNotificacion",
						"render" : function (data, type, full, meta){
							var html = "";
							var urlCaso = url_caso+"/"+full.run+"/"+full.caso;
							tituloNotificacion = 'Nueva asignación';
							html+=`<h4 style="color: #777; font-size: 16px; margin-top: 3px;">${data}</h4>`;
							html+=`<div class='notifications-item' onclick="cambiarEstadoNotificacion('0', '${urlCaso}');"   style='cursor: pointer;'>`; 
							html+=`<div class="text">`;
							html+=`<p>${full.mensaje}</p>`;
							html+=`</div>`;	
							html+=`</div>`;
							return html;	
						}
					}
				],
			});
}
// CZ SPRINT 74
function comentarioEstado(caso){
	limpiarModalMsgEstados();

	if (typeof caso == "undefined" || caso == "") return false;

	//$("#cambiar_estado").attr("data-opc", option);
	$("#cambiar_estado").attr("data-cas-id", caso);
    $("#msg_cambioEstado_body").hide();

	$('#msgCambioEstado').modal('show');
}

function validarComentarioModalEstado(){

   let comentario = $("#comentario_estado").val().trim();
   let opcion    = $("#rechazo_estado_persona").val();
   let validacion = true;

   //Validación caja de comentario
   if (comentario === "" || comentario.length < 3 || typeof comentario == "undefined"){
   	   $("#val_msg_com").show();
   	   $("#comentario_estado").addClass("is-invalid");
       validacion = false;
   }else{
	   $("#val_msg_com").hide();
	   $("#comentario_estado").removeClass("is-invalid");
   }

   //Validación rechazado por
	if (typeof opcion == "undefined" || opcion == ""){
		$("#val_msg_rec").show();
		$("#rechazo_estado_persona").addClass("is-invalid");
		validacion = false;
	}else{
		$("#val_msg_rec").hide();
		$("#rechazo_estado_persona").removeClass("is-invalid");
	}

   if (validacion == false) return false;

   let confirmacion = confirm("¿ Esta seguro que desea desestimar el caso ?");
   //let confirmacion = confirm("¿ Esta seguro que desea rechazar el caso ?");
   if (confirmacion == false) return false;
   bloquearPantalla();
   cambioEstadoCaso(opcion, $("#cambiar_estado").attr("data-cas-id"), comentario);
}

function siguienteEtapa(option, caso){
	switch (option){
		case 15: //PreDiagnostico -> Diagnostico
			//alert('vamos desde pre a diagnostico siguiente etapa');
			let val_pre = validacionCambiosDeEstados(option, caso);
			if (val_pre == false){
				toastr.error('Faltaron campos por responder');
				return false;
			} 

			let predignostico = $("#est_diag_cons").val();

			$("[name=bit-etapa-prediagnostico]").attr("disabled", "true");
			$("#btn-etapa-prediagnostico").attr("disabled", "true");
			$("#est_act_cas").val(predignostico);

			$("#diagnostico-tab").removeClass("disable-btn-nav-est");
			$("#diagnostico-tab-ico").removeClass("text-light");
			$("#diagnostico-tab-ico").addClass("text-success");

			$("#diagnostico-tab").attr("onclick", "procesoAtencionCaso("+predignostico+", " + caso + ", false);");

			$('#diagnostico-tab').click();
			$("#diagnostico-tab").focus();
			$("#diagnostico-tab").addClass("active");

			$("#btn-etapa-elaborar").prop("disabled", false);
			$('#btn-etapa-elaborar').removeAttr("disabled");
			$("[name=bit-etapa-diagnostico]").removeAttr("disabled");
		break;

		case 3: //Diagnostico -> Elaborar PAF
		//case 8: //Diagnostico -> Elaborar PAF

			validacionCambiosDeEstados(option, caso).then(function (data){

            	$html='';
    			if (data.respuesta==0){
    				$html="<div class='alert alert-warning' role='alert'>";
    				$html+="<ul>";
					for (var i=0; i<data.mensajes.length; i++) 
					{
						$html+="<li>"+data.mensajes[i]+"</li>";
					}
	    			$html+="</ul>";
	    			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					let elaborar = $("#est_elab_cons").val();

					$("[name=bit-etapa-diagnostico]").attr("disabled", "true");
					$("#btn-etapa-diagnostico").attr("disabled", "true");
					$("#est_act_cas").val(elaborar);

					$("#elaborarPAF-tab").removeClass("disable-btn-nav-est");
					$("#elaborarPAF-tab-ico").removeClass("text-light");
					$("#elaborarPAF-tab-ico").addClass("text-success");

					$("#elaborarPAF-tab").attr("onclick", "procesoAtencionCaso("+elaborar+", " + caso + ", false);");

					$('#elaborarPAF-tab').click();
					$("#elaborarPAF-tab").focus();
					$("#elaborarPAF-tab").addClass("active");

					$("#btn-etapa-elaborar").prop("disabled", false);
					$('#btn-etapa-elaborar').removeAttr("disabled");
					$("[name=bit-etapa-elaborar]").removeAttr("disabled");


					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoCaso(option, caso, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la gestión del caso en la etapa Diagnóstico. Por favor intente nuevamente."); 
      		});
					
			return false;

		break;

		case 4: //Elaborar PAF -> Ejecución PAF
		//case 9: //Elaborar PAF -> Ejecución PAF

			validacionCambiosDeEstados(option, caso).then(function (data){

            	$html='';
    			if (data.respuesta==0){
    				$html="<div class='alert alert-warning' role='alert'>";
    				$html+="<ul>";
					for (var i=0; i<data.mensajes.length; i++) 
					{
						$html+="<li>"+data.mensajes[i]+"</li>";
					}
	    			$html+="</ul>";
	    			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					let ejecucion = $("#est_ejec_cons").val();

					$("[name=bit-etapa-elaborar]").attr("disabled", "true");
					$('#btn-etapa-elaborar').attr("disabled", "true");
					$("#est_act_cas").val(ejecucion);

					$("#ejecucionPAF-tab").removeClass("disable-btn-nav-est");
					$("#ejecucionPAF-tab-ico").removeClass("text-light");
					$("#ejecucionPAF-tab-ico").addClass("text-success");

					$("#ejecucionPAF-tab").attr("onclick", "procesoAtencionCaso("+ejecucion+", " + caso + ", false);");

					$('#ejecucionPAF-tab').click();
					$("#ejecucionPAF-tab").focus();
					$("#ejecucionPAF-tab").addClass("active");

					$("#btn-etapa-ejecucion").prop("disabled", false);
					$('#btn-etapa-ejecucion').removeAttr("disabled");
					$("[name=bit-etapa-ejecucion]").removeAttr("disabled");


					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoCaso(option, caso, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la gestión del caso en la etapa Elaborar Paf. Por favor intente nuevamente."); 
      		});
					
			return false;

		break;

		case 5: //Ejecución PAF -> Cierre PAF
		//case 10: //Ejecución PAF -> Cierre PAF

			validacionCambiosDeEstados(option, caso).then(function (data){
            	$html='';
    			if (data.respuesta==0){
    				$html="<div class='alert alert-warning' role='alert'>";
    				$html+="<ul>";
					for (var i=0; i<data.mensajes.length; i++) 
					{
						$html+="<li>"+data.mensajes[i]+"</li>";
					}
	    			$html+="</ul>";
	    			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					let cierre = $("#est_cier_cons").val();

					$("[name=bit-etapa-ejecucion]").attr("disabled", "true");
					$('#btn-etapa-ejecucion').attr("disabled", "true");
					$("#est_act_cas").val(cierre);

					$("#cierrePAF-tab").removeClass("disable-btn-nav-est");
					$("#cierrePAF-tab-ico").removeClass("text-light");
					$("#cierrePAF-tab-ico").addClass("text-success");

					$("#cierrePAF-tab").attr("onclick", "procesoAtencionCaso("+cierre+", " + caso + ", false);");

					$('#cierrePAF-tab').click();
					$("#cierrePAF-tab").focus();
					$("#cierrePAF-tab").addClass("active");

					$("#btn-etapa-cierre").prop("disabled", false);
					$('#btn-etapa-cierre').removeAttr("disabled");
					$("[name=bit-etapa-cierre]").removeAttr("disabled");

					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoCaso(option, caso, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la gestión del caso en la etapa Elaborar Paf. Por favor intente nuevamente."); 
      		});
					
			return false;

		break;

		case 6: //Cierre PAF -> Seguimiento PAF
		//case 11: //Cierre PAF -> Seguimiento PAF
			
			validacionCambiosDeEstados(option, caso).then(function (data){

            	$html='';
    			if (data.respuesta==0){
    				$html="<div class='alert alert-warning' role='alert'>";
    				$html+="<ul>";
					for (var i=0; i<data.mensajes.length; i++) 
					{
						$html+="<li>"+data.mensajes[i]+"</li>";
					}
	    			$html+="</ul>";
	    			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
					validacionPreguntasSesion();
				}else{

					let seguimiento = $("#est_segu_cons").val();

					$("[name=bit-etapa-cierre]").attr("disabled", "true");
					$('#btn-etapa-cierre').attr("disabled", "true");
					$("#est_act_cas").val(seguimiento);

					$("#seguimientoPAF-tab").removeClass("disable-btn-nav-est");
					$("#seguimientoPAF-tab-ico").removeClass("text-light");
					$("#seguimientoPAF-tab-ico").addClass("text-success");

					$("#seguimientoPAF-tab").attr("onclick", "procesoAtencionCaso("+seguimiento+", " + caso + ", false);");

					$('#seguimientoPAF-tab').click();
					$("#seguimientoPAF-tab").focus();
					$("#seguimientoPAF-tab").addClass("active");

					$("#btn-etapa-egreso").prop("disabled", false);
					$('#btn-etapa-egreso').removeAttr("disabled");
					$("[name=bit-etapa-egreso]").removeAttr("disabled");


					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoCaso(option, caso, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la gestión del caso en la etapa Elaborar Paf. Por favor intente nuevamente."); 
      		});
					
			return false;

		break;

		case 7: //SEGUIMIENTO PAF
			validacionCambiosDeEstados(option, caso).then(function (data){
			
            	$html='';
    			if (data.respuesta==0){
    				$html="<div class='alert alert-warning' role='alert'>";
    				$html+="<ul>";
					for (var i=0; i<data.mensajes.length; i++) 
					{
						$html+="<li>"+data.mensajes[i]+"</li>";
					}
	    			$html+="</ul>";
	    			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					$("#btn_registro_seguimiento").parent().hide();

					$("[name=bit-etapa-seguimiento]").attr("disabled", "true");
					$("#btn-etapa-egreso").prop("disabled", true);
					/** //Inicio cambio para egreso Andres F.  */
					let date = new Date()

					let day = date.getDate()
					let month = date.getMonth() + 1
					let year = date.getFullYear()
					let fechact = '';
					if(month < 10){
						fechact = day+'-0'+month+'-'+year;
					}else{
						fechact = day+'-'+month+'-'+year;
					}

					cambioEstadoCaso(option, caso, "Se egresa caso con fecha "+fechact);
					/** //Fin cambio para egreso Andres F.  */
				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la gestión del caso en la etapa Seguimiento Paf. Por favor intente nuevamente."); 
      		});
					
			return false;

		break;

		case 12: //Egreso PAF
			let run = $("#run").val();

			validarAlertasPendientes(run, caso).then(function (data){
				if (data.validacion_alertas == true){
					let mensaje = "No se puede realizar el egreso del caso mientras existan "+data.cantidad_alertas+" Alertas Territoriales sin gestión. Por favor verifique e intente nuevamente.";

					if (data.cantidad_alertas <= 1) mensaje = "No se puede realizar el egreso del caso mientras exista "+data.cantidad_alertas+" Alerta Territorial sin gestión. Por favor verifique e intente nuevamente.";

					alert(mensaje); return false;
				}else if (data.validacion_alertas == false){
					$("[name=bit-etapa-egreso]").attr("disabled", "true");
					$('#btn-etapa-egreso').attr("disabled", "true");
					$(".btnRechEst").attr("disabled", "true");

					cambioEstadoCaso(option, caso, "");
				}
			}).catch(function (error){
				let mensaje = "Hubo un error al momento de validar la gestión del caso para su egreso. Por favor intente nuevamente.";

				console.log(error);
				alert(mensaje); return false;
			});
		break;
	}

	if (option != 12){
		$('body,html').animate({scrollTop : 0}, 500);
		cambioEstadoCaso(option, caso, "");

	}
}

function validarAlertasPendientes(run, caso){
	let url			= $("#url_validar_alert_pend").val();
	let data 		= new Object();
	data.run = run;
	data.cas_id = caso;

	return new Promise(function (resolve, reject){
		$.ajax({
			'type'		: "GET",
			'dataType'	: "JSON",
			'url'		: url,
			'data'		: data
		}).done(function(resp) {
			resolve(resp);
		}).fail(function(resp){
			reject(resp);
		});
	})
}



function testAjax(handleData) {
  $.ajax({
    url:"getvalue.php",  
    success:function(data) {
      handleData(data); 
    }
  });
}	


function limpiarModalMsgEstados(){
    $("#cambiar_estado").removeAttr("data-cas-id");
	$("#cambiar_estado").show();
	$("#contenedor_comentario_estado").show();
	$("#contenedor_rechazo_estado_persona").show();
	$("#msg_cambioEstado_body").hide();

	$("#val_msg_com").hide();
	$("#comentario_estado").removeClass("is-invalid");
	$("#comentario_estado").val("");

	$("#val_msg_rec").hide();
	$("#rechazo_estado_persona").removeClass("is-invalid");
	document.getElementById("rechazo_estado_persona").value = '';

	$("#cant_carac_cam_est").css("color", "#000000");
	 $("#cant_carac_cam_est").text(0);
}

function primeraLetraMayuscula(texto){
	
	var str = texto;
	var res = str.split(" ");
	var text="";

	for (i = 0; i < res.length; i++) { 
  		text = text +" "+res[i].charAt(0).toUpperCase() + res[i].slice(1) ;
	}

	return text;
}

function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
 }

 function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57) || (key==8))
}

function validarFormatoFecha(fecha) {
	//alert('okokok');
	var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
	if ((fecha.match(RegExPattern)) && (fecha!='')) {
		return true;
	} else {
		return false;
	}
}

function existeFecha(fecha){
	var fechaf = fecha.split("/");
	var day = fechaf[0];
	var month = fechaf[1];
	var year = fechaf[2];
	var date = new Date(year,month,'0');
	if((day-0)>(date.getDate()-0)){
		return false;
	}
	return true;
}

function calcularEdad(fecha) {
	var hoy = new Date();
	var cumpleanos = new Date(fecha);
	var edad = hoy.getFullYear() - cumpleanos.getFullYear();
	var m = hoy.getMonth() - cumpleanos.getMonth();

	if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
		edad--;
	}

	return edad;
}

function cambiarMenu(){
	var cookkie = valueCokkie("estadoMenu");
	var estadoMenu = localStorage.getItem('Numero');

	if(estadoMenu == 0) {
		$(".est_men_izq").removeClass("active");
		//document.cookie = "estadoMenu=1"; 
		localStorage.setItem("Numero", 1);

	}else { 
		$(".est_men_izq").addClass("active");
		//document.cookie = "estadoMenu=0";
		localStorage.setItem("Numero", 0);
	}

}    

function cambiarMenuAntecedentes(antecTabs){

	localStorage.getItem('m_antec');

	if(antecTabs==0) localStorage.setItem("m_antec", 0);

	if(antecTabs==1) localStorage.setItem("m_antec", 1);

	if(antecTabs==2) localStorage.setItem("m_antec", 2);

}

function logout(){

    localStorage.removeItem('Numero');

}

function obtenerInformacionRunificador(run){
	let url = $("#url_runificador").val();
	let data = new Object();
	data.run = run;

	//alert(run);

	return new Promise(function (resolve, reject){
		$.ajax({
			'type'		: "GET",
			'dataType'	: "JSON",
			'url'		: url,
			'data'		: data
		}).done(function(resp) {
			resolve(resp);
		}).fail(function(resp){
			reject(resp);
		});
	})			
}

function hoyFecha(){
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1;
    var yyyy = hoy.getFullYear();
        
    dd = addZero(dd);
    mm = addZero(mm);
 
    //return dd+'/'+mm+'/'+yyyy;

    return hoy.getTime();
}

function addZero(i) {
	if (i < 10) {
	    i = '0' + i;
	 }
    return i;
}

function validacionCambiosDeEstados(option, caso){
	let respuesta = true;
	let caso_id = caso;

	limpiarMensajesValidacionCambiosDeEstados(option);

	switch(option){
		case 3: //Diagnostico - Elaborar PAF
		//case 8: //Diagnostico - Elaborar PAF

			let data_diagnostico = new Object();
    		data_diagnostico.caso_id = caso_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});


			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
						url: "../proceso/atencion/verificarDiagnostico/"+caso_id,
						data: data_diagnostico
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		console.log(obj);
						reject(resp);
					});
				})



		break;

		case 4: //Elaborar PAF - Ejecución PAF
		//case 9: //Elaborar PAF - Ejecución PAF

			let data_elaborar_paf = new Object();
    		data_elaborar_paf.caso_id = caso_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});


			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
						url: "../proceso/atencion/verificarElaborarPaf/"+caso_id,
						data: data_elaborar_paf
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		console.log(obj);
						reject(resp);
					});
				})

		break;

		case 5: //Ejecución PAF - Evaluación

			let data_ejecucion_paf = new Object();
    		data_ejecucion_paf.caso_id = caso_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
						url: "../proceso/atencion/verificarEjecucionPaf/"+caso_id,
						data: data_ejecucion_paf
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		console.log(resp);
						reject(resp);
					});
				})

		break;

		case 6: //Evaluación PAF - Seguimiento
		//case 11: //Evaluación PAF - Seguimiento

			let data_evaluacion = new Object();
    		data_evaluacion.caso_id = caso_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});


			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
						url: "../proceso/atencion/verificarEvaluacionPaf/"+caso_id,
						data: data_evaluacion
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		console.log(obj);
						reject(resp);
					});
				})

		break;

		case 7: //EGRESO PAF
			let data_egreso = new Object();
    		data_egreso.caso_id = caso_id;

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
						url: "../proceso/atencion/verificarEgresoPaf/"+caso_id,
						data: data_egreso
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		console.log(resp);
						reject(resp);
					});
			});
		break;


		case 15: //PreDiagnostico - Diagnostico
			let obs_1 = $("#obs_prediagnostico_1").val();
			let obs_2 = $("#obs_prediagnostico_2").val();
			let obs_3 = $("#obs_prediagnostico_3").val();
			let obs_4 = $("#obs_prediagnostico_4").val();
			let obs_5 = $("#obs_prediagnostico_5").val();
		    let obs_6 = $("#obs_prediagnostico_6").val();
			let fec_1 = $("#fecha_1").data('date');
			let fec_2 = $("#fecha_2").data('date');
			let fec_3 = $("#fecha_3").data('date');
			let fec_4 = $("#fecha_4").data('date');
			let fec_5 = $("#fecha_5").data('date');
			let fec_6 = $("#fecha_6").data('date');
			
		   if (obs_1 === "" || obs_1.length < 3 || typeof obs_1 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_1").show();
		   	   $("#obs_prediagnostico_1").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_1").hide();
			   $("#obs_prediagnostico_1").removeClass("is-invalid");
		   }

		   if (obs_2 === "" || obs_2.length < 3 || typeof obs_2 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_2").show();
		   	   $("#obs_prediagnostico_2").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_2").hide();
			   $("#obs_prediagnostico_2").removeClass("is-invalid");
		   }

		   if (obs_3 === "" || obs_3.length < 3 || typeof obs_3 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_3").show();
		   	   $("#obs_prediagnostico_3").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_3").hide();
			   $("#obs_prediagnostico_3").removeClass("is-invalid");
		   }

		   if (obs_4 === "" || obs_4.length < 3 || typeof obs_4 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_4").show();
		   	   $("#obs_prediagnostico_4").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_4").hide();
			   $("#obs_prediagnostico_4").removeClass("is-invalid");
		   }

		   if (obs_5 === "" || obs_5.length < 3 || typeof obs_5 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_5").show();
		   	   $("#obs_prediagnostico_5").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_5").hide();
			   $("#obs_prediagnostico_5").removeClass("is-invalid");
		   }

		   if (obs_6 === "" || obs_6.length < 3 || typeof obs_6 == "undefined"){
		       respuesta = false;
		   	   $("#val_obs_pre_6").show();
		   	   $("#obs_prediagnostico_6").addClass("is-invalid");
		   }else{
			   $("#val_obs_pre_6").hide();
			   $("#obs_prediagnostico_6").removeClass("is-invalid");
		   }

			if (typeof fec_1 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_1").show();
				$("#fecha_prediagnostico_1").addClass("is-invalid");

			}else if (typeof fec_1 != "undefined"){
				if (!validarFormatoFecha(fec_1)){
					respuesta = false;
					$("#val_obs_pre_fec_1").show();
					$("#fecha_prediagnostico_1").addClass("is-invalid");
			   }else if (!existeFecha(fec_1)){
					respuesta = false;
					$("#val_obs_pre_fec_1").show();
					$("#fecha_prediagnostico_1").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_1").hide();
					$("#fecha_prediagnostico_1").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_1").hide();
				$("#fecha_prediagnostico_1").removeClass("is-invalid");
			}
		   
			if (typeof fec_2 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_2").show();
				$("#fecha_prediagnostico_2").addClass("is-invalid");

			}else if (typeof fec_2 != "undefined"){
				if (!validarFormatoFecha(fec_2)){
					respuesta = false;
					$("#val_obs_pre_fec_2").show();
					$("#fecha_prediagnostico_2").addClass("is-invalid");
			   }else if (!existeFecha(fec_2)){
					respuesta = false;
					$("#val_obs_pre_fec_2").show();
					$("#fecha_prediagnostico_2").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_2").hide();
					$("#fecha_prediagnostico_2").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_2").hide();
				$("#fecha_prediagnostico_2").removeClass("is-invalid");
			}

			if (typeof fec_3 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_3").show();
				$("#fecha_prediagnostico_3").addClass("is-invalid");

			}else if (typeof fec_3 != "undefined"){
				if (!validarFormatoFecha(fec_3)){
					respuesta = false;
					$("#val_obs_pre_fec_3").show();
					$("#fecha_prediagnostico_3").addClass("is-invalid");
			   }else if (!existeFecha(fec_3)){
					respuesta = false;
					$("#val_obs_pre_fec_3").show();
					$("#fecha_prediagnostico_3").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_3").hide();
					$("#fecha_prediagnostico_3").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_3").hide();
				$("#fecha_prediagnostico_3").removeClass("is-invalid");
			}

			if (typeof fec_4 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_4").show();
				$("#fecha_prediagnostico_4").addClass("is-invalid");

			}else if (typeof fec_4 != "undefined"){
				if (!validarFormatoFecha(fec_4)){
					respuesta = false;
					$("#val_obs_pre_fec_4").show();
					$("#fecha_prediagnostico_4").addClass("is-invalid");
			   }else if (!existeFecha(fec_4)){
					respuesta = false;
					$("#val_obs_pre_fec_4").show();
					$("#fecha_prediagnostico_4").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_4").hide();
					$("#fecha_prediagnostico_4").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_4").hide();
				$("#fecha_prediagnostico_4").removeClass("is-invalid");
			}

			if (typeof fec_5 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_5").show();
				$("#fecha_prediagnostico_5").addClass("is-invalid");

			}else if (typeof fec_5 != "undefined"){
				if (!validarFormatoFecha(fec_5)){
					respuesta = false;
					$("#val_obs_pre_fec_5").show();
					$("#fecha_prediagnostico_5").addClass("is-invalid");
			   }else if (!existeFecha(fec_5)){
					respuesta = false;
					$("#val_obs_pre_fec_5").show();
					$("#fecha_prediagnostico_5").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_5").hide();
					$("#fecha_prediagnostico_5").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_5").hide();
				$("#fecha_prediagnostico_5").removeClass("is-invalid");
			}

			if (typeof fec_6 == "undefined"){
				respuesta = false;
				$("#val_obs_pre_fec_6").show();
				$("#fecha_prediagnostico_6").addClass("is-invalid");

			}else if (typeof fec_6 != "undefined"){
				if (!validarFormatoFecha(fec_6)){
					respuesta = false;
					$("#val_obs_pre_fec_6").show();
					$("#fecha_prediagnostico_6").addClass("is-invalid");
			   }else if (!existeFecha(fec_6)){
					respuesta = false;
					$("#val_obs_pre_fec_6").show();
					$("#fecha_prediagnostico_6").addClass("is-invalid");
			   }else{
					$("#val_obs_pre_fec_6").hide();
					$("#fecha_prediagnostico_6").removeClass("is-invalid");
			   }
			}else{
				$("#val_obs_pre_fec_6").hide();
				$("#fecha_prediagnostico_6").removeClass("is-invalid");
			}
		break;

	}
    
    return respuesta;
}

function limpiarMensajesValidacionCambiosDeEstados(option){
	switch(option){
		case 14: //PreDiagnostico - Diagnostico
			$("#val_obs_pre_1").hide();
			$("#val_obs_pre_2").hide();
			$("#val_obs_pre_3").hide();
			$("#val_obs_pre_4").hide();
			$("#val_obs_pre_5").hide();
			$("#val_obs_pre_6").hide();

			$("#obs_prediagnostico_1").removeClass("is-invalid");
			$("#obs_prediagnostico_2").removeClass("is-invalid");
			$("#obs_prediagnostico_3").removeClass("is-invalid");
			$("#obs_prediagnostico_4").removeClass("is-invalid");
			$("#obs_prediagnostico_5").removeClass("is-invalid");
			$("#obs_prediagnostico_6").removeClass("is-invalid");

			$("#val_obs_pre_fec_1").hide();
			$("#val_obs_pre_fec_2").hide();
			$("#val_obs_pre_fec_3").hide();
			$("#val_obs_pre_fec_4").hide();
			$("#val_obs_pre_fec_5").hide();
			$("#val_obs_pre_fec_6").hide();

			$("#fecha_prediagnostico_1").removeClass("is-invalid");
			$("#fecha_prediagnostico_2").removeClass("is-invalid");
			$("#fecha_prediagnostico_3").removeClass("is-invalid");
			$("#fecha_prediagnostico_4").removeClass("is-invalid");
			$("#fecha_prediagnostico_5").removeClass("is-invalid");
			$("#fecha_prediagnostico_6").removeClass("is-invalid");
		break;
	}
}

function bloquearPantalla(){

/*	$.blockUI({
    theme: true,
    baseZ: 2000
})*/

	 $.blockUI(
	 	{
	 		baseZ: 2000
	 	});

	 /*$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: 'white', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .4, 
            color: 'white'
           
        } });*/
}

function desbloquearPantalla(){
	$.unblockUI();
}


function siguienteEtapaTerapia(option,tera_id){

	switch (option) {
		case 4: // Invitación -> Diagnostico

			validacionCambiosDeEstadosTerapia(option,tera_id).then(function (data){

            	$html='';
    			if (data.respuesta==0){

    				//alert(data.respuesta);
    	 			$html="<div class='alert alert-warning' role='alert'>";
    	 			$html+="<ul>";
						for (var i=0; i<data.mensajes.length; i++){
					 	$html+="<li>"+data.mensajes[i]+"</li>";
					 	}
	    	 			$html+="</ul>";
	     			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					//alert(data.respuesta);
					// let seguimiento = $("#est_segu_cons").val();

					// $("#diagnostico-tab").removeClass("disable-btn-nav-est");
					// $("#diagnostico-tab-ico").removeClass("text-light");
					// $("#diagnostico-tab-ico").addClass("text-success");

					//$("#diagnostico-tab").attr("onclick", "procesoAtencionCaso("+predignostico+", " + caso + ", false);");

					// $('#diagnostico-tab').click();
					// $("#diagnostico-tab").focus();
					// $("#diagnostico-tab").addClass("active");

					$("#btn-etapa-elaborar").prop("disabled", false);
					$('#btn-etapa-elaborar').removeAttr("disabled");
					$("[name=bit-etapa-diagnostico]").removeAttr("disabled");

					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoTerapia(option, tera_id, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar la invitación de la terapia. Por favor intente nuevamente."); 
      		});

      		break;

      		///////////////////////////////////////////////

		case 5: // Diagnostico -> Ejecución

			validacionCambiosDeEstadosTerapia(option,tera_id).then(function (data){

            	$html='';
    			if (data.respuesta==0){

    				//alert(data.respuesta);
    	 			$html="<div class='alert alert-warning' role='alert'>";
    	 			$html+="<ul>";
						for (var i=0; i<data.mensajes.length; i++){
					 	$html+="<li>"+data.mensajes[i]+"</li>";
					 	}
	    	 			$html+="</ul>";
	     			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					$("#btn-etapa-ejecucion").prop("disabled", false);
					$('#btn-etapa-ejecucion').removeAttr("disabled");
					$("[name=bit-etapa-ejecucion]").removeAttr("disabled");

					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoTerapia(option, tera_id, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar el diagnóstico de la terapia. Por favor intente nuevamente."); 
      		});

      		break;
					
		case 6: // Ejecución -> Seguimiento

			validacionCambiosDeEstadosTerapia(option,tera_id).then(function (data){

            	$html='';
    			if (data.respuesta==0){

    				//alert(data.respuesta);
    	 			$html="<div class='alert alert-warning' role='alert'>";
    	 			$html+="<ul>";
						for (var i=0; i<data.mensajes.length; i++){
					 	$html+="<li>"+data.mensajes[i]+"</li>";
					 	}
	    	 			$html+="</ul>";
	     			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					//$("#btn-etapa-elaborar").prop("disabled", false);
					//$('#btn-etapa-elaborar').removeAttr("disabled");
					//$("[name=bit-etapa-diagnostico]").removeAttr("disabled");

					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoTerapia(option, tera_id, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar el diagnóstico de la terapia. Por favor intente nuevamente."); 
      		});

      		break;

		case 12: // Seguimiento -> Egreso

			validacionCambiosDeEstadosTerapia(option,tera_id).then(function (data){

            	$html='';
    			if (data.respuesta==0){

    				//alert(data.respuesta);
    	 			$html="<div class='alert alert-warning' role='alert'>";
    	 			$html+="<ul>";
						for (var i=0; i<data.mensajes.length; i++){
					 	$html+="<li>"+data.mensajes[i]+"</li>";
					 	}
	    	 			$html+="</ul>";
	     			$html+="</div>";

					$('#msgErroresValidacion').find('.modal-body').html($html);
					$('#msgErroresValidacion').modal('show');
				}else{

					//$("#btn-etapa-elaborar").prop("disabled", false);
					//$('#btn-etapa-elaborar').removeAttr("disabled");
					//$("[name=bit-etapa-diagnostico]").removeAttr("disabled");

					$('body,html').animate({scrollTop : 0}, 500);
					cambioEstadoTerapia(option, tera_id, "");

				}

      		}).catch(function (error){
        		alert("Hubo un error al momento de validar el diagnóstico de la terapia. Por favor intente nuevamente."); 
      		});

      		break;

		return false;
			
	}

}

function validacionCambiosDeEstadosTerapia(option,tera_id){
	let respuesta = true;

	//limpiarMensajesValidacionCambiosDeEstados(option);

	switch(option){
		case 4: // Invitación -> Diagnostico

			let data_invitacion = new Object();
    		data_invitacion.tera_id = tera_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
							// INICIO CZ SPRINT 63 Casos ingresados a ONL
						url: "../../gestion/terapia/verificar/invitacion",
							// FIN CZ SPRINT 63 Casos ingresados a ONL
						data: data_invitacion
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		//console.log(obj);
						reject(resp);
					});
				})

		break;

		case 5: // Diagnostico -> Ejecución

			let data_diagnostico = new Object();
    		data_diagnostico.tera_id = tera_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
							// INICIO CZ SPRINT 63 Casos ingresados a ONL
						url: "../../gestion/terapia/verificar/diagnostico",
							// FIN CZ SPRINT 63 Casos ingresados a ONL
						data: data_diagnostico
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		//console.log(obj);
						reject(resp);
					});
				})

		break;

		case 6: // Ejecución -> Seguimiento

			let data_ejecucion = new Object();
    		data_ejecucion.tera_id = tera_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
							// INICIO CZ SPRINT 63 Casos ingresados a ONL
						url: "../../gestion/terapia/verificar/ejecucion",
							// FIN CZ SPRINT 63 Casos ingresados a ONL
						data: data_ejecucion
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		//console.log(obj);
						reject(resp);
					});
				})

		break;

		case 12: // Seguimiento -> Egreso

			let data_seguimiento = new Object();
    		data_seguimiento.tera_id = tera_id;
    		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

			return new Promise(function (resolve, reject){
					$.ajax({
						type: "GET",
						dataType: "JSON",
							// INICIO CZ SPRINT 63 Casos ingresados a ONL
						url: "../../gestion/terapia/verificar/seguimiento",
							// FIN CZ SPRINT 63 Casos ingresados a ONL
						data: data_seguimiento
					}).done(function(resp) {
						resolve(resp);
					}).fail(function(resp){
			    		//console.log(obj);
						reject(resp);
					});
				})

		break;

	}

    return respuesta;
}

function cambioEstadoTerapia(option, tera_id, comentario){
	// INICIO CZ SPRINT 63
	$("#cambiar_estado").hide();
	$("#contenedor_comentario_estado").hide();
	limpiarModalMsgEstadosTerapia();
	// FIN CZ SPRINT 63
	//let egreso = $("#est_egre_cons").val();
	let url = $("#url_terapia_cambio_estado").val();
	let data = new Object();
    data.option = option;
    data.tera_id = tera_id;
	data.comentario = comentario;


	$.ajax({
		url: url,
		type: "GET",
		data: data
	}).done(function(resp){
		let html= resp.mensaje;

		 if (resp.estado == 1){
		 	if (option == 7 || option == 8 || option == 9 || option == 10 || option == 11 || option == 12){
		 		$(".btnEtapa").attr("disabled", "true");
		 		$(".btnRechEst").attr("disabled", "true");
		 		$(".txtAreEtapa").attr("disabled", "true");
		 		$("#btn_agregar_detalle_seguimiento").attr("disabled", "true");
		 		$(".btn_editar_detalle_seguimiento").attr("disabled", "true");
		 		$(".boton_ptf").attr("disabled", "true");
		 		$(".input_desabilitar").attr("disabled", "true");

		// 	}else if (option == 12){ //Egreso
		// 		$("#btn-etapa-egreso").attr("disabled", "true");

		 	}
		 }

		$("#cambiar_estado").hide();
		$("#contenedor_comentario_estado").hide();
		$("#contenedor_rechazo_estado_persona").hide();

		$("#msg_cambioEstado_body").html(html);
		$("#msg_cambioEstado_body").show();
		$('#msgCambioEstadoTerapia').modal('show');

		//location.reload();

		$("#est_act_ter").val(option);

		// diagnostico
		if (option==4){
			$("#invitacion-tab").removeClass("active");
			$("#diagnostico-tab-ico").removeClass("text-light");
			$("#diagnostico-tab-ico").addClass("text-success");
			$('#diagnostico-tab').click();
			$("#diagnostico-tab").focus();
			$("#diagnostico-tab").removeClass("disabled");
			$("#diagnostico-tab").removeClass("disable-btn-nav-est");
		}

		// ejecución
		if (option==5){
			$("#invitacion-tab").removeClass("active");
			$("#diagnostico-tab").removeClass("active");
			$("#ejecucion-tab-ico").removeClass("text-light");
			$("#ejecucion-tab-ico").addClass("text-success");
			$('#ejecucion-tab').click();
			$("#ejecucion-tab").focus();
			$("#ejecucion-tab").removeClass("disabled");
			$("#ejecucion-tab").removeClass("disable-btn-nav-est");

		}

		// seguimiento
		if (option==6){
			$("#invitacion-tab").removeClass("active");
			$("#diagnostico-tab").removeClass("active");
			$("#ejecucion-tab").removeClass("active");
			$("#seguimiento-tab-ico").removeClass("text-light");
			$("#seguimiento-tab-ico").addClass("text-success");
			$('#seguimiento-tab').click();
			$("#seguimiento-tab").focus();
			$("#seguimiento-tab").removeClass("disabled");
			$("#seguimiento-tab").removeClass("disable-btn-nav-est");
		}
		// CZ SPRINT 74
		//obtenerNotificacionesTiempo();
		obtenerCantidadNotificacion();
		obtenerCantidadTiempo();
		// CZ SPRINT 74
	}).fail(function(obj){
		let html = "Error al momento de realizar la actualización del estado del la terapia. Por favor intente nuevamente.";

		console.log(obj);
		$("#cambiar_estado").hide();
		$("#contenedor_comentario_estado").hide();
		$("#contenedor_rechazo_estado_persona").hide();

		$("#msg_cambioEstado_body").html(html);
		$("#msg_cambioEstado_body").show();
		$('#msgCambioEstadoTerapia').modal('show');
	});
}


function comentarioEstadoTerapia(tera_id){
	limpiarModalMsgEstadosTerapia();

	if (typeof tera_id == "undefined" || tera_id == "") return false;

	//$("#cambiar_estado").attr("data-opc", option);
	$("#cambiar_estado").attr("data-cas-id", tera_id);
    $("#msg_cambioEstado_body").hide();

	$('#msgCambioEstadoTerapia').modal('show');
}


function validarComentarioModalEstadoTerapia(){

 let comentario = $("#comentario_estado_terapia").val().trim();
 let opcion     = $("#rechazo_estado_terapia").val();
 let tera_id    = $("#tera_id").val();
 let car_ren	= $("#val_carta_renuncia").val();

 let validacion = true;

   //Validación caja de comentario
   if (comentario === "" || comentario.length < 3 || typeof comentario == "undefined"){
   	   $("#val_msg_com").show();
   	   $("#comentario_estado_terapia").addClass("is-invalid");
       validacion = false;
   }else{
	   $("#val_msg_com").hide();
	   $("#comentario_estado_terapia").removeClass("is-invalid");
   }

 //   //Validación rechazado por
	if (typeof opcion == "undefined" || opcion == ""){
		$("#val_msg_rec").show();
		$("#rechazo_estado_terapia").addClass("is-invalid");
		validacion = false;
	}else{
		$("#val_msg_rec").hide();
		$("#rechazo_estado_terapia").removeClass("is-invalid");
	}

	// VALIDACION DE CARTA DE RENUNCIA
	// if(car_ren == ""){
	// 	$("#val_doc_carta_renuncia").show();
	// 	$("#doc_carta_renuncia").addClass("is-invalid");
	// 	validacion = false;
	// }else{
	// 	$("#val_doc_carta_renuncia").hide();
	// 	$("#doc_carta_renuncia").removeClass("is-invalid");
	// }

   if (validacion == false) return false;

   let confirmacion = confirm("¿ Esta seguro que desea rechazar la Terapia ?");
   if (confirmacion == false) return false;
   cargarCartaRenuncia(function(resp){
	   if(!resp){
		   return false;
	   }
   });
   cambioEstadoTerapia(opcion, tera_id, comentario);
}

function limpiarModalMsgEstadosTerapia(){
    //$("#cambiar_estado").removeAttr("data-cas-id");
	$("#cambiar_estado").show();
	$("#contenedor_comentario_estado").show();
	$("#contenedor_rechazo_estado_persona").show();
	$("#msg_cambioEstado_body").hide();

	$("#val_msg_com").hide();
	$("#comentario_estado_terapia").removeClass("is-invalid");
	$("#comentario_estado_terapia").val("");

	$("#val_msg_rec").hide();
	$("#rechazo_estado_terapia").removeClass("is-invalid");
	document.getElementById("rechazo_estado_terapia").value = '';

	$("#cant_carac_cam_est").css("color", "#000000");
	 $("#cant_carac_cam_est").text(0);

	$("#val_carta_renuncia").val("");
	$("#doc_carta_renuncia").val("");
	$("#filename").text("Cargar archivo");
}

 function valTextConfirmDesesCaso(){

      num_caracteres_permitidos   = 255;

      num_caracteres = $("#comentario_desestimacion").val().length;

       if (num_caracteres > num_caracteres_permitidos){ 
            $("#comentario_desestimacion").val(contenido_textarea_rechazo_estados);

       }else{ 
          contenido_textarea_rechazo_estados = $("#comentario_desestimacion").val(); 

       }

       if (num_caracteres >= num_caracteres_permitidos){ 
          $("#cant_carac_com_dest").css("color", "#ff0000"); 

       }else{ 
          $("#cant_carac_com_dest").css("color", "#000000");

       } 
      
       $("#cant_carac_com_dest").text($("#comentario_desestimacion").val().length);
   }

function esconderRut(rut, activacion = null){
	let formato = rut;

	if (activacion){
		formato = rut.replace("-","");
		formato = formato.replace(".","");
		formato = formato.replace(".","");

		let largo_rut = formato.length;

		if (largo_rut==9){
			formato = formato.substring(0, 2)+'.'+formato.substring(2, 5)+'.xxx-x';
		}

		if (largo_rut==8){
			formato = formato.substring(0, 1)+'.'+formato.substring(1, 4)+'.xxx-x';
		}

		if (largo_rut==7){
			formato = formato.substring(0, 3)+'.xxx-x';
		}

		$formato = "v";
	}

	return formato;
}

function CodificarString(string){
	let respuesta = string;

	if (typeof respuesta != "undefined" && respuesta != "") respuesta = btoa(respuesta);

	return respuesta;
}	

function DecodificarString(string){
	let respuesta = string;

	if (typeof respuesta != "undefined" && respuesta != "") respuesta = atob(respuesta);

	return respuesta;
}	

function descargarPdfNcfas(cas_id,opcion){

	bloquearPantalla();

	setTimeout(function(){ 

	desbloquearPantalla();

	}, 50000);

}

function manejoPeticionesFailAjax(objeto, tipoError, errorHttp){
	// INICIO CZ SPRINT 66
	let mensaje = "Error! Hubo un inconveniente al momento de ejecutar la acción solicitada. Por favor intente nuevamente.";
	// FIN CZ SPRINT 66
    if (objeto.status === 0){
      alert(mensaje+"\n\n- Sin conexión: Verifique su red o intente nuevamente.");

    } else if (objeto.status == 404){
      alert(mensaje+"\n\n- Página solicitada no encontrada [404].");

    } else if (objeto.status == 500){
      alert(mensaje+"\n\n- Error interno del servidor [500].");

    } else if (tipoError === 'parsererror') {
      alert(mensaje+"\n\n- Error al manipular respuesta JSON.");

    } else if (tipoError === 'timeout') {
      alert(mensaje+"\n\n- Error de tiempo de espera.");

    } else if (tipoError === 'abort') {
      alert(mensaje+"\n\n- Solicitud Ajax abortada.");

    } else {
      alert(mensaje);
      console.log('Error no capturado: ' + objeto.responseJSON);
    
    }
}

function formateoNombres(nombre = null, ape_pat = null, ape_mat = null){

	let persona = Object()
	
	if (nombre == null){
		persona.nombre = ''
	}else{
		persona.nombre = primeraLetraMayuscula(nombre);
	}

	if (ape_pat == null){
		persona.ape_pat = ''
	}else{
		persona.ape_pat = primeraLetraMayuscula(ape_pat);
	}

	if (ape_mat == null){
		persona.ape_mat = ''
	}else{
		persona.ape_mat = primeraLetraMayuscula(ape_mat);
	}

	return persona;
}


/*
** @Autor: Alvaro Neicun Rivera
** @Fecha: 20-04-2020
** @Versión: 1.0
** 
** - Funcion que muestra ventana emergente con mensaje de alerta, 
** segun parametros ingresados.
**
** @Comentarios:
**
** - 
*/
function mensajeTemporalRespuestas(tipo_mensaje = 0, mensaje = ""){
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
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
    };

    switch(tipo_mensaje){
    	case 1: //EXITO
    		 return toastr.success(mensaje);
    	break;

    	case 0: //ERROR
    	default:
    		return toastr.error(mensaje);
    }
}
