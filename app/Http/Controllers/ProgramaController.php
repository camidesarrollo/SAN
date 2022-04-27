<?php
namespace App\Http\Controllers;
use App\Modelos\Dimension;
use App\Modelos\Programa;
use App\Modelos\Ofertas;
use App\Modelos\ProgramaComuna;
use App\Modelos\AlertaTipo;
use App\Modelos\OfertaComuna;
use App\Modelos\ProgramaAlerta;
use App\Modelos\Establecimientos;
use App\Modelos\Usuarios;
use App\Modelos\Comuna;
use App\Modelos\Funcion;
use App\Modelos\Caso;
use App\Modelos\GrupFamProgramas;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\Modelos\Brecha;
use App\Modelos\BrechaIntegrante;
use App\Modelos\BrechaComuna;
use App\Modelos\BrechaBitacora;
use App\Modelos\AmProgramas;
use App\Modelos\EstadoProgramasBit;
use App\Modelos\EstablecimientoComuna;
use App\Modelos\GrupoFamiliar;
use App\Modelos\CasoGrupoFamiliar;
use DataTables;
use Carbon\Carbon;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Mail;


/**
 * Class ProgramaController
 * @package App\Http\Controllers
 */
class ProgramaController extends Controller {
	
	//rruiz 09052019
	//protected $programa;
	
	protected $nombres = [
		'prog_id'	=> 'Programa Id',
		'pro_nom'	=> 'Programa Nombre',
		'pro_des'	=> 'Programa Descripción',
		'pro_pro'	=> 'Programa Propósito',
		'pro_tip'	=> 'Programa Tipo',
		'dim_id'	=> 'Dimensión Id'
	];
	
	
	/**
	 * ProgramaController constructor.
	 * @param Programa $programa
	 */
	//rruiz 09052019 => se comenta el constructor para probar middleware auth desde las rutas
	/*public function __construct(Programa $programa){
		$this->middleware('auth');
		$this->programa	= $programa;
	}*/
	
	
	/**
	 * Método que permite el ingreso a la pantalla principal del mantenedor de Programas
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main(){

		$icono = Funcion::iconos(53);

		return view('programa.main',[
			"icono" => $icono
		]);
		
	}
		
	/**
	 * Método que lista los programas y los retorna como Json para ser entregados al DataTable
	 */
	public function listarPrograma($prog_id = null){
		$com_id = session()->all()['com_id'];
		$data		= new \stdClass();
		$data->data = array();

		if (empty($prog_id)){
			$sql = "SELECT p.prog_id, p.pro_nom, p.pro_tip, d.dim_nom, pc.pro_com_est FROM ai_programa p LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id LEFT JOIN ai_dimension d ON p.dim_id = d.dim_id WHERE pc.com_id IN (".$com_id.")";

			$programa = DB::select($sql);
		}else{
			$sql = "SELECT * FROM ai_programa p LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id LEFT JOIN ai_dimension d ON p.dim_id = d.dim_id WHERE p.prog_id = ".$prog_id." AND pc.com_id IN (".$com_id.")";

			$programa = DB::select($sql);
		
		}
		
		foreach($programa as $pi => $pv){
			if ($pv->pro_tip == 0){	
				$pv->pro_tip = 'Local';				
			
			}elseif ($pv->pro_tip == 1){
				$pv->pro_tip = 'Nacional';	
			
			}
			
			array_push($data->data, $pv);
		}
		
		echo json_encode($data); exit;
	}
	
	/**
	 * Método que busca la información para la construcción del modal de crear y modificar programas
	 * @param null $prog_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function crearPrograma($prog_id = null){
		$programa		= "";
		$programaComuna	= "";
		$direcciones = "";
		$responsable	= array();
		$ofertas      	= array();
		$id_comunas     = array();
		$dataPrograma 	= array();
		$dataAlertas  	= array();
		$componente   	= array();
		$id_comunas		= session()->all()['com_id'];
		$comunas        = Comuna::whereIn("com_id", explode(",", $id_comunas))->get();
		//$comunas        = session()->all()['comunas'];
		//dd($comunas, $a, session()->all());
		/*if (count($comunas) > 0){
			foreach ($comunas AS $c1 => $v1){ array_push($id_comunas, $v1->com_id); }
			$id_comunas = implode(",", $id_comunas);

			$responsable = DB::select("SELECT * FROM ai_usuario u LEFT JOIN ai_usuario_comuna uc ON u.id = uc.usu_id WHERE u.id_perfil = ".config('constantes.perfil_sectorialista')." AND uc.com_id IN (".$id_comunas.")");

		}*/

		$responsable = DB::select("SELECT * FROM ai_usuario u LEFT JOIN ai_usuario_comuna uc ON u.id = uc.usu_id WHERE u.id_perfil = ".config('constantes.perfil_sectorialista')." AND uc.com_id IN (".$id_comunas.")");

		$dimension				= Dimension::where("dim_act", "=", 1)->get();
		$alertaTipo     		= AlertaTipo::all();
		$fuenteFinaciamiento 	= DB::select("SELECT * FROM ai_fuent_de_financ");
		$tipoBeneficio 			= DB::select("SELECT * FROM ai_tipo_beneficio");
		$listarComunas			= DB::select("SELECT * FROM ai_comuna");

		if (!is_null($prog_id)){
			$programa		= Programa::where("prog_id","=",$prog_id)->get();
			$id_comunas 	= explode(",", $id_comunas);
	
			$programaComuna	= ProgramaComuna::where('prog_id', '=', $prog_id)->whereIn("com_id",$id_comunas)->get();
			//$ofertas 		= Ofertas::where("prog_id", "=", $prog_id)->get();

			$ofertas = Ofertas::where("prog_id", "=", $prog_id)
								->join('ai_ofertas_comuna', 'ai_ofertas.ofe_id', '=', 'ai_ofertas_comuna.ofe_id')
								->whereIn("ai_ofertas_comuna.com_id",$id_comunas)
								->get();

			$programaAlertas = ProgramaAlerta::where("prog_id", "=", $prog_id)->get();

			foreach ($programa AS $c1 => $v1){
				$dataPrograma[0] = new \stdClass;
				$dataPrograma[0]->id 			= $v1->prog_id;	
				$dataPrograma[0]->nombre 		= $v1->pro_nom;	
				$dataPrograma[0]->descripcion 	= $v1->pro_des;	
				$dataPrograma[0]->proposito 	= $v1->pro_pro;	
				$dataPrograma[0]->pob_obj 		= $v1->pro_pob_obj;	
				$dataPrograma[0]->duracion 		= $v1->pro_cant_mes;	
				$dataPrograma[0]->ins_resp 		= $v1->pro_inst_resp;	
				$dataPrograma[0]->sector 		= $v1->dim_id;	
				$dataPrograma[0]->fue_fin 		= $v1->id_fuen_de_financ;	
				$dataPrograma[0]->est_pro 		= $programaComuna[0]->pro_com_est;	
				$dataPrograma[0]->pro_com 		= $programaComuna[0]->com_id;	
				$dataPrograma[0]->pro_com_cupos	= $programaComuna[0]->pro_com_cupos;	
				$dataPrograma[0]->pro_cup 		= $v1->pro_cup;	
				$dataPrograma[0]->responsable 	= $v1->pro_usu_resp;	
				$dataPrograma[0]->tipo 			= $v1->pro_tip;	
				$dataPrograma[0]->responsable_comuna  = $programaComuna[0]->usu_resp_com;	
				$dataPrograma[0]->usu_resp_com_nom  = $programaComuna[0]->usu_resp_com_nom;	

				foreach ($programaAlertas AS $c2 => $v2){
					array_push($dataAlertas, $v2->ale_tip_id);
				}

				$dataPrograma[0]->pro_tip_ale 	= $dataAlertas;

				$dataComponentes = array();
				foreach ($ofertas AS $c2 => $v2){
					//dd($v2);
					$dataComponentes[$c2] 			  = new \stdClass;
			        $dataComponentes[$c2]->id           = $v2->ofe_id;
			        $dataComponentes[$c2]->nombre       = $v2->ofe_nom;
			        $dataComponentes[$c2]->descripcion  = $v2->ofe_des;
			        $dataComponentes[$c2]->beneficio    = $v2->id_tip_ben;
			        $dataComponentes[$c2]->cupos        = $v2->ofe_cup;
			        $dataComponentes[$c2]->priorizacion = $v2->ofe_criterio_priorizacion;
			        $dataComponentes[$c2]->periodo      = $v2->ofe_periodo_postulacion;
			        $dataComponentes[$c2]->forma        = $v2->ofe_forma_postulacion;
			        $dataComponentes[$c2]->horario      = $v2->ofe_hor_ate;
			        $dataComponentes[$c2]->responsable  = $v2->usu_resp;
			        $dataComponentes[$c2]->comuna       = "";

			        $ofertas_comuna = OfertaComuna::where("ofe_id", "=", $v2->ofe_id)->get();
			        if (count($ofertas_comuna) > 0){
			        	$dataComponentes[$c2]->comuna       = $ofertas_comuna[0]->com_id;
			        }
			        //dd($dataComponentes);

/*			      	$direcciones = "";
			      	$establecimientos = Establecimientos::where("ofe_id", "=", $v2->ofe_id)->get();
			      	if (count($establecimientos) > 0){
			      		$direcciones = array();
				      	foreach($establecimientos AS $c3 => $v3){
				      		$direcciones[$c3] = new \stdClass;

				      		$direcciones[$c3]->id            = $v3->estab_id;
	        				$direcciones[$c3]->nombre        = $v3->estab_nom;
	        				$direcciones[$c3]->direccion     = $v3->estab_dir;
	        				$direcciones[$c3]->referencia    = $v3->estab_ref;
				      	}
			      	}

			      	$dataComponentes[$c2]->direcciones  = $direcciones;
*/				}

				$dataPrograma[0]->componente      = $dataComponentes;
			}

			$componente  = $dataPrograma[0]->componente;
	      	// $establecimientos = Establecimientos::where("prog_id", "=", $prog_id)->get();
	      	$establecimientos = DB::select("SELECT * FROM ai_establecimientos e LEFT JOIN ai_establecimiento_comuna ec ON e.estab_id = ec.estab_id WHERE e.prog_id = ".$prog_id." AND ec.com_id IN (".session()->all()['com_id'].")");

	      	if (count($establecimientos) > 0){
	      		$direcciones = array();
		      	foreach($establecimientos AS $c3 => $v3){
		      		$direcciones[$c3] = new \stdClass;

		      		$direcciones[$c3]->id            = $v3->estab_id;
       				$direcciones[$c3]->nombre        = $v3->estab_nom;
       				$direcciones[$c3]->direccion     = $v3->estab_dir;
       				$direcciones[$c3]->referencia    = $v3->estab_ref;
       				$direcciones[$c3]->id_usu_responsable    = $v3->estab_usu_resp;

       				$nombre_responsable = Usuarios::find($v3->estab_usu_resp);
       				if (count($nombre_responsable) > 0){
						$nombre_responsable = $nombre_responsable->nombres.' '.$nombre_responsable->apellido_paterno.' '.$nombre_responsable->apellido_materno;
					}else{
						$nombre_responsable = "";
					
					}
       				
       				$direcciones[$c3]->nombre_usu_responsable    = $nombre_responsable;


		      	}
	      	}

			//$dataComponentes[$c2]->direcciones  = $direcciones;

			//dd("stop");


			
			/*foreach ($comunas as $ci => $cv) {
				$cv->checked	= "checked";
				$cv->disabled	= "disabled";
				if ((!is_null($programaComuna))) {
					foreach ($programaComuna->get() as $pci => $pcv) {
						if ($cv->com_id == $pcv->com_id){
							$cv->checked	= "checked";
						}
					}
				}
			}*/
			
			$id_comunas = implode(",", $id_comunas);
		}elseif (is_null($prog_id)){
			foreach ($comunas as $ci => $cv) { $cv->checked	= "checked"; $cv->disabled	= "disabled";}
			
			$dataPrograma[0] 				= new \stdClass;
			$dataPrograma[0]->id 			= "";	
			$dataPrograma[0]->nombre 		= "";	
			$dataPrograma[0]->descripcion 	= "";	
			$dataPrograma[0]->proposito 	= "";	
			$dataPrograma[0]->pob_obj 		= "";	
			$dataPrograma[0]->duracion 		= "";	
			$dataPrograma[0]->ins_resp 		= "";	
			$dataPrograma[0]->sector 		= "";	
			$dataPrograma[0]->fue_fin 		= "";	
			$dataPrograma[0]->est_pro 		= 1;	
			$dataPrograma[0]->pro_com 		= "";	
			$dataPrograma[0]->pro_com_cupos	= "";	
			$dataPrograma[0]->pro_cup 		= "";	
			$dataPrograma[0]->responsable 	= "";
			$dataPrograma[0]->tipo 			= "";	
			$dataPrograma[0]->responsable_comuna  = "";
			$dataPrograma[0]->usu_resp_com_nom  = "";
		}
		//$a = array("hola" => "hola");

		$direcciones = ($direcciones!="")?json_encode($direcciones):"na";
		return view('programa.crear')->with([
			'programa'				=> $programa,
			'dimension'				=> $dimension,
			'comunas'				=> $comunas,
			'ofertas'				=> $ofertas,
			'alertaTipo'			=> $alertaTipo,
			'fuenteFinaciamiento' 	=> $fuenteFinaciamiento,
			'responsable' 			=> $responsable,
			'tipoBeneficio' 		=> $tipoBeneficio,
			'listarComunas'			=> $listarComunas,
			'id_comunas'			=> $id_comunas,
			'dataAlertas'			=> $dataAlertas,
			'dataDireccion'           => $direcciones,
			'dataComponentes'		=> json_encode($componente),
			'dataPrograma'			=> $dataPrograma
		]);
	}
	
	/**
	 * Método que realiza el registro de un nuevo programa
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function insertarPrograma(Request $request){
		try{
			//----------------VALIDACION PROGRAMA-----------------------

			//----------------VALIDACION PROGRAMA-----------------------

			DB::beginTransaction();

			//PROGRAMA
			$prog_id						= Programa::max('prog_id')+1;
			$programa 						= new Programa();
			$programa->prog_id				= $prog_id;
			$programa->pro_nom				= $request->nombre;
			$programa->pro_des				= $request->descripcion;
			$programa->pro_pro				= $request->proposito;
			$programa->pro_pob_obj			= $request->pob_obj;
			$programa->pro_cant_mes			= $request->duracion;
			$programa->pro_inst_resp		= $request->ins_resp;
			$programa->dim_id				= $request->sector;
			$programa->id_fuen_de_financ	= $request->fue_fin;
			$programa->pro_usu_resp			= $request->responsable;
			$programa->pro_tip				= 0;//$request->pro_tip;
			$programa->pro_cup				= $request->pro_cup;
			$resultado 						= $programa->save();
			if (!$resultado) throw $resultado;

			// ESTABLECIMIENTOS

			$establecimientos = $request->establecimientos;
			if (isset($establecimientos)){
				foreach ($establecimientos as $establecimiento_actual){
					$establecimiento = Establecimientos::find($establecimiento_actual["id"]);
					
					if (is_null($establecimiento)){
						$establecimiento = new Establecimientos();	
						$establecimiento->prog_id = $prog_id;					
					}

					$establecimiento->estab_nom 	= $establecimiento_actual["nombre"];
					$establecimiento->estab_dir 	= $establecimiento_actual["direccion"];
					$establecimiento->estab_ref 	= $establecimiento_actual["referencia"];
					$establecimiento->estab_usu_resp 	= $establecimiento_actual["id_usu_responsable"];
					$resultado 						= $establecimiento->save();
					if (!$resultado) throw $resultado;

					$estab_comuna 			= new EstablecimientoComuna();
					$estab_comuna->estab_id = $establecimiento->estab_id;
					$estab_comuna->com_id 	= session()->all()["com_id"];
					$resultado 				= $estab_comuna->save();
					if (!$resultado) throw $resultado;
				}
			}


			//COMUNAS PROGRAMA
			$pro_com = explode(",", $request->pro_com);
			foreach ($pro_com as $pci => $pcv){
				$programaComuna				= new ProgramaComuna();
				$programaComuna->prog_id	= $programa->prog_id;
				$programaComuna->com_id		= $pcv;
				$programaComuna->pro_com_est= $request->est_pro;
				$programaComuna->usu_resp_com = $request->responsable_comuna;	
				$programaComuna->pro_com_cupos = $request->pro_com_cupos;	
				$programaComuna->usu_resp_com_nom = $request->usu_resp_com_nom;	
				$resultado 					  	= $programaComuna->save();
				if (!$resultado) throw $resultado;
			}

			//TIPO DE ALERTA
			if (!is_null($request->pro_tip_ale)){
				foreach ($request->pro_tip_ale as $c0 => $v0){
					$resultado = DB::table('ai_programa_alerta_tipo')->insert(['ale_tip_id' => $v0, 'prog_id' => $programa->prog_id]);
					if (!$resultado) throw $resultado;
				}
			}

			if (!is_null($request->componente)){
				foreach($request->componente AS $c1 => $v1){
					//OFERTA
					$ofe_id							= (Ofertas::max('ofe_id')) + 1;
					$oferta 						= new Ofertas();
					$oferta->ofe_id 				= $ofe_id;
					$oferta->ofe_nom 				= $v1["nombre"];
					$oferta->ofe_des 				= $v1["descripcion"];
					$oferta->id_tip_ben 			= $v1["beneficio"];
					$oferta->ofe_cup 				= $v1["cupos"];
					$oferta->ofe_criterio_priorizacion 	= $v1["priorizacion"];
					$oferta->ofe_periodo_postulacion 	= $v1["periodo"];
					$oferta->ofe_forma_postulacion 		= $v1["forma"];
					$oferta->ofe_hor_ate 			= $v1["horario"];
					$oferta->usu_resp 				= $v1["responsable"];
					$oferta->ofe_est 				= 1;
					$oferta->prog_id 				= $programa->prog_id;
					$resultado 							= $oferta->save();
					if (!$resultado) throw $resultado;

					//OFERTA COMUNA
					$ofe_com_id 				= (OfertaComuna::max('ofe_com_id')) + 1;
					$ofertasComuna 				= new OfertaComuna();
					$ofertasComuna->ofe_com_id 	= $ofe_com_id; 
					$ofertasComuna->ofe_id 		= $ofe_id;
					$ofertasComuna->com_id 		= $request->pro_com;
					$resultado					= $ofertasComuna->save();
					if (!$resultado) throw $resultado;

					$responsable = DB::select("SELECT nombres, apellido_paterno, email FROM ai_usuario WHERE id = ".$oferta->usu_resp);
					$this->envioCorreo($programa->pro_nom, $responsable);
					/*if (!is_null($v1["direcciones"])){
						foreach ($v1["direcciones"] AS $c2 => $v2){
							//ESTABLECIMIENTO OFERTA
							$establecimiento 				= new Establecimientos();
							$establecimiento->estab_nom 	= $v2["nombre"];
							$establecimiento->estab_dir 	= $v2["direccion"];
							$establecimiento->estab_ref 	= $v2["referencia"];
							$establecimiento->ofe_id 		= $ofe_id;
							$resultado 						= $establecimiento->save();
							if (!$resultado) throw $resultado;
						}
					}*/
					
				}
			}

			DB::commit();
		
			
			$mensaje = "El programa ha sido creado exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
			
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	//Inicio Andres F.
	public function envioCorreo($programa, $destinatarios){
		$objDemo = new \stdClass();
		$objDemo->tipo_correo = 'sectorialistas';
		$objDemo->nombre_programa = $programa;
		//return $destinatarios;
		//Log::error('error: ' . print_r($destinatarios));
		//foreach($destinatarios as $key => $valor){
			//return $valor['nombres'];
			$objDemo->persona = $destinatarios[0]->nombres.' '.$destinatarios[0]->apellido_paterno;
			Mail::to($destinatarios[0]->email)->send(new MailController($objDemo));
		//}
		
	}

	//Fin Andres F.
	

	/**
	 * Método que realiza la modificación de un programa ya existente
	 * @param \App\Http\Controllers\Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */

	public function eliminarEstablecimiento(Request $request){
		try{
			DB::beginTransaction();

			$id_establecimiento = $request->id;
			$estab_comuna = EstablecimientoComuna::find($id_establecimiento);
			$resultado = $estab_comuna->delete();
			if (!$resultado) throw $resultado;
			
			$establecimiento = Establecimientos::find($id_establecimiento);
			$resultado = $establecimiento->delete();
			if (!$resultado) throw $resultado;

			DB::commit();

			$mensaje = "Establecimiento eliminado con éxito.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: ' . $e);

			$mensaje = "Hubo un error al momento de eliminar el establecimiento solicitado. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function actualizarPrograma(Request $request){
		try{
			//----------------VALIDACION PROGRAMA-----------------------
			//----------------VALIDACION PROGRAMA-----------------------

			DB::beginTransaction();
			$prog_id = $request->id; 
			//PROGRAMA
			//$programa 						= Programa::find($request->id);
			$programa 						= Programa::find($prog_id);
			$programa->pro_nom				= $request->nombre;
			$programa->pro_des				= $request->descripcion;
			$programa->pro_pro				= $request->proposito;
			$programa->pro_pob_obj			= $request->pob_obj;
			$programa->pro_cant_mes			= $request->duracion;
			$programa->pro_inst_resp		= $request->ins_resp;
			$programa->dim_id				= $request->sector;
			$programa->id_fuen_de_financ	= $request->fue_fin;
			$programa->pro_usu_resp			= $request->responsable;
			//$programa->pro_tip				= 0;//$request->pro_tip;
			$programa->pro_cup				= $request->pro_cup;
			$resultado 						= $programa->save();
			if (!$resultado) throw $resultado;

			// ESTABLECIMIENTOS

			$establecimientos = $request->establecimientos;
			if (isset($establecimientos)){
				foreach ($establecimientos as $establecimiento_actual){
					$establecimiento = Establecimientos::find($establecimiento_actual["id"]);
					
					if (is_null($establecimiento)){
						$establecimiento = new Establecimientos();	
						$establecimiento->prog_id = $prog_id;					
					}

					$establecimiento->estab_nom 	= $establecimiento_actual["nombre"];
					$establecimiento->estab_dir 	= $establecimiento_actual["direccion"];
					$establecimiento->estab_ref 	= $establecimiento_actual["referencia"];
					$establecimiento->estab_usu_resp 	= $establecimiento_actual["id_usu_responsable"];
					$resultado 						= $establecimiento->save();
					if (!$resultado) throw $resultado;

					if (is_null($establecimiento_actual["id"]) && $establecimiento_actual["id"] == ""){
						$estab_comuna 			= new EstablecimientoComuna();
						$estab_comuna->estab_id = $establecimiento->estab_id;
						$estab_comuna->com_id 	= session()->all()["com_id"];
						$resultado 				= $estab_comuna->save();
						if (!$resultado) throw $resultado;
					}

				}
			}


			//COMUNAS PROGRAMA
			$pro_com = explode(",", $request->pro_com);
			foreach ($pro_com as $pci => $pcv){
				$data["prog_id"] = $request->id;
				$data["com_id"] = $pcv;
				$data["pro_com_est"] = $request->est_pro;
				$data["usu_resp_com"] = $request->responsable_comuna;
				$data["pro_com_cupos"] = $request->pro_com_cupos;
				$data["usu_resp_com_nom"] = $request->usu_resp_com_nom;

				$programaComuna = ProgramaComuna::where('prog_id', $request->id)->where('com_id', $pcv)->update($data);

				if (!$programaComuna){
					$resultado = DB::table('ai_pro_com')->insert($data);
					if (!$resultado) throw $resultado;
				}

				/*
				$programaComuna 			= ProgramaComuna::where("prog_id", "=", $request->id)->where("com_id","=", $pcv)->first();

				if (is_null($programaComuna)){
					$programaComuna				= new ProgramaComuna();
				}

				$programaComuna->prog_id	= $request->id;
				$programaComuna->com_id		= $pcv;
				$programaComuna->pro_com_est= $request->est_pro;
				$programaComuna->usu_resp_com= $request->responsable_comuna;
				$resultado = $programaComuna->save();
				if (!$resultado) throw $resultado;*/
			}

			//TIPO DE ALERTA
			if (!is_null($request->pro_tip_ale)){
				$resultado = DB::table('ai_programa_alerta_tipo')->where('prog_id', '=', $request->id)->delete();
				foreach ($request->pro_tip_ale as $c0 => $v0){
					$resultado = DB::table('ai_programa_alerta_tipo')->insert(['ale_tip_id' => $v0, 'prog_id' => $request->id]);
					if (!$resultado) throw $resultado;
				}
			}

			if (!is_null($request->componente)){
				foreach($request->componente AS $c1 => $v1){
					//OFERTA
					$ofe_id = $v1["id"];
					$oferta = Ofertas::find($ofe_id);
					if (is_null($oferta)){
						$ofe_id							= (Ofertas::max('ofe_id')) + 1;
						$oferta 						= new Ofertas();
					}

					$oferta->ofe_id 				= $ofe_id;
					$oferta->ofe_nom 				= $v1["nombre"];
					$oferta->ofe_des 				= $v1["descripcion"];
					$oferta->id_tip_ben 			= $v1["beneficio"];
					$oferta->ofe_cup 				= $v1["cupos"];
					$oferta->ofe_criterio_priorizacion 	= $v1["priorizacion"];
					$oferta->ofe_periodo_postulacion 	= $v1["periodo"];
					$oferta->ofe_forma_postulacion 		= $v1["forma"];
					$oferta->ofe_hor_ate 			= $v1["horario"];
					$oferta->usu_resp 				= $v1["responsable"];
					$oferta->ofe_est 				= 1;
					$oferta->prog_id 				= $request->id;
					$resultado 							= $oferta->save();
					if (!$resultado) throw $resultado;

					//OFERTA COMUNA
					$ofertasComuna 				= OfertaComuna::where("ofe_id", "=", $ofe_id)->first(); 
					if (is_null($ofertasComuna)){
						$ofe_com_id 				= (OfertaComuna::max('ofe_com_id')) + 1;
						$ofertasComuna 				= new OfertaComuna();
						$ofertasComuna->ofe_com_id 	= $ofe_com_id; 
						$ofertasComuna->ofe_id 		= $ofe_id;
					}

					$ofertasComuna->com_id 		= $request->pro_com;
					$resultado					= $ofertasComuna->save();
					if (!$resultado) throw $resultado;

					/*if (!is_null($v1["direcciones"])){
						foreach ($v1["direcciones"] AS $c2 => $v2){
							//ESTABLECIMIENTO OFERTA
							$establecimiento = Establecimientos::where("estab_id", "=", $v2["id"])->first();
							if (is_null($establecimiento)){
								$establecimiento = new Establecimientos();	
								$establecimiento->ofe_id 		= $ofe_id;					
							}

							$establecimiento->estab_nom 	= $v2["nombre"];
							$establecimiento->estab_dir 	= $v2["direccion"];
							$establecimiento->estab_ref 	= $v2["referencia"];
							$resultado 						= $establecimiento->save();
							if (!$resultado) throw $resultado;
						}
					}*/
				}
			}

			DB::commit();
			$mensaje = "El programa ha sido modificado exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
			
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: ' . $e);
			
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function listarProgramaXcomuna(Request $request){
		try{
			$com_id = session()->all()['com_id'];
			$cas_id = $request->cas_id;
			$grup_fam_id_origen = $request->grup_fam_id;

			$programas = DB::select("SELECT p.prog_id, p.pro_nom, 'Sectorialista: '||decode(aiu.nombres,NULL,'Sin Información',aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno)||', Email: '||decode(aiu.email,NULL,'Sin Información',aiu.email)||', Teléfono: '||decode(aiu.telefono,NULL,'Sin Información',aiu.telefono) AS contacto_establecimiento, e.estab_id, e.estab_nom FROM ai_programa p INNER JOIN ai_pro_com pc ON pc.prog_id = p.prog_id LEFT JOIN ai_establecimientos e ON e.prog_id = pc.prog_id LEFT JOIN ai_establecimiento_comuna ec ON e.estab_id = ec.estab_id LEFT JOIN ai_usuario aiu ON aiu.id = e.estab_usu_resp WHERE pc.com_id=".$com_id." AND pro_com_est = 1 AND e.estab_usu_resp IS NOT NULL AND ec.com_id IN (".$com_id.") ORDER BY p.prog_id");
			
			$prog_asignacion = array();

			foreach ($programas as $prog){
				$prog_asig 	= 0;
				$estab_asig = 0;
				$gru_fam_id = null;
				$brecha_integrante = 0;
				$brecha = Brecha::where('id_programa', $prog->prog_id)->where('estado', config('constantes.brecha_abierta'))->first();

				if ($brecha){
					$brecha_integrante = BrechaIntegrante::where('id_brecha',$brecha->id_brecha)
					->where('id_caso', $cas_id)
					->where('id_integrante', $grup_fam_id_origen)
					->where('estado', config('constantes.brecha_abierta'))->first();
				}

				$asignados = DB::select("SELECT * FROM ai_grup_fam_programas gfp LEFT JOIN ai_estados_programas ep ON gfp.est_prog_id = ep.est_prog_id WHERE gfp.gru_fam_id =".$grup_fam_id_origen." AND gfp.prog_id = ".$prog->prog_id." AND gfp.estab_id = ".$prog->estab_id." AND ep.est_prog_fin = 0");

				if (count($asignados) > 0){
					$prog_asig = 1;
			 		$gru_fam_id = $grup_fam_id_origen;
				    $estab_asig = 1;

				}

				$array_tmp 					= array();
		   	 	$array_tmp = array("prog_id" 	=> $prog->prog_id,
				  "pro_nom" 			=> $prog->pro_nom,
				  "estab_nom" 			=> $prog->estab_nom,
				  "estab_id" 			=> $prog->estab_id,
				  "gru_fam_id" 			=> $gru_fam_id,
				  "prog_asig" 			=> $prog_asig,
				  "estab_asig" 			=> $estab_asig,
				  "brecha" 				=> ($brecha_integrante)? $brecha_integrante->id_brecha_inte_caso : 0,
				  "observacion_brecha" 	=> ($brecha_integrante)? $brecha_integrante->comentario : '',
				  "contacto_establecimiento" => $prog->contacto_establecimiento);

		   	 	array_push($prog_asignacion , $array_tmp);
				
			}

			$data		= new \stdClass();
			$data->data = $prog_asignacion;
			
			echo json_encode($data); exit;
			
		} catch(\Exception $e){
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
		}
	}

	public function guardarAsignacionProgramaSinAlertas(Request $request){
		try{
			if (!isset($request->prog_id) && $request->prog_id == ""){
				$mensaje = "No se encuentra el ID del programa. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->grup_fam_id) && $request->grup_fam_id == ""){
				$mensaje = "No se encuentra el ID del integrante familiar. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->cas_id) && $request->cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$caso = Caso::where("cas_id", "=", $request->cas_id)->first();
			if (count($caso) == 0){
				$mensaje = "No se encuentra información del caso. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::beginTransaction();

			$estado_programa = config('constantes.sin_gestionar');
			if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')) $estado_programa = config('constantes.pendiente');

			$resultado = DB::insert('INSERT INTO AI_GRUP_FAM_PROGRAMAS
					(PROG_ID,
					GRU_FAM_ID,
					EST_PROG_ID,
					ESTAB_ID,
					CREATED_AT)
					VALUES (?,?,?,?,?)',
					[$request->prog_id,
					$request->grup_fam_id,
					$estado_programa,
					$request->estab_id,
					Carbon::now()]);
			if (!$resultado) throw $resultado;

			$maxId = DB::select("SELECT MAX(GRUP_FAM_PROG_ID) AS id FROM AI_GRUP_FAM_PROGRAMAS");
			if (count($maxId) == 0){
				$mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$estado_programa = config('constantes.sin_gestionar');
			$comentario = "Se asigna programa.";
			$resultado = DB::insert('insert into AI_ESTADOS_GFAM_PROGRAMAS_BIT
					(GRUP_FAM_PROG_ID,
					EST_PROG_ID,
					EST_PROG_BIT_DES)
					values (?,?,?)',
					[$maxId[0]->id,
					$estado_programa,
					$comentario]);
			if (!$resultado) throw $resultado;

			if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')){
				$estado_programa = config('constantes.pendiente');
				$comentario = "Se realiza derivación a sectorialista.";

				$resultado = DB::insert('insert into AI_ESTADOS_GFAM_PROGRAMAS_BIT
					(GRUP_FAM_PROG_ID,
					EST_PROG_ID,
					EST_PROG_BIT_DES)
					values (?,?,?)',
					[$maxId[0]->id,
					$estado_programa,
					$comentario]);
				if (!$resultado) throw $resultado;
			}

			DB::commit();

			$mensaje = "Asignación realizada exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje));
		}catch(\Exception $e){
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
		}
	}

	public function listarAsignacionProgramaSinAlertas(Request $request){
		try{
			$sql = "SELECT * FROM ai_grup_fam_programas gfp LEFT JOIN ai_programa p ON gfp.prog_id = p.prog_id LEFT JOIN ai_establecimientos e ON gfp.estab_id = e.estab_id LEFT JOIN ai_estados_programas ep ON gfp.est_prog_id = ep.est_prog_id WHERE gfp.gru_fam_id = ".$request->grup_fam_id;

			$programas = DB::select($sql);

			$data		= new \stdClass();
			$data->data = $programas;

			echo json_encode($data); exit;
			
		} catch(\Exception $e){
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
		}
	}

	public function desestimarAsignacionProgramaSinAlertas(Request $request){
		try{
			if (!isset($request->grup_fam_prog_id) && $request->grup_fam_prog_id == ""){
				$mensaje = "No se encuentra el ID de la asignacion. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->est_prog_id) && $request->est_prog_id == ""){
				$mensaje = "No se encuentra el ID del estado del programa. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}


			DB::beginTransaction();

			$bitacora = DB::table('ai_estados_gfam_programas_bit')->insert(['grup_fam_prog_id' => $request->grup_fam_prog_id, 'est_prog_id' => $request->est_prog_id, "est_prog_bit_des" => "CAMBIO DE ESTADO AUTOMATICO A DESESTIMADO."]);
			if (!$bitacora){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la desestimación de la derivación. Por favor verifique o intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje));
			}

			$derivación = DB::table('ai_grup_fam_programas')->where('grup_fam_prog_id', $request->grup_fam_prog_id)->update(['est_prog_id' => $request->est_prog_id]);
			if (!$bitacora){
				DB::rollback();
				$mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor verifique o intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje));
			}

			DB::commit();

			$mensaje = "Asignación desestimada exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje));

		} catch(\Exception $e){
			dd($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' =>  $e), 400);
		
		}
	}

	public function nomProg(Request $request){

		$prog_nom = Programa::getPrograma($request->prog_id);

		return json_decode($prog_nom);

	}

	public function generarBrecha($prog_id, $cas_id, $gru_fam_id, $id_alerta){

		try{

			DB::beginTransaction();

			$estado_abierto = config('constantes.brecha_abierta');
			$id_comuna = session()->all()['com_id'];

			//busca si existe la brecha, sino la crea
			$brecha = Brecha::where('id_programa',$prog_id)
			->join('ai_brecha_comuna', 'ai_brecha.id_brecha', '=', 'ai_brecha_comuna.id_brecha')
			->where('estado',$estado_abierto)->first();

			if (!$brecha){
				// se crea la brecha
				$brecha = new Brecha();
				$brecha->id_programa = $prog_id;
				$brecha->brecha_mensual = 1;
				$brecha->estado = $estado_abierto;
			}else{
				// se incrementa en uno la brecha mensual
				$brecha->brecha_mensual = $brecha->brecha_mensual + 1;
			}

			$brecha->save();

			$id_brecha = $brecha->id_brecha;

			//se busca si existe la brecha para la comuna, sino se crea

			$brecha_comuna = BrechaComuna::where('id_brecha',$id_brecha)->where('id_comuna',$id_comuna)->first();

			if (!$brecha_comuna){
				$brecha_comuna = new BrechaComuna();
				$brecha_comuna->id_brecha = $id_brecha;
				$brecha_comuna->id_comuna = $id_comuna;
				$brecha_comuna->save();
			}


			//se genera la brecha para el integrante
			$brechaIntegrante = new BrechaIntegrante();
			$brechaIntegrante->id_brecha = $id_brecha; 
			$brechaIntegrante->id_caso = $cas_id;
			$brechaIntegrante->id_usuario = session()->all()["id_usuario"];
			$brechaIntegrante->id_integrante = $gru_fam_id; 
			if ($id_alerta!=-1){
				$brechaIntegrante->id_alerta_territorial = $id_alerta; 
			}
			$brechaIntegrante->estado = $estado_abierto;
			$brechaIntegrante->save();

			DB::commit();

			return response()->json(array('estado' => '1',
				'mensaje' => 'El registro ha sido actualizado correctamente'));


		} catch(\Exception $e){
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' =>  $mensaje), 400);
		}

	}


	public function guardarObservacionBrecha($id_brecha, $observacion=null){

		try{

			DB::beginTransaction();

			$brecha_nna = BrechaIntegrante::find($id_brecha);
			$brecha_nna->comentario = $observacion;
			$brecha_nna->save();

			DB::commit();

			return response()->json(array('estado' => '1',
				'mensaje' => 'El registro ha sido actualizado correctamente'));

		} catch(\Exception $e){
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' =>  $mensaje), 400);
		}


	}

	public function buscarBrechaNna($id_brecha, $id_caso, $grup_fam_id){

		$brecha_nna = BrechaIntegrante::where('id_brecha',$id_brecha)->where('id_caso',$id_caso)->where('id_integrante',$grup_fam_id)->where('estado',config('constantes.brecha_abierta'))->count();
		return $brecha_nna;
	
	}

	public function listarProgramasConBrechas(){

		$sql = "SELECT 
					distinct
					aib.id_brecha,
					aip.prog_id,
					aip.pro_nom,
					decode(aip.pro_inst_resp,null,'SIN INFORMACION', aip.pro_inst_resp) pro_inst_resp,
					decode(aip.pro_cup,null,0,aip.pro_cup) pro_cup,
					aib.brecha_mensual
				FROM 
					ai_programa aip
					inner join ai_brecha aib on aib.id_programa = aip.prog_id
					inner join ai_brecha_comuna aibc on aibc.id_brecha = aib.id_brecha
				WHERE 
					aib.estado = ". config('constantes.brecha_abierta') ."
					and aibc.id_comuna = ". session()->all()['com_id'];

		$listarProgramasConBrechas = DB::select($sql);

		
		return Datatables::of($listarProgramasConBrechas)->make(true);

	}

	public function vistaProgramasConBrechas(){

		$icono = Funcion::iconos(182);

		return view('programa.brechas',
			[
				'icono' => $icono
			]
		);
	}

	public function grabarBrecha($id_brecha, $bitacora){

		try{

			DB::beginTransaction();

			$BitacoraBrecha = new BrechaBitacora();
			$BitacoraBrecha->id_brecha = $id_brecha;
			$BitacoraBrecha->id_usuario = session()->all()['id_usuario'];
			$BitacoraBrecha->comentario = $bitacora;
			$BitacoraBrecha->fecha = Carbon::now();
			$BitacoraBrecha->save();

			DB::commit();

			return response()->json(array('estado' => '1',
				'mensaje' => 'El registro ha sido actualizado correctamente'));


		} catch(\Exception $e){
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente." . $e;
			return response()->json(array('estado' => '0', 'mensaje' =>  $mensaje), 400);
		}

	}

	public function BitacoraBrecha($id_brecha){

		$sql = "select 
				    aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno coordinador,
				    to_char(aibb.fecha,'dd-mm-yyyy') fecha,
				    aibb.comentario
				from 
    				ai_brecha_bitacora aibb
    				left join ai_usuario aiu on aiu.id = aibb.id_usuario
				where 
    				aibb.id_brecha = " . $id_brecha;

		$listar = DB::select($sql);
		
		return Datatables::of($listar)->make(true);

	}


	public function listarBrechas($id_brecha){
		$where_com_id = " and aicc.com_id = " . session()->all()['com_id'];

		$sql = "select 
					aibc.id_brecha_inte_caso,
					aibc.id_caso,
					aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno gestor,
					aigf.gru_fam_run||'-'||aigf.gru_fam_dv rut_integrante_sin_formato,
					DECODE (
						LENGTH (aigf.gru_fam_run || '-' || aigf.gru_fam_dv),
						10,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 6, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 9, 2),
						9,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 5, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 8, 2),
						8,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 4, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 7, 2),
						7,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 6, 2),
						6,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 5, 2),
						5,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 4, 2),
						4,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 2),
						3,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 2)) rut_integrante_con_formato,
					aigf.gru_fam_nom||' '||aigf.gru_fam_ape_pat||' '||aigf.gru_fam_ape_mat nombre_integrante,
					aiat.ale_tip_nom,
					aibc.comentario
				from 
					ai_brecha_integrante_caso aibc
					left join ai_usuario aiu on aiu.id = aibc.id_usuario
					left join ai_caso_comuna aicc on aibc.id_caso = aicc.cas_id
					left join ai_grupo_familiar aigf on aigf.gru_fam_id = aibc.id_integrante
					left join ai_alerta_manual aiam on aiam.ale_man_id = aibc.id_alerta_territorial
					left join ai_alerta_manual_tipo aiamt on aiamt.ale_man_id = aiam.ale_man_id
					left join ai_alerta_tipo aiat on aiat.ale_tip_id = aiamt.ale_tip_id
				where aibc.estado = ".config('constantes.brecha_abierta')."
					and aibc.id_brecha = " . $id_brecha . $where_com_id;

		$listar = DB::select($sql);
		
		return Datatables::of($listar)->make(true);


	}

	public function finalizarBrecha($id_brecha_integrante){

		try{

			DB::beginTransaction();

			$brechaIntegrante = BrechaIntegrante::find($id_brecha_integrante);
			$brechaIntegrante->estado = 0;
			$brechaIntegrante->save();

			$brecha = Brecha::find($brechaIntegrante->id_brecha);
			$brecha->brecha_mensual = $brecha->brecha_mensual - 1;

			if ($brecha->brecha_mensual==0){
				$brecha->estado = config('constantes.brecha_cerrada');
			}

			$brecha->save(); 

			DB::commit();

			return response()->json(array('estado' => '1',
				'mensaje' => 'El registro ha sido actualizado correctamente'));


		} catch(\Exception $e){
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' =>  $mensaje), 400);
		}

	}

}