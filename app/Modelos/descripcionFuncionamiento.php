<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class descripcionFuncionamiento extends Model{
	
	protected $table 		= 'ai_des_fun';
	
	protected $primaryKey	= 'des_fun_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'des_fun_id',
		'tera_id',
		'des_fun_geno',
		'des_fun_preg_2',
		'des_fun_preg_3',
		'des_fun_preg_4',
		'des_fun_preg_5'
	];
	
}