<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class BrechaIntegrante extends Model
{

	protected $table = 'ai_brecha_integrante_caso';
	protected $primaryKey = 'id_brecha_inte_caso';
	public $timestamps = false;
	
	protected $fillable = [
		'id_brecha', 
		'id_caso',
		'id_usuario',
		'id_integrante',
		'id_alerta_territorial',
		'estado',
		'fecha',
		'comentario'
	];
	
}