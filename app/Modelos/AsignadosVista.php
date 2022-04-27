<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\AsignadosVista
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\AsignadosVista origen($origen)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\AsignadosVista terapeuta()
 * @mixin \Eloquent
 */
class AsignadosVista extends Model
{
    //
	protected $table = 'vw_ai_asignados';
	
	//protected $primaryKey = 'cas_id';
	
	public $timestamps = false;
	
	public function scopeOrigen($query,$origen){
		return $query->where('cas_ori',$origen);
	}
	
	public function scopeTerapeuta($query){
		return $query->where('ter_id',session('id_usuario'));
	}
	
	public function totalManuales(){
		return $this->origen(2)->count();
	}
	
	public function totalPredictivo(){
		return $this->origen(1)->count();
	}
	
	public function totalManualesTerapeuta(){
		return $this->origen(2)->terapeuta()->count();
	}
	
	public function totalPredictivoTerapeuta(){
		return $this->origen(1)->terapeuta()->count();
	}
	
}
