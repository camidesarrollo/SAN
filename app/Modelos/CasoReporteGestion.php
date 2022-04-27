<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class CasoReporteGestion extends Model{
	protected $table = 'ai_caso_reporte_gestion';
	protected $primaryKey = 'cas_id';
	public $timestamps = false;
	
	protected $fillable = [
		'ai_rgc_id'
	];

}