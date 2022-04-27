<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Brecha extends Model
{

	protected $table = 'ai_brecha';
	protected $primaryKey = 'id_brecha';
	public $timestamps = false;
	
	protected $fillable = [
		'id_programa',
		'brecha_mensual',
		'estado',
		'fecha_ingreso',
		'fecha_cierre'
	];
	
}