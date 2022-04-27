<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
	protected $table = 'ai_rol';
	protected $primaryKey = 'id';
	public $timestamps = false;
	
	protected $fillable = array(
		'nombre',
		'ruta',
		'id_estado'
	);
}
