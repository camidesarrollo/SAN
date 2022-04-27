<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class ObjetivoPaf extends Model
{
	protected $table = 'ai_objetivo_paf';
	protected $primaryKey = 'obj_id';
	public $timestamps = false;
	

	protected $fillable = array(
		'obj_nom',
		'cas_id'
	);
	
	public function caso(){
		return $this->belongsTo('App\Modelos\Caso', 'cas_id','cas_id');
	}

	public function tareas(){
		return $this->hasMany('App\Modelos\TareaObjetivoPaf', 'obj_id','obj_id');
	}

	public static function tarGesPen($cas_id) {
    
    	$tareas = "SELECT
						op.obj_id,
						otp.tar_descripcion,
						otp.tar_id,
						rgc.ai_rgc_id
					  FROM
						ai_objetivo_paf op
					  INNER JOIN
					  	ai_obj_tarea_paf otp on otp.obj_id=op.obj_id
					  LEFT JOIN	
					  	-- ai_reporte_gestion_caso rgc on rgc.ai_rgc_tar_id=otp.tar_id
					  	(select * from
    					ai_reporte_gestion_caso a
						where
    					a.ai_rgc_fec_seg = (select max(ai_rgc_fec_seg) from ai_reporte_gestion_caso b where b.ai_rgc_tar_id = a.ai_rgc_tar_id))  rgc on rgc.ai_rgc_tar_id=otp.tar_id
					  WHERE
					  (otp.est_tar_id='".config('constantes.est_tarea_vigente')."' OR otp.est_tar_id='".config('constantes.est_tarea_en_ejecucion')."') and op.cas_id='".$cas_id."' and (ai_rgc_id is null OR ai_rgc_ter='0')";

		$resultado = DB::select($tareas);

		return $resultado;






		    

    }
	
}
