<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class EstadoProgramas
 * @package App\Modelos
 */
class EstadoProgramas extends Model{
	
	protected $table 		= 'ai_estados_programas';
	
	protected $primaryKey	= 'est_prog_id';
	
	public $timestamps		= false;

	protected $fillable		= [
		'est_prog_nom',
		'est_prog_desc',
		'est_prog_ini',
		'est_prog_fin',
		'est_prog_ord',
		'est_prog_act'
	];

}