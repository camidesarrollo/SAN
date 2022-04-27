<?php
// CZ SPRINT 74  
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use Session;
use Carbon\Carbon;

class NotificacionAsignacion extends Model
{
    //
    protected $table 		= 'ai_notificacion_asignacion';
    protected $primaryKey = 'id_notificacion';

    public static function crearNotificiacion($id_usuario, $id, $tipo, $descripcion, $estado){
        $max = DB::select('select CASE WHEN max(id_notificacion)+1  IS NULL THEN 1 ELSE max(id_notificacion)+1  END as id from ai_notificacion_asignacion');
		$notificacion = new NotificacionAsignacion();
		$notificacion->id_notificacion = $max[0]->id;
		$notificacion->id_usuario = $id_usuario;
		$notificacion->id = $id;
		$notificacion->tipo = $tipo;
		$notificacion->fecha = date("Y-m-d H:i:s");
		$notificacion->titulo = "Notificación Asignación";
		$notificacion->descripcion = $descripcion;
		$notificacion->estado_notificacion = $estado;
        $notificacion->save();
	}

	public static function cantidadNotificaciones(){
		$comuna = explode(',',session()->all()['com_id']);
	
		$usuario_id = session()->all()['id_usuario'];
		// print_r(session('com_cod'));
		// die();
		static::cambiarEstadoPorFecha();

		// cambiarEstadoPorFecha();
		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			$cantnotificacion = DB::select("select count(*) as cantidad 
			from AI_NOTIFICACION_ASIGNACION 
			inner join ai_caso_comuna on ai_notificacion_asignacion.id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on AI_NOTIFICACION_ASIGNACION.id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
                        where 
			ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]." and tipo = 1 and (estado_notificacion = 1 or estado_notificacion = 2) and ai_caso_persona_indice.per_ind = 1  ");

			$cantidadNoti = $cantnotificacion[0]->cantidad;
		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			static::cambiarEstadoPorFecha();
			$cantnotificacion = DB::select("select count(*) as cantidad 
			from AI_NOTIFICACION_ASIGNACION
            inner join ai_terapia t on ai_notificacion_asignacion.id_usuario = t.usu_id and ai_notificacion_asignacion.id = t.tera_id
			inner join ai_caso_comuna on t.cas_id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on t.cas_id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
			where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]." and tipo = 2 and (estado_notificacion = 1 or estado_notificacion = 2) and ai_caso_persona_indice.per_ind = 1  ");
			
			$cantidadNoti = $cantnotificacion[0]->cantidad;
		}

		return $cantidadNoti;
	}

	public static function CantnotificacionesAsignacion(){
		$comuna = explode(',',session()->all()['com_id']);
		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			$cantnotificacion = DB::select("select count(*) as cantidad 
			from AI_NOTIFICACION_ASIGNACION 
            inner join ai_caso_comuna on ai_notificacion_asignacion.id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on AI_NOTIFICACION_ASIGNACION.id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
          	where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]." and tipo = 1 and (estado_notificacion = 1 or estado_notificacion = 2) and ai_caso_persona_indice.per_ind = 1  ");
			
			$cantidadNoti = $cantnotificacion[0]->cantidad;
		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			$cantnotificacion = DB::select("select count(*) as cantidad 
			from AI_NOTIFICACION_ASIGNACION
            inner join ai_terapia t on ai_notificacion_asignacion.id_usuario = t.usu_id and ai_notificacion_asignacion.id = t.tera_id
			inner join ai_caso_comuna on t.cas_id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on t.cas_id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
			where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]." and tipo = 2 and (estado_notificacion = 1 or estado_notificacion = 2) and ai_caso_persona_indice.per_ind = 1 ");

			$cantidadNoti = $cantnotificacion[0]->cantidad;
		}
		return $cantidadNoti;
	}
	public static function CantnotificacionesTiempoIntervencion(){
		$comuna = explode(',',session()->all()['com_cod']);
		$usuario_id = session()->all()['id_usuario'];

		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			$contador =0;
			// CZ SPRINT 77
			$cantidadNoti  = $cantidadTimpo = DB::select("select count( distinct cas_id) as cantidad from ai_time_inter_caso 
			where cas_id in (select cas_id from VW_NNA_CASO where COD_COM in (".$comuna[0].") 
			and EST_CAS_FIN <> 1 and PER_IND = 1 and 
			(USUARIO_ID = ".$usuario_id.")) and cas_estado = 'RETRASADO'");
						
		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			$contador =0;
	
			$cantidadNoti =  DB::select("select  count( distinct tera_id) as cantidad from ai_time_inter_tera 
			where tera_id in (select tera_id from 
			VW_NNA_CASO where COD_COM in (".$comuna[0].") and TER_ID =".$usuario_id." and EST_TERA_FIN <> 1
			and EST_TERA_ORD < 4 and (EST_CAS_FIN <> 1 or ES_CAS_ID = 7)) and tera_estado = 'RETRASADO'");
			// print_r(count($cantidadNoti));
			// die();
			// ;
		}

		return $cantidadNoti;
	}

	public static  function notificacionTiempoIntervencion(){
		$comuna = explode(',',session()->all()['com_cod']);
		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			// $casos =  DB::select("select distinct c.cas_id from ai_caso c  INNER JOIN ai_persona_usuario a ON (c.cas_id = a.cas_id) 
			// INNER JOIN ai_estado_caso ec ON (c.est_cas_id = ec.est_cas_id)  WHERE ec.est_cas_ord < 7 and ec.est_cas_fin != 1 and a.usu_id =". session()->all()['id_usuario']);
			
			$casos = CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('est_cas_fin','<>',1)
			->where('per_ind', 1)
			->where('CAS_ESTADO', 'RETRASADO')
            ->where(function ($query) {
                $query->where('usuario_id', '=',session()->all()['id_usuario']);
            })->get();

			$notificacion 	 = array();
			foreach($casos as $key => $caso){

					$per_run = DB::select('select * from ai_persona where per_id in (select per_id from ai_caso_persona_indice where cas_id = '.$caso->cas_id.' and per_ind = 1)');
					$objDemo = new \stdClass();
					$objDemo->tituloNotificacion = 'Alerta: Tiempo de intervención Caso';
					$estadoCaso = Caso::where('cas_id',$caso->cas_id )->first();
					$Etapa = DB::select('select * from ai_estado_caso where est_cas_id ='.$estadoCaso->est_cas_id.'order by est_cas_ord');
					$siguenteEtapa = DB::select("select * from ai_estado_caso where est_cas_ord >".$Etapa[0]->est_cas_ord." order by est_cas_ord");
					$objDemo->mensaje = "Caso: ".$caso->cas_id." debe pasar de etapa a: " . $siguenteEtapa[0]->est_cas_nom;
					$objDemo->caso = $caso->cas_id;
					$objDemo->run = $per_run[0]->per_run;
					array_push($notificacion, $objDemo);
						
			}
		}else if(session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			// $casos =  DB::select("select * from ai_terapia where tera_id in (select distinct tera_id from ai_terapia t 
			// inner join ai_estado_terapia et on t.est_tera_id =  et.est_tera_id
			//  LEFT JOIN ai_caso_terapeuta aict ON (aict.cas_id = t.cas_id)
			// where   aict.ter_id =". session()->all()['id_usuario']."  and et.est_tera_ord < 7 and et.est_tera_fin != 1 )");
			
			$casos = CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('ter_id', '=',session()->all()['id_usuario'])
			->where('est_tera_fin', '<>', 1)
			->where('est_tera_ord', '<', 4)
			->where('per_ind', 1)
			->where('tera_estado', 'RETRASADO')
			->where(function ($query) {
				$query->where('est_cas_fin', '<>', 1);
				$query->orwhere('es_cas_id', '=', 7);//egreso oln
			})->get();

			$notificacion 	 = array();
			foreach($casos as $key => $caso){

					$per_run = DB::select('select * from ai_persona where per_id in (select per_id from ai_caso_persona_indice where cas_id = '.$caso->cas_id.' and per_ind = 1)');

					$estadoCaso = Terapia::where('tera_id',$caso->tera_id )->first();
					$Etapa = DB::select('select * from ai_estado_terapia where est_tera_id ='.$estadoCaso->est_tera_id.'order by est_tera_ord');
					if($Etapa[0]->est_tera_id == 6){
						$siguenteEtapa = DB::select("select * from ai_estado_terapia where est_tera_id = 12");
					}else{
						$siguenteEtapa = DB::select("select * from ai_estado_terapia where est_tera_ord >".$Etapa[0]->est_tera_ord." order by est_tera_ord");	
						$objDemo = new \stdClass();
						$objDemo->tituloNotificacion = 'Alerta: Tiempo de intervención Terapia';
						$objDemo->mensaje = "Terapia: ".$caso->cas_id." debe pasar de etapa a: " . $siguenteEtapa[0]->est_tera_nom;
						$objDemo->caso = $caso->cas_id;
						$objDemo->terapia = $caso->tera_id;
						$objDemo->run = $per_run[0]->per_run;
						array_push($notificacion, $objDemo);
					}
		
				}
		}
		return $notificacion;
	}

		//CAMBIO DE ESTADO NOTIFICACION SI YA PASARON DOS SEMANAS DE SU CREACION
		public static function cambiarEstadoPorFecha(){
			$comuna = explode(',', session()->all()['com_id']);
			if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
				// $caso = DB::select("select * from ai_caso c where c.cas_id in (select distinct c.cas_id from ai_caso c INNER JOIN ai_persona_usuario a ON (c.cas_id = a.cas_id)  where cas_fec >='". date("Y-m-d")."' and a.usu_id =". session()->all()['id_usuario'].")");
				$notificaciones = DB::select("select AI_NOTIFICACION_ASIGNACION.*, ai_persona.per_run 
				from AI_NOTIFICACION_ASIGNACION 
				inner join ai_caso_comuna on ai_notificacion_asignacion.id = ai_caso_comuna.cas_id  
				inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
				inner join ai_caso_persona_indice on AI_NOTIFICACION_ASIGNACION.id = ai_caso_persona_indice.cas_id
				inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
				where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id = ".$comuna[0]." and tipo = 1 and estado_notificacion = 2 and ai_caso_persona_indice.per_ind = 1");
			}else if(session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
				$notificaciones = DB::select(" select AI_NOTIFICACION_ASIGNACION.id_notificacion,ai_notificacion_asignacion.titulo, ai_notificacion_asignacion.descripcion,ai_notificacion_asignacion.fecha, ai_persona.per_run, t.cas_id as id 
				from AI_NOTIFICACION_ASIGNACION
				inner join ai_terapia t on ai_notificacion_asignacion.id_usuario = t.usu_id and ai_notificacion_asignacion.id = t.tera_id
				inner join ai_caso_persona_indice on t.cas_id = ai_caso_persona_indice.cas_id
				inner join ai_usuario_comuna on t.usu_id = ai_usuario_comuna.usu_id
				inner join ai_comuna on ai_usuario_comuna.com_id = ai_comuna.com_id
				inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id  
				  where ID_USUARIO = ".session()->all()['id_usuario']." and ai_comuna.com_id = ".$comuna[0]." and tipo = 2 and estado_notificacion = 2 and ai_caso_persona_indice.per_ind = 1");
			}
	
			foreach($notificaciones as $key => $notificacion){
				$date = date("d-m-Y",strtotime($notificacion->fecha."+ 2 week"));  
				$hoy = date("d-m-Y");
				$date1 = Carbon::parse($date)->format('d-m-Y'); //FECHA CALCULADA
				$date2 = Carbon::parse($hoy)->format('d-m-Y'); //HOY
				$date1 = Carbon::createFromFormat('d-m-Y', $date1);
				$date2 = Carbon::createFromFormat('d-m-Y', $date2);
				$result = $date2->gte($date1);
	
				if($date2->gte($date1)){
					$notificacion = NotificacionAsignacion::find($notificacion->id_notificacion);
					$notificacion->estado_notificacion = 3;
					$respuesta = $notificacion->save();
				}
				
			}
			
		}
}
// CZ SPRINT 74  