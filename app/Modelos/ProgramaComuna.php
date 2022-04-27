<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Programa
 * @package App\Modelos
 */
class ProgramaComuna extends Model{
	
	protected $table 		= 'ai_pro_com';
	
	protected $primaryKey	= 'prog_id';
	
	public $timestamps		= false;
	
}