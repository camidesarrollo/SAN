<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class EstadoTerapiaBitacora extends Model
{



	protected $table = 'ai_est_terapia_bitacora';
	protected $primaryKey = 'id_tet';
	public $timestamps = false;
	
	protected $fillable = array(
		'tera_id', 
		'est_tera_id', 
		'tera_est_tera_fec', 
		'tera_est_tera_des',
		'adj_id' 
	);
	
}
