/* envia un formulario por ajax,
	 * 1er parametro es el id del form, ej: #frmUsuario
	 * 2do parametro id el div donde se mostrara el mensaje ej: #divMsg
	 * 3er parametro es una funcion javascript que se ejecutara JSON retorna OK (estado=1)
	 * para que funcione, la URL (controller) debe responder por JSON estado y msg
	 * estado = 1 indica OK
	 * estado = 0 indica ERROR
	 */
	function enviaForm(frm,div,fnc) {

	    $(div).hide();
	    
	    $.ajax({
	        type: "POST",
	        url: $(frm).attr('action'),
	        data: $(frm).serialize(),
	        dataType:'json',
	        success: function(obj)
	        {
	            $(div).show();
	            $(div).html(obj.msg);
	            $(div).addClass('alert-danger');

	            if (obj.estado == '1') {
	                $(div).removeClass('alert-danger');
	                $(div).addClass('alert-success');
	                eval(fnc);
	            }
	        }
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

function enviaFormModalFolio(frm,div,fnc, fnc2) {
    
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
                eval(fnc + "('" + obj.msg + "'," + obj.folio + "," + obj.id + ")" );
            }
            else {
                eval(fnc2 + "('" + obj.msg + "')" );
            }
        }
    });
}

function enviaFormShowModal(frm) {
    
    $.ajax({
        type: "POST",
        url: $(frm).attr('action'),
        data: $(frm).serialize(),
        dataType:'json',
        success: function(obj)
        {   
            if (obj.estado == '0') {
                modalMsj("<p>"+ obj.msg +"</p>");
            }
            if (obj.estado == '1') {
                modalMsjConfirm("Información","<p>"+ obj.msg +"</p>","btnGuardado('#btnGuardarModal'); hideModal('#modalMsjConfirm');");
            }
        }
    });
}

function enviaFormShowModal2(frm,fn1,fn0) {
    
    $.ajax({
        type: "POST",
        url: $(frm).attr('action'),
        data: $(frm).serialize(),
        dataType:'json',
        success: function(obj)
        {   
            if (obj.estado == '0') {
                eval(fn0);
                modalMsj("<p>"+ obj.msg +"</p>");
                
            }
            if (obj.estado == '1') {
                eval(fn1);
                modalMsjConfirm("Información","<p>"+ obj.msg +"</p>","btnGuardado('#btnGuardarModal2'); hideModal('#modalMsjConfirm'); ");
                
            }
        }
    });
}

function showModal(titulo,url, chico) {
    chico = chico || 0;

    $('#xModal .modal-dialog').addClass('modal-lg');
    if (chico) {
        $('#xModal .modal-dialog').removeClass('modal-lg');
        $('#xModal .modal-dialog').addClass('modal-sm');
    }
    
    $('#xModalTitle').html(titulo);
    $('#xModal .modal-body' ).html('');

    $.ajax({
        url: url,
        cache: false
    }).done(function( html ) {
        $('#xModal .modal-body').removeClass('ajaxloading');
        $('#xModal .modal-body' ).html( html );

        $('#xModal').modal('show');
    });
}

function showModalVer(titulo,url, chico) {
    chico = chico || 0;

    $('#xModalVer .modal-dialog').addClass('modal-lg');
    if (chico) {
        $('#xModalVer .modal-dialog').removeClass('modal-lg');
        $('#xModalVer .modal-dialog').addClass('modal-sm');
    }
    
    $('#xModalTitleVer').html(titulo);
    $('#xModalVer .modal-body' ).html('');

    $.ajax({
        url: url,
        cache: false
    }).done(function( html ) {
        $('#xModalVer .modal-body').removeClass('ajaxloading');
        $('#xModalVer .modal-body' ).html( html );

        $('#xModalVer').modal('show');
    });
}

function btnGuardando(btn){
    
    $(btn).text('Guardando...');
    $(btn).attr('disabled',1);

}

function btnGuardado(btn){
    
    $(btn).text('Guardado');
    $(btn).attr('disabled',1);

}

function btnEliminando(btn){
    
    $(btn).text('Eliminando...');
    $(btn).attr('disabled',1);

}

function btnFinalizado(btn){
    
    $(btn).text('Finalizado');
    $(btn).attr('disabled',1);

}

function btnGuardarHabilitar(btn,nombre){
    
    $(btn).text(nombre);
    $(btn).removeAttr('disabled');

}


function showMsj(msg,tipo) {
    if (tipo=='success') {
        modalMsjConfirm("Información","<p>"+ msg +"</p>","btnGuardado('#btnGuardarModal'); hideModal('#modalMsjConfirm');");
    }
    if (tipo=='danger') {
        modalMsj("<p>"+ msg +"</p>");
    }
      
}

function cargaDiv(url,div) {
    $.ajax({
        url: url,
        cache: false
    }).done(function( html ) {
        $(div).removeClass('ajaxloading');
        $(div).html( html );
    });

    $(div).html('Cargando, espere por favor...');
    $(div).addClass('ajaxloading');
}

function cargarDivComunas(element_id,id) {
    cargaDiv('/cargacomuna/'+id,'#'+element_id);
}

function cargarDivComunasP(element_id,id) {
    cargaDiv('/cargacomunap/'+id,'#'+element_id);
}

function cargarDivComunasPOff(element_id,id) {
    cargaDiv('/cargacomunapoff/'+id,'#'+element_id);
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

        $(id + ' .modal-body').html( html );

        eval(fnc);
    });
}


function modalMsj(mensaje) {
    $('#msjInfo').empty();
    $('#msjInfo').html(mensaje);
    $('#modalMsj').modal('show');
}

function modalMsjConfirm(titulo, mensaje, fnc) {
    $('#tituloMsjConfirm').empty();
    $('#tituloMsjConfirm').text(titulo);
    $('#bodyMsjConfirm').html(mensaje);
    $('#btnMsjConfirm').attr("onclick", fnc);
    $('#modalMsjConfirm').modal('show');
}

function ModalEliminaConfirm(titulo, mensaje, fnc) {
    $('#tituloEliminar').empty();
    $('#tituloEliminar').text(titulo);
    $('#bodyEliminar').empty();
    $('#bodyEliminar').html(mensaje);
    $('#btnElimFormIndiv').removeAttr('disabled');
    $('#btnElimFormIndiv').text('Eliminar');
    $('#btnElimFormIndiv').attr("onclick", fnc);
    $('#modalEliminar').modal('show');

}

function hideModal(modal){
    $(modal).modal('hide');
}

/*

id      : #id del modal
titulo  : titulo del modal
url     : url que se cargará con ajax en el body del modal
*/
function showModalAjaxAux(id, titulo, url, btn) {
    $(id + ' .modal-dialog').addClass('modal-lg');
    $(id + ' .modal-footer').show();
    $(id + ' .modal-header .close').show();

    if (titulo != '')
        $(id + ' .modal-title').html(titulo);
    
    $(id + ' .modal-body').html('Cargando, espere por favor...');
    $(id + ' .modal-footer').html('');

    
    $(id + ' .modal-footer').append(btn);
                
    $(id).modal('show');

    $.ajax({
        url: url,
        cache: false
    }).done(function( html ) {

        $(id + ' .modal-body').html( html );

        eval(fnc);
    });
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

function isNumber(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
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

function checkPuntaje(ptj) {
    // Despejar Puntos
    var valor = ptj.value.replace('.','');

    if (valor>100){
        modalMsj("<p>Puntaje fuera de rango</p>");
        $("#IDpuntaje").val('');
    }
     
}

function showMsjFn(msg,tipo,fn) {
    if (tipo=='success') {
        modalMsjConfirm("Información","<p>"+ msg +"</p>","btnGuardado('#btnGuardarModal'); hideModal('#modalMsjConfirm');");
        eval(fn);
    }
    if (tipo=='danger') {
        modalMsj("<p>"+ msg +"</p>");
        eval(fn);
    }
      
}


function Redirect(url) {
   window.location=url;
}


function generarPass(id_usuario){
    $('#modalPass').modal('show'); 
    $('#IDusuario').val(id_usuario);
}


    function enviarGenerarPass(){
        //btnGuardando('#btnGuardar');
        enviaFormModal('#frmPass','','passOK()','passError');

    }    

    function passOK(){
       $('#modalPass').modal('hide');              
        modalMsj("<p>Se ha generado una nueva contraseña, enviada por correo electrónico a la dirección que usted ingresó al momento de registrarse.</p>");
    }

    function passError(msj){
       $('#modalPass').modal('hide');        
        modalMsj("<p>"+msj+"</p>");
    } 

function checkMiles(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
 
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}  



    var formatNumber = {
     separador: ".", // separador para los miles
     sepDecimal: ',', // separador para los decimales
     formatear:function (num){
     num +='';
     var splitStr = num.split('.');
     var splitLeft = splitStr[0];
     var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
     var regx = /(\d+)(\d{3})/;
     while (regx.test(splitLeft)) {
     splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
     }
     return this.simbol + splitLeft +splitRight;
     },
     new:function(num, simbol){
     this.simbol = simbol ||'';
     return this.formatear(num);
     }
}


function editaDirectorio(id, folio, token) {

    $.ajax({
        type: "POST",
        url: "/api/adm/get-directorio",
        data: "folio=" + folio + "&id=" + id + "&_token=" + token,
        dataType:'json',
        success: function(obj)
        {
            console.log(obj);
            if (obj.length == 1) {
                $('#modalDirectorio input[name=rut]').val(obj[0].rut);
                $('#modalDirectorio input[name=nombre]').val(obj[0].nombre);
                $('#modalDirectorio input[name=email]').val(obj[0].email);
                $('#modalDirectorio input[name=telefono]').val(obj[0].telefono);
                $('#modalDirectorio input[name=celular]').val(obj[0].celular);
                $('#modalDirectorio select[name=id_cargo]').val(obj[0].cargo.valor);
                //$('#modalDirectorio input[name=rut]').attr('readonly','1');
                $('#modalDirectorio input[name=id]').val(obj[0].id);
                $('#modalDirectorio').modal('show');    
            }
            else {
                modalMsj("<p>No es posible editar al funcionario. Ha ocurrido un error.</p>");
            }            
        }
    });
    
}


 $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '< Ant',
     nextText: 'Sig >',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'dd/mm/yy',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
 };

 $.datepicker.setDefaults($.datepicker.regional['es']);