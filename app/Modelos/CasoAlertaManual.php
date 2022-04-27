<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class CasoAlertaManual
 * @package App\Modelos
 */
class CasoAlertaManual extends Model{
	
	protected $table 		= 'ai_caso_alerta_manual';
	
	protected $primaryKey	= 'cas_am_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'cas_am_id',
		'cas_id',
		'ale_man_id'
	];
	
	public function alertaTerritorialPorCaso($caso, $est_ale_ini = false, $est_ale_fin = false){
		$sql = "SELECT * FROM ai_caso_alerta_manual cam
				LEFT JOIN ai_alerta_manual am ON cam.ale_man_id = am.ale_man_id
				LEFT JOIN ai_estado_alerta_manual_estado eame ON am.ale_man_id = eame.ale_man_id
				LEFT JOIN ai_estado_alerta ea ON eame.est_ale_id = ea.est_ale_id
				WHERE cam.cas_id = ".$caso." AND eame.est_ale_man_est_fec = (SELECT MAX(est_ale_man_est_fec) FROM ai_estado_alerta_manual_estado WHERE ale_man_id = am.ale_man_id)";
		
		if ($est_ale_ini) $sql .= " AND ea.est_ale_ini = 1";
		
		if ($est_ale_fin) $sql .= " AND ea.est_ale_fin = 1";
		
		return DB::select($sql);
	}
	
}