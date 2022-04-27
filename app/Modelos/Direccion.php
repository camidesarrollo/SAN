<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
	protected $table = 'ai_direccion';
	
	protected $primaryKey = 'dir_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
		'per_id',
		'com_id',
		'dir_ord',
		'dir_fue',
		'dir_call',
		'dir_num',
		'dir_dep',
		'dir_des',
		'dir_fecha',
		'dir_cod_id',
		'dir_status', 
		// INICIO CZ SPRINT 68
		'cas_id'
		// FIN CZ SPRINT 68
	);
	
	// relaciones
	public function comunas(){
		return $this->belongsTo('App\Modelos\Comuna', 'com_id','com_id');
	}
	
	public function personas(){
		return $this->belongsTo('App\Modelos\Persona', 'per_id','per_id');
	}
	
	// getter
	public function getCompletaAttribute(){
		return $this->dir_call.' '.$this->dir_num.' '.$this->comunas->com_nom.' '.
			$this->comunas->provincias->pro_nom.' '.$this->comunas->provincias->regiones->reg_nom;
		
		
	}
}


