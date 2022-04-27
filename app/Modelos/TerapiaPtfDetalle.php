<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TerapiaPtfDetalle extends Model
{
	protected $table = 'ai_terapia_ptf_detalle';

	protected $primaryKey	= 'ptf_det_id';

	// public $timestamps = false;

	protected $fillable = array(
		'ptf_det_id',
		'ptf_id',
		'tera_id',
		'ptf_det_estrategia',
		'ptf_det_resultado',
		'ptf_det_observacion',
		'ptf_det_fecha',
		// INICIO CZ SPRINT 69
		'ptf_estado'
		// FIN CZ SPRINT 69
	);
}
