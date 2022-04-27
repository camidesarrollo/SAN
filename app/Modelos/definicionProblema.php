<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class definicionProblema extends Model{
	
	protected $table 		= 'ai_def_pro';
	
	protected $primaryKey	= 'def_pro_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'def_pro_id',
		'tera_id',
		'def_pro_preg_1',
		'def_pro_preg_2',
		'def_pro_preg_3',
		'def_pro_preg_4',
		'def_pro_preg_5',
		'def_pro_preg_6',
		'def_pro_preg_7',
		'def_pro_preg_8'
	];
	
}