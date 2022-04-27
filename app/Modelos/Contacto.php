<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
	protected $table = 'ai_contacto';
	
	protected $primaryKey = 'con_id';
	
	//public $timestamps = false;
	
	protected $fillable = array(
		'con_nom',
		'con_pat',
		'con_mat',
		'con_con',
		'per_id',
		'con_tlf',
		'con_ori',
		'con_par',
		'updated_at'

	);
}
