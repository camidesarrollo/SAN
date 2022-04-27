<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\Adjunto
 *
 * @property-read \App\Modelos\ModalidadVisita $ModalidadVisita
 * @mixin \Eloquent
 */
class ModalidadVisita extends Model{
	protected $table = 'ai_modalidad_visita';
	
	protected $primaryKey = 'mod_visita_id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'mod_visita_nombre'
	];
		
}
