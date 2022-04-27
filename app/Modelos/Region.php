<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Region extends Model
{
    //
	protected $table = 'ai_region';
	protected $primaryKey = 'reg_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'reg_nom',
		'reg_cod'
	);
	
	protected static function boot()
	{
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('reg_nom', 'asc');
		});
	}
	
	public function provincias()
	{
		return $this->hasMany('App\Modelos\Provincia','reg_id','reg_id');
	}
	
	public function comunas()
	{
		return $this->hasManyThrough('App\Modelos\Comuna', 'App\Modelos\Provincia','reg_id','pro_id');
	}
	
	public function getRegNomAttribute(){
		return ucwords(mb_strtolower($this->attributes['reg_nom']));
	}
}
