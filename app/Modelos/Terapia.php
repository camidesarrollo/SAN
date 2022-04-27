<?php
namespace App\Modelos;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Helpers\helper;
use App\Modelos\EstadoTerapia;


class Terapia extends Model
{
	protected $table = 'ai_terapia';
	protected $primaryKey = 'tera_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'cas_id',
		'usu_id',
		'est_tera_id',
		'ter_doc_invi',
		'ter_enc_sat',
		'ter_fas', 
		// INICIO CZ SPRINT 69
		'flag_modelo_terapia'
		// FIN CZ SPRINT 69
	);

	public static function rptDesestimacionDeCasoTerapeuta($comunas = null, $fec_ini = null, $fec_fin = null){

		$where_usuario_id = "";
		$where_com_id = "";

		if (session()->all()["perfil"] == config('constantes.perfil_terapeuta')){
			$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
			$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ''){
				$where_com_id = " and aiuc.com_id IN ({$comunas})";
			}
		}


		// listado de motivos de desestimación
		$sql_motivos_desestimacion = Helper::estadosRechazoTerapia();

		// listado de gestores de la comuna
		/*$sql_terapeutas = "select * from ai_usuario 
		left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id
		where ai_usuario.id_perfil = ".config('constantes.perfil_terapeuta')." and aiuc.com_id = ".session()->all()['com_id'];*/

		$sql_terapeutas = "select * from ai_usuario 
		left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id
		where ai_usuario.id_perfil = ".config('constantes.perfil_terapeuta').
		$where_usuario_id.
		$where_com_id;

		$registros_terapeutas = DB::select($sql_terapeutas);

		$array_resultado = array();

		// iteración para obtener la información fuente del reporte
		foreach ($registros_terapeutas as $terapeuta){
			if (session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
				foreach ($sql_motivos_desestimacion as $desestimacion){
					$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$desestimacion->est_tera_nom] = NNAAlertaManualCaso::where('ter_id',$terapeuta->id)->where('est_tera_id',$desestimacion->est_tera_id)->where('id_com',$terapeuta->com_id)
					->where(function($query) use ($fec_ini, $fec_fin){
						if($fec_ini != null){
							$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
						}					
					})->count(); 
				}
			}else{
				foreach ($sql_motivos_desestimacion as $desestimacion){
					$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$desestimacion->est_tera_nom] = NNAAlertaManualCaso::where('ter_id',$terapeuta->id)->where('est_tera_id',$desestimacion->est_tera_id)->where('id_com',session()->all()['com_id'])
					->where(function($query) use ($fec_ini, $fec_fin){
						if($fec_ini != null){
							$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
						}					
					})->count(); 
				}
			}			
		}

		return collect($array_resultado);
	}

	public static function rptEstadoAvanceTerapia($comunas = null, $fec_ini = null, $fec_fin = null){

		$where_usuario_id 	= "";
		$where_com_id 		= "";
		$id_com 			= "";

		if (session()->all()["perfil"] == config('constantes.perfil_terapeuta')){
		 	$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
		 	$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		 	$id_com = session()->all()['com_id'];
		}

		// if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
		if ((session()->all()["perfil"] == config('constantes.perfil_coordinador')) || (session()->all()["perfil"] == config('constantes.perfil_super_usuario'))){
		 	$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		 	$id_com = session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$where_com_id = " and aiuc.com_id IN ({$comunas})";
				$id_com = $comunas;
			}
		}

		$sql_terapeutas = "select * from ai_usuario 
		left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id
		where ai_usuario.id_perfil = ".config('constantes.perfil_terapeuta').
		$where_usuario_id.
		$where_com_id;

		$registros_terapeutas = DB::select($sql_terapeutas);

		$array_resultado = array();

		$invitacion = EstadoTerapia::find(config('constantes.gtf_invitacion'));
		$diagnostico = EstadoTerapia::find(config('constantes.gtf_diagnostico'));
		$ejecucion = EstadoTerapia::find(config('constantes.gtf_ejecucion'));
		$seguimiento = EstadoTerapia::find(config('constantes.gtf_seguimiento'));

		// iteración para obtener la información fuente del reporte
		foreach ($registros_terapeutas as $terapeuta){

			$casos_asignados = NNAAlertaManualCaso::select('cas_id')->distinct()
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
						
					}					
				})
				->count('cas_id');

			$casos_invitacion = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_invitacion'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$casos_diagnostico = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_diagnostico'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$casos_ejecucion = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_ejecucion'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$casos_seguimiento = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_seguimiento'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$casos_egresados = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_egreso'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$total_casos = $casos_invitacion + $casos_diagnostico + $casos_ejecucion + $casos_seguimiento;


			$nna_asignados = NNAAlertaManualCaso::where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('cas_id')
				->where(function($query) use ($fec_ini, $fec_fin){
/* 					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7); */
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count();

			$nna_invitacion = NNAAlertaManualCaso::where('est_tera_id', config('constantes.gtf_invitacion'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('cas_id')
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count();

			$nna_diagnostico = NNAAlertaManualCaso::where('est_tera_id', config('constantes.gtf_diagnostico'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('cas_id')
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count();

			$nna_ejecucion = NNAAlertaManualCaso::where('est_tera_id', config('constantes.gtf_ejecucion'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('cas_id')
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count();

			$nna_seguimiento = NNAAlertaManualCaso::where('est_tera_id', config('constantes.gtf_seguimiento'))
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('cas_id')
				->where(function($query) use ($fec_ini, $fec_fin){
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
					if($fec_ini != null){
						$query->whereBetween('tera_est_tera_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count();

			$total_nna = $nna_invitacion + $nna_diagnostico + $nna_ejecucion + $nna_seguimiento;


			$total_encuesta_satisfaccion = NNAAlertaManualCaso::where('ter_enc_sat','<>', null)
				->where('ter_id', $terapeuta->id)
				->whereIn('id_com', explode(',', $id_com))
				->select('ter_enc_sat')->count();

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Cobertura Inicial'] = config('constantes.cobertura_inicial_terapeuta');

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Casos Asignados']['N° Casos'] = $casos_asignados;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Casos Asignados']['N° NNA'] = $nna_asignados;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$invitacion->est_tera_nom]['N° Casos'] = $casos_invitacion;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$invitacion->est_tera_nom]['N° NNA'] = $nna_invitacion;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$diagnostico->est_tera_nom]['N° Casos'] = $casos_diagnostico;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$diagnostico->est_tera_nom]['N° NNA'] = $nna_diagnostico;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$ejecucion->est_tera_nom]['N° Casos'] = $casos_ejecucion;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$ejecucion->est_tera_nom]['N° NNA'] = $nna_ejecucion;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$seguimiento->est_tera_nom]['N° Casos'] = $casos_seguimiento;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno][$seguimiento->est_tera_nom]['N° NNA'] = $nna_seguimiento;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Total Atendidos']['N° Casos'] = $total_casos;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Total Atendidos']['N° NNA'] = $total_nna;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['N° de Encuestas de Satisfacción'] = $total_encuesta_satisfaccion;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Total de Casos Egresados'] = $casos_egresados;


		}

		return collect($array_resultado);

	}

	public static function rptEstadoSeguimientoTerapia($id_comunas, $fec_ini = null, $fec_fin = null){

		$where_usuario_id = "";
		$where_com_id = "";
		$between_fec = "";

		if($fec_ini != null){
			$between_fec = " AND aic.cas_est_cas_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_terapeuta')){
			$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
			$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		}

		if(session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if(!is_null($id_comunas) && trim($id_comunas != '')){
				$where_com_id = " and aiuc.com_id IN ({$id_comunas})"; 				
			}
		}

		$sql_terapeutas = "select * from ai_usuario 
		left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id
		where ai_usuario.id_perfil = ".config('constantes.perfil_terapeuta').
		$where_usuario_id.
		$where_com_id;

		$registros_terapeutas = DB::select($sql_terapeutas);

		$array_resultado = array();

		// iteración para obtener la información fuente del reporte
		foreach ($registros_terapeutas as $terapeuta){
			// Se cambia la variable session com_id por $comuna para alterar entre perfil administrador central u otros.
			$comuna = '';
			if(session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
				$comuna = $terapeuta->com_id;
			}else{
				$comuna = session()->all()['com_id'];
			}

			$sql_llamada = "select 
			    ait.tera_id
			from 
			    ai_terapia ait
			    join vw_ai_nna_am_caso aic on aic.cas_id = ait.cas_id
			    join ai_tera_ptf_seguimiento aits on aits.tera_id = ait.tera_id
			where 
			    ait.usu_id = ".$terapeuta->id."
				and aits.ptf_mod_id = ".config('constantes.seguimiento_terapia_llamada').
				$between_fec.
			    " and aic.id_com = ".$comuna;

			$sql_visita = "select 
			    ait.tera_id
			from 
			    ai_terapia ait
			    join vw_ai_nna_am_caso aic on aic.cas_id = ait.cas_id
			    join ai_tera_ptf_seguimiento aits on aits.tera_id = ait.tera_id
			where 
			    ait.usu_id = ".$terapeuta->id."
				and aits.ptf_mod_id = ".config('constantes.seguimiento_terapia_visita').
				$between_fec.
			    " and aic.id_com = ".$comuna;

			$sql_revision = "select 
			    ait.tera_id
			from 
			    ai_terapia ait
			    join vw_ai_nna_am_caso aic on aic.cas_id = ait.cas_id
			    join ai_tera_ptf_seguimiento aits on aits.tera_id = ait.tera_id
			where 
			    ait.usu_id = ".$terapeuta->id."
				and aits.ptf_mod_id = ".config('constantes.seguimiento_terapia_revision').
				$between_fec.
			    " and aic.id_com = ".$comuna;


			$casos_egresados = NNAAlertaManualCaso::select('cas_id')->distinct()->where('est_tera_id', config('constantes.gtf_egreso'))
				->where('ter_id', $terapeuta->id)
				->where('id_com',$comuna)
				->where(function($query) use ($fec_ini, $fec_fin){
					if($fec_ini != null){
						$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
					}					
				})
				->count('cas_id');

			$registros_llamada = collect(DB::select($sql_llamada))->count();
			$registros_visita = collect(DB::select($sql_visita))->count();
			$registros_revision = collect(DB::select($sql_revision))->count();

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Telefónico'] = $registros_llamada; 
			
			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Presencial'] = $registros_visita; 
			
			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Revision'] = $registros_revision;

			$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Total'] = $registros_llamada + $registros_visita; 
			
			//$array_resultado[$terapeuta->nombres.' '.$terapeuta->apellido_paterno.' '.$terapeuta->apellido_materno]['Total de casos egresados'] = $casos_egresados;

		}

		return collect($array_resultado);

	}


	
}



