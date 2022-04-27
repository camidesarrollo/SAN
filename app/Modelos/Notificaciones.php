<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notificaciones
 * @package App\Modelos
 */
class Notificaciones extends Model{
	
	protected $table 		= 'ai_notificaciones';
	
	protected $primaryKey	= 'not_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'usu_id',
		'not_des',
		'not_fec',
		'not_est',
		'per_id',
		'not_mod'
	];
	
}