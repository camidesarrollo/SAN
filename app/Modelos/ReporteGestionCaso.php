<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;


class ReporteGestionCaso extends Model
{
	protected $table = 'ai_reporte_gestion_caso';
	protected $primaryKey = 'ai_rgc_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'ai_rgc_n_rep',
		'ai_rgc_fec_seg',
		'ai_rgc_tip_rep',
		'ai_rgc_avan',
		'ai_rgc_des',
		'ai_rgc_nue_acc',
		'ai_rgc_raz',
		'ai_rgc_mod',
		'ai_rgc_na_rp_seg',
		'ai_rgc_prog_id',
		'ai_rgc_tar_id',
		'ai_rgc_ale_man_id'
	);

	// public static function getCasoRepGes($cas_id){
	public static function listarReportesPorCaso($cas_id){
		$respuesta = array();
		$total_reportes = 0;
		if (isset($cas_id) && $cas_id != ""){
			$sql_1 = DB::select("SELECT COUNT(aicg.ai_rgc_id) AS total_reportes FROM ai_caso_reporte_gestion aicg INNER JOIN ai_reporte_gestion_caso airgc ON airgc.ai_rgc_id = aicg.ai_rgc_id WHERE aicg.cas_id = ".$cas_id);	
			if (count($sql_1) > 0) $total_reportes = $sql_1[0]->total_reportes;
		
			if ($total_reportes > 0){
				for ($i = 1; $i <= $total_reportes; $i++){
					// INICIO CZ SPRINT 59
					$sql_2 = DB::select("SELECT obs.ai_rgc_des AS observacion, airgc.ai_rgc_id, airgc.ai_rgc_n_rep, airgc.ai_rgc_fec_seg, airgc.ai_rgc_tip_rep, CASE airgc.ai_rgc_tip_rep WHEN 1 THEN 'Derivaciones' WHEN 2 THEN 'Tareas' ELSE 'Observaciones' END AS tipo_rep_nom, airgc.ai_rgc_des, airgc.ai_rgc_nue_acc, CASE WHEN airgc.ai_rgc_nue_acc IS NULL THEN 'Sin información' ELSE airgc.ai_rgc_nue_acc END AS pasos_a_seguir, decode( airgc.ai_rgc_mod,0,'Revisión de plataforma',1,'Revisión de plataforma y llamados telefónicos','2','Visita al domicilio','3','Llamado telefónico','') ai_rgc_mod, airgc.ai_rgc_prog_id, airgc.ai_rgc_tar_id, airgc.ai_rgc_ale_man_id, airgc.ai_rgc_fec_ing FROM ai_caso_reporte_gestion aicg INNER JOIN ai_reporte_gestion_caso airgc ON airgc.ai_rgc_id = aicg.ai_rgc_id 
						LEFT JOIN (SELECT ai_rgc_des, airgc.ai_rgc_tip_rep, airgc.ai_rgc_n_rep FROM ai_caso_reporte_gestion aicrg LEFT JOIN ai_reporte_gestion_caso airgc ON airgc.ai_rgc_id = aicrg.ai_rgc_id WHERE aicrg.cas_id ='".$cas_id."' and ai_rgc_tip_rep='4') obs ON obs.ai_rgc_n_rep = airgc.ai_rgc_n_rep
						WHERE cas_id = ".$cas_id." AND airgc.ai_rgc_n_rep = ".$i." AND airgc.AI_RGC_TIP_REP IN (0,1,2) ORDER BY airgc.ai_rgc_n_rep asc , airgc.ai_rgc_tip_rep asc, airgc.ai_rgc_fec_ing asc");
					// FIN CZ SPRINT 59
					if (count($sql_2) == 0){
						// INICIO CZ SPRINT 59
						$sql_3 = DB::select("SELECT obs.ai_rgc_des AS observacion, airgc.ai_rgc_id, airgc.ai_rgc_n_rep, airgc.ai_rgc_fec_seg, airgc.ai_rgc_tip_rep, CASE airgc.ai_rgc_tip_rep WHEN 1 THEN 'Derivaciones' WHEN 2 THEN 'Tareas' ELSE 'Observaciones' END AS tipo_rep_nom, airgc.ai_rgc_des, airgc.ai_rgc_nue_acc, CASE WHEN airgc.ai_rgc_nue_acc IS NULL THEN 'Sin información' ELSE airgc.ai_rgc_nue_acc END AS pasos_a_seguir, decode( airgc.ai_rgc_mod,0,'Revisión de plataforma',1,'Revisión de plataforma y llamados telefónicos','2','Visita al domicilio','3','Llamado telefónico','') ai_rgc_mod, airgc.ai_rgc_prog_id, airgc.ai_rgc_tar_id, airgc.ai_rgc_ale_man_id, airgc.ai_rgc_fec_ing FROM ai_caso_reporte_gestion aicg INNER JOIN ai_reporte_gestion_caso airgc ON airgc.ai_rgc_id = aicg.ai_rgc_id 
						LEFT JOIN (SELECT ai_rgc_des, airgc.ai_rgc_tip_rep, airgc.ai_rgc_n_rep FROM ai_caso_reporte_gestion aicrg LEFT JOIN ai_reporte_gestion_caso airgc ON airgc.ai_rgc_id = aicrg.ai_rgc_id WHERE aicrg.cas_id ='".$cas_id."' and ai_rgc_tip_rep='4') obs ON obs.ai_rgc_n_rep = airgc.ai_rgc_n_rep
						WHERE cas_id = ".$cas_id." AND airgc.ai_rgc_n_rep = ".$i." AND airgc.AI_RGC_TIP_REP IN (4) ORDER BY airgc.ai_rgc_n_rep asc , airgc.ai_rgc_tip_rep asc, airgc.ai_rgc_fec_ing asc");
						// FIN CZ SPRINT 59
						if (count($sql_3) > 0) array_push($respuesta, $sql_3[0]);					
					}else{
					   foreach ($sql_2 as $k0 => $v0){
						 array_push($respuesta, $v0);
					   }	
					
					}
				}
			}
		}

 			return $respuesta;
	}
	
}