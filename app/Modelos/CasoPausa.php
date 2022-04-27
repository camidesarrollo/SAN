<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CasoPausa extends Model
{
	protected $table = 'ai_caso_bit_pau';
	
	//protected $primaryKey = 'con_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
	'cas_id',
	'usu_id',
	'estado',
	'comentario',
	'fec_ing'
	);
}
