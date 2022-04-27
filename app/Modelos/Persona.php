<?php

namespace App\Modelos;

use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Persona extends Model
{
	protected $table = 'ai_persona';
	
	protected $primaryKey  = 'per_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
		'per_act',
		'per_run',
		'per_dig',
		'per_nom',
		'per_pat',
		'per_mat',
		'per_nac',
		'per_ani',
		'per_mes',
		'per_sex',
		'per_cod_ens',
		'per_cod_gra',
		'per_gra_let',
		'per_chi',
		'per_pas'
	);
	
	public $appends = ['nombre_completo','rut','nombre_corto'];
	
	public function liceos(){
		return $this->hasMany('App\Modelos\Liceo','per_id','per_id');
	}
	
	public function contactos(){
		return $this->hasMany('App\Modelos\Contacto','per_id','per_id');
	}
	
	public function casos(){
		return $this->hasMany('App\Modelos\Caso','per_id','per_id');
	}
	
	public function casoPersonaIndice(){
		return $this->hasMany('App\Modelos\CasoPersonaIndice','per_id','per_id');
	}

	public function direcciones(){
		return $this->hasMany('App\Modelos\Direccion','per_id','per_id');
	}
	
	// getters
	public function getNombresAttribute(){
		return "{$this->per_nom} {$this->per_pat} {$this->per_mat}";
	}
	
	public function getNombreCompletoAttribute(){
		return "{$this->per_nom} {$this->per_pat} {$this->per_mat}";
	}
	
	public function getNombreCortoAttribute(){
		return "{$this->per_nom} {$this->per_pat}";
	}
	
	public function getRutAttribute()
	{
		$rut = number_format($this->per_run,0,",",".")."-".$this->per_dig;
		return $rut;
	}
	
	// setters
	public function setPerNomAttribute($value){
		$this->attributes['per_nom'] = mb_strtoupper($value);
	}
	
	public function setPerPatAttribute($value){
		$this->attributes['per_pat'] = mb_strtoupper($value);
	}
	
	public function setPerMatAttribute($value){
		$this->attributes['per_mat'] = mb_strtoupper($value);
	}
	
	public function getByRutExterno($run){
		return $this->where('per_run',$run)->first(['per_run','per_nom','per_pat','per_mat'])->setAppends(['nombre_completo']);
	}
	
	// scopes
	
	public function scopeRun($query,$run){
		return $query->where('per_run',$run);
	}
	
	// metodos
	
	public function getByRun($run){
		return $this->run($run)->first();
	}
	
	public function getByRunConCaso($run){
		return $this->with('casos')->run($run)->first();
	}
	
	public function obtenerCasoActualPersona($run){
	   $sql = "SELECT * FROM (SELECT * FROM ai_persona p
				LEFT JOIN ai_caso_persona_indice cpi ON p.per_id = cpi.per_id
				LEFT JOIN ai_caso c ON cpi.cas_id = c.cas_id
				LEFT JOIN ai_caso_estado_caso cec ON c.cas_id = cec.cas_id
				LEFT JOIN ai_estado_caso ec ON cec.est_cas_id = ec.est_cas_id
				WHERE p.per_run = '".$run."' AND ec.est_cas_fin = 0 ORDER BY cec.cas_est_cas_fec DESC)
				WHERE rownum = 1";
	   
	   return DB::select($sql);
	}

	public static function verificarOpd($run){

	   $sql = "select c.est_cas_id,aec.est_cas_nom
			from ai_persona p
			inner join ai_caso_persona_indice cpi on cpi.per_id = p.per_id 
			inner join ai_caso c on c.cas_id = cpi.cas_id
			inner join ai_estado_caso aec on aec.est_cas_id = c.est_cas_id
			where p.per_run='".$run."' 
			and (c.est_cas_id='".config('constantes.nna_presenta_medida_proteccion')."' 
				or c.est_cas_id='".config('constantes.nna_vulneracion_derechos')."' 
				or c.est_cas_id='".config('constantes.familia_intervenida_sename')."'  
				or c.est_cas_id='".config('constantes.familia_no_aplica')."'
		 		or c.est_cas_id='".config('constantes.familia_inubicable')."'
		 		or c.est_cas_id='".config('constantes.familia_rechaza_oln')."'
		 		or c.est_cas_id='".config('constantes.familia_renuncia_oln')."')";
		 		
	   return DB::select($sql);
	}

	public static function verificarCantCaso($id){
		$sql = "SELECT c.cas_id FROM ai_persona_usuario pu LEFT JOIN ai_caso c ON pu.cas_id = c.cas_id LEFT JOIN ai_caso_comuna cc ON c.cas_id = cc.cas_id LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id WHERE cc.com_id = ".Session::get('com_id')." AND pu.usu_id = ".$id." AND ec.est_cas_fin = 0 GROUP BY c.cas_id";			

	   	$respuesta = 0;
	   	$resultado = DB::select($sql);	
	   	if (count($resultado) > 0) $respuesta = count($resultado);
		
	   	return $respuesta;
	}


}
