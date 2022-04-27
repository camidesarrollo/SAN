<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class OfertaAlerta
 * @package App\Modelos
 */
class OfertaAlerta extends Model{
	
	protected $table 		= 'ai_ofertas_alerta_tipo';
	
	protected $primaryKey	= 'ofe_id';
	
	public $timestamps		= false;
}