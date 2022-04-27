<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class BitacoraEstadoSeguimiento extends Model
{
	protected $table = 'ai_bitacora_estado_segu';
	protected $primaryKey = 'bit_est_seg';
	//public $timestamps = false;
	
	protected $fillable = array(
		//'per_id',
		'fecha',
		'comentario',
		'm_contacto_codigo'

	);
	

}
