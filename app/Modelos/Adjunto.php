<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\Adjunto
 *
 * @property-read \App\Modelos\Respuesta $respuesta
 * @mixin \Eloquent
 */
class Adjunto extends Model{
	protected $table = 'ai_adjunto';
	
	protected $primaryKey = 'adj_id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'usu_id',
		'cas_id',
		'adj_mod',
		'adj_nom',
		'adj_cod'
	];
	
	public function respuesta(){
		return $this->belongsTo('App\Modelos\Respuesta','adj_id','adj_id');
	}
	
}
