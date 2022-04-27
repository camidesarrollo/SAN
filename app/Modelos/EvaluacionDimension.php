<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class EvaluacionDimension extends Model{
	
	protected $table 		= 'ai_evaluacion_dimension';
	
	protected $primaryKey	= 'eva_dim_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'eva_dim_id',
		'eva_dim_nom',
		'eva_dim_ord',
		'eva_dim_not'
	];
	
}