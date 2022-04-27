<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TerapiaSeguimientoModalidad extends Model
{

	protected $table = 'ai_terapia_ptf_seg_modalidad';
	protected $primaryKey = 'ptf_mod_id';
	public $timestamps = false;
	
	protected $fillable = [
		'ptf_mod_fecha', 
		'ptf_mod_nombre', 
		'ptf_mod_descripcion'
	];

	
}
