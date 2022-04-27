<?php

namespace App\Modelos;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\Alerta
 *
 * @property-read \App\Modelos\Problematica $problematica
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta problematica($problematica)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta run($run)
 * @mixin \Eloquent
 */
class GrupoFamiliar extends Model
{
	protected $table = 'ai_grupo_familiar';
	protected $primaryKey = 'gru_fam_id';
	public $timestamps = false;
	
	protected $fillable = [
		'gru_fam_id',
		'gru_fam_nom',
		'gru_fam_ape_pat',
		'gru_fam_ape_mat',
		'gru_fam_run',
		'gru_fam_dv',
		'gru_fam_nac',
		'gru_fam_par',
		'gru_fam_est',
		'gru_fam_sex',
		'gru_fam_telefono',
		'gru_fam_email',
		'gru_fam_fue',
		'gru_fam_fec_cre'

	];
	
	public function listarCasoActualIntegrante($run){
		$sql = "SELECT * FROM (SELECT DISTINCT(c.cas_id), gf.gru_fam_id, gf.gru_fam_run, gf.gru_fam_dv, c.est_cas_id, cec.cas_est_cas_fec FROM ai_grupo_familiar gf
				LEFT JOIN ai_caso_grupo_familiar cgf ON gf.gru_fam_id = cgf.gru_fam_id
				LEFT JOIN ai_caso c ON cgf.cas_id = c.cas_id
				LEFT JOIN ai_caso_estado_caso cec ON c.est_cas_id = cec.est_cas_id
				LEFT JOIN ai_estado_caso ec ON cec.est_cas_id = ec.est_cas_id
				WHERE gf.gru_fam_run = '".$run."' AND gf.gru_fam_est = 1 AND ec.est_cas_fin = 0 ORDER BY cec.cas_est_cas_fec DESC)
				WHERE rownum = 1";
		
		return DB::select($sql);
	}
}