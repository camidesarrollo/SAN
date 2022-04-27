<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoAlerta
 * @package App\Modelos
 */
class EstadoAlerta extends Model{
	
	protected $table 		= 'ai_estado_alerta';
	protected $primaryKey	= 'est_ale_id';
	public $timestamps		= false;
	
	protected $fillable		= [
		'est_ale_id',
		'est_ale_nom',
		'est_ale_des',
		'est_ale_ini',
		'est_ale_fin',
		'est_ale_ord'
	];
	
}