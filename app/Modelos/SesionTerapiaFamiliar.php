<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class SesionTerapiaFamiliar extends Model {
	protected $table		= 'ai_ses_ptf';
	protected $primaryKey	= 'ses_ptf_id';
	protected $fillable		= array('ses_ptf_id','tera_id','ptf_id');

	public $timestamps		= true;

	public static function obtenerSesionesPlanificadasNNA($tera_id = null, $ses_ptf_id = null, $usu_id = null, $est_tera_fin = false){
		$sql = "SELECT sp.ses_ptf_id, sp.tera_id, sp.ptf_id, tp.ptf_objetivo, tp.ptf_actividad, sp.ses_ptf_com, sp.ses_ptf_n_ses, sp.ses_ptf_fec, sp.ses_ptf_hor_ini, sp.ses_ptf_hor_fin, sp.created_at, sp.updated_at, t.est_tera_id, et.est_tera_nom, et.est_tera_back_col FROM ai_ses_ptf sp LEFT JOIN ai_terapia t ON sp.tera_id = t.tera_id LEFT JOIN ai_estado_terapia et ON t.est_tera_id = et.est_tera_id LEFT JOIN ai_terapia_ptf tp ON sp.ptf_id = tp.ptf_id WHERE 1 = 1";

		if (isset($tera_id) && $tera_id != "") $sql .= " AND t.tera_id = ".$tera_id;

		if (isset($ses_ptf_id) && $ses_ptf_id != "") $sql .= " AND sp.ses_ptf_id = ".$ses_ptf_id;

		if (isset($usu_id) && $usu_id != "") $sql .= " AND t.usu_id = ".$usu_id;
		
		if ($est_tera_fin) $sql .= " AND et.est_tera_fin <> 1";

		$respuesta = DB::select($sql);
		return $respuesta;
	}


	public static function obtenerSesionesPlanificadasInformacionNNA($tera_id = null, $ses_ptf_id = null, $usu_id = null, $est_tera_fin = false, $indice = false){
		$sql = "SELECT p.per_run, p.per_dig, p.per_nom ||' '|| p.per_pat ||' '|| p.per_mat AS nombre, sp.ses_ptf_id, sp.tera_id, sp.ptf_id, sp.ses_ptf_com, sp.ses_ptf_n_ses, sp.ses_ptf_fec, sp.ses_ptf_hor_ini, sp.ses_ptf_hor_fin, sp.created_at, sp.updated_at, t.est_tera_id, et.est_tera_nom, et.est_tera_back_col FROM ai_ses_ptf sp LEFT JOIN ai_terapia t ON sp.tera_id = t.tera_id LEFT JOIN ai_estado_terapia et ON t.est_tera_id = et.est_tera_id LEFT JOIN ai_caso_persona_indice cpi ON t.cas_id = cpi.cas_id LEFT JOIN ai_persona p ON cpi.per_id = p.per_id WHERE 1 = 1";

		if (isset($tera_id) && $tera_id != "") $sql .= " AND t.tera_id = ".$tera_id;

		if (isset($ses_ptf_id) && $ses_ptf_id != "") $sql .= " AND sp.ses_ptf_id = ".$ses_ptf_id;

		if (isset($usu_id) && $usu_id != "") $sql .= " AND t.usu_id = ".$usu_id;
		
		if ($est_tera_fin) $sql .= " AND et.est_tera_fin <> 1";

		if ($indice) $sql .= " AND cpi.per_ind = 1";

		$respuesta = DB::select($sql);
		return $respuesta;
	}

	public static function detalleSesionesSegunTipo($tera_id = null, $actividad = 0, $objetivo = 0){
		$sql = "SELECT sp.ses_ptf_id, sp.tera_id, sp.ptf_id, tp.ptf_objetivo, tp.ptf_actividad, sp.ses_ptf_com, sp.ses_ptf_n_ses, sp.ses_ptf_fec, sp.ses_ptf_hor_ini, sp.ses_ptf_hor_fin, sp.created_at, sp.updated_at, t.est_tera_id, et.est_tera_nom, et.est_tera_back_col FROM ai_ses_ptf sp LEFT JOIN ai_terapia t ON sp.tera_id = t.tera_id LEFT JOIN ai_estado_terapia et ON t.est_tera_id = et.est_tera_id LEFT JOIN ai_terapia_ptf tp ON sp.ptf_id = tp.ptf_id WHERE 1 = 1";

		if (isset($tera_id) && $tera_id != "") $sql .= " AND t.tera_id = ".$tera_id;


		switch($actividad){
			case 1: // SESION FAMILIAR
				$sql .= " AND tp.ptf_actividad LIKE '%Sesión Familiar%'";
			break;

			case 2: // TALLER MULTIFAMILIAR
				$sql .= " AND tp.ptf_actividad LIKE '%Taller Multifamiliar%'";
			break;
		}

		switch($objetivo){
			case 1: // ESTABLECER VINCULO TERAPÉUTICO
				$sql .= " AND tp.ptf_objetivo LIKE '%Establecer Vinculo Terapéutico%'";
			break;

			case 2: // Conocer el mundo organizacional de la Familia
				$sql .= " AND tp.ptf_objetivo LIKE '%Conocer el mundo organizacional de la Familia%'";
			break;

			case 3: // Intervenir en el circuito problema
				$sql .= " AND tp.ptf_objetivo LIKE '%Intervenir en el circuito problema%'";
			break;

			case 4: // Visibilizar el cambio
				$sql .= " AND tp.ptf_objetivo LIKE '%Visibilizar el cambio%'";
			break;

			case 5: // Trabajar identidad y pertenencia en la familia
				$sql .= " AND tp.ptf_objetivo LIKE '%Trabajar identidad y pertenencia en la familia%'";
			break;

			case 6: // Trabajar parentalidad y crianza
				$sql .= " AND tp.ptf_objetivo LIKE '%Trabajar parentalidad y crianza%'";
			break;

			case 7: // Trabajar en el desarrollo de habilidades parentales
				$sql .= " AND tp.ptf_objetivo LIKE '%Trabajar en el desarrollo de habilidades parentales%'";
			break;

			case 8: // Trabajar sobre el entorno social y comunitario de la familia
				$sql .= " AND tp.ptf_objetivo LIKE '%Trabajar sobre el entorno social y comunitario de la familia%'";
			break;

			default:
		}

		$respuesta = DB::select($sql);
		return $respuesta;
	}
}