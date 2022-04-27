<?php
/**
 * Created by PhpStorm.
 * User: jmarquez
 * Date: 26-10-2018
 * Time: 15:00
 */
namespace App\Modelos;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;
use Session;

class Usuarios extends Authenticatable
{
	use Notifiable;
	
	protected $table = 'ai_usuario';
	
	protected $primaryKey = 'id';
	
	public $timestamps = true;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'run','nombres', 'apellido_paterno', 'apellido_materno',
		'email',
		'telefono',
		'id_perfil',
		'id_region',
		'id_institucion',
		'id_estado'
	];
	
	protected $dates = [
		'expires_at'
	];
	
	public $appends = ['nombre_completo'];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function getNombreAttribute(){
		return ucwords(strtolower($this->nombres.' '.$this->apellido_paterno.' '.$this->apellido_materno));

	}
	
	public function getNombreCompletoAttribute(){
		return ucwords(strtolower($this->nombres.' '.$this->apellido_paterno.' '.$this->apellido_materno));
	}
	
	public function setNombresAttribute($value){
		$this->attributes['nombres'] = ucwords(strtolower($value));
	}
	
	public function setApellidoPaternoAttribute($value){
		$this->attributes['apellido_paterno'] = ucwords(strtolower($value));
	}
	
	public function setApellidoMaternoAttribute($value){
		$this->attributes['apellido_materno'] = ucwords(strtolower($value));
	}
	
	public function setEmailAttribute($value){
		$this->attributes['email'] = strtolower($value);
	}
	
	public function getRutAttribute(){
		return number_format($this->run,0,",",".")."-".dv($this->run);
	}
	
	// Relaciones
	public function perfil()
	{
		return $this->belongsTo('App\Modelos\Perfil','id_perfil','id');
	}
	
	public function comunas()
	{
		//CZ 75
		return $this->belongsToMany('App\Modelos\Comuna', 'ai_usuario_comuna', 'usu_id', 'com_id', 'id','com_id')->where('vigencia', 1)->where('oln', 'S');
		//CZ 75
	}
	
	public function casos()
	{
		return $this->belongsToMany('App\Modelos\Caso', 'ai_caso_terapeuta', 'ter_id', 'cas_id', 'id','cas_id');
	}
	
	// Metodos

	public static function buscaUsuario($usu_id){
 		return DB::select("select * from ai_usuario where id=".$usu_id."");
	}

	public function usuarioAsignado($cas_id){
 		return DB::select("select pu.run, u.nombres, u.apellido_paterno, u.apellido_materno from ai_usuario u inner JOIN ai_persona_usuario pu on u.id = pu.usu_id where pu.cas_id = ".$cas_id."");
	}

	public function getGestores($com_id){
 		return DB::select("SELECT * FROM ai_usuario u INNER JOIN ai_usuario_comuna uc on u.id = uc.usu_id WHERE uc.com_id = ".$com_id." AND u.id != ".config('constantes.gestor_prueba')." AND u.id_perfil=3");
	}

	// INICIO CZ SPRINT 63 Casos ingresados a ONL 
	public function getGestoresAsig($run, $id_caso){
		return DB::select("select * from ai_usuario u inner JOIN ai_persona_usuario pu on u.id = pu.usu_id where u.id_perfil=3 and pu.run = ".$run." and pu.cas_id = ".$id_caso." ");
	}
   // FIN CZ SPRINT 63 Casos ingresados a ONL

	public function getTerapeutas(){
		return DB::select("select id, u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno as nombre, uc.com_id
			from ai_usuario u 
			inner JOIN ai_usuario_comuna uc on uc.usu_id=u.id
			where u.id_perfil=".config('constantes.perfil_terapeuta')." 
			and com_id in (".Session::get('com_id').")");
	}

	public function getTerapeutasAsig($cas_id = null){
 		return DB::select("select * from ai_usuario u inner JOIN ai_caso_terapeuta ct on u.id = ct.ter_id where ct.cas_id = ".$cas_id." ");
	}

	// public function getTerapeutas(){
	// 	return $this->where('id_perfil',config('constantes.perfil_terapeuta'))->orderBy('nombres')->get();
	// }

	public function getAsigTerapeuta($id){
		return DB::select("select p.score as score, ec.est_cas_nom as est_cas_nom, p.run||'-'||p.dv_run AS nna_run, alm.n_am as n_am, p.run as run
            from ai_usuario u 
			inner JOIN ai_caso_terapeuta ct on ct.ter_id = u.id
			inner JOIN ai_caso c on c.cas_id = ct.cas_id
			inner JOIN ai_persona_usuario pu on pu.cas_id= c.cas_id
            inner JOIN ai_predictivo p on p.run= pu.run
            inner JOIN ai_estado_caso ec on ec.est_cas_id= c.est_cas_id
            inner JOIN 
            (SELECT a.ale_man_run, COUNT(a.ale_man_run) AS n_am FROM ai_alerta_manual a 
            WHERE a.est_ale_id <= 4
            GROUP BY a.ale_man_run) alm on alm.ale_man_run = p.run 
            where u.id_perfil=4 and u.id='".$id."'");
	}

	public function getUsuarioResponsable(){
 		return  DB::select("select id, nombres, apellido_paterno, apellido_materno from ai_usuario us inner JOIN ai_usuario_comuna uc on uc.usu_id=us.id
			inner JOIN ai_comuna c on uc.com_id=c.com_id
			where us.id_perfil=5 and c.com_cod in (".Session::get('com_cod').")");
	}

	public function getUsuarioSectorialista(){
 		return  DB::select("select u.run,u.telefono,u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as usuario_nombre, i.nom_ins
 			from ai_usuario u
 			inner JOIN ai_institucion i on u.id_institucion=i.id_ins
			where u.id=(".Session::get('id_usuario').")");
	}
	
	public function getToken(){
		$key = config('app.key');
		
		if ( Str::startsWith($key, 'base64:')) {
			$key = base64_decode(substr($key, 7));
		}
		
		$token = hash_hmac('sha256', Str::random(40), $key);
		
		$usuario = Auth::user();
		$usuario->token = $token;
		$usuario->expires_at = now()->addMinutes(config('session.lifetime'));
		$usuario->save();
		
		return $token;
	}
	
	public function destroyToken(){
		$usuario = Auth::user();
		$usuario->token = null;
		$usuario->expires_at = null;
		$usuario->save();
	}
// INICIO CZ SPRINT 75
	public static function rptUsuarioPerfil($id_perfil){

		$sql = "SELECT t3.com_nom OLN, count(t1.ID_estado) Cantidad
				FROM ai_usuario t1		
					LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id		
					LEFT JOIN ai_comuna t3 on t3.com_id = t2.com_id		
				WHERE ID_PERFIL = ".$id_perfil." AND t3.com_nom IS NOT NULL		
				AND t3.oln = 'S' AND t2.vigencia = 1 AND t1.FLAG_USUARIO_CENTRAL <> 1
				GROUP BY t3.com_cod, t3.com_nom";

		$resultado = DB::select($sql);

		return $resultado;

	}
	// CZ SPRINT 75 
	public static function rptUsuarioOln($com_id){

		$sql = "SELECT t1.run, 
                t1.nombres||' '||t1.apellido_paterno||' '||t1.apellido_materno as nombres, 
                t1.email, 
                t1.telefono, 
                t3.tipo, 
                t4.nom_ins,
				CASE t1.id_estado
					WHEN 1 THEN 'Activo'		
					WHEN 0 THEN 'Inactivo'		
				END AS Estado_usuario		
				FROM ai_usuario t1		
				LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id		
				INNER JOIN ai_comuna t5 on t5.com_id = t2.com_id	
				LEFT JOIN ai_perfil t3 on t3.cod_perfil = t1.id_perfil		
				LEFT JOIN ai_institucion t4 on t4.id_ins = t1.id_institucion
				WHERE t2.com_id = ".$com_id." AND run <> '77777777' AND ID_Perfil NOT IN (6,7) 
				AND t5.oln = 'S'
				AND FLAG_USUARIO_CENTRAL <> 1
				ORDER BY t3.cod_perfil";

		$resultado = DB::select($sql);

		return $resultado;

	}
	//INICIO DC
	public static function rptUsuarioOln2($request){
	    
	    if($request->perfil != ''){
	        
	        $sql = ' and t1.id_perfil = '.$request->perfil;
	    }else{
	        $sql = '';
	    }
	//INICIO CZ SPRINT 72
		$sql = "select 
		t1.run,
                t1.nombres||' '||t1.apellido_paterno||' '||t1.apellido_materno as nombres,
                t1.email,
                t1.telefono,
                t3.tipo,
                t4.nom_ins,
				CASE t1.id_estado
					WHEN 1 THEN 'Activo'
					WHEN 0 THEN 'Inactivo'
				END AS Estado_usuario,
		t7.reg_nom,
		t5.com_nom,
                t3.nombre as perfil,
                t1.id,
				CASE WHEN t1.FLAG_USUARIO_CENTRAL <> 0 THEN 'SI' ELSE 'NO' END  AS FLAG_USUARIO_CENTRAL
		from ai_usuario t1
				LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id
				LEFT JOIN ai_perfil t3 on t3.cod_perfil = t1.id_perfil
				LEFT JOIN ai_institucion t4 on t4.id_ins = t1.id_institucion
			INNER JOIN ai_comuna t5 on t5.com_id = t2.com_id
		inner join ai_provincia t6 on t5.pro_id = t6.pro_id
		inner join ai_region t7  on t6.reg_id = t7.reg_id
				WHERE t2.com_id = ".$request->oln.$sql." 
                AND run <> '77777777' 
				 AND t5.oln = 'S' 
				 and t2.vigencia = 1
				ORDER BY t3.cod_perfil";
	//FIN CZ SPRINT 72
	    $resultado = DB::select($sql);
	    
	    return $resultado;
	    
	}
	//FIN DC
// CZ SPRINT 75
}
