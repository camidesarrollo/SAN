<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Programa
 * @package App\Modelos
 */
class EstablecimientoComuna extends Model{
	
	protected $table 		= 'ai_establecimiento_comuna';
	
	protected $primaryKey	= 'estab_id';
	
	public $timestamps		= false;
	
}