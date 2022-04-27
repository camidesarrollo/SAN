<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;


class TransversalController extends Controller{
	
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
	}
	
	public static function authorizeclient()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://wsmds.mideplan.cl/api/auth/authorize-client",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n\t\"grant_type\":\"client_credentials\",\n\t\"client_id\":".env('client_id').",\n\t\"client_secret\":\"".env('client_secret')."\"\n}",
			CURLOPT_HTTPHEADER => array(
			  "cache-control: no-cache",
			  "content-type: application/json",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			$response = json_decode($response);
			
			return $response->access_token;
		}

	}


	public static function getRegiones()
	{
		$curl = curl_init();
		$token = TransversalController::authorizeclient();
		curl_setopt_array($curl, array(
				CURLOPT_URL => "http://wsmds.mideplan.cl/api/ws/sit/regiones/8/67cd6d772b0495027734fbfd5397567d/-1",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$token."",
				"cache-control: no-cache"
				),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response);
		
			if($result->estado == 200){
				return $result->regiones;
			}
		}
	}

	public static function getInstituciones()
	{

		$curl = curl_init();
		$token = TransversalController::authorizeclient();
		curl_setopt_array($curl, array(
				CURLOPT_URL => "http://wsmds.mideplan.cl/api/ws/institucion/16/8785d03380b8b6e3b06abfcefcfbead2/0",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"authorization: Bearer ".$token."",
					"cache-control: no-cache"
				),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			echo "cURL Error #:" . $err;
		}
		else {
			$result = json_decode($response);
			if($result->estado == 200){
				return $result->institucion;
			}
		}
	}


public static function eliminar_simbolos($string){
 
	$string = trim($string);
 
	$string = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		$string
	);
 
	$string = str_replace(
		array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		$string
	);
 
	$string = str_replace(
		array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		$string
	);
 
	$string = str_replace(
		array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		$string
	);
 
	$string = str_replace(
		array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		$string
	);
 
	$string = str_replace(
		array('ñ', 'Ñ', 'ç', 'Ç'),
		array('n', 'N', 'c', 'C',),
		$string
	);
 
	$string = str_replace(
		array("\\", "¨", "º","~",
			 "#", "@", "|", "!", "\"",
			 "·", "$", "%", "&", "/",
			 "(", ")", "?", "'", "¡",
			 "¿", "[", "^", "<code>", "]",
			 "+", "}", "{", "¨", "´",
			 ">", "< ", ";", ",", ":",
			 ".", " "),
		' ',
		$string
	);
return preg_replace('[\s+]','', $string);
}  


 public static function getInstitucionesDummy(){



		  $result = json_decode('{
			  "estado": 200,
			  "mensaje": "Su institución ha sido encontrada.",
			  "institucion": [
				  {
					  "id": "0",
					  "nombre": "SIN INFORMACIÓN",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-09-24 10:56:22",
					  "sigla": "S/I"
				  },
				  {
					  "id": "203",
					  "nombre": "CORPORACIÓN DE ASISTENCIA JUDICIAL BIOBÍO (CAJBIOBIO)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-06-19 12:13:09",
					  "sigla": null
				  },
				  {
					  "id": "200",
					  "nombre": "SUPERINTENDENCIA DE SERVICIOS SANITARIOS",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-05-03 10:34:30",
					  "sigla": null
				  },
				  {
					  "id": "201",
					  "nombre": "SUPERINTENDENCIA DE SERVICIOS SOCIALES (SUSESO)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:36:53",
					  "sigla": null
				  },
				  {
					  "id": "205",
					  "nombre": "CORPORACIÓN DE ASISTENCIA JUDICIAL VALPARAÍSO (CAJVAL)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:20:09",
					  "sigla": null
				  },
				  {
					  "id": "33",
					  "nombre": "SERVICIO DE IMPUESTOS INTERNOS (SII)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:37:29",
					  "sigla": null
				  },
				  {
					  "id": "34",
					  "nombre": "SUPERINTENDENCIA DE SALUD",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "187",
					  "nombre": "SERVICIO DE COOPERACIÓN TÉCNICA (SERCOTEC)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:40:50",
					  "sigla": null
				  },
				  {
					  "id": "188",
					  "nombre": "CORPORACIÓN DE ASISTENCIA JUDICIAL REGIÓN METROPOLITANA (CAJRM)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:19:41",
					  "sigla": null
				  },
				  {
					  "id": "18",
					  "nombre": "MINISTERIO DE MINERÍA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "19",
					  "nombre": "GENDARMERÍA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "20",
					  "nombre": "SERVICIO NACIONAL DE MENORES (SENAME)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:41:39",
					  "sigla": null
				  },
				  {
					  "id": "21",
					  "nombre": "MINISTERIO DEL TRABAJO",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "22",
					  "nombre": "SUBSECRETARÍA DE PREVISIÓN SOCIAL (SPS)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:44:23",
					  "sigla": null
				  },
				  {
					  "id": "23",
					  "nombre": "SUBSECRETARÍA DE JUSTICIA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-10-03 16:38:34",
					  "sigla": null
				  },
				  {
					  "id": "24",
					  "nombre": "DIRECCIÓN DE PRESUPUESTOS (DIPRES)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:21:39",
					  "sigla": null
				  },
				  {
					  "id": "25",
					  "nombre": "SERVICIO DE REGISTRO CIVIL E IDENTIFICACIÓN",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:35:51",
					  "sigla": null
				  },
				  {
					  "id": "26",
					  "nombre": "MINISTERIO DE VIVIENDA Y URBANISMO (MINVU)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:35:24",
					  "sigla": null
				  },
				  {
					  "id": "29",
					  "nombre": "SERVICIOS DE VIVIENDA Y URBANISMO (SERVIU)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:44:00",
					  "sigla": null
				  },
				  {
					  "id": "30",
					  "nombre": "SERVICIO NACIONAL DE LA DISCAPACIDAD (SENADIS)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:39:12",
					  "sigla": null
				  },
				  {
					  "id": "31",
					  "nombre": "SUBSECRETARÍA DE PESCA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "32",
					  "nombre": "SUPERINTENDENCIA DE PENSIONES",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "1",
					  "nombre": "MINISTERIO DE DESARROLLO SOCIAL",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-06-19 12:20:18",
					  "sigla": "MDS"
				  },
				  {
					  "id": "2",
					  "nombre": "INSTITUTO DE PREVISIÓN SOCIAL (IPS)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:25:37",
					  "sigla": null
				  },
				  {
					  "id": "3",
					  "nombre": "FUNDACIÓN INTEGRA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:24:59",
					  "sigla": null
				  },
				  {
					  "id": "4",
					  "nombre": "SUBSECRETARÍA DE INTERIOR",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 17:57:01",
					  "sigla": null
				  },
				  {
					  "id": "5",
					  "nombre": "JUNTA NACIONAL DE AUXILIO ESCOLAR Y BECAS (JUNAEB)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:26:30",
					  "sigla": null
				  },
				  {
					  "id": "6",
					  "nombre": "CORPORACIÓN NACIONAL FORESTAL (CONAF)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:21:05",
					  "sigla": null
				  },
				  {
					  "id": "7",
					  "nombre": "CORPORACIÓN NACIONAL DE DESARROLLO INDÍGENA (CONADI)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:20:37",
					  "sigla": null
				  },
				  {
					  "id": "8",
					  "nombre": "JUNTA NACIONAL DE JARDINES INFANTILES (JUNJI)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:34:37",
					  "sigla": null
				  },
				  {
					  "id": "9",
					  "nombre": "FONDO NACIONAL DE SALUD (FONASA)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:21:57",
					  "sigla": null
				  },
				  {
					  "id": "11",
					  "nombre": "FUNDACIÓN PRODEMU",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:42:14",
					  "sigla": null
				  },
				  {
					  "id": "12",
					  "nombre": "MINISTERIO DE BIENES NACIONALES",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "13",
					  "nombre": "FONDO DE SOLIDARIDAD E INVERSIÓN SOCIAL (FOSIS)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:22:28",
					  "sigla": null
				  },
				  {
					  "id": "14",
					  "nombre": "MINISTERIO DE EDUCACIÓN (MINEDUC)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:35:00",
					  "sigla": null
				  },
				  {
					  "id": "15",
					  "nombre": "SERVICIO NACIONAL DE CAPACITACIÓN Y EMPLEO (SENCE)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:38:03",
					  "sigla": null
				  },
				  {
					  "id": "16",
					  "nombre": "MUNICIPIO",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "17",
					  "nombre": "SERVICIO NACIONAL DEL ADULTO MAYOR (SENAMA)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:41:14",
					  "sigla": null
				  },
				  {
					  "id": "189",
					  "nombre": "SERVICIO NACIONAL DE LA MUJER Y LA EQUIDAD DE GÉNERO (SERNAMEG)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:43:24",
					  "sigla": null
				  },
				  {
					  "id": "190",
					  "nombre": "SUPERINTENDENCIA DE ELECTRICIDAD Y COMBUSTIBLES (SEC)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:39:37",
					  "sigla": null
				  },
				  {
					  "id": "191",
					  "nombre": "INSTITUTO NACIONAL DE LA JUVENTUD (INJUV)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:24:32",
					  "sigla": null
				  },
				  {
					  "id": "192",
					  "nombre": "FUNDACIÓN SUPERACIÓN DE LA POBREZA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:23:02",
					  "sigla": null
				  },
				  {
					  "id": "193",
					  "nombre": "INSTITUTO DE DESARROLLO AGROPECUARIO (INDAP)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:23:51",
					  "sigla": null
				  },
				  {
					  "id": "196",
					  "nombre": "FUNDACIÓN ARTESANÍAS DE CHILE",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:21:22",
					  "sigla": null
				  },
				  {
					  "id": "195",
					  "nombre": "MINISTERIO DE MEDIO AMBIENTE",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "197",
					  "nombre": "AGENCIA DE CALIDAD DE LA EDUCACIÓN",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-06-19 12:19:09",
					  "sigla": null
				  },
				  {
					  "id": "198",
					  "nombre": "PRESIDENCIA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "199",
					  "nombre": "MINISTERIO DE AGRICULTURA",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2016-04-04 10:47:57",
					  "sigla": null
				  },
				  {
					  "id": "202",
					  "nombre": "SUBSECRETARÍA DE TRANSPORTE",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 15:36:11",
					  "sigla": null
				  },
				  {
					  "id": "204",
					  "nombre": "CORPORACIÓN DE ASISTENCIA JUDICIAL TARAPACÁ ANTOFAGASTA (CAJTA)",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2018-03-27 11:19:54",
					  "sigla": null
				  },
				  {
					  "id": "206",
					  "nombre": "MACUL",
					  "id_padre": null,
					  "tipo_registro": null,
					  "estado_fk": "1",
					  "df_fecha_actualizacion": "2017-07-04 11:35:52",
					  "sigla": null
				  }
			  ]
		  }');

		if($result->estado == 200){
		  return $result->institucion;
		}


   }


}