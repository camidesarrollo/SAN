<?php

namespace App\Modelos;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class ParentescoGrupoFamiliar extends Model{
    //
	protected $table = 'ai_parentesco_grupo_familiar';
	protected $primaryKey = 'par_gru_fam_id';
	//public $timestamps = false;
	
	protected $fillable = [
		'par_gru_fam_id',
		'par_gru_fam_cod',
		'par_gru_fam_nom',
		'par_gru_fam_des'
	];
}