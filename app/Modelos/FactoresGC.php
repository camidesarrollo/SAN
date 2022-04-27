<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class FactoresGC extends Model{
	
	protected $table 		= 'ai_factores_gc';
	
	protected $primaryKey	= 'fac_gc_id';

	public $timestamps		= false;
	
	protected $fillable		= [
		'fac_gc_id',
		'fac_gc_nom',
		'fac_gc_tip',
		'fac_gc_act',
		'fac_gc_ord'
	];
}