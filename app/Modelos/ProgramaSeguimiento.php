<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

/**
 * Class Programa
 * @package App\Modelos
 */
class ProgramaSeguimiento extends Model{
	
	protected $table 		= 'ai_programa_seguimiento';
	
	protected $primaryKey	= 'pro_seg_cod_proy';
	
	public $timestamps		= false;
	
	/**
	 * Validar Método
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
		

}