<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OfertaComuna
 * @package App\Modelos
 */
class OfertaComuna extends Model{
	
	protected $table 		= 'ai_ofertas_comuna';
	
	protected $primaryKey	= 'ofe_com_id';
	
	public $timestamps		= false;
	
	
}