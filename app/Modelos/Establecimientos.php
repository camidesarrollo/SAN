<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Establecimientos
 * @package App\Modelos
 */
class Establecimientos extends Model{
	
	protected $table 		= 'ai_establecimientos';
	
	protected $primaryKey	= 'estab_id';
	
	public $timestamps		= true;

	protected $fillable		= [
		'estab_nom',
		'estab_dir',
		'estab_ref',
		'estab_usu_resp',
		'ofe_id',
		'prog_id'
	];

}