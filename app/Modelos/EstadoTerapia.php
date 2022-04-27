<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class EstadoTerapia extends Model
{


	protected $table = 'ai_estado_terapia';
	protected $primaryKey = 'est_tera_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'est_tera_nom', 
		'est_tera_des',
		'est_tera_ord',
		'est_tera_ini',
		'est_tera_fin'
	);
	
	public static function getVerificarEstadoTerapia($estado_actual_terapia){

		$result = false;

		$est_tera_fin = DB::select("select est_tera_nom from ai_estado_terapia where est_tera_id='".$estado_actual_terapia."' AND est_tera_fin = 0");
		
		if(count($est_tera_fin) > 0) $result = true;

		return $result;
	}
}
