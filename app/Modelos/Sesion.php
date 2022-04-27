<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Sesion extends Model
{
    //
	protected $table = 'ai_sesion';
	
	protected $primaryKey = 'ses_id';
	
	public $timestamps = false;
	
	protected $fillable = ['cas_id','ter_id','ses_act','ses_obs','ses_dia','ses_fec','ses_num','ses_tip','gru_id'];
	
	public $appends = ['clase','tipo','fecha','title','start','allDay','url','description','color','textColor'];
	//protected $appends = ['estado','clase','tipo','fecha'];
	
	protected $dates = ['ses_fec'];
	
	// Relaciones
	public function caso(){
		return $this->belongsTo('App\Modelos\Caso', 'cas_id','cas_id');
	}
	
	public function estados(){
		return $this->belongsToMany('App\Modelos\EstadoSesion', 'ai_sesion_estado_sesion', 'ses_id', 'est_ses_id', 'ses_id','est_ses_id','ses_obs')
			->withPivot('ses_est_ses_fec','ses_obs','ses_dia')
			->latest('ses_est_ses_fec');
	}

	public function actualizarEstado($request){
		return DB::insert('insert into ai_sesion_estado_sesion (ses_id, est_ses_id, ses_obs , ses_dia) values (?, ?, ?, ?)', [$request->ses_id, $request->est_ses_id, $request->ses_obs, $request->ses_dia]);
	}

	public function grupales(){
		return $this->belongsTo('App\Modelos\SesionGrupal', 'gru_id','gru_id');
	}
	
	// Getters
	public function getEstadoAttribute(){
		return $this->estados->first();
	}
	
	public function getUltimoEstado(){
		return $this->estados()->first();
	}
	
	public function getFechaAttribute(){
		return $this->ses_fec->format('d/m/Y H:i');
	}
	
	public function getTipoAttribute(){
		if ($this->ses_tip=='I'){
			$tipo = 'Individual';
		}elseif ($this->ses_tip=='G'){
			$tipo = 'Grupal';
		}else{
			$tipo = $this->ses_tip;
		}
		
		return $tipo;
	}
	
	public function getClaseAttribute(){
		if ($this->ses_tip=='I'){
			$clase = 'sesionIndividual';
		}elseif ($this->ses_tip=='G'){
			$clase = 'sesionGrupal';
		}else{
			$clase = '';
		}
		return $clase;
	}
	
	// Setters
	public function setSesFecAttribute($value){
		//dd(gettype($value));
		if (gettype($value)=='object'){
			$this->attributes['ses_fec'] = $value;
		}else{
			$this->attributes['ses_fec'] = Carbon::createFromFormat('d/m/Y H:i', $value);
		}
	}
	
	public function getTitleAttribute(){
		if ($this->ses_tip=='I') {
			if (!isset($this->relations['caso'])){
				return 'Sesión #' . $this->ses_num . ' Tipo: ' . $this->getTipoAttribute();
			} else {
				return 'Caso #' . $this->caso->cas_id . ' Sesión #' . $this->ses_num . ' RUT #' . $this->caso->persona->per_run . ' Tipo: ' . $this->getTipoAttribute();
			}
		}else{
			if (isset($this->total)) {
				return 'Sesion: ' . $this->getTipoAttribute() . ' Total Casos #' . $this->total;
			}else{
				return 'Sesion: ' . $this->getTipoAttribute();
			}
		}
	}
	
	public function getStartAttribute(){
		return $this->ses_fec->format('Y-m-d H:i');
	}
	
	public function getAlldayAttribute(){
		return false;
	}
	
	public function getUrlAttribute(){
		if ($this->ses_tip=='I'){
			if (!isset($this->relations['caso'])){
				$this->load('caso.persona');
			}
			return route('coordinador.caso.ficha',['origen'=>2,'run'=>$this->caso->persona->per_run]);
		}else{
			return route('sesiones.grupal.index');
		}
		
	}
	
	public function getDescriptionAttribute(){
		//return 'hola';
		return "Observacion: ".$this->ses_obs."\r\n<br> Diagnostico: ".$this->ses_dia;
	}
	
	public function getColorAttribute(){
		$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $this->ses_fec);
		if ($fecha->lt(now())){
			return 'black';
		}else{
			if ($this->ses_tip=='I'){
				return '#5F93B2';
			}else{
				return '#D6D994';
			}
		}
	}
	
	public function getTextColorAttribute(){
		//$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $this->ses_fec);
		if ($this->ses_fec->lt(now())){
			return 'white';
		}else{
			return 'black';
		}
	}
	
	//Scopes
	public function scopeNumero($query,$ses_num){
		return $query->where('ses_num',$ses_num);
	}
	
	public function scopeGrupal($query,$grupal){
		return $query->where('gru_id',$grupal);
	}
	
	public function scopeCaso($query,$caso){
		return $query->where('cas_id',$caso);
	}
	
	public function scopeTerapeuta($query,$terapeuta){
		return $query->where('ter_id',$terapeuta);
	}
	
	public function scopeTipoGrupal($query){
		return $query->where('ses_tip','G');
	}
	
	public function scopeTipoIndividual($query){
		return $query->where('ses_tip','I');
	}
	
	public function scopeTipoSeguimiento($query){
		return $query->where('ses_tip', 'C');
	}
	
	public function scopeTipoRetroalimentacion($query){
		return $query->where('ses_tip', 'R');
	}
	
	// Metodos
	
	/**
	 * @param $request
	 * @return mixed
	 */
	public function getAgenda($request){
		$sesiones = $this
			->with('caso.persona','estados')
			->when(session('perfil') == config('constantes.perfil_terapeuta'), function ($query) {
				return $query->terapeuta(session("id_usuario"));
			})
			->when($request->caso ?? false, function ($query, $caso) {
				return $query->caso($caso);
			})
			->when($request->terapeuta ?? false, function ($query, $terapeuta) {
				return $query->terapeuta($terapeuta);
			})
			->when($request->start ?? false, function ($query, $start) {
				return $query->where('ses_fec', '>=',Carbon::parse($start));
			})
			->when($request->end ?? false, function ($query, $end) {
				return $query->where('ses_fec', '<=',Carbon::parse($end));
			})
			->tipoIndividual()
			->get();
		
		return $sesiones;
	}
	
	/**
	 * @param $request
	 * @return mixed
	 */
	public function getAgendaGrupal($request){
		$sesiones = $this
			//->with('caso.persona','estados')
			->when(session('perfil') == config('constantes.perfil_terapeuta'), function ($query) {
				return $query->terapeuta(session("id_usuario"));
			})
			/*->when($request->caso ?? false, function ($query, $caso) {
				return $query->caso($caso);
			})*/
			->when($request->terapeuta ?? false, function ($query, $terapeuta) {
				return $query->terapeuta($terapeuta);
			})
			->when($request->start ?? false, function ($query, $start) {
				return $query->where('ses_fec', '>=',Carbon::parse($start));
			})
			->when($request->end ?? false, function ($query, $end) {
				return $query->where('ses_fec', '<=',Carbon::parse($end));
			})
			->tipoGrupal()
			->select('ter_id','ses_fec','gru_id',DB::raw('count(ses_fec) as total'),DB::raw("'G' as ses_tip"))
			->groupBy('ses_fec','ter_id','gru_id')
			->orderBy('ses_fec')
			->get();
		
		return $sesiones;
	
	}
	
	/**
	 * Lista las seseiones grupales de un terapeuta por id de sesion grupal
	 * @param $gru_id
	 * @return mixed
	 */
	public function getGrupalByTerapeuta($gru_id){
		return $this->grupal($gru_id)->terapeuta(session('id_usuario'))->get();
	}
	
	/**
	 * @param $gru_id
	 * @return mixed
	 */
	public function getGrupal($gru_id){
		return $this->with('caso.persona','estados')
			->where('ter_id','!=',session('id_usuario'))
			->grupal($gru_id)->get();
	}
	
	/**
	 * @param $caso
	 * @return mixed
	 */
	public function getIndividualesConEstadosByCaso($caso){
		return $this->with('estados')
			->caso($caso)
			->tipoIndividual()->get();
	}
	
	/**
	 * Lista las sesiones con su estado actual dependiendo del caso, tipo de sesion y estados a buscar.
	 * @param $caso_id
	 * @param $ses_tip
	 * @param $est
	 *
	 * @return mixed
	 */
	public function getSesionesEstadoNNA($caso_id, $ses_tip, $est = ""){
		
		$sql = "SELECT ses.ses_id, ses.cas_id, est.est_ses_id FROM ai_sesion ses
                INNER JOIN (SELECT est_s.ses_id, est_s.est_ses_id,est_s.ses_est_ses_fec FROM ai_sesion_estado_sesion est_s
                INNER JOIN (SELECT ses_id, max(ses_est_ses_fec) AS max_fec from ai_sesion_estado_sesion group by ses_id)
                est_ses ON est_s.ses_id = est_ses.ses_id AND est_s.ses_est_ses_fec = est_ses.max_fec) est ON ses.ses_id = est.ses_id
                WHERE ses.cas_id=".$caso_id." AND ses.ses_tip='".$ses_tip."'";
		
		if (count($est) > 0 && $est != "") $sql .= " AND est.est_ses_id IN (".implode(',', $est).")";
		
		$res = DB::select($sql);
		
		return $res;
	}
	
	public function getSesionesSeguimientoConEstadosByCaso($caso){
		return $this->with('estados')
			        ->caso($caso)
			        ->tipoSeguimiento()->get();
	}
	
	public function getSesionesRetroalimentacionConEstadosByCaso($caso){
		return $this->with('estados')
			        ->caso($caso)
			        ->tipoRetroalimentacion()->get();
	}
}
