<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modelos\{Adjunto, Caso, Alternativa, DimensionEncuesta, Fase, Respuesta, Pregunta, CasoPersonaIndice, Persona, Terapia};
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Freshwork\ChileanBundle\Rut;
use Session;
/**
 * Class DiagnosticoController
 * @package App\Http\Controllers
 */
class DiagnosticoController extends Controller
{
	protected $reglas_file = [
		'adjunto'           => 'sometimes|file|mimes:pdf|max:3072',
	];
	
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->middleware('verificar.caso.terapeuta')->only('show');
	}	
	//
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request){
		try{
			/*Etapa de donde se esta llamando al NCFAS
				- Diagnostico (1)
				- Evaluacion PAF (5)
				- Seguimiento PAF (6)
			*/
			$etapa = $request->opcion; 

			// VALIDACION ID CASO
			$cas_id = $request->caso;
			if (!isset($cas_id) || $cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			// VALIDACION RUN
			$run = $request->run;
			if (!isset($run) || $run == ""){
				$mensaje = "No se encuentra el RUN del NNA. Por favor verifique e intente nuevamente";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			// INFORMACION CASO
			$caso = Caso::find($cas_id);
			if (!$caso){
				$mensaje = "No se encuentra información del caso. Por favor verifique e intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			// INFORMACION NNA
			$persona = Persona::where('per_run', $run)->get();
			if (count($persona) == 0){
				$mensaje = "No se encuentra información del NNA. Por favor verifique e intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			// NOMBRE NNA / RUT SIN FORMATO / RUT FORMATEADO
			$nombres_persona = $persona[0]->per_nom.' '.$persona[0]->per_pat.' '.$persona[0]->per_mat;
			$rut_persona_sin_formato = $persona[0]->per_run;
			$rut_persona = Rut::parse($persona[0]->per_run.$persona[0]->per_dig)->format();

			// ESTRUCTURA NCFAS-G
			$fases = Fase::orderBy('fas_ord','asc')->get();
			$alternativas = Alternativa::orderBy('alt_ord','asc')->get();
			$dimensiones = DimensionEncuesta::with('preguntas')->where("dim_enc_id", "!=", config('constantes.i_ambivalencia_cuidador_niño/a'))->where("dim_enc_id","!=",config('constantes.j_preparacion_para_la_reunificacion'))->get();


			// FASE A VISUALIZAR NCFAS-G
			$fase_caso 		= $caso->fas_id;
			$fase_view 		= config('constantes.ncfas_fs_ingreso');
			$editar_ncfas 	= false;
			$total_respuestas_establecidas 	= 66;
			switch ($etapa){
				case config('constantes.en_diagnostico'): //Ingreso PAF
					$fase_view = config('constantes.ncfas_fs_ingreso');

					if ($fase_caso == 0 || $fase_caso = "") $editar_ncfas = true;
				break;

				case config('constantes.en_cierre_paf'): //Cierre PAF
					$fase_view = config('constantes.ncfas_fs_cierre');
	
					if ($fase_caso == config('constantes.ncfas_fs_ingreso')) $editar_ncfas = true;
				break;
				
				case config('constantes.en_seguimiento_paf'): //Cierre PTF
					$fase_view = config('constantes.ncfas_fs_cierre_ptf');
					
					if ($fase_caso == config('constantes.ncfas_fs_cierre')) $editar_ncfas = true;
				break;
			}

			$respuestas = Respuesta::consultaOriginalNCFAS($cas_id);
			$respuestas = collect($respuestas);

			$comentarios = Respuesta::obtenerComentarios($cas_id, $fase_view);
			$archivos = Respuesta::obtenerArchivos($cas_id, $fase_view);

			$vista = 'terapeuta.encuesta';
			return view($vista,
				[
					'fase_actual'	=>	$fase_view,
					'caso'			=>	$caso,
					'dimensiones'	=>	$dimensiones,
					'fases' 		=> 	$fases,
					'alternativas' 	=> 	$alternativas,
					'respuestas'	=>	$respuestas,
					'comentarios' 	=> 	$comentarios,
					'archivos' 		=>	$archivos,
					'opcion' 		=> $etapa,
					'nombres'       => $nombres_persona,
					'rut'           => $rut_persona,
					'rutsinformato' => $rut_persona_sin_formato,
					'editar_ncfas'  => $editar_ncfas
				]
			);
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.". $e;
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	// INICIO CZ SPRINT 62 -- PROBLEMA NCFAS 3
	public function grabarDiagnosticoRes(Request $request){
		// try {
		// 	DB::beginTransaction();
		// 	$opcion = $request->opcion;

			
		// 	foreach ($request->all() as $k => $value) {
				
		// 		if ($k == "_token" || $k == "cas_id" || $k == "opcion") {
		// 			continue;
		// 		}
				
		// 		preg_match_all('/\d+/', $k, $out);
		// 		$fas_id = $out[0][1];

		// 		$respuesta = new Respuesta();
		// 		$respuesta->cas_id = $request->cas_id;
		// 		$respuesta->res_fec = Carbon::now();
				
		// 		if (strstr($k, 'radio') != false) {
					
		// 			preg_match_all('/\d+/', $k, $out);
		// 			$respuesta->fas_id = $out[0][1];
		// 			$respuesta->pre_id = $out[0][0];
		// 			$respuesta->alt_id = $value;
					
		// 		} elseif (strstr($k, 'text') != false) {
					
		// 			preg_match_all('/\d+/', $k, $out);
		// 			$respuesta->fas_id = $out[0][1];
		// 			$respuesta->pre_id = $out[0][0];
		// 			$respuesta->alt_id = null;
		// 			$respuesta->res_com = $value;
					
					
		// 		} elseif (strstr($k, 'file') != false) {
					
		// 			$request->validate([
		// 				$k => 'sometimes|file|mimes:pdf|max:1024'
		// 			], [], [$k => $value->getClientOriginalName()]);
					
		// 			$path = Storage::disk('local')->put('encuesta', $value);
		// 			// El nombre es este , -> $value->hashName();
		// 			$adjunto = new Adjunto();
		// 			$adjunto->usu_id = null;
		// 			$adjunto->cas_id = $request->cas_id;
		// 			$adjunto->adj_mod = 'encuesta';
		// 			$adjunto->adj_nom = $value->getClientOriginalName();
		// 			$adjunto->adj_cod = $path;
		// 			$adjunto->save();
					
		// 			preg_match_all('/\d+/', $k, $out);
		// 			$respuesta->fas_id = $out[0][1];
		// 			$respuesta->pre_id = $out[0][0];
		// 			$respuesta->adj_id = $adjunto->adj_id;
					
		// 		}
		// 		$resultado = $respuesta->save();
				
		// 		if (!$resultado) {
		// 			DB::rollback();
		// 			return redirect()->route('caso.diagnostico')
		// 				->with('danger', 'Ocurrio un Error Guardando Persona cx, Por Favor Verifique.', ['caso' => $request->cas_id,'opcion'=>$opcion]);
		// 		}
				
		// 	}

     	// 	$actualizaCaso = DB::update("UPDATE AI_CASO SET fas_id='".$fas_id."' where cas_id='".$request->cas_id."'");

     	// 	if (!$actualizaCaso) {
		// 			DB::rollback();
		// 			return redirect()->route('caso.diagnostico')
		// 				->with('danger', 'Ocurrio un Error Guardando Persona cx, Por Favor Verifique.', ['caso' => $request->cas_id,'opcion'=>$opcion]);
		// 		}

		// 	DB::commit();
			
		// 	return redirect()->route('caso.diagnostico', ['caso' => $request->cas_id,'opcion'=>$opcion])
		// 		->with('success', 'El diagnostico se ha ingresado.');
		// } catch(\Exception $e) {
		// 	Log::error('error: '.$e);
		// 	return redirect()->back()
		// 		->with('danger', 'ha ocurrido un error.');
		// }
	}
	// FIN CZ SPRINT 62 -- PROBLEMA NCFAS 3


	public function grabarDiagnostico(Request $request){
		try {

			DB::beginTransaction();
			$opcion = $request->opcion;

			$encuesta =  DB::select("select res_id from ai_respuesta where cas_id=".$request->cas_id." and fas_id=".$request->fas_id." and pre_id=".$request->pre_id."");

			if($encuesta){

				$respuesta = Respuesta::find($encuesta[0]->res_id);
				$respuesta->cas_id = $request->cas_id;
				$respuesta->fas_id = $request->fas_id;
				$respuesta->pre_id = $request->pre_id;
				$respuesta->alt_id = $request->alt_id;
				$respuesta->res_com = $request->res_com;
				$respuesta->res_fec = Carbon::now();
				$resultado = $respuesta->save();

			}
			else{

				$respuesta = new Respuesta();
				$respuesta->cas_id = $request->cas_id;
				$respuesta->fas_id = $request->fas_id;
				$respuesta->pre_id = $request->pre_id;
				$respuesta->alt_id = $request->alt_id;
				$respuesta->res_com = $request->res_com;
				$respuesta->res_fec = Carbon::now();
				$resultado = $respuesta->save();

			}

			$mensaje = "Actualización de Encuesta realizada con éxito.";
			
		    DB::commit();

		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		
		}catch(\Exception $e){
			DB::rollback();

			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error en el proceso de actualización de la Encuesta. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}

	//Inicio Andres F.
	// INICIO CZ SPRINT 62 -- PROBLEMA NCFAS 3
	public function cambiarFase(Request $request){
		// try {
			
		// 	DB::beginTransaction();

		// 	$opcion = $request->opcion;

		// 	$caso = Caso::find($request->cas_id);

		// 	$miFase = $caso->fas_id;
			
		// 	if ($miFase==config('constantes.ncfas_fs_ingreso')){
		// 			$resp_validadas = $this->verificaRespuestas($request->cas_id, 3);
		// 		if($resp_validadas)
		// 		$faseActual=config('constantes.ncfas_fs_cierre');
		// 		else{
		// 			return redirect()->back()->with('danger', 'El número de respuestas del caso no corresponde.');
		// 		}	
		// 	}else if($miFase==0){
		// 			$resp_validadas = $this->verificaRespuestas($request->cas_id, 1);
		// 		if($resp_validadas){
		// 		$faseActual = config('constantes.ncfas_fs_ingreso');
		// 		}else{
		// 			return redirect()->back()->with('danger', 'El número de respuestas del caso no corresponde.');
		// 		}
				
		// 	}

		// 	//dd($faseActual);

     	// 	$actualizaCaso = DB::update("UPDATE AI_CASO SET fas_id='".$faseActual."' where cas_id='".$request->cas_id."'");

		// 	DB::commit();
			
		// 	return redirect()->route('caso.diagnostico', ['caso' => $request->cas_id,'opcion'=>$opcion])
		// 		->with('success', 'El diagnostico se ha Ingresado Correctamente.');

		// } catch(\Exception $e) {
		// 	Log::error('error: '.$e);
		// 	return redirect()->back()
		// 		->with('danger', 'ha ocurrido un error, favor intente nuevamente.');
		// }
	}
	// FIN CZ SPRINT 62 -- PROBLEMA NCFAS 3
	
	// INICIO CZ SPRINT 61
	public function verificaRespuestas($id_caso, $id_fas){
		$respuesta = false;
		$num_resp = DB::select("select count(*) as cantidad from ai_respuesta where fas_id = {$id_fas} and cas_id = ".$id_caso);
		// INICIO CZ SPRINT 61 
		if($num_resp[0]->cantidad >=66)
			$respuesta = true;
     	// FIN CZ SPRINT 61
		return $respuesta;	
	}	
	// FIN CZ SPRINT 61

	//Fin Andres F.

	public function frmGrabarDiagnostico(Request $request){
		try {
			
			DB::beginTransaction();
			$opcion 	= $request->opcion;
			$finalizar 	= $request->total_input;
			$run 		= $request->rutsinformato;
			
			foreach ($request->all() as $k => $value) {
				
				if ($k == "_token" || $k == "cas_id" || $k == "opcion") {
					continue;
				}

				$var = explode("-", $k);

					if(($var[0]=='file')&&($value!=null)){
						// INICIO CZ SPRINT 61 
						$datAdjunto =  DB::select("select * from ai_respuesta where cas_id=".$request->cas_id." and fas_id=".$var[2]." and pre_id=".$var[1]." and adj_id is not null");
						
								// $request->validate($this->reglas_derivar,[],$value);
								
								$path = Storage::disk('local')->put('encuesta', $value);
								// El nombre es este , -> $value->hashName();
								if($datAdjunto){
									$adjunto = Adjunto::find($datAdjunto[0]->adj_id);
									
									$adjunto->usu_id = null;
									$adjunto->cas_id = $request->cas_id;
									$adjunto->adj_mod = 'encuesta';
									$adjunto->adj_nom = $value->getClientOriginalName();
									$adjunto->adj_cod = $path;
									$adjunto->save();

									$respuesta = Respuesta::find($datAdjunto[0]->res_id);

									$respuesta->cas_id = $request->cas_id;
									$respuesta->fas_id = $var[2];
									$respuesta->pre_id = $var[1];
									$respuesta->adj_id = $adjunto->adj_id;
									$respuesta->res_fec = Carbon::now();
									$resultado = $respuesta->save();

								}else{
								$adjunto = new Adjunto();
								$adjunto->usu_id = null;
								$adjunto->cas_id = $request->cas_id;
								$adjunto->adj_mod = 'encuesta';
								$adjunto->adj_nom = $value->getClientOriginalName();
								$adjunto->adj_cod = $path;
								$adjunto->save();
								
								$respuesta = new Respuesta();
								$respuesta->cas_id = $request->cas_id;
								$respuesta->fas_id = $var[2];
								$respuesta->pre_id = $var[1];
								$respuesta->adj_id = $adjunto->adj_id;
								$respuesta->res_fec = Carbon::now();
								$resultado = $respuesta->save();
								}

								// FIN CZ SPRINT 61
					}	
					if(($var[0]=='radio')||($var[0]=='text')&&($value!=null)){
						$encuesta =  DB::select("select res_id from ai_respuesta where cas_id=".$request->cas_id." and fas_id=".$var[2]." and pre_id=".$var[1]."");

							if($encuesta){

								$respuesta = Respuesta::find($encuesta[0]->res_id);
								$respuesta->cas_id = $request->cas_id;
								$respuesta->fas_id = $var[2];
								$respuesta->pre_id = $var[1];
								if($var[0]=='radio'){
								$respuesta->alt_id = $value;
								}else{
								$respuesta->res_com = $value;
								}
								$respuesta->res_fec = Carbon::now();
								$resultado = $respuesta->save();

							}
							else{

								$respuesta = new Respuesta();
								$respuesta->cas_id = $request->cas_id;
								$respuesta->fas_id = $var[2];
								$respuesta->pre_id = $var[1];
								if($var[0]=='radio'){
								$respuesta->alt_id = $value;
								}else{
								$respuesta->res_com = $value;
								}
								$respuesta->res_fec = Carbon::now();
								$resultado = $respuesta->save();
							}
					}

			}

			// FINALIZAR DIAGNOSTICO
			if($finalizar){
				$caso = Caso::find($request->cas_id);
			
				$miFase = $caso->fas_id;
				// CZ SPRINT 77
				if($caso->est_cas_id == config('constantes.en_cierre_paf')){
						$resp_validadas = $this->verificaRespuestas($request->cas_id, 3);
					if($resp_validadas == true){
						$faseActual = config('constantes.ncfas_fs_cierre'); //3
					}else{
						DB::rollback();
						return response()->json(array('estado' => '0', 'mensaje' => "El número de respuestas del caso no corresponde.", 'ncfas'=> 'NCFAS-G CIERRE'), 200);
						}	
				}else if($caso->est_cas_id == config('constantes.en_diagnostico') ){
						$resp_validadas = $this->verificaRespuestas($request->cas_id, 1);
					if($resp_validadas == true){
						$faseActual = config('constantes.ncfas_fs_ingreso'); //1
					}else{
						DB::rollback();
						return response()->json(array('estado' => '0', 'mensaje' => "El número de respuestas del caso no corresponde", 'ncfas'=> "NCFAS-G DIAGNOSTICO. "), 200);
						}	
				}

     			$actualizaCaso = DB::update("UPDATE AI_CASO SET fas_id='".$faseActual."' where cas_id='".$request->cas_id."'");
     			if (!$actualizaCaso){
					//  CZ SPRINT 77
					 DB::rollback();
     				$mensaje = "Hubo un error al momento de actualizar la información de la fase actual del NFAS-G en el Caso. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
     			}
			}
			
			$mensaje = "Actualización de Encuesta realizada con éxito.";	
		    DB::commit();
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		
		} catch(\Exception $e) {
			Log::info('error ocurrido:'.$e);
			$mensaje = "Hubo un error en el proceso de actualización de la Encuesta. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function generaPdfNcfas(Request $request){

		// $numero_caso = $request->cas_id;
		// $opcion = $request->opcion;

		// //dd($numero_caso);

		// $caso = Caso::find($numero_caso);
		// $casopersonaindice = CasoPersonaIndice::where('cas_id',$caso->cas_id)->get();
		// $persona = Persona::where('per_id',$casopersonaindice[0]->per_id)->get();
		// $nombres_persona = $persona[0]->per_nom.' '.$persona[0]->per_pat.' '.$persona[0]->per_mat;
		// $rut_persona_sin_formato = $persona[0]->per_run;
		// $rut_persona = Rut::parse($persona[0]->per_run.$persona[0]->per_dig)->format();

		// if (!$caso){
		// 	$mensaje = "No se Pudo Encontrar el caso, intente nuevamente.";
		// 	return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		// }

		// $faseActual = 0;

		// $miFase = $caso->fas_id;
			

		// if ($miFase==config('constantes.ncfas_fs_ingreso')){
		// 	$faseActual=config('constantes.ncfas_fs_cierre');
		// }else if($miFase==2){
		// 	$faseActual=3;
		// }else if($miFase==3){
		// 		$faseActual=4;
		// }else if($miFase==null){
		// 		$faseActual = config('constantes.ncfas_fs_ingreso');
		// }else if($miFase==0){
		// 		$faseActual = config('constantes.ncfas_fs_ingreso');
		// }

		// $fases = Fase::orderBy('fas_ord','asc')->get();
			
		// $dimensiones = DimensionEncuesta::with('preguntas')->where("dim_enc_id", "!=", config('constantes.i_ambivalencia_cuidador_niño/a'))
		// 					->where("dim_enc_id","!=",config('constantes.j_preparacion_para_la_reunificacion'))->get();
			
		// $alternativas = Alternativa::orderBy('alt_ord','asc')->get();
			
		// $sql="select * 
		// 		from 
		// 		    ai_respuesta 
		// 		where 
		// 		   cas_id = ".$numero_caso." 
		// 		   and pre_id in (select 
		// 		                        pre_id 
		// 		                  from 
		// 		                        ai_pregunta 
		// 		                  where 
		// 		                        dim_enc_id in (select 
		// 		                                             dim_enc_id 
		// 		                                       from 
		// 		                                             ai_dimension_encuesta 
		// 		                                       where 
		// 		                                             dim_enc_id between ".config('constantes.a_entorno')." and ".config('constantes.h_salud_familiar').") 
		// 		                        and pre_tip=".config('constantes.preguntas_nfcfas').") order by pre_id, fas_id";

		// $array_respuestas = DB::select($sql);
		// $respuestas = collect($array_respuestas);

		// // DESDE TERAPIA

		// if ($request->has('desde_terapeuta')) {

		// 	$respuestas_ncfasg = Respuesta::where('cas_id',$numero_caso)->whereNotNull('alt_id')->orderBy('pre_id')->orderBy('fas_id')->get();

		// 	$sql_preguntas_ncfasg = "select pre_id from ai_pregunta where dim_enc_id in (select dim_enc_id from ai_dimension_encuesta where dim_enc_id between ".config('constantes.a_entorno')." and ".config('constantes.h_salud_familiar').") and pre_tip=".config('constantes.preguntas_nfcfas');

		// 	$coleccion_de_preguntas_ncfasg = collect(DB::select($sql_preguntas_ncfasg));
		// 		$preguntas_respondidas_ncfasg_cierre = 0;
		// 		foreach ($coleccion_de_preguntas_ncfasg as $pregunta){
		// 		if ($respuestas_ncfasg->where('pre_id', $pregunta->pre_id)->where('fas_id',config('constantes.ncfas_fs_cierre'))->count()>0){
		// 	$preguntas_respondidas_ncfasg_cierre++;
		// 	}
		// }

		// $fase_a_verificar_ncfasg = ($preguntas_respondidas_ncfasg_cierre>0)?config('constantes.ncfas_fs_cierre'):config('constantes.ncfas_fs_ingreso');

		// $vista = 'terapeuta.ncfasg_terapeuta';
		// }else{
		// if ($opcion == config('constantes.en_diagnostico')){
		// 	$fase_a_verificar_ncfasg = config('constantes.ncfas_fs_ingreso');
		// }
		// if ($opcion == config('constantes.en_cierre_paf')){
		// 	$fase_a_verificar_ncfasg = config('constantes.ncfas_fs_cierre');	
		// }

		// $vista = 'terapeuta.encuesta';
		// }

		// $sql = "select r.*,p.dim_enc_id,p.pre_tip,f.fas_nom
		// 			from ai_respuesta r
		// 			inner join ai_pregunta p on p.pre_id = r.pre_id
		// 			inner join ai_fase f on f.fas_id = r.fas_id
		// 			where r.cas_id = ".$numero_caso." and p.pre_tip = 2
		// 			and r.fas_id = ".$fase_a_verificar_ncfasg."
		// 			order by r.pre_id , r.fas_id";
			
			
		// $comentarios = DB::select($sql);
			
		// $sql = "select
		// 			r.*,
		// 			p.dim_enc_id,
		// 			p.pre_tip,
		// 			f.fas_nom,
		// 			a.adj_nom,
		// 			a.adj_cod,
		// 			a.adj_id
		// 			from ai_respuesta r
		// 			inner join ai_pregunta p on p.pre_id = r.pre_id
		// 			inner join ai_fase f on f.fas_id = r.fas_id
		// 			inner join ai_adjunto a on r.adj_id = a.adj_id
		// 			where r.cas_id = ".$numero_caso." and p.pre_tip = 3
		// 			and r.fas_id = ".$fase_a_verificar_ncfasg."
		// 			order by r.pre_id , r.fas_id";
			
		// $archivos = DB::select($sql);

		// $today = Carbon::now()->format('d/m/Y');

		// $nombres ="pendiente";

		// $rut = $rut_persona;

		// // $rutsinformato = 16555454;

		// $fase_actual = $faseActual;

		// $return_vista["today"] = $today;
		// $return_vista["fase_actual"] = $fase_actual;
		// $return_vista["caso"] = $caso;
		// $return_vista["dimensiones"] = $dimensiones;
		// $return_vista["fases"] = $fases;
		// $return_vista["alternativas"] = $alternativas;
		// $return_vista["respuestas"] = $respuestas;
		// $return_vista["comentarios"] = $comentarios;
		// $return_vista["archivos"] = $archivos;
		// $return_vista["nombres_persona"] = $nombres_persona;
		// $return_vista["rut"] = $rut;
		// // $return_vista["rutsinformato"] = $rutsinformato;
		// $return_vista["opcion"] = $opcion;

		// $returnHTML = view('pdf.ncfas',$return_vista)->render();

 	//  	$pdf = \PDF::loadHTML($returnHTML);
	 	
  //    	return $pdf->download('resultado_ncfas_('.date("d-m-Y").').pdf');

     	// $data = \PDF::loadView('pdf.ncfas', $return_vista)
      //   ->save(storage_path('app/') . 'archivo_okok.pdf');


		return  view('ficha.ncfas');


	}
}