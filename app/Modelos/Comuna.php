<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Comuna extends Model
{
    //
	protected $table = 'ai_comuna';
	protected $primaryKey = 'com_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'pro_id',
		'com_nom',
		'com_cod'
	);
	
	protected static function boot()
	{
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('com_nom', 'asc');
		});
	}
	
	public function provincias(){
		return $this->belongsTo('App\Modelos\Provincia', 'pro_id','pro_id');
	}
	
	public function getComNomAttribute(){
		return ucwords(mb_strtolower($this->attributes['com_nom']));
	}
	
	public function scopeProvincia($query, $provincia){
		return $query->where('pro_id',$provincia);
	}
	
	public function getByProvincia($provincia){
		return $this->provincia($provincia)->get();
	}
}
