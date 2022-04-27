<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TerapiaSeguimientoDetalle extends Model
{

	protected $table = 'ai_tera_ptf_seguimiento';
	protected $primaryKey = 'ptf_seg_id';
	public $timestamps = false;
	
	protected $fillable = [
		'tera_id', 
		'ptf_seg_fecha', 
		'ptf_mod_id',
		'ptf_seg_recursos',
		'ptf_seg_redes',
		'ptf_seg_riesgo',
		'ptf_seg_observacion'
	];

	
}	 