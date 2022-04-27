<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class EstadoProgramasBit
 * @package App\Modelos
 */
class EstadoGfamProgramasBit extends Model{
	
	protected $table 		= 'ai_estados_gfam_programas_bit';
	protected $primaryKey 	= 'grup_fam_prog_id';
	
	public $timestamps		= false;

	protected $fillable		= [
		'est_prog_id',
		'est_prog_bit_des',
		'est_prog_bit_fec'
	];

}