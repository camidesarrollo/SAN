<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class Accion extends Model{
	
	protected $table 		= 'ai_acciones';
	
	protected $primaryKey	= 'acc_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'acc_id',
		'acc_nom',
		'acc_des',
		'acc_acc'
	];
	
}