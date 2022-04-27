<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CasoPersonaIndice extends Model
{
    //
	protected $table = 'ai_caso_persona_indice';
	
	protected $primaryKey = 'cas_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
		'cas_id',
		'per_id',
		'per_ind',
		'periodo'
	);

	public function estados(){
		return $this->belongsToMany('App\Modelos\EstadoCaso', 'ai_caso_estado_caso', 'cas_id', 'est_cas_id', 'cas_id','est_cas_id')
			->using('App\Modelos\CasoEstado')
			->withPivot('cas_est_cas_fec','cas_est_cas_des')
			->latest('cas_est_cas_fec');
	}

	public function terapeutas(){
		return $this->belongsToMany('App\Modelos\Usuarios', 'ai_caso_terapeuta',
			'cas_id', 'ter_id', 'cas_id','id')
			->using('App\Modelos\CasoTerapeuta');
	}
}
