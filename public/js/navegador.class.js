
//-CREAR UNA COOKIE

function crearCokkie(cookieName, cookieValue, expires=null, path=null, domain=null, secure=null) {

		document.cookie =

			escape(cookieName) + '=' + escape(cookieValue)

			+ (expires ? '; expires=' + expires.toGMTString() : '')

			+ (path ? '; path=' + path : '')

			+ (domain ? '; domain=' + domain : '')

			+ (secure ? '; secure' : '');

};

//-ENTREGA EL VALOR DE UNA COKKIE

function valueCokkie(cookieName) {

		var cookieValue = '';

		var posName = document.cookie.indexOf(escape(cookieName) + '=');

		if (posName != -1) {

			var posValue = posName + (escape(cookieName) + '=').length;

			var endPos = document.cookie.indexOf(';', posValue);

			if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));

			else cookieValue = unescape(document.cookie.substring(posValue));

		}

		return (cookieValue);

};


/**
 * @package	i-datum
 * Proyecto	: Plataforma de Software Web i-datum
 * Archivo	:	Navegador.class.js
 *
 * @link http://www.siigsa.cl
 * @copyright SIIGSA, Propiedad Intelectual y Derechos Patrimoniales de Software y Base de Datos i-datum. Registro Propiedad Intelectual Nº 211.351 y 211.352 respectivamente, con fecha 22 de noviembre del 2011
 * @author Cristián Gómez Mamani <cgomez@siigsa.cl>
 * @since 03-12-2009
 * @version 1.0.6
 *
 * Clase que permite gestionar la identificación y versión de un explorador web
 *
 *
 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
 * @since 14-05-2009
 * @version 6
 * validarNavegador()
 *
 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
 * @since 17-06-2016
 * @version 7
 * Navegador()
 *
 */

// function Navegador(){

// 	var ua, i;
// 	var s = null;
// 	var inicio = 0;
// 	this.nombre = null;
// 	this.isIE    = false;
// 	this.isNS    = false;
// 	this.isOP    = false;
// 	this.isCH    = false;
// 	this.isFF    = false;
// 	this.version = null;
// 	this.versionIE = 11;
// 	this.versionFF = 40;
// 	this.versionCH = 40;

//   ua = navigator.userAgent;
  
//   if ((navigator.userAgent).indexOf("Opera")!=-1) {

//     this.isOP = true;
//     this.isOP = true;

//   } else if (navigator.appName=="Netscape") {

//   	if ((navigator.userAgent).indexOf("Firefox") != -1) {

// 	  	s 					 = "Firefox";
//     	inicio	 		 = parseInt(ua.indexOf(s)) + s.length + 1;
//     	this.version = parseInt(ua.substr(inicio, 3));
//     	this.isFF    = true;

//   	} else if ((navigator.userAgent).indexOf("Chrome") != -1) {

// 	  	s 				 	 = "Chrome";
//     	inicio    	 = parseInt(ua.indexOf(s)) + s.length + 1;
//     	this.version = parseInt(ua.substr(inicio, 3));
//     	this.isCH    = true;

//   	} else if ((navigator.userAgent).indexOf("Trident") != -1) {

// 	  	s 				 	 = "Internet Explorer";
//     	var re       = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
//       if (re.exec(ua) != null) {
//           rv = parseFloat(RegExp.$1);
//           this.version = rv;
//       }                
//     	this.isIE    = true;

//   	}

//   } else if ((navigator.appName).indexOf("Microsoft") != -1 ) {

//     var s			   = "MSIE";
//     inicio       = parseInt(ua.indexOf(s)) + s.length + 1;
//     this.version = parseInt(ua.substr(inicio, 3));
//     this.isIE    = true;

//   }
  
//   this.nombre = s;

	/**
	 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
	 * @since 14-05-2009
	 * @version 1.0.6
   *
   * validacion de navegador para el sistema (IE>=8, FF>=3, CH>=1)
   *
	 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
	 * @since 03-12-2009
	 * @version 6
   *
   * se cambio el alert por confirm y se genero una cookie para que no pregunte siempre
   *
   */
// 	this.validarNavegador = function(){

// 		try{
      
//       //console.log(this.nombre + ' - ' + oNavegador.version);
      
// 			if (this.getCookie('validacionBrowser') == "" || !this.getCookie('validacionBrowser')){
        
// 				if (this.isIE && oNavegador.version < this.versionIE) {

// 					/*if (confirm('Para ver correctamente este sitio necesita Internet Explorer version ' + this.versionIE + '.0 o superior. Haga click en el boton Aceptar para redireccionar a la pagina de descarga de Internet Explorer actualizada.')){
// 						location.href = GC_URL_DESCARGA_IEXPLORER;
// 					}else{
// 						this.setCookie('validacionBrowser','true');
// 					}*/

// 				} else if (this.isFF && oNavegador.version < this.versionFF) {

// 					/*if (confirm('Para ver correctamente este sitio necesita Mozilla Firefox version. ' + this.versionFF + '.5 o superior. Haga click en el boton Aceptar para redireccionar a la pagina de descarga de Firefox actualizada.')){
// 						location.href = GC_URL_DESCARGA_FIREFOX;
// 					}else{
// 						this.setCookie('validacionBrowser','true');
// 					}*/

// 				} else if (this.isCH && oNavegador.version < this.versionCH) {

// 					/*if (confirm('Para ver correctamente este sitio necesita Google Chrome version ' + this.versionCH + '.0 o superior. Haga click en el boton Aceptar para redireccionar a la página de descarga de Google Chrome actualizada.')){
// 						location.href = GC_URL_DESCARGA_CHROME;
// 					}else{
// 						this.setCookie('validacionBrowser','true');
// 					}*/

// 				} else if ((oNavegador.nombre == null && oNavegador.version == null) || this.isOP) {

// 					/*if (confirm('Para ver correctamente este sitio necesita Mozilla Firefox version 40 o superior. Haga click en el boton Aceptar para redireccionar a la página de descarga de Firefox actualizada.')){
// 						location.href = GC_URL_DESCARGA_FIREFOX;
// 					}else{
// 						this.setCookie('validacionBrowser','true');
// 					}*/

// 				}

// 			}

//   	}catch(e){

// 			alert(e.name + " - " + e.message);

// 		}

// 	}


// 	/**
// 	 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
// 	 * @since 03-12-2009
// 	 * @version 1.0.1
//    *
//    * seteo de cookie javascript
//    *
//    */
// 	this.setCookie = function(cookieName, cookieValue, expires, path, domain, secure) {

// 		document.cookie =

// 			escape(cookieName) + '=' + escape(cookieValue)

// 			+ (expires ? '; expires=' + expires.toGMTString() : '')

// 			+ (path ? '; path=' + path : '')

// 			+ (domain ? '; domain=' + domain : '')

// 			+ (secure ? '; secure' : '');

// 	};



// 	/**
// 	 * @author Patricio Cifuentes Ithal <pcifuentes@siigsa.cl>
// 	 * @since 03-12-2009
// 	 * @version 1.0.1
//    *
//    * retorno de valor de cookie javascript
//    *
//    */
// 	this.getCookie = function(cookieName) {

// 		var cookieValue = '';

// 		var posName = document.cookie.indexOf(escape(cookieName) + '=');

// 		if (posName != -1) {

// 			var posValue = posName + (escape(cookieName) + '=').length;

// 			var endPos = document.cookie.indexOf(';', posValue);

// 			if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));

// 			else cookieValue = unescape(document.cookie.substring(posValue));

// 		}

// 		return (cookieValue);

// 	};

// }
