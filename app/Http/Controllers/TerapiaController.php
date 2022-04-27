<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\App;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Modelos\NNAAlertaManualCaso;	
use App\Modelos\Comuna;
use App\Modelos\Usuarios;
use App\Modelos\Terapia;
use App\Modelos\Respuesta;
use App\Modelos\Caso;
use App\Modelos\CasoTerapeuta;
use App\Modelos\EstadoTerapiaBitacora;
use App\Modelos\definicionProblema;
use App\Modelos\PautaTrabFamTer;
use App\Modelos\descripcionFuncionamiento;
use App\Modelos\documentoPlanTerapiaFamiliar;
// INICIO CZ SPRINT 78
use App\Modelos\CasosGestionEgresado;
// FIN CZ SPRINT 78
// INICIO CZ SPRINT 74  
use App\Modelos\NotificacionAsignacion;
use App\Modelos\DatosPersona;
// CZ SPRINT 74  
use App\Modelos\Funcion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Modelos\TerapiaPtf;
use App\Modelos\TerapiaPtfDetalle;
use App\Modelos\EvaluacionPregunta;
use App\Modelos\EvaluacionRespuesta;
use App\Modelos\TerapiaSeguimientoDetalle;
use App\Modelos\SesionTerapiaFamiliar;
use App\Modelos\PersonaUsuario;
use App\Modelos\Persona;
use App\Modelos\TiempoIntervencionTerapia;
use Freshwork\ChileanBundle\Rut;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use App\Traits\CasoTraitsGenericos;
use App\Http\Controllers\MailController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;


class TerapiaController extends Controller
{
	protected $reglas_doc_invit = [
		'doc_invit' => 'file|mimes:pdf,jpeg,png|max:3072'
	];

	protected $reglas_doc_genograma = [
		'file_genograma' => 'file|mimes:pdf,jpeg,png|max:3072'
	];

	protected $reglas_doc_encu = [
		'doc_encu' => 'file|mimes:pdf,jpeg,png|max:3072'
	];

	protected $reglas_doc_renuncia = [
		'doc_renuncia' => 'file|mimes:pdf,jpeg,png|max:3072'
	];
	
	protected $caso;
	use CasoTraitsGenericos;

	public function __construct(
		//Pruebas unitarias
		Caso $caso
	)
	{
		$this->caso	= $caso;
	}

	public function asignarTerapeuta(){
		if(session()->all()){
		$com_ses 	= array();
		$com_id 	= session()->all()['com_id'];

		if (isset($com_id) && $com_id != ""){
			$com_id = explode(",", $com_id);

			if (count($com_id) > 0) $com_ses = Comuna::whereIn("com_id", $com_id)->get();
		}


		$cantidad_casos = NNAAlertaManualCaso::select('cas_id', DB::raw('count(cas_id) AS total'))->where('cod_com', $com_ses[0]->com_cod)
			->where('nec_ter','1')
			->where('ter_id',null)
			->where('est_cas_fin','<>','1')
            ->whereIn('es_cas_id', [config('constantes.en_elaboracion_paf'),
            						config('constantes.en_ejecucion_paf'),
									config('constantes.en_cierre_paf'),
									config('constantes.en_seguimiento_paf')]
				)
		->groupBy('cas_id')->get();

		$casos = NNAAlertaManualCaso::where('cod_com', $com_ses[0]->com_cod)
			->where('nec_ter','1')
			->where('ter_id',null)
			->where('est_cas_fin','<>','1')
            ->whereIn('es_cas_id', [config('constantes.en_elaboracion_paf'),
            						config('constantes.en_ejecucion_paf'),
									config('constantes.en_cierre_paf'),
									config('constantes.en_seguimiento_paf')]
				)
			->get();

		$cantidad_casos = count($cantidad_casos);

		$usuarios = new Usuarios();
		$terapeutas = $usuarios->getTerapeutas();

		$icono = Funcion::iconos(141);

		return view('terapia.asignar_terapeuta',['com_cod'=>$com_ses[0]->com_cod,'cantidad_casos'=>$cantidad_casos,'terapeutas'=>$terapeutas, 'icono'=>$icono  ]);
		
	}
	}
	
	
	public function justificacionTerapia(Request $request){
		$cas_id = $request->cas_id;
		$caso = Caso::select('cas_just_terapia')->find($cas_id);
		return $caso;
	}

	public function nombreGestor(Request $request){
		$cas_id = $request->cas_id;
		$nombre_gestor = NNAAlertaManualCaso::select('usuario_nomb')->where('cas_id',$cas_id)->get();
		return $nombre_gestor;
	}

	
	public function dataAsignarTerapeuta(Request $request){
		
		$com_cod = $request->com_cod;

		return Datatables::of(NNAAlertaManualCaso::query()
		->where('cod_com', $com_cod)
		->where('nec_ter','1')
		->where('ter_id',null)
		->where('per_ind',1)
		->where('est_cas_fin', '<>', '1')
		->whereIn('es_cas_id',[	config('constantes.en_elaboracion_paf'),
								config('constantes.en_ejecucion_paf'),
								config('constantes.en_cierre_paf'),
								config('constantes.en_seguimiento_paf')]
				)
		)->make(true);
	}
	// CZ SPRINT 74  
	public function envioCorreoTerapeuta($terapeuta,$caso){
		$objDemo = new \stdClass();
		$objDemo->tipo_correo = 'asignacionTerapeuta';
		$objDemo->caso = $caso;
		Mail::to($terapeuta)->send(new MailController($objDemo));

	}
	// CZ SPRINT 74  
	public function crearTerapia(Request $request){
		try{

			$cas_id = $request->cas_id;
			$ter_id = $request->tera_id;
			$aprobacion_terapia = $request->aprobar_terapia;
			$est_tera_id = config('constantes.gtf_invitacion'); 

			DB::beginTransaction();


			if ($aprobacion_terapia==2){
				$caso = Caso::find($cas_id);
				$caso->cas_just_rech_coord = $request->justificacion_coordinador;
				$caso->fec_just_rech_coord = Carbon::now();
				$caso->id_just_rech_coord = session('id_usuario');
				$caso->nec_ter = null;
				$caso->cas_just_terapia = null;
				//$caso->save();
				$resultado = $caso->save();
				if (!$resultado){
				   	   DB::rollBack();
				       $mensaje = "Error al momento de rechazar la terapia. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }
			}else{
			
				$cas_ter_id	= CasoTerapeuta::max('cas_ter_id');
				$cas_ter_id = $cas_ter_id + 1;

				$casoTerapeuta = new CasoTerapeuta();
				$casoTerapeuta->cas_ter_id = $cas_ter_id;
				$casoTerapeuta->ter_id = $ter_id;
				$casoTerapeuta->cas_id = $cas_id;
				$casoTerapeuta->cas_ter_est = 1;
				//$casoTerapeuta->save();
				$resultado = $casoTerapeuta->save();
				if (!$resultado){
				   	   DB::rollBack();
				       $mensaje = "Error al momento de asignar el terapeuta. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }



				$terapia = new Terapia();
				$terapia->cas_id = $cas_id;
				$terapia->usu_id = $ter_id;
				$terapia->est_tera_id = $est_tera_id;
				// INICIO CZ SPRINT 69
				$terapia->flag_modelo_terapia = 2;
				$terapia->ter_com_fir = 7;
				// FIN CZ SPRINT 69
				//$terapia->save();
				$resultado = $terapia->save();
				if (!$resultado){
				   	   DB::rollBack();
				       $mensaje = "Error al momento de asignar el terapeuta. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }


				$tera_id = $terapia->tera_id; 

				$usuario = Usuarios::find($ter_id);
				$nombre_terapeuta = $usuario->nombres.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
				$this->envioCorreoTerapeuta($usuario->email, $cas_id);
				$bitacora = new EstadoTerapiaBitacora();
				$bitacora->tera_id = $tera_id;
				$bitacora->est_tera_id = $est_tera_id;
				$bitacora->tera_est_tera_des = "Terapia Asignada a: ".$nombre_terapeuta;
				//$bitacora->save();
				$resultado = $bitacora->save();
				// CZ SPRINT 74  
				$persona = DB::select('Select * from  ai_persona inner join ai_caso_persona_indice on  ai_persona.per_id = ai_caso_persona_indice.per_id where ai_caso_persona_indice.per_ind = 1 and ai_caso_persona_indice.cas_id ='. $cas_id);
				$nombreNNA = $persona[0]->per_nom;
				$rutFormato = Rut::parse($persona[0]->per_run.$persona[0]->per_dig)->format(); 
				$id_usuario = $ter_id;
				$id = $tera_id;
				$tipo = 2;
				$mensaje = 'Se ha asignado nuevo NNA '.$nombreNNA[0].'.'.$persona[0]->per_pat.'  '.$rutFormato. ' para su gestión.';
				$estado = 1;
				NotificacionAsignacion::crearNotificiacion($id_usuario, $id, $tipo, $mensaje, $estado);
				// CZ SPRINT 77
				TiempoIntervencionTerapia::crearTiempoIntervencion($id);
				// CZ SPRINT 74  
				if (!$resultado){
				   	   DB::rollBack();
				       $mensaje = "Error al momento de asignar el terapeuta. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }
			}

			DB::commit();

			// $datos_nna =  DatosPersona::where('cas_id',$cas_id)->first();
			// $this->envioCorreoTerapeuta($datos_nna,$usuario);
			return response()->json(array('estado' => '1',
				'mensaje' => 'Se asignó la terapia'),200);


		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(array('estado' => '0', 'mensaje' =>'Error al asignar el terapueta: '. $e), 400);
		}

	}

	public function cambioBitacoraTerapia(request $request){

		try{

			DB::beginTransaction();

			$tera_id = $request->tera_id;

			switch ($request->option){

				case '20': //Invitacion

					$estado_terapia = config('constantes.gtf_invitacion');
					$comentario = $request->comentario;

					break;

				case '30': //Diagnostico

					$estado_terapia = config('constantes.gtf_diagnostico');
					$comentario = $request->comentario;

					break;

				case '40': //Ejecución

					$estado_terapia = config('constantes.gtf_ejecucion');
					$comentario = $request->comentario;

					break;

				case '50': //Seguimiento

					$estado_terapia = config('constantes.gtf_seguimiento');
					$comentario = $request->comentario;

					break;

			}

			$terapia_estado = EstadoTerapiaBitacora::where("tera_id", "=", $tera_id)->where("est_tera_id", "=", $estado_terapia)->first();
			$terapia_estado->tera_est_tera_des = $comentario;
			
			$resultado = $terapia_estado->save();
				
			if (!$resultado) {
				DB::rollback();
				$mensaje = "Error al momento de actualizar comentario del estado de la terapia. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
				
			$mensaje = "Actualización de bitácora realizada con éxito.";

			DB::commit();
			
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);


	}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error en el proceso de actualización de bitacora de terapia. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
	}


	}

	public function procesoTerapiaCaso(Request $request){
		try{
	   	   $run 	= $request->run;
		   $opcion 	= $request->option;
		   $cas_id = $request->cas_id;

		   $file_vista 			= "";
		   $estado_actual_caso 	= "";
		   $estados 			= array();
		   $return_vista 		= array();

		   $terapia = Terapia::where('cas_id',$cas_id)->get();
		   $estado_actual_terapia = $terapia[0]->est_tera_id;

		   $tera_id = $terapia[0]->tera_id;
	   	   $bitacoras_estados_terapia = Helper::bitacorasEstadosTerapia($tera_id);
		   $return_vista["bitacoras_estados"] 	= $bitacoras_estados_terapia;

		   //FORMATEO RUN
		   $dv_run 				= Rut::set($run)->calculateVerificationNumber();
		   $run_formateado 		= Rut::parse($run.$dv_run)->format();
		   $return_vista["run"] = $run;
		   $return_vista["run_terapia_formateado"] = $run_formateado;

		   $return_vista["tera_id"] = $tera_id;
		   $return_vista["caso_id"] = $cas_id;
		   $nna_teparia = $this->caso->informacionNNATerapia($cas_id);
		   $return_vista["estado_actual_terapia"] = $nna_teparia[0]->est_tera_id;
		   $return_vista["nna_teparia"] = $nna_teparia[0];
		   $return_vista["id_terapeuta"] = $nna_teparia[0]->usu_id;

		   //VALIDACION DE PERMISOS X PERFIL
		   $return_vista["modo_visualizacion"] = "";
		   $return_vista["habilitar_funcion"] = false;
		   if ($estado_actual_terapia == $opcion){
				if (session()->all()["editar"]){
					$return_vista["modo_visualizacion"] = 'edicion';

				}else if (!session()->all()["editar"]){
					if (session()->all()["visualizar"]) $return_vista["modo_visualizacion"] = 'visualizacion';

				}	
		   }else if ($estado_actual_terapia != $opcion){
		   		if (session()->all()["visualizar"]) $return_vista["modo_visualizacion"] = 'visualizacion';

		   }
			
		    switch ($opcion){
			   	case config('constantes.gtf_invitacion'): // BOTON INVITACION
					default:
					$file_vista = "ficha.terapia.gtf_invitacion";
				break;
			   
				case config('constantes.gtf_diagnostico'): // BOTON DIAGNOSTICO
					$return_vista["evaluacion_inicial_realizada"] = $nna_teparia[0]->ter_eva_ini;
					$return_vista["ter_com_fir"] = $nna_teparia[0]->ter_com_fir;

					$file_vista = "ficha.terapia.gtf_diagnostico";
				break;

				case config('constantes.gtf_ejecucion'): // BOTON EJECUCION
					$return_vista["evaluacion_cierre_realizada"] = $nna_teparia[0]->ter_eva_cie;

					$file_vista = "ficha.terapia.gtf_ejecucion";

				break;

				case config('constantes.gtf_seguimiento'): // BOTON SEGUIMIENTO
					$return_vista["evaluacion_seguimiento_realizada"] = $nna_teparia[0]->ter_eva_seg;
					$file_vista = "ficha.terapia.gtf_seguimiento";
				break;

				case config('constantes.gtf_resumen'): // BOTON RESUMEN
				break;

				case config('constantes.gtf_familia_rechaza_participacion'): // RECHAZO 1
					$file_vista = "ficha.terapia.gtf_resumen";
				break;

				case config('constantes.gtf_Familia_no_aplica'): // RECHAZO 2
					$file_vista = "ficha.terapia.gtf_resumen";
				break;

				case config('constantes.gtf_nna_presenta_vulneracion_derechos'): // RECHAZO 3
					$file_vista = "ficha.terapia.gtf_resumen";
				break;

				case config('constantes.gtf_familia_no_asiste'):// RECHAZO 4
					$file_vista = "ficha.terapia.gtf_resumen";
				break;

				case config('constantes.gtf_familia_renuncia_a_la_tf'): // RECHAZO 5
					$file_vista = "ficha.terapia.gtf_resumen";
				break;
			}
		    $returnHTML = view($file_vista, $return_vista)->render();
		   
		    $mensaje = "Información mostrada éxitosamente.";
		    return response()->json( array('success' => true, 'html'=>$returnHTML) );
		}catch(\Exception $e){
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error al momento de mostrar la información. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}
	}


	public function documentoInvitacionTerapia(Request $request){
		try{
			//$request->validate($this->reglas_doc_invit,[]);

			//VALIDACION DE TAMAÑO DE ARCHIVO
		 	$validacion_size = Validator::make($request->all(), ['doc_invit' => 'file|max:5120']);
	 		if ($validacion_size->fails()){
				$mensaje = "Error al subir documento, tamaño máximo permitido 5 MB. Por favor verificar e intentar nuevamente.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }

			//VALIDACION DE EXTENSIÓN DE ARCHIVO
			$validacion_extension = Validator::make($request->all(), ['doc_invit' => 'file|mimes:pdf,jpeg,png']);

			if ($validacion_extension->fails()){
				$mensaje = "Extensión de archivo no permitida. Por favor subir un documento con las siguientes extensiones: jpg, png o pdf.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }


			DB::beginTransaction();

			if(!$request->file('doc_invit')){
				
				$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

        	$files = $request->file('doc_invit');

        	$tera_id = $request->tera_id;

        	$destinationPath = 'doc';

        	$doc_fec = Carbon::now();

   		    $extension = $files->getClientOriginalExtension();

        	$filename = "carta_de_invitacion_".$tera_id."(".date("dmY").").".$extension;

            $upload_success = $files->move($destinationPath, $filename);

			$terapia = Terapia::find($tera_id);
			$terapia->ter_doc_invi = $filename;
			$terapia->ter_doc_invi_fec = Carbon::createFromFormat('d/m/Y H:i:s', date('d/m/Y G:i:s'));
			$respuesta = $terapia->save();

			if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir el documento de Aceptación o Rechazo. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }


     		// $doc_invitacion = DB::update("update AI_TERAPIA set ter_doc_invi='".$filename."'  
     		// 				where tera_id=".$tera_id);
			
			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'
				, 'filename' => $filename ),200);
		
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);

			$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";
			if (!is_null($e->getMessage())  && $e->getMessage() != "") $mensaje = $e->getMessage();
			
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}		
	}

	public function verificarInvitacion(Request $request){

		$terapia = Terapia::find($request->tera_id);
		
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;
		$i=0;

		// se verifica el documento de invitacion
		if (is_null($terapia->ter_doc_invi) || $terapia->ter_doc_invi == ""){
			$array_respuesta['mensajes'][$i++] = 'Debe subir el Documento de Invitación';
			$array_respuesta['respuesta'] = 0;
		}

		return $array_respuesta;
	}

	public function verificarEjecucion(Request $request){
	
		$tera_id = $request->tera_id;
		$terapia = Terapia::find($tera_id);
		$i=0;
		$sw_ptf = true;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;


		//////////////////////////////
		// PAUTA DE TRABAJO FAMILIAR
		/////////////////////////////
		$pauta_trabajo_familiar_ter = PautaTrabFamTer::where('tera_id',$tera_id)->first();

		if (!$pauta_trabajo_familiar_ter){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la pauta de trabajo familiar';
			$array_respuesta['respuesta'] = 0;
		}else{

			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_1==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_1==''){
					$sw_ptf = false;
			}
			// if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_2==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_2==''){
			// 		$sw_ptf = false;
			// }
			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_3==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_3==''){
					$sw_ptf = false;
			}
			// if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_4==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_4==''){
			// 		$sw_ptf = false;
			// }
			// if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_5==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_5==''){
			// 		$sw_ptf = false;
			// }
			// if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_6==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_6==''){
			// 		$sw_ptf = false;
			// }
			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_7==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_7==''){
					$sw_ptf = false;
			}
			// if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_8==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_8==''){
			// 		$sw_ptf = false;
			// }
			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_9==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_9==''){
					$sw_ptf = false;
			}
			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_10==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_10==''){
					$sw_ptf = false;
			}
			if ($pauta_trabajo_familiar_ter->trab_fam_ter_preg_11==null || $pauta_trabajo_familiar_ter->trab_fam_ter_preg_11==''){
					$sw_ptf = false;
			}

			if (!$sw_ptf){
				$array_respuesta['mensajes'][$i++] = 'Debe completar la pauta de trabajo familiar';
				$array_respuesta['respuesta'] = 0;

			}

		}

		//////////////////////////////////////
		// EVALUACION CIERRE TERAPIA FAMILIAR
		//////////////////////////////////////
		$preguntas = EvaluacionPregunta::get();
		$respuestas = EvaluacionRespuesta::where('tera_id',$tera_id)->where('eva_fase_id',2)->get();

		// INICIO CZ SPRINT 60
		if ($respuestas->count() <= 9){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la evaluación de cierre de la terapia';
			$array_respuesta['respuesta'] = 0;
		}
		//FIN CZ SPRINT 60

		///////////////////////////
		// ENCUESTA DE SATISFACCION
		///////////////////////////

		// $encuesta_satifaccion = $terapia->ter_enc_sat;

		// if ($encuesta_satifaccion==null || $encuesta_satifaccion==''){
		// 	$array_respuesta['mensajes'][$i++] = 'Debe subir la encuesta de satisfacción';
		// 	$array_respuesta['respuesta'] = 0;
		// }
		// INICIO CZ SPRINT 69
		///////////////////////////
		// PLAN DE TERAPIA FAMILIAR VALIDACION
		///////////////////////////
		if($terapia->flag_modelo_terapia == 2){
			// INICIO CZ SPRINT 69
			$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id', $tera_id)->whereNull('ptf_estado')->get();;
			// FIN CZ SPRINT 69 
			if(count($terapia_ptf_detalle)>0){
				// INICIO CZ SPRINT 69
				$array_respuesta['mensajes'][$i++] = 'Debe completar los estados en el Plan de Terapia Familiar.';
				// FIN CZ SPRINT 69
				$array_respuesta['respuesta'] = 0;
			}
		}
		// FIN CZ SPRINT 69
		return $array_respuesta;

	}

	public function verificarSeguimiento(Request $request){

		$tera_id = $request->tera_id;
		$terapia = Terapia::find($tera_id);
		$i=0;
		$sw_ptf = true;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;


		//////////////////////////////////////
		// EVALUACION EGRESO TERAPIA FAMILIAR
		//////////////////////////////////////
		$preguntas = EvaluacionPregunta::get();
		$respuestas = EvaluacionRespuesta::where('tera_id',$tera_id)->where('eva_fase_id',3)->get();

		if ($preguntas->count()<>$respuestas->count()){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la evaluación de egreso de la terapia';
			$array_respuesta['respuesta'] = 0;
		}

		return $array_respuesta;
	
	}

	public function verificarDiagnostico(Request $request){


		$tera_id = $request->tera_id;
		$i=0;
		$sw_dp = $sw_df = true;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;
		//INICIO CZ SPRINT 69 
		$terapia = Terapia::where("tera_id",$request->tera_id)->first();
		// FIN CZ SPRINT 69
		//////////////////////////////////////
		// EVALUACION INICIAL TERAPIA FAMILIAR
		//////////////////////////////////////
		$preguntas = EvaluacionPregunta::get();
		$respuestas = EvaluacionRespuesta::where('tera_id',$tera_id)->where('eva_fase_id',1)->get();
		// INICIO CZ SPRINT 60
		if ($respuestas->count() <= 9){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la evaluación inicial de la terapia';
			$array_respuesta['respuesta'] = 0;
		}
		//FIN CZ SPRINT 60

		/////////////////////////////////////
		// DOCUMENTO PLAN DE TERAPIA FAMILIAR
		/////////////////////////////////////
		$plan_terapia_familiar = documentoPlanTerapiaFamiliar::where('tera_id',$tera_id)->first();
		if (!$plan_terapia_familiar){
			$array_respuesta['mensajes'][$i++] = 'Debe subir el Plan de Terapia Familiar';
			$array_respuesta['respuesta'] = 0;
		}
		
		//////////////////////////////
		// DESCRIPCION FUNCIONAMIENTO
		/////////////////////////////
		$descripcion_funcionamiento = descripcionFuncionamiento::where('tera_id',$tera_id)->first();
		if (!$descripcion_funcionamiento){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la descripción de funcionamiento y la Organización Familiar';
			$array_respuesta['respuesta'] = 0;
		}else{
			if ($descripcion_funcionamiento->des_fun_geno==null || $descripcion_funcionamiento->des_fun_geno==''){
					$sw_df = false;
			}
			if ($descripcion_funcionamiento->des_fun_preg_2==null || $descripcion_funcionamiento->des_fun_preg_2==''){
					$sw_df = false;
			}
			if ($descripcion_funcionamiento->des_fun_preg_3==null || $descripcion_funcionamiento->des_fun_preg_3==''){
					$sw_df = false;
			}
			if ($descripcion_funcionamiento->des_fun_preg_4==null || $descripcion_funcionamiento->des_fun_preg_4==''){
					$sw_df = false;
			}
			if ($descripcion_funcionamiento->des_fun_preg_5==null || $descripcion_funcionamiento->des_fun_preg_5==''){
					$sw_df = false;
			}
			if (!$sw_df){
				$array_respuesta['mensajes'][$i++] = 'Debe completar la descripción de funcionamiento y la Organización Familiar';
				$array_respuesta['respuesta'] = 0;

			}

		}

		//////////////////////////
		// DEFINICION DEL PROBLEMA
		//////////////////////////
		$definicion_problema = definicionProblema::where('tera_id',$tera_id)->first();

		if (!$definicion_problema){
			$array_respuesta['mensajes'][$i++] = 'Debe completar la definición del problema';
			$array_respuesta['respuesta'] = 0;
		}else{
			if ($definicion_problema->def_pro_preg_1==null || $definicion_problema->def_pro_preg_1==''){
					$sw_dp = false;
			}
			/*if ($definicion_problema->def_pro_preg_2==null || $definicion_problema->def_pro_preg_2==''){
					$sw_dp = false;
			}*/
			if ($definicion_problema->def_pro_preg_3==null || $definicion_problema->def_pro_preg_3==''){
					$sw_dp = false;
			}
			if ($definicion_problema->def_pro_preg_4==null || $definicion_problema->def_pro_preg_4==''){
					$sw_dp = false;
			}
			// INICIO CZ SPRINT 69
			if($terapia->flag_modelo_terapia == 1) {
			if ($definicion_problema->def_pro_preg_5==null || $definicion_problema->def_pro_preg_5==''){
					$sw_dp = false;
			}
			if ($definicion_problema->def_pro_preg_6==null || $definicion_problema->def_pro_preg_6==''){
					$sw_dp = false;
			}
			}
			// FIN CZ SPRINT 69
			if ($definicion_problema->def_pro_preg_7==null || $definicion_problema->def_pro_preg_7==''){
					$sw_dp = false;
			}
			if ($definicion_problema->def_pro_preg_8==null || $definicion_problema->def_pro_preg_8==''){
					$sw_dp = false;
			}
			if (!$sw_dp){
				$array_respuesta['mensajes'][$i++] = 'Debe completar la definición del problema';
				$array_respuesta['respuesta'] = 0;

			}
		}
		return $array_respuesta;
	}

public function cambioEstadoTerapia(request $request){
		try{
			DB::beginTransaction();
			
			if (!isset($request->option) || $request->option == "" || !isset($request->tera_id) || $request->tera_id== ""){
				$mensaje = "Falta datos para completar el proceso. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			$cambio_estado = true;
		// CZ SPRINT 78
			$perteneceNotificacion = CasosGestionEgresado::query()
            ->where('ter_id', '=',session()->all()['id_usuario'])
			->where('est_tera_fin', '<>', 1)
			->where('est_tera_ord', '<', 4)
			->where('tera_estado', 'RETRASADO')
			->where('tera_id', $request->tera_id)
			->count();
					// CZ SPRINT 77
			// CZ SPRINT 74  
			switch ($request->option){
				//CAMBIA DE INVITACION A DIAGNOSTICO
				case config('constantes.gtf_diagnostico'):
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_diagnostico');
					$comentario = "";
					$tera_est_tera_fec = "";
				break;

				//CAMBIA DE DIAGNOSTICO A EJECUCION
				case config('constantes.gtf_ejecucion'):
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_ejecucion');
					$comentario = "";
					$tera_est_tera_fec = "";
				break;

				//CAMBIA DE EJECUCION A SEGUIMIENTO
				case config('constantes.gtf_seguimiento'):
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_seguimiento');
					$comentario = "";
					$tera_est_tera_fec = "";
				break;

				//CAMBIA DE SEGUIMIENTO A EGRESO
				case config('constantes.gtf_egreso'):
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_egreso');
					$comentario = "";
					$tera_est_tera_fec = "";
				break;

				//FAMILIA RECHAZA
				case config('constantes.gtf_familia_rechaza_participacion'): 
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_familia_rechaza_participacion');
					$comentario = $request->comentario;
				break;

				//FAMILIA NO APLICA
				case config('constantes.gtf_Familia_no_aplica'): 
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_Familia_no_aplica');
					$comentario = $request->comentario;
				break;

				//PRESENTA VULNERACION DE DERECHOS
				case config('constantes.gtf_nna_presenta_vulneracion_derechos'): 
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_nna_presenta_vulneracion_derechos');
					$comentario = $request->comentario;
				break;

				//FAMILIA NO ASISTE
				case config('constantes.gtf_familia_no_asiste'): 
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_familia_no_asiste');
					$comentario = $request->comentario;
				break;

				//FAMILIA RENUNCIA A LA TERAPIA
				case config('constantes.gtf_familia_renuncia_a_la_tf'): 
					$tera_id = $request->tera_id;
					$est_tera_id = config('constantes.gtf_familia_renuncia_a_la_tf');
					$comentario = $request->comentario;
				break;
			}

			if ($cambio_estado == true){
				
				$terapia = Terapia::where("tera_id", "=", $tera_id)->first();
				$terapia->est_tera_id = $est_tera_id;
				$resultado = $terapia->save();

				// INICIO CZ SPRINT 66
				$bitacora = EstadoTerapiaBitacora::where('tera_id',$tera_id)
				->where('est_tera_id',$est_tera_id)->first();

				if (count($bitacora) == 0){
					$bitacora = new EstadoTerapiaBitacora();
				
				}
				$bitacora->tera_id = $tera_id;
				$bitacora->est_tera_id = $est_tera_id;
				
				if($bitacora->tera_est_tera_des == null){
					$bitacora->tera_est_tera_des = $comentario;
				}
				// CZ SPRINT 74  
						// CZ SPRINT 77
				if($perteneceNotificacion > 0){
					if(session()->all()['perfil'] == config('constantes.perfil_gestor') || session()->all()['perfil'] == config('constantes.perfil_terapeuta') ){
						$plazo = DB::selectOne("select FN_PLAZO_INTERVENCION(2, ".$tera_id.") as plazo from dual");
						$date1 = new \DateTime("now");
						$date2 = new \DateTime($plazo->plazo);

						if($date2 > $date1){
							$updateTime = DB::update("update AI_TIME_INTER_TERA set tera_estado = 'A TIEMPO' where tera_id = {$tera_id}");
						}else{
							$updateTime = DB::update("update AI_TIME_INTER_TERA set tera_estado = 'RETRASADO' where tera_id = {$tera_id}");
						}
								// CZ SPRINT 77
						$cantidad = NotificacionAsignacion::cantidadNotificaciones();
						$cantidad_asignacion = NotificacionAsignacion::CantnotificacionesAsignacion();
						// $cantidad_tiempo_intervencion = NotificacionAsignacion::CantnotificacionesTiempoIntervencion();
						// $tiempoIntervencion = NotificacionAsignacion::notificacionTiempoIntervencion();
		
						$request->session()->put("cantidad",$cantidad);
						$request->session()->put("cantidad_asignacion",$cantidad_asignacion);
						// $request->session()->put("cantidad_tiempo_intervencion",$cantidad_tiempo_intervencion);
						
						// $request->session()->put("tiempoIntervencion",$tiempoIntervencion);
					}
				}
				// CZ SPRINT 74  	
				// FIN CZ SPRINT 66
				$bitacora->save();
			}

			$mensaje = "Cambio de estado realizado con éxito.";		
			
		    DB::commit();
			
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error en el proceso de actualización de estado. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
		}
	}

	function buscarDefinicionProblema(Request $request){
		try{
			if (!isset($request->tera_id) || $request->tera_id == "") throw new \Exception("Falta ID de la terapia para buscar la información solicitada. Por Favor Verifique.");

			$listar_terapia = Terapia::where("tera_id", $request->tera_id)->get();
			if (count($listar_terapia) == 0) throw new \Exception("No se encuentra información de la terapia solicitada. Por Favor Verifique.");

			$listar_definicion = definicionProblema::where("tera_id", $request->tera_id)->get();
			//if (count($listar_definicion) == 0) throw new \Exception("No se encuentra información respecto a la definición del problema. Por Favor Verifique.");

			return response()->json(array('estado' => '1', 'respuesta' => $listar_definicion), 200);

		}catch(\Exception $e){
			Log::info('error ocurrido:'.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	function guardarDefinicionProblema(Request $request){
		try{
			if (!isset($request->option) || $request->option == "") throw new \Exception("No se encuentra número de pregunta. Por Favor Verifique.");

			if (!isset($request->tera_id) || $request->tera_id == "") throw new \Exception("No se encuentra ID de la terapia. Por Favor Verifique.");

			if (!isset($request->valor) || $request->valor == "") throw new \Exception("No se encuentra valor de pregunta. Por Favor Verifique.");

			$guardar = new definicionProblema();
			// INICIO CZ SPRINT 57
			$guardar_ai_evaluacion_respuesta = new EvaluacionRespuesta();
			$guardar_ai_evaluacion_respuesta_2 = new EvaluacionRespuesta();
			$guardar_ai_evaluacion_respuesta_3 = new EvaluacionRespuesta();
			// FIN CZ SPRINT 57
			if (isset($request->def_pro_id) && $request->def_pro_id != "") $guardar = definicionProblema::find($request->def_pro_id);

			$guardar->tera_id = $request->tera_id;
			switch ($request->option){
				case 1:
					$guardar->def_pro_preg_1 = $request->valor;
					// INICIO CZ SPRINT 60
					// $getIdEvaluacion = EvaluacionRespuesta::where(["tera_id" => $request->tera_id, "eva_fase_id" => 1, "eva_pre_id" => 11])->first();

					// if(count($getIdEvaluacion)>0){
					// 	$guardar_ai_evaluacion_respuesta = EvaluacionRespuesta::find($getIdEvaluacion->eva_res_id);
					// }
					// $guardar_ai_evaluacion_respuesta->tera_id 		= $request->tera_id;
					// $guardar_ai_evaluacion_respuesta->eva_fase_id 	= 1;
					// $guardar_ai_evaluacion_respuesta->eva_pre_id 	= 11;
					// $guardar_ai_evaluacion_respuesta->eva_res_alt_com = $request->valor;

					// $getIdEvaluacion2 = EvaluacionRespuesta::where(["tera_id" => $request->tera_id, "eva_fase_id" => 2, "eva_pre_id" => 11])->first();

					// if(count($getIdEvaluacion2)>0){
					// 	$guardar_ai_evaluacion_respuesta_2 = EvaluacionRespuesta::find($getIdEvaluacion2->eva_res_id);
					// }
					// $guardar_ai_evaluacion_respuesta_2->tera_id 		= $request->tera_id;
					// $guardar_ai_evaluacion_respuesta_2->eva_fase_id 	= 2;
					// $guardar_ai_evaluacion_respuesta_2->eva_pre_id 	= 11;
					// $guardar_ai_evaluacion_respuesta_2->eva_res_alt_com = $request->valor;
					
					// $getIdEvaluacion3 = EvaluacionRespuesta::where(["tera_id" => $request->tera_id, "eva_fase_id" => 3, "eva_pre_id" => 11])->first();

					// if(count($getIdEvaluacion3)>0){
					// 	$guardar_ai_evaluacion_respuesta_3 = EvaluacionRespuesta::find($getIdEvaluacion2->eva_res_id);
					// }
					// $guardar_ai_evaluacion_respuesta_3->tera_id 		= $request->tera_id;
					// $guardar_ai_evaluacion_respuesta_3->eva_fase_id 	= 3;
					// $guardar_ai_evaluacion_respuesta_3->eva_pre_id 	= 11;
					// $guardar_ai_evaluacion_respuesta_3->eva_res_alt_com = $request->valor;
					// $respuesta = $guardar_ai_evaluacion_respuesta->save();
					// $respuesta = $guardar_ai_evaluacion_respuesta_2->save();
					// $respuesta = $guardar_ai_evaluacion_respuesta_3->save();
						// FIN CZ SPRINT 60
				break;

				case 2:
					$guardar->def_pro_preg_2 = $request->valor;
				break;

				case 3:
					$guardar->def_pro_preg_3 = $request->valor;
				break;

				case 4:
					$guardar->def_pro_preg_4 = $request->valor;
				break;

				case 5:
					$guardar->def_pro_preg_5 = $request->valor;
				break;

				case 6:
					$guardar->def_pro_preg_6 = $request->valor;
				break;

				case 7:
					$guardar->def_pro_preg_7 = $request->valor;
				break;

				case 8:
					$guardar->def_pro_preg_8 = $request->valor;
				break;
			}

			$respuesta = $guardar->save();
			if (!$respuesta) throw new \Exception("Error al momento de guardar la información. Por favor intente nuevamente");


			DB::commit();
			$mensaje = "Información guardada con éxito.";
		    return response()->json(array('estado' => '1', 'respuesta' => $guardar->def_pro_id, 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	function buscarDescripcionFuncionamiento(Request $request){
		try{
			if (!isset($request->tera_id) || $request->tera_id == "") throw new \Exception("Falta ID de la terapia para buscar la información solicitada. Por Favor Verifique.");

			$listar_terapia = Terapia::where("tera_id", $request->tera_id)->get();
			if (count($listar_terapia) == 0) throw new \Exception("No se encuentra información de la terapia solicitada. Por Favor Verifique.");

			$listar_funcionamiento = descripcionFuncionamiento::where("tera_id", $request->tera_id)->get();

			return response()->json(array('estado' => '1', 'respuesta' => $listar_funcionamiento), 200);
		}catch(\Exception $e){
			Log::info('error ocurrido:'.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	function guardarDescripcionFuncionamiento(Request $request){
		try{
			if (!isset($request->option) || $request->option == "") throw new \Exception("No se encuentra número de pregunta. Por Favor Verifique.");

			if (!isset($request->tera_id) || $request->tera_id == "") throw new \Exception("No se encuentra ID de la terapia. Por Favor Verifique.");

			if (!isset($request->valor) || $request->valor == "") throw new \Exception("No se encuentra valor de pregunta. Por Favor Verifique.");


			$guardar = new descripcionFuncionamiento();
			if (isset($request->des_fun_id) && $request->des_fun_id != "") $guardar = descripcionFuncionamiento::find($request->des_fun_id);

			$guardar->tera_id = $request->tera_id;
			switch ($request->option){
				case 2:
					$guardar->des_fun_preg_2 = $request->valor;
				break;

				case 3:
					$guardar->des_fun_preg_3 = $request->valor;
				break;

				case 4:
					$guardar->des_fun_preg_4 = $request->valor;
				break;

				case 5:
					$guardar->des_fun_preg_5 = $request->valor;
				break;
			}

			$respuesta = $guardar->save();
			if (!$respuesta) throw new \Exception("Error al momento de guardar la información. Por favor intente nuevamente");

			DB::commit();
			$mensaje = "Información guardada con éxito.";
		    return response()->json(array('estado' => '1', 'respuesta' => $guardar->des_fun_id, 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			Log::info('error ocurrido:'.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	public function guardarDocumentoGenograma(Request $request){
		$request->validate($this->reglas_doc_genograma,[]);

		try{
			DB::beginTransaction();

			if (!isset($request->des_tera_id) || $request->des_tera_id == "") throw new \Exception("No se encuentra ID de la terapia. Por Favor Verifique.");

			if(!$request->file('file_genograma')){
				
				$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			$tera_id = $request->des_tera_id;
			$archivo = $request->file('file_genograma');
			$extension = $archivo->getClientOriginalExtension();
			$destino = 'doc';

			$nombre_archivo = "Genograma_Terapia_".$tera_id."(".date("dmY").").".$extension;
			$mover_servidor = $archivo->move($destino, $nombre_archivo);

			$registrar = new descripcionFuncionamiento();
			if (isset($request->des_fun_id) && $request->des_fun_id != "") $registrar = descripcionFuncionamiento::find($request->des_fun_id);

			$registrar->tera_id 	 = $tera_id;
			$registrar->des_fun_geno = $nombre_archivo;
			$resultado 				 = $registrar->save();
			if (!$resultado) throw $resultado;

			DB::commit();
			return response()->json(array('estado' => '1', 'respuesta' => $registrar->des_fun_id, 'nombre_archivo' => $nombre_archivo, 'mensaje' => 'Archivo guardado exitosamente.'), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = 'Hubo un error al momento de guardar el genograma. Por favor intente nuevamente.';
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function guardarDocumentoPlanTerapia(Request $request){
		try{
			DB::beginTransaction();

			if (!isset($request->fir_tera_id) || $request->fir_tera_id == "") throw new \Exception("No se encuentra ID de la terapia. Por Favor Verifique.");

			if(!$request->file('file_firma_plan')){
				
				$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			$tera_id = $request->fir_tera_id;
			$archivo = $request->file('file_firma_plan');
			$extension = $archivo->getClientOriginalExtension();
			$destino = 'doc';

			$nombre_archivo = "Firma_Plan_Terapia_Familiar_".$tera_id."(".date("dmYhis").").".$extension;
			$mover_servidor = $archivo->move($destino, $nombre_archivo);

			$guardar = new documentoPlanTerapiaFamiliar();
			$guardar->tera_id 				= $tera_id;
			$guardar->doc_fir_pla_ter_arc 	= $nombre_archivo;
			$resultado 						= $guardar->save();
			if (!$resultado) throw $resultado;

			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = 'Hubo un error al momento de guardar el documento de plan terapia. Por favor intente nuevamente.';
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}	
	}

	function listarHistorialPlanTerapiaFamiliar(Request $request){
		$registros = array();
		$listar_historial = documentoPlanTerapiaFamiliar::where("tera_id", $request->tera_id)->get();
		if (count($listar_historial) > 0) $registros = $listar_historial;

		$data	= new \stdClass();
		$data->data = $registros;

		echo json_encode($data); exit;
	}
	 public function listarPtfSesion(request $request){
		// INCIO CZ SPRINT 69
		$terapias_ptf = TerapiaPtf::where('ptf_actividad','Sesión Familiar')->where('flag_modelo_terapia',1)->get();
		// FIN CZ SPRINT 69
		$tera_id = $request->tera_id;

		foreach ($terapias_ptf as $terapia_ptf){

		$ptf_id = $terapia_ptf->ptf_id; 

		$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id', $tera_id)->where('ptf_id',$ptf_id)->get();

		if ($terapia_ptf_detalle->count()==0){
		$terapia_ptf_detalle = new TerapiaPtfDetalle();
		$terapia_ptf_detalle->tera_id = $tera_id;
		$terapia_ptf_detalle->ptf_id = $ptf_id; 
		$terapia_ptf_detalle->save();
		} 

		}
		// INCIO CZ SPRINT 69
		$sql = "select 
		   b.ptf_id as ptf_id,
		   a.ptf_numero as ptf_numero,
		   a.ptf_actividad as ptf_actividad,
		   a.ptf_objetivo as ptf_objetivo,
		   a.ptf_meta as ptf_meta,
		   b.ptf_det_estrategia as ptf_det_estrategia,
		   b.ptf_det_resultado as ptf_det_resultado,
		   b.ptf_det_observacion as ptf_det_observacion,
		   b.ptf_det_fecha as ptf_det_fecha
		from 
		    ai_terapia_ptf a
		left join ai_terapia_ptf_detalle b on (a.ptf_id = b.ptf_id) and b.tera_id = ".$tera_id." 
		                    where a.ptf_actividad = 'Sesión Familiar' and a.FLAG_MODELO_TERAPIA = 1
		                    order by a.ptf_orden";
		// FIN CZ SPRINT 69
		$resultado = DB::select($sql);

		return Datatables::of($resultado)->make(true);

	}
	public function listarPtfTaller(request $request){
		$terapias_ptf = TerapiaPtf::where('ptf_actividad','Taller Multifamiliar')->where('flag_modelo_terapia',1)->get();
		$tera_id = $request->tera_id;

		foreach ($terapias_ptf as $terapia_ptf){

		$ptf_id = $terapia_ptf->ptf_id; 

		$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id', $tera_id)->where('ptf_id',$ptf_id)->get();

		if ($terapia_ptf_detalle->count()==0){
		$terapia_ptf_detalle = new TerapiaPtfDetalle();
		$terapia_ptf_detalle->tera_id = $tera_id;
		$terapia_ptf_detalle->ptf_id = $ptf_id; 
		$terapia_ptf_detalle->save();
		} 

		}

		$sql = "select 
		   b.ptf_id as ptf_id,
		   a.ptf_numero as ptf_numero,
		   a.ptf_actividad as ptf_actividad,
		   a.ptf_objetivo as ptf_objetivo,
		   a.ptf_meta as ptf_meta,
		   b.ptf_det_estrategia as ptf_det_estrategia,
		   b.ptf_det_resultado as ptf_det_resultado,
		   b.ptf_det_observacion as ptf_det_observacion,
		   b.ptf_det_fecha as ptf_det_fecha
		from 
		    ai_terapia_ptf a
		left join ai_terapia_ptf_detalle b on (a.ptf_id = b.ptf_id) and b.tera_id = ".$tera_id." 
		                    where a.ptf_actividad = 'Taller Multifamiliar' and a.FLAG_MODELO_TERAPIA  = 1
		                    order by a.ptf_orden";

		$resultado = DB::select($sql);

		return Datatables::of($resultado)->make(true);
			}

	public function guardarPtfDetalle(request $request){
		try{
			$tera_id = $request->tera_id;
			$ptf_id = $request->ptf_id;
			$tip_ses = $request->tip_ses;
			$valor = $request->valor;

			$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id',$tera_id)->where('ptf_id',$ptf_id)->first();

			// dd($valor);
			foreach ($valor AS $c01 => $v01){			
				switch ($c01){
					case 0: // estrategia
						// $terapia_ptf_detalle=TerapiaPtfDetalle::find($terapia_ptf_detalle[0]->ptf_det_id);	
								
						$terapia_ptf_detalle->ptf_det_estrategia = $valor[$c01];
					break;
	    
					case 1: // resultado
						// $terapia_ptf_detalle=TerapiaPtfDetalle::find($terapia_ptf_detalle[0]->ptf_det_id);	
		
						$terapia_ptf_detalle->ptf_det_resultado = $valor[$c01];
					break;

					case 2: // observacion
						// $terapia_ptf_detalle=TerapiaPtfDetalle::find($terapia_ptf_detalle[0]->ptf_det_id);	

						$terapia_ptf_detalle->ptf_det_observacion = $valor[$c01];
					break;

					case 3: // fecha
						// if ($valor[$c01]){
							$fecha = Carbon::createFromFormat( 'd/m/Y', $valor[$c01]);
							// $terapia_ptf_detalle=TerapiaPtfDetalle::find($terapia_ptf_detalle[0]->ptf_det_id);	
							$terapia_ptf_detalle->ptf_det_fecha = $fecha;

						// }else{
							// $terapia_ptf_detalle=TerapiaPtfDetalle::find($terapia_ptf_detalle[0]->ptf_det_id);	
							// $terapia_ptf_detalle->ptf_det_fecha = null;

						// }
					break;
				}
		} 

			// dd($terapia_ptf_detalle);
			$respuesta = $terapia_ptf_detalle->save();	
			// dd($respuesta);

			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

			DB::commit();

			$mensaje = "Información registrada con éxito.";
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::info('guardarPtfDetalle('.$e.')');

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}
	// INCIO CZ SPRINT 69
	public function guardarPtfDetalle_2021(request $request){
		try{
			
			$tera_id = $request->tera_id;
			$ptf_id = $request->ptf_id;
			$tip_ses = $request->tip_ses;
			$valor = $request->valor;
			// INICIO CZ SPRINT 69
			if(($request->ptf_id != 15) && ($request->ptf_id != 18) && ($request->ptf_id != 21)){
			if($valor[0] == null|| $valor[0] == "" ){
				return response()->json(array('estado' => '0', 'mensaje' => 'Se debe ingresar resultado alcanzado'), 400);
			}

			if($valor[1] == null|| $valor[1] == "" ){
				return response()->json(array('estado' => '0', 'mensaje' => 'Se debe ingresar observaciones y comentarios'), 400);
			}

			if($valor[2] == null|| $valor[2] == "" ){
				return response()->json(array('estado' => '0', 'mensaje' => 'Se debe ingresar fecha'), 400);
			}
			}
			// FIN CZ SPRINT 69

			if($valor[3] == null|| $valor[3] == "" ){
				return response()->json(array('estado' => '0', 'mensaje' => 'Se debe ingresar estado'), 400);
			}

			$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id',$tera_id)->where('ptf_id',$ptf_id)->first();

			// dd($valor);
			foreach ($valor AS $c01 => $v01){			
				switch ($c01){
					// INICIO CZ SPRINT 69
					case 0:  // resultado
						if($valor[$c01] != null || $valor[$c01] != ""){
						$terapia_ptf_detalle->ptf_det_resultado = $valor[$c01];
						}
					break;
					  
					case 1: // observacion
						if($valor[$c01] != null || $valor[$c01] != ""){
						$terapia_ptf_detalle->ptf_det_observacion = $valor[$c01];
						}
					break;

					case 2: // fecha
							if($valor[$c01] != null || $valor[$c01] != ""){
							$fecha = Carbon::createFromFormat( 'd/m/Y', $valor[$c01]);	
							$terapia_ptf_detalle->ptf_det_fecha = $fecha;
							}
					break;
					// FIN CZ SPRINT 69
					case 3: // Estado
						$terapia_ptf_detalle->ptf_estado = $valor[$c01];
					break;				
				}
			}
				
			// dd($terapia_ptf_detalle);
			$respuesta = $terapia_ptf_detalle->save();	
			// dd($respuesta);

			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();

			$mensaje = "Información registrada con éxito.";
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::info('guardarPtfDetalle('.$e.')');

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}
	public static function getDatosSesiones_2021(Request $request){
	    $cas_id=$request->cas_id;
	    $terapia=$request->terapia;
		// INICIO CZ SPRINT 69
		$sesiones = DB::select("SELECT td.ptf_id from ai_terapia_ptf_detalle td
								LEFT JOIN ai_terapia at ON td.tera_id = at.tera_id
								LEFT JOIN ai_terapia_ptf a on (a.ptf_id = td.ptf_id) 
								WHERE at.cas_id = ".$cas_id." and a.ptf_actividad = 'Sesión Familiar' and a.FLAG_MODELO_TERAPIA = 2 and ptf_estado = 1");
	    // FIN CZ SPRINT 69
	    $array_respuesta['sesiones_realizadas'] = count($sesiones);
	    

		$sesiones2 = Terapia::where("cas_id", $cas_id)->value("ter_com_fir");
	    $array_respuesta['sesiones_comprometidas'] = $sesiones2;
		if ($sesiones2 == 0) {

			$array_respuesta['porcentaje_logro'] = 0;
		}else if($sesiones == 0){
			$array_respuesta['porcentaje_logro'] = 0;
		}else{
		$array_respuesta['porcentaje_logro'] = number_format(($array_respuesta['sesiones_realizadas'] / $array_respuesta['sesiones_comprometidas'])*100, 2);

		}

	    return $array_respuesta;
	}
	public function listarPtfSesion_2021(request $request){
		$terapias_ptf = TerapiaPtf::where('flag_modelo_terapia',2)->get();
		$tera_id = $request->tera_id;
					  
		foreach ($terapias_ptf as $terapia_ptf){

		$ptf_id = $terapia_ptf->ptf_id; 

		$terapia_ptf_detalle = TerapiaPtfDetalle::where('tera_id', $tera_id)->where('ptf_id',$ptf_id)->get();

		if ($terapia_ptf_detalle->count()==0){
		$terapia_ptf_detalle = new TerapiaPtfDetalle();
		$terapia_ptf_detalle->tera_id = $tera_id;
		$terapia_ptf_detalle->ptf_id = $ptf_id; 
		$terapia_ptf_detalle->save();
		} 

		}
						
		$sql = "select 
		   b.ptf_id as ptf_id,
		   a.ptf_numero as ptf_numero,
		   a.ptf_actividad as ptf_actividad,
		   a.ptf_objetivo as ptf_objetivo,
		   a.ptf_meta as ptf_meta,
		   b.ptf_det_estrategia as ptf_det_estrategia,
		   b.ptf_det_resultado as ptf_det_resultado,
		   b.ptf_det_observacion as ptf_det_observacion,
		   b.ptf_det_fecha as ptf_det_fecha,
		   b.ptf_estado as ptf_estado
		from 
		    ai_terapia_ptf a
		left join ai_terapia_ptf_detalle b on (a.ptf_id = b.ptf_id) and b.tera_id = ".$tera_id." 
		where a.FLAG_MODELO_TERAPIA = 2 
		                    order by a.ptf_orden";
						
		$resultado = DB::select($sql);
		foreach($resultado as $key=> $row){
			if($row->ptf_id == 13){
				$resultado[$key]->agrupar = 0;
				$resultado[$key]->tituloagrupacion = "";
			}
			if($row->ptf_id == 14 || $row->ptf_id == 15 || $row->ptf_id == 16){
				$resultado[$key]->agrupar = 1;
				$resultado[$key]->tituloagrupacion = 'Módulo 1: "Nuestras familias". Dimensión NCFAS-G: Interacciones Familiares';
			}
			if($row->ptf_id == 17 || $row->ptf_id == 18 || $row->ptf_id == 19){
				$resultado[$key]->agrupar = 3;
				$resultado[$key]->tituloagrupacion = 'Módulo 2: "Nuestras familias y relaciones". Dimensión NCFAS-G: Bienestar del NNA';
			}
			if($row->ptf_id == 20 || $row->ptf_id == 21 || $row->ptf_id == 22){
				$resultado[$key]->agrupar = 4;
				$resultado[$key]->tituloagrupacion ='Módulo 3: "Cuidando y guiando nuestra familias". Dimension NCFAS-G: Competencias Parentales';
			}
			if($row->ptf_id == 23 || $row->ptf_id == 24){
				$resultado[$key]->agrupar = 5;
				$resultado[$key]->tituloagrupacion = 'Módulo 4: "Nuestros aprendizajes y desafíos".';
				}
			}
		// print_r($resultado);
		// die();
				
		return Datatables::of($resultado)->make(true);

			}
	public static function getDatosSesionFamiliar_2021(Request $request){
		$cas_id=$request->cas_id;
	    $terapia=$request->terapia;
	    $sesiones = DB::select("SELECT td.ptf_id from ai_terapia_ptf_detalle td
		LEFT JOIN ai_terapia at ON td.tera_id = at.tera_id
        LEFT JOIN ai_terapia_ptf a on (a.ptf_id = td.ptf_id) 
        where a.ptf_actividad = 'Taller Multifamiliar' and at.cas_id = ".$cas_id. " and a.FLAG_MODELO_TERAPIA = 2 and ptf_estado = 1");

	    $array_respuesta['sesiones_realizadas2'] = count($sesiones);

	    $sesiones2 = DB::select("SELECT b.ptf_id as ptf_id from ai_terapia_ptf a
		left join ai_terapia_ptf_detalle b on (a.ptf_id = b.ptf_id) and b.tera_id = ".$terapia." where a.ptf_id = 22 or a.ptf_id = 23 or  a.ptf_id = 24  and a.FLAG_MODELO_TERAPIA = 2 order by a.ptf_orden");
	    $array_respuesta['sesiones_comprometidas2'] = count($sesiones2);
		//inicio ch
		$array_respuesta['porcentaje_logro2'] = number_format(($array_respuesta['sesiones_realizadas2'] / $array_respuesta['sesiones_comprometidas2'])*100,2);
		//fin ch

	    return $array_respuesta;
		}
	// FIN CZ SPRINT 69
	function guardarPauTrabFamTer(Request $request){
		
		try{
			if (!isset($request->option) || $request->option == "") throw new \Exception("No se encuentra número de pregunta. Por Favor Verifique.");

			if (!isset($request->tera_id) || $request->tera_id == "") throw new \Exception("No se encuentra ID de la terapia. Por Favor Verifique.");

			if (!isset($request->valor) || $request->valor == "") throw new \Exception("No se encuentra valor de pregunta. Por Favor Verifique.");

			$resultado = DB::select("select pau_trab_fam_ter_id from ai_pau_trab_fam_ter where tera_id=".$request->tera_id."");

			if($resultado){

				$respuesta = DB::update("UPDATE ai_pau_trab_fam_ter SET trab_fam_ter_preg_".$request->option."='".$request->valor."' where pau_trab_fam_ter_id='".$resultado[0]->pau_trab_fam_ter_id."'");

				//$respuesta="";
			}

			else { 	

				$guardar = new PautaTrabFamTer();

				$guardar->tera_id = $request->tera_id;
					switch ($request->option){
						case 1:
							$guardar->trab_fam_ter_preg_1 = $request->valor;
						break;

						// case 2:
						// 	$guardar->trab_fam_ter_preg_2 = $request->valor;
						// break;

						case 3:
							$guardar->trab_fam_ter_preg_3 = $request->valor;
						break;

						// case 4:
						// 	$guardar->trab_fam_ter_preg_4 = $request->valor;
						// break;

						// case 5:
						// 	$guardar->trab_fam_ter_preg_5 = $request->valor;
						// break;

						// case 6:
						// 	$guardar->trab_fam_ter_preg_6 = $request->valor;
						// break;

						case 7:
							$guardar->trab_fam_ter_preg_7 = $request->valor;
						break;

						// case 8:
						// 	$guardar->trab_fam_ter_preg_8 = $request->valor;
						// break;

						case 9:
							$guardar->trab_fam_ter_preg_9 = $request->valor;
						break;

						case 10:
							$guardar->trab_fam_ter_preg_10 = $request->valor;
						break;

						case 11:
							$guardar->trab_fam_ter_preg_11 = $request->valor;
						break;

					}

				$respuesta = $guardar->save();
			}

			if (!$respuesta) throw new \Exception("Error al momento de guardar la información. Por favor intente nuevamente");

			DB::commit();
			$mensaje = "Información guardada con éxito.";
		    return response()->json(array('estado' => '1', 'respuesta' => $respuesta, 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}


	public function documentoEncSatTer(Request $request){

		$request->validate($this->reglas_doc_encu,[]);

		try {

			DB::beginTransaction();

        	$files = $request->file('doc_encu');

			if(!$request->file('doc_encu')){
				
				$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}


        	$tera_id = $request->tera_id;

        	$destinationPath = 'doc';

        	$doc_fec = Carbon::now();

   		    $extension = $files->getClientOriginalExtension();

        	$filename = "encuesta_satisfaccion_terapia_familiar_".$tera_id."(".date("dmY").").".$extension;

            $upload_success = $files->move($destinationPath, $filename);

            $terapia = Terapia::find($tera_id);
            $terapia->ter_enc_sat = $filename;
            $terapia->ter_enc_sat_fec = Carbon::createFromFormat('d/m/Y H:i:s', date('d/m/Y G:i:s'));
            $respuesta = $terapia->save();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir la Encuesta de Satisfacción. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

     		// $doc_invitacion = DB::update("update AI_TERAPIA set ter_enc_sat='".$filename."' where tera_id=".$tera_id);
			
			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'
				, 'filename' => $filename ),200);
		
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66 
			$mensaje = "Hubo un error al momento de subir la Encuesta de Satisfacción. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}		
	}

	public function consultarPauFrabFamTer(Request $request){

		try {

			DB::beginTransaction();
			if(!$request->tera_id){
				$mensaje = "Hubo un error al momento de consulta la información de la pauta.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			$resultado = DB::select("select ai_pau_trab_fam_ter.*,ai_def_pro.def_pro_preg_1 as motivo  from ai_pau_trab_fam_ter left join ai_def_pro on
			ai_pau_trab_fam_ter.tera_id = ai_def_pro.tera_id where ai_pau_trab_fam_ter.tera_id=". $request->tera_id."");

			return response()->json(array('estado' => '1', 'mensaje' => ''
				, 'resultado' => $resultado[0] ),200);
		
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de consulta la información de la pauta.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}		
	}

	public function listarDetalleSeguimiento(Request $request){

		$tera_id = $request->tera_id;

		return Datatables::of(DB::table("ai_tera_ptf_seguimiento a")
				->select("*")
				->Join("ai_terapia_ptf_seg_modalidad b", "a.ptf_mod_id", "=", "b.ptf_mod_id")
				->where("a.tera_id", $tera_id))->make(true);

	}

	public function accionesFormularioDetalleSeguimiento(Request $request){

		try{
			DB::beginTransaction();
		  
		  $respuesta = "";
		  switch ($request->option){
			  case 1: //Buscar información seguimiento

				$ptf_seg_id = $request->ptf_seg_id;

				$resultado = TerapiaSeguimientoDetalle::find($ptf_seg_id);

				$respuesta = 
				[
					"ptf_seg_fecha" => $resultado->ptf_seg_fecha, 
					"ptf_mod_id" => $resultado->ptf_mod_id, 
					"ptf_seg_recursos" => $resultado->ptf_seg_recursos, 
					"ptf_seg_redes" => $resultado->ptf_seg_redes,
					"ptf_seg_riesgo" => $resultado->ptf_seg_riesgo,
					"ptf_seg_observacion" => $resultado->ptf_seg_observacion,
					"ptf_seg_id" => $resultado->ptf_seg_id
				];

			  break;

			  case 2: //Insertar información seguimiento

				$actualizar_registro = new TerapiaSeguimientoDetalle();

				$actualizar_registro->ptf_seg_fecha =  Carbon::createFromFormat( 'd/m/Y', $request->ptf_seg_fecha);

				$actualizar_registro->tera_id = $request->tera_id;
				$actualizar_registro->ptf_mod_id = $request->ptf_mod_id;
				$actualizar_registro->ptf_seg_recursos = $request->ptf_seg_recursos;
				$actualizar_registro->ptf_seg_redes = $request->ptf_seg_redes;
				$actualizar_registro->ptf_seg_riesgo = $request->ptf_seg_riesgo;
				$actualizar_registro->ptf_seg_observacion = $request->ptf_seg_observacion;
				
				 $respuesta = $actualizar_registro->save();

				 if (!$respuesta) throw new \Exception("Ocurrio un Error al Guardar la Información. Por Favor intente nuevamente.");


			  break;

			  case 3: //Actualizar seguimiento

				$ptf_seg_id = $request->ptf_seg_id;

				$actualizar_registro = TerapiaSeguimientoDetalle::find($ptf_seg_id);


				$actualizar_registro->ptf_seg_fecha =  Carbon::createFromFormat( 'd/m/Y', $request->ptf_seg_fecha);

				$actualizar_registro->ptf_mod_id = $request->ptf_mod_id;
				$actualizar_registro->ptf_seg_recursos = $request->ptf_seg_recursos;
				$actualizar_registro->ptf_seg_redes = $request->ptf_seg_redes;
				$actualizar_registro->ptf_seg_riesgo = $request->ptf_seg_riesgo;
				$actualizar_registro->ptf_seg_observacion = $request->ptf_seg_observacion;
				
				 $respuesta = $actualizar_registro->save();

				 if (!$respuesta) throw new \Exception("Ocurrio un Error al Actualizar la Información. Por Favor intente nuevamente.");
			  break;


			}

			 DB::commit();

 		return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	   
	   }catch(\Exception $e){
		   DB::rollback();
		   Log::error('error: '.$e);
		   
		   $mensaje = "Error al momento de realizar la acción solicitada. Por favor intente nuevamente.";
		   if (!is_null($e->getMessage())  && $e->getMessage() != "") $mensaje = $e->getMessage();
		   
		   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
	   }

	}



	public function reAsignarTerapeuta(Request $request){

		try{

			DB::beginTransaction();
			
			$reasignar = DB::update("update AI_CASO_TERAPEUTA set ter_id='".$request->terapeuta_id."' where cas_id=".$request->cas_id);

			$reasignar = DB::update("update AI_TERAPIA set usu_id='".$request->terapeuta_id."' where cas_id=".$request->cas_id);

			DB::commit();

			return response()->json(array('estado' => '1','mensaje' => 'El terapeuta ha sido reasignado correctamente.'),200);


		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(array('estado' => '0', 'mensaje' =>'Error al reasignar el terapueta:'. $e), 400);
		}

	}


	/**
	 * Método que realiza el despliegue de la sesiones de terapia familiar.
	 */
	// public function sesionesTerapiaFamiliar(String $nna_run){
	public function sesionesTerapiaFamiliar(Request $request){
		$run 				= "";
		$nna_caso 			= "";
		$run_formateado  	= "";
		$nombre_completo 	= "";
		$tera_id 			= "";
		$tipo_planificacion = $request->planificacion;

		if ($tipo_planificacion == 0){ //X NNA
			$run 			= $request->run;
			$nna_caso		= NNAAlertaManualCaso::where('run', $run)->get();

			$tera_id 		 = $nna_caso[0]->tera_id;
			$run_formateado  = $nna_caso[0]->nna_run_con_formato;
			$nombre_completo = $nna_caso[0]->nna_nombre_completo;
		}
		
		$ptf_actividad	= TerapiaPtf::select('ptf_actividad')->distinct()->get();
		$ptf_objetivo	= TerapiaPtf::all();

		return view('ficha.terapia.sesiones_terapia_familiar')
			->with('nna_run', $run)
			->with('tera_id', $tera_id)
			->with('run_formateado', $run_formateado)
			->with('nombre_completo', $nombre_completo)
			->with('tipo_planificacion', $tipo_planificacion)
			->with('ptf_actividad', $ptf_actividad)
			->with('ptf_objetivo', $ptf_objetivo);

	}


	/**
	 * Método que obtiene las sesiones de terapia familiar enviada por parámetros
	 */
	public function getSesionesTerapiaFamiliar(Request $request){
		try{
			$tera_id 			= $request->tera_id;
			$tipo_planificacion = $request->tipo_planificacion;
			$ses_ptf_id 		= $request->ses_ptf_id;
		
			if ($tipo_planificacion == 0){
				$run = $request->nna_run;

				if (!isset($tera_id) || $tera_id == ""){
					$nna_caso	= NNAAlertaManualCaso::where('run', $run)->get();
					$tera_id 	= $nna_caso[0]->tera_id;
				}


				if (is_null($ses_ptf_id)){
					$stf 	= SesionTerapiaFamiliar::obtenerSesionesPlanificadasNNA($tera_id);
					
				}else{
					$stf 	= SesionTerapiaFamiliar::obtenerSesionesPlanificadasNNA($tera_id, $ses_ptf_id);
				
				}
			}else if ($tipo_planificacion == 1){
				if (!isset($tera_id) || $tera_id == ""){
					$stf = SesionTerapiaFamiliar::obtenerSesionesPlanificadasNNA("", "", session()->all()['id_usuario'], true);
				
				}else{
					if (isset($ses_ptf_id) && $ses_ptf_id != "") $stf = SesionTerapiaFamiliar::obtenerSesionesPlanificadasInformacionNNA($tera_id, $ses_ptf_id, null, false, true);

				}		
			}

			// dd($stf);
			return response()->json(array('estado' => '1', 'tera_id' => $tera_id, 'sesiones' => $stf),200);
		}catch(\Exception $e){
			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);	
		}
	}


	/**
	 * Método inserta sesiones de terapia familiar
	 */
	public function insertarSesionesTerapiaFamiliar(Request $request){
			try{
				$validacion_sesion = $this->validacionSesionesTerapia($request->tera_id, $request->ptf_id, $request->ptf_actividad);

				if (!$validacion_sesion->estado){
					$mensaje = $validacion_sesion->mensaje;

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				if (!$this->validarNuevaSesionTerapiaFamiliar($request)){
					$mensaje = "La sesión coincide para este día, con otra sesión planificada. Por favor verifique e intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				DB::beginTransaction();
				
				$ses_ptf_fec 	= new \DateTime($request->ses_ptf_fec);
				$ses_ptf_fec 	= Carbon::createFromFormat('d/m/Y', $ses_ptf_fec->format('d/m/Y'));
				
				$sesTerFam 					= new SesionTerapiaFamiliar();
				$sesTerFam->ses_ptf_id 		= DB::table('dual')->select('SEQ_AI_SES_PTF_SES_PTF_ID.nextval')->pluck('nextval')[0];
				$sesTerFam->tera_id 		= $request->tera_id;
				$sesTerFam->ptf_id 			= $request->ptf_id;
				$sesTerFam->ses_ptf_com 	= $request->ses_ptf_com;
				$sesTerFam->ses_ptf_n_ses	= $request->ses_ptf_n_ses;
				$sesTerFam->ses_ptf_fec	 	= $ses_ptf_fec;
				$sesTerFam->ses_ptf_hor_ini	= $request->ses_ptf_hor_ini;
				$sesTerFam->ses_ptf_hor_fin	= $request->ses_ptf_hor_fin;
				$respuesta = $sesTerFam->save();
				if(!$respuesta){
					$mensaje = "Hubo un error al momento de registrar la sesión. Por favor intente nuevamente o contacte con el Administrador.";
					
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}	

				DB::commit();

				$mensaje = "Sesión de Terapia Familiar planificada éxitosamente.";
				return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

			} catch (\Exception $e) {
				DB::rollback();

				return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
			}
	}


	/**
	 * Método que elimina sesiones de terapia familiar
	 */
	public function eliminarSesionesTerapiaFamiliar(Request $request){

		try{

			DB::beginTransaction();

			$sesTerFam = SesionTerapiaFamiliar::find($request->ses_ptf_id);
			$resultado = $sesTerFam->delete();
			if (!$resultado) throw $resultado;
			
			DB::commit();

			return response()->json(array('estado' => '1','mensaje' => 'La sesion de terapia familiar se ha eliminado correctamente.'),200);

		} catch (\Exception $e) {

			DB::rollback();

			return response()->json(array('estado' => '0', 'mensaje' => 'Error al eliminar la sesion de terapia familiar:'. $e), 400);

		}

	}


	/**
	 * Método que valida las sesiones nuevas no coincidan con otras ya existentes para el mismo día.
	 */
	public function validarNuevaSesionTerapiaFamiliar(Request $request){

		//DB::enableQueryLog();
		//dd(DB::getQueryLog());
		$inicio 	= strtotime("{$request->ses_ptf_fec} {$request->ses_ptf_hor_ini}:00");
		$termino 	= strtotime("{$request->ses_ptf_fec} {$request->ses_ptf_hor_fin}:00");
		$sesTerFam 	= SesionTerapiaFamiliar::whereRaw("trunc(ses_ptf_fec) = TO_DATE('{$request->ses_ptf_fec}', 'yyyy-mm-dd')")->get();

		foreach ($sesTerFam as $stf){
			$stf_inicio		= strtotime(explode(' ', $stf->ses_ptf_fec)[0] . ' ' . $stf->ses_ptf_hor_ini . ':00');
			$stf_termino	= strtotime(explode(' ', $stf->ses_ptf_fec)[0] . ' ' . $stf->ses_ptf_hor_fin . ':00');
			//if (($stf_inicio <= $inicio && $stf_termino >= $inicio) || ($stf_inicio <= $termino && $stf_termino >= $termino)){
			if (($stf_inicio < $inicio && $stf_termino > $inicio) || ($stf_inicio < $termino && $stf_termino > $termino)){
				return false;
			}
		}

		return true;

	}

	public function validarRunSesionTerapia(Request $request){
		try{
			$run = $request->run;
			if (!Rut::parse($run)->validate()){
				$mensaje = "RUN Incorrecto. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$run = Rut::parse($run)->toArray();
 			$val_run = $this->validarPredictivoPersonaCasoAlertas($run[0], $run[1]);
 			if (!$val_run["caso"]){
 				$mensaje = "RUN sin Caso actualmente abierto. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
 			}

 			$caso = PersonaUsuario::where("run", $run[0])->get();
 			if (count($caso) == 0){
 				$mensaje = "Hubo un error al momento de buscar la información del Caso. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
 			}

 			$persona = Persona::where("per_run", $run[0])->get();
 			if (count($persona) == 0){
 				$mensaje = "Hubo un error al momento de buscar la información del NNA. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
 			}

 			$cas_id = $caso[0]->cas_id;
 			$terapia = Terapia::where("cas_id", $cas_id)->get();
 			if (count($caso) == 0){
 				$mensaje = "Hubo un error al momento de buscar la información de la Terapia. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
 			}

 			$nombre_completo = "Sin información.";
 			if (isset($persona[0]->per_nom) && $persona[0]->per_nom != ""){
 				$nombre_completo = $persona[0]->per_nom;

 				if (isset($persona[0]->per_pat) && $persona[0]->per_pat != "") $nombre_completo .= " ".$persona[0]->per_pat;

 				if (isset($persona[0]->per_mat) && $persona[0]->per_mat != "") $nombre_completo .= " ".$persona[0]->per_mat;
 			}

			return response()->json(array('estado' => '1', 'tera_id' => $terapia[0]->tera_id, 'run' => $run[0], 'nombre' => $nombre_completo), 200);
		}catch(\Exception $e){
			$mensaje = "Hubo un error al momento de validar el RUN ingresado. Por favor intente nuevamente.<br/><br/> - ".$e->getMessage();

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function resumenPlanificacionSesionesTerapia($tera_id){
		try{
			$respuesta = new \stdClass();

			// TOTAL TERAPIAS
			$respuesta->total_terapias = SesionTerapiaFamiliar::obtenerSesionesPlanificadasNNA($tera_id);
				
			// TOTAL TERAPIAS FAMILIAR
			$respuesta->total_terapias_familiar = SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 1, $objetivo = 0);

			// TOTAL TERAPIAS MULTIFAMILIAR
			$respuesta->total_terapias_multi_familiar = SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 2, $objetivo = 0);

			// TOTAL SESION FAMILIAR - DEFINIR EL PROBLEMA QUE PREOCUPA A LA FAMILIA
			$respuesta->total_terapias_objetivo_1 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 1, $objetivo = 1);

			// TOTAL SESION FAMILIAR - CONOCER A LA FAMILIA, SUS INTEGRANTES Y RELACIONES
			$respuesta->total_terapias_objetivo_2 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 1, $objetivo = 2);

			// TOTAL SESION FAMILIAR - TRABAJAR EN EL PROBLEMA QUE DEFINIO LA FAMILIA
			$respuesta->total_terapias_objetivo_3 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 1, $objetivo = 3);

			// TOTAL SESION FAMILIAR - TRABAJAR EN LA SOLUCION AL PROBLEMA Y EN COMO MANTENERLOS AVANCES 
			$respuesta->total_terapias_objetivo_4 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 1, $objetivo = 4);

			// TOTAL TALLER MULTIFAMILIAR - TRABAJAR IDENTIDAD Y PERTENENCIA
			$respuesta->total_terapias_objetivo_5 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 2, $objetivo = 5);

			// TOTAL TALLER MULTIFAMILIAR - TRABAJAR PARENTALIDAD Y CRIANZA
			$respuesta->total_terapias_objetivo_6 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 2, $objetivo = 6);

			// TOTAL TALLER MULTIFAMILIAR - TRABAJAR EN EL DESARROLLO DE HABILIDADES PARENTALES
			$respuesta->total_terapias_objetivo_7 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 2, $objetivo = 7);

			// TOTAL TALLER MULTIFAMILIAR - TRABAJAR SOBRE EL ENTORNO SOCIAL Y COMUNITARIO
			$respuesta->total_terapias_objetivo_8 =	SesionTerapiaFamiliar::detalleSesionesSegunTipo($tera_id, $actividad = 2, $objetivo = 8);

			return $respuesta;

		}catch(\Exception $e){
			return $e->getMessage();

		}
	}

	public function validacionSesionesTerapia($tera_id, $objetivo_id = null, $actividad = null){
		try{
			$respuesta = new \stdClass();
			$respuesta->estado = true;
			$respuesta->mensaje = "";

			// GESTION TERAPIA ABIERTA
			$terapia = DB::table('ai_terapia t')->select('t.tera_id', 't.cas_id', 'et.est_tera_nom')->leftJoin('ai_estado_terapia et', 't.est_tera_id', '=', 'et.est_tera_id')->where("tera_id", $tera_id)->where("est_tera_fin", "=", 0)->get();
			if (count($terapia) == 0){
				$mensaje = "La Gestión de Terapia para este NNA se encuentra finalizada. \n\nEstado: ".$terapia[0]->est_tera_nom.".";

				$respuesta->estado = false;
				$respuesta->mensaje = $mensaje;

				return $respuesta;
			}

			// GESTION CASO ABIERTA
			$caso = DB::table('ai_caso c')->select('c.cas_id', 'ec.est_cas_nom')->leftJoin('ai_estado_caso ec', 'c.est_cas_id', '=', 'ec.est_cas_id')->where("cas_id", $terapia[0]->cas_id)->where("est_cas_fin", "=", 0)->get();
			if (count($caso) == 0){
				$mensaje = "La Gestión de Caso para este NNA se encuentra finalizada. \n\nEstado: ".$caso[0]->est_cas_nom.".";
				
				$respuesta->estado = false;
				$respuesta->mensaje = $mensaje;

				return $respuesta;
			}

			$info_terapia = $this->resumenPlanificacionSesionesTerapia($tera_id);	

			// TOTAL TERAPIAS (MAX: 12)
			if (count($info_terapia->total_terapias) >= 12){
				$mensaje = "Cantidad máxima de sesiones planificadas por terapia, se encuentra completada. \n\n(Máximo: 12 / Total Sesiones Planificadas: ".count($info_terapia->total_terapias).")";
				
				$respuesta->estado = false;
				$respuesta->mensaje = $mensaje;

				return $respuesta;
			}

			switch ($actividad){
				case "Sesión Familiar": // TOTAL TERAPIAS FAMILIAR (MAX: 8)
					if (count($info_terapia->total_terapias_familiar) >= 8){
						$mensaje = "Cantidad máxima de Sesiones Familiares planificadas por terapia, se encuentran ingresadas. \n\n(Máximo: 8 / Total Sesiones Familiares Planificadas: ".count($info_terapia->total_terapias_familiar).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}	
				break;

				case "Taller Multifamiliar": // TOTAL TERAPIAS MULTIFAMILIAR (MAX: 4)
					if (count($info_terapia->total_terapias_multi_familiar) >= 4){
						$mensaje = "Cantidad máxima de Talleres Multifamiliares planificados por terapia, se encuentran ingresados. \n\n(Máximo: 4 / Total Talleres Multifamiliares Planificados: ".count($info_terapia->total_terapias_multi_familiar).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;
			}

			switch($objetivo_id){
				case 1: // TOTAL SESION FAMILIAR - DEFINIR EL PROBLEMA QUE PREOCUPA A LA FAMILIA (MAX: 1)
					if (count($info_terapia->total_terapias_objetivo_1) >= 1){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°1 de la terapia, se encuentran ingresadas. \n\n(Máximo: 1 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_1).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 2:
				case 3: // TOTAL SESION FAMILIAR - CONOCER A LA FAMILIA, SUS INTEGRANTES Y RELACIONES (MAX: 2)
					if (count($info_terapia->total_terapias_objetivo_2) >= 2){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°2 de la terapia, se encuentran ingresadas. \n\n(Máximo: 2 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_2).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 4:
				case 5:
				case 6: // TOTAL SESION FAMILIAR - TRABAJAR EN EL PROBLEMA QUE DEFINIO LA FAMILIA (MAX: 3)
					if (count($info_terapia->total_terapias_objetivo_3) >= 3){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°3 de la terapia, se encuentran ingresadas. \n\n(Máximo: 3 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_3).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 7:
				case 8: // TOTAL SESION FAMILIAR - TRABAJAR EN LA SOLUCION AL PROBLEMA Y EN COMO (MAX: X) MANTENERLOS AVANCES (MAX: 2) 
					if (count($info_terapia->total_terapias_objetivo_4) >= 2){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°4 de la terapia, se encuentran ingresadas. \n\n(Máximo: 2 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_4).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 9: // TOTAL TALLER MULTIFAMILIAR - TRABAJAR IDENTIDAD Y PERTENENCIA (MAX: 1)
					if (count($info_terapia->total_terapias_objetivo_5) >= 1){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°5 de la terapia, se encuentran ingresadas. \n\n(Máximo: 1 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_5).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 10: // TOTAL TALLER MULTIFAMILIAR - TRABAJAR PARENTALIDAD Y CRIANZA (MAX: 1)
					if (count($info_terapia->total_terapias_objetivo_6) >= 1){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°6 de la terapia, se encuentran ingresadas. \n\n(Máximo: 1 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_6).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 11: // TOTAL TALLER MULTIFAMILIAR - TRABAJAR EN EL DESARROLLO DE HABILIDADES PARENTALES (MAX: 1)
					if (count($info_terapia->total_terapias_objetivo_7) >= 1){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°7 de la terapia, se encuentran ingresadas. \n\n(Máximo: 1 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_7).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;

				case 12: // TOTAL TALLER MULTIFAMILIAR - TRABAJAR SOBRE EL ENTORNO SOCIAL Y COMUNITARIO (MAX: 1)
					if (count($info_terapia->total_terapias_objetivo_8) >= 1){
						$mensaje = "Cantidad máxima de sesiones planificadas para el objetivo N°8 de la terapia, se encuentran ingresadas. \n\n(Máximo: 1 / Total sesiones: ".count($info_terapia->total_terapias_objetivo_8).")";
						
						$respuesta->estado = false;
						$respuesta->mensaje = $mensaje;

						return $respuesta;
					}
				break;
			}

			return $respuesta;
		}catch(\Exception $e){
			$respuesta->estado = false;
			$respuesta->mensaje = $e->getMessage();

			return $respuesta;
		}
	}

	public function registrarNumeroSesionesTFComprometidas(Request $request){
		try{
            if (!isset($request->tera_id) || $request->tera_id == ""){
                $mensaje = "No se encuentra ID de la Terapia. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->ter_com_fir) || $request->ter_com_fir == ""){
                $mensaje = "No se encuentra el Número de Sesiones Comprometidas. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();

            $resp = Terapia::where("tera_id", $request->tera_id)->first();
            $resp->ter_com_fir = $request->ter_com_fir;
          
            $respuesta = $resp->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::commit();
            $mensaje = "Registro actualizado con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            $mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }    
	}
	//inicio ch
	public function verNumeroSesionesTFComprometidas(Request $request){
		$ver_sesion = Terapia::where("tera_id", $request->tera_id)->value('ter_com_fir');
		return $ver_sesion;
	}
	//fin ch
	public function documentoRenuncia(Request $request){

		$request->validate($this->reglas_doc_renuncia,[]);

		try {

			DB::beginTransaction();

			if(!$request->file('doc_carta_renuncia')){
				
				$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
        	$files = $request->file('doc_carta_renuncia');

        	$tera_id = $request->tera_id;

        	$destinationPath = 'doc';

        	$doc_fec = Carbon::now();

   		    $extension = $files->getClientOriginalExtension();

        	$filename = "carta_de_renuncia_terapia_familiar_".$tera_id."(".date("dmY").").".$extension;

            $upload_success = $files->move($destinationPath, $filename);

            $terapia = Terapia::find($tera_id);
			$terapia->ter_doc_ren = $filename;
			$respuesta = $terapia->save();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir la carta. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'
				, 'filename' => $filename ),200);

		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Error al momento de subir documento. Por favor intente nuevamente.";
			
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}		
	}


	public function verBitacoraEstadosTerapia($cas_id){
		$sql = "SELECT et.est_tera_nom, to_char(etb.tera_est_tera_fec, 'dd-mm-yyyy') tera_est_tera_fec, etb.tera_est_tera_des FROM ai_terapia t LEFT JOIN ai_est_terapia_bitacora etb ON t.tera_id = etb.tera_id LEFT JOIN ai_estado_terapia et ON etb.est_tera_id = et.est_tera_id  WHERE t.cas_id = ".$cas_id." ORDER BY est_tera_ord";

		$resultado = DB::select($sql);

		return Datatables::of(collect($resultado))->make(true);
	}
// CZ SPRINT 74  
	//OBTENER NOTIFICACION DE TIEMPO DE INTERVENCION
	public function notificacionTiempoIntervencion(){
		return	NotificacionAsignacion::notificacionTiempoIntervencion();
	}
	// CZ SPRINT 74  
}