<?php
/**
 * Created by PhpStorm.
 * User: jmarquez
 * Date: 26-10-2018
 * Time: 15:08
 */

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Session;

class Funcion extends Model  {
	
	protected $table = 'ai_funcion';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
			'ID',
			'NOMBRE',
			'RUTA',
			'ID_ESTADO',
			'FUN_ORD',
			'TIPO',
			'ID_PADRE',
			'COD_ACCION',
			'CLASE'
	];

	public static function iconos($id){

		$icono = DB::select("select clase from ai_funcion where id='".$id."'");

		return $icono[0]->clase;
	}

	public static function nombre_menu($id){

		$nombre = DB::select("select nombre from ai_funcion where id='".$id."'");

		return $nombre[0]->nombre;
	}

	public static function obtener_permiso_funcion($perfil, $cod_accion){
		$sql ="SELECT id, nombre, ruta, id_estado, fun_ord, tipo, id_padre, cod_accion, clase FROM ai_funcion f LEFT JOIN ai_funcion_perfil fp ON f.id = fp.id_funcion WHERE fp.id_perfil = ".$perfil." AND f.cod_accion = '".$cod_accion."'";

		$resultado = DB::select($sql);
		return $resultado;

	}
	
}
