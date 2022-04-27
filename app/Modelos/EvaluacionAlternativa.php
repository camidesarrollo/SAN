<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class EvaluacionAlternativa extends Model{
	
	protected $table 		= 'ai_evaluacion_alternativa';
	
	protected $primaryKey	= 'eva_alt_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'eva_alt_id',
		'eva_alt_nom',
		'eva_alt_val',
		'eva_alt_ord'
	];
	
}