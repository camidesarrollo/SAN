<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Relations\Pivot;
use DB;

class CasoTerapeuta extends Pivot
{
	//
	protected $table = 'ai_caso_terapeuta';
	
	protected $primaryKey = 'cas_ter_id';
	
	public $timestamps = false;
	
	protected $fillable = ['cas_id','ter_id','cas_ter_fec'];
	
	protected $dates = ['cas_ter_fec'];
	
	// scopes
	public function scopeTerapeuta($query, $terapeuta){
		return $query->where('ter_id',$terapeuta);
	}
	
	public function scopeCaso($query, $caso){
		return $query->where('cas_id',$caso);
	}
	
	// relaciones
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function caso(){
		return $this->belongsTo('App\Modelos\Caso', 'cas_id', 'cas_id');
	}
	
	// metodos
	/**
	 * Devuelve los casos de un terapeuta con su la relacion caso y persona
	 * @param $terapeuta
	 * @return mixed
	 */
	public function getConCasoPersona($terapeuta){
		return $this->with('caso.persona')->terapeuta($terapeuta)->get();
	}
	
	public function verificarCasoTerapeuta($caso){
		return $this->terapeuta(session('id_usuario'))
			->caso($caso)
			->exists();
	}
	
	public function getTerapeutaAsignado($cas_id = null){
		$sql = "SELECT * FROM ai_caso_terapeuta ct LEFT JOIN ai_usuario u ON ct.ter_id = u.id WHERE 1 = 1";
		
		if (!is_null($cas_id) && $cas_id != "") $sql .= " AND ct.cas_id = ".$cas_id;
		
		return DB::select($sql);
	}
}
