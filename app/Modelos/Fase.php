<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    //
	protected $table = 'ai_fase';
	protected $primaryKey = 'fas_id';
	public $timestamps = false;
	
	public function respuestas()
	{
		return $this->hasMany('App\Modelos\Respuesta','fas_id','fas_id');
	}
	
	
}
