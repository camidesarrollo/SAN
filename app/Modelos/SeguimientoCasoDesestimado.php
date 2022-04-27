<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class SeguimientoCasoDesestimado extends Model
{

	protected $table = 'ai_seguimiento_caso_desest';
	protected $primaryKey = 'seg_cas_des_id';
	public $timestamps = false;
	
	protected $fillable = [
		'prog_seg_cod_proy',
		'prog_seg_nom',
		'tip_prog_seg_cod',
		'tip_prog_seg_nom',
		'est_cas_id',
		'est_cas_nom',
		'objetivo_codigo'
	];
	
}