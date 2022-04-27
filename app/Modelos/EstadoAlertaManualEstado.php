<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoAlerta
 * @package App\Modelos
 */
class EstadoAlertaManualEstado extends Model{
	
	protected $table 		= 'ai_estado_alerta_manual_estado';
	protected $primaryKey	= 'est_ale_id';
	public $timestamps		= false;
	
	protected $fillable		= [
		'est_ale_id',
		'ale_man_id',
		'est_ale_man_est_fec',
		'ale_just_est'
	];
	
}