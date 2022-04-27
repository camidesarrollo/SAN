<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class ProgramaAlerta
 * @package App\Modelos
 */
class ProgramaAlerta extends Model{
	
	protected $table 		= 'ai_programa_alerta_tipo';
	
	public $timestamps		= false;
}