<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class EstadoProgramasBit
 * @package App\Modelos
 */
class EstadoProgramasBit extends Model{
	
	protected $table 		= 'ai_estados_programas_bit';
	protected $primaryKey 	= 'am_prog_id';
	
	public $timestamps		= false;

	protected $fillable		= [
		'am_prog_id',
		'est_prog_id',
		'est_prog_bit_des',
		'est_prog_bit_fec'
	];

}