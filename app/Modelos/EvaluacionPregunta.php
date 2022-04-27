<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class EvaluacionPregunta extends Model{
	
	protected $table 		= 'ai_evaluacion_pregunta';
	
	protected $primaryKey	= 'eva_pre_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'eva_pre_id',
		'eva_pre_nom',
		'eva_pre_ord',
		'eva_pre_tip',
		'eva_dim_id'
	];
	
}