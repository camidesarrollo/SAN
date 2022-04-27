<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class AmProgramas
 * @package App\Modelos
 */
class GrupFamProgramas extends Model{
	
	protected $table 		= 'ai_grup_fam_programas';
	
	protected $primaryKey	= 'grup_fam_prog_id';
	
	public $timestamps		= false;

	protected $fillable		= [
		'prog_id',
		'gru_fam_id',
		'est_prog_id',
		'estab_id'
	];

}