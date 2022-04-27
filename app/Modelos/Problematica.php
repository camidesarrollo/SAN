<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Problematica extends Model
{
    //
	protected $table = 'ai_problematica';
	protected $primaryKey = 'pro_id';
	public $timestamps = false;
	
	protected static function boot()
	{
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('pro_nom', 'asc');
		});
	}
	
	public function getProNomAttribute($value){
		return ucwords(mb_strtolower($value));
	}
	
	public function dimension()
	{
		return $this->belongsTo('App\Modelos\Dimension', 'dim_id','dim_id');
	}
	
	public function alertas(){
		return $this->hasMany('App\Modelos\Alerta', 'pro_id','pro_id');
	}
	
	public function scopeDimension($query, $dimension)
	{
		return $query->where('dim_id', $dimension);
	}
	
	public function getByDimension($dim_id){
		return $this->when($dim_id ?? false, function ($query, $dim_id){
				return $query->dimension($dim_id);
			})
			->get();
	}
	
}
