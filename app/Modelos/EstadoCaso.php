<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class EstadoCaso extends Model
{
	protected $table = 'ai_estado_caso';
	protected $primaryKey = 'est_cas_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'est_cas_nom',
		'est_cas_des',
		'est_cas_ord',
		'est_cas_ini',
		'est_cas_fin'
	);
	
	protected static function boot()
	{
		parent::boot();
		
		// Order by name ASC
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('est_cas_ord', 'asc');
		});
	}
	
	//relaciones
	public function casos(){
		return $this->belongsToMany('App\Modelos\Caso', 'ai_caso_estado_caso', 'est_cas_id', 'cas_id', 'est_cas_id','cas_id');
	}
	
	// scopes
	public function scopeRegistrado($query)
	{
		return $query->whereRaw( 'lower(est_cas_nom) like ?', array( '%registrado%' ) );
	}
	
	public function scopeVerificado($query)
	{
		return $query->whereRaw( 'lower(est_cas_nom) like ?', array( '%verificado%' ) );
	}
	
	public function scopeAsignado($query)
	{
		return $query->whereRaw( 'lower(est_cas_nom) like ?', array( '%asignado%' ) );
	}
	
	public function scopePlanificado($query)
	{
		return $query->whereRaw( 'lower(est_cas_nom) like ?', array( '%planificado%' ) );
	}
	
	public function scopeDerivado($query)
	{
		return $query->whereRaw( 'lower(est_cas_nom) like ?', array( '%derivado%' ) );
	}
	
	public function scopePrimero($query){
		return $query->where('est_cas_ini',1);
	}
	
	//metodos
	
	public function getDerivado(){
		return $this->derivado()->first();
	}
	
	public function getPrimero(){
		return $this->primero()->first();
	}
	
	public function getAsignado(){
		return $this->asignado()->first();
	}
	
	public function getVerificado(){
		return $this->verificado()->first();
	}
	
	public static function getVerificarEstado($estado_actual_caso){
		$result = false;

		$est_cas_fin = DB::select("select est_cas_fin from ai_estado_caso where est_cas_id='".$estado_actual_caso."'");

		if($est_cas_fin != null){
		if($est_cas_fin[0]->est_cas_fin==1) $result = true;
		}
		
		return $result;
	}

}
