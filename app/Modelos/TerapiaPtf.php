<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TerapiaPtf extends Model
{
	protected $table = 'ai_terapia_ptf';
	protected $primaryKey = 'ptf_id';
	public $timestamps = false;

	
	protected $fillable = array(
		'ptf_id', 'ptf_numero', 'ptf_actividad', 'ptf_objetivo', 'ptf_meta', 'ptf_orden'
	);

}
