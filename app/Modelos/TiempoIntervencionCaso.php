<?php
// CZ SPRINT 77
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
class TiempoIntervencionCaso extends Model
{
    protected $table 		= 'AI_TIME_INTER_CASO';
    protected $primaryKey	= 'id_time';
	public $timestamps = false;


	public static  function notificacionTiempoIntervencion(){
		$comuna = explode(',',session()->all()['com_cod']);
		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			// $casos =  DB::select("select distinct c.cas_id from ai_caso c  INNER JOIN ai_persona_usuario a ON (c.cas_id = a.cas_id) 
			// INNER JOIN ai_estado_caso ec ON (c.est_cas_id = ec.est_cas_id)  WHERE ec.est_cas_ord < 7 and ec.est_cas_fin != 1 and a.usu_id =". session()->all()['id_usuario']);
			
			$casos = CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('est_cas_fin','<>',1)
			->where('per_ind', 1)
            ->where(function ($query) {
                $query->where('usuario_id', '=',session()->all()['id_usuario']);
            })->where('cas_estado', 'RETRASADO')->get();

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
		// return Datatables::of($notificacion);
		return $notificacion;
	}

	public static function crearTiempoIntervencion($cas_id){
		$maxId = DB::select('select max(id_time)+1 as max from AI_TIME_INTER_CASO');
		$tiempo = new TiempoIntervencionCaso();
		$tiempo->id_time = $maxId[0]->max;
		$tiempo->cas_id = $cas_id;
		$tiempo->cas_estado = 'A TIEMPO';
		$save = $tiempo->save();
		return $save;
	}
}
