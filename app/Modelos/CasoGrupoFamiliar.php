<?php

namespace App\Modelos;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class CasoGrupoFamiliar extends Model{
    //
	protected $table = 'ai_caso_grupo_familiar';
	protected $primaryKey = 'gru_fam_id';
	public $timestamps = false;
	
	protected $fillable = [
		'cas_id',
		'gru_fam_id'
	];
	
	public function listarGrupoFamiliar($cas_id = null, $gru_fam_id = null, $gru_fam_est = null, $gru_fam_run = null){
		
		$sql = "SELECT * FROM ai_caso_grupo_familiar cgf LEFT JOIN ai_grupo_familiar gf ON cgf.gru_fam_id = gf.gru_fam_id
				LEFT JOIN ai_parentesco_grupo_familiar pgf ON gf.gru_fam_par = pgf.par_gru_fam_id WHERE 1 = 1";
		
		if (isset($cas_id) && $cas_id != "") $sql .= " AND cgf.cas_id = ".$cas_id;
		
		if (isset($gru_fam_id) && $gru_fam_id != "") $sql .= " AND cgf.gru_fam_id = ".$gru_fam_id;
		
		if (isset($gru_fam_est) && $gru_fam_est != "") $sql .= " AND gf.gru_fam_est = ".$gru_fam_est;
		
		if (isset($gru_fam_run) && $gru_fam_run != "") $sql .= " AND gf.gru_fam_run = ".$gru_fam_run;

		$sql .=" order by gru_fam_est desc";
		
		$respuesta = DB::select($sql);
		
		return $respuesta;
	}

	public static function rptIntegrantesGfamiliar(){

		$sql = "SELECT 
				aicgf.cas_id as Caso_Id,
				aigf.GRU_FAM_RUN as integr_RUT,
				aigf.GRU_FAM_DV as integr_DV,
				aigf.gru_fam_nom||' '||aigf.gru_fam_ape_pat||' '||aigf.gru_fam_ape_mat as integr_nombre,
				aigf.GRU_FAM_PAR as parentesco_id,
				aipgf.par_gru_fam_nom as parentesco_con_JH,
				aigf.GRU_FAM_EST as integr_estado,
				CASE aigf.gru_fam_est WHEN 1 THEN 'VIGENTE' WHEN 0 THEN 'NO VIGENTE' END as Vigencia,
				aigf.GRU_FAM_NAC as integr_fnac,
				FLOOR(months_between(sysdate,aigf.GRU_FAM_NAC)/12) as integr_edad, 
				Case aigf.GRU_FAM_SEX when 1 then 'Masculino' when 2 then 'Femenino' end as integr_genero,
				(select 
					per_ind 
				from 
					ai_caso_persona_indice aicpi
					left join ai_persona aip on aip.per_id = aicpi.per_id
				where 
				cas_id = aicgf.cas_id
				and per_run = gru_fam_run) as nna_indice
				from 
					ai_caso_grupo_familiar aicgf
					left join ai_grupo_familiar aigf on aigf.gru_fam_id = aicgf.gru_fam_id
					left join ai_parentesco_grupo_familiar aipgf on aipgf.par_gru_fam_id = aigf.gru_fam_par
				order by cas_id, aigf.gru_fam_par";

		$resultado = DB::select($sql);

		return $resultado;

	}
}