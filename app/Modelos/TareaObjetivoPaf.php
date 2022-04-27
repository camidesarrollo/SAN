<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class TareaObjetivoPaf extends Model
{
	protected $table = 'ai_obj_tarea_paf';
	protected $primaryKey = 'tar_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'obj_id',
		'tar_descripcion',
		'tar_plazo',
		'tar_gestor_id',
		'tar_grupfa_id',
		'tar_observacion',
		'tar_fecha_seg',
		'tar_comentario_seg',
		'est_tar_id'
	);
	
	
	public function objetivoPaf(){
		return $this->belongsTo('App\Modelos\ObjetivoPaf', 'obj_id','obj_id');
	}
	
	public function gestor(){
		return $this->belongsTo('App\Modelos\Usuarios', 'tar_gestor_id','id');
	}

	public function grupoFamiliar(){
		return $this->belongsTo('App\Modelos\GrupoFamiliar', 'tar_grupfa_id','gru_fam_id');
	}

	public static function grupFamGesResp($tar_id){
		$sql =  DB::select("SELECT gru_fam_id				
				FROM  AI_OBJ_TAREA_GRUP_FAM_PAF 
				WHERE tar_id='".$tar_id."'");

		$result = [];
		$i=0;

		foreach ($sql  as $value) {

			$result[$i] = $value->gru_fam_id;
			$i++;

		}

		return $result;
	}

	public static function rptObjetivoTareas(){

		$sql = "SELECT 
				    aiop.cas_id, 
				    aibtp.obj_id,
				    aiop.obj_nom,
				    aibtp.tar_id,
				    aibtp.tar_descripcion,
				    aibtp.tar_plazo,
				    aibtp.tar_gestor_id,
				    aibtp.tar_grupfa_id,
				    aibtp.tar_observacion,
				--    TO_NUMBER(TO_CHAR(aibtp.tar_fecha_seg, 'YYYYMMDD')) AS tar_fecha_seg,
				    TO_NUMBER(TO_CHAR(t2.tar_fecha_seg2, 'YYYYMMDD')) AS tar_fecha_seg,
				    aibtp.tar_comentario_seg,
				    CASE WHEN aibtp.est_tar_id=1 THEN 'VIGENTE' 
				             WHEN aibtp.est_tar_id=2 THEN 'EN EJECUCION' 
				             WHEN aibtp.est_tar_id=3 THEN 'FINALIZADA' END AS TAR_ESTADO,
				     TO_NUMBER(TO_CHAR(sysdate, 'YYYYMMDD')) AS FECHA_INSERT,
				     cast(t3.cas_des as varchar2(1000 byte)) as cas_des,
				     t5.com_nom
				from 
				    ALERTA_INFANCIA.ai_obj_tarea_paf aibtp
				    left join ALERTA_INFANCIA.ai_objetivo_paf aiop on aiop.obj_id = aibtp.obj_id
				    LEFT JOIN (SELECT tar_id, MAX(fecha) tar_fecha_seg2 
				                FROM ALERTA_INFANCIA.ai_obj_tar_bit_paf
				                GROUP BY tar_id) t2 ON (t2.tar_id = aibtp.tar_id)  
				    left join ai_caso t3 on (t3.cas_id = aiop.cas_id)
				    left join ai_caso_comuna t4 on (t4.cas_id = t3.cas_id)
				    left join ai_comuna t5 on (t5.com_id = t4.com_id)
				where  aibtp.est_tar_id <> 4";

		$resultado = DB::select($sql);
		
		return $resultado;
	}


}
