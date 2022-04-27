<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Provincia extends Model
{
    //
	protected $table = 'ai_provincia';
	protected $primaryKey = 'pro_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'reg_id',
		'pro_nom',
		'pro_cod'
	);
	
	protected static function boot()
	{
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('pro_nom', 'asc');
		});
	}
	
	public function comunas()
	{
		return $this->hasMany('App\Modelos\Comuna','pro_id','pro_id');
	}
	
	public function regiones()
	{
		return $this->belongsTo('App\Modelos\Region', 'reg_id','reg_id');
	}
	
	public function getProNomAttribute(){
		return ucwords(mb_strtolower($this->attributes['pro_nom']));
	}
	
	public function scopeRegion($query,$region){
		return $query->where('reg_id',$region);
	}
	
	public function getByRegion($region){
		return $this->region($region)->get();
	}
}
