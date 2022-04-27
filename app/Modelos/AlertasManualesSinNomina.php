<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NNAAlertaManualCaso
 * @package App\Modelos
 */
class AlertasManualesSinNomina extends Model{
	
	protected $table 		= 'vw_ai_alerta_manual_sin_nomina';
	
	public $timestamps		= false;
	
}