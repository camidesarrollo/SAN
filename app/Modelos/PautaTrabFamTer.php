<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class PautaTrabFamTer extends Model{
	
	protected $table 		= 'AI_PAU_TRAB_FAM_TER';
	
	protected $primaryKey	= 'PAU_TRAB_FAM_TER_ID';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'PAU_TRAB_FAM_TER_ID',
		'TERA_ID',
		'TRAB_FAM_TER_PREG_1',
		'TRAB_FAM_TER_PREG_2',
		'TRAB_FAM_TER_PREG_3',
		'TRAB_FAM_TER_PREG_4',
		'TRAB_FAM_TER_PREG_5',
		'TRAB_FAM_TER_PREG_6',
		'TRAB_FAM_TER_PREG_7',
		'TRAB_FAM_TER_PREG_8',
		'TRAB_FAM_TER_PREG_9',
		'TRAB_FAM_TER_PREG_10',
		'TRAB_FAM_TER_PREG_11'
	];
	
}