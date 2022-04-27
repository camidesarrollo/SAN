<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class EvaluacionFase extends Model{
	
	protected $table 		= 'ai_evaluacion_fase';
	
	protected $primaryKey	= 'eva_fase_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'eva_fase_id',
		'eva_fase_nom',
		'eva_fase_ord'
	];
	
}