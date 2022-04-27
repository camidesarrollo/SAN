<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SesionGrupal extends Model
{
    //
	protected $table = 'ai_sesion_grupal';
	protected $primaryKey = 'gru_id';
	public $timestamps = false;
	
	protected $fillable = ['usu_id', 'gru_rut', 'gru_nom', 'gru_fec', 'gru_obs'];
	
	protected $appends = ['fecha','estado'];
	
	protected $dates = ['gru_fec'];
	
	public function setGruFecAttribute($value){
		$this->attributes['gru_fec'] = Carbon::createFromFormat('d/m/Y H:i', $value);
		$this->attributes['usu_id'] = 2;
	}
	
	public function setGruRutAttribute($value){
		$this->attributes['gru_rut'] = devuelveRut($value);
	}
	
	public function getFechaAttribute(){
		return $this->gru_fec->format('d/m/Y H:i');
	}
	
	public function getRutAttribute(){
		$rut = number_format($this->gru_rut,0,",",".")."-".dv($this->gru_rut);
		return $rut;
	}
	
	public function getEstadoAttribute(){
		return $this->estados->first();
	}
	
	public function estados(){
		return $this->belongsToMany('App\Modelos\EstadoSesion', 'ai_sesion_estado_grupal', 'gru_id', 'est_ses_id', 'gru_id','est_ses_id')
			->withPivot('ses_est_gru_fec')
			->latest('ses_est_gru_fec');
	}
	
	public function terapeutas(){
		return $this->hasMany('App\Modelos\Sesion','gru_id','gru_id')
			->groupBy();
	}
	
	public function terapeutas2(){
		return $this->hasOne('App\Modelos\Sesion','gru_id','gru_id')
			->selectRaw('gru_id, count(*) as count')->groupBy('gru_id');
	}
	
	public function getUltimoEstado(){
		return $this->estados()->first();
	}
}
