<?php
namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Modelos\{AlertaManual, Dimension, Persona, Predictivo,
	Problematica, Usuarios,Categoria, AlertaTipo,Ofertas,CasoTerapeuta,
	AlertaManualTipo, EstadoAlerta, CasoAlertaManual, Caso, CasoGrupoFamiliar, OfertaAlerta,
	PersonaUsuario, EstadoAlertaManualEstado, GrupoFamiliar, ObjetivoPaf, TareaObjetivoPaf, Direccion, Provincia, ProgramaAlerta, Programa, Establecimientos, AmProgramas, EstadoProgramas, EstadoProgramasBit, Region, Comuna, AlertaManualContacto,Funcion, AlertasManualesSinNomina, DocPaf, Brecha, BrechaIntegrante, NNAAlertaManualCaso, NNASinRun, AmDimension, NNAAlertaManual};
	use App\Modelos\NominaComunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use DataTables;
use PDF;
use Carbon\Carbon;
use App\Traits\CasoTraitsGenericos;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Console;
use Freshwork\ChileanBundle\Rut;


class AlertaController extends Controller
{

	protected $reglas_doc_consentimiento = [
		'doc_cons' => 'file|mimes:pdf,jpeg,png|max:3072'
	];

	protected $reglas_doc = [
		'archivo' => 'file|mimes:doc,docx,pdf|max:3072'
	];

	protected $regla_validacion_PAF = [
		'archivo' => 'file|mimes:doc,docx,pdf',
		'archivo.required' => 'Hola'
	];

	protected $reglas_doc_encuestasatisfaccion = [
		'enc_sati' => 'file|mimes:pdf,jpeg,png|max:3072'
	];

    //
	use CasoTraitsGenericos;
	
	protected $dimension;
	
	protected $problematica;
	
	protected $predictivo;
	
	protected $persona;
	
	protected $alerta;

	protected $categoria;
	
	protected $caso;
	
	protected $casoGrupoFamiliar;
	
	protected $ofertaAlerta;
	
	protected $personaUsuario;

	protected $comunas;

	protected $Region;

	protected $docPaf;
	
	public function __construct(
		Dimension		$dimension,
		Problematica	$problematica,
		Predictivo		$predictivo,
		Persona			$persona,
		AlertaManual	$alertaManual,
		Usuarios		$usuario,
		Categoria		$categoria,
		AlertaTipo      $AlertaTipo,
		Ofertas         $Ofertas,
		CasoTerapeuta	$caso_terapeuta,
		AlertaManualTipo $AlertaManualTipo,
		EstadoAlerta     $EstadoAlerta,
		CasoAlertaManual $CasoAlertaManual,
        Caso             $caso,
		CasoGrupoFamiliar $casoGrupoFamiliar,
		OfertaAlerta      $ofertaAlerta,
		PersonaUsuario    $personaUsuario,
		Region            $region,
		Comuna   		 $comunas,
		DocPaf           $docPaf
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		//$this->middleware('verificar.perfil:externo,coordinador');
		$this->dimension		= $dimension;
		$this->problematica		= $problematica;
		$this->predictivo		= $predictivo;
		$this->persona			= $persona;
		$this->alertaManual		= $alertaManual;
		$this->usuario			= $usuario;
		$this->categoria		= $categoria;
		$this->alertaTipo		= $AlertaTipo;
		$this->ofertas		    = $Ofertas;
		$this->caso_terapeuta	= $caso_terapeuta;
		$this->alertaManualTipo = $AlertaManualTipo;
		$this->estadoAlerta     = $EstadoAlerta;
		$this->casoAlertaManual = $CasoAlertaManual;
	    $this->caso             = $caso;
	    $this->casoGrupoFamiliar = $casoGrupoFamiliar;
	    $this->ofertaAlerta     = $ofertaAlerta;
	    $this->personaUsuario   = $personaUsuario;
	    $this->region 			= $region;
	    $this->docPaf 			= $docPaf;
	}
	
	/**
	 * Ventana listado de Alertas Territoriales
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){

		try {

			$icono = Funcion::iconos(32);
			
			return view('alertas.main',['icono'=>$icono]);

		} catch(\Exception $e) {
			
			Log::error('error: '.$e);
			$mensaje = "Hubo error al momento de buscar la informaciÃ³n solicitada. Por favor intente nuevamente o contacte con el administrador.";
			
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Registra una alerta en el sistema para un infante
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function registrarAlerta(Request $request){
	    
	    
		try{
		    
		    if($request->nna_run != null){
		        // INICIO CZ SPRINT 77
		    $rutOld = $request->nna_run;
		    $request->nna_run= str_replace('.', '', $request->nna_run);
			$rutDireccion = $request->nna_run;
			$rutValidarDireccion = explode("-", $rutDireccion);
		    $request->nna_run= str_replace('-', '', $request->nna_run);
				// INICIO CZ SPRINT 77
				if(strlen($request->nna_run) > 8 && $request->estado != 2){
		    $request->nna_run = substr($request->nna_run, 0, -1);
		    }
				// INICIO CZ SPRINT 77
		    
		    }
			
			if ((config('constantes.activar_maestro_direcciones')) && ($request->estado == 0)){
				$com_id = Comuna::where("com_cod", $request->com_id_nna)->first();
				if (!$com_id){
					$mensaje = "Hubo un error al momento de buscar la comuna ingresada. Por favor intente nuevamente o contacte con el Administrador.";
	                
	                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
				
				$request->com_id_nna = $com_id->com_id;

				if(!isset($request->id_dir)) $request->id_dir = "";
			}
			
			if(Session::get('perfil') == config('constantes.perfil_gestor')){
				if ($request->estado == 0){
				    
					$val_ingreso_at = false;

					$respuesta = $this->validarPredictivoPersonaCasoAlertas($request->nna_run, Rut::set($request->nna_run)->calculateVerificationNumber());

					if ($respuesta["predictivo"] || $respuesta["integrante_familiar"]){
						$val_ingreso_at = true;

					}

					$respuesta = NNAAlertaManualCaso::where("run", $request->nna_run)->get();

					if ($val_ingreso_at != true && count($respuesta) > 0){
						$val_ingreso_at = true;

					}

					if (!$val_ingreso_at){
						$mensaje = "NNA no puede ser asignado por este perfil, no se encuentra en nomina o asignado a este gestor.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
					}
				}
			}
			
			DB::beginTransaction();
			//$contactos = json_decode($request->contactos);
			$contactos = $request->contactos;

			/*Obtenemos run sin puntos ni guiones*/
			$rut = $request->nna_run;
			
			if($request->estado == 0){ // FORMATO RUT PARA INGRESOS NNA
				$dv_rut = Rut::parse($rut)->vn();
				if (!config('constantes.activar_maestro_direcciones')){
				    //$rut = Rut::parse($request->nna_run)->number();
				    $rut = $request->nna_run;
				}
				
				$codigo = "";

			}else if($request->estado == 1){ // FORMATO PARA LOS NUEVOS NNA SIN RUN
				
					$alertM_id	= AlertaManual::max('ale_man_id');
					$alertM_id  = $alertM_id + 1;
					$rut = $alertM_id.strtotime(now());

				$dv_rut = "S";

				$nna_srn = new NNASinRun();
				
				$nna_srn->nna_run = $rut;
				$nna_srn->nna_nom = $request->nna_nombre;
				$nna_srn->nom_mat = strtoupper($request->nom_mad);
				$nna_srn->ape_mat = strtoupper($request->ape_mad);
				$nna_srn->nom_pat = strtoupper($request->nom_pad);
				$nna_srn->ape_pat = strtoupper($request->ape_pad);

				$codigo = $this->generarCodigoCompuesto($request->nna_nombre, $request->nna_fecha_nac, $request->nom_mad, $request->ape_mad, $request->nom_pad, $request->ape_pad);
				
				$resultado = $nna_srn->save();
				if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar al NNA sin run. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

			}else{ //FORMATO PARA LOS NNS SIMILARES
				
				$rut = $request->nna_run;
				$dv_rut = "S";
				$get_nom = NNASinRun::where('nna_run',$rut)->first();
				$request->nna_nombre = $get_nom->nna_nom;
				$get_codigo = AlertaManual::select('ale_man_cod_nna_srn')->where('ale_man_run',$rut)->first();
				$codigo = $get_codigo->ale_man_cod_nna_srn;
			}
			
			$arr_ale_info_rel = array();
			$arr_ale_id = $request->ale_tip_id;
			$verif_arr = $request->ale_info_rel;
			foreach ($verif_arr as $v) {
				if(!is_null($v) && $v != "") array_push($arr_ale_info_rel, $v);
			}

			$total_ale_tip = count($arr_ale_info_rel);
			
			$est_ale_ini = EstadoAlerta::where("est_ale_ini", 1)->get();
			
			$est_ale_ini = $request->estadoIncor; 
			//DB::insert("insert into ai_estado_alerta_manual_estado (est_ale_id, ale_man_id, est_ale_man_est_fec, ale_just_est) values(4, ".AlertaManual::max('ale_man_id').", sysdate, 'Alerta Territorial en estado Incorporada')");
			
			// INICIO CZ SPRINT 55
			if($request->estado == 0){
			
				// $dir_per = DB::select("SELECT * 
				// FROM ai_direccion dir
				// left JOIN ai_comuna D
				// ON dir.com_id = d.com_id
				// left JOIN ai_provincia p
				// ON d.pro_id = p.pro_id
				// left JOIN ai_region r
				// ON p.reg_id = r.reg_id
				// where dir_id = {$request->dir_id}");
			
				//SE INGRESA UNA NUEVA DIRECCION EN LA TABLA DIRECCION Y EN LA TABLA DE ALERTA_MANUAL
				//SE PREGUNTA SI EL RUT ESTA EN EL SISTEMA 
				// SPRINT 69 SE COMENTA EL INSERT DE DIRECCIONES DE LA TABLA AI_DIRECCIONES AL MOMENTO DE INGRESAR UNA ALERTA
				// $per_id = Persona::where("per_run","=", $rutValidarDireccion[0])->value("per_id");
				// if(count($per_id)>0){
					
				// 	$dir_per = Direccion::where("per_id", "=", $per_id)->where("dir_status", "=",1)->get();
				// 	// INICIO CZ SPRINT 69 MANTIS 9770
				// 	$caso = CasoPersonaIndice::leftJoin("ai_caso", "ai_caso_persona_indice.cas_id", "=", "ai_caso.cas_id")->leftJoin("ai_estado_caso", "ai_caso.est_cas_id", "=","ai_estado_caso.est_cas_id" )->where("ai_caso_persona_indice.per_id", "=", $per_id)->where("ai_estado_caso.est_cas_id", "<>","1")->first();
				// 	// FIN CZ SPRINT 69 MANTIS 9770
				// 	if(count($dir_per) == 0){
				// 		// INICIO CZ SPRINT 69 MANTIS 9770
				// 		$max = Direccion::max('dir_id');
				// 		// FIN CZ SPRINT 69 MANTIS 9770
				// 		$add_dir = new Direccion();
				// 		// INICIO CZ SPRINT 69 MANTIS 9770
				// 		$add_dir->dir_id = $max+1;
				// 		// FIN CZ SPRINT 69 MANTIS 9770
				// 		$add_dir->per_id = $per_id;
				// 		$add_dir->com_id = $request->com_id_nna;
				// 		$add_dir->dir_call = $request->nna_calle;
				// 		$add_dir->dir_num = $request->nna_dir;
				// 		$add_dir->dir_status = 1;
				// 		// INICIO CZ SPRINT 69 MANTIS 9770
				// 		if(count($caso)>0){
				// 			$add_dir->cas_id   = $caso->cas_id;
				// 		}
				// 		// FIN CZ SPRINT 69 MANTIS 9770
				// 		$add_dir->save();
				// 	}
				// }
				// INICIO CZ SPRINT 69
				}

			//FIN CZ SPRINT 55 
			$arr_ale_man_ids = array();
			$total_contact = count($contactos);

			//FIN CZ SPRINT 63 Casos ingresados a ONL
			for($i=0; $i < $total_ale_tip; $i++){
				$alertM_id	= AlertaManual::max('ale_man_id');
				
				$alertM_id  = $alertM_id + 1;
				
				$am = new AlertaManual;
				$am->ale_man_id  = $alertM_id;
				$am->ale_man_run = $rut;
				$am->ale_man_obs = "campo borrar";

				// I.- IDENTIFICACIÃ“N USUARIO:
				$am->dim_id = $request->dim_id;
				$am->ale_man_dir_usu = $request->dir_usu_nna; //null
				$am->ale_man_car_usu = $request->car_usu;

				// II.- IDENTIFICACION DEL NNA o GESTANTE:
				$am->ALE_MAN_NNA_NOMBRE = $request->nna_nombre;
				$am->ALE_MAN_NNA_FEC_NAC = $request->nna_fecha_nac; //null
				$am->ALE_MAN_NNA_EDAD = $request->nna_edad; //NaN
				$am->ALE_MAN_NNA_SEXO = $request->nna_sexo; //null
				$am->REG_ID = $request->reg_id;
				if(is_numeric($am->REG_ID) == false){
				    return response()->json(array('estado' => '0', 'mensaje' => 'El ID de la Region debe ser numerica'), 200);
				}
				$am->COM_ID = $request->com_id_nna;
				$am->ALE_MAN_NNA_CALLE = $request->nna_calle;
				$am->ALE_MAN_NNA_DIR = $request->nna_dir;
				$am->ALE_MAN_NNA_DEPTO = $request->nna_depto;
				$am->ALE_MAN_NNA_BLOCK = $request->nna_block;
				$am->ALE_MAN_NNA_CASA = $request->nna_casa;
				$am->ALE_MAN_NNA_KM_SITIO = $request->nna_km_sitio;
				$am->ALE_MAN_NNA_REF = $request->nna_ref;
				$am->ALE_MAN_NNA_NOM_CUI = $request->nna_nom_cui;
				$am->ALE_MAN_NNA_NUM_CUI = $request->nna_num_cui;
				$am->ALE_MAN_COD_NNA_SRN = $codigo;
				if (config('constantes.activar_maestro_direcciones')){
					$am->ALE_MAN_COD_ID_DIR = $request->id_dir;	
				}

				// IV. ESCOLARIDAD NNA:
				$am->ALE_MAN_EST_EDU = $request->ale_man_est_edu;
				$am->ALE_MAN_CUR = $request->ale_man_cur;
				$am->ALE_MAN_ASI = $request->ale_man_asi;
				$am->ALE_MAN_REN = $request->ale_man_ren;

				// IV. SALUD NNA:
				$am->ALE_MAN_PRE = $request->ale_man_pre;
				$am->ALE_MAN_CEN_SAL = $request->ale_man_cen_sal;
				$am->ALE_MAN_ANT_REL = $request->ale_man_ant_rel;


				// V. ANTECEDENTES FAMILIARES:
				$am->ALE_MAN_ANTE_HIST_FAM = $request->ante_hist_fam;
				$am->ALE_MAN_ANTE_ASPEC_FAM = $request->ante_aspec_fam;
				$am->ALE_MAN_ANTE_INTERV_FAM = $request->ante_interv_fam;
				$am->id_usu = session()->all()["id_usuario"];
				
				$am->est_ale_id  = $est_ale_ini;
				// INICIO CZ SPRINT 77
				if(Session::get('perfil') == config('constantes.perfil_sectorialista')){
					$am->ale_man_tipo  = 1;
				}else if(Session::get('perfil') == config('constantes.perfil_gestor')){
					$am->ale_man_tipo  = 2;
				}else if(Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
					$am->ale_man_tipo  = 3;
				}	
				
				$predictivo = Predictivo::where('run', $rut)->first();
		
				if(count($predictivo) > 0){
				
					$am->ALE_MAN_NOMINA = "SI";
					if($predictivo->nna_sename == 1){
						$am->ALE_MAN_SENAME = "SI";
					}
					
				}else{
					$am->ALE_MAN_NOMINA = "NO";
					$am->ALE_MAN_SENAME = "NO";
				}

				// INICIO CZ SPRINT 77
				
				$resultado = $am->save();
				
				if (!$resultado) throw $resultado;

				// Alerta Manual tipo
				$amt = new AlertaManualTipo;
				$amt->ale_man_id = $am->ale_man_id;
				$amt->ale_tip_id = $arr_ale_id[$i];
				$amt->ale_man_info_rel = $arr_ale_info_rel[$i];
				$resultado = $amt->save();
				
				if (!$resultado) throw $resultado;
				
				$eame = new EstadoAlertaManualEstado;
				$eame->est_ale_id = $est_ale_ini;
				$eame->ale_man_id = $am->ale_man_id;
				if($request->estadoIncor == 1){ //por validar
				    $eame->ale_just_est = "Alerta Territorial en estado Por Validar.";
				}else if($request->estadoIncor == 4){ //Incorporada
				$eame->ale_just_est = "Alerta Territorial en estado Incorporada.";
				}
				
				$resultado = $eame->save();
				
				if (!$resultado) throw $resultado;
				
				array_push($arr_ale_man_ids, $am->ale_man_id);
				//contactos NNA
				for ($index=0; $index < $total_contact; $index++){ 
					$amc = new AlertaManualContacto;
					$amc->AI_ALE_MAN_CON_NOM 	= $contactos[$index]["nombre"];
					$amc->AI_ALE_MAN_CON_PARENT = $contactos[$index]["parentesco"];
					$amc->AI_ALE_MAN_CON_FON 	= $contactos[$index]["telefono"];
					$amc->AI_ALE_MAN_CON_DIR 	= $contactos[$index]["direccion"];
					$amc->AI_ALE_MAN_ID 		= $am->ale_man_id;
					$resultado = $amc->save();
					if (!$resultado) throw $resultado;

				}
			}

			$val_nna = $this->validarPredictivoPersonaCasoAlertas($rut, $dv_rut);
	
			if ($val_nna["caso"] == true){
				$caso = $this->persona->obtenerCasoActualPersona($rut);
				if ($caso){
					foreach ($arr_ale_man_ids AS $v1){
						$cam = new CasoAlertaManual;
						$cam->cas_id = $caso[0]->cas_id;
						$cam->ale_man_id = $v1;
						$resultado = $cam->save();
						if (!$resultado) throw $resultado;

						// Vincula AT al crearla en la Etapa EvaluaciÃ³n DiagnÃ³stica
						if (isset($request->dim_enc_id) || $request->dim_enc_id != ""){
				
							$am_dim = new AmDimension();
							$am_dim->cas_id 	= $caso[0]->cas_id;
							$am_dim->ale_man_id = $v1;
							$am_dim->dim_enc_id = $request->dim_enc_id;
							$resultado = $am_dim->save();			
							if (!$resultado) throw $resultado;
						}
					}
				}
				
			}else if ($val_nna["caso"] == false && $val_nna["integrante_familiar"] == true){
				if ($val_nna["predictivo"] == true){
					$grupo = new GrupoFamiliar();
					$caso  = $grupo->listarCasoActualIntegrante($rut);
	                
					if (count($caso) > 0){
						$gestor_asignado =  $this->usuario->getGestoresAsig($rut);
						
						if ($gestor_asignado){
							$resultado = $this->asociarIntegranteFamiliarCaso($rut, $dv_rut, $caso[0]->cas_id, $gestor_asignado[0]->id);
							
							if ($resultado["estado"] != 1) throw $resultado;
						}
					}
				}
			}			
			
			// cambio estado direccion 
			if ((config('constantes.activar_maestro_direcciones')) && ($request->estado == 0) && ($request->id_dir != null)){
				$cambio_est_dir = $this->cambioVigenciaDireccion($request->id_dir, $request->nna_run);
				if ($cambio_est_dir["status"] != 1){
					DB::rollback();
	                $mensaje = "Hubo un error al cambiar el estado de vigencia de la direcciÃ³n. Por favor intente nuevamente o contacte con el Administrador.";
	                
	                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			}
	
			DB::commit();

			$mensaje = "Alerta Territorial creada con Ã©xito.";

			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			dd($e);
			DB::rollback();	
			Log::error('Error: '.$e);
			
			$mensaje = "Hubo un error desconocido al momento de guardar la(s) Alerta(s) Territorial(es). Por favor intente nuevamente.";
			if (!is_null($e->getMessage()) && $e->getMessage() != "") $mensaje = $e->getMessage();

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	/**
	 * Registra una alerta en el sistema para un infante
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function editarAlerta(Request $request, $id){
		try{
			$comunas = Comuna::all();
			$region = region::all();

			$dimension =  Dimension::where("dim_act", "=", 1)->get();

			$contacto_nna_alert = DB::select("select * from ai_alerta_manual_contactos where ai_ale_man_id=".$id);

			$alertaManual = $this->alertaManual->registroAlertaManual($id);
			if (count($alertaManual) == 0) return redirect()->back()->with('danger', 'Hubo un error Buscando la alerta.');
			
			$AlertasTiposReg =  $this->alertaTipo->AlertasTiposReg($id);

			$idsAlertReg="";
			$cont=0;
			foreach ($AlertasTiposReg as $value) {
				if($cont==0){
			   		$idsAlertReg = $value->ale_tip_id;
			   		$cont=1;
			   	}else{
					$idsAlertReg = $idsAlertReg.",".$value->ale_tip_id;	
				}
			}
			
			$tipo_nna = NNASinRun:: where('nna_run',$alertaManual[0]->ale_man_run)->first();
			if(count($tipo_nna) == 0){
				$dv_run = Rut::set($alertaManual[0]->ale_man_run)->calculateVerificationNumber();
				$rut_completo = Rut::parse($alertaManual[0]->ale_man_run.$dv_run)->format();
			}else{
				$dv_run = "S";
				$rut_completo = $alertaManual[0]->ale_man_run."-".$dv_run;
			}

			// $dv_run = Rut::set($alertaManual[0]->ale_man_run)->calculateVerificationNumber();
			// $rut_completo = Rut::parse($alertaManual[0]->ale_man_run.$dv_run)->format();
			$nnaNombre = $alertaManual[0]->ale_man_nna_nombre;

			$dv_run_usu = Rut::set($alertaManual[0]->run)->calculateVerificationNumber();
			$rut_completo_usu = Rut::parse($alertaManual[0]->run.$dv_run_usu)->format();

			$url_mapa = config('constantes.sit_url').'?mapId='.config('constantes.sit_mapid')
				.'&serId='.config('constantes.sit_serid')
				.'&ext='.config('constantes.sit_ext')
				.'&regExt='.config('constantes.sit_regext')
				.'&token='.$request->user()->token
				.'&usuId='.$request->user()->run;


			return view('alertas.editar_alerta')->with([
				'alertaManual' 			=> $alertaManual,
				'nnaNombre' 			=> $nnaNombre, 
				'idsAlertReg' 			=> $idsAlertReg,
				'rut_completo' 			=> $rut_completo, 
				'comunas' 				=> $comunas, 
				'region' 				=> $region,
				'dimension' 			=> $dimension, 
				'contacto_nna_alert' 	=> $contacto_nna_alert,
				'rut_completo_usu' 		=> $rut_completo_usu,
				'url_mapa' 				=> $url_mapa
			]);

		}catch(\Exception $e){
			$mensaje = "Hubo inconvenientes al momento de desplegar el formulario de Alertas Territoriales. Por favor intente nuevamente o contacte con el Administrador.";

			return view('layouts.errores')->with(['mensaje' => $mensaje]);
		}
	}


	/**
	 * Registra una alerta en el sistema para un infante
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function ofertaRegistrar(Request $request){
		try {
			
			DB::beginTransaction();

			$total_ofe_tip = count($request->ofe_id);

			$arr_ofe_id = $request->ofe_id;

			// $actulizaAlertaM = DB::update("UPDATE AI_ALERTA_MANUAL SET cat_urg_id=". $request->cat_urg_id." where ale_man_id=".$request->id_ale_man."");

			//dd($actulizaAlertaM);

			for($i=0;$i<$total_ofe_tip;$i++){

			$borrarAlerta = DB::delete("DELETE AI_AM_OFERTAS where ale_man_id=".$request->id_ale_man."");
			}

			//dd($borrarAlerta);

			for($i=0;$i<$total_ofe_tip;$i++){
				$registroAlerta = DB::insert("INSERT INTO AI_AM_OFERTAS
				(ofe_id,ale_man_id)
				VALUES (".$arr_ofe_id[$i].",".$request->id_ale_man.")");
			}
			
			DB::commit();

			return view('alertas.main')
				->with('success', 'La Alerta ha Sido Modificada Exitosamente.');
			
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			return redirect()->back()
				->with('danger', 'Ha Ocurrido un Error Modificando la Alerta.');
		}
	}

	
		/**
	 * Registra una alerta en el sistema para un infante
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function elaborarPaf(Request $request){
		try {
			DB::beginTransaction();
			
			if ($request->option == "" || !isset($request->option) || $request->caso_id == "" || !isset($request->caso_id)){
				DB::rollback();
				$mensaje = "No se puede completar la acciÃ³n debido a falta de informaciÃ³n. Por favor intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
            switch ($request->option){
				case 1: //RECOMENDACION A TERAPIA
					$recomendacion_terapia = Caso::where("cas_id", "=", $request->caso_id)->first();
					$recomendacion_terapia->nec_ter = $request->nec_ter;
					$recomendacion_terapia->cas_just_terapia = $request->cas_just_terapia;

					$resultado = $recomendacion_terapia->save();
					if (!$resultado){
						DB::rollback();

						$mensaje = "Error al momento de guardar la selecciÃ³n de recomendaciÃ³n a terapia. Por favor intente nuevamente.";

						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
					}
				break;
	
				// rruiz 01082019
				// se comenta todo el bloque de opcion "2" pues ahora
				// el gestor NO podrÃ¡ elegir al terapeuta
				/*case 2: //Terapeuta asignado
					$cas = Caso::where("cas_id", "=", $request->caso_id)->first();
					$caso_terapeuta = CasoTerapeuta::where("cas_id", "=", $request->caso_id)->first();
				
					if ($cas->nec_ter == 1){
						if (count($caso_terapeuta) > 0){ //Actualizar registro
							$caso_terapeuta->ter_id = $request->valor;
							$resultado = $caso_terapeuta->save();
							
							if (!$resultado){
								DB::rollback();
								$mensaje = "Error al momento de actualizar registro. Por favor intente nuevamente.";
								
								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
							}
						}else if (count($caso_terapeuta) == 0){ //Insertar Registro
							$cas_ter_id	= CasoTerapeuta::max('cas_ter_id');
							$cas_ter_id = $cas_ter_id + 1;
							
							$sql = "INSERT INTO ai_caso_terapeuta (cas_ter_id, ter_id, cas_id)
									VALUES('".$cas_ter_id."', '".$request->valor."', '".$request->caso_id."')";
							$resultado = DB::insert($sql);
							
							if (!$resultado){
								DB::rollback();
								$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
								
								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
							}
						}
					}else if(count($caso_terapeuta) > 0){
						$resultado = $caso_terapeuta->delete();
						
						if (!$resultado){
							DB::rollback();
							$mensaje = "Error al momento de eliminar registro. Por favor intente nuevamente.";
							
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
						}
					}
				break;*/
	
				case 3: //Ofertas y grupo famiiar asignadas

					$ofe_id = $request->ofe_id;
					$ale_man_id = $request->ale_id;
					$parent_id = $request->parent_id;
					$est_prest_id = 2;

					//$fec_cre = date("y/m/d H:i:s"); campo con default en bd
					
					$busAlertaOferta = $this->alertaTipo->busalertaOfertaDos($ofe_id,$ale_man_id,$parent_id);
					
					if($busAlertaOferta){
						$elmiAlertaOferta = $this->alertaTipo->elimAlertaOfertaDos($ofe_id,$ale_man_id,$parent_id);
						
						if (!$elmiAlertaOferta){
							DB::rollback();
							$mensaje = "Error al momento de eliminar registro. Por favor intente nuevamente.";
							
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
						}
					}else {

						$alertaOferta = $this->alertaTipo->alertaOfertaDos($ofe_id, $ale_man_id,
							$parent_id, $est_prest_id);

						$maxId = DB::select("select max(am_prog_id) as id from AI_AM_PROGRAMAS");

       					$id = $maxId[0]->id;

       					// $maxId = DB::select("select max(est_prest_bit_id) as idprest from ai_estado_prest_bitacora");

       					// $idPrest = $maxId[0]->idprest+1;
						
/*						$bitacoraPrestacEst = DB::insert("INSERT INTO ai_estado_prest_bitacora
						(est_prest_bit_id, est_prest_id, am_ofe_id, est_prest_fec,ofe_id)
						VALUES('".$idPrest."', '".$est_prest_id."', '".$id."', '".$fec_cre."','".$ofe_id."')");*/

						// $bitacoraPrestacEst = DB::insert("INSERT INTO ai_estado_prest_bitacora (est_prest_bit_id, est_prest_id, am_ofe_id, ofe_id) VALUES('".$idPrest."', '".$est_prest_id."', '".$id."', '".$ofe_id."')");

						// $bitacoraPrestacEst = DB::insert("INSERT INTO ai_estado_estados_programas_bit (am_prog_id, est_prog_id, est_prog_bit_des, est_prog_bit_fec) VALUES('".$ofe_id."', '".$est_prest_id."', '".$ofe_id."')");

					$bitacoraPrestacEst = DB::insert("INSERT INTO ai_estados_programas_bit(am_prog_id,est_prog_id)VALUES(".$id.",".$est_prest_id.")");


					}
				break;

				case 4: //ACTUALIZA CAMPO JUSTIFICACION TERAPIA

					$actualizaCaso = DB::update("UPDATE AI_CASO SET CAS_JUST_TERAPIA='".$request->valor."' where cas_id='".$request->caso_id."'");
						
					if (!$actualizaCaso) {
						DB::rollback();
						$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
							
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
					}
						
				break;

				case 5: // CAMBIA EL ESTADO DE LA ALERTA A "NO CORRESPONDE".

					$est_ale_id = null;

					if($request->btn==2){
						$est_ale_id = 7;
					}
					else{
						$est_ale_id = 1;
					}

					$actualizaAlerta = DB::update("UPDATE AI_ALERTA_MANUAL SET est_ale_id=".$est_ale_id." where ale_man_id='".$request->valor."'");

					if (!$actualizaAlerta) {
						DB::rollback();
						$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
							
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
					}

					//$fec_cre = date("y/m/d H:i:s"); campo con default en bd

/*					$bitacoraAlerta = DB::insert("INSERT INTO ai_estado_alerta_manual_estado 
					(est_ale_id, ale_man_id, est_ale_man_est_fec, ale_just_est)
					VALUES('".$est_ale_id."', '".$request->valor."', '".$fec_cre."', '".$request->justificar."')");*/

					$bitacoraAlerta = DB::insert("INSERT INTO ai_estado_alerta_manual_estado 
					(est_ale_id, ale_man_id, ale_just_est)
					VALUES('".$est_ale_id."', '".$request->valor."', '".$request->justificar."')");

					if (!$bitacoraAlerta) {
						DB::rollback();
						$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
							
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
					}
				
				break;

				case 6: // HABILITA O DESESTIMA A OFERTA.

					$justificar = null;
					$est_prest_id = null;

					if($request->btn==1){
						$est_prest_id = 6;
						$justificar = $request->justificar;
					}
					else{
						$est_prest_id = 1;
					}

					//$fec_cre = date("y/m/d H:i:s"); campo tiene default en bd

					$maxId = DB::select("select max(est_prest_bit_id) as idprest from ai_estado_prest_bitacora");

       				$idPrest = $maxId[0]->idprest+1;

					$actualizaOferta = DB::update("UPDATE AI_AM_OFERTAS SET est_prest_id=".$est_prest_id." where ale_man_id='".$request->ale_man_id."' and ofe_id='".$request->ofe_id."' and ofe_id='".$request->ofe_id."' and gru_fam_id='".$request->gru_fam_id."'");

					$am_ofe_id = DB::select("SELECT am_ofe_id FROM AI_AM_OFERTAS  where ale_man_id='".$request->ale_man_id."' and ofe_id='".$request->ofe_id."' and ofe_id='".$request->ofe_id."' and gru_fam_id='".$request->gru_fam_id."'");

					$am_ofe_id = $am_ofe_id[0]->am_ofe_id;

/*					$bitacoraPrestacEst = DB::insert("INSERT INTO ai_estado_prest_bitacora
					(est_prest_bit_id, est_prest_id, am_ofe_id, est_prest_fec,est_prest_jus,ofe_id)
					VALUES('".$idPrest."', '".$est_prest_id."', '".$am_ofe_id."','".$fec_cre."','".$justificar."','".$request->ofe_id."')");*/

					$bitacoraPrestacEst = DB::insert("INSERT INTO ai_estado_prest_bitacora
					(est_prest_bit_id, est_prest_id, am_ofe_id,est_prest_jus,ofe_id)
					VALUES('".$idPrest."', '".$est_prest_id."', '".$am_ofe_id."','".$justificar."','".$request->ofe_id."')");

				break;
			}
			
			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Registro guardado exitosamente.'),200);
		
		} catch(\Exception $e) {

			DB::rollback();
			
			$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
			Log::error('error: '.$mensaje);
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}
	}

	public function imprimir($run, $cas_id = null){
		$dv = Rut::set($run)->calculateVerificationNumber();
		$run_formateado = Rut::parse($run.$dv)->format();

		$estados_tarea = [0 => config('constantes.est_tarea_vigente'), 1 => config('constantes.est_tarea_en_ejecucion'), 2 => config('constantes.est_tarea_finalizada')];

		$data = array();
		$objetivos = ObjetivoPaf::where("cas_id", "=", $cas_id)->orderBy('obj_id', 'asc')->get();

		foreach($objetivos AS $c1 => $v1){

		$tareas = TareaObjetivoPaf::where("obj_id", "=", $v1->obj_id)->whereIn("est_tar_id", $estados_tarea)->orderBy('tar_id', 'asc')->get();

		if(count($tareas) > 0){
			$data[$c1] = new \stdClass;
			$data[$c1]->obj_id = $v1->obj_id;
			$data[$c1]->obj_nom = $v1->obj_nom;
			$data[$c1]->cas_id = $v1->cas_id;

			$data[$c1]->tareas = array();
		
			// if (count($tareas) == 0){
			// 	$data[$c1]->tareas[0] = new \stdClass;
			// 	$data[$c1]->tareas[0]->tar_id 		 = "Sin informaciÃ³n";
			// 	$data[$c1]->tareas[0]->obj_id 		 = "Sin informaciÃ³n";
			// 	$data[$c1]->tareas[0]->tar_descripcion = "Sin informaciÃ³n";
			// 	$data[$c1]->tareas[0]->tar_plazo 		 = "Sin informaciÃ³n";
			// 	$data[$c1]->tareas[0]->responsable 	 = "";
			// 	$data[$c1]->tareas[0]->tar_observacion = "Sin informaciÃ³n";

			// }else if (count($tareas) > 0){	
			if (count($tareas) > 0){	
				foreach ($tareas AS $c2 => $v2){
						$data[$c1]->tareas[$c2] = new \stdClass;
						$data[$c1]->tareas[$c2]->tar_id = $v2->tar_id;
						$data[$c1]->tareas[$c2]->obj_id = $v2->obj_id;

						$data[$c1]->tareas[$c2]->tar_descripcion = "Sin informaciÃ³n";
						if (!is_null($v2->tar_descripcion) && $v2->tar_descripcion != ""){
							$data[$c1]->tareas[$c2]->tar_descripcion = $v2->tar_descripcion;
						}

						$data[$c1]->tareas[$c2]->tar_plazo = "Sin informaciÃ³n";
						if (!is_null($v2->tar_plazo) && $v2->tar_plazo != ""){
							$data[$c1]->tareas[$c2]->tar_plazo = $v2->tar_plazo;
						}


					// ---------------- RESPONSABLE -------------------------------
					$gestor = "";
					if (!is_null($v2->tar_gestor_id) && $v2->tar_gestor_id != ""){
						$gestor = Usuarios::where("id", "=", $v2->tar_gestor_id)->get();
						if (count($gestor) > 0){
							$gestor = $gestor[0]->nombres." ".$gestor[0]->apellido_paterno." ".$gestor[0]->apellido_materno.chr(10);
						}
					}

					$nombres = array();
					$grup_fam = DB::select("SELECT * FROM ai_obj_tarea_grup_fam_paf WHERE tar_id =".$v2->tar_id."");

					foreach ($grup_fam as $val){
						if (!is_null($val->gru_fam_id) && $val->gru_fam_id!= ""){
							$integrante = GrupoFamiliar::where("gru_fam_id", "=", $val->gru_fam_id)->get();

							foreach ($integrante as $int){
								$nom_tmp = "";
								$nom_tmp = "- ".mb_strtolower($int->gru_fam_nom)." ".mb_strtolower($int->gru_fam_ape_pat)." ".mb_strtolower($int->gru_fam_ape_mat).chr(10);

								array_push ($nombres, $nom_tmp);

								}
							}
					}

					if (count($nombres) == 0){
						if (!is_null($gestor) && $gestor != ""){
							$data[$c1]->tareas[$c2]->responsable = ucwords($gestor);

						}else{
							$data[$c1]->tareas[$c2]->responsable = "Sin informaciÃ³n";
						
						}
					}else if (count($nombres) == 1){
						if (!is_null($gestor) && $gestor != ""){
							$data[$c1]->tareas[$c2]->responsable = ucwords($gestor);
							$limpiar_str = str_replace("-", "", $nombres[0]);
							$data[$c1]->tareas[$c2]->responsable .= ucwords($limpiar_str);

						}else{
							$limpiar_str = str_replace("-", "", $nombres[0]);
							$data[$c1]->tareas[$c2]->responsable = ucwords($limpiar_str);

						}
					}else if (count($nombres) > 1){
						if (!is_null($gestor) && $gestor != ""){
							$data[$c1]->tareas[$c2]->responsable = ucwords($gestor);
							$str = implode("-", $nombres);
							$limpiar_str = str_replace("-", "", $str);
							$data[$c1]->tareas[$c2]->responsable .= ucwords($limpiar_str);

						}else{
							$str = implode("-", $nombres);
							$limpiar_str = str_replace("-", "", $str);
							$data[$c1]->tareas[$c2]->responsable = ucwords($limpiar_str);

						}
					}
					// ---------------- RESPONSABLE -------------------------------

					$data[$c1]->tareas[$c2]->tar_observacion = "Sin informaciÃ³n";
					if (!is_null($v2->tar_observacion) && $v2->tar_observacion != ""){
						$data[$c1]->tareas[$c2]->tar_observacion = $v2->tar_observacion;
					}

				}
			}
		
		  }	
		}
		

		/*Obtenemos la fecha actual*/
     	$today = Carbon::now()->format('d/m/Y');
		//return view('pdf.doc_paf',['today' => $today, 'data' => $data, 'run_formateado' => $run_formateado]);

     	//dd($data);

     	/*Generamos el PDF*/
 	 	//$pdf = \PDF::loadView('pdf.doc_paf',compact('today','caso','usuarioAsignado','nna_rut', 'grupo_familiar', 'alertas', 'descartadas', 'terapeuta', 'gestor'));

 	 	$pdf = \PDF::loadView('pdf.doc_paf',compact('today','data','run_formateado'));

 	 	$pdf->setPaper('A4', 'landscape');

 	 	//return $pdf->stream('result.pdf');

 	 // 	return view('pdf.doc_paf')->with([
			// 	'today' => $today,
			// 	'data' => $data, 
			// 	'run_formateado' => $run_formateado
			// ]);
 	 	
 	 	/*Se devuelve el documento para su descarga*/
		//inicio Andres F.  
     	return $pdf->download('Plan de Atención Familiar ('.date("d-m-Y").').pdf');
	}

	function eliminar_acentos($cadena){

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}

	//Fin Andres F.
	/**
	 * Devuelve las problematicas asociadas a una dimension
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getProblematica(Request $request){
		try{
			$problematicas = $this->problematica->getByDimension($request->dim_id);
			
			return response()->json($problematicas);
		
		} catch (\Exception $e){
			Log::error('error: '.$e);
			return response()->json([]);
		}
	}
	
	/**
	 * Verifica si un Rut dado existe en predictivo
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getRut(Request $request){
		try{
			$encontrado = true;
			$pertenece_comuna = false;
			
			$persona = $this->predictivo->getByRutExterno($request->rut);
			if (is_null($persona)) $encontrado = false;
			
			if ($encontrado == true) {
				if (session()->all()["com_cod"] == $persona->dir_com_1) $pertenece_comuna = true;
			}
		
			return response()->json(['encontrado' => $encontrado, 'persona' => $persona, 'pertenece_comuna' => $pertenece_comuna]);
		}catch (\Exception $e){
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento obtener información de la persona. Por favor verifique e intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(['encontrado'=> false, 'errores'=>$mensaje],404);
		}
	}
	
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main(){

		return view('alertas.main');
		
	}
	
	/**
	 *
	 */
	public function listarAlertas(){
		$com_ses 	= explode(',', Session::get('com_cod'));
		$perfil 	= Session::get('perfil');
		$respuesta 	= array();
		// CZ SPRINT 75
		if($perfil == config('constantes.perfil_sectorialista') || $perfil == config('constantes.perfil_gestor_comunitario')){
		// CZ SPRINT 75	
			$respuesta = AlertaManual::where("id_usu",session()->all()['id_usuario'])
										->where("com_id",session()->all()['com_id'])->get();

			foreach($respuesta  AS $c1 => $v1){
				
				$tipo_id = AlertaManualTipo::select('ale_tip_id')->find($v1->ale_man_id);
				$tipo = AlertaTipo::select('ale_tip_nom')->find($tipo_id->ale_tip_id);

				$respuesta[$c1]->ale_tip_nom = $tipo->ale_tip_nom;

				$est_alerta = EstadoAlerta::select('est_ale_nom')->find($v1->est_ale_id);
				$respuesta[$c1]->est_ale_nom = $est_alerta->est_ale_nom;
				
				$usuario = Usuarios::find(session()->all()['id_usuario']);
				$respuesta[$c1]->usuario = $usuario->nombre_completo;
				
				$tipo_nna = NNASinRun:: where('nna_run',$v1->ale_man_run)->first();
				if(count($tipo_nna) == 0){
					$dv = Rut::set($v1->ale_man_run)->calculateVerificationNumber(); 
					$rut = Rut::parse($v1->ale_man_run.$dv)->format();
					$respuesta[$c1]->rut_completo = $rut;
				
				}else{
					$rut = $v1->ale_man_run."-S";
					$respuesta[$c1]->rut_completo = $rut;
				
				}

				$respuesta[$c1]->estado_caso = "Sin Estado";

				$casos = NNAAlertaManualCaso::where('run', $v1->ale_man_run)->first();
				if (count($casos) > 0){
					$respuesta[$c1]->estado_caso = $casos->est_cas_nom;
				
				}
				
			}
				
		}else{
			$id_casos = array();
			$id_at = array();

			//Se obtiene el total de casos asignados al GESTOR
			$casos = NNAAlertaManualCaso::select('cas_id')
				->where('est_cas_fin','<>',1)
				->where('usuario_id',session()->all()['id_usuario'])
				->get();

			if (count($casos) > 0){
				foreach ($casos AS $c0 => $v0) array_push($id_casos, $v0->cas_id); 

				$id_casos = implode(",", $id_casos); 
				$respuesta = $this->alertaManual->listarAlertasGestor($id_casos,$com_ses);

				foreach ($respuesta AS $c1 => $v1){
					array_push($id_at, $v1->ale_man_id); 

					$tipo_nna = NNASinRun:: where('nna_run',$v1->ale_man_run)->first();
					if(count($tipo_nna) == 0){
						$dv = Rut::set($v1->ale_man_run)->calculateVerificationNumber(); 
						$rut = Rut::parse($v1->ale_man_run.$dv)->format();
					
					}else{
						$rut = $v1->ale_man_run."-S";
					
					}

					$respuesta[$c1]->rut_completo = $rut;
				}

				$respuesta1 = AlertaManual::whereNotIn('ale_man_id', $id_at)->where("id_usu",session()->all()['id_usuario'])
										->where("com_id",session()->all()['com_id'])->get();				

				foreach($respuesta1  AS $c2 => $v2){
					$tipo_id = AlertaManualTipo::select('ale_tip_id')->find($v2->ale_man_id);
					$tipo = AlertaTipo::select('ale_tip_nom')->find($tipo_id->ale_tip_id);

					$est_alerta = EstadoAlerta::select('est_ale_nom')->find($v2->est_ale_id);
					$usuario = Usuarios::find(session()->all()['id_usuario']);
				
					$tipo_nna = NNASinRun:: where('nna_run',$v2->ale_man_run)->first();
					if(count($tipo_nna) == 0){
						$dv = Rut::set($v2->ale_man_run)->calculateVerificationNumber(); 
						$rut = Rut::parse($v2->ale_man_run.$dv)->format();
					
					}else{
						$rut = $v2->ale_man_run."-S";
					
					}

					$indice = count($respuesta);
					$respuesta[$indice] = new \stdClass;
					$respuesta[$indice]->ale_man_id 	= $v2->ale_man_id;	
					$respuesta[$indice]->ale_man_run 	= $v2->ale_man_run;
					$respuesta[$indice]->ale_man_nna_nombre = $v2->ale_man_nna_nombre;
					$respuesta[$indice]->ale_tip_nom 	= $tipo->ale_tip_nom;
					$respuesta[$indice]->ale_man_fec 	= $v2->ale_man_fec;
					$respuesta[$indice]->ale_man_obs 	= $v2->ale_man_obs;
					$respuesta[$indice]->est_ale_nom 	= $est_alerta->est_ale_nom;
					$respuesta[$indice]->usuario 		= $usuario->nombre_completo;
					$respuesta[$indice]->rut_completo 	= $rut;	
				}
			}
		}

		$data	= new \stdClass();
		$data->data = $respuesta;

		echo json_encode($data); exit;
	}

	/**
	 *
	 */
	public function listarAlertasFiltro($cod_com){

		$alertas = $this->alertaManual->listadoAlertasManuales($cod_com);

		$data	= new \stdClass();
		$data->data = $alertas;

		echo json_encode($data); exit;
	}
	
	/**
	 * @param null $ale_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */

	public function crearAlertas(Request $request){
		try{
		  	$comunas = Comuna::all();
			$region = region::all();
			$dimension =  Dimension::where("dim_act", "=", 1)->get();
			$run = $request->run;

			$usuSec = $this->usuario->getUsuarioSectorialista();

			$alertaTipos = $this->alertaTipo->listadoAlertasTipos();

			$dv_run_usu = Rut::set($usuSec[0]->run)->calculateVerificationNumber();
			$rut_completo_usu = Rut::parse($usuSec[0]->run.$dv_run_usu)->format();

			$categorias = $this->categoria->all();
		
			$url_mapa = config('constantes.sit_url').'?mapId='.config('constantes.sit_mapid')
				.'&serId='.config('constantes.sit_serid')
				.'&ext='.config('constantes.sit_ext')
				.'&regExt='.config('constantes.sit_regext')
				.'&token='.$request->user()->token
				.'&usuId='.$request->user()->run;
		  
			return view('alertas.registrar_alerta')
				->with(['categorias' 	=> $categorias, 
						'alertaTipos'	=> $alertaTipos, 
						'usuSec' 		=> $usuSec ,
						'region' 		=> $region,
						'comunas' 		=> $comunas,
						'dimension' 	=> $dimension, 
						'url_mapa' 		=> $url_mapa, 
						'rut_completo_usu' => $rut_completo_usu,
						'run'			=> $run
						]);

		}catch(\Exception $e){
			$mensaje = "Hubo inconvenientes al momento de desplegar el formulario de Alertas Territoriales. Por favor intente nuevamente o contacte con el Administrador.";

			return view('layouts.errores')->with(['mensaje' => $mensaje]);
		}
	}

	public function buscarAlertaReg(Request $request){
	    $run = $request->per_run;
	    $dig = $request->per_dig;
	    $run = str_replace('.', '', $run);
	    
	    $per_id = Persona::where("per_run", $run)->where("per_dig", $request->per_dig)->value("per_id");
		// INICIO CZ SPRINT 69
		if(count($per_id) > 0){
			// INICIO CZ SPRINT 69
			$dir_per = DB::select("select distinct com_id,dir_call,dir_num,dir_dep, dir_sit, dir_block, dir_casa, cas_id from AI_DIRECCION where PER_ID = {$per_id}
			and cas_id in (Select max(cas_id) from AI_PERSONA_USUARIO where run = {$run})");
			// FIN CZ SPRINT 69
			foreach($dir_per as $key => $value){
	        $comuna = Comuna::where("com_id", "=", $value->com_id)->first();
	        $provincia = Provincia::where("pro_id", "=", $comuna->pro_id)->first();
	        $region = Region::where("reg_id", "=", $provincia->reg_id)->value("reg_nom");	        
	        echo "<tr>";
				 // INICIO CZ SPRINT 69
				echo "<td id='region_".$key."' >".$region."</td>";
				echo "<td id='provincia_".$key."' >".$provincia->pro_nom."</td>";
				echo "<td id='comuna_".$key."'>".$comuna->com_nom."</td>";
				echo "<td id='dir_call_".$key."' >".$value->dir_call."</td>";
				echo "<td id='dir_num_".$key."'>".$value->dir_num."</td>";
				echo "<td id='dir_dep_".$key."' >".$value->dir_dep."</td>";
				echo "<td id='dir_block_".$key."'>".$value->dir_block."</td>";
				echo "<td id='dir_casa_".$key."'>".$value->dir_casa."</td>";
				echo "<td id='dir_sit_".$key."'>".$value->dir_sit."</td>";
				echo '<td><label class="miro-radiobutton">
				<input type="checkbox" class="checkbox_encontrado" value="'.$key.'"  onclick="encontrado('.$key.')" name="radio" id="radio'.$key.'">
				<span id="label_'.$key.'" class="span_label" style="display:none">Ubicado</span>
				</label></td>';
				 // FIN CZ SPRINT 69
	        //echo '<td><button type="button" class="btn btn-primary btn-sm elem_1" onclick="eliminarDireccion('.$value->dir_id.');">Eliminar</button></td>';
	        echo "</tr>";
	    }
	    //echo $per_id;
	}
		// INICIO CZ SPRINT 69
	}

	// INICIO CZ SPRINT 55
	public function direccionPersona(Request $request){
		$dir_per = DB::select("SELECT * 
		FROM ai_direccion dir
		left JOIN ai_comuna D
		ON dir.com_id = d.com_id
		left JOIN ai_provincia p
		ON d.pro_id = p.pro_id
		left JOIN ai_region r
		ON p.reg_id = r.reg_id
		where dir_id = {$request->dir_id}");
		return response()->json(array('estado' => '1', 'respuesta' => $dir_per), 200); 
	}

	public function getRegion(Request $request){
		$comuna = Comuna::where("com_id", "=", $request->idComuna)->get();
		$provincia = Provincia::where("pro_id", "=",$comuna[0]->pro_id)->get();
		$region = Region::where("reg_id", "=", $provincia[0]->reg_id)->get();
		return response()->json(array('estado' => '1', 'comuna' => $comuna, 'provincia' => $provincia, 'region' => $region ), 200); 
		
		
	}
	//FIN CZ SPRINT 55


	public function buscarDireccion(Request $request){
		$run = $request->per_run;
		$dig = $request->per_dig;

		$per_id = Persona::where("per_run", $request->per_run)->where("per_dig", $request->per_dig)->value("per_id");
		$dir_per = Direccion::where("per_id", "=", $per_id)->get();

		foreach($dir_per as &$value){
			$comuna = Comuna::where("com_id", "=", $value->com_id)->first();
			$provincia = Provincia::where("pro_id", "=", $comuna->pro_id)->first();
			$region = Region::where("reg_id", "=", $provincia->reg_id)->value("reg_nom");

			echo "<tr>";
			echo "<td>".$region."</td>";
			echo "<td>".$provincia->pro_nom."</td>";
			echo "<td>".$comuna->com_nom."</td>";
			echo "<td>".$value->dir_call."</td>";
			echo "<td>".$value->dir_num."</td>";
			if (isset($value->dir_status)){
				if ($value->dir_status == 0) {
					echo '<td><input type="checkbox" name="estado" value="1" onclick="actualizarEstado('.$value->dir_id.', $(this).val());"/>No Actual</td>';

				}elseif ($value->dir_status == 1){
					echo '<td><input type="checkbox" name="estado" value="0" checked="checked" onclick="actualizarEstado('.$value->dir_id.', $(this).val());" />Actual</td>';

				}
				
			}else{
				echo '<td><input type="checkbox" name="estado" value="1" onclick="actualizarEstado('.$value->dir_id.', $(this).val());"/>No Actual</td>';

			}
			//echo '<td><button type="button" class="btn btn-primary btn-sm elem_1" onclick="eliminarDireccion('.$value->dir_id.');">Eliminar</button></td>';
			echo "</tr>";
		}
		
		echo $dir_per;
	}

	public function actualizarEstado(Request $request){
		$status = Direccion::find($request->id);
		 //INICIO CZ SPRINT 55
		 DB::update("Update  ai_direccion set dir_status = 0 where per_id = {$status->per_id}");
		 //INICIO FIN SPRINT 55
 		$status->dir_status = $request->estado;
		$status->save(); 

	}

	public function guardarDireccion(Request $request){
		$run = $request->persona;
		//$dig = $request->per_dig;
		$per_id = Persona::where("per_run", "=", $run)->value("per_id");
		//echo $per_id;
		// INICIO CZ SPRINT 69 MANTIS 9770
		$max = Direccion::max('dir_id');
		$add_dir = new Direccion();
		$add_dir->dir_id = $max+1;
		// FIN CZ SPRINT 69 MANTIS 9770
		//$add_dir_ad = new Direccion();
		$add_dir->per_id = $per_id;
		$add_dir->com_id = $request->comuna;
		$add_dir->dir_call = $request->calle;
		$add_dir->dir_num = $request->num;

		$add_dir->save();
		   
	}

 	public function eliminarDireccion(Request $request){
		
		$delete_dir = $request->id; 
		$dir = Direccion::find($delete_dir);
		$dir->delete();
		
	} 

	public function alertaTipo(){
		try{
			//$alertaTipos = $this->alertaTipo->listadoAlertasTipos();	
			$sql = "select at.ale_tip_id, at.ale_tip_nom, at.ale_tip_des
			  from ai_alerta_tipo at";

			$alertaTipos = DB::select($sql);
			if (count($alertaTipos) == 0){
				$mensaje = "No se encuentran tipos de Alertas Territoriales a desplegar.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
			

			return response()->json(array('estado' => '1', 'respuesta' => $alertaTipos), 200); 
		}catch(\Exception $e){
			Log::error('error: '.$e);

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}

	

		/*$alertaTipos = $this->alertaTipo->listadoAlertasTipos();
		dd("hola");
		dd($alertaTipos);

		$data	= new \stdClass();
		$data->data = $alertaTipos;

		echo json_encode($data); exit;*/

		
	}

	public function alertaTipoReg($id){

		$alertaTipos = $this->alertaTipo->AlertasTiposReg($id);

		$data	= new \stdClass();
		$data->data = $alertaTipos;

		echo json_encode($data); exit;

		// return view('alertas.registrar_alerta')->with(['categorias'=>$categorias,'alertaTipos'=>$alertaTipos ]);
		
	}

	public function misAlertas(){

		$misAlertas = $this->alertaManual->misAlertasManuales();

			foreach ($misAlertas as $value) {

			$nna = $this->predictivo->getByRutExterno($value->ale_man_run);
			
			return Datatables::of($misAlertas)
			->addColumn('rut_completo', function ($value) {

				if (!is_null($value->ale_man_run)){

					$nna = $this->predictivo->getByRutExterno($value->ale_man_run);

					$rut_completo = $value->ale_man_run."-".$nna->dv_run;
					//$rut_completo = Rut::parse($value->ale_man_run."-".$nna->dv_run)->format();

					return $rut_completo;
				}else{
					return '';
				}
			}, true)
			->rawColumns(['rut_completo'])
			->make(true);

		}

		$data	= new \stdClass();
		$data->data = $misAlertas;

		echo json_encode($data); exit;

	}
	

	public function ofertas($ids,$cod_com){

		$ofertaTipos = $this->alertaTipo->listadoOfertasTipos($ids,$cod_com);

		$data	= new \stdClass();
		$data->data = $ofertaTipos;

		echo json_encode($data); exit;

		// return view('alertas.registrar_alerta')->with(['categorias'=>$categorias,'alertaTipos'=>$alertaTipos ]);
		
	}

	public function enviararh(Request $request){
		try {
			//VALIDACION DE EXTENSIÃ“N DE ARCHIVO
			$validacion_extension = Validator::make($request->all(), ['archivo' => 'file|mimes:doc,docx,pdf']);
			if ($validacion_extension->fails()){
				$mensaje = "ExtensiÃ³n de archivo no permitida. Por favor subir un documento con las siguientes extensiones: doc, docx o pdf.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }

	        //VALIDACION DE TAMAÃ‘O DE ARCHIVO
	 		$validacion_size = Validator::make($request->all(), ['archivo' => 'file|max:5120']);
	 		if ($validacion_size->fails()){
				$mensaje = "Error al subir documento, tamaÃ±o mÃ¡ximo permitido 5 MB. Por favor verificar e intentar nuevamente.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }

			$cas_id = $request->cas_id;
			if (!$cas_id){
				$mensaje = "No se encuentra NÂ° del caso. Por favor verificar e intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::beginTransaction();

			$filename = "";
        	$doc_fec = Carbon::now();
        	$destinationPath = 'doc';
        	$files = $request->file('archivo');
			if($files != null){

        	$insert = new DocPaf();
        	$insert->cas_id 		= $cas_id;
        	$insert->doc_paf_arch 	= $filename;
        	$insert->doc_fec 		= $doc_fec;
        	$resultado 				= $insert->save();
        	if (!$resultado){
     			$mensaje = "Error al momento de guardar el documento en BD. Por favor intente nuevamente.";

     			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
     		}

     		$extension = $files->getClientOriginalExtension();

     		$id = $insert->doc_paf_id;
        	$filename = "doc_".$id.".".$extension;

        	$upload_success = $files->move($destinationPath, $filename);

     		$update = DocPaf::find($id);
     		$update->doc_paf_arch 	= $filename;
     		$resultado 				= $update->save();
     		if (!$resultado){
     			$mensaje = "Error al momento de guardar el documento en BD. Por favor intente nuevamente.";

     			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
     		}

			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'),200);
			}else{
				DB::rollback();
				$mensaje = "Error al momento de subir el documento solicitado. Por favor intente nuevamente.";
				if ($e->getMessage() != "") $mensaje = $e->getMessage();
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
		
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			//$mensaje = $filename;
			$mensaje = "Error al momento de subir el documento solicitado. Por favor intente nuevamente.";
			if ($e->getMessage() != "") $mensaje = $e->getMessage();
			
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}		
	}
	
	function validarIngresoTipoAlerta(request $request){
		try{
			$respuesta = true;
			$rut = substr($request->run,0,-2);
			$rut = str_replace ( "." , "", $rut);
			
			$casos = DB::table("ai_persona p")->select("*")
				->leftJoin("ai_caso c", "p.per_id", "=", "c.per_id")
				->leftJoin("ai_estado_caso ec", "c.est_cas_id", "=", "ec.est_cas_id")
				->where("p.per_run", "=", $rut)
				->where("ec.est_cas_fin", "=", 0)->get();
			
			$caso_id = "";
			$fecha_mayor_actual = "";
			if (count($casos) == 1){
				$caso_id = $casos[0]->cas_id;
				
			}else if (count($casos) > 1){
				foreach ($casos as $cv){
					if ($fecha_mayor_actual == "" || !isset($fecha_mayor_actual)){
						$caso_id = $cv->cas_id;
						$fecha_mayor_actual = $cv->cas_fec;
						
					}else if ($fecha_mayor_actual != "" && isset($fecha_mayor_actual)){
						if (strtotime($cv->cas_fec) > strtotime($fecha_mayor_actual)){
							$caso_id = $cv->cas_id;
							$fecha_mayor_actual = $cv->cas_fec;
						}
					}
				}
			}
			
			if ($caso_id != ""){
				$alerta_manual = CasoAlertaManual::where("cas_id", "=", $caso_id)->get();
				
				foreach ($alerta_manual AS $c0 => $v0){
					$validacion = 	AlertaManualTipo::where("ale_man_id", "=", $v0->ale_man_id)->get();
					
					foreach ($validacion AS $c1 => $v1){
						if ($v1->ale_tip_id == $request->id) $respuesta = false;
						
					}
				}
			}else if ($caso_id == ""){
				$alerta_manual = DB::select("SELECT * FROM ai_alerta_manual am LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
									WHERE am.ale_man_run = '".$rut."' AND ea.est_ale_fin = 0");
				
				foreach ($alerta_manual AS $v0){
					$validacion = 	AlertaManualTipo::where("ale_man_id", "=", $v0->ale_man_id)->get();
					
					foreach ($validacion AS $c1 => $v1){
						if ($v1->ale_tip_id == $request->id) $respuesta = false;
						
					}
				}
			
			}
			
			return response()->json(array('estado' => '1', 'respuesta' => $respuesta),200);
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de validar el ingreso del tipo de alerta. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	//ADJUNTAR DOCUMENTO CONSENTIMIENTO
	public function enviararhcons(Request $request){
		$request->validate($this->reglas_doc_consentimiento,[]);

		try {

			DB::beginTransaction();

			$cas_id=$request->cas_id;
        	$files = $request->file('doc_cons2');
			if($files != null){
        	$destinationPath = 'doc';
        	$extension = $files->getClientOriginalExtension();
            
        	$filename = "const_".$cas_id.".".$extension;
            $upload_success = $files->move($destinationPath, $filename);

            $caso = Caso::find($cas_id);
            $caso->cas_doc_cons = $filename;
            $caso->cas_doc_cons_fec = Carbon::createFromFormat('d/m/Y H:i:s', date('d/m/Y G:i:s'));
            $respuesta = $caso->save();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir el documento de Consentimiento. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

     		// $actualizaCaso = DB::update("UPDATE AI_CASO SET cas_doc_cons='".$filename."' where cas_id='".$cas_id."'");
			
			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'),200);
			}else{
				DB::rollback();
				Log::error('error: '.$e);

				//INICIO CZ SPRINT 66
				$mensaje = "Hubo un error al momento de subir el documento de Consentimiento. Por favor intente nuevamente.";
				// FIN CZ SPRINT 66
				
				return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
			}
        	
		
		} catch(\Exception $e) {

			DB::rollback();
			Log::error('error: '.$e);

			//INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de subir el documento de Consentimiento. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}		
	}

	public function asignarProgramaIntegrante(Request $request){
		try{
			$nombre_integrante = GrupoFamiliar::find($request->id_familiar);
			$nombre_integrante = $nombre_integrante->gru_fam_nom." ".$nombre_integrante->gru_fam_ape_pat." ".$nombre_integrante->gru_fam_ape_mat;

			$cas_id = CasoGrupoFamiliar::where("gru_fam_id","=",$request->id_familiar)->get();
			$cas_id = $cas_id[0]->cas_id;

			$comuna_id = DB::select("SELECT * FROM ai_caso_comuna WHERE cas_id = ".$cas_id);
			$comuna_id = $comuna_id[0]->com_id;

			$data = array();
			$id_tipo_alerta = AlertaManualTipo::where("ale_man_id", "=", $request->id_alerta)->get();
			$id_tipo_alerta = $id_tipo_alerta[0]->ale_tip_id;

			//$programas_por_alerta = DB::select("SELECT * FROM ai_programa_alerta_tipo pat LEFT JOIN ai_programa p ON pat.prog_id = p.prog_id LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id WHERE pat.ale_tip_id = ".$id_tipo_alerta." AND pc.com_id = ".$comuna_id);

			$programas_por_alerta = DB::select("SELECT DISTINCT(p.prog_id), pat.*, pc.*, p.prog_id, p.pro_nom FROM ai_programa_alerta_tipo pat LEFT JOIN ai_programa p ON pat.prog_id = p.prog_id LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id WHERE pat.ale_tip_id = ".$id_tipo_alerta." AND pc.com_id = ".$comuna_id." AND pc.pro_com_est=1");

			if (count($programas_por_alerta) > 0){
				foreach ($programas_por_alerta AS $c1 => $v1){
					$programa = Programa::where("prog_id", "=", $v1->prog_id)->get();
				
					if (count($programa) > 0){
						foreach ($programa AS $c2 => $v2){
							$data[$c1] = new \stdClass; 
							$data[$c1]->prog_id 	= $v2->prog_id; 

							// buscar si el programa existe en la tabla ai_brecha con estatus abierto!!
							$brecha = Brecha::where('id_programa', $v2->prog_id)->where('estado', config('constantes.brecha_abierta'))->first();

							$brecha_integrante = 0;

							if ($brecha){

								$brecha_integrante = BrechaIntegrante::where('id_brecha',$brecha->id_brecha)
								->where('id_caso', $cas_id)
								->where('id_integrante', $request->id_familiar)
								->where('estado', config('constantes.brecha_abierta'))->first();

							}

							$data[$c1]->brecha 	= ($brecha_integrante)? $brecha_integrante->id_brecha_inte_caso : 0;
							$data[$c1]->observacion_brecha 	= ($brecha_integrante)? $brecha_integrante->comentario : '';

							// se busca la informaciÃ³n del sectorialista encargado del programa
							$sectorialista = DB::select("SELECT 
							'Sectorialista: '||decode(aiu.nombres,null,'Sin InformaciÃ³n',aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno)||', Email: '||decode(aiu.email,null,'Sin InformaciÃ³n',aiu.email)||', TelÃ©fono: '||decode(aiu.telefono,null,'Sin InformaciÃ³n',aiu.telefono) as contacto 
							FROM 
							ai_programa p 
							left join ai_usuario aiu on aiu.id = p.pro_usu_resp	
							WHERE  p.prog_id = ".$v2->prog_id);

							$sectorialista = collect($sectorialista);

							$data[$c1]->contacto 	= $sectorialista[0]->contacto;


							$data[$c1]->pro_nom 	= $v2->pro_nom; 
							$data[$c1]->id_ale 		= $request->id_alerta; 
							$data[$c1]->id_tip_ale 	= $id_tipo_alerta; 
							$data[$c1]->id_fam 		= $request->id_familiar; 

							$data[$c1]->asignar 	= ""; 
							$data[$c1]->am_prog_id 	= ""; 

							$asignado = DB::select("SELECT * FROM ai_am_programas WHERE prog_id = ".$v2->prog_id." AND ale_man_id = ".$request->id_alerta." AND gru_fam_id = ".$request->id_familiar." AND ale_tip_id = ".$id_tipo_alerta);

							if (count($asignado) > 0){
								$data[$c1]->asignar 	= "checked";
								$data[$c1]->am_prog_id 	= $asignado[0]->am_prog_id;

							} 

							$data[$c1]->establecimiento = array();
							$establecimiento = DB::select("SELECT * FROM ai_establecimientos e LEFT JOIN ai_establecimiento_comuna ec ON e.estab_id = ec.estab_id WHERE prog_id = ".$v2->prog_id." AND ec.com_id IN (".Session::all()['com_id'].")");

							if (count($establecimiento) > 0){
								foreach ($establecimiento AS $c3 => $v3){
									$data[$c1]->establecimiento[$c3] = new \stdClass;
									$data[$c1]->establecimiento[$c3]->estab_id 	= $v3->estab_id;
									$data[$c1]->establecimiento[$c3]->estab_nom = $v3->estab_nom;
									
									$data[$c1]->establecimiento[$c3]->asignar 	= "";
									
									// se buscan los datos del sectorialista responsable del establecimiento
									$id_usuario = $v3->estab_usu_resp;
									$sectorialista_establecimiento = Usuarios::find($id_usuario);
									$datos_sectorialista = 'Sectorialista: '.$sectorialista_establecimiento->nombres.' '.$sectorialista_establecimiento->apellido_paterno.' '.$sectorialista_establecimiento->apellido_materno.', Email: '.$sectorialista_establecimiento->email.', TelÃ©fono: '.$sectorialista_establecimiento->telefono;

									$data[$c1]->establecimiento[$c3]->contacto_establecimiento 	= $datos_sectorialista;

									$estab_asig = DB::select("SELECT * FROM ai_am_programas WHERE prog_id = ".$v2->prog_id." AND ale_man_id = ".$request->id_alerta." AND gru_fam_id = ".$request->id_familiar." AND ale_tip_id = ".$id_tipo_alerta." AND estab_id = ".$v3->estab_id);

									if (count($estab_asig) > 0){
										$data[$c1]->asignar 						= "checked";
										$data[$c1]->establecimiento[$c3]->asignar 	= "checked";
									} 
								}
							}
						}
					}
				}
			}
			
			return response()->json(array('estado' => '1', 'respuesta' => $data, 'integrante' => $nombre_integrante), 200);
		}catch(\Exception $e){
			$mensaje = "Error: ".$e;
			Log::error($mensaje);
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);

		}
	}

	public function guardarAsignacionPrograma(Request $request){
		try{
			if (!isset($request->cas_id) || $request->cas_id == "" || is_null($request->cas_id)){
				$mensaje = "No se encuentra el ID del caso. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'mensaje' => $mensaje), 200);
			}

			$caso = Caso::where("cas_id", "=", $request->cas_id)->first();
			if (count($caso) == 0){
				$mensaje = "No se encuentra informaciÃ³n del caso. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'mensaje' => $mensaje), 200);
			}

			DB::beginTransaction();

			$estado_programa = config('constantes.sin_gestionar');
			if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')){
				$estado_programa = config('constantes.pendiente');

			}

			$guardar 				= new AmProgramas();
			$guardar->prog_id 		= $request->prog_id;
			$guardar->ale_man_id 	= $request->id_ale;
			$guardar->gru_fam_id 	= $request->id_gru_fam;
			$guardar->est_prog_id 	= $estado_programa;
			$guardar->estab_id 		= $request->estab_id;
			$guardar->ale_tip_id 	= $request->id_tip_ale;
			$resultado 				= $guardar->save();
			if (!$resultado) throw $resultado;

			//Cambio de Estado de Alerta Territorial
			if($caso->est_cas_id > config('constantes.en_elaboracion_paf')){
				$ale_man = AlertaManual::find($request->id_ale);
				$ale_man->est_ale_id = 3; //En Espera de AtenciÃ³n
				$resultado = $ale_man->save();
				if (!$resultado) throw $resultado;

				$eame = new EstadoAlertaManualEstado;
				$eame->est_ale_id = 3;
				$eame->ale_man_id = $request->id_ale;
				$eame->ale_just_est = "Alerta Territorial en espera de atenciÃ³n.";
				$resultado = $eame->save();
				if (!$resultado) throw $resultado;
			}

			$estado_programa = config('constantes.sin_gestionar');
			$comentario = "Se asigna programa.";
			$guardar_estado = new EstadoProgramasBit();
			$guardar_estado->am_prog_id 		= $guardar->am_prog_id;
			$guardar_estado->est_prog_id 		= $estado_programa;
			$guardar_estado->est_prog_bit_des 	= $comentario;
			$resultado = $guardar_estado->save();
			if (!$resultado) throw $resultado;

			if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')){
				$estado_programa = config('constantes.pendiente');
				$comentario = "Se realiza derivaciÃ³n a sectorialista.";

				$guardar_estado = new EstadoProgramasBit();
				$guardar_estado->am_prog_id 		= $guardar->am_prog_id;
				$guardar_estado->est_prog_id 		= $estado_programa;
				$guardar_estado->est_prog_bit_des 	= $comentario;
				$resultado = $guardar_estado->save();
				if (!$resultado) throw $resultado;

			}

			$mensaje = "Programa asignado con Ã©xito.";

			DB::commit();
			return response()->json(array('estado' => '1', 'respuesta' => $guardar->am_prog_id, 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();

			$mensaje = "Error: ".$e;
			Log::error($mensaje);
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function desestimarAsignacionPrograma(Request $request){
		try{
			DB::beginTransaction();

			/*$actualizar 				= AmProgramas::find($request->id_am_prog);
			$actualizar->est_prog_id 	= config('constantes.no_corresponde');
			$resultado 					= $actualizar->save();
			if (!$resultado) throw $resultado;*/

			$actualizar_estado = EstadoProgramasBit::find($request->id_am_prog);
			$resultado  = $actualizar_estado->delete();
			if (!$resultado) throw $resultado;

			$actualizar = AmProgramas::find($request->id_am_prog);
			$resultado  = $actualizar->delete();
			if (!$resultado) throw $resultado;

			/*$actualizar_estado 						= new EstadoProgramasBit();
			$actualizar_estado->am_prog_id 			= $request->id_am_prog;
			$actualizar_estado->est_prog_id 		= config('constantes.no_corresponde');
			$actualizar_estado->est_prog_bit_des 	= "Se desestima programa.";
			$resultado 								= $actualizar_estado->save();
			if (!$resultado) throw $resultado;*/


			$mensaje = "AsignaciÃ³n desestimada con Ã©xito.";
			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			//dd($e);
			$mensaje = "Error: ".$e;
			Log::error($mensaje);
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);

		}
	}


	public function validarNnaAlerta(Request $request){
	    
	    DB::beginTransaction();
	    $estado = $request->ale_estado;
	    $idAlerta = $request->ale_id;
	    $nomEstado = $request->nom_estado;
	    $respuesta = $this->alertaManual->ActualizarEstadoAlerta($idAlerta, $estado);
	    if($respuesta == 1){
	        $this->alertaManual->HistorialEstadoAlerta($idAlerta, $estado, $nomEstado);	       
	    }
	    DB::commit();
	    echo $respuesta;
	}

	public function enviarencsati(Request $request){
		$request->validate($this->reglas_doc_encuestasatisfaccion,[]);

		try {
			DB::beginTransaction();

			$cas_id=$request->cas_id;
        	$files = $request->file('enc_sati');
			if($files != null){
        	$destinationPath = 'doc';
        	$extension = $files->getClientOriginalExtension();
            
        	$filename = "encsati_".$cas_id.".".$extension;
            $upload_success = $files->move($destinationPath, $filename);


            $caso 						= Caso::find($cas_id);
            $caso->cas_enc_sati 		= $filename;
            $caso->cas_enc_sati_fec 	= Carbon::createFromFormat('d/m/Y H:i:s', date('d/m/Y G:i:s'));
            
            $respuesta = $caso->save();
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir la Encuesta de SatisfacciÃ³n. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

			
			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'),200);
			}else{
				
				//dd($e);

				DB::rollback();
				Log::error('error: '.$e);
				$mensaje = "Hubo un error al momento de subir la Encuesta de satisfacción. Por favor intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $e), 400);	
			}

		
		} catch(\Exception $e) {

			//dd($e);

			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de subir la Encuesta de satisfacción. Por favor intente nuevamente.";
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}		
	}

	public static function listarAlertasSinNomina(Request $request){


		$start_date = (!empty($request->start_date)) ? ($request->start_date) : ('');
        $end_date   = (!empty($request->end_date)) ? ($request->end_date) : ('');
        $nomina     = (!empty($request->nomina)) ? ($request->nomina) : ('');
        $sin_caso   = (!empty($request->sin_caso)) ? ($request->sin_caso) : ('');
        $estado_alerta  = (!empty($request->estado_alerta)) ? ($request->estado_alerta) : ('');

		$sql	= "	SELECT 
						am.ale_man_run, 
						am.ale_man_nna_nombre, 
						am.ale_tip_nom, 
						am.est_ale_id, 
						am.est_ale_nom, 
						am.usuario, 
						am.ale_man_fec, 
						c.cas_id, 
						ec.est_cas_nom, 
						p.run,am.ale_man_id,
						CASE WHEN et.est_tera_nom IS NULL THEN 'SIN TERAPIA' ELSE et.est_tera_nom END AS est_tera_nom
					FROM VW_AI_ALERTA_MANUAL am
	            		LEFT JOIN ai_caso_alerta_manual ca 	ON ca.ale_man_id 	= am.ale_man_id
	        			LEFT JOIN ai_caso c 				ON c.cas_id 		= ca.cas_id
	        			LEFT JOIN ai_estado_caso ec 		ON ec.est_cas_id 	= c.est_cas_id 
	        			LEFT JOIN ai_predictivo p 			ON p.run 			= am.ale_man_run
	        			LEFT JOIN ai_terapia t 				ON t.cas_id 		= c.cas_id
    					LEFT JOIN ai_estado_terapia et 		ON et.est_tera_id 	= t.est_tera_id
        			WHERE 
        				am.com_id =" . Session::get('com_id');

         if(!empty($estado_alerta)){

         	$sql.=" and am.est_ale_id =  " . $estado_alerta."";
        }

        if($nomina == 'Si'){        	
        	$sql.=" and p.run IS NOT NULL";
        }elseif($nomina == 'No'){
        	$sql.=" and p.run IS NULL";
        } 

        if($sin_caso == 'Si'){        	
        	$sql.=" and c.cas_id IS NULL";
        }elseif($sin_caso == 'No'){
        	$sql.=" and c.cas_id IS NOT NULL";
        }



        if($start_date && $end_date){


        	$start_date = Carbon::createFromFormat( 'd/m/Y', $start_date)->startOfDay();
        	$end_date = Carbon::createFromFormat( 'd/m/Y', $end_date)->endOfDay();

            // $sql.=" and am.ale_man_fec >= '" . $start_date . "' AND am.ale_man_fec <= '" . $end_date . "'";

            $sql.=" and am.ale_man_fec between '" . $start_date . "' and '" . $end_date . "'";


        }

		$listadoAlertasManualesSinNomina = DB::select($sql);

		foreach ($listadoAlertasManualesSinNomina AS $c1 => $v1){
				$dv = Rut::set($v1->ale_man_run)->calculateVerificationNumber(); 
				$rut = Rut::parse($v1->ale_man_run.$dv)->format();
				$listadoAlertasManualesSinNomina[$c1]->rut_completo = $rut;

			}
		
		return Datatables::of($listadoAlertasManualesSinNomina)
			->make(true);



	}

	public function indexAlertasSinNomina(){

		try {

			$icono = Funcion::iconos(32);

			$estado_alerta = DB::select("SELECT est_ale_id, est_ale_nom FROM ai_estado_alerta");
			
			return view('alertas.mainAlertasSinNomina',['icono'=>$icono],['estado_alerta'=>$estado_alerta]);

		} catch(\Exception $e) {
			
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}

	public static function ExcelAlertasSinNomina(Request $request){


		$start_date = (!empty($request->start_date)) ? ($request->start_date) : ('');
        $end_date   = (!empty($request->end_date)) ? ($request->end_date) : ('');
        $nomina     = (!empty($request->nomina)) ? ($request->nomina) : ('');
        $sin_caso   = (!empty($request->sin_caso)) ? ($request->sin_caso) : ('');
        $estado_alerta  = (!empty($request->estado_alerta)) ? ($request->estado_alerta) : ('');



		$sql= "select 
			am.ale_man_run, am.ale_tip_nom, am.est_ale_id, am.est_ale_nom, am.usuario, am.ale_man_fec, c.cas_id, ec.est_cas_nom, p.run,am.ale_man_id
            
		from 
			VW_AI_ALERTA_MANUAL am
            
        LEFT JOIN ai_caso_alerta_manual ca ON ca.ale_man_id = am.ale_man_id
        LEFT JOIN ai_caso c ON c.cas_id = ca.cas_id
        LEFT JOIN ai_estado_caso ec ON ec.est_cas_id = c.est_cas_id 
        LEFT JOIN ai_predictivo p ON p.run = am.ale_man_run

        WHERE am.com_id =" . Session::get('com_id');

         if(!empty($estado_alerta)){

         	$sql.=" and am.est_ale_id =  " . $estado_alerta."";
        }

        if($nomina == 'Si'){        	
        	$sql.=" and p.run IS NOT NULL";
        }elseif($nomina == 'No'){
        	$sql.=" and p.run IS NULL";
        } 

        if($sin_caso == 'Si'){        	
        	$sql.=" and c.cas_id IS NULL";
        }elseif($sin_caso == 'No'){
        	$sql.=" and c.cas_id IS NOT NULL";
        }



        if($start_date && $end_date){


        	$start_date = Carbon::createFromFormat( 'd/m/Y', $start_date)->startOfDay();
        	$end_date = Carbon::createFromFormat( 'd/m/Y', $end_date)->endOfDay();

            // $sql.=" and am.ale_man_fec >= '" . $start_date . "' AND am.ale_man_fec <= '" . $end_date . "'";

            $sql.=" and am.ale_man_fec between '" . $start_date . "' and '" . $end_date . "'";


        }

		$listadoAlertasManualesSinNomina = DB::select($sql);

			foreach ($listadoAlertasManualesSinNomina AS $c1 => $v1){
				$dv = Rut::set($v1->ale_man_run)->calculateVerificationNumber(); 
				$rut = Rut::parse($v1->ale_man_run.$dv)->format();
				$listadoAlertasManualesSinNomina[$c1]->rut_completo = $rut;

			}
		
		return $listadoAlertasManualesSinNomina;



	}

	function eliminar_tildes($cadena){

	
		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('ÃƒÂ¡', 'ÃƒÂ ', 'ÃƒÂ¤', 'ÃƒÂ¢', 'Ã‚Âª', 'Ãƒï¿½', 'Ãƒâ‚¬', 'Ãƒâ€š', 'Ãƒâ€ž'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);
	
		$cadena = str_replace(
			array('ÃƒÂ©', 'ÃƒÂ¨', 'ÃƒÂ«', 'ÃƒÂª', 'Ãƒâ€°', 'ÃƒË†', 'ÃƒÅ ', 'Ãƒâ€¹'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );
	
		$cadena = str_replace(
			array('ÃƒÂ­', 'ÃƒÂ¬', 'ÃƒÂ¯', 'ÃƒÂ®', 'Ãƒï¿½', 'ÃƒÅ’', 'Ãƒï¿½', 'ÃƒÅ½'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );
	
		$cadena = str_replace(
			array('ÃƒÂ³', 'ÃƒÂ²', 'ÃƒÂ¶', 'ÃƒÂ´', 'Ãƒâ€œ', 'Ãƒâ€™', 'Ãƒâ€“', 'Ãƒâ€�'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );
	
		$cadena = str_replace(
			array('ÃƒÂº', 'ÃƒÂ¹', 'ÃƒÂ¼', 'ÃƒÂ»', 'ÃƒÅ¡', 'Ãƒâ„¢', 'Ãƒâ€º', 'ÃƒÅ“'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );
	
		$cadena = str_replace(
			array('ÃƒÂ±', 'Ãƒâ€˜', 'ÃƒÂ§', 'Ãƒâ€¡'),
			array('n', 'N', 'c', 'C'),
			$cadena
		);
	
		return $cadena;
	}

	public function generarCodigoCompuesto( $nna_nom, $nna_fec, $nom_mad, $ape_mad, $nom_pad, $ape_pad){
		
		$nna_nom = $this->eliminar_tildes($nna_nom);
		$nom_mad = $this->eliminar_tildes($nom_mad);
		$ape_mad = $this->eliminar_tildes($ape_mad);
		$nom_pad = $this->eliminar_tildes($nom_pad);
		$ape_pad = $this->eliminar_tildes($ape_pad);
		
			$nombres = explode(" ",$nna_nom);
			
			if(count($nombres) == 2){
				$nna_nom = substr($nombres[0],0,2);
				$nna_ape = substr($nombres[1],0,2);
			}else if(count($nombres) == 3){
				$nna_nom = substr($nombres[0],0,2);
				$nna_ape = substr($nombres[1],0,2);
			}else if(count($nombres) == 1){
			    $nna_nom = substr($nombres[0],0,2);
			    $nna_ape = '';
			}else{
			    
				$nna_nom = substr($nombres[0],0,2);
				$nna_ape = substr($nombres[2],0,2);
			}			
			
			$nna_fec = Carbon::createFromFormat('d/m/Y', $nna_fec)->format('Ymd');

			if($nom_mad != ""){
				$nom_mad = substr($nom_mad,0,2);
				$ape_mad = substr($ape_mad,0,2);
				$nom_pad = "";
				$ape_pad = "";
			}else{
				$nom_mad = "";
				$ape_mad = "";
				$nom_pad = substr($nom_pad,0,2);
				$ape_pad = substr($ape_pad,0,2);
			}

			$codigo = strtoupper($nna_nom.$nna_ape.$nna_fec.$nom_mad.$ape_mad.$nom_pad.$ape_pad);
			
			return $codigo;

	}

	public function consultaNNAsinRun(Request $request){
		try{

		
			$codigo = $this->generarCodigoCompuesto($request->nna_nom, $request->nna_fec, $request->nom_mad, $request->ape_mad, $request->nom_pad, $request->ape_pad);
			
			$respuesta = AlertaManual::select('ale_man_run')->where("ale_man_cod_nna_srn","like","%".$codigo."%")->groupBy("ale_man_run")->get();
			//DD(count($respuesta));
			if(count($respuesta)== 0){
				return response()->json(array('estado' => "0", 'codigo' => $codigo), 200);
			}else{
				return response()->json(array('estado' => "1", 'codigo' => $codigo), 200);
			};
			
			
		}catch(\Exception $e){

            return response()->json($e->getMessage(), 400);
        }

	}

	public function listarNNAsinRun(Request $request){
		try{
			$respuesta = AlertaManual::select('ale_man_run','ale_man_nna_nombre','ale_man_nna_fec_nac','ale_man_nna_edad','ale_man_nna_sexo')->where("ale_man_cod_nna_srn","like","%".$request->codigo."%")->groupBy("ale_man_run",'ale_man_nna_nombre','ale_man_nna_fec_nac','ale_man_nna_edad','ale_man_nna_sexo')->get();
						
			if(count($respuesta)>0){
				foreach($respuesta as $nna){
					$resp = NNASinRun::where("nna_run", $nna->ale_man_run)->first();
					$nna->dat_mat = $resp->nom_mat." ".$resp->ape_mat;
					$nna->dat_pat = $resp->nom_pat." ".$resp->ape_pat;
				}
			}
			
			$data	= new \stdClass();
			$data->data = $respuesta;
			echo json_encode($data); exit;

		}catch(\Exception $e){

            return response()->json($e->getMessage(), 400);
        }

		
	}

	public static function generarTokenSeguridad(){
		
		// Create token header as a JSON string
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

        // Create token payload as a JSON string
        $payload = json_encode(['iss' => config('constantes.key_ws_val'),'exp' => time() + config('constantes.tk_ws_exp')]);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, config('constantes.pass_ws_val'), true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
		$token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
				

		return response()->json(array('token' => $token), 200);
		
	}


	public static function getTokenRegDir(){
		
		// Create token header as a JSON string
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

        // Create token payload as a JSON string
        $payload = json_encode(['iss' => config('constantes.key_ws_reg_dir'),'exp' => time() + config('constantes.tk_ws_reg_dir_exp')]);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, config('constantes.pass_ws_reg_dir'), true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $token;	
		
	}


		/**
	 * Consulta estado GrabaciÃƒÂ³n
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function valida_reg_grabado(Request $request){
		try {
			if (!isset($request->ID_transaccion) || $request->ID_transaccion == ""){
				$mensaje = "No se encuentra el ID de la direcciÃƒÂ³n. Por favor verifique e intente nuevamente.";


				return response()->json($mensaje, 400);
			}

			$token = AlertaController::getTokenRegDir();

			$client = new Client();

		 	$respuesta = $client->get(config("constantes.url_verificacion_direccion").$request->ID_transaccion.'/1', [
		 	' connect_timeout ' => 1,
            'headers' => [
        					'Accept' => 'application/json',
        					'Authorization' => 'Bearer ' . $token,
    					 ]
        	]);
				
	        if ($respuesta->getStatusCode() != 200){
	        	$mensaje = "Hubo un error al momento validar el grabado de la direcciÃƒÂ³n. Por favor verifique e intente nuevamente.";


				return response()->json($mensaje, 400);
	    	}
	        
	        $response = $respuesta->getBody()->getContents();
		
	        $respuesta = json_decode($response, true);
			
			return $respuesta;

		} catch (\Exception $e) {
			

			if($e->getCode()==500){

				$mensaje = "Error en el servidor";

			}else if($e->getCode()==404){

				$mensaje = "El servicio no se encuentra";

			} else {

				$mensaje = "Error inesperado";

			}
			// INICIO CZ SPRINT 66
				$mensaje = "Hubo un error al momento validar el grabado de la direcciÃƒÂ³n. Por favor verifique e intente nuevamente.";			
			// INICIO CZ SPRINT 66

			$res = array('status' => 2, 'msg' => $mensaje, 'error_code' => $e->getCode());
		 	return $res;
		}
		
	}


	public function cambioVigenciaDireccion($id_dir, $run){
		try {
			if (!isset($id_dir) || $id_dir == ""){
				$mensaje = "No se encuentra el ID de la direcciÃƒÂ³n. Por favor verifique e intente nuevamente.";

				return array("status" => 0, "mensaje" => $mensaje);
			}

			if (!isset($run) || $run == ""){
				$mensaje = "No se encuentra RUN. Por favor verifique e intente nuevamente.";


				return array("status" => 0, "mensaje" => $mensaje);
			}

			$token = AlertaController::getTokenRegDir();

			$client = new Client();

			$url = config("constantes.url_actualizacion_estado_direccion").$id_dir."/".$run."/".config("constantes.ID_sistema_fuente")."/".config("constantes.ID_negocio_vigencia");

		 	$respuesta = $client->get( $url, [
		 		'connect_timeout' => 1,
            	'headers' => [
        					'Accept' => 'application/json',
        					'Authorization' => 'Bearer ' . $token,
    					 ]
        	]);

	        if ($respuesta->getStatusCode() != 200){
	        	$mensaje = "Hubo un error al momento validar el grabado de la direcciÃƒÂ³n. Por favor verifique e intente nuevamente.";


				return array("status" => 0, "mensaje" => $mensaje);
	    	}
	        
	        $response = $respuesta->getBody()->getContents();
		
	        $respuesta = json_decode($response, true);
			
			return $respuesta;

		} catch (\Exception $e) {

			if($e->getCode()==500){

				$mensaje = "Error en el servidor";

			}else if($e->getCode()==404){

				$mensaje = "El servicio no se encuentra";

			} else {

				$mensaje = "Error inesperado";

			}

			return array("status" => 2, "mensaje" => $mensaje, "error_code" => $e->getCode());
		}
		
	}

	public function validarGestorRun($run, $formato){
		if($formato){
			$rut = Rut::parse($run)->number();
		
		}else{
			if(!config('constantes.activar_maestro_direcciones')){
				$run_sin_formato = Rut::parse($run)->format(Rut::FORMAT_WITH_DASH);
				$sep = explode("-", $run_sin_formato);

				$rut = $sep[0];
			}else{
				$rut = $run;
			}
		}

		$predictivo = Predictivo::find($rut);

		if(count($predictivo)>0){
			return true;
		
		}else{

			$grupo_fam = GrupoFamiliar::where('gru_fam_run', $rut)->first();
			
			if(count($grupo_fam) > 0){
				$caso = CasoGrupoFamiliar::where('gru_fam_id', $grupo_fam->gru_fam_id)->first();
				$result = PersonaUsuario::where('cas_id',$caso->cas_id)->where('usu_id',session()->all()["id_usuario"])->first();
				
				if(count($result) > 0){
					return true;
				}else{
					return false;
				}
	
			}else{
				return false;
			}
		}
		
	}

	public function permisoAgregarAT(Request $request){

		$respuesta = $this->validarGestorRun($request->run, true);
		if($respuesta){
			return response()->json(array('estado' => '1'), 200);
		}else{
			return response()->json(array('estado' => '0'), 200);
		}
	}

	public function listarAlertasporTipo(Request $request){
		
		if (!isset($request->cas_id) || $request->cas_id == ""){
			$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente.";

			return array("status" => 0, "mensaje" => $mensaje);
		}
		$data	= new \stdClass();
		$cas_id = $request->cas_id;
		$ale_tip_id = $request->ale_tip_id;
		
		$respuesta = $this->alertaManual->listarAlertasporTipo($cas_id,$ale_tip_id);
			if (count($respuesta) > 0){
				foreach($respuesta AS $alerta){
					$dimensiones = AmDimension::select("ade.dim_enc_nom")->leftJoin("ai_dimension_encuesta ade","ade.dim_enc_id","=","ai_am_dimension.dim_enc_id")
											->where("cas_id",$cas_id)->where("ale_man_id",$alerta->ale_man_id)->get();
					if(count($dimensiones) > 0){
						$primer = true;
						$alerta->dimension = "";
						foreach($dimensiones AS $dimension){
							if(!$primer) $alerta->dimension .= " - ";
							$alerta->dimension .= $dimension->dim_enc_nom; 
							$primer = false;
						}
					}else{
						$alerta->dimension = "Sin Vincular"; 
					}
				}
				
				$data->data = $respuesta;
			}		
			
		echo json_encode($data); exit;
	}

	public function desestimarAlertasporTipo(Request $request){
		try{

			DB::beginTransaction();
			
			if (!isset($request->cas_id) || $request->cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente.";
	
				return array("status" => 0, "mensaje" => $mensaje);
			}
			$data	= new \stdClass();
			$cas_id = $request->cas_id;
			$ale_tip_id = $request->ale_tip_id;
			$alertas = $this->alertaManual->listarAlertasporTipo($cas_id,$ale_tip_id);
			
			foreach($alertas as $alerta){
				$ale_man = AlertaManual::find($alerta->ale_man_id);
				$ale_man->est_ale_id = 7; //No Resuelta
				$resultado = $ale_man->save();
				
				if (!$resultado){
					DB::rollback();
					$mensaje = "Hubo un error al momento de realizar la acciÃƒÂ³n solicitada. Por favor intente nuevamente.";
	
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				$eame = new EstadoAlertaManualEstado;
				$eame->est_ale_id = 7;
				$eame->ale_man_id = $alerta->ale_man_id;
				$eame->ale_just_est = "Se desestima la Alerta Territorial.";
				$resultado = $eame->save();
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Hubo un error al momento de realizar la acciÃƒÂ³n solicitada.. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
			}

			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Alerta(s) Desestimada(s)'), 200);

		}catch(\Exception $e){

			DB::rollback();

			return response()->json(array('estado' => '0', 'mensaje' => 'Error al desestimar: '.$e), 400);

		}		

	}

	public function listarProgramaIntegrante(Request $request){
		try{
			$nombre_integrante = GrupoFamiliar::find($request->id_familiar);
			$nombre_integrante = $nombre_integrante->gru_fam_nom." ".$nombre_integrante->gru_fam_ape_pat." ".$nombre_integrante->gru_fam_ape_mat;

			$cas_id = CasoGrupoFamiliar::where("gru_fam_id","=",$request->id_familiar)->get();
			$cas_id = $cas_id[0]->cas_id;

			$comuna_id = DB::select("SELECT * FROM ai_caso_comuna WHERE cas_id = ".$cas_id);
			$comuna_id = $comuna_id[0]->com_id;

			$data = array();
			$id_tipo_alerta = AlertaManualTipo::where("ale_man_id", "=", $request->id_alerta)->get();
			$id_tipo_alerta = $id_tipo_alerta[0]->ale_tip_id;

			$programas_por_alerta = DB::select("SELECT DISTINCT(p.prog_id), pat.*, pc.*, p.prog_id, p.pro_nom, e.estab_id, e.estab_nom, e.estab_usu_resp FROM ai_programa_alerta_tipo pat LEFT JOIN ai_programa p ON pat.prog_id = p.prog_id LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id LEFT JOIN ai_establecimientos e ON pat.prog_id = e.prog_id LEFT JOIN ai_establecimiento_comuna ec ON e.estab_id = ec.estab_id WHERE pat.ale_tip_id = ".$id_tipo_alerta." AND pc.com_id = ".$comuna_id." AND pc.pro_com_est = 1 AND e.estab_id IS NOT NULL AND estab_usu_resp IS NOT NULL AND ec.com_id = ".$comuna_id);

			if (count($programas_por_alerta) > 0){
				foreach ($programas_por_alerta AS $c1 => $v1){
					$data[$c1] = new \stdClass; 
					$data[$c1]->integrante = $nombre_integrante;
					$data[$c1]->prog_id 	= $v1->prog_id; 

					$brecha_integrante = 0;
					$brecha = Brecha::where('id_programa', $v1->prog_id)->where('estado', config('constantes.brecha_abierta'))->first();

					if ($brecha){
						$brecha_integrante = BrechaIntegrante::where('id_brecha',$brecha->id_brecha)
						->where('id_caso', $cas_id)
						->where('id_integrante', $request->id_familiar)
						->where('estado', config('constantes.brecha_abierta'))->first();

					}

					// dd($brecha);

					$data[$c1]->brecha 	= ($brecha_integrante)? $brecha_integrante->id_brecha_inte_caso : 0;
					$data[$c1]->observacion_brecha 	= ($brecha_integrante)? $brecha_integrante->comentario : '';

					$sectorialista = DB::select("SELECT 'Sectorialista: '||decode(aiu.nombres,null,'Sin InformaciÃƒÂ³n',aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno)||', Email: '||decode(aiu.email,null,'Sin InformaciÃƒÂ³n',aiu.email)||', TelÃƒÂ©fono: '||decode(aiu.telefono,null,'Sin InformaciÃƒÂ³n',aiu.telefono) as contacto FROM ai_programa p left join ai_usuario aiu on aiu.id = p.pro_usu_resp WHERE  p.prog_id = ".$v1->prog_id);

					$sectorialista = collect($sectorialista);

					$data[$c1]->contacto 	= $sectorialista[0]->contacto;
					$data[$c1]->pro_nom 	= $v1->pro_nom; 
					$data[$c1]->id_ale 		= $request->id_alerta; 
					$data[$c1]->id_tip_ale 	= $id_tipo_alerta; 
					$data[$c1]->id_fam 		= $request->id_familiar; 

					$data[$c1]->estab_id 	= $v1->estab_id;
					$data[$c1]->estab_nom 	= $v1->estab_nom;				
					
					$sectorialista_establecimiento = Usuarios::find($v1->estab_usu_resp);
					$datos_sectorialista = 'Sectorialista: '.$sectorialista_establecimiento->nombres.' '.$sectorialista_establecimiento->apellido_paterno.' '.$sectorialista_establecimiento->apellido_materno.', Email: '.$sectorialista_establecimiento->email.', TelÃƒÂ©fono: '.$sectorialista_establecimiento->telefono;

					$data[$c1]->contacto_establecimiento 	= $datos_sectorialista;

					$estab_asig = DB::select("SELECT * FROM ai_am_programas WHERE prog_id = ".$v1->prog_id." AND ale_man_id = ".$request->id_alerta." AND gru_fam_id = ".$request->id_familiar." AND ale_tip_id = ".$id_tipo_alerta." AND estab_id = ".$v1->estab_id);

					$data[$c1]->asignar 	= ""; 
					$data[$c1]->am_prog_id 	= ""; 

					if (count($estab_asig) > 0){
						$data[$c1]->asignar 	= "checked";
						$data[$c1]->am_prog_id 	= $estab_asig[0]->am_prog_id;
					} 
				}
			}
			
			$datas	= new \stdClass();
			$datas->data = $data;

			echo json_encode($datas); exit;

		}catch(\Exception $e){
			$mensaje = "Caso Controller / listarProgramaIntegrante: ".$e;
			Log::error($mensaje);
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}	
}
