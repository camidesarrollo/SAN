<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaOfertaComuna
 * @package App\Modelos
 */
class CategoriaOfertaComuna extends Model{
	
	protected $table 		= 'ai_categoria_ofertas_comuna';
	
	protected $primaryKey	= 'ofe_com_id';
	
	public $timestamps		= false;
	
	
}