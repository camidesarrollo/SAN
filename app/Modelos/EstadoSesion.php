<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class EstadoSesion extends Model
{
    //
	protected $table = 'ai_estado_sesion';
	protected $primaryKey = 'est_ses_id';
	public $timestamps = false;
	
	protected $appends = ['nombre'];
	
	protected static function boot(){
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('est_ses_ord', 'asc');
		});
	}
	
	public function sesiones(){
		return $this->belongsToMany('App\Modelos\Sesion',
			'ai_sesion_estado_sesion', 'est_ses_id',
			'ses_id', 'est_ses_id','ses_id');
	}

	public function getBitaEstSes($cas_id){
		
		$sql = "SELECT * FROM ai_sesion_estado_sesion order by ses_est_ses_fec desc";
		
		$res = DB::select($sql);
		
		return $res;
	}
	
	public function sesiones_grupales(){
		return $this->belongsToMany('App\Modelos\SesionGrupal',
			'ai_sesion_estado_grupal', 'est_ses_id',
			'gru_id', 'est_ses_id','gru_id');
	}
	
	public function scopePrimero($query){
		return $query->where('est_ses_ini','1');
	}
	
	public function scopeUltimo($query){
		return $query->where('est_ses_fin','1');
	}
	
	public function getPrimero(){
		return $this->primero()->first();
	}
	
	public function getUltimo(){
		return $this->ultimo()->first();
	}
	
	public function getNombreAttribute(){
		return ucwords(strtolower($this->est_ses_nom));
	}
	
	public function getEstSesNomAttribute($value){
		return ucwords(strtolower($value));
	}


	
}
