<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class SesionTarea extends Model
{
	protected $table = 'ai_sesion_tarea';
	protected $primaryKey = 'id_sesion_tarea';
	public $timestamps = false;
	
	protected $fillable = [
		'tar_id',
		'fecha',
		'comentario',
		'id_usuario'
	];
}
