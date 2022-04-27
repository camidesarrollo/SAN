<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class AmProgramas
 * @package App\Modelos
 */
class AmProgramas extends Model{
	
	protected $table 		= 'ai_am_programas';
	
	protected $primaryKey	= 'am_prog_id';
	
	//public $timestamps		= false;

	protected $fillable		= [
		'prog_id',
		'ale_man_id',
		'gru_fam_id',
		'est_prog_id',
		'estab_id',
		'ale_tip_id'
	];

}