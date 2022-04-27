<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CasoEstado extends Pivot
{
    //
	protected $table = 'ai_caso_estado_caso';
	
	protected $primaryKey = 'id_cec';
	
	public $timestamps = false;
	
	protected $dates = ['cas_est_cas_fec'];
	
	protected $fillable = array(
		'cas_id',
		'est_cas_id',
		'cas_est_cas_fec',
		'cas_est_cas_des'
	);
}
