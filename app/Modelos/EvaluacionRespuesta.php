<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Accion
 * @package App\Modelos
 */
class EvaluacionRespuesta extends Model{
	
	protected $table 		= 'ai_evaluacion_respuesta';
	
	protected $primaryKey	= 'eva_res_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'eva_res_id',
		'tera_id',
		'eva_fase_id',
		'eva_pre_id',
		'eva_alt_id',
		'eva_res_fec',
	];

	public static function rptRespuestasEvaluacionTF(){

		$sql = "SELECT
			    t2.cas_id caso_id,
			    t1.tera_id terapia_id,
			    t4.com_nom OLN,
			    t9.nombres||' '||t9.apellido_paterno||' '||t9.apellido_materno nombre_terapeuta,
			    t5.eva_fase_id fase_id,
			    t5.eva_fase_nom fase_nombre,
			    t8.eva_dim_id dimension_id,
			    t8.eva_dim_nom dimension_nombre,
			    t6.eva_pre_id pregunta_id,
			    t6.eva_pre_nom pregunta_nombre,
			    t1.eva_res_fec fecha_respuesta,
			    t7.eva_alt_val alternativa_valor,
			    t1.eva_res_alt_com prob_a_trabajar
			from
			    ai_evaluacion_respuesta t1
			    Left join ai_terapia t2 on t2.tera_id = t1.tera_id
			    left join ai_caso_comuna t3 on t3.cas_id = t2.cas_id
			    left join ai_comuna t4 on t4.com_id = t3.com_id 
			    left join ai_evaluacion_fase t5 on t5.eva_fase_id = t1.eva_fase_id 
			    left join ai_evaluacion_pregunta t6 on t6.eva_pre_id = t1.eva_pre_id
			    left join ai_evaluacion_alternativa t7 on t7.eva_alt_id = t1.eva_alt_id
			    left join ai_evaluacion_dimension t8 on t8.eva_dim_id = t6.eva_dim_id 
			    left join ai_usuario t9 on t9.id = t2.usu_id
			order by t2.cas_id,t5.eva_fase_id, t8.eva_dim_ord, t6.eva_pre_ord";

		$resultado = DB::select($sql);

		return $resultado;

	}
	
}