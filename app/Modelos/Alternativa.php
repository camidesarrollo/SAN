<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\Alternativa
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modelos\Respuesta[] $respuestas
 * @mixin \Eloquent
 */
class Alternativa extends Model
{
    //
	protected $table = 'ai_alternativa';
	protected $primaryKey = 'alt_id';
	public $timestamps = false;
	
	public function respuestas()
	{
		return $this->hasMany('App\Modelos\Respuesta','alt_id','alt_id');
	}
}
