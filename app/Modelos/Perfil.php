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
class Perfil extends Model  {
	
	protected $table = 'ai_perfil';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'nombre',
		'ruta',
		'id_estado',
		'tipo'
	];
	
	protected static function boot(){
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('id', 'asc');
		});
	}
	
	public function usuarios(){
		return $this->hasMany('App\Modelos\Usuarios','id_perfil','id');
	}

	public function MenuPri($id_perfil){
		return DB::select("select * from AI_FUNCION F INNER JOIN AI_FUNCION_PERFIL FP ON F.ID = FP.ID_FUNCION WHERE FP.ID_PERFIL = ".$id_perfil." AND F.id_estado= 1 and tipo=0 and  F.id_padre=0 ORDER BY F.fun_ord");

		// return DB::select("SELECT R.*,(SELECT count(*) FROM AI_ROL_FUNCION WHERE ID_ROL = PR.ID_ROL) as FUNCIONES FROM AI_ROL R INNER JOIN AI_PERFIL_ROL PR on PR.ID_ROL = R.ID WHERE R.ID_ESTADO = 1 AND PR.ID_PERFIL = ".$id_perfil." ORDER BY R.ORDEN");
	}

	public function funciones($id_perfil){
		return DB::select("select * from AI_FUNCION F INNER JOIN AI_FUNCION_PERFIL FP ON F.ID = FP.ID_FUNCION WHERE FP.ID_PERFIL = ".$id_perfil." AND F.id_estado= 1 and F.tipo=0 and F.id_padre>0 ORDER BY F.fun_ord");
		// return DB::select("SELECT R.ID AS ID_ROL,R.NOMBRE AS NOMBRE_ROL, R.RUTA AS RUTA_ROL,
		// 	F.ID AS ID_FUNCION,F.NOMBRE AS NOMBRE_FUNCION, F.RUTA AS RUTA_FUNCION FROM AI_ROL R INNER JOIN AI_PERFIL_ROL PR on PR.ID_ROL = R.ID INNER JOIN AI_ROL_FUNCION RF on RF.ID_ROL = PR.ID_ROL INNER JOIN AI_FUNCION F on F.ID = RF.ID_FUNCION WHERE F.ID_ESTADO = 1 AND R.ID_ESTADO = 1 AND PR.ID_PERFIL = ".$id_perfil." ORDER BY R.ORDEN, F.FUN_ORD");
	}

	//correccion Andres 
	public function acciones(){
		return DB::select("select * from ai_funcion INNER JOIN ai_funcion_perfil on ai_funcion.id = ai_funcion_perfil.id_funcion and ai_funcion_perfil.id_perfil=".Session::get('perfil')." order By FUN_ORD asc");
	}
	//Correccion Andres

	// scopes
	
	public function scopeActivos($query){
		return $query->where('id_estado',1);
	}
	
	public function getActivos(){
		return $this->activos()->get();
	}

	public function permisos($id_perfil, $cod_accion){
		$sql = "SELECT id, nombre, ruta, id_estado, fun_ord, tipo, id_padre, cod_accion, clase FROM ai_funcion f LEFT JOIN ai_funcion_perfil fp ON f.id = fp.id_funcion WHERE fp.id_perfil = ".$id_perfil." AND f.cod_accion = '".$cod_accion."' AND f.tipo = 2 ORDER BY fun_ord ASC";

		return DB::select($sql);
	}
}
