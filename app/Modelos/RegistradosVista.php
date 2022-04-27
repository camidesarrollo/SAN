<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class RegistradosVista extends Model
{
	protected $table = 'vw_ai_registrados';
	
	//protected $primaryKey = 'cas_id';
	
	public $timestamps = false;
	
	public function scopeOrigen($query,$origen){
		return $query->where('origen',$origen);
	}
	
	public function totalManuales(){
		return $this->origen('Manual')->count();
	}
	
	public function totalPredictivo(){
		return $this->origen('Predictivo')->count();
	}
}
