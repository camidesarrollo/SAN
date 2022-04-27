<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Freshwork\ChileanBundle\Rut;
// INICIO CZ SPRINT 57
use App\Modelos\{Accion, Ofertas, Terapia, EvaluacionFase, EvaluacionPregunta, EvaluacionDimension, EvaluacionRespuesta, EvaluacionAlternativa, Usuarios, Persona, definicionProblema};
// FIN CZ SPRINT 57


class EvaluacionController extends Controller
{
	protected $accion;
	protected $ofertas;
	protected $terapia;
	
	public function __construct(
		Accion			$accion,
		Ofertas			$ofertas,
		Terapia 		$terapia
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->accion		= $accion;
		$this->ofertas		= $ofertas;
		$this->terapia 		= $terapia;
	}

	public function show(Request $request){
		try{
			$tera_id 					= $request->tera_id;
			$run_sin_formato			= $request->run_sin_formato;
			$run_con_formato			= $request->run_con_formato;	
			$evaluacion 				= array();
			$diagnostico 				= false;
			$ejecucion 					= false;
			$seguimiento 				= false;
			$diagnostico_visualizacion 	= false;
			$ejecucion_visualizacion	= false;
			$seguimiento_visualizacion 	= false;
			$fase 						= "";
			$etapa_visualizacion		= false;

			$lis_ter = Terapia::find($tera_id);
			if (!$lis_ter) throw new \Exception("Ocurrio un error al momento de buscar información de la terapia. Por favor intente nuevamente.");

			$lis_terapeuta = Usuarios::find($lis_ter->usu_id);
			if (!$lis_terapeuta) throw new \Exception("Ocurrio un error al momento de buscar información del terapeuta asignado. Por favor intente nuevamente.");

			$nombre_terapeuta = $lis_terapeuta->nombres." ".$lis_terapeuta->apellido_paterno." ".$lis_terapeuta->apellido_materno;
			$dv_run = Rut::set($lis_terapeuta->run)->calculateVerificationNumber();
			$run_terapeuta = Rut::parse($lis_terapeuta->run.$dv_run)->format();


			$lis_persona = Persona::where('per_run', $run_sin_formato)->first();
			if (!$lis_persona) throw new \Exception("Ocurrio un error al momento de buscar información del NNA. Por favor intente nuevamente.");

			$nombre_nna = $lis_persona->per_nom." ".$lis_persona->per_pat." ".$lis_persona->per_mat;
			//dd($lis_ter);
			$estado_actual_terapia = $lis_ter->est_tera_id;
			switch ($estado_actual_terapia){
				case config('constantes.gtf_diagnostico'):
					$diagnostico 				= true;
					$evaluacion 				= new \stdClass;
					$evaluacion->titulo 		= "Evaluación Inicial Terapia Familiar";


					if (session()->all()["editar"]){
						if ($lis_ter->ter_eva_ini == 1){
							$diagnostico_visualizacion = true;
							$etapa_visualizacion 	   = true;
						
						}
					}elseif (session()->all()["visualizar"]){
						$diagnostico_visualizacion = true;
						$etapa_visualizacion 	   = true;

					}
				break;

				case config('constantes.gtf_ejecucion'):
					$ejecucion 	 				= true;
					$evaluacion 				= new \stdClass;
					$evaluacion->titulo 		= "Evaluación Cierre Terapia Familiar";

					if (session()->all()["editar"]){
						if ($lis_ter->ter_eva_cie == 1){
							$ejecucion_visualizacion 	= true;
							$etapa_visualizacion 	   	= true;	
						} 
					}elseif (session()->all()["visualizar"]){
						$ejecucion_visualizacion 	= true;
						$etapa_visualizacion 	   	= true;	

					}
				break;

				case config('constantes.gtf_seguimiento'):
					$seguimiento 				= true;
					$evaluacion 				= new \stdClass;
					$evaluacion->titulo 		= "Evaluación Seguimiento Terapia Familiar";

					if (session()->all()["editar"]){
						if ($lis_ter->ter_eva_seg == 1){
							$seguimiento_visualizacion 	= true;
							$etapa_visualizacion 	   	= true;	
						} 
					}elseif (session()->all()["visualizar"]){
						$seguimiento_visualizacion 	= true;
						$etapa_visualizacion 	   	= true;	

					} 

				break;

				default:
					$evaluacion 				= new \stdClass;
					$evaluacion->titulo 		= "Evaluación Terapia Familiar";
					$etapa_visualizacion		= true;
			}

			//if (empty($evaluacion)) throw new \Exception("Ocurrio un error al momento de buscar información del NNA. Por favor intente nuevamente.");

			$evaluacion->dimensiones 	= array();
			$lis_fase			= EvaluacionFase::orderBy('eva_fase_ord', 'asc')->get();
			$lis_dimension 		= EvaluacionDimension::orderBy('eva_dim_ord', 'asc')->get();
			$lis_alternativa 	= EvaluacionAlternativa::orderBy('eva_alt_ord', 'asc')->get();
			foreach ($lis_dimension AS $c1 => $v1){
				$evaluacion->dimensiones[$c1] = new \stdClass;
				$evaluacion->dimensiones[$c1]->eva_dim_id  = $v1->eva_dim_id;
				$evaluacion->dimensiones[$c1]->eva_dim_nom = $v1->eva_dim_nom;
				$evaluacion->dimensiones[$c1]->eva_dim_ord = $v1->eva_dim_ord;
				$evaluacion->dimensiones[$c1]->eva_dim_not = $v1->eva_dim_not;
				$evaluacion->dimensiones[$c1]->preguntas   = array();

				$lis_pregunta 		= EvaluacionPregunta::where(['eva_dim_id' => $v1->eva_dim_id, 'eva_pre_tip' => 1])->orderBy('eva_pre_ord', 'asc')->get();
				foreach($lis_pregunta AS $c2 => $v2){
					$evaluacion->dimensiones[$c1]->preguntas[$c2] = new \stdClass;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->eva_pre_id  = $v2->eva_pre_id;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->eva_pre_nom = $v2->eva_pre_nom;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->eva_pre_ord = $v2->eva_pre_ord;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->eva_pre_tip = $v2->eva_pre_tip;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->eva_dim_id  = $v2->eva_dim_id;
					$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases  = array();

					foreach($lis_fase AS $c3 => $v3){
						$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3] = new \stdClass;
						$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->eva_fase_id 	= $v3->eva_fase_id;
						$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->eva_fase_nom = $v3->eva_fase_nom;
						$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->eva_fase_ord = $v3->eva_fase_ord;

						switch ($v3->eva_fase_id){
							case config('constantes.evaluacion_inicial'):
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->etapa = $diagnostico;
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->visualizacion = $diagnostico_visualizacion;

								if ($diagnostico) $fase = config('constantes.evaluacion_inicial');
							break;

							case config('constantes.evaluacion_cierre'):
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->etapa = $ejecucion;
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->visualizacion = $ejecucion_visualizacion;

								if ($ejecucion) $fase = config('constantes.evaluacion_cierre');
							break;

							case config('constantes.evaluacion_seguimiento'):
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->etapa = $seguimiento;
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->visualizacion = $seguimiento_visualizacion;

								if ($seguimiento) $fase = config('constantes.evaluacion_seguimiento');
							break;
						}						

						$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas = array();

						foreach($lis_alternativa AS $c4 => $v4){
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4] = new \stdClass;
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->eva_alt_id = $v4->eva_alt_id;
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->eva_alt_nom = $v4->eva_alt_nom;
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->eva_alt_val = $v4->eva_alt_val;
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->eva_alt_ord = $v4->eva_alt_ord;
							$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->eva_alt_clas = $v4->eva_alt_clas;

							$filtro_consulta = array(); 
							$filtro_consulta["tera_id"] 	= $tera_id; 
							$filtro_consulta["eva_fase_id"] = $v3->eva_fase_id;
							$filtro_consulta["eva_pre_id"] 	= $v2->eva_pre_id;
							$filtro_consulta["eva_alt_id"] 	= $v4->eva_alt_id;
							$respuesta = EvaluacionRespuesta::where($filtro_consulta)->first();

							if (count($respuesta) > 0){
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->respuesta = true;
							}else{
								$evaluacion->dimensiones[$c1]->preguntas[$c2]->fases[$c3]->alternativas[$c4]->respuesta = false;
							}
						}
					}
				}
			}

			$comentario = EvaluacionPregunta::where(['eva_dim_id' => 1, 'eva_pre_tip' => 2])->get();
			if (count($comentario) == 0) throw new \Exception("Ocurrio un error al momento de buscar información del motivo de consulta de la terapia. Por favor intente nuevamente.");

			$valor_comentario = EvaluacionRespuesta::where(["tera_id" => $tera_id, "eva_fase_id" => $fase, "eva_pre_id" => $comentario[0]->eva_pre_id])->first();
			if ($valor_comentario){
				$valor_comentario = $valor_comentario->eva_res_alt_com;

			}

			$caso = $lis_ter->cas_id;

			return view('ficha.terapia.terapia_evaluacion',
				[
					'evaluacion'		=> $evaluacion,
					'run_sin_formato' 	=> $run_sin_formato,
					'run_con_formato' 	=> $run_con_formato,
					'nombre_terapeuta' 	=> $nombre_terapeuta,
					'run_terapeuta' 	=> $run_terapeuta,
					'nombre_nna' 		=> $nombre_nna,
					'tera_id' 			=> $tera_id,
					'fase'				=> $fase,
					'comentario'		=> $comentario,
					'valor_comentario'	=> $valor_comentario,
					'etapa_visualizacion' => $etapa_visualizacion,
					'id_caso'    => $caso
					/*'diagnostico' 		=> $diagnostico, 			
					'ejecucion' 		=> $ejecucion, 				
					'seguimiento' 		=> $seguimiento, 			
					'diagnostico_visualizacion' => $diagnostico_visualizacion, 
					'ejecucion_visualizacion' 	=> $ejecucion_visualizacion,
					'seguimiento_visualizacion' => $seguimiento_visualizacion, */
				]);

		}catch(\Exception $e){
			Log::error('error: '.$e);
// INICIO CZ SPRINT 66
			$mensaje = "Ocurrio un error al momento de visualizar la evaluación, intente nuevamente.". $e;
			// FIN CZ SPRINT 66
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}

	public function guardarEvaluacionTemporal(Request $request){
		try{
			if (!isset($request->tera_id) || $request->tera_id == "" || !isset($request->eva_fase_id) || $request->eva_fase_id == "" || !isset($request->eva_pre_id) || $request->eva_pre_id == ""){
				$mensaje = "Faltan parámetros para  guardar la respuesta. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

			}

			DB::beginTransaction();

			$guardar = EvaluacionRespuesta::where(["tera_id" => $request->tera_id, "eva_fase_id" => $request->eva_fase_id, "eva_pre_id" => $request->eva_pre_id])->first();

			if (count($guardar) == 0) $guardar = new EvaluacionRespuesta();

			$guardar->tera_id 		= $request->tera_id;
			$guardar->eva_fase_id 	= $request->eva_fase_id;
			

			if (isset($request->eva_alt_id) && $request->eva_alt_id != "") $guardar->eva_alt_id = $request->eva_alt_id;
		

			$guardar->eva_pre_id 	= $request->eva_pre_id;

			// FIN CZ SPRINT 57
			$respuesta = $guardar->save();
			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la respuesta ingresada. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();
			$mensaje = "Respuesta registrada con éxito.";
			return response()->json(array('estado' => '1', 'respuesta' => $guardar->eva_res_id, 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			Log::error('error: '.$e);
			// INICIO CZ SPRIN 66
			$mensaje = "Hubo un error al momento de registrar la respuesta ingresada. Por favor intente nuevamente.";
			DB::rollback();
			return response()->json($mensaje, 400);
			// FIN CZ SPRINT 66
		}
	}
//INICIO CZ SPRINT  57
	public function guardarRespuestaEvaluacionMotivoTF(Request $request){
		$datos =  $request->all();

			$listar_respuesta = EvaluacionRespuesta::where("tera_id", "=", $datos['tera_id'])->where("eva_fase_id", "=", $datos['eva_fase_id'])->get();
			$evaluacionRespuesta11 = DB::select("select count(*) as cantidad from ai_evaluacion_respuesta WHERE tera_id = ".$datos['tera_id']. "and EVA_FASE_ID = ".$datos['eva_fase_id']. "and EVA_PRE_ID = 11");

			if($evaluacionRespuesta11[0]->cantidad == 0){
					$definicionProblema = definicionProblema::where(["tera_id" =>$datos['tera_id']])->get();
			
					$guardar_ai_evaluacion_respuesta = new EvaluacionRespuesta();

					$id_i_evaluacion_respuesta = DB::Select("Select max(eva_res_id)+1 as id from ai_evaluacion_respuesta  WHERE tera_id = ".$datos['tera_id']." and EVA_FASE_ID = ".$datos['eva_fase_id']);
			
					$guardar_ai_evaluacion_respuesta->eva_res_id = $id_i_evaluacion_respuesta[0]->id;
					$guardar_ai_evaluacion_respuesta->tera_id = $datos['tera_id'];
					$guardar_ai_evaluacion_respuesta->eva_fase_id =$datos['eva_fase_id'];
					$guardar_ai_evaluacion_respuesta->eva_pre_id 	= 11;
					$guardar_ai_evaluacion_respuesta->eva_res_alt_com = $definicionProblema[0]->def_pro_preg_1;
					$guardar_ai_evaluacion_respuesta->save();

					if (!$guardar_ai_evaluacion_respuesta){
						$mensaje = "Hubo un error al momento de finalizar la evaluación. Por favor intente nuevamente.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
					}else{
						DB::commit();
						$mensaje = "Se ha insertado respuesta de Motivo TF con exito.";
						return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
					}

				}else{
				$mensaje = "Se ha insertado respuesta de Motivo TF con exito.";
				return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
			}
				}
	//FIN CZ SPRINT 57
	public function finalizarEvaluacionTerapia(Request $request){
		
		try{
				
			if (!isset($request->eva_tera_id) || $request->eva_tera_id == "" || !isset($request->eva_run_sin_formato) || $request->eva_run_sin_formato == "" || !isset($request->eva_run_con_formato) || $request->eva_run_con_formato == "" || !isset($request->eva_fase) || $request->eva_fase == ""){
				$mensaje = "Faltan parámetros para finalizar la evaluación. Por favor verifique e intente nuevamente este, es el mensaje.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$actualizar_terapia = Terapia::find($request->eva_tera_id);
			if (!$actualizar_terapia){
				$mensaje = "No se encuentra información de la terapia. Por favor verifique e intente nuevamente.";

				return redirect()->back()->with('danger', $mensaje);
			}

			switch ($request->eva_fase){
				case config('constantes.evaluacion_inicial'):
					if ($actualizar_terapia->ter_eva_ini == 1){
						$mensaje = "Ya se encuentra finalizada esta evaluación en esta etapa. Por favor verifique la información.";

						return redirect()->back()->with('danger', $mensaje);
					}

					$actualizar_terapia->ter_eva_ini = 1;
					$fase = config('constantes.evaluacion_inicial');
				break;

				case config('constantes.evaluacion_cierre'):
					if ($actualizar_terapia->ter_eva_cie == 1){
						$mensaje = "Ya se encuentra finalizada esta evaluación en esta etapa. Por favor verifique la información.";

						return redirect()->back()->with('danger', $mensaje);
					}

					$actualizar_terapia->ter_eva_cie = 1;
					$fase = config('constantes.evaluacion_cierre');
				break;

				case config('constantes.evaluacion_seguimiento'):
					if ($actualizar_terapia->ter_eva_seg == 1){
						$mensaje = "Ya se encuentra finalizada esta evaluación en esta etapa. Por favor verifique la información.";

						return redirect()->back()->with('danger', $mensaje);
					}

					$actualizar_terapia->ter_eva_seg = 1;
					$fase = config('constantes.evaluacion_seguimiento');
				break;
			}

			$dato = DB::Select('select count(*) as cantidad from "AI_EVALUACION_RESPUESTA" where "TERA_ID" ='. $request->eva_tera_id .'and "EVA_FASE_ID" = '.$request->eva_fase);
			// INICIO CZ SPRINT 60
			if ($dato[0]->cantidad < 10){
				$mensaje = "Error! Existen preguntas sin respuestas. Por favor verifique e intente nuevamente.";

				return redirect()->back()->with('danger', $mensaje);
			}
			// FIN CZ SPRINT 60

			//FIN CZ SPRINT  57
			$resultado = $actualizar_terapia->save();
			if (!$resultado){
				$mensaje = "Hubo un error al momento de finalizar la evaluación. Por favor intente nuevamente.";

				return redirect()->back()->with('danger', $mensaje);
			}

			DB::commit();
			return redirect()->route('gestion-terapia-familiar.evaluacion', ['tera_id' => $request->eva_tera_id, 'run_sin_formato' => $request->eva_run_sin_formato, 'run_con_formato' => $request->eva_run_con_formato])->with('success', 'Se finalizo con éxito la evaluación.');
		}catch(\Exception $e){
			DB::rollback();
			return redirect()->back()->with('danger', 'hubo un error al momento de procesar su solicitud. Por favor intente nuevamente.');
		}
	}	

	
}