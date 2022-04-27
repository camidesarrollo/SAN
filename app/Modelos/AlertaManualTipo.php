<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AlertaManualTipo
 * @package App\Modelos
 */
class AlertaManualTipo extends Model{
	
	protected $table 		= 'ai_alerta_manual_tipo';
	
	protected $primaryKey	= 'ale_man_id';
	public $timestamps		= false;
	
	protected $fillable		= [
		'ale_man_id',
		'ale_tip_id'
	];
}