<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AlertaManualTipo
 * @package App\Modelos
 */
class AlertaManualContacto extends Model{
	
	protected $table 		= 'ai_alerta_manual_contactos';
	
	protected $primaryKey	= 'ai_ale_man_con_id';
	public $timestamps		= false;
	
	protected $fillable		= [
		'AI_ALE_MAN_CON_NOM',
		'AI_ALE_MAN_CON_PARENT',
		'AI_ALE_MAN_CON_FON',
		'AI_ALE_MAN_CON_DIR',
		'AI_ALE_MAN_ID'
	];
}

				
