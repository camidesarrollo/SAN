<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Parametro extends Model  {

	protected $table = 'ai_parametro';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected static function boot(){
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('orden', 'asc');
		});
	}

	// scopes
	
	public function scopeActivos($query){
		return $query->where('id_estado',1);
	}
	
	public function scopePadre($query,$padre){
		return $query->where('id_padre',$padre);
	}
	
	public function scopeValores($query){
		return $query->where('valor','>',0);
	}
	
	// metodos
	
	public function getEstados(){
		return $this->activos()->padre(1)->valores()->get();
	}
}
