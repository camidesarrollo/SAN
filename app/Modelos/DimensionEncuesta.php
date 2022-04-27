<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DimensionEncuesta extends Model
{
	protected $table = 'ai_dimension_encuesta';
	
	protected $primaryKey = 'dim_enc_id';
	
	public $timestamps = false;
	
	// relaciones
	public function preguntas(){
		return $this->hasMany('App\Modelos\Pregunta','dim_enc_id','dim_enc_id');
	}
}
