<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class BrechaBitacora extends Model
{

	protected $table = 'ai_brecha_bitacora';
	protected $primaryKey = 'id_brecha_bitacora';
	public $timestamps = false;
	
	protected $fillable = [
		'id_brecha',
		'id_usuario',
		'fecha',
		'comentario'
	];
	
}