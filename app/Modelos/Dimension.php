<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Dimension extends Model
{
	protected $table = 'ai_dimension';
	
	protected $primaryKey = 'dim_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
		'dim_nom',
		'dim_des',
		'dim_act'
	);
	
	protected static function boot(){
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('dim_nom', 'asc');
		});
	}
	
	public function getDimNomAttribute($value){
		return ucwords(mb_strtolower($value));
	}
	
	// relaciones
	public function problematicas(){
		return $this->hasMany('App\Modelos\Problematica','dim_id','dim_id');
	}
	
	public function alertas(){
		return $this->hasManyThrough('App\Modelos\Alerta','App\Modelos\Problematica','dim_id', 'pro_id');
	}
	
	// metodos
	public function getConProblematicaByRut($rut){
		return $this->with(
			['alertas' => function ($query) use ($rut){
				$query->run($rut)->with('problematica');
			}]
		)->get();
	}
	
}
