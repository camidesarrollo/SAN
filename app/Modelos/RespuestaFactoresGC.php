<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class RespuestaFactoresGC extends Model{
	
	protected $table 		= 'ai_respuestas_factores_gc';
	
	protected $primaryKey	= 're_fa_gc_id';
	
	public $timestamps		= true;
	
	protected $fillable		= [
		're_fa_gc_id',
		'pro_an_id',
		'usu_id',
		'fac_gc_id',
		're_fa_gc_des'
	];
	
}