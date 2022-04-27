<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tercero extends Model
{
    //
	protected $table = 'ai_tercero';
	protected $primaryKey = 'ter_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'ter_nom',
		'ter_des'
	);
	
	protected static function boot()
	{
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('ter_nom', 'asc');
		});
	}
	
	public function casos()
	{
		return $this->belongsToMany('App\Modelos\Caso', 'ai_caso_tercero', 'ter_id', 'cas_id', 'ter_id','cas_id')
			->withPivot('cas_ter_fec')
			->latest('cas_ter_fec');
	}
	
	public function getTerNomAttribute($value){
		return ucwords(mb_strtolower($value));
	}
	
	public function getTerceroCombo(){
		//all('ter_nom','ter_id')->pluck('ter_nom', 'ter_id')->toArray();
		return $this->all('ter_nom','ter_id')->pluck('ter_nom', 'ter_id')->toArray();
	}
}
