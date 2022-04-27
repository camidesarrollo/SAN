<?php
/**
 * Funciones utilitarias para usar en todo el proyecto
 * User: jmarquez
 * Date: 30-10-2018
 * Time: 9:48
 * Desc: Funciones de Ayuda de la aplicacion
 */

if (!function_exists("dv")) {
	/**
	 * Funcion que generar el digito identificador del run
	 * @param $r
	 * @return string
	 */
	function dv($r){ $s=1;for($m=0; $r!=0; $r/=10)$s=($s+$r%10*(9-$m++%6))%11; return chr($s?$s+47:75); }
}


if (!function_exists("aplicarColor")) {
	/** Funcion para aplicara un color segun el Score del caso
	 * @param $score
	 * @return string
	 */
	function aplicarColor($score){
		$claseCss = '';
		if($score===0){
			$score =  1;
		}
		
		switch ($score) {
			
			case $score <=20 :
				$claseCss =  "alarmaUno";
				break;
			case $score <= 40 :
				$claseCss =  "alarmaDos";
				break;
			case $score <= 60 :
				$claseCss =  "alarmaTres";
				break;
			case $score <= 80 :
				$claseCss =  "alarmaCuatro";
				break;
			case $score <= 100 :
				$claseCss =  "alarmaCinco";
				break;
		}
		
		return $claseCss;
	}
}

if (!function_exists("limpiarRut")) {
	/** Remueve los "." del rut y devuelve array con el run y el digito verificador
	 * @param $rut
	 * @return array
	 */
	function limpiarRut($rut){
		return explode("-", str_replace('.', '', $rut));
	}
}

if (!function_exists("devuelveRut")) {
	/** Devuelve solo la parte del rut sin el digito verificador y los "."
	 * @param $rut
	 * @return mixed
	 */
	function devuelveRut($rut){
		$run = limpiarRut($rut);
		return $run[0];
	}
}

