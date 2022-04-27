<?php
namespace App\Http\Controllers;
use App\Services\ApiMdsService;
use Auth;
use Illuminate\Support\Facades\App;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use DataTables;
use GuzzleHttp\Client;

use App\Modelos\{AlertaManual,
	AsignadosVista,
	Caso,
	Contacto,
	CasoEstado,
	CasoTerapeuta,
	Comuna,
	Dimension,
	EstadoCaso,
	NNAAlertaManual,
	Persona,
	Direccion,
	Liceo,
	Predictivo,
	Score,
	Region,
	Tercero,
	RegistradosVista,
	UsuarioComuna,
	Usuarios,
	Sesion,
	Perfil,
	GrupoFamiliar,
	CasoGrupoFamiliar,
	CasoPersonaIndice,
	CasoAlertaManual,
	Respuesta,
	Provincia,
	ParentescoGrupoFamiliar,
	AlertaChcc,
	AlertaChileCreceContigo,
	NNAAlertaManualCaso,
	ObjetivoPaf,
	TareaObjetivoPaf,
	PersonaUsuario,
	ModalidadVisita,
	Programa,
	ReporteGestionCaso,
	Funcion,
	CodigoEnsenanza,
	AmProgramas,
	EstadoProgramasBit,
	AsignadosSectorialista,
	EstadoProgramas,
	EstadoGfamProgramasBit,
	GrupFamProgramas,
	Pregunta,
	ProgramaSeguimiento,
	SeguimientoCasoDesestimado,
	BitacoraEstadoSeguimiento,
	CasoPausa,
	SesionDevolucion,
	DescartePredictivo,
	CasoReporteGestion,
	Terapia,
	EstadoTerapiaBitacora,
	EstadoTerapia,
	SesionTarea,
	AlertaPriorizadaporTipo,
	AlertaPriorizadaCaso,
	AlertaTipo,
	EstadoAlertaManualEstado,
	AmDimension,
	DocumentCoord,
	// INICIO CZ SPRINT 58
	ContactoParentesco2,
	// FIN CZ SPRINT 58
	// INICIO CZ SPRINT 68
	DatosPersona,
	// FIN CZ SPRINT 68
	// INICIO CZ SPRINT 72
	CasosDesestimados,
	// FIN CZ SPRINT 72
	// CZ SPRINT 74
	NotificacionAsignacion,
	TiempoIntervencionCaso,
	CasosGestionEgresado, 
	NominaComunal
	// CZ SPRINT 74
};

//Inicio Andres F.
use App\Http\Controllers\MailController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Traits\CasoTraitsGenericos;
use App\Helpers\helper;
use Freshwork\ChileanBundle\Rut;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
//Fin Andres F.

class CasoController extends Controller
{
	protected $nombres = [
		'cas_id' => 'Casos',
		'ter_id' => 'Terceros',
		'cas_est_cas_des' => 'Comentario',
		'est_cas_id' => 'Estado',
	];
	
	protected $reglas_derivar = [
		'adjunto'           => 'sometimes|file|mimes:pdf,jpeg,bmp,png,txt,xls,xlsx,doc,docx|max:3072',
		'cas_id'            => 'required',
		'ter_id'            => 'required|numeric',
		'cas_est_cas_des'   => 'required',
		'est_cas_id'        => '',
	];

	protected $reglas_doc = [
		'archivo' => 'file|mimes:pdf,docx,doc|max:3072'
    ];
	
	use CasoTraitsGenericos;
	
	protected $caso;
	protected $estado_caso;
	protected $usuario;
	protected $dimension;
	protected $tercero;
	protected $persona;
	protected $contacto;
	protected $direccion;
	
	protected $caso_terapeuta;
	
	protected $caso_estado;
	
	protected $registrados_vista;
	
	protected $asignados_vista;
	
	protected $alertaManual;
	
	protected $usuario_comuna;
	
	protected $grupo_familiar;
	
	protected $casoGrupoFamiliar;
	
	protected $casoPersonaIndice;

	protected $amProgramas;

	protected $estadoProgramasBit;

	protected $descartePredictivo;
	
	public function __construct(
		//Pruebas unitarias
		Caso				$caso,
		EstadoCaso			$estado_caso,
		Usuarios			$usuario,
		Dimension			$dimension,
		Tercero				$tercero,
		Persona				$persona,
		Contacto			$contacto,
		Direccion			$direccion,
		CasoTerapeuta		$caso_terapeuta,
		CasoEstado			$caso_estado,
		RegistradosVista	$registrados_vista,
		AsignadosVista		$asignados_vista,
		Perfil              $perfil,
		AlertaManual		$alertaManual,
		UsuarioComuna       $usuario_comuna,
		GrupoFamiliar       $grupo_familiar,
		CasoGrupoFamiliar   $casoGrupoFamiliar,
		CasoPersonaIndice   $casoPersonaIndice,
		AmProgramas         $amProgramas,
		EstadoProgramasBit  $estadoProgramasBit,
		DescartePredictivo  $descartePredictivo,
		// INICIO CZ SPRINT 58
		ContactoParentesco2 $ContactoParentesco2,
		// INICIO CZ SPRINT 58
		// INICIO CZ SPRINT 68
		DatosPersona 		$DatosPersona,
		// CZ SPRINT 74
		NotificacionAsignacion $notificacionAsignacion
		// CZ SPRINT 74
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->middleware('verificar.perfil:coordinador')
			->only(['mostrarFrmManuales','listar']);
		$this->middleware('verificar.perfil:coordinador,terapeuta,gestor,super_usuario,coordinador_regional')
			->only(['mostrarFrmManuales','ficha']);
		$this->middleware('verificar.caso.terapeuta',['only' => ['ficha']]);
		$this->caso					= $caso;
		$this->estado_caso			= $estado_caso;
		$this->usuario				= $usuario;
		$this->dimension			= $dimension;
		$this->tercero				= $tercero;
		$this->persona				= $persona;
		$this->contacto				= $contacto;
		$this->direccion			= $direccion;
		$this->caso_terapeuta		= $caso_terapeuta;
		$this->caso_estado			= $caso_estado;
		$this->registrados_vista	= $registrados_vista;
		$this->asignados_vista		= $asignados_vista;
		$this->perfil				= $perfil;
		$this->alertaManual			= $alertaManual;
		$this->usuario_comuna       = $usuario_comuna;
		$this->grupo_familiar       = $grupo_familiar;
		$this->casoGrupoFamiliar    = $casoGrupoFamiliar;
		$this->casoPersonaIndice    = $casoPersonaIndice;
		$this->amProgramas    		= $amProgramas;
		$this->estadoProgramasBit   = $estadoProgramasBit;
		$this->descartePredictivo   = $descartePredictivo;
	}

	/**
	* Devuelve coincidencias contra la vista de bd
	* para la búsqueda interactiva
	*/
	public function busquedaInteractiva($run){

		$run_entrada = $run;

		try{
			if (Rut::parse($run_entrada)->validate()){
				$run_con_formato = Rut::parse($run_entrada)->format();
				// INICIO CZ SPRINT 73
				$arr1 = str_split($run);
				$arr2 = explode("-",$run);
				$run = $arr2[0];
				$dv = $arr2[1];
				$val_info = $this->validarPredictivoPersonaCasoAlertas($arr2[0], $arr2[1]);
				if ($val_info["persona"] == false){
					$predictivo = $this->caso->informacionNNAPredictivo($run);
					if(count($predictivo) > 0){
						$nna['coincidencia']="1";
						$nna['run_correcto']="1";
						$nna['error']="0";
						$nna['nna_run_con_formato']=$run_con_formato;
						$nna['run']=$run;
						return $nna;
						//dd('dataresultante',$nna);
					}else{
						$nna['coincidencia']="0";
						$nna['run_correcto']="1";
						$nna['nna_run_con_formato']=$run_con_formato;
						$nna['run']=$run;
						return $nna;
						//dd('noencontro',$nna);
					}
				}else if ($val_info["persona"] == true){
					$cantidadCasos = $this->caso->cantidadCasosNNA($run);
					if($cantidadCasos > 0){
						$nna['coincidencia']="1";
						$nna['run_correcto']="1";
						$nna['error']="0";
						$nna['nna_run_con_formato']=$run_con_formato;
						$nna['run']=$run;
						return $nna;
						//dd('dataresultante',$nna);
				}else{
					$nna['coincidencia']="0";
					$nna['run_correcto']="1";
					$nna['error']="0";
					return $nna;
					//dd('noencontro',$nna);
				}

				}
			}else{
				$nna['coincidencia']="0";
				$nna['run_correcto']="0";
				$nna['error']="0";
				return $nna;
				//dd('es invalido',$nna);
			}
				// FIN CZ SPRINT 73
		} catch(\Exception $e) {
			$nna['error']="1";
			return $nna;
		}
	
	}
	
	/**
	 * Muestra el formulario de Casos por Evaluar
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function vistaCasosRegistrados(){
		$comuna = explode(',',session()->all()['com_cod']);

		$desde_terapia = 0;
		if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
			// CZ SPRINT 74
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))
			->whereIn('cod_com', $comuna)->where('est_cas_fin','<>',1)
			// CZ SPRINT 75
			->where('usuario_id', '=',session()->all()['id_usuario'])->where('vigencia', 1)->groupBy('cas_id')->get();
			// CZ SPRINT 74
			$cantidad_casos = count($cantidad_casos);

		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			// CZ SPRINT 74
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))
				->whereIn('cod_com', $comuna)
				->where('ter_id', '=',session()->all()['id_usuario'])
				->where('est_tera_fin', '<>', 1)
				// CZ SPRINT 75
				->where('vigencia', 1)
				->where(function ($query) {
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
				})
				->groupBy('cas_id')->get();
			

			$cantidad_casos = count($cantidad_casos);
			$desde_terapia = 1;
		
		}

		// ------------------------PERFIL SUPER USUARIO--------------------------

		if (session()->all()['perfil'] == config('constantes.perfil_super_usuario')){

			$cantidad_casos = NNAAlertaManualCaso::select('cas_id', 
				DB::raw('count(cas_id) AS total'))
				->whereIn('cod_com', $comuna)
				->where('est_cas_fin','<>',1)
				->groupBy('cas_id')->get();
				
			$cantidad_casos = count($cantidad_casos);

		}

		$terapeutas = $this->usuario->getTerapeutas();
		
		$acciones = $this->perfil->acciones();

	 	$icono = Funcion::iconos(31);
		
		return view('caso.registrados',
			[
				'terapeutas' => $terapeutas,
				'acciones' => $acciones,
				'cantidad_casos' => $cantidad_casos,
				'desde_terapia' => $desde_terapia,
				'icono' => $icono

			]
		);
		
	}
	
	/**
	 * Devuelve el listado para la grilla de casos por evaluar
	 * @return mixed
	 */
	public function dataCasosRegistrados(){
		$comuna = explode(',',session()->all()['com_cod']);

		if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
			// CZ SPRINT 74
			$casos = CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('est_cas_fin','<>',1)
            ->where(function ($query) {
                $query->where('usuario_id', '=',session()->all()['id_usuario']);
            })->get();
			return Datatables::of($casos)
            ->make(true);
			// CZ SPRINT 74
		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			// CZ SPRINT 74
			$casos = CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('ter_id', '=',session()->all()['id_usuario'])
			->where('est_tera_fin', '<>', 1)
			->where('est_tera_ord', '<', 5)
			->where(function ($query) {
				$query->where('est_cas_fin', '<>', 1);
				$query->orwhere('es_cas_id', '=', 7);//egreso oln
				
			})->get();
			return Datatables::of($casos)->make(true);
			// CZ SPRINT 74
		} else if (session()->all()['perfil'] == config('constantes.perfil_super_usuario')){
			// CZ SPRINT 74
			return Datatables::of(CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('est_cas_fin','<>',1))
            ->make(true);

		}
	}
	
	
	/**
	 * Permite asirnar masivamente un terapeuta a muchos casos
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function asignacionMasiva(Request $request){
		$request->validate([
			'terapeuta_id' => 'required',
			'comentario' => 'required',
		], [], ['terapeuta_id' => 'terapeuta']);
		
		try {
			DB::beginTransaction();
			
			foreach ($request->casos as $id_caso) {
				$this->caso_terapeuta->create([
					'cas_id' => $id_caso,
					'ter_id' => $request->terapeuta_id
				]);
				
				$this->caso_estado->create([
					'cas_id' => $id_caso,
					'est_cas_id' => 4,
					'cas_est_cas_des' => $request->comentario
				]);
				
				$caso = Caso::find($id_caso);
				$caso->est_cas_id = 4;
				$caso->save();
			}
			
			DB::commit();
			
			return redirect()->route('vista.casos.registrados')
				->with('success', 'Se ha asignado el terapeuta a los casos');
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return redirect()->back()->with('danger', $mensaje);
		}
	}
	
	//Inicio Andres F.
	public function envioCorreo(){
		$objDemo = new \stdClass();
		$objDemo->tipo_correo = 'sectorialistas';
		$objDemo->nombre_programa = 'Testing';
		$objDemo->persona = 'Andres Sectorialista';
		

		try{
			Mail::to('afernandez@mmasesorias.cl')->send(new MailController($objDemo));

	  	}catch(\Exception $r){
			  echo 'Excepción: ',  $r->getMessage(), "\n";
	  	}
		echo('proceso finalizado');
	}

	//Fin Andres F.

	/**
	 * Genera la vista de ficha del caso
	 * @param Request $request
	 * @param $origen (1 predictivo, 2 tablas del sistema)
	 * @param $run
	 * @param ApiMdsService $apiMds
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public function ficha(Request $request, $run = null, $idcaso = null, ApiMdsService $apiMds){
		// FIN CZ SPRINT 63 Casos ingresados a ONL
		//INICIO CZ SPRINT 63 
		if($idcaso == null || $run == null ){
				$mensaje = "URL incompleta. Por favor intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
		// FIN CZ SPRINT 63

		try{
			// INICIO CZ SPRINT 62
			$beneficioSemame_Mensaje = "";
			$beneficioSemame_Error = "";
			// FIN CZ SPRINT 62
			$origen_info_nna = "PREDICTIVO";
			$origen_contacto = "sinasignacion"; //verifica q los contactos esten en ai_contacto_parentesco_2
			$direcciones 	 = array();
			$contactos 		 = array();
			$regiones 		 = array();
			$comunas 		 = array();
			$array_contacto_parent = array();
			$array_contacto_insti = array();	
			$disabled_parentesco = true;
			$caso_con_terapia = false;
			$direcciones_adicionales = array();
			// INICIO CZ SPRINT 68
			$array 			= array();
			$arrayH 		= array();
			// INICIO CZ SPRINT 56 BENEFICIOS SENAME
			$arrayS 		= array();
			// FIN CZ SPRINT 56 BENEFICIOS SENAME
			$arrayUB 		= array();
			$arrayHB 		= array();
			// INICIO CZ SPRINT 56 BENEFICIOS SENAME
			$arrayUS 		= array();
			// FIN CZ SPRINT 56 BENEFICIOS SENAME
			$calificacion 	= 0;
			$fecha_act_rsh  = null;
			$rsh ="";
			$rshEstado ="";
			// FIN CZ SPRINT 68
			$run_dv = Rut::set($run)->calculateVerificationNumber(); 
			$val_info = $this->validarPredictivoPersonaCasoAlertas($run, $run_dv);
			if ($val_info["persona"] == false){
				
				//Se busca información de NNA en tabla predictivo
				$predictivo = $this->caso->informacionNNAPredictivo($run);
				
				if (!$predictivo){
					$mensaje = "No se encontro información del NNA consultado. Por favor intente nuevamente.";

					return view('layouts.errores')->with(['mensaje'=>$mensaje]);
				}

				//Se aplica color al score
				$data = $predictivo[0];
				$data->color = aplicarColor($data->score);
				// INICIO CZ SPRINT 68
				$direcciones = $this->obtenerDirecciones($data);
				$array_contacto_parent = $this->alerta_contacto_parent($run);
				$array_contacto_insti = $this->alerta_contacto_insti($run);
				$contactos = $this->contactoRIS($run,$data);
				// FIN CZ SPRINT 68
				//Obtenemos el ID de las comunas asociadas al usuario logeado
				$comunas_usuario = "";
				$lista_comuna_usuario = $this->usuario_comuna->buscarComunasUsuario(session('id_usuario'));
			
				//Validamos que la comuna del NNA se encuentre dentro de las asignadas del usuario logeado
				foreach($lista_comuna_usuario as $valor){
					if ($valor->com_cod != "" && isset($valor->com_cod) && $valor->com_cod == $data->dir_com_1) $comunas_usuario = $valor->com_id;
				}

			}else if ($val_info["persona"] == true){
				$origen_info_nna = "PERSONA";
				// INICIO CZ SPRINT 69
				if($idcaso != 0){
					$persona 		 = $this->caso->informacionNNAPersona($run, $idcaso);
				if (!$persona){
					$mensaje = "No se encontro información del NNA consultado. Por favor intente nuevamente.";

					return view('layouts.errores')->with(['mensaje'=>$mensaje]);
				}
				
					//Se aplica color al score
					$data = $persona[0];

					//Obtenemos el ID de las comunas asociadas al usuario logeado
					$comunas_usuario = "";
					$lista_comuna_usuario = $this->usuario_comuna->buscarComunasUsuario(session('id_usuario'));
					//Validamos que la comuna del NNA se encuentre dentro de las asignadas del usuario logeado
					foreach($lista_comuna_usuario as $valor){
						if ($valor->com_cod != "" && isset($valor->com_cod) && $valor->com_cod == $data->com_cod){
							$comunas_usuario = $valor->com_id;
						}
					}
				}else{
						//Se busca información de NNA en tabla predictivo
					$predictivo = $this->caso->informacionNNAPredictivo($run);
					
					if (!$predictivo){
						$mensaje = "No se encontro información del NNA consultado. Por favor intente nuevamente.";

						return view('layouts.errores')->with(['mensaje'=>$mensaje]);
					}

					//Se aplica color al score
					$data = $predictivo[0];
					$data->color = aplicarColor($data->score);
					// INICIO CZ SPRINT 68
					$direcciones = $this->obtenerDirecciones($data);
					$array_contacto_parent = $this->alerta_contacto_parent($run);
					$array_contacto_insti = $this->alerta_contacto_insti($run);
					$contactos = $this->contactoRIS($run,$data);
					// FIN CZ SPRINT 68
					//Obtenemos el ID de las comunas asociadas al usuario logeado
					$comunas_usuario = "";
					$lista_comuna_usuario = $this->usuario_comuna->buscarComunasUsuario(session('id_usuario'));
				
					//Validamos que la comuna del NNA se encuentre dentro de las asignadas del usuario logeado
					foreach($lista_comuna_usuario as $valor){
						if ($valor->com_cod != "" && isset($valor->com_cod) && $valor->com_cod == $data->dir_com_1) $comunas_usuario = $valor->com_id;
					}
				}
				// FIN CZ SPRINT 69

				//Inicio Andres F.
				$sel_contact_parent = DB::select("select d.periodo, d.run, d.fecha_ingreso, d.fuente, d.nombre_contacto, d.parentesco,
				d.numero_contacto, d.tipo_numero, d.orden_contacto, d.tipo_dato, d.comuna, d.categoria, f.com_nom
				from ai_contacto_parentesco_2 d left join ai_comuna f on (d.comuna = f.com_cod)
				WHERE d.run =".$run);

				if (count($sel_contact_parent) == 0){
					$contact_alerta_parentesco = DB::select("select * from ai_alerta_contacto_parentesco where run = ".$run);
					if (count($contact_alerta_parentesco) > 0){
						$this->traspasoContactoParentesco2($run);
					}
				}	
		
				//Se hace primero validación de que ai_contacto_parentesco cuando se esta cargando la ficha
				//una vez que se actualice la tabla ai_contacto_parentesco_2 y se vuelva a preguntar por la 
				//información en esa tabla, entonces se podrán cargar los datos requeridos

				//Fin Andres F.
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
				if($idcaso == 0){
					$data->cas_id = null;
					// INICIO CZ SPRINT 69
					$data->estado = null;
					// FIN CZ SPRINT 69	
				}else{ 
					$caso = Caso::find($idcaso);
					$data->cas_id = $idcaso;
					$data->estado = $caso->est_cas_id;
					$data->score = $caso->cas_sco;
					$data->cas_doc_cons = $caso->cas_doc_cons;
					$data->est_pau = $caso->cas_est_pau;
					// INICIO CZ SPRINT 68
					$datosPersona = DatosPersona::where('per_id', "=",$data->per_id)->where('cas_id', "=", $caso->cas_id)->first();
					// INICIO CZ SPRINT 69
					if(count($datosPersona) > 0){
					$data->per_nom = $datosPersona->per_nom;
					$data->per_pat = $datosPersona->per_pat;
					$data->per_mat = $datosPersona->per_mat;
					// INICIO CZ SPRINT 69
					$data->nombre = $datosPersona->per_nom ." " .$datosPersona->per_pat . " " . $datosPersona->per_mat;
					$data->edad_ani = $datosPersona->per_ani;
					$data->edad_mes = $datosPersona->per_mes;
					$data->sexo = $datosPersona->per_sex;
					// FIN CZ SPRINT 69
					}
					// FIN CZ SPRINT 69	
					$liceo = Liceo::where('per_id',"=",$data->per_id)->where('cas_id', "=",$data->cas_id)->first();
					if(count($liceo) != 0){
						$data->per_COD_GRA = $liceo->RBD_COD_GRA;
						$data->per_COD_ENS = $liceo->RBD_COD_ENS;
						$data->per_GRA_LET = $liceo->RBD_GRA_LET;
					}
					// FIN CZ SPRINT 68
				}
				// FIN CZ SPRINT 63 Casos ingresados a ONL

				//dd($data);
				$data->color = aplicarColor($data->score);
				//INICIO CZ SPRINT 60
				// INICIO CZ SPRINT 68
				if($idcaso != 0){
					$direcciones = $this->obtenerDireccion($data);	
				// INICIO CZ SPRINT 69
				}else{
					$persona_perdictivo = Predictivo::where('run', $run)->first();
					$direcciones = $this->obtenerDirecciones($persona_perdictivo);
							}	
				// FIN CZ SPRINT 69
				// FIN CZ SPRINT 68
				$disabled_parentesco = false;	
				// INICIO CZ SPRINT 68 
				$array_contacto_parent = $this->contacto_parentesco_2($run);
				$array_contacto_insti = $this->contacto_parentesco_insti_2($run);
				
				$contactos = $this->obtenerContacto($data->per_id);
				// FIN CZ SPRINT 68
				//dd($contactos, count($contactos));

				$val_caso_con_terapia = $this->caso->informacionNNATerapia($idcaso);
				
				if (count($val_caso_con_terapia) > 0) $caso_con_terapia = true;				
			}

			try{
			  	$rsh = $apiMds->getRsh($data->run);
				//   INICIO CZ SPRINT 68
			$rshEstado = $rsh->estado;

			if ($rsh->estado == 200){
				if (!is_null($rsh->grupo) && $rsh->grupo != ""){
				 $grupo = (array) $rsh->grupo;	
				 $calificacion   = $rsh->grupo->cse;
				 $fecha_act_rsh  = date("d/m/Y", strtotime($grupo["Fecha Ingreso"]));
				}
	  
				foreach ($rsh->integrantes as $key => $value) {		
					
					$fechaNacimiento = CasoController::transformarFecha($value->{'Fecha Nacimiento'});	
					$edad = CasoController::calculaedad($fechaNacimiento);
				
					$ultimosBeneficios 	= CasoController::ultimosBeneficios($value->Run);
					$ultimosBeneficios 	= json_decode($ultimosBeneficios,true);
	  
					$estadoBenf 		= $ultimosBeneficios["Estado"];
					$EstadoConsulta 	= $ultimosBeneficios["EstadoConsulta"];
	  
					$HistoricoBeneficios = CasoController::HistoricoBeneficios($value->Run);
					$HistoricoBeneficios = json_decode($HistoricoBeneficios,true);
					$estadoHist = $HistoricoBeneficios["Estado"];
					$EstadoConsultaH = $HistoricoBeneficios["EstadoConsulta"];
	  
					//INICIO CZ SPRINT 56 BENEFICIO SENAME
					// INCIO CZ SPRINT 61 BENEFICIO SENAME DESCOMENTADO
					$senameBeneficios = CasoController::senameBeneficios($value->Run);
					$senameBeneficios = json_decode($senameBeneficios,true);
					$EstadoConsultaSename = $senameBeneficios["EstadoConsulta"];
					// FIN CZ SPRINT 61 BENEFICIO SENAME DESCOMENTADO
					//FIN CZ SPRINT 56 BENEFICIO SENAME
	  
					if($estadoBenf == 1){
						$beneficios = $ultimosBeneficios["beneficios"];
	  
						foreach ($beneficios as $b){
								array_push($array, array( 
									"id_program"           => $b["id_programa"],
									"fecharecepcionultben" => $b["fecharecepcionultben"],
									"nombre_programa"      => $b["nombre_programa"],
									"montoultben"          => $b["montoultben"])
							);
						}
					}
					if($estadoHist == 1){
						$beneficiosHist = $HistoricoBeneficios["beneficios"];
	  
						foreach ($beneficiosHist as $h){
								array_push($arrayH, array( 
									"id_programa"     => $h["id_programa"],
									"fecha_recepcion" => $h["fecha_recepcion"],
									"monto"           => $h["monto"],
									"nombre_programa" => $h["nombre_programa"])
							);
						}
					}
					//INICIO CZ SPRINT 56 BENEFICIO SENAME
					//INICIO CZ SPRINT 61 BENEFICIO SENAME DESCOMENTADO
						if($EstadoConsultaSename != 0){
							$beneficiosSenam = $senameBeneficios["datos"];			
							foreach ($beneficiosSenam  as $s){
									array_push($arrayS, array( 
										"RUN"     => $s["RUN"],
										"NOMBRES" => $s["NOMBRES"],
										"APELLIDO_PATERNO"           => $s["APELLIDO_PATERNO"],
										"APELLIDO_MATERNO" => $s["APELLIDO_MATERNO"],
										"FECHA_INGRESO" => $s["FECHA_INGRESO"],
										"FECHA_EGRESO" => $s["FECHA_EGRESO"],
										"NOMBREPROYECTO" => $s["NOMBREPROYECTO"],
										"TIPO_PROYECTO" => $s["TIPO_PROYECTO"],
										"MODELO" => $s["MODELO"],
									
									)	
								);
							}
						}
						
						// INICIO CZ SPRINT 62
						if($EstadoConsultaSename == 0){
							$beneficioSemame_Mensaje = $senameBeneficios["Mensaje"];
							$beneficioSemame_Error = $senameBeneficios["Error"];
						}
						// FIN CZ SPRINT 62
						
					//INICIO CZ SPRINT 61 BENEFICIO SENAME DESCOMENTADO
					//FIN CZ SPRINT 56 BENEFICIO SENAME
					$parentesco = substr($value->Parentesco,7);
	  
					array_push($arrayUB, array( 
						 "EstadoConsulta" => $EstadoConsulta,
						 "run" 			  => $value->Run,
						 "Parentesco"	  => $parentesco,
						 "estado"         => $estadoBenf,
						 "beneficios"     => $array
						));
					
					$array=[];
	  
					array_push($arrayHB, array( 
						"EstadoConsulta" => $EstadoConsultaH,
						"run" 			 => $value->Run,
						"Parentesco"	 => $parentesco,
						"estado"         => $estadoHist,
						"beneficios"     => $arrayH
						));
	  
					//INICIO CZ SPRINT 56 BENEFICIOS SENAME 
					// INICIO CZ SPRINT 61 BENEFICIOS SENAME DESCOMENTADO
						if($EstadoConsultaSename != 0){
							$Nro_registrosSename = $senameBeneficios["Nro_registros"];
							array_push($arrayUS, array( 
								"EstadoConsulta" => $EstadoConsultaSename,
								"run" 			 => $value->Run,
								"Parentesco"	 => $parentesco,
								"beneficiosSename" => $arrayS,
								"EDAD" => $edad,
								"Nro_registros" =>$Nro_registrosSename,
								));
						}else{
							array_push($arrayUS, array( 
								"EstadoConsulta" => $EstadoConsultaSename,
								"run" 			 => $value->Run,
								"Parentesco"	 => $parentesco,
								"beneficiosSename" => $arrayS,
								"EDAD" => $edad,
								"Nro_registros" =>0,
								));	
						}
					//FIN CZ  SPRINT 61 BENEFICIOS SENAME DESCOMENTADO
					//FIN CZ  SPRINT 56 BENEFICIOS SENAME
					$arrayH=[];
				}	
			}
			//FIN CZ SPRINT 68
			}catch(\Exception $r){
				$mensaje = "Hubo un error al momento de consultar el RUN en el Registro Social de Hogares. Por favor intente nuevamente.";

				// return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			// Log::error('(Ficha NNA / Beneficios / RSH ): [Estado => '.$rsh->estado.', Mensaje => '.$rsh->mensaje.']');

			$mapaUrl = config('constantes.sit_url').'?mapId='.config('constantes.sit_mapid')
				.'&serId='.config('constantes.sit_serid')
				.'&ext='.config('constantes.sit_ext')
				.'&regExt='.config('constantes.sit_regext')
				.'&token='.$request->user()->token
				.'&usuId='.$request->user()->run;
			
			$acciones = $this->perfil->acciones();
			

			//$obj = new Region();
			$regiones = Region::all();

			$provincias = Provincia::all();
			
			$comunas = Comuna::all();

			$direcciones_adicionales = DB::select("SELECT * FROM ai_direccion_adicionales d 
										LEFT JOIN ai_comuna c ON d.dir_com = c.com_id
										LEFT JOIN ai_provincia p ON c.pro_id = p.pro_id
										LEFT JOIN ai_region r ON p.reg_id = r.reg_id
										WHERE d.run =".$run);


			$codigo_ensenanza = CodigoEnsenanza::find($data->cod_ens);
			$nombre_ensenanza = ($codigo_ensenanza)?$codigo_ensenanza->nivel_nombre:'Sin información.';
			$editar = FALSE;
			if(session("tipo_perfil") == "gestor"){$editar = TRUE;}

			$historial_pausa =  DB::select(" select u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre,a.cas_id,to_char(fec_ing,'dd-mm-yyyy HH24:MI:SS')fec_ing, usu_id, estado, comentario 
				 from ai_caso_bit_pau  a left join ai_usuario u on a.usu_id=u.id 
				 where a.cas_id='".$data->cas_id."'");
						
		
			// INICIO CZ SPRINT 60			
			if($data->estado){
			$est_cas_fin = EstadoCaso::getVerificarEstado($idcaso);
			}else{
				$est_cas_fin = "";
			}
			// FIN CZ SPRINT 60
			return view("ficha.main",
				[
					'caso' 				=> $data,
					'run'				=> $run,
					//'gestores'	    	=> $gestores,
					'origen_info_nna'  	=> $origen_info_nna,
					'origen_contacto'	=> $origen_contacto,
					'direcciones'		=> $direcciones,
					// INICIO CZ SPRINT 60
					'est_cas_fin' => $est_cas_fin,
					//FIN CZ SPRINT 60
					'regiones'			=> $regiones,
					'provincias'		=> $provincias,
					'comunas'			=> $comunas,
					'contactos'			=> $contactos,
					'contact_parent'	=> $array_contacto_parent,
					'contact_insti'		=> $array_contacto_insti,
					'disabled'			=> $disabled_parentesco,
					//'array_parentesto'	=> $array_sel_parentesco,
					//'nivel'				=> $nivel,
					'rsh'   			=> $rsh,
					'mapaUrl'			=> $mapaUrl,
					'acciones'			=> $acciones,
					'arrayUB'			=> $arrayUB,
					'arrayHB'			=> $arrayHB,
					// INICIO CZ SPRINT 56
					'arrayUS'			=> $arrayUS,
					// FIN CZ SPRINT 56
					'rshEstado'			=> $rshEstado,
					'calificacion'		=> $calificacion,
					'nombre_codigo_ens'	=> $nombre_ensenanza,
					'editar'			=> $editar,
					'direcciones_adicionales' => $direcciones_adicionales,
					'caso_con_terapia' => $caso_con_terapia,
					'fecha_act_rsh'    => $fecha_act_rsh,
					'historial_pausa'  => $historial_pausa,
					// INICIO CZ SPRINT 62
					'beneficioSename_Error' => $beneficioSemame_Error,
					'beneficioSename_Mensaje' => $beneficioSemame_Mensaje
					// FIN CZ SPRINT 62
				]);
		} catch(\Exception $e){
			Log::error('error: '.$e);
			//INICIO CZ SPRINT 66
			$mensaje = "Ocurrio un error al momento de cargar los datos de la ficha, intente nuevamente.";
			// FIN CZ SPRINT 66
			return view('layouts.errores')->with(['mensaje'=>$e]);
		}
	}
	// INICIO CZ SPRINT 68
	public function contactoRIS($run,$data){
		$contactos 		 = array();  
		//Se recopila información de contacto 1
		if (!is_null($data->info_nom_contacto_1) && $data->info_nom_contacto_1 != "" &&
		  !is_null($data->info_app_contacto_1) && $data->info_app_contacto_1 != "" &&
		  !is_null($data->info_apm_contacto_1) && $data->info_apm_contacto_1 != "" &&
		  !is_null($data->info_num_contacto_1) && $data->info_num_contacto_1 != "" ){

		  $contacto_uno = (object) [
			'con_nom' => $data->info_nom_contacto_1,
			'con_pat' => $data->info_app_contacto_1,
			'con_mat' => $data->info_apm_contacto_1,
			'con_tlf' => $data->info_num_contacto_1,
			'con_par' => null,
			'con_ori' => 'RIS'
		  ];
	  
		  $contactos[] 	= $contacto_uno;
		}
	  
		//Se recopila información de contacto 2
		if (!is_null($data->info_nom_contacto_2) && $data->info_nom_contacto_2 != "" &&
		  !is_null($data->info_app_contacto_2) && $data->info_app_contacto_2 != "" &&
		  !is_null($data->info_apm_contacto_2) && $data->info_apm_contacto_2 != "" &&
		  !is_null($data->info_num_contacto_2) && $data->info_num_contacto_2 != "" ){
	  
		  $contacto_dos = (object) [
			'con_nom' => $data->info_nom_contacto_2,
			'con_pat' => $data->info_app_contacto_2,
			'con_mat' => $data->info_apm_contacto_2,
			'con_tlf' => $data->info_num_contacto_2,
			'con_par' => null,
			'con_ori' => 'RIS'
		  ];
	  
		  $contactos[] 	= $contacto_dos;
		}
		return  $contactos;
	}

	public function alerta_contacto_parent($run){
		$array_contacto_parent = array();
		$sel_contact_parent = DB::select("select d.periodo, d.run, d.fecha_ingreso, d.fuente, d.nombre_contacto, d.parentesco,
						d.numero_contacto, d.tipo_numero, d.orden_contacto, d.tipo_dato, d.comuna, f.com_nom
						from ai_alerta_contacto_parentesco d left join ai_comuna f on (d.comuna = f.com_cod)
						WHERE d.tipo_dato = 1 and d.run =".$run);
												
		if (count($sel_contact_parent) > 0){
			foreach ($sel_contact_parent as $key => $value) {
				$array_contacto_parent[] = $value;	
			}
		}
		return $array_contacto_parent;
	}	

	public function  alerta_contacto_insti($run){
		// INICIO CZ SPRINT 69
		$array_contacto_insti = array();
		// FIN CZ SPRINT 69
		$sel_contact_parent = DB::select("select d.periodo, d.run, d.fecha_ingreso, d.fuente, d.nombre_contacto, d.parentesco,
					d.numero_contacto, d.tipo_numero, d.orden_contacto, d.tipo_dato, d.comuna, f.com_nom
					from ai_alerta_contacto_parentesco d left join ai_comuna f on (d.comuna = f.com_cod)
					WHERE d.tipo_dato != 1 and d.run =".$run);
											
		if (count($sel_contact_parent) > 0){
			foreach ($sel_contact_parent as $key => $value) {
				$array_contacto_insti[] = $value;												
			}
		}
		return 	$array_contacto_insti;
	}
		
	public function obtenerDireccion($data){
		$dir = DB::select("SELECT * FROM ai_direccion d LEFT JOIN ai_comuna c ON d.com_id = c.com_id WHERE d.per_id = ".$data->per_id." and d.cas_id= ".$data->cas_id."ORDER BY dir_ord");
		$direcciones 	 = array();
		foreach ($dir AS $c1 => $v1){
			$zona 		= "";
			$direccion 	= "";

			//Se busca información de dirección

			$zona = Comuna::with('provincias.regiones')->where('com_cod', $v1->com_cod)->get();
			// INICIO CZ SPRINT 60
			$varCheck = "";
			$valorinput = 0;
			if($v1->dir_status == 1){
				$varCheck = "checked";
				$valorinput = 1;
			}
			// FIN CZ SPRINT 60
			$direccion = (object) [
				'dir_dep'=>null, 
				'dir_call'=>$v1->dir_call, 
				'dir_num'=>$v1->dir_num,
				'dir_id'=>$v1->dir_id, 
				'dir_cod_id'=>$v1->dir_cod_id,
				'dir_status'=>$v1->dir_status,
				'dir_fue'=>$v1->dir_fue?$v1->dir_fue:$data->dir_fue,
				'dir_fecha'=>$v1->dir_fecha?$v1->dir_fecha:$data->dir_fecha,
				'comunas'=>(object)['com_nom'=>$zona[0]->com_nom,
				'provincias'=>(object)['pro_nom'=>$zona[0]->provincias->pro_nom,
				'regiones'=>(object)['reg_nom'=>$zona[0]->provincias->regiones->reg_nom]]],
				'completa'=>$v1->dir_call.' '.$v1->dir_num.', '.$zona[0]->com_nom.', '.$zona[0]->provincias->pro_nom.', '.$zona[0]->provincias->regiones->reg_nom, 
				// INICIO CZ SPRINT 60
				'inputDireccion' => $varCheck,
				'valorinput' => $valorinput
				// FIN CZ SPRINT 60
			];
			array_push($direcciones, $direccion);
		}
		return 	$direcciones;
	}

	public function contacto_parentesco_2($run){
		$array_contacto_parent = array();
		$sel_contact_parent = DB::select("select d.periodo, d.run, d.fecha_ingreso, d.fuente, d.nombre_contacto, d.parentesco,
						d.numero_contacto, d.tipo_numero, d.orden_contacto, d.tipo_dato, d.comuna, d.categoria, f.com_nom
						from ai_contacto_parentesco_2 d left join ai_comuna f on (d.comuna = f.com_cod)
						WHERE d.tipo_dato = 1 and d.run =".$run);
		
		if (count($sel_contact_parent) > 0){
			//$direccion = new Direccion;
			$origen_contacto = "aicontactoparentesco2";
			foreach ($sel_contact_parent as $key => $value) {
				if(is_null($value->categoria)){
					$value->categoria = 1;
				}
				$array_contacto_parent[] = $value;											
			}
		}
		return $array_contacto_parent;
	}
		
	public function contacto_parentesco_insti_2($run){
		$array_contacto_insti = array();	
		$sel_contact_parent = DB::select("select d.periodo, d.run, d.fecha_ingreso, d.fuente, d.nombre_contacto, d.parentesco,
					d.numero_contacto, d.tipo_numero, d.orden_contacto, d.tipo_dato, d.comuna, d.categoria, f.com_nom
					from ai_contacto_parentesco_2 d left join ai_comuna f on (d.comuna = f.com_cod)
					WHERE d.tipo_dato != 1 and d.run =".$run);
	
		if (count($sel_contact_parent) > 0){
			//$direccion = new Direccion;
			$origen_contacto = "aicontactoparentesco2";
			foreach ($sel_contact_parent as $key => $value) {
					if(is_null($value->categoria)){
					$value->categoria = 1;
				}	
					$array_contacto_insti[] = $value;												
			}
		}
		return $array_contacto_insti;
	}

	public function obtenerContacto($data){
		$contactos 		 = array();

		$listar_contactos = Contacto::where("per_id", $data)->orderBy('con_con')->get(); 

		foreach ($listar_contactos AS $c2 => $v2){
			$contacto = "";

			$parentesco = "";
			if (!is_null($v2->con_par) && $v2->con_par != ""){
				$listar_parentesco = ParentescoGrupoFamiliar::find($v2->con_par);
				if (count($listar_parentesco) > 0) $parentesco = $listar_parentesco->par_gru_fam_nom;
			}

			$con_fec_fue = null;

			//dd($v2->con_fec_fue);

			if(!is_null($v2->con_fec_fue)){

				$con_fec_fue = date("d/m/Y", strtotime($v2->con_fec_fue));

			}

			$contacto = (object) [
				'con_id'  => $v2->con_id,
				'con_nom' => $v2->con_nom,
				'con_pat' => $v2->con_pat,
				'con_mat' => $v2->con_mat,
				'con_tlf' => $v2->con_tlf,
				'con_fue' => $v2->con_fue,
				'con_fec_fue' => $con_fec_fue,
				'con_par' => $parentesco,
				//'con_par' => $v2->con_par,
				'con_ori' => $v2->con_ori
			];

			array_push($contactos, $contacto);
		}

		return $contactos;
	}

	public function obtenerDirecciones($data){
		$direcciones 	 = array();
		if (!is_null($data->dir_com_1) && $data->dir_com_1 != "" &&
			!is_null($data->dir_calle_1) && $data->dir_calle_1 != "" &&
			!is_null($data->dir_num_1) && $data->dir_num_1 != ""){
			//Se busca información de dirección 1
			$zona_1 = Comuna::with('provincias.regiones')->where('com_cod',$data->dir_com_1)->get();

			$direccion_1 = (object) [
				//INICIO CZ SPRINT 58 
				'dir_id' => '',
				//FIN CZ SPRINT 58 
				'dir_dep'=>null, 'dir_call'=>$data->dir_calle_1, 'dir_num'=>$data->dir_num_1,
				'dir_fue'=>$data->dir_fuente_1,'dir_fecha'=>$data->dir_fecha_ingr_1,
				'comunas'=>(object)['com_nom'=>$zona_1[0]->com_nom,
				'provincias'=>(object)['pro_nom'=>$zona_1[0]->provincias->pro_nom,
				'regiones'=>(object)['reg_nom'=>$zona_1[0]->provincias->regiones->reg_nom]]],
				'completa'=>$data->dir_calle_1.' '.$data->dir_num_1.', '.
				$zona_1[0]->com_nom.', '.$zona_1[0]->provincias->pro_nom.', '.
				$zona_1[0]->provincias->regiones->reg_nom
			];

			$direcciones[0] = $direccion_1;
		}				
		if (!is_null($data->dir_com_2) && $data->dir_com_2 != "" &&
			!is_null($data->dir_calle_2) && $data->dir_calle_2 != "" &&
			!is_null($data->dir_num_2) && $data->dir_num_2 != ""){
			//Se busca información de dirección 2
			$zona_2 = Comuna::with('provincias.regiones')->where('com_cod',$data->dir_com_2)->get();
		
			$direccion_2 = (object) [
				//INICIO CZ SPRINT 58 
				'dir_id' => '',
				//FIN CZ SPRINT 58 
				'dir_dep'=>null,'dir_call'=>$data->dir_calle_2, 'dir_num'=>$data->dir_num_2,
				'dir_fue'=>$data->dir_fuente_2,'dir_fecha'=>$data->dir_fecha_ingr_2,
				'comunas'=>(object)['com_nom'=>$zona_2[0]->com_nom,
				'provincias'=>(object)['pro_nom'=>$zona_2[0]->provincias->pro_nom,
				'regiones'=>(object)['reg_nom'=>$zona_2[0]->provincias->regiones->reg_nom]]],
				'completa'=>$data->dir_calle_2.' '.$data->dir_num_2.', '.
				$zona_2[0]->com_nom.', '.$zona_2[0]->provincias->pro_nom.', '.
				$zona_2[0]->provincias->regiones->reg_nom
			];

			$direcciones[1] = $direccion_2;
		}

		if (!is_null($data->dir_com_3) && $data->dir_com_3 != "" &&
			!is_null($data->dir_calle_3) && $data->dir_calle_3 != "" && 
			!is_null($data->dir_num_2) && $data->dir_num_2 != ""){
			//Se busca información de dirección 3
			$zona_3 = Comuna::with('provincias.regiones')->where('com_cod',$data->dir_com_3)->get();
			
			$direccion_3 = (object) [
				//INICIO CZ SPRINT 58 
				'dir_id' => '',
				//FIN CZ SPRINT 58 
				'dir_dep'=>null,'dir_call'=>$data->dir_calle_3, 'dir_num'=>$data->dir_num_2,
				'dir_fue'=>$data->dir_fuente_3,'dir_fecha'=>$data->dir_fecha_ingr_3,
				'comunas'=>(object)['com_nom'=>$zona_3[0]->com_nom,
				'provincias'=>(object)['pro_nom'=>$zona_3[0]->provincias->pro_nom,
				'regiones'=>(object)['reg_nom'=>$zona_3[0]->provincias->regiones->reg_nom]]],
				'completa'=>$data->dir_calle_3.' '.$data->dir_num_3.', '.
				$zona_3[0]->com_nom.', '.$zona_3[0]->provincias->pro_nom.', '.
				$zona_3[0]->provincias->regiones->reg_nom
			];

			$direcciones[2] = $direccion_3;
		}
		return $direcciones;
	}

	// FIN CZ SPRINT 68

	//INICIO CZ SPRINT 60
	public function actualizarEstadoDireccion(Request $request){
			$status = Direccion::find($request->id);
			// INICIO CZ SPRINT 69
			DB::update("Update  ai_direccion set dir_status = 0 where per_id = {$status->per_id} and cas_id = {$status->cas_id}");
			// FIN CZ SPRINT 69
			$status->dir_status = $request->estado;
			$status->save(); 
	
		if (!$status){
			$mensaje = "Error al momento de actualizar el dirección en BD. Por favor intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		DB::commit();

		return response()->json(array('estado' => '1', 'mensaje' => 'Dirreccón actualizado con exitosamente.'),200);
	}
	//FIN CZ SPRINT 60 
	/**
	 * @param $origen
	 * @param $run
	 * @return \Illuminate\Http\JsonResponse
	 */
	// public function fichaRapida($run){
	// 	try{
	// 		$respuesta = array();
			
	// 		$caso = $this->caso->origen_1($run);
	// 		if (!$caso) throw $caso;
			
	// 		$comuna = Comuna::where('com_cod', $caso[0]->dir_com_1)->get();
	// 		$caso[0]->dir_com_nom_1     = $comuna[0]->com_nom;
	// 		$respuesta["datos_basicos"] = $caso[0];
			
	// 		$mensaje = "Recolección de datos de NNA fue realizada con éxito.";
	// 		return response()->json(array('estado' => '1', 'respuesta' => $respuesta, 'mensaje' => $mensaje), 200);
			
	// 	}catch(\Exception $e){
	// 		$mensaje = "Error al momento de recolectar datos de NNA. Por favor intentar nuevamente.";
	// 		return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
	// 	}
	// }
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function agregarDireccion(Request $request){
		try{	
			if (!isset($request->per_id) || $request->per_id == ""){
				$mensaje = "No se encuentra ID de Persona. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->com_id) || $request->com_id == ""){
				$mensaje = "No se encuentra ID de la Comuna de la Dirección ingresada. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if(config('constantes.activar_maestro_direcciones')){
				$com = Comuna::where("com_cod",$request->com_id)->first();
				$com_id = $com->com_id;
			}else{
				$com_id = $request->com_id;
			}

			DB::beginTransaction();
		
			$direcciones= Direccion::where('per_id',$request->per_id)->orderBy('dir_ord')->get();

			$prioridadEscalar = $request->prioridad;
			foreach ($direcciones as $direc){
				if($direc->dir_ord >= $prioridadEscalar){
					$prioridadEscalar++;

					$direccion = Direccion::find($direc->dir_id);
					$direccion->dir_ord = $prioridadEscalar;
					$respuesta = $direccion->save();
					if (!$respuesta){
						DB::rollback();
						$mensaje = "Hubo un error al momento de registrar la Dirección. Por favor verifique e intente nuevamente.";
				
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
					}
			 	}
			}
			// INICIO CZ SPRINT 68
			$max = Direccion::max('dir_id');
			$registrar = new Direccion();
			$registrar->dir_id = $max+1;
			// FIN CZ SPRINT 68
			$registrar->per_id = $request->per_id;		
			$registrar->com_id = $com_id;		
			$registrar->dir_ord = $request->prioridad;		
			$registrar->dir_fue = "SAN";		
			$registrar->dir_call = $request->dir_call;		
			$registrar->dir_num = $request->dir_num;		
			$registrar->dir_dep = $request->dir_dep;		
			$registrar->dir_des = $request->dir_des;		
			$registrar->dir_sit = $request->dir_sit;		
			$registrar->dir_block = $request->dir_block;		
			$registrar->dir_casa = $request->dir_casa;
			$registrar->dir_cod_id = $request->dir_cod_id;
			// INICIO CZ SPRINT 68
			$registrar->cas_id = $request->cas_id;
			// FIN CZ SPRINT 68
			$registrar->dir_fecha = Carbon::now();		

			$respuesta = $registrar->save();
			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la Dirección. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}	

			// cambio estado direccion 
			if ((config('constantes.activar_maestro_direcciones')) && ($request->dir_cod_id != null)){
				$cambio_est_dir = $this->cambioVigenciaDireccion($request->dir_cod_id, $request->nna_run);
				if ($cambio_est_dir["status"] != 1){
					DB::rollback();
	                $mensaje = "Hubo un error al cambiar el estado de vigencia de la dirección. Por favor intente nuevamente o contacte con el Administrador.";
	                
	                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			}

			DB::commit();

			$mensaje = "Dirección registrada con éxito.";
			
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		} catch(\Exception $e) {
			DB::rollback();

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	// INICIO CZ SPRINT 56 BENEFICIOS SENAME
	function calculaedad($fechanacimiento){
		list($dia,$mes,$ano) = explode("-",$fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		  $ano_diferencia--;
		return $ano_diferencia;
	}
	//FIN CZ SPRINT 56 BENEFICIOS SENAME 
	
	function transformarFecha($fecha){
		$y = substr( $fecha, 0, 4 );
		$m = substr( $fecha, 4, 2 );
		$d = substr( $fecha, 6, 2 );
		return date( 'd-m-Y', mktime( 0, 0, 0, $m, $d, $y ) );
	}
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function agregarContacto(Request $request){
		$fecha = date_create();
		$fecha_ingreso = date_timestamp_get($fecha);
	
		$ordenContactos = DB::select("SELECT max(orden_contacto) as maximo FROM ai_contacto_parentesco_2 WHERE RUN = ".$request->run);
		
		if (is_null($ordenContactos[0]->maximo) || ($ordenContactos[0]->maximo == '')){
			$ordenContactos[0]->maximo = 1;
		}
		else
		$ordenContactos[0]->maximo++;
		
		/*echo('aqui');
		print_r($ordenContactos);die();*/
		DB::beginTransaction();
		//INICIO CZ SPRINT 58 
		// $resultado =  DB::insert("INSERT INTO AI_CONTACTO_PARENTESCO_2 (periodo, run, fecha_ingreso, fuente, nombre_contacto,
		// parentesco, numero_contacto, tipo_numero, orden_contacto, tipo_dato, comuna, categoria)
		// VALUES (".$request->periodo.",".$request->run.",".$fecha_ingreso.",'".$request->fuente."','".$request->nombrecomp."','".$request->parentesco."','".$request->telefono."', 
		// ".$request->tipo_num.",".$ordenContactos[0]->maximo.",".$request->tipo_dato.", '".$request->comuna."', ".$request->id_categoria.")");

		$ContactoParentesco2 = new ContactoParentesco2();
		$ContactoParentesco2->periodo = $request->periodo;
		$ContactoParentesco2->run = $request->run;
		$ContactoParentesco2->fecha_ingreso = $fecha_ingreso;
		$ContactoParentesco2->fuente = $request->fuente;
		$ContactoParentesco2->nombre_contacto = $request->nombrecomp;
		$ContactoParentesco2->parentesco = $request->parentesco;
		$ContactoParentesco2->numero_contacto = $request->telefono;
		$ContactoParentesco2->tipo_numero = $request->tipo_num;
		$ContactoParentesco2->orden_contacto = $ordenContactos[0]->maximo;
		$ContactoParentesco2->tipo_dato = $request->tipo_dato;
		$ContactoParentesco2->comuna = $request->comuna;
		$ContactoParentesco2->categoria = $request->id_categoria;
		$resultado = $ContactoParentesco2->save();
		// FIN CZ SPRINT 58 
		if (!$resultado){
			DB::rollback();
				// INIICIO CZ SPRINT 67
				return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run, 'idcaso' => $request->cas_id])
				->with('danger', 'Ocurrio un Error Guardando Contacto, Por Favor Verifique.');
				// FIN CZ SPRINT 67
		}
	
		DB::commit();
		// INIICIO CZ SPRINT 67
		return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run, 'idcaso' => $request->cas_id])
			->with('success', 'El contacto '.$request->nombres.' '.$request->paterno.' ha sido agregado.');
		// FIN CZ SPRINT 67
	}
	
	/**
	 * Realiza la accion de verificar un caso, tambien pasa toda la informacion del predictivo a las tablas del sistema
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function verificar(Request $request){
		$request->validate(['comentario' => 'required']);
		
		try{
			DB::beginTransaction();
		
			//if ($request->origen==1){//predictivo
				$datos = Predictivo::where('run',$request->run)->get();
				$predictivo = $datos[0];
				
				$persona = new Persona;
				$persona->per_act = 1;
				$persona->per_run = $request->run;
				$persona->per_dig = $predictivo->dv_run;
				$persona->per_nom = strtoupper($predictivo->nombres);
				$persona->per_pat = strtoupper($predictivo->ap_paterno);
				$persona->per_mat = strtoupper($predictivo->ap_materno);
				$persona->per_sex = $predictivo->sexo;
				$persona->per_ani = $predictivo->edad_agno ?? '';
				$persona->per_mes = $predictivo->edad_meses ?? '';
				$persona->per_cod_ens = $predictivo->cod_ens;
				$persona->per_cod_gra = $predictivo->cod_gra;
				$persona->per_gra_let = $predictivo->let_cur;
				$resultado = $persona->save();
			
				if (!$resultado){
					DB::rollback();
					return redirect()->route('coordinador.caso.ficha')
						->with('danger', 'Ocurrio un Error Guardando Persona cx, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
				}
			
				// CONTACTOS
			
				if ($predictivo->info_nom_contacto_1!=null) {
					$contacto = new Contacto;
					$contacto->con_nom = $predictivo->info_nom_contacto_1;
					$contacto->con_pat = $predictivo->info_app_contacto_1;
					$contacto->con_tlf = $predictivo->info_num_contacto_1;
					$contacto->con_ori = "RIS";
					$contacto->con_con = 1;
					$resultado = $persona->contactos()->save($contacto);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando Contacto1 en Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
				if ($predictivo->info_nom_contacto_2!=null) {
					$contacto = new Contacto;
					$contacto->con_nom = $predictivo->info_nom_contacto_2;
					$contacto->con_pat = $predictivo->info_app_contacto_2;
					$contacto->con_tlf = $predictivo->info_num_contacto_2;
					$contacto->con_ori = "RIS";
					$contacto->con_con = 2;
					$resultado = $persona->contactos()->save($contacto);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando Contacto2 en Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
			
				if ($predictivo->rbd!=null){
					$liceo = new Liceo;
					$liceo->rbd_nom = $predictivo->nombre_rbd;
					$liceo->rbd_rbd = $predictivo->rbd;
					$resultado = $persona->liceos()->save($liceo);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando RBD en  Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
			
				if ($predictivo->dir_calle_1!=null) {
					$comuna = Comuna::where('com_cod',$predictivo->dir_com_1)->first();
					$direccion = new Direccion;
					$direccion->com_id = $comuna->com_id;
					$direccion->dir_ord = 1;
					$direccion->dir_call = $predictivo->dir_calle_1;
					$direccion->dir_num = $predictivo->dir_num_1;
				
					$resultado = $persona->direcciones()->save($direccion);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando dirección1 en Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
			
				if ($predictivo->dir_calle_2!=null) {
					$comuna = Comuna::where('com_cod',$predictivo->dir_com_2)->first();
					$direccion = new Direccion;
					$direccion->com_id = $comuna->com_id;
					$direccion->dir_ord = 2;
					$direccion->dir_call = $predictivo->dir_calle_2;
					$direccion->dir_num = $predictivo->dir_num_2;
				
					$resultado = $persona->direcciones()->save($direccion);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando dirección2 en Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
			
				if ($predictivo->dir_calle_3!=null) {
					$comuna = Comuna::where('com_cod',$predictivo->dir_com_3)->first();
					$direccion = new Direccion;
					$direccion->com_id = $comuna->com_id;
					$direccion->dir_ord = 3;
					$direccion->dir_call = $predictivo->dir_calle_3;
					$direccion->dir_num = $predictivo->dir_num_3;
				
					$resultado = $persona->direcciones()->save($direccion);
					if (!$resultado){
						DB::rollback();
						return redirect()->route('coordinador.caso.ficha')
							->with('danger', 'Ocurrio un Error Guardando dirección 3 en Persona, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
					}
				}
				
				$estado_actualizar = $request->descartar_estado;
				if (is_null($estado_actualizar)){
					$estado = $this->estado_caso->getVerificado();
					if (is_null($estado)){
						DB::rollback();
						$mensaje = 'Error. No se pudo Conseguir el Estado Asignado';
						return redirect()->back()->with('danger', $mensaje);
					}
					
					$estado_actualizar = $estado->est_cas_id;
				}
			
				$caso = new Caso;
			
				$caso->per_id = $persona->per_id;
				$caso->cas_nom = 'Caso Desde Predictivo - '.date('d/m/Y H:i:s');
				$caso->cas_fec = Carbon::now();
				$caso->cas_ori = 1;
				$caso->cas_sco = $predictivo->score;
				$caso->cas_des = $request->comentario;
				$caso->est_cas_id = $estado_actualizar;
				$resultado  = $caso->save();
				if (!$resultado){
					DB::rollback();
					return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run])
						->with('danger', 'Ocurrio un Error Guardando Caso, Por Favor Verifique.');
				}
				
				$score = $caso->scores()->create([
					'sco_sco' => $predictivo->score
				]);
				
				if (is_null($score)){
					DB::rollback();
					return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run])
						->with('danger', 'Ocurrio un Error Guardando score, Por Favor Verifique.');
				}
				
				//$request->origen = 2;
			/*} else {
				$persona = $this->persona->getByRun($request->run);
				
				if (is_null($persona)){
					DB::rollback();
					$mensaje = 'Error. No se pudo Conseguir la persona';
					return redirect()->back()->with('danger', $mensaje);
				}
				
				$caso = $persona->caso()->first();
				if (is_null($caso)){
					DB::rollback();
					$mensaje = 'Error. No se pudo Conseguir el caso';
					return redirect()->back()->with('danger', $mensaje);
				}
				
				$estado_actualizar = $request->descartar_estado;
				if (is_null($estado_actualizar)){
					$estado = $this->estado_caso->getVerificado();
					if (is_null($estado)){
						DB::rollback();
						$mensaje = 'Error. No se pudo Conseguir el Estado Asignado';
						return redirect()->back()->with('danger', $mensaje);
					}
					
					$estado_actualizar = $estado->est_cas_id;
				}
				
			}*/
			
			$caso->estados()->attach($estado_actualizar, ['cas_est_cas_des' => $request->comentario]);
			
			DB::commit();
			return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run])
				->with('success', 'El Caso ha sido verificado.');
		} catch (\Exception $e) {
			DB::rollback();
			return redirect()->back()
				->with('danger', 'Ocurrio un Error Guardando Persona cv, Por Favor Verifique.');
		}
	}
	/**
	 * Realiza la accion de asignar un terapeuta a un caso
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	// public function asignar(Request $request){
	// 	$request->validate([
	// 			'comentario'=>'required',
	// 			'terapeuta_id'=> 'required'
	// 		],[],['terapeuta_id'=>'terapeuta']);

	// 	try{
	// 		DB::beginTransaction();
			
	// 		$caso = $this->caso->find($request->id_caso);
	// 		if (is_null($caso)){
	// 			DB::rollback();
	// 			$mensaje = 'Error. No se pudo conseguir el Caso';
	// 			return redirect()->back()->with('danger', $mensaje);
	// 		}
			
	// 		/*$estado = $this->estado_caso->getAsignado();
	// 		if (is_null($estado)){
	// 			DB::rollback();
	// 			$mensaje = 'Error. No se pudo Conseguir el Estado Asignado';
	// 			return redirect()->back()->with('danger', $mensaje);
	// 		}*/
	// 		//$caso->estados()->attach($estado->est_cas_id, ['cas_est_cas_des' => $request->comentario]);
	// 		$caso->estados()->attach("5", ['cas_est_cas_des' => $request->comentario]);
			
	// 		//$caso->terapeutas()->attach($request->terapeuta_id);
			
	// 		$casoTerapeuta = new CasoTerapeuta;
	// 		$casoTerapeuta->ter_id = $request->terapeuta_id;
	// 		$casoTerapeuta->cas_id = $request->id_caso;
	// 		$casoTerapeuta->cas_ter_fec = date("Y-m-d h:i:s");
	// 		$casoTerapeuta->save();

	// 		DB::commit();
	// 		return redirect()->back()
	// 			->with('success', 'El Caso ha sido asignado a un terapeuta.');
	// 	} catch (\Exception $e) {
	// 		DB::rollback();
	// 		return redirect()->back()
	// 			->with('danger', 'Ha Ocurrido un Error Asignando terapeuta el caso.');
	// 	}
	// }
	
	/**
	 * Muestra formulario de busqueda por run
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showBuscar(){
		return view('persona.buscar');
	}
	
	/**
	 * Muestra el formulario para ingresar casos manuales
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mostrarFrmManuales(){
		try {
			$dimensiones = $this->dimension->all();
			
			return view('caso.manual')->with(['dimensiones'=>$dimensiones]);
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Crea los Casos Manuales
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function ingresarManuales(Request $request){
		try {
			DB::beginTransaction();
			
			if ($request->fecha_nac != '') {
				$fecha2 = Carbon::createFromFormat('d/m/Y', $request->fecha_nac)->format('Y-m-d');
				$años = Carbon::createFromFormat('d/m/Y', $request->fecha_nac)->diffInYears(Carbon::now());
				$meses = Carbon::createFromFormat('d/m/Y', $request->fecha_nac)->diffInMonths(Carbon::now());
			}
			
			$run_dv = explode("-", str_replace('.', '', $request->rut));
			$run = $run_dv[0];
			$run_dig = dv($run_dv[0]);
			
			$resultado = $this->persona->where('per_run',$run)->first();
			if (!is_null($resultado)){
				DB::rollback();
				return redirect()->back()
					->with('danger', 'La Persona ya posee un caso asociado.');
			}
			
			$persona = new Persona;
			$persona->per_run = $run;
			$persona->per_dig = $run_dig;
			$persona->per_nom = $request->nombres;
			$persona->per_pat = $request->apellido_p;
			$persona->per_mat = $request->apellido_m;
			$persona->per_sex = $request->sexo;
			$persona->per_nac = $fecha2 ?? '';
			$persona->per_ani = $años ?? '';
			$persona->per_mes = $meses ?? '';
			$persona->per_cod_ens = $request->rbd_nivel;
			$persona->per_cod_gra = $request->rbd_curso;
			$persona->per_gra_let = $request->rbd_letra;
			$persona->per_chi = $request->per_chi;
			$resultado = $persona->save();
			
			if (!$resultado) {
				DB::rollback();
				return redirect()->back()
					->with('danger', 'Ocurrio un Error Guardando Persona, Por Favor Verifique.');
			}
			
			$con_con = 1;
			for($i=0;$i<count($request->con_nom);$i++){
				if ($request->con_nom[$i] != '') {
					$contacto = [
						'con_con' => $con_con++,
						'con_nom' => $request->con_nom[$i],
						'con_pat' => $request->con_pat[$i],
						'con_mat' => $request->con_mat[$i],
						'con_tlf' => $request->con_tlf[$i],
						'con_ori' => session("nombre_perfil"),
					];
					
					$resultado = $persona->contactos()->create($contacto);
					if (!$resultado) {
						DB::rollback();
						return redirect()->back()
							->with('danger', 'Ocurrio un Error Guardando Contactos, Por Favor Verifique.');
					}
				}
			}
			
			$com_id = 1;
			$dir_ord = 1;
			
			for($i=0;$i<count($request->dir_call);$i++){
				if ($request->dir_call[$i] != '') {
					$direccion = [
						'com_id' 	=> $com_id,
						'dir_ord' 	=> $dir_ord++,
						'dir_call' 	=> $request->dir_call[$i],
						'dir_num' 	=> $request->dir_num[$i],
						'dir_dep' 	=> $request->dir_dep[$i],
					];
					
					$resultado = $persona->direcciones()->create($direccion);
					if (!$resultado) {
						DB::rollback();
						return redirect()->back()
							->with('danger', 'Ocurrio un Error Guardando la Direccion, Por Favor Verifique.');
					}
				}
			}
			
			if ($request->nombre_rbd != '') {
				$liceo = [
					'rbd_nom' => $request->nombre_rbd,
					'rbd_rbd' => $request->rbd_rbd,
				];
				
				$resultado = $persona->liceos()->create($liceo);
				if (!$resultado) {
					DB::rollback();
					return redirect()->back()
						->with('danger', 'Ocurrio un Error Guardando Datos Escolares, Por Favor Verifique.');
				}
			}
			
			$caso = [
				'cas_nom' 	=> 'Caso Manual - '.now()->format('d/m/Y H:i'),
				'cas_des' 	=> $request->desc_alerta,
				'cas_fec' 	=> now(),
				'cas_ori' 	=> config('constantes.origen_manual'),
				'dim_id' 	=> $request->dim_id
			];
			
			$caso = $persona->casos()->create($caso);
			
			$estado_caso = $this->estado_caso->getPrimero();
			
			$caso->estados()->save($estado_caso);
			
			DB::commit();
			
			return redirect()->back()
				->with('success', 'El Caso ha Sido Creado Exitosamente.');
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			return redirect()->back()
				->with('danger', 'Ha Ocurrido un Error Creando el Caso.');
		}
	}
	
	/**
	 * Muestra la pantalla de casos asignados
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function vistaCasosAsignados(){
		try {
			$dimensiones = $this->dimension->all();
			
			$estados = $this->estado_caso->all();
			
			if (session('perfil')==config('constantes.perfil_terapeuta')){
				$numeroPredictivos = $this->asignados_vista->totalPredictivoTerapeuta();
				$numeroManuales = $this->asignados_vista->totalManualesTerapeuta();
			}else{
				$numeroPredictivos = $this->asignados_vista->totalPredictivo();
				$numeroManuales = $this->asignados_vista->totalManuales();
			}
			
			return view('caso.asignados')
				->with(['dimensiones' => $dimensiones,
					'estados' => $estados,
					'numeroManuales' => $numeroManuales,
					'numeroPredictivos' => $numeroPredictivos
				]);
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Realiza la consulta de casos asignados
	 * @param Request $request
	 * @return mixed
	 * @throws \Exception
	 */
	public function dataCasosAsignados(Request $request){
		//dd($request);
		
		$asignados = $this->asignados_vista->select(['cas_id', 'run', 'per_run',
			'fecha',
			'score',
			'dimension',
			'origen',
			'estado',
			'ter_nom'
		]);
		
		if (session('tipo_perfil')==config('constantes.tipo_terapeuta')){
			$asignados = $asignados->where('ter_id',session('id_usuario'));
		}
		
		$asignados->when(request('origen'), function ($query, $origen) {
			return $query->where('cas_ori', $origen);
		});
		
		return Datatables::of($asignados)
			->addColumn('color', function ($caso) {
				if (!is_null($caso->score)){
					return '<div class="circulo ' . aplicarColor($caso->score) . '">' . $caso->score . '</div>';
				}else{
					return '';
				}
			}, true)
			->rawColumns(['color'])
			//->orderColumn('color', 'score $1')
			//->orderColumn('fecha', 'cas_fec $1')
			->make();
	}
	
	/**
	 * Muestra el formulario para derivar un caso
	 * @param $cas_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function derivarShow($cas_id){
		try {
			$caso = $this->caso->with('terceros')->find($cas_id);
			if (is_null($caso)){
				$mensaje = 'Error. No se pudo conseguir el Caso';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$desabilitar = '';
			$estado = $this->estado_caso->getDerivado();
			$estado_caso = $caso->estados()->wherePivot('est_cas_id',$estado->est_cas_id)->first();
			if (!is_null($estado_caso)) {
				$desabilitar = 'disabled';
			}
			
			$caso = Caso::find($cas_id);
			$caso->est_cas_id = $estado->est_cas_id;
			$caso->save();
			
			$terceros = $this->tercero->getTerceroCombo();
			
			return view('ficha.derivar_caso_modal')
				->with(['caso'=>$caso,'terceros'=>$terceros,'desabilitar'=>$desabilitar,'estado_caso'=>$estado_caso]);
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Realiza la acción de derivar sobre el caso
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function derivarActualizar(Request $request){
		$request->validate($this->reglas_derivar,[], $this->nombres);
		
		try {
			DB::beginTransaction();
			
			$caso = $this->caso->find($request->cas_id);
			if (is_null($caso)){
				DB::rollback();
				$mensaje = 'Error. No se pudo conseguir el Caso';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$estado = $this->estado_caso->getDerivado();
			if (is_null($estado)){
				DB::rollback();
				$mensaje = 'Error. No se pudo Conseguir el Estado Derivado';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$caso->estados()->attach($estado->est_cas_id, ['cas_est_cas_des' => $request->cas_est_cas_des]);
			
			$caso->terceros()->attach($request->ter_id);
			
			/*if ($request->adjunto){
				$request->adjunto->store('derivaciones');
			}*/
			
			DB::commit();
			//DB::rollback();
			return response()->json(array('estado' => '1',
				'mensaje' => ' Se Derivo Exitosamente el Caso.'),200);
		} catch(\Exception $e) {
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Generar el pdf con la cartola de RSH
	 * @param $run
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function generarCartolaRsh($run){
		$servicio = file_get_contents(config('constantes.url_cartola').$run."/true");
		
		$servicio = json_decode($servicio);
		
		if ($servicio){
			if ($servicio->estado == 1) {
				$html = base64_decode($servicio->contenido);
			} else {
				$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}
		}else {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
		
		$pdf = App::make('dompdf.wrapper');
		
		return $pdf->loadHTML($html)->setPaper('a4', 'portrait')->download('cartola_'.$run.'_'.date('Y-m-d-His').'.pdf');
	}
	
	/**
	 * Realiza la accion de rechazar un caso.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function rechazar(Request $request){
		$request->validate(['comentario' => 'required']);
		
		try{
			DB::beginTransaction();
			
			//$caso = new Caso;
			//$caso->cas_id = $request->id_caso;
			
			$estado_actualizar = $request->estado_rechazado;
			if (is_null($estado_actualizar)){
				$mensaje = 'Error. No se pudo conseguir el ID del estado rechazado.';
				return redirect()->back()->with('danger', $mensaje);
			}
			
			$caso = Caso::find($request->id_caso);
			$caso->est_cas_id = $estado_actualizar;
			$caso->save();
			
			$caso->estados()->attach($estado_actualizar, ['cas_est_cas_des' => $request->comentario]);
			
			DB::commit();
			return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run])
				->with('success', 'El caso ha sido rechazado exitosamente.');
		} catch (\Exception $e) {
			DB::rollback();
			return redirect()->back()
				->with('danger', 'Ocurrio un error al momento de guardar la actualización de estado del caso. Por favor verifique.');
		}
	}
	
	
	
	public function casosOficinaLocal(){
		
		return view('caso.oficina_local_old');
		
	}
	
	
	/**
	 * Muestra el listado de casos asginados a la comuna.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function vistaCasosOficinaLocal(){
		try {
			 $asignados = $this->asignados_vista->select(['cas_id', 'run', 'per_run',
				'fecha',
				'score',
				'dimension',
				'origen',
				'estado',
				'ter_nom'
			]);
			
			if (session('tipo_perfil')==config('constantes.tipo_terapeuta')){
				$asignados = $asignados->where('ter_id',session('id_usuario'));
			}
			
			$asignados->when(request('origen'), function ($query, $origen){
				return $query->where('cas_ori', $origen);
			});
			
		
		    //$registrados = NominaComunal::where('usuario_id', session()->all()['id_usuario']);
			
			return Datatables::of($asignados)
				->addColumn('color', function ($caso) {
					if (!is_null($caso->score)){
						return '<div class="circulo ' . aplicarColor($caso->score) . '">' . $caso->score . '</div>';
					}else{
						return '';
					}
				}, true)
				->rawColumns(['color'])
				->orderColumn('color', 'score $1')
				->orderColumn('fecha', 'cas_fec $1')
				->make();
			
			return view('caso.oficina_local');
			
			/*return view('caso.asignados')
				->with(['dimensiones' => $dimensiones,
					'estados' => $estados,
					'numeroManuales' => $numeroManuales,
					'numeroPredictivos' => $numeroPredictivos
				]);*/
			
		}catch(\Exception $e){
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			
		}
	}
	
	public function casosAdministracion(){

		$regiones = DB::select('select * from ai_region');

		return view('caso.asignar_nna', compact('regiones'));
	}
	
	/**
	 * Método que lista los NNA sin asignar por comuna.
	 *
	 * @return Datatables
	 */
	public function vistaCasosAdministracion(){
		try {
			$asignados = $this->asignados_vista->select(['cas_id', 'run', 'per_run',
				'fecha',
				'score',
				'dimension',
				'origen',
				'ter_nom'
			]);
			
			if (session('tipo_perfil')==config('constantes.tipo_terapeuta')){
				$asignados = $asignados->where('ter_id',session('id_usuario'));
			}
			
			$asignados->when(request('origen'), function ($query, $origen) {
				return $query->where('cas_ori', $origen);
			});
			
			return Datatables::of($asignados)
				->addColumn('color', function ($caso) {
					if (!is_null($caso->score)){
						return '<div class="circulo ' . aplicarColor($caso->score) . '">' . $caso->score . '</div>';
					}else{
						return '';
					}
				}, true)
				->rawColumns(['color'])
				->orderColumn('color', 'score $1')
				->orderColumn('fecha', 'cas_fec $1')
				->make();
			
			return view('caso.asignar_nna');
			
			/*return view('caso.asignados')
				->with(['dimensiones' => $dimensiones,
					'estados' => $estados,
					'numeroManuales' => $numeroManuales,
					'numeroPredictivos' => $numeroPredictivos
				]);*/
			
		}catch(\Exception $e){
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			
		}
	}
	
	/**
	 * Método que lista los gestores según comuna.
	 *
	 * @return Datatables
	 */
	public function vistaGestores(){
		 try{
			 $user = Auth::id();
			 
			 $comuna_coordinador = DB::table('ai_usuario')
									 ->select('*')
									 ->rightJoin('ai_usuario_comuna', 'ai_usuario.id', '=', 'ai_usuario_comuna.usu_id')
									 ->where([['ai_usuario.id_perfil', '=',2], ['ai_usuario.id', '=', 33],])
									 ->get();
			 
			 if (count($comuna_coordinador) == 0) throw $comuna_coordinador;
			 
			 $gestores_comuna = DB::table('ai_usuario')
				 ->select('*')
				 ->rightJoin('ai_usuario_comuna', 'ai_usuario.id', '=', 'ai_usuario_comuna.usu_id')
				 ->where([['ai_usuario.id_perfil', '=', 3], ['ai_usuario_comuna.com_id', '=', $comuna_coordinador[0]->com_id],])
				 ->get();
			
			 return Datatables::of($gestores_comuna)
					 ->addColumn('total_casos_asignados', function ($row) {
					 	 $usu_id = (int) $row->id;
					 	
						 $total_casos_asignados = DB::table('ai_persona_usuario')
								 ->where('usu_id','=', $usu_id)
								 ->count();
						 
						 return $total_casos_asignados;
					 }, true)
				     ->rawColumns(['total_casos_asignnados'])
				     ->make();
			 
			 return view('caso.asignar_nna');
			 
		 }catch (\Exception $e){
			 $mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			 return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		 }
	}
	
	/**
	 * Método que inserta en la BD la asignación de un NNA a un gestor.
	 *
	 * @param $request [usu_id: ID del Gestor / run: Rut del NNA]
	 * @return JSON [1: Asignación exitosa / 2: Error al asignar]
	 */
	// INICIO CZ SPRINT 68
	public function crearPersona($nna,$datos_nna){
		/*Se guardan datos básicos del NNA en la tabla AI_PERSONA*/
		if(!isset($nna) || $nna == null || $nna == ""){
			throw new \Exception("No se encuentra RUT del NNA. Por Favor Verifique.");
		}
		if(!isset($datos_nna->nombres) || $datos_nna->nombres == null || $datos_nna->nombres == ""){
			throw new \Exception("No se encuentran NOMBRES del NNA. Por Favor Verifique.");
		}
		// if(!isset($datos_nna->sexo) || $datos_nna->sexo == null || $datos_nna->sexo == ""){
		// 	throw new \Exception("No se encuentra SEXO del NNA. Por Favor Verifique.");
		// }	
					//CZ SPRINT 73
				        $persona = new Persona;
					$persona->per_act = 1;
		                        $persona->per_run = $nna;
					//CZ SPRINT 73
					$persona->per_dig = $datos_nna->dv_run;
					$persona->per_nom = strtoupper($datos_nna->nombres);
					$persona->per_pat = strtoupper($datos_nna->ap_paterno);
					$persona->per_mat = strtoupper($datos_nna->ap_materno);
					$persona->per_sex = $datos_nna->sexo;
					$persona->per_ani = $datos_nna->edad_agno ?? '';
					$persona->per_mes = $datos_nna->edad_meses ?? '';
					$persona->per_cod_ens = $datos_nna->cod_ens;
					$persona->per_cod_gra = $datos_nna->cod_gra;
					$persona->per_gra_let = $datos_nna->let_cur;
					
					$resultado = $persona->save();
					//Inicio Andres F.
					if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información Básica de NNA. Por Favor Verifique.");
					else{ //Correccion Sprint 61 Andres F
			$this->envioCorreoSectorialista($nna);
			return $persona;
					}
					//Fin Andres F.
	}
	public function crearDatosPersona($caso,$persona,$datos_nna){
		$datosPersona = new DatosPersona();
		$datosPersona->cas_id = $caso->cas_id;
		$datosPersona->per_id =  $persona->per_id;
		$datosPersona->per_nom = strtoupper($datos_nna->nombres);
		$datosPersona->per_pat = strtoupper($datos_nna->ap_paterno);
		$datosPersona->per_mat = strtoupper($datos_nna->ap_materno);
		$datosPersona->per_sex = $datos_nna->sexo;
		$datosPersona->per_ani = $datos_nna->edad_agno ?? '';
		$datosPersona->per_mes = $datos_nna->edad_meses ?? '';
		$resultado = $datosPersona->save();
		//Inicio Andres F.
		if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información Básica de NNA. Por Favor Verifique.");
	}
	public function guardarInfoContacto($datos_nna,$persona){
					/*Se guarda información de contacto 1 del NNA*/
					if (!is_null($datos_nna->info_nom_contacto_1) && $datos_nna->info_nom_contacto_1 != "" && !is_null($datos_nna->info_num_contacto_1) && $datos_nna->info_num_contacto_1 != "") {
						$contacto = new Contacto;
						$contacto->con_nom = $datos_nna->info_nom_contacto_1;
						$contacto->con_pat = $datos_nna->info_app_contacto_1;
						$contacto->con_mat = $datos_nna->info_apm_contacto_1;
						$contacto->con_tlf = $datos_nna->info_num_contacto_1;
						$contacto->con_ori = "RIS";
						$contacto->con_con = 1;
						$contacto->con_par = $datos_nna->relacion_contacto_1;
						$contacto->con_fue = $datos_nna->info_fue_contacto_1;
						$contacto->con_fec_fue = $datos_nna->info_fec_contacto_1;
						
						$resultado = $persona->contactos()->save($contacto);
						if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de Contacto 1 de NNA. Por Favor Verifique.");
					}
					
					/*Se guarda información de contacto 2 del NNA*/
					if (!is_null($datos_nna->info_nom_contacto_2) && $datos_nna->info_nom_contacto_2 != "" && !is_null($datos_nna->info_num_contacto_2) && $datos_nna->info_num_contacto_2 != ""){
						$contacto = new Contacto;
						$contacto->con_nom = $datos_nna->info_nom_contacto_2;
						$contacto->con_pat = $datos_nna->info_app_contacto_2;
						$contacto->con_mat = $datos_nna->info_apm_contacto_2;
						$contacto->con_tlf = $datos_nna->info_num_contacto_2;
						$contacto->con_ori = "RIS";
						$contacto->con_con = 2;
						$contacto->con_par = null;
						$contacto->con_fue = $datos_nna->info_fue_contacto_2;
						$contacto->con_fec_fue = $datos_nna->info_fec_contacto_2;
						
						$resultado = $persona->contactos()->save($contacto);
						if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de Contacto 2 de NNA. Por Favor Verifique.");
					}
	}
	//INICIO CZ SPRINT 68 
	public function guardarInfoLiceo($datos_nna,$persona, $cas_id){
	// FIN CZ SPRINT 68
					/*Se guarda información de estudios del NNA*/
					if (!is_null($datos_nna->rbd) && $datos_nna->rbd != ""){
						$dir_rbd = null;
						if (!is_null($datos_nna->dir_rbd) && $datos_nna->dir_rbd != "" && !is_null($datos_nna->dir_num_rbd) && $datos_nna->dir_num_rbd != ""){
							$dir_rbd = $datos_nna->dir_rbd." #".$datos_nna->dir_num_rbd;

							if (!is_null($datos_nna->cod_com_rbd) && $datos_nna->cod_com_rbd != ""){
								$comuna = Comuna::where('com_cod', $datos_nna->cod_com_rbd)->first();
								
								if (count($comuna) > 0) $dir_rbd .= ", ".$comuna->com_nom;
							}
						}

						$liceo = new Liceo;
						$liceo->rbd_nom = $datos_nna->nombre_rbd;
						$liceo->rbd_rbd = $datos_nna->rbd;
						$liceo->rbd_dir = $dir_rbd;
						$liceo->fue_rbd = $datos_nna->fue_rbd;
						$liceo->fec_fue_rbd = $datos_nna->fec_fue_rbd;
			$liceo->RBD_COD_GRA = $datos_nna->per_COD_GRA;
			$liceo->RBD_COD_ENS = $datos_nna->per_COD_ENS;
			$liceo->RBD_GRA_LET = $datos_nna->PER_GRA_LET;
						// INICIO CZ SPRINT 68
						$liceo->CAS_ID = $cas_id;
						$liceo->per_id = $persona;
						// FIN CZ SPRINT 68
						// $resultado = $persona->liceos()->save($liceo);
						// INICIO CZ SPRINT 68
						$resultado = $liceo->save();
						// FIN CZ SPRINT 68
						if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de Estudios de NNA. Por Favor Verifique.");
					}
	}
					
	public function guardarDireccion($datos_nna,$persona,$caso){
					/*Se guarda información de Dirección 1 del NNA*/
					if (!is_null($datos_nna->dir_calle_1) && $datos_nna->dir_calle_1 != "" && !is_null($datos_nna->dir_num_1) && $datos_nna->dir_num_1 != ""){
						$comuna = Comuna::where('com_cod', $datos_nna->dir_com_1)->first();
						if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° 1 no válida. Por Favor Verifique.");
			$max = Direccion::max('dir_id');
						$direccion = new Direccion;
			$direccion->dir_id 		= $max+1;
						$direccion->com_id 		= $comuna = $comuna->com_id;;
						$direccion->dir_ord 	= 1;
						$direccion->dir_call 	= $datos_nna->dir_calle_1;
						$direccion->dir_num 	= $datos_nna->dir_num_1;
						$direccion->dir_sit 	= $datos_nna->dir_sitio_1;
						$direccion->dir_block 	= $datos_nna->dir_block_1;
						$direccion->dir_casa 	= $datos_nna->dir_casa_1;
						$direccion->dir_fue 	= $datos_nna->dir_fuente_1;
						$direccion->dir_fecha   = $datos_nna->dir_fecha_ingr_1;
						// INICIO CZ SPRINT 69
			$direccion->cas_id   = $caso->cas_id;
						$direccion->per_id = $persona->per_id;
						// $resultado = $persona->direcciones()->save($direccion);
						$resultado = $direccion->save();
						// FIN CZ SPRINT 69
						if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de Dirección 1 de NNA. Por Favor Verifique.");
					}
					
					/*Se guarda información de Dirección 2 del NNA*/
					if (!is_null($datos_nna->dir_calle_2) && $datos_nna->dir_calle_2 != "" && !is_null($datos_nna->dir_num_2) && $datos_nna->dir_num_2 != ""){
						$comuna = Comuna::where('com_cod', $datos_nna->dir_com_2)->first();
						//if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° 2 no válida. Por Favor Verifique.");

						if (count($comuna) > 0){
				$max = Direccion::max('dir_id');
			
							$direccion = new Direccion;
				$direccion->dir_id 		= $max+1;
							$direccion->com_id    = $comuna->com_id;
							$direccion->dir_ord   = 2;
							$direccion->dir_call  = $datos_nna->dir_calle_2;
							$direccion->dir_num   = $datos_nna->dir_num_2;
							$direccion->dir_sit   = $datos_nna->dir_sitio_2;
							$direccion->dir_block = $datos_nna->dir_block_2;
							$direccion->dir_casa  = $datos_nna->dir_casa_2;
							$direccion->dir_fue   = $datos_nna->dir_fuente_2;
							$direccion->dir_fecha = $datos_nna->dir_fecha_ingr_2;
							// INICIO CZ SPRINT 69
				$direccion->cas_id   = $caso->cas_id;
							$direccion->per_id = $persona->per_id;
							// $resultado = $persona->direcciones()->save($direccion);
							$resultado = $direccion->save();
							// FIN CZ SPRINT 69
							if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de Dirección 2 de NNA. Por Favor Verifique.");
						}
					}
					
					/*Se guarda información de Dirección 3 del NNA*/
					if (!is_null($datos_nna->dir_calle_3) && $datos_nna->dir_calle_3 != "" && !is_null($datos_nna->dir_num_3) && $datos_nna->dir_num_3 != ""){
						$comuna = Comuna::where('com_cod', $datos_nna->dir_com_3)->first();
						//if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° 3 no válida. Por Favor Verifique.");

						if (count($comuna) > 0){
				$max = Direccion::max('dir_id');
				
							$direccion = new Direccion;
				$direccion->dir_id 		= $max+1;
							$direccion->com_id    = $comuna->com_id;
							$direccion->dir_ord   = 3;
							$direccion->dir_call  = $datos_nna->dir_calle_3;
							$direccion->dir_num   = $datos_nna->dir_num_3;
							$direccion->dir_sit   = $datos_nna->dir_sitio_3;
							$direccion->dir_block = $datos_nna->dir_block_3;
							$direccion->dir_casa  = $datos_nna->dir_casa_3;
							$direccion->dir_fue   = $datos_nna->dir_fuente_3;
							$direccion->dir_fecha = $datos_nna->dir_fecha_ingr_3;
							// INICIO CZ SPRINT 69
				$direccion->cas_id   = $caso->cas_id;
							$direccion->per_id = $persona->per_id;
							// $resultado = $persona->direcciones()->save($direccion);
							$resultado = $direccion->save();
							// FIN CZ SPRINT 69
							if (!$resultado)  throw new \Exception("Ocurrio un Error Guardando Información de Dirección 3 de NNA. Por Favor Verifique.");
						}
					}
					}

	public function crearCaso($comentario,$datos_nna,$estado){
					$caso = new Caso;
					//$caso->per_id = $persona->per_id;
					$caso->cas_nom = 'Caso - ' . date('d/m/Y H:i:s');
					$caso->cas_fec = Carbon::now();
					$caso->cas_ori = 1;
					$caso->cas_sco = $datos_nna->score;
					$caso->cas_des = $comentario;
					$caso->est_cas_id = $estado->est_cas_id;
					
					$resultado = $caso->save();
					if (!$resultado){
						throw new \Exception("Ocurrio un Error Creando el Caso de NNA. Por Favor Verifique.");
					} 
		return $caso;
	}
					
	public function crearCasoPersonaIndice($caso,$persona,$datos_nna){
					/*Se vincula al NNA con el caso creado*/
					$caso_indice = new CasoPersonaIndice();
					$caso_indice->cas_id  = $caso->cas_id;
					$caso_indice->per_id  = $persona->per_id;
					$caso_indice->per_ind = 1;
					$caso_indice->cpi_n_alertas = $datos_nna->n_alertas;
					$caso_indice->cpi_prioridad = $datos_nna->score;
					$caso_indice->periodo = $datos_nna->periodo;
					$resultado = $caso_indice->save();
					if (!$resultado) throw new \Exception("Ocurrio un Error al Momento de Vincular NNA al Caso. Por Favor Verifique.");

	}

	public function vincularComunaCaso($id_comuna_dir_1,$caso){
					//Se vincula el caso con su respectiva comuna
					$comuna = Comuna::where('com_id', $id_comuna_dir_1)->first();
					if (count($comuna) == 0 || is_null($id_comuna_dir_1) || $id_comuna_dir_1 == "") throw new \Exception("No se encuentra ID de comuna de origen del NNA. Por favor verifique código comunal.");

					$resultado = DB::table('ai_caso_comuna')->insert(['cas_id' => $caso->cas_id, 'com_id' => $comuna->com_id]);
					if(!$resultado) throw $resultado;
	}
					
	public function vincularAlertaCaso($nna,$caso){
					//Se obtiene las Alertas Territoriales sin gestionar que mantiene el NNA.
		$alertas_levantadas = $this->alertaManual->listarAlertasManualesNNA($nna, null, true);

					//Se vincula las Alertas obtenidas al Caso recién creado.
					foreach ($alertas_levantadas as $valor) {
						$resultado = DB::insert("INSERT INTO AI_CASO_ALERTA_MANUAL (cas_id, ale_man_id)
									  VALUES ('".$caso->cas_id."','".$valor->ale_man_id."')");
						
						if (!$resultado) throw new \Exception("Ocurrio un Error al Vincular una Alerta Territorial al Caso del NNA. Por Favor Verifique.");
					}
					}
						
	public function editarPersona($persona_id,$datos_nna){

						$persona = Persona::find($persona_id);
						$persona->per_sex = $datos_nna->sexo;
						$persona->per_ani = $datos_nna->edad_agno ?? '';
						$persona->per_mes = $datos_nna->edad_meses ?? '';
						$persona->per_cod_ens = $datos_nna->cod_ens;
						$persona->per_cod_gra = $datos_nna->cod_gra;
						$persona->per_gra_let = $datos_nna->let_cur;						
						$resultado 		  	  = $persona->save();
						if (!$resultado) throw $resultado;

	}

	public function editarInfoContacto($datos_nna,$persona_id){
						//Obtenemos la informacion de contacto del NNA
						$contactos = array();
						$contactos[0] = new \stdClass;
						$contactos[0]->con_nom = $datos_nna->info_nom_contacto_1;
						$contactos[0]->con_pat = $datos_nna->info_app_contacto_1;
						$contactos[0]->con_mat = $datos_nna->info_apm_contacto_1;
						$contactos[0]->con_tlf = $datos_nna->info_num_contacto_1;
						$contactos[0]->con_ori = "RIS";
						$contactos[0]->con_con = 1;
						$contactos[0]->con_par = $datos_nna->relacion_contacto_1;

						$contactos[1] = new \stdClass;
						$contactos[1]->con_nom = $datos_nna->info_nom_contacto_2;
						$contactos[1]->con_pat = $datos_nna->info_app_contacto_2;
						$contactos[1]->con_mat = $datos_nna->info_apm_contacto_2;
						$contactos[1]->con_tlf = $datos_nna->info_num_contacto_2;
						$contactos[1]->con_ori = "RIS";
						$contactos[1]->con_con = 2;
						$contactos[0]->con_par = null;


						foreach($contactos AS $c1 => $v1){
							if (!is_null($v1->con_tlf) && $v1->con_tlf != "" && !is_null($persona_id) && $persona_id != "" && !is_null($v1->con_nom) && $v1->con_nom != ""){
								$actualizar_contacto = DB::select("SELECT * FROM ai_contacto WHERE  con_nom LIKE '%".$v1->con_nom."%' AND con_tlf LIKE '%".$v1->con_tlf."%' AND per_id = ".$persona_id);

								$obj_con = new Contacto;
								if (count($actualizar_contacto) > 0) $obj_con = Contacto::find($actualizar_contacto[0]->con_id);

								$obj_con->con_nom = $v1->con_nom;
								$obj_con->con_pat = $v1->con_pat;
								$obj_con->con_mat = $v1->con_mat;
								$obj_con->con_tlf = $v1->con_tlf;
								$obj_con->con_ori = $v1->con_ori;
								$obj_con->con_con = $v1->con_con;
								$obj_con->con_par = $v1->con_par;
								$obj_con->per_id  = $persona_id;
								$resultado 		  = $obj_con->save();
								if (!$resultado) throw $resultado;
							}
						}
	}

	public function actualizarInfoLiceo($datos_nna,$persona_id){
		//Agregamos o actualizamos la información de educación
		if (!is_null($datos_nna->rbd) && $datos_nna->rbd != ""){
			$actualizar_liceo = DB::select("SELECT * FROM ai_rbd WHERE rbd_rbd LIKE '%".$datos_nna->rbd."%' AND per_id = ".$persona_id);

			$liceo = new Liceo;
			if (count($actualizar_liceo) > 0) $liceo = Liceo::find($actualizar_liceo[0]->rbd_id);

			$dir_rbd = null;
			if (!is_null($datos_nna->dir_rbd) && $datos_nna->dir_rbd != "" && !is_null($datos_nna->dir_num_rbd) && $datos_nna->dir_num_rbd != ""){
				$dir_rbd = $datos_nna->dir_rbd." #".$datos_nna->dir_num_rbd;

				if (!is_null($datos_nna->cod_com_rbd) && $datos_nna->cod_com_rbd != ""){
					$comuna = Comuna::where('com_cod', $datos_nna->cod_com_rbd)->first();
					
					if (count($comuna) > 0) $dir_rbd .= ", ".$comuna->com_nom;
				}
			}

			$liceo->rbd_nom = $datos_nna->nombre_rbd;
			$liceo->rbd_rbd = $datos_nna->rbd;
			$liceo->rbd_dir = $dir_rbd;
			$liceo->per_id 	= $persona_id;
			$resultado 		= $liceo->save();
			if (!$resultado) throw $resultado;
		}
	}

	public function editarDirecciones($datos_nna,$persona_id,$caso){
						//Obtenemos la informacion de ubicación del NNA
						$direcciones = array();
						$direcciones[0] = new \stdClass;
						$direcciones[0]->dir_call 	= $datos_nna->dir_calle_1;
						$direcciones[0]->dir_num 	= $datos_nna->dir_num_1;
						$direcciones[0]->dir_com 	= $datos_nna->dir_com_1;
						$direcciones[0]->dir_ord 	= 1;
						$direcciones[0]->dir_sit 	= $datos_nna->dir_sitio_1;
						$direcciones[0]->dir_block 	= $datos_nna->dir_block_1;
						$direcciones[0]->dir_casa 	= $datos_nna->dir_casa_1;

						$direcciones[1] = new \stdClass;
						$direcciones[1]->dir_call 	= $datos_nna->dir_calle_2;
						$direcciones[1]->dir_num 	= $datos_nna->dir_num_2;
						$direcciones[1]->dir_com 	= $datos_nna->dir_com_2;
						$direcciones[1]->dir_ord 	= 2;
						$direcciones[1]->dir_sit 	= $datos_nna->dir_sitio_2;
						$direcciones[1]->dir_block 	= $datos_nna->dir_block_2;
						$direcciones[1]->dir_casa 	= $datos_nna->dir_casa_2;

						$direcciones[2] = new \stdClass;
						$direcciones[2]->dir_call 	= $datos_nna->dir_calle_3;
						$direcciones[2]->dir_num 	= $datos_nna->dir_num_3;
						$direcciones[2]->dir_com 	= $datos_nna->dir_com_3;
						$direcciones[2]->dir_ord 	= 3;
						$direcciones[2]->dir_sit 	= "";
						$direcciones[2]->dir_block 	= "";
						$direcciones[2]->dir_casa 	= "";

						foreach ($direcciones AS $c1 => $v1){
							if (!is_null($v1->dir_call) && $v1->dir_call != "" && !is_null($v1->dir_num) && $v1->dir_num != "" && !is_null($persona_id) && $persona_id != ""){
						
								$guardar_direccion = true;
								$comuna = Comuna::where('com_cod', $v1->dir_com)->first();

								if ($c1 == 0){
									if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° ".$c1." no válida. Por Favor Verifique.");
								
								}else{
									if (count($comuna) == 0) $guardar_direccion = false;

								}
								
								if ($guardar_direccion){
					$actualizar_direccion = DB::select("SELECT * FROM ai_direccion WHERE dir_call LIKE '%".$v1->dir_call."%' AND dir_num LIKE '%".$v1->dir_num."%' AND per_id = ".$persona_id." and cas_id =".$caso->cas_id);

									$obj_dir = new Direccion;							
									if (count($actualizar_direccion) > 0) $obj_dir = Direccion::find($actualizar_direccion[0]->dir_id);

									$obj_dir->dir_call 	= $v1->dir_call;
									$obj_dir->dir_num 	= $v1->dir_num;
									$obj_dir->com_id 	= $comuna->com_id;
									$obj_dir->dir_ord 	= $v1->dir_ord;
									$obj_dir->dir_sit 	= $v1->dir_sit;
									$obj_dir->dir_block = $v1->dir_block;
									$obj_dir->dir_casa 	= $v1->dir_casa;
									$obj_dir->per_id 	= $persona_id;
					$obj_dir->cas_id = $caso->cas_id;
									$resultado 			= $obj_dir->save();
									if (!$resultado) throw $resultado;
								}

							}
						}
						}


		// INICIO CZ SPRINT 68
		public function reasignarGestor(Request $request){
			$reasignarGestor = DB::update("update ai_persona_usuario set usu_id='".$request->id_usu."' where cas_id=".$request->id_caso); 
			$gestor_asignado = Usuarios::where("id", $request->id_usu)->get();
						
					if (count($gestor_asignado) > 0){
						$gestor_asignado = $gestor_asignado[0];
			$comentario = 'Se reasigna caso a gestor ' . $gestor_asignado->nombres . ' ' . $gestor_asignado->apellido_paterno . ' ' . $gestor_asignado->apellido_materno . '.';
		}

			$reasignarGestorCaso = DB::update("update ai_caso set cas_des='".$comentario."' where cas_id=".$request->id_caso);

			if ($request->post){
				return redirect()->back()
				->with('success', 'Se ha asignado correctamente NNA a Gestor.');
			
			}else{
				$mensaje = "Se ha asignado correctamente NNA a Gestor.";
				return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);			
					}
		}
		// FIN CZ SPRINT 68

	public function crearNNAGrupoFamiliar($nna,$datos_nna){
		//AGREGA NNA GRUPO FAMILIAR	
		$cod_parentesco_default = DB::select("SELECT par_gru_fam_cod FROM ai_parentesco_grupo_familiar WHERE par_gru_fam_nom LIKE '%por definir%'");
		$fec_cre = now()->format('d/m/Y');
						
		$grupo = new GrupoFamiliar;
		$grupo->gru_fam_nom     = strtoupper($datos_nna->nombres);
		$grupo->gru_fam_ape_pat = strtoupper($datos_nna->ap_paterno);
		$grupo->gru_fam_ape_mat = strtoupper($datos_nna->ap_materno);
		$grupo->gru_fam_run     = $datos_nna->run;
		$grupo->gru_fam_dv      = $datos_nna->dv_run;
		$grupo->gru_fam_nac 	= $datos_nna->fecha_nac;
						
		$grupo->gru_fam_par     = $cod_parentesco_default[0]->par_gru_fam_cod; //Defecto Pordefinir cod 99.
		$grupo->gru_fam_sex     = $datos_nna->sexo;
		$grupo->gru_fam_fue		= "SAN";
		$grupo->gru_fam_fec_cre = Carbon::createFromFormat( 'd/m/Y', $fec_cre);
						
		Log::info($grupo);

		$resultado = $grupo->save();
		if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");
		return $grupo;
	}

	public function crearNNACasoGrupoFamiliar($caso,$grupo){
		$caso_grupo = new CasoGrupoFamiliar;
		$caso_grupo->cas_id = $caso->cas_id;
		$caso_grupo->gru_fam_id = $grupo->gru_fam_id;
		$resultado = $caso_grupo->save();
		if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");

	}

	public function NNAGrupoFamiliarRSH($fecha,$array_integrantes,$nna,$caso,$id_usu){
		foreach ($array_integrantes AS $c1 => $v1){
			//foreach ($rsh->integrantes AS $c1 => $v1) {
				$integrantes = $array_integrantes[$c1];
				$integrantes = (array) $array_integrantes[$c1];

				//$integrantes = (array)$rsh->integrantes[$c1];

				/*Obtenemos digito verificador del RUN*/
				$s = 1;
				$r = $integrantes["Run"];
				for ($m = 0; $r != 0; $r /= 10) $s = ($s + $r % 10 * (9 - $m++ % 6)) % 11;
				$run_integrante = chr($s ? $s + 47 : 75);
						
				/*Se valida si integrante se encuentra dentro del predictivo, mantiene alguna alerta territorial levantada o algun caso abierto.*/
				$val_res = $this->validarPredictivoPersonaCasoAlertas($integrantes["Run"], $run_integrante);
						
				if ($val_res["caso"] == false || $nna == $integrantes["Run"]){
					$fecha_nacimiento = new \DateTime($integrantes["Fecha Nacimiento"]);
					$fecha_ingreso = new \DateTime($fecha["Fecha Ingreso"]);

					$grupo = new GrupoFamiliar;
					$grupo->gru_fam_nom     = $integrantes["Nombres"];
					$grupo->gru_fam_ape_pat = $integrantes["Apellido Paterno"];
					$grupo->gru_fam_ape_mat = $integrantes["Apellido Materno"];
					$grupo->gru_fam_run     = $integrantes["Run"];
					$grupo->gru_fam_dv      = $run_integrante;
					$grupo->gru_fam_nac 	= Carbon::createFromFormat( 'd/m/Y', $fecha_nacimiento->format('d/m/Y'));
					$grupo->gru_fam_fec_cre	= Carbon::createFromFormat( 'd/m/Y', $fecha_ingreso->format('d/m/Y'));
					$grupo->gru_fam_fue		= "RSH";

					/*Obtenemos el codigo de parentesco*/
					$cod_parentesco = explode(" ", $integrantes["Parentesco"]);
					$cod_parentesco = str_replace(["(", ")"], "", $cod_parentesco[0]);

					// Se realiza validación para estar seguro que existe el tipo de parentesco,
					// en caso de NO existir, se forza a ser 99 => por definir
					$CodParentescoGrupoFamiliar = ParentescoGrupoFamiliar::find($cod_parentesco);
					if (!$CodParentescoGrupoFamiliar){
						$cod_parentesco = config('constantes.parentesco_por_definir');
					}
					$grupo->gru_fam_par = $cod_parentesco;

					/*Obtenemos el sexo del integrante*/
					$sexo_integrante = explode(" ", $integrantes["Sexo"]);
					$sexo_integrante = str_replace(["(", ")"], "", $sexo_integrante[0]);
					$grupo->gru_fam_sex		= $sexo_integrante;

							$resultado = $grupo->save();
							if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");
							
							$caso_grupo = new CasoGrupoFamiliar;
							$caso_grupo->cas_id = $caso->cas_id;
							$caso_grupo->gru_fam_id = $grupo->gru_fam_id;
							
							//dd($caso->cas_id, $grupo->gru_fam_id);
							$resultado = $caso_grupo->save();
							if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");
					
					/*Calculamos la edad, a base de la fecha de nacimiento y la fecha actual*/
					$fecha_actual = new \DateTime();
					$edad = $fecha_actual->diff($fecha_nacimiento);
					
					/*Validamos si es hombre (1: Hombre || 2: Mujer)*/
					//if ($sexo_integrante == 1){
						if ($edad->y < 18){
							if ($val_res["predictivo"] == true){
								$resultado = $this->asociarIntegranteFamiliarCaso($integrantes["Run"], $run_integrante, $caso->cas_id, $id_usu);
								if ($resultado["estado"] != 1) throw new \Exception("Ocurrio un Error al Vincular Integrante Familiar con Caso. Por Favor Verifique.");
							
							}
						}
				}
						}
					}
					
	public function NNAGrupoFamiliarRSHConCaso($fecha, $array_integrantes,$rsh,$caso,$id_usu, $nna){
					foreach ($array_integrantes AS $c1 => $v1){
						$integrantes = (array) $rsh->integrantes[$c1];
						
						/*Obtenemos digito verificador del RUN*/
						$s=1;
						$r = $integrantes["Run"];
						for($m=0;$r!=0;$r/=10) $s=($s+$r%10*(9-$m++%6))%11;
						$run_integrante = chr($s?$s+47:75);
						
						/*Se valida si integrante se encuentra dentro del predictivo, mantiene alguna alerta territorial levantada o algun caso abierto.*/
						$val_res = $this->validarPredictivoPersonaCasoAlertas($integrantes["Run"], $run_integrante);
						
			if ($val_res["caso"] == false || $nna == $integrantes["Run"]){
							$fecha_nacimiento = new \DateTime($integrantes["Fecha Nacimiento"]);
							$fecha_ingreso = new \DateTime($fecha["Fecha Ingreso"]);

							$grupo = new GrupoFamiliar;
							$grupo->gru_fam_nom     = $integrantes["Nombres"];
							$grupo->gru_fam_ape_pat = $integrantes["Apellido Paterno"];
							$grupo->gru_fam_ape_mat = $integrantes["Apellido Materno"];
							$grupo->gru_fam_run     = $integrantes["Run"];
							$grupo->gru_fam_dv      = $run_integrante;
							$grupo->gru_fam_nac 	= Carbon::createFromFormat( 'd/m/Y', $fecha_nacimiento->format('d/m/Y'));
							$grupo->gru_fam_fec_cre	= Carbon::createFromFormat( 'd/m/Y', $fecha_ingreso->format('d/m/Y'));
							$grupo->gru_fam_fue		= "RSH";
							
							/*Obtenemos el codigo de parentesco*/
							$cod_parentesco = explode(" ",$integrantes["Parentesco"]);
							$cod_parentesco = str_replace(["(",")"], "", $cod_parentesco[0]);
							$grupo->gru_fam_par = $cod_parentesco;
							
							/*Obtenemos el sexo del integrante*/
							$sexo_integrante = explode(" ", $integrantes["Sexo"]);
							$sexo_integrante = str_replace(["(", ")"], "", $sexo_integrante[0]);
							$grupo->gru_fam_sex		= $sexo_integrante;
							
							$resultado = $grupo->save();
							if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");
							
							$caso_grupo = new CasoGrupoFamiliar;
							$caso_grupo->cas_id = $caso->cas_id;
							$caso_grupo->gru_fam_id = $grupo->gru_fam_id;
							
							$resultado = $caso_grupo->save();
							if (!$resultado) throw new \Exception("Ocurrio un Error Guardando la Información del Grupo Familiar del NNA. Por Favor Verifique.");
							
							/*Calculamos la edad, a base de la fecha de nacimiento y la fecha actual*/
							$fecha_actual = new \DateTime();
							$edad = $fecha_actual->diff($fecha_nacimiento);
							
							/*Validamos si es hombre (1: Hombre || 2: Mujer)*/
							//if ($sexo_integrante == 1) {
								if ($edad->y < 18){
									if ($val_res["predictivo"] == true){
							$resultado = $this->asociarIntegranteFamiliarCaso($integrantes["Run"], $run_integrante, $caso->cas_id, $id_usu);
										
										if ($resultado["estado"] != 1) throw new \Exception("Ocurrio un Error al Vincular Integrante Familiar con Caso. Por Favor Verifique.");
									}
								}
			}
		}
	}

	public function asignarGestor(request $request){
         try{
		    DB::beginTransaction();
		    $mensaje_error_rsh = "";
		    $array_integrantes = array();

			if (isset($request->id_usu_anterior) && $request->id_usu_anterior != "" && !is_null($request->id_usu_anterior))
			{

				$resultado = DB::table('ai_persona_usuario')
				->where(["usu_id" => $request->id_usu_anterior, 'run' => $request->nna, 'cas_id' => $request->id_caso])->update(['usu_id' => $request->id_usu]);

				if (!$resultado) throw new \Exception("Ocurrio un Error al Reasignar Gestor a NNA. Por Favor Verifique.".$resultado);

			}else if (!isset($request->id_usu_anterior) || $request->id_usu_anterior == "" || is_null($request->id_usu_anterior)){
				
				/*Se obtiene información del NNA*/
				$datos_nna = Predictivo::where('run', $request->nna)->get();
				//    INICIO CZ SPRINT 59
			   if (count($datos_nna) == 0){
					$datos_nna = "";
					// throw new \Exception("No se encuentra RUN de NNA en Nómina. Por Favor Verifique.");
			   }else{
				$datos_nna = $datos_nna[0];
			   }	
				
				//    $persona_id = Persona::where("per_run", $datos_nna->run)->where("per_dig", $datos_nna->dv_run)->first();
				$persona_id = Persona::where("per_run", $request->nna)->first();
				//FIN CZ SPRINT 59 
			   if (count($persona_id) == 0 && $datos_nna != ""){ //NNA nunca creado en BD
					
					$persona =  $this->crearPersona($request->nna,$datos_nna);
					
					$this->guardarInfoContacto($datos_nna,$persona);
					
					$id_comuna_dir_1 = null;
					$comuna = Comuna::where('com_cod', $datos_nna->dir_com_1)->first();
					if (count($comuna) > 0) $id_comuna_dir_1 = $comuna->com_id;

					/*Se busca estado inicial del caso*/
					$estado = $this->estado_caso::where('est_cas_ini', 1)->get();
					$estado = $estado[0];
					
					/*Se busca la información del gestor que se esta asignando*/
					$comentario = "";
					$gestor_asignado = Usuarios::where("id", $request->id_usu)->get();
					if (count($gestor_asignado) > 0){
						$gestor_asignado = $gestor_asignado[0];
						$comentario = 'Se asigna caso a gestor ' . $gestor_asignado->nombres . ' ' . $gestor_asignado->apellido_paterno . ' ' . $gestor_asignado->apellido_materno . '.';
					}

					$caso = $this->crearCaso($comentario,$datos_nna,$estado);

					$caso->estados()->attach($estado->est_cas_id, ['cas_est_cas_des' => $comentario]);
					
					$this->crearCasoPersonaIndice($caso,$persona,$datos_nna);
									
					$this->vincularComunaCaso($id_comuna_dir_1,$caso);

					$this->guardarDireccion($datos_nna,$persona,$caso);
					
					$this->vincularAlertaCaso($request->nna,$caso);
					//Se vincula grupo familiar al caso
					$apiMds = new ApiMdsService;
					$rsh = $apiMds->getRsh($request->nna);	
					if($rsh->estado == 200){
						$fecha = (array) $rsh->grupo;
								}
						
					if (($rsh->estado != 200) && ($rsh->estado != 202)) {
						$mensaje_error_rsh = $rsh->mensaje;
						throw new \Exception($rsh->mensaje);
					}else{
						if (isset($rsh->integrantes)){
							$array_integrantes = $rsh->integrantes;
						}else{
							$grupo = $this->crearNNAGrupoFamiliar($request->nna,$datos_nna);
							
							$this->crearNNACasoGrupoFamiliar($caso,$grupo);
						}
					}
					if($rsh->estado == 200){
					$this->NNAGrupoFamiliarRSH($fecha,$array_integrantes, $request->nna, $caso, $request->id_usu);
					}
					// INICIO CZ SPRINT 69
					// OBTENER PERSONAS DEL CASO 
					$personasCaso = CasoPersonaIndice::where('cas_id', $caso->cas_id)->get();
					foreach($personasCaso as $key => $perCaso){
						$per = Persona::where('per_id', $perCaso->per_id)->first();
						$perdictivo = Predictivo::where('run', $per->per_run)->first();
						$this->crearDatosPersona($caso,$per,$perdictivo);
						// INICIO CZ SPRINT 68
						$this->guardarInfoLiceo($perdictivo,$per->per_id, $caso->cas_id);	
						// FIN CZ SPRINT 68 
					}
					// FIN CZ SPRINT 69
					/*Se asigna caso a gestor.*/
					$persona = DB::select("select * from ai_persona where per_run = $request->nna");
							$this->traspasoDireccionesAdicionales($persona[0]->per_id, $request->nna, $caso);
					// CZ SPRINT 74
							$nombreNNA = $persona[0]->per_nom;
							$rutFormato = Rut::parse($persona[0]->per_run.$persona[0]->per_dig)->format(); 
							$id_usuario = $request->id_usu;
							$id = $caso->cas_id;
							$tipo = 1;
							$estado = 1;
							$mensaje = 'Se ha asignado nuevo NNA '.$nombreNNA[0].'.'.$persona[0]->per_pat.'  '.$rutFormato. ' para su gestión.';
							$estado = 1;
							NotificacionAsignacion::crearNotificiacion($id_usuario, $id, $tipo, $mensaje, $estado);
							// CZ SPRINT 77
					$resultado = DB::table('ai_persona_usuario')->insert(['usu_id' => $request->id_usu, 'run' => $request->nna, 'cas_id' => $caso->cas_id]);
						$this->envioCorreoGestor($caso->cas_id, $gestor_asignado);
					
							// CZ SPRINT 77
					if (!$resultado){
						throw new \Exception("Ocurrio un error al vincular el caso con el gestor asignado. Por Favor Verifique.");
					}else{
						DB::commit();
					}
						// CZ SPRINT 74
			   }else if (count($persona_id) > 0 && $datos_nna != ""){ //NNA ya creado en BD
					
					$persona_id = $persona_id->per_id;
					
					$persona = Persona::where("per_run", $request->nna)->first();
					//$caso = DB::table('ai_caso c')->join("ai_estado_caso ec", "c.est_cas_id", "=", "ec.est_cas_id")->where("c.per_id", "=", $persona_id)->where("ec.est_cas_fin", "!=", 1)->get();
					//selecciona caso por id persona, no estan en estado final
					
					$caso = DB::select("SELECT * FROM ai_caso_persona_indice cpi 
							LEFT JOIN ai_caso c ON cpi.cas_id = c.cas_id
							LEFT JOIN ai_caso_estado_caso cec ON c.cas_id = cec.cas_id
							LEFT JOIN ai_estado_caso ec ON cec.est_cas_id = ec.est_cas_id 
							,(SELECT cas_id, max(cas_est_cas_fec) AS max_fec FROM ai_caso_estado_caso GROUP BY cas_id) subQuery
							WHERE subQuery.cas_id = cpi.cas_id AND subQuery.max_fec = cec.cas_est_cas_fec AND cpi.per_id = ".$persona_id." AND ec.est_cas_fin != 1 AND rownum = 1 ORDER BY c.created_at DESC");	
					
					
					if (count($caso) == 0){ //se crea caso
						//Se obtiene información del NNA
						$datos_nna = Predictivo::where('run', $request->nna)->get();
						
						if (count($datos_nna) == 0)	throw new \Exception("No se encuentra RUN de NNA en Nómina. Por Favor Verifique.");
						$datos_nna = $datos_nna[0];

						$this->editarPersona($persona_id,$datos_nna);

						$this->editarInfoContacto($datos_nna,$persona);

						//$this->editarDirecciones($datos_nna,$persona_id,$caso);

						// $this->actualizarInfoLiceo($datos_nna,$persona_id);

					/*Se busca estado inicial del caso*/
					$estado = $this->estado_caso::where('est_cas_ini', 1)->get();
					$estado = $estado[0];
						
					/*Se busca la información del gestor que se esta asignando*/
					$comentario = "";
						$gestor_asignado = Usuarios::where("id", $request->id_usu)->get();
						if (count($gestor_asignado) > 0){
							$gestor_asignado = $gestor_asignado[0];
						$comentario = 'Se asigna caso a gestor '.$gestor_asignado->nombres.' '.$gestor_asignado->apellido_paterno.' '.$gestor_asignado->apellido_materno .'.';

					}

					$caso = $this->crearCaso($comentario,$datos_nna,$estado);
					
					$caso->estados()->attach($estado->est_cas_id, ['cas_est_cas_des' => $comentario]);

					$this->crearCasoPersonaIndice($caso,$persona,$datos_nna);
					
					$id_comuna_dir_1 = null;
					$comuna = Comuna::where('com_cod', $datos_nna->dir_com_1)->first();
					if (count($comuna) > 0) $id_comuna_dir_1 = $comuna->com_id;

					$this->vincularComunaCaso($id_comuna_dir_1,$caso);

					$this->guardarDireccion($datos_nna,$persona,$caso);
	
					$this->vincularAlertaCaso($request->nna,$caso);
					//Se vincula grupo familiar al caso
					$apiMds = new ApiMdsService;
					$rsh = $apiMds->getRsh($request->nna);
					if($rsh->estado == 200){
						$fecha = (array) $rsh->grupo;
					}

					if (($rsh->estado != 200) && ($rsh->estado != 202)){
						$mensaje_error_rsh = $rsh->mensaje;
						throw new \Exception($rsh->mensaje);
					}else{
						if (isset($rsh->integrantes)){
							$array_integrantes = $rsh->integrantes;
						}else{
							//AGREGA NNA GRUPO FAMILIAR
							$fec_nac = new \DateTime($datos_nna->fecha_nac);

							$grupo = $this->crearNNAGrupoFamiliar($request->nna,$datos_nna);
							
							$this->crearNNACasoGrupoFamiliar($caso,$grupo);
							
						}
						}
						if($rsh->estado == 200){
							$this->NNAGrupoFamiliarRSHConCaso($fecha,$array_integrantes,$rsh,$caso,$request->id_usu,$request->nna);
						}
						
					// INICIO CZ SPRINT 69	
					// OBTENER PERSONAS DEL CASO 
					$personasCaso = CasoPersonaIndice::where('cas_id', $caso->cas_id)->get();
					foreach($personasCaso as $key => $perCaso){
						$per = Persona::where('per_id', $perCaso->per_id)->first();
						$perdictivo = Predictivo::where('run', $per->per_run)->first();
						$this->crearDatosPersona($caso,$per,$perdictivo);
						// INICIO CZ SPRINT 68
						$this->guardarInfoLiceo($perdictivo,$per->per_id,$caso->cas_id);	
						// FIN CZ SPRINT 68
					}
							$persona = DB::select("select * from ai_persona where per_run = $request->nna");
							$this->traspasoDireccionesAdicionales($persona[0]->per_id, $request->nna, $caso);
						// CZ SPRINT 74
							$nombreNNA = $persona[0]->per_nom;
							$rutFormato = Rut::parse($persona[0]->per_run.$persona[0]->per_dig)->format(); 
							$id_usuario = $request->id_usu;
							$id = $caso->cas_id;
							$tipo = 1;
							$estado = 1;
							$mensaje = 'Se ha asignado nuevo NNA '.$nombreNNA[0].'.'.$persona[0]->per_pat.'  '.$rutFormato. ' para su gestión.';
							$estado = 1;
							
							NotificacionAsignacion::crearNotificiacion($id_usuario, $id, $tipo, $mensaje, $estado);
							
								$this->envioCorreoGestor($caso->cas_id, $gestor_asignado);
							
					/*Se asigna caso a gestor.*/
					$resultado = DB::table('ai_persona_usuario')->insert(['usu_id' => $request->id_usu, 'run' => $request->nna, 'cas_id' => $caso->cas_id]);

						if (!$resultado){
							throw new \Exception("Ocurrio un error al vincular el caso con el gestor asignado. Por Favor Verifique.");

						}else{
							
							DB::commit();
						} 					
					}else if (count($caso) > 0){ //existe caso abierto
						//INICIO CZ SPRINT 58 
						$this->reasignarGestor($request->id_usu,$caso);
						//FIN CZ SPRINT 58
						// FIN CZ SPRINT 68
					}
			}
			}
			$this->traspasoContactoParentesco2($request->nna);
			TiempoIntervencionCaso::crearTiempoIntervencion($caso->cas_id);
			if ($request->post){
				return redirect()->back()
				->with('success', 'Se ha asignado correctamente NNA a Gestor.');
			
			}else{
				$mensaje = "Se ha asignado correctamente NNA a Gestor.";
				return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'caso_asig' => $caso->cas_id), 200);			
			}

			

		 }catch(\Exception $e){
		 	DB::rollback();
		 	Log::info('error ocurrido:'.$e);

		 	$mensaje = $e->getMessage();
		 	if ($mensaje_error_rsh != ""){
		 		$mensaje = "Error al momento de asignar NNA a Gestor, descripción: ".$mensaje_error_rsh;
		 	}
			
			if ($request->post){
				 return redirect()->back()->with('danger', $mensaje);
		
			}else{
				 return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				 
			}
		 }
	}
		
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function oficinaLocal(){
		
		return view('caso.oficina_local');
		
	}
	/**
	 * Envío de correo a gestor
	 */
	public function envioCorreoSectorialista($run_nna){
		$data_sectorialista = DB::select("select am.ale_man_id, am.ale_man_run, am.dim_id, am.ale_man_nna_nombre, au.id, au.id_perfil, au.email, pr.pro_nom, cm.com_nom 
		from ai_alerta_manual am inner join ai_usuario au on (am.id_usu = au.id) inner join ai_programa pr on (am.dim_id = pr.dim_id) left join ai_comuna cm on (am.com_id = cm.com_id) 
		where am.ale_man_run = ".$run_nna." and rownum = 1");

		if (isset($data_sectorialista[0]->id_perfil)){
			if($data_sectorialista[0]->id_perfil == 5){ //es sectorialista
				$objDemo = new \stdClass();
				//Correccion Sprint61 Andres F.
				$objDemo->tipo_correo = 'asignacion';
				//Fin Correccion Sprint61 Andres F.
				$objDemo->nombre_programa = $data_sectorialista[0]->pro_nom;
				$objDemo->nombre_comuna = $data_sectorialista[0]->com_nom;
				$objDemo->nombre_nna = $data_sectorialista[0]->ale_man_nna_nombre;

				//Mail::to($destinatarios[0]->email)->send(new MailController($objDemo));
				//corrección envío dinámico Sprint 61 Andres F
				Mail::to($data_sectorialista[0]->email)->send(new MailController($objDemo));
			}

		}
	}
// CZ SPRINT 74
	public function envioCorreoGestor($caso, $gestor_asignado){
		$objDemo = new \stdClass();
		$objDemo->tipo_correo = 'asignacionGestor';
		$objDemo->caso = $caso;
		Mail::to($gestor_asignado->email)->send(new MailController($objDemo));
	}
// CZ SPRINT 74
	/**
	 * Paso de las direcciones adicionales a tabla dirección
	 */
	// INICIO CZ SPRINT 68
	public function traspasoDireccionesAdicionales($id_persona, $run_persona, $caso){
// INICIO CZ SPRINT 69
		$casoEstado = Caso::leftJoin('ai_estado_caso', "ai_caso.est_cas_id", "=", "ai_estado_caso.est_cas_id")->where('cas_id', $caso->cas_id)->where('est_cas_fin', '<>', 1)->get();

		if(count($casoEstado) > 0){		
		// INICIO CZ SPRINT 63
		$direcciones_adicionales = DB::select("SELECT * FROM ai_direccion_adicionales d 
			LEFT JOIN ai_comuna c ON d.dir_com = c.com_cod
										LEFT JOIN ai_provincia p ON c.pro_id = p.pro_id
										LEFT JOIN ai_region r ON p.reg_id = r.reg_id
			WHERE dir_com != 0 and  d.run ="."$run_persona");
		// FIN CZ SPRINT 63	
		foreach($direcciones_adicionales as $key => $direcciones_add){
				// INICIO CZ SPRINT 69
				$direccion = Direccion::where("com_id", '=', $direcciones_add->com_id)->where("per_id", '=', $id_persona)->where("dir_fue", '=', $direcciones_add->dir_fuente)->where("dir_call", '=', $direcciones_add->dir_calle)->where("dir_num", '=', $direcciones_add->dir_num)->where("dir_dep", '=', $direcciones_add->dir_dpto)->where("dir_sit", '=', $direcciones_add->dir_sitio)->where("dir_block", '=', $direcciones_add->dir_block)->where("dir_fecha", '=', $direcciones_add->dir_fecha)->where("cas_id","=",$caso->cas_id)->get();
				// FIN CZ SPRINT 69
			if(count($direccion) == 0){
						if($direcciones_add->com_id != 0 || $direcciones_add->com_id != null){
				// INICIO CZ SPRINT 68
				$direccion_ord = Direccion::where("dir_ord",$direcciones_add->dir_orden)->where("per_id", '=', $id_persona)->where("cas_id","=",$caso->cas_id)->first();
				if(count($direccion_ord)>0){
					$dirupdate = Direccion::find($direccion_ord->dir_id);
					$max = DB::select('select MAX(DIR_ORD) as max from "AI_DIRECCION" where "PER_ID" = '.$id_persona.' and "CAS_ID" =' . $caso->cas_id);
					$dirupdate->dir_ord = $max[0]->max+1;
					$dirupdate->save();
				}
				// FIN CZ SPRINT 68
				$max = Direccion::max('dir_id');
				$registrar = new Direccion();
				$registrar->dir_id = $max+1;
				// INICIO CZ SPRINT 63
				$registrar->per_id = $id_persona;	
				// FIN CZ SPRINT 63	
				// INICIO CZ SPRINT 61
					$registrar->com_id = $direcciones_add->com_id;
				// FIN CZ SPRINT 61 
				$registrar->dir_ord = $direcciones_add->dir_orden;		
				$registrar->dir_fue = $direcciones_add->dir_fuente;		
				$registrar->dir_call = $direcciones_add->dir_calle;		
				$registrar->dir_num = $direcciones_add->dir_num;		
				$registrar->dir_dep = $direcciones_add->dir_dpto;				
				$registrar->dir_sit = $direcciones_add->dir_sitio;		
				$registrar->dir_block = $direcciones_add->dir_block;		
				$registrar->dir_fecha = $direcciones_add->dir_fecha;
				$registrar->origen =  1;
				// INICIO CZ SPRINT 68
				$registrar->cas_id   = $caso->cas_id;
				// FIN CZ SPRINT 68
				$respuesta = $registrar->save();

				if (!$respuesta){
					DB::rollback();
								$mensaje = "Hubo error al momento de asignar NNA. Por favor intente nuevamente o contáctese con el asistente técnico(a).";
	
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}	
			}
					}
				// FIN CZ SPRINT 69
			}
		// INICIO CZ SPRINT 69
		}
	}

	public function ordenarDirecciones($id_persona, $run_persona, $caso){
		$direcciones = Direccion::where('per_id', '=', $id_persona)->where('cas_id', '=', $caso->cas_id)->get();
		foreach($direcciones as $key => $direccion){
			$dirord = Direccion::select("dir_id")->where('per_id', '=', $id_persona)->where('cas_id', '=', $caso->cas_id)->where("dir_ord", "=", $key+1)->get();
			// INICIO CZ SPRINT 69
			if(count($dirord)>=1){
			// FIN CZ SPRINT 69
				$dirmax_ord = DB::select('select max(dir_ord) as max from AI_DIRECCION where per_id = '. $id_persona .  " and cas_id = " .$caso->cas_id);
				$minimoDir = $dirord[0]->dir_id;
				foreach($dirord as $key => $diro){
					if ($minimoDir > $diro->dir_id){
						$minimoDir = $diro->dir_id;
					}
				}

				$updateDir = Direccion::find($minimoDir);
				$updateDir->dir_ord = $dirmax_ord[0]->max+1;
				$updateDir->save();
				
			}
		}
		DB::commit();	
	}
	// FIN CZ SPRINT 68

	/**
	 * Paso de contactos a tabla ai_contacto_parentesco_2
	 * Solo se pasaran registros cuya comuna no sea null
	 */
	public function traspasoContactoParentesco2($run_persona){
		$contacto_parentesco = DB::select("SELECT * FROM ai_alerta_contacto_parentesco 
										WHERE run =".$run_persona);
		
		if (count($contacto_parentesco) > 0){
			foreach ($contacto_parentesco as $key => $value) {
				//INICIO CZ SPRINT 65 
				$where = '';

				if($value->numero_contacto != null){
					$where .= ' and NUMERO_CONTACTO =' ."'$value->numero_contacto'"; 
				}else{
					$where .= ' and NUMERO_CONTACTO is null ';
				}

				$validarSiExiste = DB::select("SELECT * FROM AI_CONTACTO_PARENTESCO_2 
												WHERE run ={$run_persona} 
												and FUENTE= '{$value->fuente}'  
												and PARENTESCO = '{$value->parentesco}' 
												" . $where);

				if(count($validarSiExiste) == 0){
					
				$value->fecha_ingreso = is_null($value->fecha_ingreso) ? 0 : $value->fecha_ingreso;
					
				if(!is_null($value->comuna)){
				//INICIO CZ SPRINT 58 
				// $resultado = DB::insert("INSERT INTO AI_CONTACTO_PARENTESCO_2 (PERIODO, RUN, FECHA_INGRESO, FUENTE, NOMBRE_CONTACTO, PARENTESCO, NUMERO_CONTACTO, TIPO_NUMERO, ORDEN_CONTACTO, TIPO_DATO, COMUNA) 
				// VALUES (".$value->periodo.",".$run_persona.",".$value->fecha_ingreso.",'".$value->fuente."','".$value->nombre_contacto."','".$value->parentesco."','".$value->numero_contacto."',".$value->tipo_numero.",".$value->orden_contacto.",".$value->tipo_dato.",'".$value->comuna."'".")");				
				$contactoP2 = new ContactoParentesco2();
				$contactoP2->PERIODO = $value->periodo;
				$contactoP2->RUN = $run_persona; 
				$contactoP2->FECHA_INGRESO = $value->fecha_ingreso; 
				$contactoP2->FUENTE = $value->fuente; 
				$contactoP2->NOMBRE_CONTACTO = $value->nombre_contacto; 
				$contactoP2->PARENTESCO = $value->parentesco; 
				$contactoP2->NUMERO_CONTACTO = $value->numero_contacto; 
				$contactoP2->TIPO_NUMERO = $value->tipo_numero; 
				$contactoP2->ORDEN_CONTACTO = $value->orden_contacto; 
				$contactoP2->TIPO_DATO = $value->tipo_dato; 
				$contactoP2->COMUNA = $value->comuna; 
				// $contactoP2->CATEGORIA = "0";
				
				$resultado = $contactoP2->save();
				//FIN CZ SPRINT 58 
				if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de contacto parentesco. Por Favor Verifique.");													
					}else{
					// $resultado = DB::insert("INSERT INTO AI_CONTACTO_PARENTESCO_2 (PERIODO, RUN, FECHA_INGRESO, FUENTE, NOMBRE_CONTACTO, PARENTESCO, NUMERO_CONTACTO, TIPO_NUMERO, ORDEN_CONTACTO, TIPO_DATO, COMUNA) 
					// VALUES (".$value->periodo.",".$run_persona.",".$value->fecha_ingreso.",'".$value->fuente."','".$value->nombre_contacto."','".$value->parentesco."','".$value->numero_contacto."',".$value->tipo_numero.",".$value->orden_contacto.",".$value->tipo_dato.",'S/I'".")");				
						//INICIO CZ SPRINT 58 
						$ContactoParentesco2 = new ContactoParentesco2();
						$ContactoParentesco2->periodo = $value->periodo;
						$ContactoParentesco2->run = $run_persona;
						$ContactoParentesco2->fecha_ingreso = $value->fecha_ingreso;
						$ContactoParentesco2->fuente = $value->fuente;
						$ContactoParentesco2->nombre_contacto = $value->nombre_contacto;
						$ContactoParentesco2->parentesco = $value->parentesco;
						$ContactoParentesco2->numero_contacto = $value->numero_contacto;
						$ContactoParentesco2->tipo_numero = $value->tipo_numero;
						$ContactoParentesco2->orden_contacto = $value->orden_contacto;
						$ContactoParentesco2->tipo_dato = $value->tipo_dato;
						$ContactoParentesco2->comuna = 'S/I';
						// $ContactoParentesco2->categoria = $value->id_categoria;
						$resultado = $ContactoParentesco2->save();
						//FIN CZ SPRINT 58 
					if (!$resultado) throw new \Exception("Ocurrio un Error Guardando Información de contacto parentesco. Por Favor Verifique.");																		
				}
		}		
			}		
	}

		$contacto_parentesco2 = DB::select("SELECT * FROM AI_CONTACTO_PARENTESCO_2  
										WHERE run =".$run_persona . " order by fecha_ingreso desc");
			
			$cotador = 1;
			foreach($contacto_parentesco2  as $key => $value){
				// INICIO CZ SPRINT 69
				$value->fecha_ingreso = is_null($value->fecha_ingreso) ? 0 : $value->fecha_ingreso;
				// FIN CZ SPRINT 69
				$actualizaCaso = DB::update("update  AI_CONTACTO_PARENTESCO_2 set orden_contacto = {$cotador} 
				where run = {$run_persona}  and 
				fecha_ingreso = {$value->fecha_ingreso} and
				(FUENTE = '{$value->fuente}' or  FUENTE is null) and 
				(PARENTESCO = '{$value->parentesco}' or PARENTESCO  is null)  and 
				(NUMERO_CONTACTO = '{$value->numero_contacto}' or NUMERO_CONTACTO is null)");
				$cotador = $cotador+1;	
				if (!$actualizaCaso) {
					DB::rollback();
					$mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
						
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
			}
			DB::commit();
		
	}

    /**
	* Función que actualiza el campo categoria de la tabla ai_contacto_parentesco_2
	*/
	public function actualizacategoria(Request $request){
		
		$mensaje = "Categoría actualizada";
		$sql = "UPDATE ai_contacto_parentesco_2 set categoria = ".$request->value." where run = ".$request->run." and orden_contacto = ".$request->orden;
	    $sql = DB::update($sql);
		if(!$sql){
			$mensaje = "Error al actualizar Categoría. Contacto a Administrador";
		}
		return $mensaje;
	}



	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function casosComunales(){
		$comuna = explode(',',session()->all()['com_cod']);

		//$cantidad_casos = NNAAlertaManualCaso::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->groupBy('cas_id')->get();
		// CZ SPRINT 74
		$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->where('est_cas_fin', '<>',1)->groupBy('cas_id')->get();
		$cantidad_casos = count($cantidad_casos);
		$icono = Funcion::iconos(121);

		return view('caso.comunales', [
			"cantidad_casos" => $cantidad_casos,
			"icono" => $icono
		]);
		
	}
	
	
	/**
	 * Listado json de NNA para la oficina local NNA
	 */
	public function listarNNA(){

		$comuna = explode(',',session()->all()['com_cod']);
		
		return Datatables::of(NominaComunal::query()->whereIn('cod_com', $comuna))
				->addColumn('color', function ($caso){
					return $caso->score;
				}, true)
				->addColumn('prueba12', function($caso){
					return 'algo';
				})
				->rawColumns(['color'])
				->make(true);
	}

	public function obtenerCantidadAlertasNNA(request $request){
		$cas_id = $request->cas_id;
		$est_cas_id = $request->est_cas_id;
		$run = $request->run;
		if($est_cas_id == config('constantes.en_prediagnostico') || $est_cas_id == config('constantes.en_diagnostico')){
			$condicion = 'AND ea.est_ale_id BETWEEN 1 AND 6';
		}else{
			$condicion = 'AND ea.est_ale_id BETWEEN 2 AND 6' ;
		}
		// INICIO CZ SPRINT 63 Casos ingresados a ONL
		$casos = DB::select("select cas_id from ai_persona_usuario where run = {$run}");
		$menor = $cas_id;
		$validaAlerta = "";
		if(count($casos) > 1){
			foreach($casos as $key => $cas){
				if($cas->cas_id<$cas_id){
					$menor = $cas->cas_id;
				}
			}
			$estadoCasoMenor = DB::select("select est_cas_id from ai_caso where cas_id = {$menor}");
		
			if($menor == $cas_id){
				$validaAlerta = "and am.ale_man_fec <= (select cas_est_cas_fec as fecha from AI_CASO_ESTADO_CASO where CAS_ID = {$cas_id} and EST_CAS_ID ={$est_cas_id})";
			}else{
				if(count($casos) == 2){
					if($est_cas_id != 5 || $est_cas_id != 10 || $est_cas_id != 6 || $est_cas_id != 4 || $est_cas_id !=3 || $est_cas_id !=1){
						$validaAlerta = "and am.ale_man_fec >= (select cas_est_cas_fec as fecha from AI_CASO_ESTADO_CASO where CAS_ID = {$menor} and EST_CAS_ID ={$estadoCasoMenor[0]->est_cas_id}) and am.ale_man_fec <= (select cas_est_cas_fec as fecha from AI_CASO_ESTADO_CASO where CAS_ID = {$cas_id} and EST_CAS_ID ={$est_cas_id})";
					}else{
						$validaAlerta = "and am.ale_man_fec >= (select cas_est_cas_fec as fecha from AI_CASO_ESTADO_CASO where CAS_ID = {$menor} and EST_CAS_ID ={$estadoCasoMenor[0]->est_cas_id})";
					}
					
				}
			}
			
		}else{
			if($est_cas_id != 5 || $est_cas_id != 10 || $est_cas_id != 6 || $est_cas_id != 4 || $est_cas_id !=3 || $est_cas_id !=1){
				$validaAlerta = "and am.ale_man_fec <= (SELECT SYSTIMESTAMP FROM dual)";
			}else{
				$validaAlerta = "and am.ale_man_fec <= (select cas_est_cas_fec as fecha from AI_CASO_ESTADO_CASO where CAS_ID = {$cas_id} and EST_CAS_ID ={$est_cas_id})";
			}
		}

		
		//$estadoCaso = CasoEstado::select('cas_est_cas_fec')->where('cas_id',$cas_id)->where('est_cas_id', $est_cas_id)->get();
		//INICIO DC 
	    $tipoAlerta = DB::select("SELECT 
            am.est_ale_id, 
            am.ale_man_id, 
            am.ale_man_dir_usu,
            at.ale_tip_id, 
            at.ale_tip_nom, 
            count(at.ale_tip_id) as cantidad,
            ea.est_ale_nom,
            amt.ale_man_info_rel
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
			WHERE cpi.cas_id=".$cas_id." $validaAlerta   
			GROUP BY at.ale_tip_id,
            at.ale_tip_nom, 
            am.ale_man_id, 
            am.est_ale_id, 
            ea.est_ale_nom, 
            am.ale_man_fec, 
            am.ale_man_dir_usu,
            amt.ale_man_info_rel
            ORDER BY am.ale_man_fec desc" );
	       //FIN DC

		  

/*
		$tipoAlerta = DB::select(" SELECT am.est_ale_id, am.ale_man_id, at.ale_tip_id, at.ale_tip_nom, count(at.ale_tip_id) as cantidad
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
			WHERE cpi.cas_id=".$cas_id." ".$condicion." GROUP BY at.ale_tip_id,at.ale_tip_nom, am.est_ale_id, am.ale_man_id" );*/
			
			return count($tipoAlerta);
			//FIN CZ SPRINT 63 Casos ingresados a ONL
	}

	/**
	 * Listado json de NNA para la oficina local NNA
	 */
	public function listarNNAComunales(){

		// com_cod CODIGO DE LA COMUNA 
		$comuna = explode(',',session()->all()['com_cod']);
		// CZ SPRINT 77
		$query = CasosGestionEgresado::query()->whereIn('cod_com', $comuna)->where('est_cas_fin',0);
		return Datatables::of($query)
				->addColumn('color', function ($caso){
					return $caso->score;
				}, true)
				->addColumn('terapeuta', function ($caso){
					if($caso->ter_id){
						$usu = Usuarios::find($caso->ter_id);
						$ter_nom = $usu->nombres.' '.$usu->apellido_paterno.' '.$usu->apellido_materno;
					}else{
						$ter_nom = 'Sin Terapeuta';
					}
					return $ter_nom;
				}, true)
				->rawColumns(['color'])
				->make(true);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function asignarNNA(){
		//$com_ses	= session()->all()['comunas'];
		$com_ses 	= array();
		$com_id 	= session()->all()['com_id'];
		if (isset($com_id) && $com_id != ""){
			$com_id = explode(",", $com_id);

			if (count($com_id) > 0) $com_ses = Comuna::whereIn("com_id", $com_id)->get();
		}

		$icono = Funcion::iconos(25);

		//dd($icono);
		
		return view('caso.asignar_nna')->with([
			'com_ses'	=> $com_ses,
			'icono' => $icono
		]);
		
	}
	
	
	/**
	 * Listado json para asignar NNA filtrado por las comunas del usuario registrado
	 * @param $cod_cod
	 */
	public function listarAsignarNNA($cod_com){
		
		//$comuna = explode(',',session()->all()['com_cod']);
		$comuna = explode(",", $cod_com);
// CZ SPRINT 74
        return Datatables::of(NominaComunal::query()
        	->Where('descartado', '=', '0')
            ->whereIn('cod_com', $comuna)
            ->where(function ($query) {
                $query->whereNull('usuario_id')
                      ->orWhere('est_cas_fin', '=', '1');
            }))
            ->make(true);
        // ----------------------------------------------------

		//return Datatables::of(NominaComunal::query()->whereIn('cod_com', $comuna)
				//->whereNull('usuario_id')->orWhere('est_cas_fin','1'))
				//->addColumn('runsinformato', function ($caso) {
				//	return $caso->nna_run;
				//}, true)
				//->rawColumns(['runsinformato'])
				//->make(true);
	}

	/* inicio Andres F sprint 63 */
	public function obtieneCasosAnteriores(request $request){
		/* inicio Andres F corrección sprint 63 */
		$registros = DB::select("select ai_caso.cas_id,ai_estado_caso.est_cas_nom,ai_caso_estado_caso.cas_est_cas_fec  from ai_persona_usuario 
		inner join ai_caso on ai_persona_usuario.cas_id = ai_caso.cas_id 
		inner join ai_caso_estado_caso on  ai_caso.cas_id =  ai_caso_estado_caso.cas_id 
		inner join ai_estado_caso on ai_caso_estado_caso.est_cas_id = ai_estado_caso.est_cas_id 
		where ai_persona_usuario.run = ".$request->run_nna." and ai_caso_estado_caso.est_cas_id = ai_caso.est_cas_id order by cas_id desc");
		/* FIN Andres F corrección sprint 63 */

		//return json_encode($registros);
	
		/*$opt = new \stdClass();
		$opt->cas_id = 3456;
		$opt->est_cas_nom = 'prueba maldicion';
		$opt->cas_est_cast_fec = '2021-04-23';
		array_push($registros, $opt);*/
		//print_r($registros);die();
		return Datatables::of(collect($registros))->make(true);
	}

/* Fin Andres F sprint 63 */


	/**
	 * Listado json para asignar NNA filtrado por las comunas del usuario registrado
	 * @param $cod_cod
	 */
	public function listarAsignarNNADOS(request $request){

		 $columns = array( 
            0 =>'run', 
            1 =>'nna_run_con_formato', 
            2 =>'nna_run',
            3 => 'score',
            4 => 'est_cas_nom'
        );


		$com_cod = session('com_cod');

      	$totalData = DB::select("select count(run) as total
				from vw_ai_nna_am
				where cod_com in (".$com_cod.")
				and (usuario_id is null or est_cas_fin=1)
				");

        $totalData = $totalData[0]->total;

        $totalFiltered = $totalData;

   		$limit = $request['length'];
   		$start = $request['start'];

   		$order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {                   
        	$registros = DB::select("SELECT T.* FROM ( 
				SELECT T.*, rowNum as rowIndex
				FROM (
				    select run, nna_run_con_formato, nna_run, score,n_am,est_cas_nom 
				from vw_ai_nna_am
				where cod_com in (".$com_cod.")
				and (usuario_id is null or est_cas_fin=1)
				)T)T
				WHERE rowIndex between ".$start." AND ".intval($limit+$start). " order by ".$order." ".$dir);
                                      
        }else{            
            $search = $request->input('search.value'); 

   			$registros = DB::select("SELECT T.* FROM ( 
				SELECT T.*, rowNum as rowIndex
				FROM (
				    select run, nna_run_con_formato, nna_run, score,n_am,est_cas_nom 
				from vw_ai_nna_am
				where cod_com in (".$com_cod.") and
				 run like '%".$search."%' or
				 nna_run_con_formato like '%".$search."%' or
				 nna_run like '%".$search."%' or
				 score like '%".$search."%' or
				 n_am like '%".$search."%'
				and (usuario_id is null or est_cas_fin=1)
				)T)T
				WHERE rowIndex between ".$start." AND ".intval($limit+$start). " order by ".$order." ".$dir);

   				$totalFiltered = sizeof($registros);
        }
        
        $data_resultante = array();
        
        if(!empty($registros))
        {
            foreach ($registros as $detalle_registro)
            {
                $array_detalle_registros['nna_run_con_formato'] = $detalle_registro->nna_run_con_formato;
                $array_detalle_registros['nna_run'] = $detalle_registro->nna_run;
                $array_detalle_registros['score'] = $detalle_registro->score;   
				$array_detalle_registros['n_am'] = $detalle_registro->n_am;  
                $array_detalle_registros['est_cas_nom'] = $detalle_registro->est_cas_nom;
                $array_detalle_registros['run'] = $detalle_registro->run;
                $data_resultante[] = $array_detalle_registros;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data_resultante   
        );
		
		return json_encode($json_data);
	}

	
	
	/**
	 * Método que lista los gestores y su cantidad de NNA asignados
	 */
	public function listarAsignadosGestores($com_id){
		// INICIO CZ SPRINT 64
		if (App::environment('local') || App::environment('qa') || App::environment('desa') || App::environment('QA')) {
		$gestores = DB::select("SELECT u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre, id FROM ai_usuario u 
			LEFT JOIN ai_usuario_comuna uc ON u.id = uc.usu_id WHERE uc.com_id = ".$com_id." AND u.id_perfil = ".config('constantes.perfil_gestor')." AND u.id_estado = 1");	
		}else{
			$gestores = DB::select("SELECT u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre, id FROM ai_usuario u 
			LEFT JOIN ai_usuario_comuna uc ON u.id = uc.usu_id WHERE uc.com_id = ".$com_id." AND u.id_perfil = ".config('constantes.perfil_gestor')." AND u.id_estado = 1 AND u.id != ".config('constantes.gestor_prueba')."");
		}
		// FIN CZ SPRINT 64
		if (count($gestores) > 0 ){
			foreach ($gestores as $c0 => $v0){
				$casos_asignados = DB::select("SELECT c.cas_id FROM ai_persona_usuario pu LEFT JOIN ai_caso c ON pu.cas_id = c.cas_id 
				LEFT JOIN ai_caso_comuna cc ON c.cas_id = cc.cas_id LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id 
				WHERE cc.com_id = ".$com_id." AND pu.usu_id = ".$v0->id." AND ec.est_cas_fin = 0 GROUP BY c.cas_id");

				$gestores[$c0]->asignados = 0;
				if (count($casos_asignados) > 0) $gestores[$c0]->asignados = count($casos_asignados);
			}
		}						
		
		$data		= new \stdClass();
		$data->data = $gestores;
		
		echo json_encode($data); exit;
		
	
	}
	
	public function firmaConsentimiento(){
		
		$today = Carbon::now()->format('d/m/Y');
		$pdf = \PDF::loadView('pdf.firma_consentimiento',compact('today'));
		
		return $pdf->download('ejemplo.pdf');
		
	}
	
	public function cambioEstadoCaso(request $request){
		try{
			DB::beginTransaction();
			
			if (!isset($request->option) || $request->option == "" || !isset($request->caso_id) || $request->caso_id == ""){
				$mensaje = "Falta datos para completar el proceso. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			$cambio_estado = true;
			$desest_terapia = false;
// CZ SPRINT 77
			$perteneceNotificacion = CasosGestionEgresado::query()
            ->where('est_cas_fin','<>',1)
			->where('cas_estado', 'RETRASADO')
			->where('cas_id', $request->caso_id)
			->count();

			switch ($request->option){
				case config('constantes.rechazado_por_familiares'): //Rechazado x Familia
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.rechazado_por_familiares');
					$comentario = $request->comentario;
				break;
				
				case config('constantes.rechazado_por_gestor'): //Rechazado x Gestor
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.rechazado_por_gestor');
					$comentario = $request->comentario;
				break;

				case 13: //Bitacora - En prediagnostico
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_prediagnostico');
					$comentario = $request->comentario;
				break;
				
				case 'b3': //Bitacora - En diagnostico
				//case 3: //Bitacora - En diagnostico
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_diagnostico');
					$comentario = $request->comentario;
				break;
				
				case 'b4': //Bitacora - En elaboracion
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_elaboracion_paf');
					$comentario = $request->comentario;
				break;
				
				case 'b5': //Bitacora - En ejecucion
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_ejecucion_paf');
					$comentario = $request->comentario;
				break;
				
				case 'b6': //Bitacora - Cierre PAF
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_cierre_paf');
					$comentario = $request->comentario;
				break;

				case 'b7': //Bitacora - Seguimiento PAF
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_seguimiento_paf');
					$comentario = $request->comentario;
				break;

				//Inicio cambio para egreso Andres F. 
				case 'b8': //Bitacora - Egreso
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.egreso_paf');
					$comentario = $request->comentario;
				break;
				//Fin cambio para egreso Andres F. 

				/*case 7: //Bitacora - Seguimiento
					$cambio_estado = false;
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_seguimiento_paf');
					$comentario = $request->comentario;
				break;*/

				case 15: //En Diagnostico
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_diagnostico');
					$comentario = $request->comentario;						
				break;
				
				case config('constantes.en_elaboracion_paf'): //Elaboracion PAF
				//case 8: //Elaboracion PAF
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_elaboracion_paf');
					$comentario = $request->comentario;
				break;
				
				case config('constantes.en_ejecucion_paf'): //Ejecucion PAF
				//case 9: //Ejecucion PAF
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_ejecucion_paf');
					$comentario = $request->comentario;


					$selectTareaBit = DB::select("select a.tar_id
						FROM ai_obj_tarea_paf a
						INNER JOIN ai_objetivo_paf b
						ON a.obj_id = b.obj_id 
						where a.est_tar_id='1' and b.cas_id='".$caso_id."'");

					if($selectTareaBit){

						foreach ($selectTareaBit as  $val) {

								$actualizaTareaBit = DB::insert("INSERT INTO ai_obj_tar_bit_paf(TAR_ID,EST_TAR_ID,FECHA)VALUES('".$val->tar_id."','2','".Carbon::now()."')");

						}
					}

					$actualizar_estado_tareas = DB::update("update (select * FROM ai_obj_tarea_paf a
					INNER JOIN ai_objetivo_paf b
					ON a.obj_id = b.obj_id where a.est_tar_id='".config('constantes.est_tarea_vigente')."' and b.cas_id='".$caso_id."')
					SET EST_TAR_ID='".config('constantes.est_tarea_en_ejecucion')."'");


					$integrantes_familiares = CasoGrupoFamiliar::where("cas_id", "=", $caso_id)->get();
					foreach ($integrantes_familiares AS $c1 => $v1){
						//ASIGNACION CON ALERTA TERRITORIAL
						$asignacion_con_at = DB::select("SELECT * FROM ai_am_programas ap LEFT JOIN ai_estados_programas ep ON ap.est_prog_id = ep.est_prog_id WHERE ap.gru_fam_id = ".$v1->gru_fam_id." AND ep.est_prog_ini = 1");

						foreach ($asignacion_con_at AS $c2 => $v2){
							$actualizar_bitacoras	=	DB::table('ai_estados_programas_bit')->insert(['am_prog_id' => $v2->am_prog_id, 'est_prog_id' => config('constantes.pendiente'), 'est_prog_bit_des' => 'Se realiza derivación a sectorialista.']);

							if (!$actualizar_bitacoras){
								DB::rollback();
								$mensaje = "Error al momento de insertar los nuevos estados de los programas asignados. Por favor intente nuevamente.";

								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
							}

							$actualizar_asignaciones	=	DB::table('ai_am_programas')->where('am_prog_id', $v2->am_prog_id)->update(['est_prog_id' => config('constantes.pendiente')]);

							if (!$actualizar_asignaciones){
								DB::rollback();
								$mensaje = "Error al momento de realizar la actualización de los estados de los programas asignados. Por favor intente nuevamente.";

								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
							}
						}

						//ASIGNACION CON ALERTA TERRITORIAL

						//ASIGNACION SIN ALERTA TERRITORIAL
						$asignacion_sin_at = DB::select("SELECT * FROM ai_grup_fam_programas ap LEFT JOIN ai_estados_programas ep ON ap.est_prog_id = ep.est_prog_id WHERE ap.gru_fam_id = ".$v1->gru_fam_id." AND ep.est_prog_ini = 1");

						foreach ($asignacion_sin_at AS $c3 => $v3){
							$actualizar_bitacora	=	DB::table('ai_estados_gfam_programas_bit')->insert(['grup_fam_prog_id' => $v3->grup_fam_prog_id, 'est_prog_id' => config('constantes.pendiente'), 'est_prog_bit_des' => 'Se realiza derivación a sectorialista.']);

							if (!$actualizar_bitacora){
								DB::rollback();
								$mensaje = "Error al momento de insertar los nuevos estados de los programas asignados. Por favor intente nuevamente.";

								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
							}

							$actualizar_asignacion	=	DB::table('ai_grup_fam_programas')->where('grup_fam_prog_id', $v3->grup_fam_prog_id)->update(['est_prog_id' => config('constantes.pendiente')]);

							if (!$actualizar_asignacion){
								DB::rollback();
								$mensaje = "Error al momento de realizar la actualización de los estados de los programas asignados. Por favor intente nuevamente.";

								return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
							}
						}
						//ASIGNACION SIN ALERTA TERRITORIAL

					}
				break;
				
				case config('constantes.en_cierre_paf'): //Cierre PAF
				//case 10: //Cierre PAF
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_cierre_paf');
					$comentario = $request->comentario;
				break;
				
				//case 11: //Seguimiento PAF
				case config('constantes.en_seguimiento_paf'): //Seguimiento PAF
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.en_seguimiento_paf');
					$comentario = $request->comentario;
				break;
				
				case config('constantes.egreso_paf'): //Egreso PAF
				//dd("okok333");
				//case 12: //Egreso PAF
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.egreso_paf');
					$comentario = $request->comentario;
								// INICIO CZ SPRINT 56
						//se realiza cambio de estado de la terapia a egresado 
						$terapia = Terapia::where("cas_id", "=", $caso_id)->first();
						if($terapia != null){
							$terapia->est_tera_id = 12;
						$resultado = $terapia->save();
						
						if (!$resultado) {
							DB::rollback();
							$mensaje = "Error al momento de actualizar estado de la terapia. Por favor intente nuevamente.";
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
						}
						$bitacora = new EstadoTerapiaBitacora();
						$bitacora->tera_id = $terapia->tera_id;
						$bitacora->est_tera_id = 12;
						// INICIO CZ SPRINT 66
						if($bitacora->tera_est_tera_des == null){
						$bitacora->tera_est_tera_des = $comentario;
						}
						// FIN CZ SPRINT 66
						$resultado = $bitacora->save();

						if (!$resultado) {
							DB::rollback();
							$mensaje = "Error al momento de ingresar la bitacora de la terapia. Por favor intente nuevamente.";
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
						}

					}
					//FIN CZ SPRINT 56
					
				break;

				case config('constantes.familia_intervenida_sename'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.familia_intervenida_sename');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.nna_vulneracion_derechos'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.nna_vulneracion_derechos');
					$comentario = $request->comentario;
				break;

				case config('constantes.nna_presenta_medida_proteccion'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.nna_presenta_medida_proteccion');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.familia_no_aplica'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.familia_no_aplica');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.familia_inubicable'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.familia_inubicable');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.familia_rechaza_oln'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.familia_rechaza_oln');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.familia_renuncia_oln'): //Rechazado
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.familia_renuncia_oln');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.direccion_incorrecta'): 
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.direccion_incorrecta');
					$comentario = $request->comentario;
					$desest_terapia = true;

				break;

				case config('constantes.direccion_desactualizada'):
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.direccion_desactualizada');
					$comentario = $request->comentario;
					$desest_terapia = true;

				break;

				case config('constantes.nna_vulneracion_derecho_delito'):
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.nna_vulneracion_derecho_delito');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

				case config('constantes.nna_vulneracion_derecho_no_delito'):
					$caso_id = $request->caso_id;
					$estado_caso = config('constantes.nna_vulneracion_derecho_no_delito');
					$comentario = $request->comentario;
					$desest_terapia = true;
				break;

			}

			if ($cambio_estado == true){

				// CZ SPRINT 74
				if($perteneceNotificacion > 0){
					if(session()->all()['perfil'] == config('constantes.perfil_gestor') || session()->all()['perfil'] == config('constantes.perfil_terapeuta') ){
						// CZ SPRINT 77
						$plazo = DB::selectOne("select FN_PLAZO_INTERVENCION(1, ".$request->caso_id.") as plazo from dual");
						$date1 = new \DateTime("now");
						$date2 = new \DateTime($plazo->plazo);

						if($date2 > $date1){
							$updateTime = DB::update("update AI_TIME_INTER_CASO set cas_estado = 'A TIEMPO' where cas_id = {$request->caso_id}");
						}else{
							$updateTime = DB::update("update AI_TIME_INTER_CASO set cas_estado = 'RETRASADO' where cas_id = {$request->caso_id}");

						}
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

				$caso_estado = CasoEstado::where('cas_id',$caso_id)
					->where('est_cas_id',$estado_caso)->first();

				if (count($caso_estado) == 0){
					$caso_estado = new CasoEstado();
				
				}

				$caso_estado->cas_id = $caso_id;
				$caso_estado->est_cas_id = $estado_caso;
				// INICIO CZ SPRINT 66
				if($caso_estado->cas_est_cas_des == null){
				$caso_estado->cas_est_cas_des = $comentario;
				}
				// FIN CZ SPRINT 66
				$resultado = $caso_estado->save();
				
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error al momento de realizar el cambio de estado del caso. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$caso = Caso::where("cas_id", "=", $caso_id)->first();
				$caso->est_cas_id = $estado_caso;
				$resultado = $caso->save();
				
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error al momento de actualizar estado del caso. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}


				// Cambio de Estado de las Alertas Territoriales del NNA
				if($estado_caso == config('constantes.en_elaboracion_paf')){


				}else if($estado_caso == config('constantes.en_ejecucion_paf')){

				    $alertas = Helper::getAlertaObjetivo($caso_id);
					
				    if(count($alertas) > 0){
				        foreach($alertas as $alerta_obj){
							$alerta = AlertaManual::find($alerta_obj->ai_alerta_id);
							if(count($alerta) > 0){
				            $resp = Helper::ActualizaEstadoAlertaObjetivo($alerta_obj->ai_alerta_id);

				            if($resp != 1){
				                return response()->json(array('estado' => '1', 'mensaje' => 'Ha ocurrido un error al intentar actualizar el estado de las Alertas Territoriales-'), 200);
				            }else{
				                Helper::insHistorialEstadoAlerta($alerta_obj->ai_alerta_id, 5, 'En Atención');
							}
						}
						}
				        DB::commit();

					}
				}

				$mensaje = "Cambio de estado realizado con éxito.";
			}else if ($cambio_estado == false){
				$caso_estado = CasoEstado::where("cas_id", "=", $caso_id)->where("est_cas_id", "=", $estado_caso)->first();
				$caso_estado->cas_est_cas_des = $comentario;
				$resultado = $caso_estado->save();
				
				//dd($resultado,$caso_estado->id_cec,$caso_id,$estado_caso,$request->option,$comentario);

				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error al momento de actualizar comentario del estado del caso. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$mensaje = "Actualización de bitácora realizada con éxito.";
			}
		    DB::commit();
			
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			dd($e);
			
			$mensaje = "Hubo un error en el proceso de actualización de estado. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		
		}
	}
	
	public function guardarFormDiagnostico(request $request){
		try{
			
		   DB::beginTransaction();
			
		   switch ($request->option){
			   case 1: // VISITAS N°1
                   $caso = Caso::where("cas_id", "=", $request->cas_id)->first();
				   $caso->cas_visit_des_1 = $request->comentario;
				   $caso->cas_visit_fec_1 = $request->fecha;
				   //$request->fecha;
				   $resultado = $caso->save();
				   
				   if (!$resultado){
				   	   DB::rollBack();
				       $mensaje = "Error al momento de guardar la visita N°1. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }
			   break;
			
			   case 2: // VISITAS N°2
				   $caso = Caso::where("cas_id", "=", $request->cas_id)->first();
				   $caso->cas_visit_des_2 = $request->comentario;
				   $caso->cas_visit_fec_2 = $request->fecha;
				   $resultado = $caso->save();
				
				   if (!$resultado){
					   DB::rollBack();
					   $mensaje = "Error al momento de guardar la visita N°2. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }
			   break;
			
			   case 3: // VISITAS N°3
				   $caso = Caso::where("cas_id", "=", $request->cas_id)->first();
				   $caso->cas_visit_des_3 = $request->comentario;
				   $caso->cas_visit_fec_3 = $request->fecha;
				   $resultado = $caso->save();
				
				   if (!$resultado){
					   DB::rollBack();
					   $mensaje = "Error al momento de guardar la visita N°3. Por favor intente nuevamente.";
					   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				   }
			   break;
		   }
			
		   DB::commit();
		   
		   $mensaje = "Información guardada éxitosamente.";
		   return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}
	}
	
	public function descargaDocumento($archivo){
	   switch ($archivo){
		   case 1: //Documento consentimiento - Etapa Diagnostico
			   $documento = public_path().'\doc/'.config("constantes.documento_consentimiento_diagnostico");
			   return response()->download($documento);
		   break;
	   }
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */

	public function listarDocPaf($id){

		$doc_paf = DB::select("select doc_paf_arch, to_char(doc_fec,'dd-mm-yy') doc_fec from ai_doc_paf where cas_id=".$id." order by doc_fec desc");
		//$doc_paf = DB::select("select doc_paf_arch, doc_fec  as doc_fec from ai_doc_paf where cas_id=".$id." order by doc_fec desc");

		$data	= new \stdClass();
		$data->data = $doc_paf;

		echo json_encode($data); exit;
	}

	public function adjuntapaf(Request $request){

		// $doc_paf = DB::select("select doc_paf_arch, doc_fec from ai_doc_paf where cas_id=".$id." order by doc_fec desc");

		$ok=$request->sub_paf;

		echo json_encode($ok);

		//$doc_paf = $request;

		// $data	= new \stdClass();
		// $data->data = $doc_paf;

		// echo json_encode($data); exit;
	}

	public function listarPaf(Request $request){

		// $doc_paf = DB::select("select doc_paf_arch, doc_fec from ai_doc_paf where cas_id=".$id." order by doc_fec desc");

		$cas_id = $request->id;

		$alertasAsociadas = DB::select("select at.ale_tip_id,ale_tip_nom 
				,cam.cas_id,am.ale_man_id, am.ale_man_fec
				from ai_alerta_manual am 
				inner join ai_caso_alerta_manual cam on am.ale_man_id=cam.ale_man_id
                inner join ai_alerta_manual_tipo amt on am.ale_man_id=amt.ale_man_id
				inner join ai_alerta_tipo at on amt.ale_tip_id=at.ale_tip_id
                where cam.cas_id=".$cas_id."");

		echo json_encode($ok);

		//$doc_paf = $request;

		// $data	= new \stdClass();
		// $data->data = $doc_paf;

		// echo json_encode($data); exit;
	}
	//INICIO DC
	public function getDefinicion(Request $request){
	    $datos = DB::select("select cat_des_descripcion from AI_CATEGORIA_DESESTIMACION where cat_des_id_perfil = ".$request->perfil." and cat_des_id_motivo = ".$request->valor);
	    echo json_encode($datos); exit;
	}
	//FIN DC
	public function validancfas(Request $request){
        try{
			$caso = DB::select("select fas_id from ai_caso where cas_id=".$request->cas_id."");
		  
		    $respuesta = false;
			 if ($caso[0]->fas_id == 1 || $caso[0]->fas_id == 3) $respuesta = true;

           return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
        }catch(\Exception $e){
          DB::rollback();
		  Log::info('error ocurrido:'.$e);
			
		  $mensaje = "";
		  return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
        }
	}	

	public function validadoccons(Request $request){
        try{
			$caso = DB::select("select cas_doc_cons from ai_caso where cas_id=".$request->cas_id."");
		  
		    $respuesta = false;
			 if ($caso[0]->cas_doc_cons != null || $caso[0]->cas_doc_cons != "") $respuesta = true;

           return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
        }catch(\Exception $e){
          DB::rollback();
		  Log::info('error ocurrido:'.$e);
			
		  $mensaje = "";
		  return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
        }
	}

	public function listarSegPrest($id){

		$seg_pres = DB::select("select cas_id,cgf.gru_fam_id,amt.ale_man_id,p.prog_id,gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat as integrantes,ale_tip_nom,ep.est_prog_nom, usu.nombres as usu_responsable,p.pro_nom,est.estab_nom, amp.estab_id
			from ai_grupo_familiar gf
			inner join ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gf.gru_fam_id
			inner join ai_am_programas amp on gf.gru_fam_id=amp.gru_fam_id
			inner join ai_programa p on p.prog_id=amp.prog_id
			left join ai_usuario usu on p.pro_usu_resp=usu.id
			inner join ai_estados_programas ep on ep.est_prog_id=amp.est_prog_id
			inner join ai_alerta_manual_tipo amt on amt.ale_man_id=amp.ale_man_id
			inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
			left join ai_establecimientos est on est.prog_id=p.prog_id
			where cgf.cas_id =".$id." order by gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat,  ale_tip_nom");

		return Datatables::of($seg_pres)->make(true);

		// $seg_pres = DB::select(" select am.gru_fam_id, am.ale_man_id, am.am_ofe_id, gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat as integrantes,ale_tip_nom,
		// 	listagg(o.ofe_nom||' / Estado: '||ep.est_prest_nom, ' - ')
		// 	within group (order by o.ofe_nom) as ofertas, am.ofe_id, cgf.cas_id, usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as usu_responsable, usu.email, usu.telefono
		// 	from ai_am_ofertas am
		// 	inner join ai_grupo_familiar gf on gf.gru_fam_id=am.gru_fam_id
		// 	inner join ai_ofertas o on am.ofe_id=o.ofe_id
		// 	inner join ai_usuario usu on o.usu_resp=usu.id
  //           inner join ai_estado_prestaciones ep on am.est_prest_id=ep.est_prest_id
  //           inner join ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gf.gru_fam_id
  //           inner join ai_alerta_manual_tipo amt on amt.ale_man_id=am.ale_man_id
  //           inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
  //           where cgf.cas_id = ".$id." group by am.gru_fam_id 
  //           ,gru_fam_nom,gru_fam_ape_pat,gru_fam_ape_mat,ale_tip_nom,am.ale_man_id, am.am_ofe_id, am.ofe_id, cgf.cas_id, usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno, usu.email, usu.telefono");
		
		/*$data	= new \stdClass();
		$data->data = $seg_pres;

		echo json_encode($data); exit;*/
	}


	public function listarSegPrestSinAt($cas_id){

		$seg_pres_sin_at = DB::select("select gfp.grup_fam_prog_id,cas_id,cgf.gru_fam_id,
			gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat as integrantes,
			ep.est_prog_nom,p.pro_nom,p.prog_id, 
            usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as usu_responsable,
            estab.estab_id,estab.estab_nom,estab.usu_resp_estab
			from ai_grupo_familiar gf
			inner join ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gf.gru_fam_id
			inner join ai_grup_fam_programas gfp on gfp.gru_fam_id=gf.gru_fam_id
			inner join ai_programa p on p.prog_id=gfp.prog_id
			inner join ai_estados_programas ep on ep.est_prog_id=gfp.est_prog_id
			left join ai_usuario usu on p.pro_usu_resp=usu.id
            left join (select est.estab_id,est.estab_nom,usu_est.nombres||' '||usu_est.apellido_paterno||' '||usu_est.apellido_materno as usu_resp_estab from ai_establecimientos est 
            left join ai_usuario usu_est on usu_est.id=est.estab_usu_resp) estab on estab.estab_id=gfp.estab_id
			where cgf.cas_id ='".$cas_id."' order by gru_fam_id");


		return Datatables::of($seg_pres_sin_at)->make(true);


		/*$data	= new \stdClass();
		$data->data = $seg_pres_sin_at;

		echo json_encode($data); exit;*/
	}
	
	public function verHistorialEstadosPrestacion(Request $request){
		$resultado = array();
		if (isset($request->cas_id) && is_numeric($request->cas_id) && $request->cas_id != "" &&
			isset($request->gru_fam_id) && is_numeric($request->gru_fam_id) && $request->gru_fam_id != "" &&
			isset($request->ale_man_id) && is_numeric($request->ale_man_id) && $request->ale_man_id != "" &&
			isset($request->ofe_id) && is_numeric($request->ofe_id) && $request->ofe_id != ""){
			
			$sql = "SELECT ep.est_prog_nom, epb.est_prog_bit_des, to_char(epb.est_prog_bit_fec, 'DD-MM-YY HH24:MI:SS') AS est_prog_bit_fec 
				FROM ai_caso_alerta_manual cam
				LEFT JOIN ai_am_programas ap ON cam.ale_man_id = ap.ale_man_id
				LEFT JOIN ai_estados_programas_bit epb ON ap.am_prog_id = epb.am_prog_id
				LEFT JOIN ai_estados_programas ep ON epb.est_prog_id = ep.est_prog_id
				WHERE cam.cas_id = ".$request->cas_id." AND ap.gru_fam_id = ".$request->gru_fam_id."  AND ap.ale_man_id = ".$request->ale_man_id." AND ap.prog_id = ".$request->ofe_id." ORDER BY epb.est_prog_bit_fec DESC";
			
			$resultado = DB::select($sql);
		}

		// $resultado = array();
		// if (isset($request->cas_id) && is_numeric($request->cas_id) && $request->cas_id != "" &&
		// 	isset($request->gru_fam_id) && is_numeric($request->gru_fam_id) && $request->gru_fam_id != "" &&
		// 	isset($request->ale_man_id) && is_numeric($request->ale_man_id) && $request->ale_man_id != "" &&
		// 	isset($request->ofe_id) && is_numeric($request->ofe_id) && $request->ofe_id != ""){
			
		// 	$sql = "SELECT ep.est_prest_nom, epb.est_prest_jus, to_char(epb.est_prest_fec, 'DD-MM-YY HH24:MI:SS') AS est_prest_fec FROM ai_caso_alerta_manual cam
		// 		LEFT JOIN ai_am_ofertas ao ON cam.ale_man_id = ao.ale_man_id
		// 		LEFT JOIN ai_estado_prest_bitacora epb ON ao.am_ofe_id = epb.am_ofe_id
		// 		LEFT JOIN ai_estado_prestaciones ep ON epb.est_prest_id = ep.est_prest_id
		// 		WHERE cam.cas_id = ".$request->cas_id." AND ao.gru_fam_id = ".$request->gru_fam_id." AND ao.ale_man_id = ".$request->ale_man_id." AND ao.ofe_id = ".$request->ofe_id."
		// 		ORDER BY epb.est_prest_fec DESC";
			
		// 	$resultado = DB::select($sql);
		// }

		$data	= new \stdClass();
		$data->data = $resultado;

		echo json_encode($data); exit;
	}


		public function verHistorialEstadosPrestacionSinAT(Request $request){
		$resultado = array();
		if (isset($request->grup_fam_prog_id) && is_numeric($request->grup_fam_prog_id) && $request->grup_fam_prog_id != ""){
						
			$sql = "SELECT ep.est_prog_nom,p.prog_id,p.pro_nom,e.estab_id,epb.grup_fam_prog_id,epb.est_prog_bit_des,epb.est_prog_bit_fec
				FROM ai_grup_fam_programas gfp
				INNER JOIN ai_estados_gfam_programas_bit epb ON epb.grup_fam_prog_id = gfp.grup_fam_prog_id
				INNER JOIN ai_programa p ON gfp.prog_id = p.prog_id
				LEFT JOIN ai_estados_programas ep ON epb.est_prog_id = ep.est_prog_id
				LEFT JOIN ai_establecimientos e ON  e.estab_id= gfp.estab_id
				WHERE epb.grup_fam_prog_id='".$request->grup_fam_prog_id."'";
			
			$resultado = DB::select($sql);
		}

		$data	= new \stdClass();
		$data->data = $resultado;

		echo json_encode($data); exit;
	}
	//INICIO DC
	public function actualizaCantComp(Request $request){
	    $cont_tar = Helper::get_cantTarCom($request->caso_id);
	    echo $cont_tar[0]->cantidad;
	}
	public function actualizaPorLog(Request $request){
	    $datos 			= array();
	    $cont_tar = Helper::get_cantTarCom($request->caso_id);
	    $datos["comprometidas"] = $cont_tar[0]->cantidad;
	    $cont_log = Helper::get_cantTarLog($request->caso_id);
	    $datos["lobgradas"] = $cont_log[0]->cantidad;
	    //INICIO DC
	    if($cont_tar == 0){
	        $datos["porLog"] = '';	        
	    }else{
	        $porLog = $cont_log[0]->cantidad * 100/$cont_tar[0]->cantidad;
	        $porLog = round($porLog, 1);
	        $datos["porLog"] = $porLog.'%';
	    }

	    //FIN DC
	    echo json_encode($datos); exit;

	}
    //FIN DC
	public function procesoAtencionCaso(Request $request){
		try{
	   	   	$run 	= $request->run;
		   	$opcion 	= $request->option;

		   	$file_vista 			= "";
		   	$estado_actual_caso 	= "";
		   	$estados 			= array();
		   	$return_vista 		= array();
		   	$titulos_modal 		= Helper::tituloModal();	
			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			// INICIO CZ SPRINT 69
		   	$informacion_nna = $this->caso->informacionNNAPersona($run, $request->caso_id);
			// FIN CZ SPRINT 69
			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			if (!$informacion_nna){
				$mensaje = "No se encontro información del NNA consultado. Por favor intente nuevamente.";

				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$data 								= $informacion_nna[0];	
			$return_vista["run"] 				= $run;

            //Se busca información del caso
            $caso_id 			= $request->caso_id;
            $bitacoras_estados 	= Helper::bitacorasEstados($caso_id);
			$caso 				= Caso::where("cas_id", "=", $caso_id)->first();
	
			if (!$caso){
				$mensaje = "No se encontro información del caso consultado. Por favor intente nuevamente.";

				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$estado_actual_caso = $caso->est_cas_id;

			//verifica si el caso esta en estado finalizado
			$est_cas_fin = EstadoCaso::getVerificarEstado($estado_actual_caso);

            // Data por defecto a cargar para todas las ventanas
			$return_vista["titulos_modal"] 		= $titulos_modal;
			$return_vista["bitacoras_estados"] 	= $bitacoras_estados;
			$return_vista["estado_actual_caso"] = $estado_actual_caso;
			$return_vista["caso_id"] 			= $caso_id;
			$return_vista["data"] 				= $data;
			$return_vista["fas_id"]             = $caso->fas_id;
			$return_vista["est_cas_fin"]        = $est_cas_fin;

			// VALIDACION DE PERMISOS X PERFIL
			$return_vista["modo_visualizacion"] = "";
			$return_vista["habilitar_funcion"] = false;
			if ($estado_actual_caso == $opcion){
				if (session()->all()["editar"]){
					$return_vista["modo_visualizacion"] = 'edicion';

				}else if (!session()->all()["editar"]){
					if (session()->all()["visualizar"]) $return_vista["modo_visualizacion"] = 'visualizacion';

				}
			}else if ($estado_actual_caso != $opcion){
				if (session()->all()["visualizar"]) $return_vista["modo_visualizacion"] = 'visualizacion';
					
			}

		    switch ($opcion){
			   	case config('constantes.en_prediagnostico'): // BOTON PRE DIAGNOSTICO
				default:
					$file_vista = "ficha.prediagnostico";

					$return_vista['prediagnostico_des_1'] = $caso->prediagnostico_des_1;
					$return_vista['prediagnostico_fec_1'] = ($caso->prediagnostico_fec_1!='')?date_format(date_create($caso->prediagnostico_fec_1),"d/m/Y"):'';
					$return_vista['prediagnostico_des_2'] = $caso->prediagnostico_des_2;
					$return_vista['prediagnostico_fec_2'] = ($caso->prediagnostico_fec_2!='')?date_format(date_create($caso->prediagnostico_fec_2),"d/m/Y"):'';
					$return_vista['prediagnostico_des_3'] = $caso->prediagnostico_des_3;
					$return_vista['prediagnostico_fec_3'] = ($caso->prediagnostico_fec_3!='')?date_format(date_create($caso->prediagnostico_fec_3),"d/m/Y"):'';
					$return_vista['prediagnostico_des_4'] = $caso->prediagnostico_des_4;
					$return_vista['prediagnostico_fec_4'] = ($caso->prediagnostico_fec_4!='')?date_format(date_create($caso->prediagnostico_fec_4),"d/m/Y"):'';
					$return_vista['prediagnostico_des_5'] = $caso->prediagnostico_des_5;
					$return_vista['prediagnostico_fec_5'] = ($caso->prediagnostico_fec_5!='')?date_format(date_create($caso->prediagnostico_fec_5),"d/m/Y"):'';
					$return_vista['prediagnostico_des_6'] = $caso->prediagnostico_des_6;
					$return_vista['prediagnostico_fec_6'] = ($caso->prediagnostico_fec_6!='')?date_format(date_create($caso->prediagnostico_fec_6),"d/m/Y"):'';

				break;
			   	case config('constantes.en_diagnostico'): // BOTON DIAGNOSTICO
					// VALIDACION REALIZACION NCFAS-G
					$ncfasg_realizado = false;
					if (($caso->fas_id == config('constantes.ncfas_fs_ingreso')) || ($caso->fas_id == config('constantes.ncfas_fs_cierre')) || ($caso->fas_id == config('constantes.ncfas_fs_cierre_ptf'))){
						$ncfasg_realizado = true;
						
					} 

					$g_asig_id = null;
					$gestor_asignado = PersonaUsuario::where("cas_id", "=", $caso_id)->first();
					if (count($gestor_asignado) > 0) $g_asig_id = $gestor_asignado->usu_id;

					$visitas = array();
					if (isset($caso) && $caso != ""){
						if (count($caso) > 0){
							// VISITA 1
							$visitas[0] = new \stdClass();
							$visitas[0]->fecha = date('y/m/d', strtotime($caso->cas_visit_fec_1));
							$visitas[0]->visita = $caso->cas_visit_des_1;
							
							// VISITA 2
							$visitas[1] = new \stdClass();
							$visitas[1]->fecha = date('y/m/d', strtotime($caso->cas_visit_fec_2));
							$visitas[1]->visita = $caso->cas_visit_des_2;
							
							// VISITA 3
							$visitas[2] = new \stdClass();
							$visitas[2]->fecha = date('y/m/d', strtotime($caso->cas_visit_fec_3));
							$visitas[2]->visita = $caso->cas_visit_des_3;
							
							$fas_id = $caso->fas_id;
							$cas_est_act = $caso->est_cas_id;
							$nec_ter = $caso->nec_ter;
						}
					}

					// *********************BENEFICIOS NNA**********************

					$arrayUB = array();

					$arrayHB = array();

					$array = array();

					$arrayH = array();
	
					$rutGruF = $this->casoGrupoFamiliar->listarGrupoFamiliar($caso_id);
						
					foreach ($rutGruF as $value) {

						$ultimosBeneficios = CasoController::ultimosBeneficios($value->gru_fam_run);
						$ultimosBeneficios = json_decode($ultimosBeneficios,true);
						$estadoBenf = $ultimosBeneficios["Estado"];
						$EstadoConsulta = $ultimosBeneficios["EstadoConsulta"];

						$HistoricoBeneficios = CasoController::HistoricoBeneficios($value->gru_fam_run);
						$HistoricoBeneficios = json_decode($HistoricoBeneficios,true);
						$estadoHist = $HistoricoBeneficios["Estado"];
						$EstadoConsultaH = $HistoricoBeneficios["EstadoConsulta"];

						if($estadoBenf==1){

						$beneficios = $ultimosBeneficios["beneficios"];

						foreach ($beneficios as $b) {

							array_push($array, array( 
										"id_program" => $b["id_programa"],
										"fecharecepcionultben" => $b["fecharecepcionultben"],
										"nombre_programa" => $b["nombre_programa"],
										"montoultben" => $b["montoultben"]));
										}
									}

								if($estadoHist==1){

									$beneficiosHist = $HistoricoBeneficios["beneficios"];

										foreach ($beneficiosHist as $h) {
											array_push($arrayH, array( 
												"id_programa"     => $h["id_programa"],
												"fecha_recepcion" => $h["fecha_recepcion"],
												"monto"           => $h["monto"],
												"nombre_programa" => $h["nombre_programa"]));
										}
								}

								array_push($arrayUB, array( 
									"EstadoConsulta" => $EstadoConsulta, 
									"run" 		     => $value->gru_fam_run, 
									"grupoFam"       => $value->par_gru_fam_nom, 
									"estado"         => $estadoBenf,
									"beneficios"     => $array));
								
								$array=[];

								array_push($arrayHB, array( 
									"EstadoConsulta" => $EstadoConsultaH, 
									"run" 			 => $value->gru_fam_run,
									"grupoFam"       => $value->par_gru_fam_nom,
									"estado"         => $estadoHist,
									"beneficios"     => $arrayH));

								$arrayH=[];

						}

					// *********************FIN BENEFICIOS NNA**********************
					if (session()->all()["perfil"] == config("constantes.perfil_gestor")){
						if ($return_vista["modo_visualizacion"] == 'visualizacion') $return_vista["habilitar_funcion"] = true;
						
					}	

					$array_ncfas = Pregunta::listar_ncfas($caso_id);

					$file_vista = "ficha.AtencionDiagnostico";
					$return_vista["g_asig_id"] 			= $g_asig_id;
					$return_vista["visitas"] 			= $visitas;
					$return_vista["fas_id"] 			= $fas_id;
					$return_vista["ncfasg_realizado"] 	= $ncfasg_realizado;
					$return_vista["arrayUB"] 			= $arrayUB;
					$return_vista["arrayHB"] 			= $arrayHB;
					$return_vista["array_ncfas"]        = $array_ncfas;
					
					if ($caso->cas_doc_cons){
						$return_vista["documentoconsentimiento"] = $caso->cas_doc_cons;
					
					}else{
						$return_vista["documentoconsentimiento"] = 'na';
					
					}
			   break;
			
			   case config('constantes.en_elaboracion_paf'): // BOTON ELABORAR PAF
					$terapeutas = array();
					$terapeuta_asignado = null;		
					$just_terapia 		= $caso->cas_just_terapia; //
					$necesita_terapeuta = $caso->nec_ter;		//
					$terapeuta_asignado_id = "";
					$nombre_terapeuta_asignado = "na";
					// CANTIDAD DE TAREAS COMPROMETIDAS
					//INICIO DC
					$cont_tar = Helper::get_cantTarCom($caso_id);
					$cont_tar = $cont_tar[0]->cantidad;
					//FIN DC

					//Se obtiene el ID de la persona
					$persona = Persona::where('per_run', $data->run)->get();
					if (count($persona) > 0){
						$persona_id = $persona[0]->per_id;
						$data->per_id = $persona_id;

						// INICIO CZ SPRINT 63 Casos ingresados a ONL
							$cas = CasoPersonaIndice::where('per_id', $persona_id)->where('cas_id',$caso_id)->get();
						// FIN CZ SPRINT 63 Casos ingresados a ONL
						if (count($cas) > 0){
							$data->cas_id = $cas[0]->cas_id;
					
							$terapeutas = $this->usuario->getTerapeutas();

							if($caso->nec_ter=='1' && $caso->est_cas_id <> config('constantes.en_elaboracion_paf')){
								$nombre_terapeuta_asignado = 'necesita_terapia';
							}

							$buscar_terapeuta = $this->caso_terapeuta::where("cas_id", $data->cas_id)->first();
							if (count($buscar_terapeuta) > 0){
								$info_terapeuta = $this->usuario::where("id", $buscar_terapeuta->ter_id)->first();

								if (count($info_terapeuta) > 0){
									$terapeuta_asignado = $info_terapeuta->nombres.' '.$info_terapeuta->apellido_paterno.' '.$info_terapeuta->apellido_materno;	
									$terapeuta_asignado_id = $info_terapeuta->id;

									$nombre_terapeuta_asignado = Usuarios::find($terapeuta_asignado_id);
									
									$nombre_terapeuta_asignado = ($nombre_terapeuta_asignado)?$nombre_terapeuta_asignado->nombres.' '.$nombre_terapeuta_asignado->apellido_paterno.' '.$nombre_terapeuta_asignado->apellido_materno:'na';
			              
								}
							}
						}

					}

					$grupoFam = Helper::get_grupoFamiliarAsoc($caso_id);
					$grupo_familiar = Helper::get_grupoFamiliarAsoc($caso_id);
					if (count($grupo_familiar) > 0){
						foreach ($grupo_familiar as $c1 => $v1){
							$parentesco = ParentescoGrupoFamiliar::find($v1->gru_fam_par);
							
							$grupo_familiar[$c1]->parentesco = "Sin información.";
							if (count($parentesco) > 0) $grupo_familiar[$c1]->parentesco = $parentesco->par_gru_fam_nom; 
						}
					}

					$alertasXnna = Helper::get_alertasXnna($caso_id);

					$tip_array = [];
					$alertaManualTipOfe = $this->alertaManual->alertaManualTipoOfertas($run);

					foreach ($alertaManualTipOfe as $value) {
						array_push($tip_array, $value->ale_tip_id);
					}



					if (session()->all()["perfil"] == config("constantes.perfil_gestor")){
						if ($return_vista["modo_visualizacion"] == 'visualizacion') $return_vista["habilitar_funcion"] = true;
						
					}

					//HABILITAR RECOMENDACIÓN A TERAPIA
					$modo_recomendacion = "";
					$recomendacion_terapia_ver = Funcion::obtener_permiso_funcion(session()->all()["perfil"], 'GC00');
					$recomendacion_terapia_editar = Funcion::obtener_permiso_funcion(session()->all()["perfil"], 'GC01');

					if (session()->all()["perfil"] == config("constantes.perfil_gestor")){
						if (count($recomendacion_terapia_editar) > 0){
							if ($estado_actual_caso == $opcion){
								if ($terapeuta_asignado_id == ""){
									$modo_recomendacion = "editar";

								}else{
									$modo_recomendacion = "visualizar";	
								
								}
							}else if ($estado_actual_caso != $opcion){
							  if ($necesita_terapeuta == "" || $necesita_terapeuta == 0){
							  	  $modo_recomendacion = "visualizar";	
							  
							  }else if ($necesita_terapeuta == 1){
							  	  $modo_recomendacion = "visualizar";	
							  
							  }
							}
						}else if (count($recomendacion_terapia_ver) > 0){
							$modo_recomendacion = "visualizar";

						}
					}else{
						if (count($recomendacion_terapia_editar) > 0){
							if ($estado_actual_caso == $opcion){
								$modo_recomendacion = "editar";

							}else if ($estado_actual_caso != $opcion){
								if (count($recomendacion_terapia_ver) > 0) $modo_recomendacion = "visualizar";

							}	

						}else if (count($recomendacion_terapia_ver) > 0){
							$modo_recomendacion = "visualizar";

						}
					}

					$file_vista = "ficha.elaborar_paf";
					$return_vista["necesita_terapeuta"] 	= $necesita_terapeuta;
					$return_vista["just_terapia"] 			= $just_terapia;
					$return_vista["terapeuta_asignado"] 	= $terapeuta_asignado;
					$return_vista["terapeutas"] 			= $terapeutas;
					$return_vista["grupoFam"] 				= $grupoFam;
					$return_vista["alertaManualTipOfe"] 	= $alertaManualTipOfe;
					$return_vista["tip_array"]				= $tip_array;
					$return_vista["alertasXnna"] 			= $alertasXnna;
					$return_vista["run"] 	  				= $run;
					$return_vista["grupo_familiar"]			= $grupo_familiar;
					$return_vista["terapeuta_asignado_id"]	= $terapeuta_asignado_id;
					$return_vista["nombre_terapeuta_asignado"] = $nombre_terapeuta_asignado;
					$return_vista["modo_recomendacion"]		= $modo_recomendacion;
					$return_vista["cont_tar"] 				= $cont_tar;

					//dd($return_vista);
			   break;
			
			   case config('constantes.en_ejecucion_paf'): // BOTON EJECUCION PAF
					$terapeuta_asignado = null;		

					//Se obtiene el ID de la persona
					$persona = Persona::where('per_run', $data->run)->get();
					if (count($persona) > 0){
						$persona_id 	= $persona[0]->per_id;
						$data->per_id 	= $persona_id;

						//Se obtiene el ID del Caso
						// INICIO CZ SPRINT 63 Casos ingresados a ONL
						$cas = CasoPersonaIndice::where('per_id', $persona_id)->where('cas_id',$caso_id)->get();
						// FIN CZ SPRINT 63 Casos ingresados a ONL
						if (count($cas) > 0){
							$data->cas_id = $cas[0]->cas_id;

							$buscar_terapeuta = $this->caso_terapeuta::where("cas_id", $data->cas_id)->first();
							if (count($buscar_terapeuta) > 0){
								$info_terapeuta = $this->usuario::where("id", $buscar_terapeuta->ter_id)->first();

								if (count($info_terapeuta) > 0){
									//$terapeuta_asignado = $info_terapeuta->nombres.' '.$info_terapeuta->apellido_paterno.' '.$info_terapeuta->apellido_materno;	
									$terapeuta_asignado = '<div>
														<ul>
														<li>Nombre: '.
														$info_terapeuta->nombres.' '.$info_terapeuta->apellido_paterno.' '.$info_terapeuta->apellido_materno.'</li>'.
														'<li>Correo: '.
														$info_terapeuta->email.'</li>'.	
														'<li>Teléfono: '.
														$info_terapeuta->telefono.'</li>'.
														'</ul>
														</div>';
			              
								}
							}
						}
					}

					if (session()->all()["perfil"] == config("constantes.perfil_gestor")){
						if ($return_vista["modo_visualizacion"] == 'visualizacion') $return_vista["habilitar_funcion"] = true;
						
					}
					// Numero de Actividades Realizadas
					$actividades = Caso::casoActividadesRealizadas($caso_id);
					
					//$cont_tar = $caso->cas_can_tar; //tareas comprometidas
					
					$cont_tar = Helper::get_cantTarCom($caso_id);
					$cont_tar = $cont_tar[0]->cantidad;
					

					$x = count($actividades);
					//INICIO DC
					if ($cont_tar == 0) {						
						$p_logro = '';
					}else{
						$p_logro = $x*100/$cont_tar;
						$p_logro = round($p_logro, 1);
						$p_logro = $p_logro.'%';
					}
					//FIN DC
					$return_vista["p_logro"] 				= $p_logro;
					$return_vista["cont_tar"] 				= $cont_tar;
					$return_vista["actividades"] 		= $x;
					//$file_vista = "ficha.construccion";
					$file_vista = "ficha.ejecucion_paf";
					$return_vista["terapeuta"] = $terapeuta_asignado;
					//$file_vista = "ficha.ejecucion_paf";
			   break;

			   	case config('constantes.en_cierre_paf'): // BOTON CIERRE PAF	
			   		/*Logica para comprobar si el NCFAS-G ya se realizó*/

			   		$array_ncfas = Pregunta::listar_ncfas($caso_id);
	
					$fas_id = "";
					$ncfasg_realizado = false;
					/*Se obtiene el ID de la persona*/
					$persona = Persona::where('per_run', $data->run)->get();
					if (count($persona) > 0){
						$persona_id = $persona[0]->per_id;
						$data->per_id = $persona_id;
									
						// INICIO CZ SPRINT 63 Casos ingresados a ONL
						$cas = CasoPersonaIndice::where('per_id', $persona_id)->where('cas_id',$caso_id)->get();
						// FIN CZ SPRINT 63 Casos ingresados a ONL
						if (count($cas) > 0) $data->cas_id = $cas[0]->cas_id;
						
						if (isset($caso) && $caso != ""){
							if (count($caso) > 0){
								$fas_id = $caso->fas_id;

								//if ($fas_id == config('constantes.ncfas_fs_cierre') || $fas_id == config('constantes.ncfas_fs_cierre_ptf')) $ncfasg_realizado = true;
								// INICIO CZ SPRINT 56
								if ($fas_id == config('constantes.ncfas_fs_cierre') ) $ncfasg_realizado = true;
								// FIN CZ SPRINT 56
							}
						}
					}

					$return_vista["encuestasatisfaccion"] = 'na';
					if ($caso->cas_enc_sati){
						$return_vista["encuestasatisfaccion"] = $caso->cas_enc_sati;
					}

					// Numero de Actividades Realizadas
					$actividades = Caso::casoActividadesRealizadas($caso_id);
					
					//$cont_tar = $caso->cas_can_tar; 
					$cont_tar = Helper::get_cantTarCom($caso_id);
					$cont_tar = $cont_tar[0]->cantidad;
					

					$x = count($actividades);
					//INICIO DC
					if ($cont_tar == 0) {						
						$p_logro = '';
					}else{
						$p_logro = $x*100/$cont_tar;
						$p_logro = round($p_logro, 1);
						$p_logro = $p_logro.'%';
					}
					//FIN DC
					$return_vista["p_logro"] 				= $p_logro;
					$return_vista["actividades"] 		= $x;
					$return_vista["cont_tar"] 				= $cont_tar;
					$file_vista = "ficha.cierre_paf";
					$return_vista["fas_id"] 			= $fas_id;
					$return_vista["ncfasg_realizado"] 	= $ncfasg_realizado;
					$return_vista["array_ncfas"] 	= $array_ncfas;
			   	break;

				case config('constantes.en_seguimiento_paf'): // BOTON SEGUIMIENTO PAF
	 			case config('constantes.egreso_paf'): // EGRESO
	 				// VALIDACION REALIZACION NCFAS-G
					$ncfasg_realizado = false;
					if ($caso->fas_id == config('constantes.ncfas_fs_cierre_ptf')){
						$ncfasg_realizado = true;

					}

					$array_ncfas = Pregunta::listar_ncfas($caso_id);
		 			$numero_reporte = $this->ultimoRepSeg($caso_id);
		 			$numero_reporte = $numero_reporte + 1;
					$sin_pendientes = $this->gestionPendientesPaf($caso_id);

					//VALIDACION DE NCFAS-G EN CASO DE TERAPIA DESESTIMADA
					$ncfas_terapia = false;
					$caso_est_ter = NNAAlertaManualCaso::where("cas_id",$caso_id)->first();
					if ( $caso_est_ter->est_tera_fin == 0) $ncfas_terapia = true;

					$return_vista["sin_pendientes"] 	= $sin_pendientes;
					$return_vista["caso_con_terapia"] 	= $ncfas_terapia;
		 			$return_vista["numero_reporte"] 	= $numero_reporte;
		 			$return_vista["fas_id"] 			= $caso->fas_id;
					$return_vista["ncfasg_realizado"] 	= $ncfasg_realizado;
					$return_vista["array_ncfas"] 		= $array_ncfas;
					$file_vista = "ficha.egreso_paf";
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

	public function validarParentescoIntegrante(Request $request){
		try {
			$respuesta = false;
			if (isset($request->cas_id) && $request->cas_id != "" && isset($request->par_gru_fam_id) && $request->par_gru_fam_id != ""){
				$sql1 = "SELECT * FROM ai_caso_grupo_familiar cgf
					LEFT JOIN ai_grupo_familiar gf ON cgf.gru_fam_id = gf.gru_fam_id
					LEFT JOIN ai_parentesco_grupo_familiar pgf ON gf.gru_fam_par = pgf.par_gru_fam_id
					WHERE cgf.cas_id = ".$request->cas_id." AND pgf.par_gru_fam_cod = 1 AND gf.gru_fam_est = 1";
				
				$sql2 = "SELECT * FROM ai_parentesco_grupo_familiar WHERE par_gru_fam_id = ".$request->par_gru_fam_id." AND par_gru_fam_cod = 1";
				
				$validacion1 = DB::select($sql1);
				$validacion2 = DB::select($sql2);
				
				if (count($validacion1) > 0 && count($validacion2) > 0) $respuesta = true;
			}
		
			return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
		}catch (\Exception $e){
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Error al momento de validar el parentesco del integrante familiar. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}


	public function validarAlertasPendientes(Request $request){
		try {
			$can_aler = 0;
			$resp_val = false;
			
			$caso_alerta_manual = new CasoAlertaManual();
			$val_ale = $caso_alerta_manual->alertaTerritorialPorCaso($request->cas_id, true);

			if (count($val_ale) > 0){
                 $can_aler = count($val_ale);
                 $resp_val = true;
		    }

            return response()->json(array('validacion_alertas' =>  $resp_val, 'cantidad_alertas' =>  $can_aler), 200);
		}catch (\Exception $e){
			Log::info('error ocurrido:'.$e);
			
			return response()->json(array('mensaje' => $e->getMessage()), 400);
		}
	}



	/**
	 * Método que obtiene los beneficios de una persona a través  de su rut
	 * @param $run
	 * @return false|string
	 */
	public function ultimosBeneficios($run){
		try{

			$servicio = file_get_contents($_ENV['URL_ULTIMOS_BENEFICIOS']."&RunConsulta=".$run."&IdPrograma=0&UltimosBeneficios=1");
			$servicio = json_decode($servicio);
		
			return json_encode($servicio);

		} catch (\Exception $e) {

			$servicio = array("EstadoConsulta" => 0, "beneficios"=> [] , "Estado" => 0);
			
			return json_encode($servicio);

		}	
		
	}

		/**
	 * Método que obtiene el histórico de beneficios de una persona a través  de su rut
	 *
	 * @param $run
	 * @return false|string
	 */
	public function historicoBeneficios($run){

		try{
		
			$servicio = file_get_contents($_ENV['URL_HISTORICO_BENEFICIOS']."&RunConsulta=".$run."&IdPrograma=0&UltimosBeneficios=0");

			$servicio = json_decode($servicio);

			return json_encode($servicio);

		} catch (\Exception $e) {
		
			$servicio = array("EstadoConsulta" => 0, "beneficios"=> [] , "Estado" => 0);

			return json_encode($servicio);

		}	
		
	}
	// INICIO CZ SPRINT 56 BENEFICIO SENAME
	// INCIO CZ SPRINT 61
	public function senameBeneficios($run){
		try{
			$id_usuario = session('id_usuario'); 
			$inf_usuario = DB::Select("select * from ai_usuario where id = " .$id_usuario);
			//URL A PROD 
			$servicio = file_get_contents($_ENV['URL_SEMAME_BENEFICIOS'].$_ENV['CLAVE_SISTEMA']."&RunConsulta=".$run."&RunQuienConsulta=".$inf_usuario[0]->run);	
			//URL PRUEBA
			//$servicio = file_get_contents("http://wsmdsf.mideplan.cl/api-ris/restHistoricoSename?ClaveSistema=jaWCl1to6YjrlXV94xum&RunConsulta=".$run."&RunQuienConsulta=".$inf_usuario[0]->run);	
			//$servicio = file_get_contents("http://wsmdsf.mideplan.cl/api-ris/restHistoricoSename?ClaveSistema=jaWCl1to6YjrlXV94xum&RunConsulta=18215109&RunQuienConsulta=12345678");
			$servicio = json_decode($servicio);
			
			return json_encode($servicio);

		} catch (\Exception $e) {

			$servicio = array("EstadoConsulta" => 0, "beneficios"=> [] , "Estado" => 0);

			return json_encode($servicio);
		
		}	
	
	}
	// FIN CZ SPRINT 61
	//FIN CZ SPRINT 56 BENEFICIO SENAME
	// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public function atencionNNA(Request $request, $run = null, $idcaso = null){
	// FIN CZ SPRINT 63 Casos ingresados a ONL
       try{
		   if($run == null || $idcaso == null){
			   
				$mensaje = "Ocurrió un error al momento de desplegar la información. Por favor verifique url para ingresar a la ficha del nna.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		   }
       		$run_dv = Rut::set($run)->calculateVerificationNumber(); 
       		$val_cas = $this->validarPredictivoPersonaCasoAlertas($run, $run_dv);
       		$submenu = Helper::tituloModal();
       		$caso_con_terapia = false;

			if ($val_cas["persona"] == false){
				$caso = $this->caso->informacionNNAPredictivo($run);
			    if (!$caso){
				    $mensaje = "No se Pudo Encontrar el Run, intente nuevamente.";
				    return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			    }

			    $data 		= $caso[0];
			   /*Obtenemos el ID de las comunas asociadas al usuario logeado*/
			   $comunas_usuario = "";
			   $lista_comuna_usuario = $this->usuario_comuna->buscarComunasUsuario(session('id_usuario'));
		
			   /*Validamos que la comuna del NNA se encuentre dentro de las asignadas del usuario logeado*/
			   foreach($lista_comuna_usuario as $valor){
				   if ($valor->com_cod != "" && isset($valor->com_cod) && $valor->com_cod == $data->dir_com_1){
					   $comunas_usuario = $valor->com_id;
				   }
			   }

			}else if ($val_cas["persona"] == true){
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
				// INICIO CZ SPRINT 69
				$caso = $this->caso->informacionNNAPersona($run,$idcaso);
				// FIN CZ SPRINT 69
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
			    if (!$caso){
				    $mensaje = "No se Pudo Encontrar el Run, intente nuevamente.";
				    return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			    }

			    $data 		= $caso[0];
				if($idcaso == 0){
					$data->cas_id = null;
					$data->estado = null;
				}else{ 
					$caso = Caso::find($idcaso);
					$data->cas_id = $idcaso;
					$data->estado = $caso->est_cas_id;
					$data->score = $caso->cas_sco;
					$data->cas_doc_cons = $caso->cas_doc_cons;
					$data->est_pau = $caso->cas_est_pau;
				}
				
			   /*Obtenemos el ID de las comunas asociadas al usuario logeado*/
			   $comunas_usuario = "";
			   $lista_comuna_usuario = $this->usuario_comuna->buscarComunasUsuario(session('id_usuario'));

			   /*Validamos que la comuna del NNA se encuentre dentro de las asignadas del usuario logeado*/
			   foreach($lista_comuna_usuario as $valor){
				   if ($valor->com_cod != "" && isset($valor->com_cod)){
				   	   if ($valor->com_cod == $data->com_cod) $comunas_usuario = $valor->com_id;
				   	   
				   }
			   }
			   $val_caso_con_terapia = null;
			   if($idcaso != 0){
				$val_caso_con_terapia = $this->caso->informacionNNATerapia($caso->cas_id);   
			   }
			   if (count($val_caso_con_terapia) > 0){
				   $caso_con_terapia = true;
			   }	   
			   
			}

		   /*Se obtiene el ID de la persona*/
		   $estado_actual_caso = "";
		   $persona = Persona::where('per_run', $data->run)->get();
		   if (count($persona) > 0){
			   $data->per_id = $persona[0]->per_id;
		
			   /*Se obtiene el ID del Caso*/
			   // rruiz 05082019 => se agrega ordenacion por cas_id desc, para que siempre traiga el ultimo
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
				//$cas = CasoPersonaIndice::where('per_id', $data->per_id)->orderby('cas_id','desc')->get();
				if($idcaso != 0){
					$cas = CasoPersonaIndice::where('per_id', $data->per_id)->where('cas_id',$caso->cas_id)->orderby('cas_id','desc')->get();
				}else{
			   $cas = CasoPersonaIndice::where('per_id', $data->per_id)->orderby('cas_id','desc')->get();
				}
				
			   
			   //$cas = CasoPersonaIndice::where('per_id', $data->per_id)->get();

			//    if (count($cas) > 0) $data->cas_id = $cas[0]->cas_id;
			if($idcaso != 0){
			   $caso_nna = Caso::where('cas_id', $data->cas_id)->get();
				if (count($caso_nna) > 0) $estado_actual_caso = $caso_nna[0]->est_cas_id; 
			}else{
				$estado_actual_caso = null;
			}
			// FIN CZ SPRINT 63 Casos ingresados a ONL  
		   }
		 
		   /*Obtenemos los gestores de la comuna a quienes se les puede asignar el caso*/
		    if($comunas_usuario==""){
		    	$gestores =[];

		    }else{
		    	$gestores = $this->usuario->getGestores($comunas_usuario);
		   
		    }
	
		   /*Obtenemos el gestor asignado al caso si lo tuviera*/
		   $g_asig_id 		= null;
		   $gestor_asignado = null;
		  // INICIO CZ SPRINT 63 Casos ingresados a ONL

		  $gestor 			= $this->usuario->getGestoresAsig($run,$idcaso );
		  // INICIO CZ SPRINT 63 Casos ingresados a ONL

	
		   /*Validamos si tiene gestor asignado, en caso afirmativo obtenemos su ID, Nombre y Apellido*/
		   if($gestor){
			   $g_asig_id = $gestor[0]->id;
			   $gestor_asignado = $gestor[0]->nombres." ".$gestor[0]->apellido_paterno;
		   }
	
		   $acciones = $this->perfil->acciones();

		   /*Obtenemos el terapeuta asignado al caso si lo tuviera*/
		   $tera_asig_id 		= null;
		   $terapeuta_asignado  = null;
		   $terapeuta           = null;
		   $terapeutas 		    = $this->usuario->getTerapeutas();

		   if($data->cas_id){
		   		$terapeuta = $this->usuario->getTerapeutasAsig($data->cas_id);
			}
		   /*Validamos si tiene terapeuta asignado, en caso afirmativo obtenemos su ID, Nombre y Apellido*/
		   if($terapeuta){
			   $tera_asig_id = $terapeuta[0]->id;
			   $terapeuta_asignado = $terapeuta[0]->nombres." ".$terapeuta[0]->apellido_paterno." ".$terapeuta[0]->apellido_materno;
		   }
		   


			$historial_pausa =  DB::select(" select u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre,a.cas_id,to_char(fec_ing,'dd-mm-yyyy HH24:MI:SS')fec_ing, usu_id, estado, comentario 
				 from ai_caso_bit_pau  a left join ai_usuario u on a.usu_id=u.id 
				 where a.cas_id='".$data->cas_id."'");

				 

			// INICIO CZ SPRINT 59
			if($data->estado){
			$est_cas_fin = EstadoCaso::getVerificarEstado($data->estado);
			}else{
				$est_cas_fin = "";
			}
			// FIN CZ SPRINT 59

				// INICIO CZ SPRINT 59 
			//print_r($tera_asig_id); --> vacio
			//print_r($terapeuta_asignado); --> vacio
			//print_r($terapeuta); --> vacio
			//print_r($terapeutas);--> listado de terapeuta
		   return view("ficha.atencion_nna",
			   [
				   'caso' 				=> $data,
				   // INICIO CZ SPRINT 59
				   'est_cas_fin' => $est_cas_fin,
					//FIN CZ SPRINT 59
				   'run'				=> $run,
				   'estado_actual_caso' => $estado_actual_caso,
				   'gestores'			=> $gestores,
				   'g_asig_id' 			=> $g_asig_id,
				   'gestor_asignado'	=> $gestor_asignado,
				   'acciones'			=> $acciones,
				   'tera_asig_id'       => $tera_asig_id,
				   'terapeuta_asignado' => $terapeuta_asignado,
				   'terapeuta'          => $terapeuta,
				   'terapeutas'			=> $terapeutas,
				   'caso_con_terapia'   => $caso_con_terapia,
				   'historial_pausa'    => $historial_pausa,
				   'submenu'			=> $submenu
			   ]);
	   }catch(\Exception $e){
		   Log::error('error: '.$e);
		   //INICIO CZ SPRINT 66
		   $mensaje = "Ocurrio un error al momento de cargar los datos de la ficha, intente nuevamente.";
			// FIN CZ SPRINT 66
		   return view('layouts.errores')->with(['mensaje'=>$e]);
	   }
    }
	
	// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public function historialNNA(Request $request, $run = null, $idcaso = null){
		// FIN CZ SPRINT 63 Casos ingresados a ONL
		try{

			if($idcaso == null || $run == null ){
				$mensaje = "URL incompleta. Por favor intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$dv = Rut::set($run)->calculateVerificationNumber();
			$validacion_predictivo_persona = $this->validarPredictivoPersonaCasoAlertas($run, $dv);
			$caso_con_terapia = false;

			if ($validacion_predictivo_persona['persona']){

				// INICIO CZ SPRINT 63 Casos ingresados a ONL
				// INICIO CZ SPRINT 69
				$caso = $this->caso->informacionNNAPersona($run, $idcaso);
				// FIN CZ SPRINT 69
				// INICIO CZ SPRINT 71 
				if($idcaso == 0){
					$caso[0]->cas_id = null;
					$caso[0]->estado = null;
				}else{ 
					$findCaso = Caso::find($idcaso);
					$caso[0]->cas_id = $idcaso;
					$caso[0]->estado = $findCaso->est_cas_id;
					$caso[0]->score = $findCaso->cas_sco;
					$caso[0]->cas_doc_cons = $findCaso->cas_doc_cons;
					$caso[0]->est_pau = $findCaso->cas_est_pau;
				}
				// FIN CZ SPRINT 71 
				// INICIO CZ SPRINT 63 Casos ingresados a ONL

				$val_caso_con_terapia = $this->caso->informacionNNATerapia($idcaso);
				if (count($val_caso_con_terapia) > 0) $caso_con_terapia = true;
			
			}else{
				$caso = $this->caso->informacionNNAPredictivo($run);

			}

			if (!$caso){
				$mensaje = "No se Pudo Encontrar el Run, intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$alertas_territoriales_historial = helper::alertasTerritorialesHistorial($run); 

			$alertas_san_nna = helper::get_alertasManualXnna($run);

			$data = $caso[0];

			$historial_pausa =  DB::select(" select u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre,a.cas_id,to_char(fec_ing,'dd-mm-yyyy HH24:MI:SS')fec_ing, usu_id, estado, comentario 
				 from ai_caso_bit_pau  a left join ai_usuario u on a.usu_id=u.id 
				 where a.cas_id='".$data->cas_id."'");


			return view("ficha.historial_nna",
				[
					 'caso' 			=> $data,
					 'run'				=> $run,
					 'alertas_territoriales_historial' => $alertas_territoriales_historial,
					 'alertas_san_nna'  => $alertas_san_nna,
					 'caso_con_terapia' => $caso_con_terapia,
					 'historial_pausa' => $historial_pausa
				]);
		}catch(\Exception $e){
			Log::error('error: '.$e);
			$mensaje = "Ocurrió un error al momento de desplegar la información. Por favor comuníquese con su contraparte técnica.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	public function listarVisitasDiagnostico(Request $request){
		$lis_cons 		= array();
		$lis_vis_diag 	= array();
		if (isset($request->caso_id) && $request->caso_id != "") $lis_cons = Caso::where('cas_id', '=', $request->caso_id)->get();
		
		foreach ($lis_cons AS $c01 => $v01){
			if (!is_null($v01->cas_visit_fec_1) && $v01->cas_visit_fec_1 != "" && !is_null($v01->cas_visit_des_1) && $v01->cas_visit_des_1 != ""){
				$lis_vis_diag[0] = new \stdClass();
				$lis_vis_diag[0]->numero_visita 		= 1;
				$lis_vis_diag[0]->fecha_visita 			= $v01->cas_visit_fec_1;
				$lis_vis_diag[0]->descripcion_visita 	= $v01->cas_visit_des_1;
				
				$modalidad_visita = ModalidadVisita::find($v01->cas_visit_mod_1);
				$lis_vis_diag[0]->modalidad_visita 	= $modalidad_visita->mod_visita_nombre;		
			}
			
			if (!is_null($v01->cas_visit_fec_2) && $v01->cas_visit_fec_2 != "" && !is_null($v01->cas_visit_des_2) && $v01->cas_visit_des_2 != ""){
				$lis_vis_diag[1] = new \stdClass();

				$lis_vis_diag[1]->numero_visita = 2;
				$lis_vis_diag[1]->fecha_visita = $v01->cas_visit_fec_2;
				$lis_vis_diag[1]->descripcion_visita = $v01->cas_visit_des_2;
				
				$modalidad_visita = ModalidadVisita::find($v01->cas_visit_mod_2);
				$lis_vis_diag[1]->modalidad_visita 	= $modalidad_visita->mod_visita_nombre;
			}
			
			if (!is_null($v01->cas_visit_fec_3) && $v01->cas_visit_fec_3 != "" && !is_null($v01->cas_visit_des_3) && $v01->cas_visit_des_3 != "") {
				$lis_vis_diag[2] = new \stdClass();

				$lis_vis_diag[2]->numero_visita = 3;
				$lis_vis_diag[2]->fecha_visita = $v01->cas_visit_fec_3;
				$lis_vis_diag[2]->descripcion_visita = $v01->cas_visit_des_3;
				
				$modalidad_visita = ModalidadVisita::find($v01->cas_visit_mod_3);
				$lis_vis_diag[2]->modalidad_visita 	= $modalidad_visita->mod_visita_nombre;
			}
		}
		
		$data	= new \stdClass();
		$data->data = $lis_vis_diag;

		echo json_encode($data); exit;
	}
	
	public function accionesFormularioVisitas(Request $request){
	   try{
		  DB::beginTransaction();
		  
		  $respuesta = "";
		  switch ($request->option){
			  case 1: //Buscar información visita
				  if ($request->cas_id == "" || $request->num_vis == "") throw new \Exception("Faltan parametros para obtener registro. Por favor verifique e intente nuevamente");
				  
				  $resultado = Caso::where("cas_id", "=", $request->cas_id)->first();
				  if (!$resultado) throw new \Exception("Error al momento de buscar la información de visita del Caso. Por favor intente nuevamente.");
				  
				  if ($request->num_vis == 1){
				  	  $respuesta = ["fecha_visita" => $resultado->cas_visit_fec_1, "descripcion_visita" => $resultado->cas_visit_des_1, "numero_visita" => $request->num_vis, "modalidad_visita" => $resultado->cas_visit_mod_1];
				  
				  }else if ($request->num_vis == 2){
					  $respuesta = ["fecha_visita" => $resultado->cas_visit_fec_2, "descripcion_visita" => $resultado->cas_visit_des_2, "numero_visita" => $request->num_vis, "modalidad_visita" => $resultado->cas_visit_mod_2];
					  
				  }else if ($request->num_vis == 3){
					  $respuesta = ["fecha_visita" => $resultado->cas_visit_fec_3, "descripcion_visita" => $resultado->cas_visit_des_3, "numero_visita" => $request->num_vis, "modalidad_visita" => $resultado->cas_visit_mod_3];
					  
				  }
			  break;
			
			  case 2: //Registrar nueva visita
				  if ($request->cant_vis == 3) throw new \Exception("No puede ingresar más de 3 visitas para un Caso. Por Favor verifique.");
				  
				  $insertar_registro = Caso::where("cas_id", "=", $request->cas_id)->first();
				  if ($request->cant_vis == 0){
					  $insertar_registro->cas_visit_fec_1 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					  $insertar_registro->cas_visit_des_1 = $request->descripcion_visita;
					  $insertar_registro->cas_visit_mod_1 = $request->modalidad_visita;
				  
				  }else if ($request->cant_vis == 1){
					  $insertar_registro->cas_visit_fec_2 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					  $insertar_registro->cas_visit_des_2 = $request->descripcion_visita;
					  $insertar_registro->cas_visit_mod_2 = $request->modalidad_visita;
				 
				  }else if ($request->cant_vis == 2){
					  $insertar_registro->cas_visit_fec_3 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					  $insertar_registro->cas_visit_des_3 = $request->descripcion_visita;
					  $insertar_registro->cas_visit_mod_3 = $request->modalidad_visita;
				  
				  }
				
				  $respuesta = $insertar_registro->save();
				  if (!$respuesta) throw new \Exception("Error al momento de guardar la información de la visita. Por favor intente nuevamente");
			  break;
			
			  case 3: //Actualizar visita
				 $actualizar_registro = Caso::where("cas_id", "=", $request->cas_id)->first();
				 
				 if ($request->num_vis == 1){
					 $actualizar_registro->cas_visit_fec_1 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					 $actualizar_registro->cas_visit_des_1 = $request->descripcion_visita;
					 $actualizar_registro->cas_visit_mod_1 = $request->modalidad_visita;
				 	
				 }else if($request->num_vis == 2){
					 $actualizar_registro->cas_visit_fec_2 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					 $actualizar_registro->cas_visit_des_2 = $request->descripcion_visita;
					 $actualizar_registro->cas_visit_mod_2 = $request->modalidad_visita;
					 
				 }else if($request->num_vis == 3){
					 $actualizar_registro->cas_visit_fec_3 = Carbon::createFromFormat( 'd/m/Y', $request->fecha_visita);
					 $actualizar_registro->cas_visit_des_3 = $request->descripcion_visita;
					 $actualizar_registro->cas_visit_mod_3 = $request->modalidad_visita;
				 }
				
				 $respuesta = $actualizar_registro->save();
				 if (!$respuesta) throw new \Exception("Ocurrio un Error al Actualizar la Información de la Visita N° X. Por Favor intente nuevamente.");
			  break;
		  }
		  
		   DB::commit();
		   return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	   }catch(\Exception $e){
		   DB::rollback();
		   Log::error('error: '.$e);
		   
		   $mensaje = "Error al momento de realizar la acción solicitada. Por favor intente nuevamente.";
		   if (!is_null($e->getMessage())  && $e->getMessage() != "") $mensaje = $e->getMessage();
		   
		   return response()->json(array('mensaje' => $mensaje), 400);
	   }
	}

	public function runificador(Request $request){
		try{
			if (!Rut::parse($request->run)->validate()){
				$mensaje = "RUN no válido. Por favor verificar y volver a intentar.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			
			}

			$run_formateado = Rut::parse($request->run)->format(Rut::FORMAT_ESCAPED); 
			$array_run = Rut::parse($run_formateado)->toArray();

			$consulta = ['rut' => $array_run[0], 'dv' => $array_run[1]];
			$cliente = new \SoapClient(config('constantes.url_runificador'), ['encoding' => 'UTF-8', 'trace' => true]);

			$respuesta = $cliente->obtenerPersona($consulta);
			if ($respuesta->obtenerPersonaResult->Estado == "ERROR"){
				$mensaje = $respuesta->obtenerPersonaResult->Glosa;
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);

			}

			$respuesta = $respuesta->obtenerPersonaResult;
		   return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
		}catch(\Exception $e){
		   $mensaje = "Hubo un error al momento de consultar el RUN ingresado. Por favor verificar y volver a intentar.";
		   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);

		}
	}


	public function preDiagnostico(){
		return view("ficha.prediagnostico");
	}

	public function guardarObsPreDiagnostico(request $request){

		try{

			$caso_id = $request->caso_id;
			$tipo = $request->tipo;
			$valor = $request->valor;

			$caso = Caso::find($caso_id);

			switch ($tipo){
				case 'obs_prediagnostico_1': 
					$caso->prediagnostico_des_1 = $valor;
					break;
				case 'obs_prediagnostico_2': 
					$caso->prediagnostico_des_2 = $valor;
					break;
				case 'obs_prediagnostico_3': 
					$caso->prediagnostico_des_3 = $valor;
					break;
				case 'obs_prediagnostico_4': 
					$caso->prediagnostico_des_4 = $valor;
					break;
				case 'obs_prediagnostico_5': 
					$caso->prediagnostico_des_5 = $valor;
					break;
				case 'obs_prediagnostico_6': 
					$caso->prediagnostico_des_6 = $valor;
					break;
			}

			$caso->save();

			$mensaje = "ok";
			return response()->json(array('estado' => '1', 'respuesta' => $mensaje), 200);

		}catch(\Exception $e){
			$mensaje = "Error: ".$e;
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}

	public function guardarFechaPreDiagnostico(request $request){

		try{

			$caso_id = $request->caso_id;
			$tipo = $request->tipo;
			$valor = Carbon::createFromFormat( 'd/m/Y', $request->valor);

			$caso = Caso::find($caso_id);

			switch ($tipo){
				case 'fecha_prediagnostico_1': 
					$caso->prediagnostico_fec_1 = $valor;
					break;
				case 'fecha_prediagnostico_2': 
					$caso->prediagnostico_fec_2 = $valor;
					break;
				case 'fecha_prediagnostico_3': 
					$caso->prediagnostico_fec_3 = $valor;
					break;
				case 'fecha_prediagnostico_4': 
					$caso->prediagnostico_fec_4 = $valor;
					break;
				case 'fecha_prediagnostico_5': 
					$caso->prediagnostico_fec_5 = $valor;
					break;
				case 'fecha_prediagnostico_6': 
					$caso->prediagnostico_fec_6 = $valor;
					break;
			}

			$caso->save();

			$mensaje = "ok";
			return response()->json(array('estado' => '1', 'respuesta' => $mensaje), 200);

		}catch(\Exception $e){
			$mensaje = "Error.".$e;
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
		
	}

	public function guardarDescripcionObjetivo(Request $request){
		try{
			$obj_id = $request->obj_id;
			$obj_nom = $request->obj_nom;

			if (!isset($obj_id) || $obj_id == ""){
				$mensaje = "No se encuentra el ID del objetivo. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);	
			}

			if (!isset($obj_nom) || $obj_nom == ""){
				$mensaje = "No se encuentra el nombre del objetivo. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);	
			}

			DB::beginTransaction();

			$objetivo = ObjetivoPaf::find($obj_id);
			$objetivo->obj_nom =  $obj_nom;
			$respuesta = $objetivo->save();
			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momendo de modificar el nombre del Objetivo. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();

			$mensaje = "Modificación registrada con éxito.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();

			return response()->json($e->getMessage(), 400);
		}
	}

	public function guardarObjetivoPrincipal(Request $request){
		try{
			$cas_id = $request->caso_id;
			$nombre = $request->descripcion_objetivo;

			if (!isset($cas_id) || $cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);	
			}

			if (!isset($nombre) || $nombre == ""){
				$mensaje = "No se encuentra el nombre del objetivo a ingresar. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);	
			}

			DB::beginTransaction();

			$objetivo = new ObjetivoPaf();
			$objetivo->obj_nom = $request->descripcion_objetivo;
			$objetivo->cas_id = $request->caso_id;
			$respuesta = $objetivo->save();

			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar el Objetivo. Por favor intente nuevamente o contacte con el Administrador.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();

			$mensaje = "Objetivo registrado con éxito.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			return response()->json($e->getMessage(), 400);
		
		}
	}

	public function actualizarTarea(Request $request){
		try{
			// --------------------- VALIDACION ----------------------
			if (is_null($request->tar_descripcion) || $request->tar_descripcion == "" || trim($request->tar_descripcion) == ""){
				$mensaje = "No se encuentra un nombre de tarea válido para registrar. Por favor verifique y vuelva a intentar.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($request->tar_observacion) || $request->tar_observacion == "" || trim($request->tar_observacion) == ""){
				$mensaje = "No se encuentra un resultado de tarea válido para registrar. Por favor verifique y vuelva a intentar.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($request->tar_plazo) || !is_numeric($request->tar_plazo) || $request->tar_plazo == ""){
				$mensaje = "No se encuentra un plazo de tarea válido para registrar. Por favor verifique y vuelva a intentar.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($request->cas_id) || $request->cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique y vuelva a intentar.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($request->obj_id) || $request->obj_id == ""){
				$mensaje = "No se encuentra ID del Objetivo. Por favor verifique y vuelva a intentar.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
			// --------------------- VALIDACION ----------------------

			DB::beginTransaction();

			$grup_fam_id = $request->grup_fam_id;
			$tar_id = $request->tar_id;
			$cas_id = $request->cas_id;
			$crear_tarea = false;

			$caso = Caso::find($cas_id);
			if (count($caso) == 0){
				$mensaje = "No se encuentra información del estado actual del caso. Por favor verifique y vuelva a intentar.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!is_null($tar_id) && isset($tar_id) && $tar_id != ""){
				$actualizar_tarea = TareaObjetivoPaf::find($tar_id);
				if (count($actualizar_tarea) == 0){
					$mensaje = "No se encuentra información de la tarea a actualizar. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				$resultado = DB::DELETE("DELETE AI_OBJ_TAREA_GRUP_FAM_PAF 
						WHERE TAR_ID = '".$tar_id."'");
			}else {
				$crear_tarea = true;
				$actualizar_tarea = new TareaObjetivoPaf();
			}
	
			$actualizar_tarea->obj_id 			= $request->obj_id;
			$actualizar_tarea->tar_descripcion 	= $request->tar_descripcion;
			$actualizar_tarea->tar_plazo 		= $request->tar_plazo;
			$actualizar_tarea->tar_grupfa_id 	= null;
			$actualizar_tarea->tar_observacion 	= $request->tar_observacion;

			$actualizar_tarea->tar_gestor_id = null;
			if (!is_null($request->id_responsable) && $request->id_responsable != ""){
				$actualizar_tarea->tar_gestor_id = $request->id_responsable;
			}

			if ($crear_tarea){
				$estado_tarea = config('constantes.est_tarea_vigente');

				if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')){
					$estado_tarea = config('constantes.est_tarea_en_ejecucion');

				}

				$actualizar_tarea->est_tar_id = $estado_tarea;
			}
			
			$resultado = $actualizar_tarea->save();
			if (!$resultado){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la información de la tarea. Por favor intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($tar_id) || !isset($tar_id) || $tar_id == ""){
				$tar_id = $actualizar_tarea->tar_id;
			}

			if($crear_tarea){
				$resultado = DB::insert("INSERT INTO AI_OBJ_TAR_BIT_PAF (tar_id, est_tar_id) VALUES (".$tar_id.",".config('constantes.est_tarea_vigente').")"); 

				if (!$resultado){
					$mensaje = "Hubo un error al momento de guardar el cambio de estado de la tarea. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				if ($caso->est_cas_id != config('constantes.en_elaboracion_paf')){
					$resultado = DB::insert("INSERT INTO AI_OBJ_TAR_BIT_PAF (tar_id, est_tar_id) VALUES (".$tar_id.",".config('constantes.est_tarea_en_ejecucion').")"); 

					if (!$resultado){
						$mensaje = "Hubo un error al momento de guardar el cambio de estado de la tarea. Por favor intente nuevamente.";

						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
					}

				}
			}

			if (!is_null($grup_fam_id) && $grup_fam_id != ""){
				foreach ($grup_fam_id AS $c1 => $v1){
					if (!is_null($v1) && $v1 != "" && is_numeric($v1)){
						$resultado = DB::INSERT("INSERT INTO AI_OBJ_TAREA_GRUP_FAM_PAF (TAR_ID,GRU_FAM_ID) VALUES ('".$tar_id."','".$v1."')");

						if (!$resultado){
							DB::rollback();
							$mensaje = "Error al registrar un integrante como responsable de la tarea. Por favor intente nuevamente.";
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
						}
					}
				}
			}

			DB::commit();

			$mensaje = 'Información de Tarea registrada con éxito.';
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'obj_id'=> $request->obj_id), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('Error (Creación / Actualización Tarea): '.$e->getMessage());

			return response()->json($e->getMessage(), 400);
		}
	}

	public function recuperarDataTarea(Request $request){
		try{
			$edicion = false;
			$tar_id = $request->tar_id;
			if (!isset($tar_id) || $tar_id == ""){
				$mensaje = "No se encuentra el ID de la Tarea. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}


			$tarea = TareaObjetivoPaf::find($tar_id);
			if (!$tarea){
				$mensaje ="No se encuentra información de la Tarea solicitada. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$responsables = TareaObjetivoPaf::grupFamGesResp($tar_id);

			$tar_gestor_id = $tarea->tar_gestor_id;
			if(isset($tar_gestor_id) && $tar_gestor_id != ""){
				array_push($responsables, $tar_gestor_id);
			}

			$tarea['id_responsable'] = ($tarea->tar_gestor_id)?$tarea->tar_gestor_id:$tarea->tar_grupfa_id;

			$tarea['responsables'] = $responsables;

			return response()->json(array('estado' => '1', 'respuesta' => $tarea, 'edicion' => $edicion), 200);

		}catch (\Exception $e){
			return response()->json($e->getMessage(), 400);
		
		}
	}

	public function AccionesObjetivo(Request $request){

		try{

			$obj_id = $request->obj_id;
			$opcion = $request->option;
		    $edicion = false;
		    $respuesta="";

		    switch ($opcion){

	        	case 1: //Buscar información tarea

	        		$edicion = true;

	        		$respuesta = ObjetivoPaf::find($obj_id);

	        		if (!$respuesta){
						
						$mensaje = "Error al recolectar información del objetivo. Por favor intente nuevamente.";
						
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}

				break;

				case 4: //Actulizar tarea a no vigente

	        		$edicion = true;

	        		$actualizaTarea = DB::update("UPDATE AI_OBJ_TAREA_PAF SET 
					est_tar_id ='".config('constantes.est_tarea_no_vigente')."'
					where tar_id ='".$request->tar_id."'");

					if (!$actualizaTarea){
						
						$mensaje = "Error al momento de actualizar la tarea. Por favor intente nuevamente.";
						
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}

					$actualizaTareaBit = DB::insert("INSERT INTO ai_obj_tar_bit_paf 
					(TAR_ID,EST_TAR_ID,FECHA) VALUES ('".$request->tar_id."','".config('constantes.est_tarea_no_vigente')."','".Carbon::now()."')");

					if (!$actualizaTareaBit){
						
						$mensaje = "Error al momento de actualizar la bitacora de la tarea. Por favor intente nuevamente.";
						
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}
	        		

				break;

			}

			return response()->json(array('estado' => '1', 'respuesta' => $respuesta, 'edicion' => $edicion), 200);


		}catch (\Exception $e){
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}

	}

	public function listarTareas(Request $request){

		$obj_id = $request->obj_id;

		$tareas = TareaObjetivoPaf::where('obj_id',$obj_id)->get();

		foreach($tareas AS $c0 => $tarea_paf){
			$responsable_gestor = "";
			$responsable_grupof = "";

			if($tarea_paf->tar_gestor_id){
			$responsable_grupof = ($tarea_paf->tar_gestor_id)?$tarea_paf->gestor->nombres.' '.$tarea_paf->gestor->apellido_paterno.' '.$tarea_paf->gestor->apellido_materno:'';

				$responsable_grupof = "- ".$responsable_grupof;
			}

			$responsables_id = TareaObjetivoPaf::grupFamGesResp($tarea_paf->tar_id);

			foreach ($responsables_id as $v) {

				$result_gru_fam = DB::select("SELECT gru_fam_nom,gru_fam_ape_pat,gru_fam_ape_mat FROM ai_grupo_familiar 
					WHERE GRU_FAM_ID='".$v."'");

				$responsable_grupof = $responsable_grupof."-".$result_gru_fam[0]->gru_fam_nom." ".$result_gru_fam[0]->gru_fam_ape_pat." ".$result_gru_fam[0]->gru_fam_ape_mat;
					
			}

			$tarea_paf['nombre_responsable'] = ($responsable_gestor)?$responsable_gestor:$responsable_grupof;
		}
		
		return Datatables::of($tareas)
            ->make(true);
	}

	public function AccionesTarea(Request $request){


		try{

			$respuesta = "";
			$tar_id = $request->tar_id;
			$opcion = $request->option;
		    $edicion = false;

		    switch ($opcion){

	        	case 1: //Buscar información tarea

	        		$edicion = true;

					$respuesta = TareaObjetivoPaf::find($tar_id);


					$respuesta['obj_nom'] = $respuesta->objetivoPaf->obj_nom;
					

					$respuesta['id_responsable'] = ($respuesta->tar_gestor_id)?$respuesta->tar_gestor_id:$respuesta->tar_grupfa_id;;
					

					if (!$respuesta){
						
						$mensaje = "Error al recolectar información de la tarea. Por favor intente nuevamente.";
						
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}

					break;

				case 3: //Actualizar tarea

					
					if (!$resultado){
						$mensaje = "Error al actualizar información de la tarea. Por favor intente nuevamente.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}
				break;
			}

			return response()->json(array('estado' => '1', 'respuesta' => $respuesta, 'edicion' => $edicion), 200);


		}catch (\Exception $e){
			 return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		 }
	
	}

	public function getVigentes(Request $request){
	    $caso_id = $request->caso_id;
	    
	    $sql = "select count(*) as vigentes
			from 
			ai_objetivo_paf a
		    left join ai_obj_tarea_paf b on (a.obj_id = b.obj_id)
			left join ai_obj_tar_estado_paf c on (b.est_tar_id = c.est_tar_id)
			left join ai_obj_tar_bit_paf d on (c.est_tar_id = d.est_tar_id and b.tar_id = d.tar_id)     
            WHERE c.est_tar_id = 1
            AND a.cas_id= ".$caso_id;
	    
	    $sql = DB::select($sql);
	    return Datatables::of($sql)
	    ->make(true);
	}


	public function listarObjetivosPaf(Request $request){

		$caso_id = $request->caso_id;
		$chkestados = $request->chkestados;
		//dd($request->fec_ini);

		$sql_filtro_fecha_ini = "";

		$sql_filtro_fecha_ter = "";

		$sql_filtro_fecha_ini_ter = "";

		$i=0;	

		$sql_filtro_estado = "(b.est_tar_id IN (1,2) OR b.est_tar_id IS NULL) and ";

		if(($request->fec_ini!="")&&($request->fec_ter!="")){

			$start_date = Carbon::createFromFormat( 'd/m/Y', $request->fec_ini)->startOfDay();
			$end_date = Carbon::createFromFormat( 'd/m/Y', $request->fec_ter)->endOfDay();

			$sql_filtro_fecha_ini_ter = "d.fecha BETWEEN '".$start_date ."' AND '".$end_date."' and";


		} else if($request->fec_ini!=""){

			$start_date = Carbon::createFromFormat( 'd/m/Y', $request->fec_ini)->startOfDay();
		
			$sql_filtro_fecha_ini = "d.fecha>='".$start_date."' and";

		} else if($request->fec_ter!=""){
		
        	$end_date = Carbon::createFromFormat( 'd/m/Y', $request->fec_ter)->endOfDay();
		
			$sql_filtro_fecha_ter = "d.fecha<='".$end_date."' and";

		}

		if(($chkestados!=0)&&($chkestados!=5)){

			$filtro_sin_info = "";

			foreach ($chkestados as $vchk) {

				if($vchk==5) $filtro_sin_info = "OR b.est_tar_id IS NULL";

				if($i==0){
					$filtro = $vchk;
					$i=1;
				}else{
					$filtro = $filtro .",".$vchk;
				}

			}

			$sql_filtro_estado = "(b.est_tar_id IN (".$filtro.") ".$filtro_sin_info.") and ";

		} else if(($chkestados==0) && ($chkestados!="")) {

			$sql_filtro_estado ="b.est_tar_id IN (0) and ";

		 } else if($chkestados==5) {

			$sql_filtro_estado = "(b.est_tar_id IS NULL) and ";

		 }

		//($sql_filtro_estado);

		

		
		$sql = "select rownum as registro,
				a.obj_nom obj_nom,
			a.obj_id obj_id,
			b.tar_id,
			b.tar_descripcion tar_descripcion,
			b.tar_plazo plazo,
			b.tar_gestor_id gestor,
			b.tar_grupfa_id familiar,
			b.tar_observacion observacion,
			b.tar_fecha_seg tar_fecha_seg,
			b.tar_comentario_seg tar_comentario_seg,
			c.est_tar_nom estado,
			c.est_tar_id,
			d.fecha as est_act_fecha
			from 
			ai_objetivo_paf a
		    left join ai_obj_tarea_paf b on (a.obj_id = b.obj_id)
			left join ai_obj_tar_estado_paf c on (b.est_tar_id = c.est_tar_id)
			left join ai_obj_tar_bit_paf d on (c.est_tar_id = d.est_tar_id and b.tar_id = d.tar_id)
			where ".$sql_filtro_fecha_ini_ter." ".$sql_filtro_fecha_ter." ".$sql_filtro_fecha_ini." ".$sql_filtro_estado." a.cas_id=".$caso_id." order by obj_id asc, tar_id asc";

			// dd($sql);

		$sql = DB::select($sql);

		//dd($sql);

		if($sql!=[]){

			$nom_base = $sql[0]->obj_nom;

		}else{

			$nom_base = null;
		}

		
		$cont= 1 ;

		// }else{ 
		// 	if (!is_null($v1->familiar) && $v1->familiar != ""){
		// 		$responsable = DB::select("SELECT * FROM ai_grupo_familiar WHERE gru_fam_id = ".$v1->familiar);
		// 		 if (count($responsable) > 0) $responsable = $responsable[0]->gru_fam_nom." ".$responsable[0]->gru_fam_ape_pat." ".$responsable[0]->gru_fam_ape_mat;

		foreach ($sql AS $c1 => $v1){
			// $responsable = "Sin información";

			$responsable = "";
			if (!is_null($v1->gestor) && $v1->gestor != ""){
				 $responsable = DB::select("SELECT * FROM ai_usuario WHERE id = ".$v1->gestor);
				 if(count($responsable) > 0) {

				 		$responsable = "- ".$responsable[0]->nombres." ".$responsable[0]->apellido_paterno." ".$responsable[0]->apellido_materno;
				 
				 }
			}

			$grupFamGesResp = TareaObjetivoPaf::grupFamGesResp($v1->tar_id);

			if($grupFamGesResp){

				foreach ($grupFamGesResp as $v) {

					$result = DB::select("SELECT * FROM ai_grupo_familiar WHERE gru_fam_id = ".$v);

					if(count($result) > 0){

						$responsable = $responsable." - ".$result[0]->gru_fam_nom." ".$result[0]->gru_fam_ape_pat." ".$result[0]->gru_fam_ape_mat;
					
					}
				}

			}

			$sql[$c1]->responsable = $responsable;

			$fecha_estado = DB::select("SELECT to_char(fecha,'dd-mm-YYYY') as fecha, fecha as fecha_filtro FROM AI_OBJ_TAR_BIT_PAF WHERE tar_id = '".$v1->tar_id."' and est_tar_id='".$v1->est_tar_id."'" );

			if($fecha_estado){

				$sql[$c1]->fecha_estado = $fecha_estado[0]->fecha;

			} else {

				$sql[$c1]->fecha_estado = "Sin información";

			}

			$responsable = "";

			if($nom_base!=$v1->obj_nom){
				
				$cont = $cont + 1;

			 	$sql[$c1]->num_reg = $cont;

			 	$nom_base=$v1->obj_nom;

			 }else {

			 	 	$sql[$c1]->num_reg = $cont;	
			 }

			
			 //dd($sql);

		}

		return Datatables::of($sql)
            ->make(true);

	}

	public function verificarDiagnostico($cod_caso){

		$caso = Caso::find($cod_caso);
		
		$i = $preguntas_respondidas_ncfasg_ingreso = 0;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;
		$caso_id = $caso->cas_id;

		// se verifican visitas
		if (is_null($caso->cas_visit_fec_1) || $caso->cas_visit_fec_1 == "" || is_null($caso->cas_visit_des_1) || $caso->cas_visit_des_1 == ""){
			// INICIO CZ SPRINT 59
			$array_respuesta['mensajes'][$i++] = 'Debe registrar actividades';
			// FIN CZ SPRINT 59
			$array_respuesta['respuesta'] = 0;
		}

		// se verifica el documento de consentimiento
		if (is_null($caso->cas_doc_cons) || $caso->cas_doc_cons == ""){
			$array_respuesta['mensajes'][$i++] = 'Debe subir el Documento de Consentimiento';
			$array_respuesta['respuesta'] = 0;
		}

		// se verifica el NCFAS-G
		$respuestas_ncfasg = Respuesta::where('cas_id',$caso_id)->whereNotNull('alt_id')->orderBy('pre_id')->orderBy('fas_id')->get();

		$sql_preguntas_ncfasg = "select pre_id from ai_pregunta where dim_enc_id in (select dim_enc_id from ai_dimension_encuesta where dim_enc_id between ".config('constantes.a_entorno')." and ".config('constantes.h_salud_familiar').") and pre_tip=".config('constantes.preguntas_nfcfas');

		$coleccion_de_preguntas_ncfasg = collect(DB::select($sql_preguntas_ncfasg));
		foreach ($coleccion_de_preguntas_ncfasg as $pregunta){
			if ($respuestas_ncfasg->where('pre_id', $pregunta->pre_id)->where('fas_id',config('constantes.ncfas_fs_ingreso'))->count()>0){
				$preguntas_respondidas_ncfasg_ingreso++;
			}
		}

		if ($coleccion_de_preguntas_ncfasg->count()<>$preguntas_respondidas_ncfasg_ingreso)
		{
			$array_respuesta['mensajes'][$i++] = 'Debe realizar el NCFAS-G';
			$array_respuesta['respuesta'] = 0;
		}

		$caso = Caso::select('est_cas_id')->where('cas_id',$caso_id)->get();
		// INICIO CZ SPRINT 63 Casos ingresados a ONL
		$run = DB::Select("select * from ai_persona_usuario where cas_id = {$caso_id}");
		$alertasXnna = Helper::getAlertaNNAxTipoEva($caso_id,$caso[0]->est_cas_id,$run[0]->run);
		// FIN CZ SPRINT 63 Casos ingresados a ONL
		if(count($alertasXnna) == 0){
			$array_respuesta['mensajes'][$i++] = "Debe incorporar alertas territoriales";
			$array_respuesta['respuesta'] = 0;
		}
		// INICIO CZ SPRINT 61
		$count_est_ale_id = 0;
 		foreach($alertasXnna as $key => $alerta){
			
			if($alerta->est_ale_id == 1){
				$count_est_ale_id++;
				
			}
		}

		if($count_est_ale_id != 0){
			$array_respuesta['mensajes'][$i++] = "No pueden avanzar de etapa si tienen alertas “por validar”";
			$array_respuesta['respuesta'] = 0;
		}
		// FIN CZ SPRINT 61
		return $array_respuesta;
		
	}

	//Andres F. - Inicio
	public function verificarEjecucionPaf($cod_caso){
	
		$caso = Caso::find($cod_caso);
		$i = $tareas_sin_fecha = 0;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1; //1:ok 0:error
		$objetivos = ObjetivoPaf::tarGesPen($cod_caso);
		if(count($objetivos) > 0 ){  //existen tareas en ejecución
			$array_respuesta['respuesta'] = 0;
			$array_respuesta['mensajes'][$i++] = 'Existen tareas en ejecución';
		} 
		

		/////////////////////////////////
		// VALIDACION DE FECHAS DE TAREAS
		/////////////////////////////////
		/*$objetivos = ObjetivoPaf::where('cas_id',$cod_caso)->get();
		foreach ($objetivos as $objetivo){
			$tareas_sin_fecha +=  $objetivo->tareas->where('tar_fecha_seg', null)->count();
		}

		if ($tareas_sin_fecha > 0){
			$array_respuesta['mensajes'][$i++] = 'Debe colocar fecha a todas las tareas';
			$array_respuesta['respuesta'] = 0;			
		}*/


			return $array_respuesta;

	}
	//Andres F. - Fin

	public function verificarElaborarPaf($cod_caso){

		$caso = Caso::find($cod_caso);

		$i = $tareas_paf = 0;
	
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;
		$caso_id = $caso->cas_id;

		if ($caso->documentosPaf->count()==0){
			$array_respuesta['mensajes'][$i++] = 'Debe subir el Plan de Atención Familiar';
			$array_respuesta['respuesta'] = 0;
		}

		if ($caso->nec_ter==null || $caso->nec_ter==''){
			$array_respuesta['mensajes'][$i++] = 'Debe seleccionar una opción para la sección ¿necesita terapia?';
			$array_respuesta['respuesta'] = 0;
		}

		$objetivos = ObjetivoPaf::where('cas_id',$caso_id)->get();
		foreach($objetivos as $objetivo){
			$tareas_paf += TareaObjetivoPaf::where('obj_id',$objetivo->obj_id)->count();
		}

		if ($tareas_paf==0){
			$array_respuesta['mensajes'][$i++] = 'Debe agregar los Objetivos y sus Tareas';
			$array_respuesta['respuesta'] = 0;
		}
		
		//INICIO DC
		//verifica vinculacion alertas
		// INICIO CZ SPRINT 69
		$alertas = DB::select("SELECT
            am.ale_man_id
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			left join ai_caso_alerta_manual ca on am.ale_man_id = ca.ale_man_id
			WHERE ca.cas_id=".$caso_id."
            and am.est_ale_id in (2, 4)
            GROUP BY am.ale_man_id");
			// FIN CZ SPRINT 69
		if(count($alertas) > 0){
		    $error_vinculacion = 0;
		    $cont_alertas = 0;
		    foreach ($alertas as $alerta){
		        $idAlerta = $alerta->ale_man_id;
		        $vinculada = DB::select("select * from ai_alerta_objetivo
                where ai_caso_id = ".$caso_id."
                and ai_alerta_id = ".$idAlerta);
		        if(count($vinculada) == 0){
		            $error_vinculacion = 1;
		            $cont_alertas++;
		        }
		    }
		    if($error_vinculacion == 1){
		        $array_respuesta['mensajes'][$i++] = "Se han detectado ".$cont_alertas." Alerta(s) Territorial(es) sin vincular";
		        $array_respuesta['respuesta'] = 0;
		    }
		    
		}
		//FIN DC
		
		return $array_respuesta;

	}

	public function verificarEvaluacionPaf($cod_caso){

		$caso = Caso::find($cod_caso);
		
		$i = $preguntas_respondidas_ncfasg_cierre = 0;
		$array_respuesta = array();
		$array_respuesta['respuesta'] = 1;
		$caso_id = $caso->cas_id;

		//se verifica las preguntas de sesion de devolucion

		$sesDev = SesionDevolucion::select('ses_dev_fec','ses_dev_pre_1','ses_dev_pre_2','ses_dev_pre_3','ses_dev_pre_4','ses_dev_pre_5')->where('cas_id', $cod_caso)->first();
		if(!is_null($sesDev)){
			if((is_null($sesDev->ses_dev_fec))||(is_null($sesDev->ses_dev_pre_1))||(is_null($sesDev->ses_dev_pre_2))||(is_null($sesDev->ses_dev_pre_3))||(is_null($sesDev->ses_dev_pre_4))||(is_null($sesDev->ses_dev_pre_5))){
				$array_respuesta['mensajes'][$i++] = 'Debe responder las preguntas de Sesión de Devolución de Resultados';
				$array_respuesta['respuesta'] = 0;
			}
		}else{
			$array_respuesta['mensajes'][$i++] = 'Debe responder las preguntas de Sesión de Devolución de Resultados';
			$array_respuesta['respuesta'] = 0;
		}
		
		//se verifica la encuesta de satisfacción
		if (is_null($caso->cas_enc_sati) || $caso->cas_enc_sati == ""){
			$array_respuesta['mensajes'][$i++] = 'Debe subir la encuesta de satisfacción';
			$array_respuesta['respuesta'] = 0;
		}

		// se verifica el NCFAS-G
		if ($caso->fas_id != config("constantes.ncfas_fs_cierre")){
			$array_respuesta['mensajes'][$i++] = 'Debe realizar el NCFAS-G';
			$array_respuesta['respuesta'] = 0;
		}

		return $array_respuesta;

	}

	public static function getDatosSesiones(Request $request){
	    $cas_id=$request->cas_id;
	    $terapia=$request->terapia;
		//inicio ch
		$sesiones = DB::select("SELECT td.ptf_id from ai_terapia_ptf_detalle td
								LEFT JOIN ai_terapia at ON td.tera_id = at.tera_id
								WHERE at.cas_id = ".$cas_id." and td.ptf_id < 9 and td.PTF_DET_ESTRATEGIA is NOT NULL");
	    $array_respuesta['sesiones_realizadas'] = count($sesiones);
	    

		$sesiones2 = Terapia::where("cas_id", $cas_id)->value("ter_com_fir");
		//fin ch
	    $array_respuesta['sesiones_comprometidas'] = $sesiones2;

		//inicio ch
		if ($sesiones2 == 0) {

			$array_respuesta['porcentaje_logro'] = 0;
		}else if($sesiones == 0){
			$array_respuesta['porcentaje_logro'] = 0;
		}else{
		$array_respuesta['porcentaje_logro'] = number_format(($array_respuesta['sesiones_realizadas'] / $array_respuesta['sesiones_comprometidas'])*100, 2);

		}
		//fin ch
		
	    return $array_respuesta;
	}
	//inicio ch
	public static function getDatosSesionFamiliar(Request $request){
		$cas_id=$request->cas_id;
	    $terapia=$request->terapia;
	    $sesiones = DB::select("SELECT td.ptf_id from ai_terapia_ptf_detalle td
		LEFT JOIN ai_terapia at ON td.tera_id = at.tera_id
		WHERE at.cas_id = ".$cas_id." and td.ptf_id >= 9 and td.PTF_DET_ESTRATEGIA is NOT NULL");
								
	    $array_respuesta['sesiones_realizadas2'] = count($sesiones);
	    
		// INICIO CZ SPRINT 71 MANTIS 9848
	    $sesiones2 = DB::select("SELECT b.ptf_id as ptf_id from ai_terapia_ptf a
		left join ai_terapia_ptf_detalle b on (a.ptf_id = b.ptf_id) and b.tera_id = ".$terapia." where a.ptf_actividad = 'Taller Multifamiliar' and a.flag_modelo_terapia = 1  order by a.ptf_orden");
		// FIN CZ SPRINT 71 MANTIS 9848
	    $array_respuesta['sesiones_comprometidas2'] = count($sesiones2);
		//inicio ch
		$array_respuesta['porcentaje_logro2'] = number_format(($array_respuesta['sesiones_realizadas2'] / $array_respuesta['sesiones_comprometidas2'])*100,2);
		//fin ch
		
	    return $array_respuesta;
	}
	//fin ch
	// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public function gestionTerapiaFamiliar(Request $request, $run = null, $idcaso = null){
	// FIN CZ SPRINT 63 Casos ingresados a ONL
		try{
			
			if($idcaso == null || $run == null ){
				$mensaje = "URL incompleta. Por favor intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$return_vista = array();
			// INICIO CZ SPRINT 69
			$info_nna = $this->caso->informacionNNAPersona($run, $idcaso);
			// FIN CZ SPRINT 69
			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			$nna_teparia = $this->caso->informacionNNATerapia($idcaso);
			
			if($idcaso == 0){
				$info_nna[0]->cas_id = null;
				$info_nna[0]->estado = null;
			}else{ 
				$caso = Caso::find($idcaso);
				$info_nna[0]->cas_id = $idcaso;
				$info_nna[0]->estado = $caso->est_cas_id;
				$info_nna[0]->score = $caso->cas_sco;
				$info_nna[0]->cas_doc_cons = $caso->cas_doc_cons;
				$info_nna[0]->est_pau = $caso->cas_est_pau;
			}
			// FIN CZ SPRINT 63 Casos ingresados a ONL

			$return_vista["caso"] = $info_nna[0];
			$return_vista["nna_teparia"] = $nna_teparia[0];
		    $return_vista["run"] = $run;



		    //---------------VALIDACION DE PERMISOS X PERFIL-------
		   	$return_vista["modo_visualizacion"] = "";
		   	if (session()->all()["editar"]){
				$return_vista["modo_visualizacion"] = 'edicion';

			}else if (!session()->all()["editar"]){
				if (session()->all()["visualizar"]) $return_vista["modo_visualizacion"] = 'visualizacion';

			}
			//---------------VALIDACION DE PERMISOS X PERFIL--------


			//-------------------VISUALIZAR NCFAS-G-----------------
			$data = new \stdClass;
			$data->nombre = $info_nna[0]->nombre;
			$data->run = $info_nna[0]->run;
			$data->dig = $info_nna[0]->dig;
			$return_vista["data"]        = $data;

			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			$caso 	= Caso::where("cas_id", "=", $idcaso)->first();
			// FIN CZ SPRINT 63 Casos ingresados a ONL
			if (!$caso){
				$mensaje = "No se encontro información del caso consultado. Por favor intente nuevamente.";

				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}

			$return_vista["fas_id"]        = $caso->fas_id;
			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			$array_ncfas = Pregunta::listar_ncfas($idcaso);
			// FIN CZ SPRINT 63 Casos ingresados a ONL
			$return_vista["array_ncfas"]        = $array_ncfas;
			//-------------------VISUALIZAR NCFAS-G-----------------
			
			// INICIO CZ SPRINT 63 Casos ingresados a ONL
			$historial_pausa =  DB::select(" select u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre,a.cas_id,to_char(fec_ing,'dd-mm-yyyy HH24:MI:SS')fec_ing, usu_id, estado, comentario 
				 from ai_caso_bit_pau  a left join ai_usuario u on a.usu_id=u.id 
				 where a.cas_id='".$idcaso."'");

			$sesiones = DB::select("SELECT tpd.ptf_det_id FROM ai_terapia_ptf_detalle tpd
									LEFT JOIN ai_terapia at ON tpd.tera_id = at.tera_id
									WHERE at.cas_id = ".$idcaso." AND tpd.ptf_det_resultado IS NOT NULL");

			// FIN CZ SPRINT 63 Casos ingresados a ONL			
			$return_vista["historial_pausa"] = $historial_pausa;
			$return_vista["sesiones"] = count($sesiones);
			return view("ficha.terapia.gestion_terapia_familiar", $return_vista);

		}catch(\Exception $e){
			Log::error('error: '.$e);
			//INICIO CZ SPRINT 66
			$mensaje = "Ocurrio un error al momento de desplegar la información, intente nuevamente.";
			// FIN CZ SPRINT 66
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}

	public function listarCasosDesestimados(Request $request){
		
		try{

			$acciones = $this->perfil->acciones();

			$icono = Funcion::iconos(161);

			$tipo_programa = DB::select("SELECT 
									tip_pro_seg_cod,
									tip_pro_seg_nom 
									FROM 
									AI_TIPO_PROGRAMA_SEGUIMIENTO
									ORDER BY tip_pro_seg_cod asc");


			return view('caso.desestimados',
			[
				'acciones' => $acciones,
				'icono' => $icono,
				'tipo_programa' => $tipo_programa
			]
		);

		}catch(\Exception $e){
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error al momento de desplegar la información, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}

	// INICIO CZ SPRINT 72
	public function dataCasosDesestimados(Request $request){
		$estado = $request->estado;
		if($estado == null || $estado == 0){

		$resultado = array();
		$comuna = explode(',',session()->all()['com_cod']);
		
		if (session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
				$casos_desestimados = CasosDesestimados::whereIn('cod_com', $comuna)->get();			
				foreach ($casos_desestimados AS $c01 => $v01){
					$caso_con_seguimiento = SeguimientoCasoDesestimado::where("caso_id", "=", $v01->cas_id)->first();

					if (count($caso_con_seguimiento) > 0){
						if (config("constantes.NNA_ha_sido_ingresado_al_programa_de_protección") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_derivado_a_oferta_especializada") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_ha_sido_ingresado_al_programa") == $caso_con_seguimiento->est_cas_seg_cod){
							unset($casos_desestimados[$c01]);
						} 
						

					}
				}
			

				// return Datatables::of($casos_desestimados)->make(true);

			}else if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
				$casos_desestimados = CasosDesestimados::whereIn('cod_com', $comuna)
				->where('usuario_id', '=',session()->all()['id_usuario'])
				->get();
		
			foreach ($casos_desestimados AS $c01 => $v01){
				$caso_con_seguimiento = SeguimientoCasoDesestimado::where("caso_id", "=", $v01->cas_id)->first();

				if (count($caso_con_seguimiento) > 0){
						if (config("constantes.NNA_ha_sido_ingresado_al_programa_de_protección") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_derivado_a_oferta_especializada") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_ha_sido_ingresado_al_programa") == $caso_con_seguimiento->est_cas_seg_cod){
							unset($casos_desestimados[$c01]);
						} 
					

				}
			}
				// return Datatables::of($casos_desestimados)->make(true);
			}
		}else{
			$resultado = array();
			$comuna = explode(',',session()->all()['com_cod']);
			
			if (session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
				$casos_desestimados = CasosDesestimados::whereIn('cod_com', $comuna)
				->where("es_cas_id", $estado)
				->get();	

				foreach ($casos_desestimados AS $c01 => $v01){
					$caso_con_seguimiento = SeguimientoCasoDesestimado::where("caso_id", "=", $v01->cas_id)->first();

					if (count($caso_con_seguimiento) > 0){
						if (config("constantes.NNA_ha_sido_ingresado_al_programa_de_protección") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_derivado_a_oferta_especializada") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_ha_sido_ingresado_al_programa") == $caso_con_seguimiento->est_cas_seg_cod){
							unset($casos_desestimados[$c01]);
						} 
						

					}
				}
				// return Datatables::of($casos_desestimados)->make(true);
			// CZ SPRINT 75
		}else if (session()->all()['perfil'] == config('constantes.perfil_gestor')){

				$casos_desestimados = CasosDesestimados::whereIn('cod_com', $comuna)
			->where('usuario_id', '=',session()->all()['id_usuario'])
				->where("es_cas_id", $estado)
			->get();

			// CZ SPRINT 75
		foreach ($casos_desestimados AS $c01 => $v01){
			$caso_con_seguimiento = SeguimientoCasoDesestimado::where("caso_id", "=", $v01->cas_id)->first();

			if (count($caso_con_seguimiento) > 0){
						if (config("constantes.NNA_ha_sido_ingresado_al_programa_de_protección") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_derivado_a_oferta_especializada") == $caso_con_seguimiento->est_cas_seg_cod || config("constantes.NNA_ha_sido_ingresado_al_programa") == $caso_con_seguimiento->est_cas_seg_cod){
							unset($casos_desestimados[$c01]);
						} 
				

			}
		}
				// return Datatables::of($casos_desestimados)->make(true);
			}
		}

        return Datatables::of($casos_desestimados)->make(true);
		}
	// FIN CZ SPRINT 72
	public function egresoCasosDesestimados(Request $request){
		try{
			$caso_id 		= $request->caso_id;
			$estado 		= $request->estados;
			$contacto 		= $request->mod_contacto;
			$comentario 	= $request->comentario;
			$fecha 			= $request->int_date;
			$prog_atencion 	= "";
			$nom_proyecto 	= "";

			if (is_null($caso_id) || $caso_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($estado) || $estado == ""){
				$mensaje = "No se encuentra el ID del estado del seguimiento. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($contacto) || $contacto == ""){
				$mensaje = "No se encuentra el ID de la modalidad de contacto. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($comentario) || $comentario == ""){
				$mensaje = "No se encuentra el comentario ingresado. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (is_null($fecha) || $fecha == ""){
				$mensaje = "No se encuentra la fecha del seguimiento. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (config('constantes.NNA_ha_sido_ingresado_al_programa_de_protección') == $estado || config('constantes.NNA_derivado_a_oferta_especializada') == $estado || config('constantes.NNA_ha_sido_ingresado_al_programa') == $estado){
				$prog_atencion = $request->prog_atencion;
				$nom_proyecto = $request->nom_proyecto;

				if (is_null($prog_atencion) || $prog_atencion == ""){
					$mensaje = "No se encuentra el programa de atención. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				if (is_null($nom_proyecto) || $nom_proyecto == ""){
					$mensaje = "No se encuentra el nombre del proyecto. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			}

			$caso = Caso::find($caso_id);
			if (count($caso) == 0){
				$mensaje = "No se encuentra información del caso. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			switch ($caso->est_cas_id){
				case config('constantes.nna_presenta_medida_proteccion'):
					$estado_caso = config('constantes.nna_presenta_medida_proteccion');
				break;

				case config('constantes.nna_vulneracion_derecho_delito'):
					$estado_caso = config('constantes.nna_vulneracion_derecho_delito');
				break;

				case config('constantes.nna_vulneracion_derecho_no_delito'):
					$estado_caso = config('constantes.nna_vulneracion_derecho_no_delito');
				break;
			}

			$objetivo = DB::select("SELECT os.objetivo_id, os.objetivo_nombre, os.objetivo_codigo FROM ai_estado_objetivo_seguimiento eos LEFT JOIN ai_objetivo_seguimiento os ON eos.objetivo_codigo = os.objetivo_codigo WHERE eos.est_cas_id = ".$estado_caso);
			if (count($objetivo) == 0){
				$mensaje = "No se encuentra objetivo del estado seleccionado. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$seguimientoCasoDes = SeguimientoCasoDesestimado::where("caso_id", "=", $caso_id)->first();

			if (count($seguimientoCasoDes) == 0) $seguimientoCasoDes = new SeguimientoCasoDesestimado();
			    
				$seguimientoCasoDes->prog_seg_cod_proy 	= $nom_proyecto;
				$seguimientoCasoDes->tip_pro_seg_cod 	= $prog_atencion;
				$seguimientoCasoDes->est_cas_seg_cod 	= $estado;
				$seguimientoCasoDes->caso_id 			= $caso_id;
				$seguimientoCasoDes->objetivo_codigo 	= $objetivo[0]->objetivo_codigo;
				$resultado 	= $seguimientoCasoDes->save();
				if (!$resultado){
					DB::rollback();
					$mensaje = "Hubo un error al momento de guardar el seguimiento. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				$BitacoraSeguimiento = new BitacoraEstadoSeguimiento();
				$BitacoraSeguimiento->seg_cas_des_id 	= $seguimientoCasoDes->seg_cas_des_id;
				$BitacoraSeguimiento->est_cas_seg_cod 	= $estado;
				$BitacoraSeguimiento->fecha 			= Carbon::createFromFormat('d/m/Y', $fecha);
				$BitacoraSeguimiento->comentario 		= $comentario;
				$BitacoraSeguimiento->m_contacto_codigo = $contacto;
				$resultado 	= $BitacoraSeguimiento->save();
				if (!$resultado){
					DB::rollback();
					$mensaje = "Hubo un error al momento de guardar el estado del seguimiento. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			
				DB::commit();

				$mensaje = "Seguimiento guardado con éxito.";

				return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch (\Exception $e){
				DB::rollback();
				$mensaje = "Error al momento de guardar el seguimiento. Por favor intente nuevamente.";

			 	return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function casosBitacora($cas_id){

		$sql = "select
					a.cas_id,
					a.id_cec,
					b.est_cas_nom estado_caso,
					a.cas_est_cas_des descripcion_bitacora,
					to_char(a.cas_est_cas_fec,'dd-mm-yyyy') fecha_bitacora
				from
					ai_caso_estado_caso a,
					ai_estado_caso b
				where 
					a.cas_id = " .$cas_id. "
					and a.est_cas_id = b.est_cas_id
				order by est_cas_ord";

		$resultado = DB::select($sql);

		return Datatables::of(collect($resultado))->make(true);
	}

	public function dataProgAleTarAcPen(Request $request){

		$cas_id = $request->cas_id;

		$data_table_array = [];

		$resultado = Programa::proGesPen($cas_id);

		foreach ($resultado as $v) {

		array_push($data_table_array, array('id' => $v->prog_id,'tipo' => "Programa",'nombre' => $v->pro_nom,'estado' => $v->est_prog_nom));
		}

		// //$data_table_array = (object) $data_table_array;

		// dd($data_table_array);

		$resultadodos = AlertaManual::aleGesPen($cas_id);

		foreach ($resultadodos as $v) {

		array_push($data_table_array,array('id' => $v->ale_man_id,'tipo' => "Alertas",'nombre' => $v->ale_tip_nom,'estado' => $v->est_ale_nom));
		}

		$resultadotres = ObjetivoPaf::tarGesPen($cas_id);

		foreach ($resultadotres as $v) {

			if($v->ai_rgc_id==null){
				array_push($data_table_array,array('id' => $v->tar_id,'tipo' => "Tarea",'nombre' => $v->tar_descripcion,'estado' => "Sin Gestionar"));
			}

		}

		if($request->datatables==1)	{
			return Datatables::of(collect($data_table_array))->make(true);
		}	

		//dd($data_table_array);

		return response()->json(array('data_table_array' => $data_table_array),200);


	}

	public function dataTarPen(Request $request){

			$cas_id = $request->cas_id;

			$data_table_array = [];

			$resultado = ObjetivoPaf::tarGesPen($cas_id);

			foreach ($resultado as $v) {

				if($v->ai_rgc_id==null){
				array_push($data_table_array,array('id' => $v->tar_id,'nombre' => $v->tar_descripcion,'estado' => "Sin Gestionar", 'avances' => "", 'descripcion' => "", 'nacciones' => ""));
				}

			}

	//dd(Session::get('data_rpt_seg'));

	return Datatables::of(collect($data_table_array))->make(true);

	}

	public function dataDerPen(Request $request){

	$cas_id = $request->cas_id;

	$data_table_array = [];

	$resultado = Programa::proGesPen($cas_id);

	foreach ($resultado as $v) {

	array_push($data_table_array,array('id' => $v->prog_id,'nombre' => $v->pro_nom,'estado' => "Sin Gestionar", 'avances' => "", 'descripcion' => "",'razon' => "", 'nacciones' => ""));
	}

	return Datatables::of(collect($data_table_array))->make(true);

	}


	public function dataAlePen(Request $request){

	$cas_id = $request->cas_id;

	$data_table_array = [];

	$resultadodos = AlertaManual::aleGesPen($cas_id);

	foreach ($resultadodos as $v) {

	array_push($data_table_array,array('id' => $v->ale_man_id,'nombre' => $v->integrante,'estado' => $v->est_ale_nom, 'integrante' => "", 'nnaalerta' => "", 'tipale' => $v->ale_tip_nom));
	}

	return Datatables::of(collect($data_table_array))->make(true);

	}


	public function verificarEgresoPaf(Request $request){
		try{

			$cas_id = $request->caso_id;
			$caso = Caso::find($cas_id);
			$caso_est = NNAAlertaManualCaso::where("cas_id",$cas_id)->first();
			$ultimo_rep = $this->ultimoRepSeg($cas_id);

			$array_respuesta = array();
			$array_respuesta['respuesta'] 	= 1;
			
			
			// if (($caso->fas_id != config("constantes.ncfas_fs_cierre_ptf")) && ($caso_est->est_tera_fin == 0)){
			// 	$array_respuesta['respuesta'] = 0;

			// 	$mensaje = "Debe completar el NCFAS-G antes de egresar el Caso. Por favor verifique e intente nuevamente.";

			// 	$array_respuesta['mensajes'][0] = $mensaje;	
			// }

			return response()->json($array_respuesta, 200);

		}catch(\Exception $e){
			return response()->json($e->getMessage(), 400);
		
		}
	}

	public function ingresoRptSeg(Request $request){
		try {
			$data 			= $request->data;
			$caso_id 		= $data["informacion"][0]["cas_id"];
			$numero_reporte = $this->ultimoRepSeg($caso_id);
			$numero_reporte = $numero_reporte + 1;
			$fecha_reporte 	= $data["informacion"][0]["fecha_reporte"];

			DB::beginTransaction();

			// 	SE RECORRE DATA DE SEGUIMIENTO INGRESADO		
			foreach ($data as $clave => $valor){
				
				//INFORMACION
				if ($clave == "informacion"){
					foreach ($valor as  $v){
						$ReporteGestionCaso = new ReporteGestionCaso();
						$ReporteGestionCaso->ai_rgc_n_rep = $numero_reporte;
						$ReporteGestionCaso->ai_rgc_fec_seg = Carbon::createFromFormat('d/m/Y', $fecha_reporte);
						$ReporteGestionCaso->ai_rgc_tip_rep  = 0;
						$ReporteGestionCaso->ai_rgc_des =  $v["comentario"];
						$ReporteGestionCaso->ai_rgc_mod  = $v["modalidad_seguimiento"];
						$ReporteGestionCaso->ai_rgc_ter = 0;

						$respuesta = $ReporteGestionCaso->save();
						if (!$respuesta){
							$mensaje = "Hubo un error al momento de registrar la información del seguimiento. Por Favor verifique e intente nuevamente.";

							DB::rollback();
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
						}

						$CasoReporteGestion = new CasoReporteGestion();
						$CasoReporteGestion->cas_id 	= $caso_id;
						$CasoReporteGestion->ai_rgc_id 	= $ReporteGestionCaso->ai_rgc_id;
						$respuesta = $CasoReporteGestion->save();
						if (!$respuesta){
							$mensaje = "Hubo un error al momento de vincular los seguimientos de Alertas Territoriales ingresadas con el Caso. Por favor verifique e intente nuevamente.";

							DB::rollback();
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
						}
					}
				}
				
			}
			
			DB::commit();

			$mensaje = "Seguimiento registrado exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch (\Exception $e){
			DB::rollback();

			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

 	public function dataReporteGestion(Request $request){
		$data 	= array();

		if (isset($request->cas_id) && $request->cas_id != ""){
			$cas_id = $request->cas_id;
			$data = ReporteGestionCaso::listarReportesPorCaso($cas_id);
		}
		
		foreach($data AS $c0 => $v0){
			$v0->ai_rgc_fec_seg = date("d-m-Y", strtotime($v0->ai_rgc_fec_seg));
			$v0->ai_rgc_fec_ing = date("d-m-Y", strtotime($v0->ai_rgc_fec_ing));

		}

		return Datatables::of($data)
		->make(true);
	}

	public function levantarFichaRegistroSeguimiento(Request $request){
		try{
			if (!isset($request->cas_id) || $request->cas_id == ""){
				$mensaje = "No se encuentra N° del caso. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$cas_id = $request->cas_id;
			$dataRegistroSeguimiento = array();
			$dataRegistroSeguimiento["informacion"] = array();
			$dataRegistroSeguimiento["informacion"][0] = new \stdClass;
			$dataRegistroSeguimiento["informacion"][0]->cas_id = $cas_id;
			$dataRegistroSeguimiento["informacion"][0]->numero_reporte = 1;

			$programas_pendientes = Programa::proGesPen($cas_id);

			$alertas_pendientes = AlertaManual::aleGesPen($cas_id);

			$tareas_pendientes = ObjetivoPaf::tarGesPen($cas_id);

			$dataRegistroSeguimiento["programas"] = array();
			foreach ($programas_pendientes as $c0 => $v0){
				$dataRegistroSeguimiento["programas"][$c0] 					= new \stdClass;
				$dataRegistroSeguimiento["programas"][$c0]->prog_id 		= $v0->prog_id;
				$dataRegistroSeguimiento["programas"][$c0]->pro_nom 		= $v0->pro_nom;
				$dataRegistroSeguimiento["programas"][$c0]->est_prog_nom 	= $v0->est_prog_nom;
				$dataRegistroSeguimiento["programas"][$c0]->estab_nom 		= $v0->estab_nom; 
				$dataRegistroSeguimiento["programas"][$c0]->avances 		= ""; 
				$dataRegistroSeguimiento["programas"][$c0]->descripcion 	= ""; 
				$dataRegistroSeguimiento["programas"][$c0]->nuevas_acciones = ""; 
				$dataRegistroSeguimiento["programas"][$c0]->razon 			= ""; 
				$dataRegistroSeguimiento["programas"][$c0]->modalidad_seguimiento = ""; 
				$dataRegistroSeguimiento["programas"][$c0]->fecha_ingreso = "";
				$dataRegistroSeguimiento["programas"][$c0]->finalizar_pendiente = "";
			}

			$dataRegistroSeguimiento["tareas"] = array();
			foreach ($tareas_pendientes as $c1 => $v1){
				$dataRegistroSeguimiento["tareas"][$c1] = new \stdClass;
				$dataRegistroSeguimiento["tareas"][$c1]->obj_id 			= $v1->obj_id;
				$dataRegistroSeguimiento["tareas"][$c1]->tar_descripcion 	= $v1->tar_descripcion;
				$dataRegistroSeguimiento["tareas"][$c1]->tar_id 			= $v1->tar_id;
				$dataRegistroSeguimiento["tareas"][$c1]->avances 			= "";
				$dataRegistroSeguimiento["tareas"][$c1]->descripcion 		= "";
				$dataRegistroSeguimiento["tareas"][$c1]->nuevas_acciones 	= "";
				$dataRegistroSeguimiento["tareas"][$c1]->modalidad_seguimiento = "";
				$dataRegistroSeguimiento["tareas"][$c1]->fecha_ingreso = "";
				$dataRegistroSeguimiento["tareas"][$c1]->finalizar_pendiente = "";
			}

			$dataRegistroSeguimiento["alertas"] = array();
			foreach ($alertas_pendientes as $c2 => $v2){
				$dataRegistroSeguimiento["alertas"][$c2] = new \stdClass;
				$dataRegistroSeguimiento["alertas"][$c2]->ale_man_id 		= $v2->ale_man_id;
				$dataRegistroSeguimiento["alertas"][$c2]->ale_tip_nom 		= $v2->ale_tip_nom;
				$dataRegistroSeguimiento["alertas"][$c2]->est_ale_nom 		= $v2->est_ale_nom;
				$dataRegistroSeguimiento["alertas"][$c2]->integrante 		= $v2->integrante;
				$dataRegistroSeguimiento["alertas"][$c2]->nueva_alerta 		= "";
				$dataRegistroSeguimiento["alertas"][$c2]->modalidad_seguimiento = "";
				$dataRegistroSeguimiento["alertas"][$c2]->fecha_ingreso 
				= date_format(date_create($v2->ale_man_fec),"d/m/Y");
				$dataRegistroSeguimiento["alertas"][$c2]->finalizar_pendiente = "";
				$dataRegistroSeguimiento["alertas"][$c2]->sectorialista = $v2->sectorialista;
				$dataRegistroSeguimiento["alertas"][$c2]->nuevas_acciones = "";
			}

			$dataRegistroSeguimiento["pasos_a_seguir"] = array();
			$dataRegistroSeguimiento["pasos_a_seguir"][0] = new \stdClass;
			$dataRegistroSeguimiento["pasos_a_seguir"][0]->comentario = "";

			$numero_reporte = $this->ultimoRepSeg($cas_id);
			$numero_reporte = $numero_reporte + 1;

			return response()->json(array('estado' => '1', 'respuesta' => $dataRegistroSeguimiento, 'nreporte' => $numero_reporte), 200);
		}catch (\Exception $e){
			DB::rollback();
			$mensaje = "Error al momento de desplegar el reporte solicitado. Por favor intente nuevamente";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function ultimoRepSeg($cas_id){
		$respuesta = 0;

		$ultimo_rep_seg = DB::select("SELECT 
									ai_rgc_n_rep,
									ai_rgc_fec_seg 
									FROM 
									AI_CASO_REPORTE_GESTION aicg 
									LEFT JOIN
									AI_REPORTE_GESTION_CASO  airgc 
									ON airgc.ai_rgc_id = aicg.ai_rgc_id 
									WHERE cas_id='".$cas_id."' 
									ORDER BY ai_rgc_n_rep DESC");

		if (count($ultimo_rep_seg) == 0) return $respuesta;


		$respuesta = $ultimo_rep_seg[0]->ai_rgc_n_rep;
		return $respuesta;
	}


	public function gestionPendientesPaf($cas_id){

		$programa = Programa::proGesPen($cas_id);

		$ale_man = AlertaManual::aleGesPen($cas_id);

		$tarea = ObjetivoPaf::tarGesPen($cas_id);

		$sin_pendientes = 0;

		if($programa!=[]) $sin_pendientes = 1;
		if($ale_man!=[]) $sin_pendientes = 1;
		if($tarea!=[]) $sin_pendientes = 1;

		return $sin_pendientes;

	}

	public function nomGesVerificarOpd(Request $request){

		$array_result = [];

		$buscar_gestor =  Usuarios::buscaUsuario($request->id_usu);

		$nombre_gestor = $buscar_gestor[0]->nombres." ".$buscar_gestor[0]->apellido_paterno." ".$buscar_gestor[0]->apellido_materno;

		$array_result[0] = $nombre_gestor;

		$array_result[1] = 0;

		$array_result[2] = "";

		$array_result[3] = "";

		$result_ver_opd = Persona::verificarOpd($request->run);
		if($result_ver_opd){
			$array_result[1] = 1;
			$array_result[2] = $result_ver_opd[0]->est_cas_nom;
		}

		$verificarCantCaso = Persona::verificarCantCaso($request->id_usu);
		$array_result[3] = $verificarCantCaso;

		return $array_result;

	}


	public function guardarSesionesObjTarPaf(Request $request){
		try{
			$tar_id = $request->tar_id;
			if (!isset($tar_id) || $tar_id == ""){
				$mensaje = "No se encuentra ID de la tarea. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$fec_ses_tar = $request->fec_ses_tar;
			if (!isset($fec_ses_tar) || $fec_ses_tar == ""){
				$mensaje = "No se encuentra la fecha de realización de la Sesión. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$tar_sesion_ejecucion_paf = $request->tar_sesion_ejecucion_paf;
			if (!isset($tar_sesion_ejecucion_paf) || $tar_sesion_ejecucion_paf == ""){
				$mensaje = "No se encuentra el comentario de la Sesión. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::beginTransaction();

			$sesion_tarea = new SesionTarea();
			$sesion_tarea->tar_id = $tar_id; 
			$sesion_tarea->fecha = Carbon::createFromFormat('d/m/Y', $fec_ses_tar); 
			$sesion_tarea->comentario = $tar_sesion_ejecucion_paf;
			$sesion_tarea->id_usuario = session()->all()['id_usuario'];

			$resultado = $sesion_tarea->save();
			if (!$resultado){
				DB::rollback();

				$mensaje = "Hubo un error al momento de registrar la Sesión. Por favor verifique e intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
			
			DB::commit();

			$mensaje = "Sesión registrada con éxito.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch (\Exception $e){
			DB::rollback();

			return response()->json($e->getMessage(), 400);
		}
	}

	public function listarSesionesTareas(Request $request){

		$tar_id = $request->tar_id;

		$sesion_tareas = DB::select("SELECT
									tar_id,
									to_char(fecha,'dd-mm-YYYY') as fecha,
									comentario,
									fecha as fecha_ordena,
									u.nombres ||' '|| u.apellido_paterno ||' '|| 
									u.apellido_materno as nom_usu
									FROM 
									AI_SESION_TAREA ast 
									INNER JOIN 
									AI_USUARIO u ON ast.id_usuario=u.id
									WHERE tar_id='".$tar_id."' 
									ORDER BY fecha_ordena asc, id_sesion_tarea asc");

		return Datatables::of($sesion_tareas)
            ->make(true);

	}

		public function dataContacto(Request $request)
	{
		try {

			if (!isset($request->id) || $request->id == ""){
				$mensaje = "No se encuentra N° del caso. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$contacto =  Contacto::find($request->id);

			if (!$contacto){
							
							$mensaje = "Error al recolectar información del objetivo. Por favor intente nuevamente.";
							
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
						}
			return $contacto;
			
		} catch (Exception $e) {
			DB::rollback();
			$mensaje = "Error al momento de editar el contacto. Por favor intente nuevamente";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}

	public function editarContacto(Request $request)
	{


	$request->validate(
		[
			'nombres'=>'required',
			'paterno'=>'required',
			'materno'=>'required',
			'telefono'=>'numeric|required',
			'parentesco'=>'required',
			'prioridad'=>'required'
		],[],
		[
			'paterno'=>'apellido paterno',
			'materno'=>'apellido materno',
			'telefono'=>'número de telefono',
		]);

			DB::beginTransaction();

			$resultado = Contacto::where('con_id',$request->contact_id)->update(['con_nom'=>$request->nombres, 'con_pat'=>$request->paterno, 'con_mat'=>$request->materno, 'con_tlf'=>$request->telefono, 'con_par'=>$request->parentesco, 'con_con'=>$request->prioridad]);


		if (!$resultado){
			DB::rollback();
			return redirect()->route('coordinador.caso.ficha')
				->with('danger', 'Ocurrio un Error Editando el Contacto, Por Favor Verifique.', ['origen' => $request->origen, 'run' => $request->run]);
		}

			DB::commit();
			return redirect()->route('coordinador.caso.ficha', ['origen' => $request->origen, 'run' => $request->run])
				->with('success', 'El contacto '.$request->nombres.' '.$request->paterno.' ha sido editado.');

		
	}

	
	public function dataDireccion(Request $request){
		try {
			if (!isset($request->id) || $request->id == ""){
				$mensaje = "No se encuentra ID de Dirección. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$direccion =  Direccion::find($request->id);

			if (!$direccion){	
				$mensaje = "No se encuentra información de la Dirección Solicitada. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$provincia_id = Comuna::find($direccion->com_id);
			$region_id = Provincia::find($provincia_id->pro_id);

			$direccion['prov_id'] = $provincia_id->pro_id;
			$direccion['reg_id'] = $region_id->reg_id;

			return response()->json(array('estado' => '1', 'respuesta' => $direccion), 200);			
		} catch (Exception $e) {
			DB::rollback();
			$mensaje = "Error al momento de editar el direccion. Por favor intente nuevamente";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}

	public function editarDireccion(Request $request){
		try{
			if (!isset($request->id) || $request->id == ""){
				$mensaje = "No se encuentra ID de dirección. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->com_id) || $request->com_id == ""){
				$mensaje = "No se encuentra ID de la Comuna de la Dirección a actualizar. Por favor verifique e intente nuevamente.";
				
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if(config('constantes.activar_maestro_direcciones')){
				$com = Comuna::where("com_cod",$request->com_id)->first();
				$com_id = $com->com_id;
			}else{
				$com_id = $request->com_id;
			}

			DB::beginTransaction();

			$direcciones= Direccion::where('per_id', $request->per_id)->orderBy('dir_ord')->get();

			$prioridadEscalar = $request->prioridad;
			foreach ($direcciones as $direc){
				if($direc->dir_ord >= $prioridadEscalar){
					$prioridadEscalar++;

					$direccion = Direccion::find($direc->dir_id);
					$direccion->dir_ord = $prioridadEscalar;
					$respuesta = $direccion->save();
					if (!$respuesta){
						DB::rollback();
						$mensaje = "Hubo un error al momento de registrar la Dirección. Por favor verifique e intente nuevamente.";
				
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
					}
			 	}
			}

			$data = [
					'dir_call' => $request->dir_call, 
					'dir_num'  => $request->dir_num, 
					'dir_dep'  => $request->dir_dep, 
					'dir_block' => $request->dir_block, 
					'dir_sit'  => $request->dir_sit, 
					'dir_casa' => $request->dir_casa,
					'com_id'   => $com_id,
					'dir_ord'  => $request->prioridad,
					'dir_des'  => $request->dir_des,
					'dir_cod_id' => $request->dir_cod_id,
					'dir_fecha' => Carbon::now()
					];
		

			$resultado = Direccion::where('dir_id',$request->id)->update($data);

			if (!$resultado){
				DB::rollback();
				$mensaje = "Hubo un error al momento de actualizar la dirección. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			// cambio estado direccion 
			if ((config('constantes.activar_maestro_direcciones')) && ($request->dir_cod_id != null)){
				$cambio_est_dir = $this->cambioVigenciaDireccion($request->dir_cod_id, $request->nna_run);
				if ($cambio_est_dir["status"] != 1){
					DB::rollback();
	                $mensaje = "Hubo un error al cambiar el estado de vigencia de la dirección. Por favor intente nuevamente o contacte con el Administrador.";
	                
	                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			}
	
			DB::commit();
		
			$mensaje = "Dirección actualizada con éxito.";
			
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(Exception $e){
			DB::rollback();
			$mensaje = "Hubo un error al momento de actualizar la Dirección. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function gestionarPrestaciones(){
		$icono = Funcion::iconos(104);
		$nombre_ventana = Funcion::nombre_menu(104);
		$estados_programa = EstadoProgramas::where("est_prog_act", 1)->where("est_prog_fin", 1)->orderBy('est_prog_ord', 'asc')->get();

		return view('caso.gestionar_prestaciones',
			[
				'icono' => $icono,
				'nombre_ventana' => $nombre_ventana,
				'estados_programa' => $estados_programa
			]
		);
	}

		// INICIO CZ SPRINT 56
		public function verEstadoDerivacion(Request $request){

			if (!isset($request->id) || $request->id == ""){
				$mensaje = "Error al momento de buscar el ID de la derivación. Por favor intente nuevamente.";
	
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
	
			$amProgramas = AmProgramas::find($request->id);
	
			if ($amProgramas){
	
				$estadoProgramaBit = EstadoProgramasBit::orderBy("est_prog_bit_fec","DESC")->leftjoin('ai_estados_programas', 'ai_estados_programas.est_prog_id', '=', 'AI_ESTADOS_PROGRAMAS_BIT.est_prog_id')->where("am_prog_id", "=", $request->id)->get();
				return response()->json(array('estado' => '1', 'respuesta' => $estadoProgramaBit), 200);
			}
	
			$GrupFamProgramas = GrupFamProgramas::find($request->id);
	
			if ($GrupFamProgramas){
	
				$estadoProgramaBit = EstadoGfamProgramasBit::orderBy("est_prog_bit_fec","DESC")->leftjoin('ai_estados_programas', 'ai_estados_programas.est_prog_id', '=', 'ai_estados_gfam_programas_bit.est_prog_id')->where("grup_fam_prog_id", "=", $request->id)->get();
				//$estadoProgramaBit = BD::Select("select * from AI_ESTADOS_PROGRAMAS_BIT where AM_PROG_ID = {$request->id} order by est_prog_bit_fec DESC");
				return response()->json(array('estado' => '1', 'respuesta' => $estadoProgramaBit), 200);
			}
		}
		// FIN CZ SPRINT 56
	
	public function cambiarEstadoDerivacion(Request $request){
		try{
			DB::beginTransaction();

			if (!isset($request->id) || $request->id == ""){
				$mensaje = "Error al momento de buscar el ID de la derivación. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->estado) || $request->estado == ""){
				$mensaje = "Error al momento de buscar el ID del nuevo estado de la derivación. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($request->comentario) || $request->comentario == ""){
				$mensaje = "Error al momento de buscar el comentario del nuevo estado de la derivación. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}


			// primer universo "AmProgramas"

			$amProgramas = AmProgramas::find($request->id);

			if ($amProgramas){

				$estadoProgramasBit = new EstadoProgramasBit();
				$estadoProgramasBit->am_prog_id = $request->id;
				$estadoProgramasBit->est_prog_id = $request->estado;
				$estadoProgramasBit->est_prog_bit_des = $request->comentario;
				
				$resultado 	= $estadoProgramasBit->save();
				if (!$resultado){
					$mensaje = "Hubo un error al momento de guardar el cambio de estado de la derivación. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				
				}

				$amProgramas->est_prog_id = $request->estado;
				$resultado = $amProgramas->save();

				if (!$resultado){
					$mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor intente nuevamente.";


				}

			}

			// segundo universo "GrupFamProgramas"
 
			$GrupFamProgramas = GrupFamProgramas::find($request->id);

			if ($GrupFamProgramas){

				$estadoProgramasBit = new EstadoGfamProgramasBit();
				$estadoProgramasBit->grup_fam_prog_id = $request->id;
				$estadoProgramasBit->est_prog_id = $request->estado;
				$estadoProgramasBit->est_prog_bit_des = $request->comentario;
				
				$resultado 	= $estadoProgramasBit->save();
				if (!$resultado){
					$mensaje = "Hubo un error al momento de guardar el cambio de estado de la derivación. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				
				}

				$GrupFamProgramas->est_prog_id = $request->estado;
				$resultado = $GrupFamProgramas->save();

				if (!$resultado){
					$mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor intente nuevamente.";


				}

			}

			/*$estadoProgramasBit = new EstadoProgramasBit();
			$estadoProgramasBit->am_prog_id = $request->id;
			$estadoProgramasBit->est_prog_id = $request->estado;
			$estadoProgramasBit->est_prog_bit_des = $request->comentario;
			
			$resultado 	= $estadoProgramasBit->save();
			if (!$resultado){
				$mensaje = "Hubo un error al momento de guardar el cambio de estado de la derivación. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			
			}
			
			$amProgramas = AmProgramas::find($request->id);
			$amProgramas->est_prog_id = $request->estado;
			$resultado = $amProgramas->save();

			if (!$resultado){
				$mensaje = "Hubo un error al momento de actualizar el estado de la derivación. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

			}*/

			DB::commit();

			$mensaje = "Estado de derivación actualizado exitosamente.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			$mensaje = "Error al momento de actualizar el estado de la derivación. Por favor intente nuevamente.";

			if (!is_null($e->getMessage()) && $e->getMessage() != "") $mensaje = $e->getMessage();

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		
		}
	}

	public function listarDerivacionesAsignadas(){
		$comuna = explode(',',session()->all()['com_cod']);		
		$usuario = session()->all()['id_usuario'];

		$asignados =  AsignadosSectorialista::query()->whereIn('com_cod', $comuna)->where('id_responsable','=',$usuario)->where('est_prog_id', '<>', config('constantes.sin_gestionar'));
		if (count($asignados) == 0) $asignados = array();

        return Datatables::of($asignados)->make(true);    
	}

	public function finalizarTarea(Request $request){


		try{

			DB::beginTransaction();

			$result = DB::insert("insert into AI_OBJ_TAR_BIT_PAF (tar_id, est_tar_id) values (".$request->tar_id.",".$request->est_id.")");

				if (!$result){
					$mensaje = "Hubo un error al momento de guardar el cambio de estado de la tarea. Por favor intente nuevamente.";

					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				
				}

			$Tarea_Objetivo = TareaObjetivoPaf::find($request->tar_id);
			$Tarea_Objetivo->est_tar_id = $request->est_id;
			$resultado = $Tarea_Objetivo->save();
			
			DB::commit();

		return response()->json(array('estado' => '1', 'respuesta' => $result), 200);

		}catch (\Exception $e){

			DB::rollback();

			$mensaje = "Error al momento de ingresar el registro de sesión, favor intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}

	public function selEstadoTarea(Request $request){
	    $caso_id = $request->caso_id;
	    $estado = $request->estado;
	    $idObjetivo = $request->idObjetivo;
	    $idTarea = $request->idTarea;
	    $sql = "UPDATE ai_obj_tarea_paf set est_tar_id = ".$estado." where tar_id = ".$idTarea." and obj_id = ".$idObjetivo;
	    $sql = DB::update($sql);
	    return $sql;
	}

    //DC Inicio
	public function listarObjetivosEjecucionPaf(Request $request){
		$caso_id = $request->caso_id;
		//dd($request->fec_ini);
		$sql_filtro_fecha_ini = "";
		$sql_filtro_fecha_ter = "";
		$sql_filtro_fecha_ini_ter = "";
		$i=0;	
		$sql_filtro_estado = "(b.est_tar_id IN (1,2,3,5) OR b.est_tar_id IS NULL) and ";
		//($sql_filtro_estado);
		$sql = "select rownum as registro,
				a.obj_nom obj_nom,
			a.obj_id obj_id,
			b.tar_id,
			b.tar_descripcion tar_descripcion,
			b.tar_plazo plazo,
			b.tar_gestor_id gestor,
			b.tar_grupfa_id familiar,
			b.tar_observacion observacion,
			b.tar_fecha_seg tar_fecha_seg,
			b.tar_comentario_seg tar_comentario_seg,
			c.est_tar_nom estado,
			c.est_tar_id,
			d.fecha as est_act_fecha
			from 
			ai_objetivo_paf a
		    join ai_obj_tarea_paf b on (a.obj_id = b.obj_id)
			left join ai_obj_tar_estado_paf c on (b.est_tar_id = c.est_tar_id)
			left join ai_obj_tar_bit_paf d on (c.est_tar_id = d.est_tar_id and b.tar_id = d.tar_id)
			where ".$sql_filtro_fecha_ini_ter." ".$sql_filtro_fecha_ter." ".$sql_filtro_fecha_ini." ".$sql_filtro_estado." a.cas_id=".$caso_id." order by obj_id asc, tar_id asc";

			// dd($sql);

		$sql = DB::select($sql);
		//dd($sql);
		if($sql!=[]){
			$nom_base = $sql[0]->obj_nom;
		}else{
			$nom_base = null;
		}
		$cont= 1 ;

		// }else{ 
		// 	if (!is_null($v1->familiar) && $v1->familiar != ""){
		// 		$responsable = DB::select("SELECT * FROM ai_grupo_familiar WHERE gru_fam_id = ".$v1->familiar);
		// 		 if (count($responsable) > 0) $responsable = $responsable[0]->gru_fam_nom." ".$responsable[0]->gru_fam_ape_pat." ".$responsable[0]->gru_fam_ape_mat;

		foreach ($sql AS $c1 => $v1){
			// $responsable = "Sin información";

			$responsable = "";
			if (!is_null($v1->gestor) && $v1->gestor != ""){
				 $responsable = DB::select("SELECT * FROM ai_usuario WHERE id = ".$v1->gestor);
				 if(count($responsable) > 0) {

				 		$responsable = "- ".$responsable[0]->nombres." ".$responsable[0]->apellido_paterno." ".$responsable[0]->apellido_materno;
				 
				 }
			}

			$grupFamGesResp = TareaObjetivoPaf::grupFamGesResp($v1->tar_id);

			if($grupFamGesResp){

				foreach ($grupFamGesResp as $v) {

					$result = DB::select("SELECT * FROM ai_grupo_familiar WHERE gru_fam_id = ".$v);

					if(count($result) > 0){

						$responsable = $responsable." - ".$result[0]->gru_fam_nom." ".$result[0]->gru_fam_ape_pat." ".$result[0]->gru_fam_ape_mat;
					
					}
				}

			}

			$sql[$c1]->responsable = $responsable;

			$fecha_estado = DB::select("SELECT to_char(fecha,'dd-mm-YYYY') as fecha, fecha as fecha_filtro FROM AI_OBJ_TAR_BIT_PAF WHERE tar_id = '".$v1->tar_id."' and est_tar_id='".$v1->est_tar_id."'" );

			if($fecha_estado){

				$sql[$c1]->fecha_estado = $fecha_estado[0]->fecha;

			} else {

				$sql[$c1]->fecha_estado = "Sin información";

			}

			$responsable = "";

			if($nom_base!=$v1->obj_nom){
				
				$cont = $cont + 1;

			 	$sql[$c1]->num_reg = $cont;

			 	$nom_base=$v1->obj_nom;

			 }else {

			 	 	$sql[$c1]->num_reg = $cont;	
			 }

			
			 // dd($sql);

		}

		return Datatables::of($sql)
            ->make(true);

	}


	/**
	 * Método que muestra vista para filtrar inteervenciones
	 */
	public function filtrarIntervenciones(){

		$icono = Funcion::iconos(182);

		$comuna = session()->all()['com_id'];

		$estado_caso = DB::select("SELECT est_cas_id, est_cas_nom FROM ai_estado_caso");

		$estado_tarea = DB::select("SELECT est_tar_id, est_tar_nom FROM ai_obj_tar_estado_paf");

		$comunas = DB::select("SELECT com_id, com_nom FROM ai_comuna ORDER BY com_nom asc");
		
		return view('administrador_central.intervenciones',
			[
				'icono' => $icono,
				'comunas' => $comunas,
				'estado_caso' => $estado_caso,
				'estado_tarea' => $estado_tarea
			]);
	}

	public static function ExcelIntervenciones(Request $request){


		$start_date = (!empty($request->int_start_date)) ? ($request->int_start_date) : ('');
        $end_date   = (!empty($request->int_end_date)) ? ($request->int_end_date) : ('');
        $comunas   = (!empty($request->comunas)) ? ($request->comunas) : ('');
        $estado_caso  = (!empty($request->estado_caso)) ? ($request->estado_caso) : ('');
        $estado_tarea  = (!empty($request->estado_tarea)) ? ($request->estado_tarea) : ('');

        

        $sql = "SELECT p.per_run, c.cas_id, ec.est_cas_nom, pi.per_ind, u.nombres, u.apellido_paterno, op.obj_nom, tp.tar_descripcion, te.est_tar_nom, st.fecha,st.comentario, com.com_nom
							FROM ai_caso c
							 LEFT JOIN ai_caso_persona_indice pi on c.cas_id = pi.cas_id
							 LEFT JOIN ai_persona p on pi.per_id = p.per_id
							 LEFT JOIN ai_estado_caso ec on c.est_cas_id = ec.est_cas_id
							 LEFT JOIN ai_persona_usuario pu on c.cas_id = pu.cas_id and p.per_run = pu.run
							 LEFT JOIN ai_usuario u on pu.usu_id = u.id
							 LEFT JOIN ai_objetivo_paf op on op.cas_id = c.cas_id
							 LEFT JOIN ai_obj_tarea_paf tp on op.obj_id = tp.obj_id
							 LEFT JOIN ai_obj_tar_estado_paf te on tp.est_tar_id = te.est_tar_id
							 LEFT JOIN ai_sesion_tarea st on tp.tar_id = st.tar_id /*NUMERICO*/
							 LEFT JOIN ai_caso_comuna cc ON c.cas_id = cc.cas_id
							 LEFT JOIN ai_comuna com ON cc.com_id = com.com_id

							WHERE pi.per_ind = 1 ";


		if ((session()->all()["perfil"] == config('constantes.perfil_coordinador')) || (session()->all()['perfil'] == config('constantes.perfil_coordinador_regional'))){

			 $sql.=" and cc.com_id =  " . Session::get('com_id')."";
			 
		 }elseif ((session()->all()["perfil"] == config('constantes.perfil_administrador_central'))) {
				if(!empty($comunas)){

         	 		$sql.=" and cc.com_id IN(".$comunas.")";
        		}
		 }


	 	




		if(!empty($estado_caso)){

         	$sql.=" and c.est_cas_id =  " . $estado_caso."";
        }

        if(!empty($estado_tarea)){

         	$sql.=" and tp.est_tar_id =  " . $estado_tarea."";
        }

        if($start_date && $end_date){

        	 $start_date = Carbon::createFromFormat( 'd/m/Y', $start_date);
        	 $end_date = Carbon::createFromFormat( 'd/m/Y', $end_date);

            $sql.=" and st.fecha between '" . $start_date . "' and '" . $end_date . "'";


        }

		
		$listadoIntervenciones = DB::select($sql);

		foreach ($listadoIntervenciones AS $c1 => $v1){
				$dv = Rut::set($v1->per_run)->calculateVerificationNumber(); 
				$rut = Rut::parse($v1->per_run.$dv)->format();
				$listadoIntervenciones[$c1]->rut_completo = $rut;

			}

		return $listadoIntervenciones;
    }

    public function programaSeguimiento(Request $request){

    	
    return ProgramaSeguimiento::Select('pro_seg_cod_proy','pro_seg_nom')->where('pro_seg_cod','=',$request->id)->get();

    }

    public function cargarFormularioSeguimientoCasosDesestimados(Request $request){
    	try{
    		$caso_id = $request->caso_id;
    		$estado_caso = $request->est_cas_id;

    		if (is_null($caso_id) || $caso_id == ""){
    			$mensaje = "No se encuentra N° del caso. Por favor verifique e intente nuevamente.";

    			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
    		}

    		if (is_null($estado_caso) || $estado_caso == ""){
    			$mensaje = "No se encuentra estado actual del caso. Por favor verifique e intente nuevamente.";

    			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
    		}


    		$estado_seguimiento_caso = DB::select("SELECT *
									FROM AI_ESTADO_SEG_CASO_DESES e
						   	        LEFT JOIN AI_ESTADO_SEGUIMIENTO_CASO c ON e.est_cas_seg_cod = c.est_cas_seg_cod
						   	        LEFT JOIN AI_ESTADO_OBJETIVO_SEGUIMIENTO f ON c.est_cas_id = f.est_cas_id
					                WHERE c.est_cas_id =".$estado_caso);


    		$modalidad_contacto = DB::select("SELECT m_contacto_id, m_contacto_nombre, m_contacto_codigo FROM ai_modalidad_contacto");

    		//$programa_seguimiento = ProgramaSeguimiento::all();
    		// return ProgramaSeguimiento::Select('pro_seg_cod_proy','pro_seg_nom')->where('pro_seg_cod','=',$request->id)->get();

    		$respuesta = new \stdClass;
    		$respuesta->estado_seguimiento_caso = $estado_seguimiento_caso;
    		$respuesta->modalidad_contacto = $modalidad_contacto;
    		//$respuesta->programa_seguimiento = $programa_seguimiento;

    		return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
    	}catch(Exception $e){
    		return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);

    	}
    }

    public function listarDetalleSeguimientoCasosDesestimados(Request $request){
    	$caso_id = $request->caso_id;
    	$resultado = array();

    	if (!is_null($caso_id) && $caso_id != ""){
	    	$sql = "SELECT os.objetivo_nombre, bes.fecha, mc.m_contacto_nombre, escd.est_cas_seg_nombre, tps.tip_pro_seg_nom, ps.pro_seg_nom, bes.comentario FROM ai_seguimiento_caso_desest scd 
			LEFT JOIN ai_objetivo_seguimiento os ON scd.objetivo_codigo = os.objetivo_codigo
			LEFT JOIN ai_tipo_programa_seguimiento tps ON scd.tip_pro_seg_cod = tps.tip_pro_seg_cod 
			LEFT JOIN ai_programa_seguimiento ps ON scd.prog_seg_cod_proy = ps.pro_seg_cod_proy 
			LEFT JOIN ai_bitacora_estado_segu bes ON scd.seg_cas_des_id = bes.seg_cas_des_id
			LEFT JOIN ai_modalidad_contacto mc ON bes.m_contacto_codigo = mc.m_contacto_codigo  
			LEFT JOIN ai_estado_seg_caso_deses escd ON bes.est_cas_seg_cod = escd.est_cas_seg_cod WHERE scd.caso_id = ".$caso_id; 

			$resultado = DB::select($sql);

		}

    	return Datatables::of($resultado)->make(true);
    }


    public function pausarReiniciarCaso(Request $request){
    	try {
    		if (!isset($request->cas_id) || $request->cas_id == ""){
    			$mensaje = "No se encuentra ID de Caso. Por favor verifique e intente nuevamente.";

    			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
    		}

    		if (!isset($request->comentario) || $request->comentario == ""){
    			$mensaje = "No se encuentra comentario para su ingreso. Por favor verifique e intente nuevamente.";

    			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
    		}

    		if (!isset($request->estado) || $request->estado == ""){
    			$mensaje = "No se encuentra parámetro de cambio de estado Caso. Por favor verifique e intente nuevamente.";

    			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
    		}

			DB::beginTransaction();

			if ($request->estado == 1){
				$cas_est_pau = 0;

			}else if ($request->estado == 0){
			 	$cas_est_pau=1;

			}

			$caso = Caso::find($request->cas_id);
			$caso->cas_est_pau = $cas_est_pau;

			$caso_update = $caso->update();
			if (!$caso_update){
				DB::rollback();
				$mensaje = "Error al momento de cambiar el estado de Pausa del Caso. Por verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			$insert_pausa = DB::insert("INSERT INTO ai_caso_bit_pau
						(cas_id,
						 usu_id,
						 estado,
						 comentario,
						 fec_ing)
 						VALUES('".$request->cas_id."','".session('id_usuario')."','".$cas_est_pau."','".$request->comentario."','".Carbon::now()."')");

			
			if (!$insert_pausa){
				DB::rollback();
				$mensaje = "Error al momento de cambiar el estado de Pausa del Caso. Por verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			DB::commit();
			
			$mensaje = "Se ha cambiado correctamente el estado de Pausa del Caso.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de cambiar el estado de Pausa del Caso. Por favor verificar e intentar nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	/**
     * Método que registra las preguntas de la sesiones de devolucion
     */
	public function guardarSesDevPreguntas(request $request){

		try{

			$caso_id = $request->cas_id;
			$tipo = $request->tipo;
			$valor = $request->valor;

			$sesion_devolucion = SesionDevolucion::where('cas_id','=',$caso_id)->first();

						
			if(count($sesion_devolucion) == 0){
				
				$sesion_devolucion = new SesionDevolucion();
				$sesion_devolucion->ses_dev_id = DB::table('dual')->select('SEQ_SES_DEV_SES_DEV_ID.nextval')->pluck('nextval')[0];
				$sesion_devolucion->cas_id	= $request->cas_id;
				$sesion_devolucion->usu_id	= session()->all()['id_usuario'];
				
			}

			
			switch ($tipo){
				case 'sesion_fecha':
					if($request->valor != ""){
						$ses_fec = Carbon::createFromFormat( 'd/m/Y', $request->valor);
					}else{
						$ses_fec = $request->valor;
					}
					$sesion_devolucion->ses_dev_fec = $ses_fec;
					break;
				case 'sesion_pregunta_1': 
					$sesion_devolucion->ses_dev_pre_1 = $valor;
					break;
				case 'sesion_pregunta_2': 
					$sesion_devolucion->ses_dev_pre_2 = $valor;
					break;
				case 'sesion_pregunta_3': 
					$sesion_devolucion->ses_dev_pre_3 = $valor;
					break;
				case 'sesion_pregunta_4': 
					$sesion_devolucion->ses_dev_pre_4 = $valor;
					break;
				case 'sesion_pregunta_5': 
					$sesion_devolucion->ses_dev_pre_5 = $valor;
					break;
			}

			$respuesta = $sesion_devolucion->save();
			
			$mensaje = "ok";
			return response()->json(array('estado' => '1', 'respuesta' => $mensaje), 200);

		}catch(\Exception $e){
			$mensaje = "Error: ".$e;
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}

	}


    /**
     * Método que registra las sesiones de devolucion
     */
    public function guardarSesionDevolucion(Request $request){

		try{

			DB::beginTransaction();
			

			$ses_dev_fec = Carbon::createFromFormat( 'd/m/Y', $request->ses_dev_fec)->now();
			// $ses_dev_fec = new \DateTime($request->ses_dev_fec);
			
			$sesDev = SesionDevolucion::where('cas_id','=',$request->cas_id)->first();

			if(count($sesDev) == 0){
				$sesDev 				= new SesionDevolucion();
			}
			
			$sesDev->ses_dev_id		= DB::table('dual')->select('SEQ_SES_DEV_SES_DEV_ID.nextval')->pluck('nextval')[0];
			$sesDev->ses_dev_fec 	= Carbon::createFromFormat('d/m/Y', $ses_dev_fec->format('d/m/Y'));
			//$sesDev->ses_dev_com	= $request->ses_dev_com;
			$sesDev->cas_id			= $request->cas_id;
			$sesDev->usu_id 		= session()->all()['id_usuario'];
			$sesDev->ses_dev_pre_1  = $request->ses_dev_pre_1;
			$sesDev->ses_dev_pre_2  = $request->ses_dev_pre_2;
			$sesDev->ses_dev_pre_3  = $request->ses_dev_pre_3;
			$sesDev->ses_dev_pre_4  = $request->ses_dev_pre_4;
			$sesDev->ses_dev_pre_5  = $request->ses_dev_pre_5;
			
			$sesDev->save();

			DB::commit();

			return response()->json(array('estado' => '1', 'mensaje' => 'Registrado exitósamente'), 200);

		}catch(\Exception $e){

			DB::rollback();

			//return response()->json(array('estado' => '0', 'mensaje' => 'Error al registrar: '.$e), 400);
			dd($e);

		}

	}


    /**
     * Método que lista las sesiones de devolucion
     */
    public function listarSesionDevolucion(Request $request){

		try{

			$sesDev = SesionDevolucion::select('SES_DEV_FEC','SES_DEV_PRE_1','SES_DEV_PRE_2','SES_DEV_PRE_3','SES_DEV_PRE_4','SES_DEV_PRE_5')->where('cas_id', '=',$request->cas_id)->first();
			$estado = count($sesDev);
			if(($estado > 0) && ($sesDev->ses_dev_fec != "")){
				$sesDev->ses_dev_fec = Carbon::createFromFormat('Y-m-d H:i:s',$sesDev->ses_dev_fec)->format('d/m/Y');
			}
			
			$data = json_encode($sesDev);
			return response()->json(array('estado' => $estado, 'data' => $data), 200);


			// $get_lis_ses_dev	= DB::table('AI_SES_DEV')
			// 	->select(DB::raw('TO_CHAR(SES_DEV_FEC, \'DD/MM/YYYY\') as SES_DEV_FEC'), 'SES_DEV_COM')
			// 	->where('cas_id', $request->cas_id)
			// 	->orderBy('ses_dev_fec', 'desc')
			// 	->get();
			
			// return Datatables::of($get_lis_ses_dev)->make(true);

		}catch(\Exception $e){

			//return response()->json(array('estado' => '0', 'mensaje' => 'Error al listar: '.$e), 400);
			dd($e);

		}

	}

	public function guardarDesestimacionNomina(Request $request){
		try{
			$run = $request->run;
			$periodo = $request->periodo;
			$descartar = $request->descartar;
			$comentario = $request->comentario;

			$predictivo = Predictivo::where('run', '=', $run)->first();

			if (!isset($run) || is_null($run) || $run == ""){
				$mensaje = "No se encuentra el RUN del NNA a registrar. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($periodo) || is_null($periodo) || $periodo == ""){
				$mensaje = "No se encuentra el periodo del NNA a registrar. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (!isset($descartar) || is_null($descartar) || $descartar == ""){
				$mensaje = "No se encuentra la acción a registrar del NNA. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			if (strlen(trim($comentario)) < 3 || !isset($comentario) || is_null($comentario) || $comentario == ""){
				$mensaje = "Comentario a registrar no válido. Por favor verifique e intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
			
			DB::beginTransaction();

			$registrar = new DescartePredictivo();
			$registrar->run = $run;
			$registrar->des_pre_per = $periodo;
			$registrar->des_pre_act = $descartar;
			$registrar->des_pre_com = $comentario;
			$registrar->des_com_cod = $predictivo->dir_com_1;

			$resultado = $registrar->save();
			if (!$resultado){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la información solicitada. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$actualizar = Predictivo::find($run);
			$actualizar->des_pre_act = $descartar;

			$resultado = $actualizar->save();
			if (!$resultado){
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar la información solicitada. Por favor intente nuevamente.";

				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();

			$mensaje = "Información registrada con éxito.";
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
			Log::error('Error al descartar NNA en nómina: '.$e->getMessage());

			$mensaje = $e->getMessage();
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function documentosGestionCasos(){

		//if((session()->all()['perfil'] == config('constantes.perfil_terapeuta')) || (session()->all()['perfil'] == config('constantes.perfil_sectorialista'))){
		//	return redirect()->back();
		//}else{
			return view('caso.documentos_apoyo');
		//}
	}

	public function registrarTareasComprometidas(Request $request){

		try{

			if (!isset($request->cas_id) || $request->cas_id == ""){
                $mensaje = "No se encuentra ID del Caso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            if (!isset($request->cas_can_tar) || $request->cas_can_tar == ""){
                $mensaje = "No se encuentra la cantidad de tareas. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            DB::beginTransaction();                        

			$caso = Caso::find($request->cas_id);
			$caso->cas_can_tar = $request->cas_can_tar;
			
            $respuesta = $caso->save();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción guardada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
            //FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
	}

	public function vincularObjetivo(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $alertasXnna = Helper::vincularObjetivo($request->idAlerta,$request->idObj, $request->cas_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	}
	
	public function verVinculacion(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();

	    $alertasXnna = Helper::verVinculacion($request->alerta, $request->obj_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	}
	
	public function porcentajeLogro(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::porcentajeLogro($request->cas_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	
	public function getEnAtencion(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::getEnAtencion($request->cas_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	
	public function getAlertaEstados(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    if($request->estado_id == 1){ //Por validar
	        $respuesta =  DB::select("select
            est_ale_id,
            est_ale_nom
            from ai_estado_alerta
            where est_ale_ord in (2, 3)
            order by est_ale_ord asc");
	    }else if($request->estado_id == 5){ //En atencion
	        $respuesta =  DB::select("select
            est_ale_id,
            est_ale_nom
            from ai_estado_alerta
            where est_ale_ord in (6, 7)
            order by est_ale_ord asc");
	    }
	    
	    
	    echo json_encode($respuesta); exit;
	}
	
	public function updMitigar(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::updMitigar($request->ale_estado, $request->ale_id);
	    DB::commit();
	    if($alertasXnna == 1){
	        Helper::insHistorialEstadoAlerta($request->ale_id, $request->ale_estado, $request->nom_estado);
	    }
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	
	//INICIO DC
	public function updNoMitigar(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::updNoMitigar($request->ale_estado, $request->ale_id, $request->motivo);
	    DB::commit();
	    if($alertasXnna == 1){
	        Helper::insHistorialEstadoAlerta($request->ale_id, $request->ale_estado, $request->nom_estado);
	    }
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	//FIN DC
	
	public function listarAlertaDetectada(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	   
	    $alertasXnna = Helper::listarAlertaDetectada($request->cas_id, $request->obj_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	
	}

	public function listarAlertaPriorizada(Request $request){

		$data   = new \stdClass();
		$data->data = array();

		$caso = Caso::where('cas_id',$request->cas_id)->get();
		//INICIO CZ SPRINT 63 Casos ingresados a ONL
		$alertasXnna = Helper::getAlertaNNAxTipoEva($request->cas_id,$caso[0]->est_cas_id, $request->run);
		//INICIO CZ SPRINT 63 Casos ingresados a ONL	
		$data->data = $alertasXnna;
	
		echo json_encode($data); exit;

	}

	//INICIO DC
	public function listarDimensionVinculada(Request $request){
	    
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::listarDimensionVinculada($request->cas_id, $request->alerta_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	
	public function alertaAddObjetivo(Request $request){
	    
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $alertasXnna = Helper::alertaAddObjetivo($request->cas_id);
	    
	    $data->data = $alertasXnna;
	    
	    echo json_encode($data); exit;
	    
	}
	//FIN DC

	public function seleccionarAlertasporTipo(Request $request){

		try{

			if (!isset($request->cas_id) || $request->cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente.";
	
				return array("status" => 0, "mensaje" => $mensaje);
			}

			$cas_id = $request->cas_id;
			$ale_tip_id = $request->ale_tip_id;
			
			DB::beginTransaction();
			$at_asoc = new AlertaPriorizadaporTipo();
			$at_asoc->cas_id = $cas_id;
			$at_asoc->ale_tip_id = $ale_tip_id;
			$respuesta = $at_asoc->save();
			if (!$respuesta){

				$mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente o contacte con el Administrador.";
	
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$alerta = AlertaManual::select('ai_alerta_manual.ale_man_id')
									->leftjoin('ai_caso_alerta_manual', 'ai_caso_alerta_manual.ale_man_id', '=', 'ai_alerta_manual.ale_man_id')
									->leftjoin('ai_alerta_manual_tipo', 'ai_alerta_manual_tipo.ale_man_id', '=', 'ai_alerta_manual.ale_man_id')
									->where('ai_caso_alerta_manual.cas_id', $cas_id)
									->where('ai_alerta_manual_tipo.ale_tip_id', $ale_tip_id)->get();

			foreach($alerta AS $am_id){
				$at_asoc_caso = new AlertaPriorizadaCaso();
				$at_asoc_caso->prio_at_id = $at_asoc->prio_at_id;
				$at_asoc_caso->ale_man_id = $am_id->ale_man_id;
				$respuesta = $at_asoc_caso->save();

				if (!$respuesta){

					$mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente o contacte con el Administrador.";
		
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
			}	

			DB::commit();
			
			$mensaje = "Alerta registrada con Exito.";
		
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'id' => $ale_tip_id), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente o contacte con el Administrador.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}


	public function listadoHistorialPausaCaso(Request $request){
		$respuesta = "";

		if (isset($request->cas_id) && $request->cas_id != ""){
			$respuesta =  DB::select(" select u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre,a.cas_id,to_char(fec_ing,'dd-mm-yyyy HH24:MI:SS')fec_ing, usu_id, estado, comentario 
				 from ai_caso_bit_pau  a left join ai_usuario u on a.usu_id=u.id 
				 where a.cas_id='".$request->cas_id."'");
		}
        
        $data   = new \stdClass();
        $data->data = $respuesta;

        echo json_encode($data); exit;
	}

	public function listarAlertasDiagnostico(){
		$alertas = AlertaTipo::get();

		$data   = new \stdClass();
		$data->data = $alertas;			
	
		echo json_encode($data); exit;
	}

	public function getDataNnaAlerta(Request $request){
		
		if (!isset($request->per_id) || $request->per_id == ""){
			$mensaje = "No se encuentra ID de Persona. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		$per_id = $request->per_id;
		$run = $request->run;
		if(count($run) > 10){
			$nna_data = AlertaManual::select('ale_man_nna_fec_nac as fec_na','ale_man_nna_sexo as sexo')
										->where('ale_man_run',$run)->first();
		}else{
			$nna_data = GrupoFamiliar::select('gru_fam_nac as fec_na','gru_fam_sex as sexo')
										->where('gru_fam_run',$run)->first();
										
		}
		$direccion = Direccion::where('per_id',$per_id)->first();
		$usuario = Usuarios::leftJoin('ai_institucion int','ai_usuario.id_institucion',"=","int.id_ins")
					->leftJoin('ai_region reg','ai_usuario.id_region','=','reg.reg_id')
					->where('id',session()->all()['id_usuario'])->get();
		$region = Region::where('reg_nom',$request->reg)->first();
		return response()->json(
						array(
								'estado' => '1', 
								'usuario' => $usuario, 
								'nna_data' => $nna_data, 
								'direccion' => $direccion,
								'region' => $region
							), 200);
	}

	public function diagnosticoListarAlertasDetectadas(Request $request){
		if (!isset($request->cas_id) || $request->cas_id == ""){
			$mensaje = "No se encuentra ID del Caso. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		if (!isset($request->dim_id) || $request->dim_id == ""){
			$mensaje = "No se encuentra ID de la Dimension. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		$cas_id = $request->cas_id;
		$dim_id = $request->dim_id;
		$alertas = AmDimension::where("cas_id",$cas_id)->where("dim_enc_id",$dim_id)->get();
		$ale_man_id = "";
		
		if(count($alertas) > 0){
			$primer = true;
			foreach($alertas AS $alerta){
				if(!$primer) $ale_man_id .= ", ";
				$ale_man_id .= $alerta->ale_man_id;
				$primer = false;
			}
		}
		
		$am_dim = AlertaManual::listarAlertasDetectadas($cas_id,$ale_man_id);

		$data   = new \stdClass();
		$data->data = $am_dim;			
	
		echo json_encode($data); exit;

	}

	public function diagnosticoListarAlertasVinculadas(Request $request){
		if (!isset($request->cas_id) || $request->cas_id == ""){
			$mensaje = "No se encuentra ID del Caso. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		if (!isset($request->dim_id) || $request->dim_id == ""){
			$mensaje = "No se encuentra ID de la Dimension. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}

		$cas_id = $request->cas_id;
		$dim_id = $request->dim_id;
		$alertas = AmDimension::where("cas_id",$cas_id)->where("dim_enc_id",$dim_id)->get();
		$ale_man_id = "";
		
		if(count($alertas) > 0){
			$primer = true;
			foreach($alertas AS $alerta){
				if(!$primer) $ale_man_id .= ", ";
				$ale_man_id .= $alerta->ale_man_id;
				$primer = false;
			}
		}
		
		$am_dim = AlertaManual::listarAlertasVinculadas($cas_id,$ale_man_id,$dim_id);
		
		$data   = new \stdClass();
		$data->data = $am_dim;			
	
		echo json_encode($data); exit;

	}

	public function vincularAlertaDimension(Request $request){
		try{

			if (!isset($request->cas_id) || $request->cas_id == ""){
				$mensaje = "No se encuentra el ID del caso. Por favor verifique e intente nuevamente.";
	
				return array("status" => 0, "mensaje" => $mensaje);
			}

			if (!isset($request->ale_man_id) || $request->ale_man_id == ""){
				$mensaje = "No se encuentra el ID de la Alerta. Por favor verifique e intente nuevamente.";
	
				return array("status" => 0, "mensaje" => $mensaje);
			}	

			if (!isset($request->dim_id) || $request->dim_id == ""){
				$mensaje = "No se encuentra el ID de la Dimensión. Por favor verifique e intente nuevamente.";
	
				return array("status" => 0, "mensaje" => $mensaje);
			}

			$am_dim = new AmDimension();
			$am_dim->cas_id 	= $request->cas_id;
			$am_dim->ale_man_id = $request->ale_man_id;
			$am_dim->dim_enc_id = $request->dim_id;
			$respuesta = $am_dim->save();

			if (!$respuesta){
				DB::rollback();
				$mensaje = "Hubo un error al momento de vincular la información. Por favor intente nuevamente o contacte con el Administrador.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			DB::commit();
			
			$mensaje = "Alerta vinculada con Exito.";
		
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de vincular la información. Por favor intente nuevamente o contacte con el Administrador.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
		}
	}

	/******************      Documentacion Coordinador         ***************/
	
	public function viewDocumentacion(){

		try {			

			$tipo_doc = DB::select("SELECT doc_tip_id, doc_tip_nom FROM ai_tip_doc_co WHERE doc_tip_tip = 2");
			
			return view('documentacion.main',['tipo_doc'=>$tipo_doc]);

		} catch(\Exception $e) {
			
			Log::error('error: '.$e);
			// INCIO CZ SPRINT 66
			$mensaje = "Ocurrio un error en la obtencion del documento, intente nuevamente.";
			// FIN CZ SPRINT 66
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}

	public function cargarInformeAnexos(Request $request){
        $request->validate($this->reglas_doc,[]);

		try {

			if($request->tipo == 1){
				$input_name = "doc_prot";
			}else if($request->tipo == 6){
				$input_name = "doc_mat_doc";
			//INICIO DC
			}else if($request->tipo == 7){
			    $input_name = "doc_prot_sos";
			//FIN DC
			}else{
				$input_name = "doc_act_lis";
			}

            //VALIDACION DE EXTENSIÓN DE ARCHIVO
			//inicio ch
			if(!$request->file($input_name)){
				$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
			
				return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
			}
			$files = $request->file($input_name);
			$extension = $files->getClientOriginalExtension();
			if($extension != 'pdf' and $extension != 'doc' and $extension != 'docx'){
			    $mensaje = "ExtensiÃ³n de archivo no permitida. Por favor subir un documento con las siguientes extensiones: doc, docx o pdf.";			    
	           return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
			}//fin ch

	        //VALIDACION DE TAMAÑO DE ARCHIVO
	 		$validacion_size = Validator::make($request->all(), [$input_name => 'file|max:5120']);
	 		if ($validacion_size->fails()){
				$mensaje = "Error al subir documento, tamaño máximo permitido 5 MB. Por favor verificar e intentar nuevamente.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }
            
			DB::beginTransaction();

			$n_doc = DocumentCoord::all();
			$id = count($n_doc)+1;			
			$fecha = date('d-m-Y');
			
			$destinationPath = 'doc_coordinador';

			switch($request->tipo){
                case 1:                    
					if(!$request->file('doc_prot')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_prot');    
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Protocolos_de_Referencia_Contrarreferencia_".$id."_(".$fecha.").".$extension;
                break;
                case 2:
					if(!$request->file('doc_act_lis')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_act_lis');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Reuniones_Mensuales_Red_Comunal_".$id."_(".$fecha.").".$extension;
				break;
				case 3:
					if(!$request->file('doc_act_lis')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_act_lis');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Reuniones_bilaterales_realizadas_actores_".$id."_(".$fecha.").".$extension;
				break;
				case 4:
					if(!$request->file('doc_act_lis')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_act_lis');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Reuniones_equipo_coordinacion_".$id."_(".$fecha.").".$extension;
				break;
				case 5:
					if(!$request->file('doc_act_lis')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_act_lis');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Reuniones_equipo_analisis_".$id."_(".$fecha.").".$extension;
                break;
                case 6:
					if(!$request->file('doc_mat_doc')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_mat_doc');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Materiales_documentos_elaboracion_".$id."_(".$fecha.").".$extension;
                break;
                //INICIO DC
                case 7:
					if(!$request->file('doc_prot_sos')){
						$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
					
						return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
					}
                    $files = $request->file('doc_prot_sos');
                    $extension = $files->getClientOriginalExtension();
                    $filename = "Protocolos_sospecha_vulneracion_derechos_".$id."_(".$fecha.").".$extension;
                break;
                //FIN DC
			}  
			
            $doc = new DocumentCoord();
            $doc->doc_act_nom   = $filename;
			$doc->doc_tip_id 	= $request->tipo;
			$doc->usu_id 		= session()->all()['id_usuario'];
			$doc->com_id 		= session()->all()['com_id'];
            $respuesta = $doc->save();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			$upload_success = $files->move($destinationPath, $filename);
			
			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Documento guardado exitosamente.'),200);
		
		} catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
			// INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de cargar el documento. Por favor intente nuevamente.";
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}		
		
	}
	
	public function listarCoordinadorDocumentosProtocolo(Request $request){
		// if(session()->all()['perfil'] == config("constantes.perfil_coordinador")){
		// 	$com_id = session()->all()['com_id'];
		// }else{
		// 	$com_id = session()->all()['com_id'];
		// }

		$resultado = DocumentCoord::getListadoDocumentos(1,$request->comunas);
		//$resultado = DocumentCoord::where("usu_id",$usu_id)->where('doc_tip_id',1)->get();

		$data		= new \stdClass();
		$data->data = $resultado;
	
		echo json_encode($data); exit;
	}

	//INICIO DC
	public function listarCoordinadorDocumentosProtocolo2(Request $request){
	    
	    $resultado = DocumentCoord::getListadoDocumentos(7,$request->comunas);
	    
	    $data		= new \stdClass();
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	//FIN DC

	public function listarCoordinadorDocumentosActas(Request $request){
		// if(session()->all()['perfil'] == config("constantes.perfil_coordinador")){
		// 	$com_id = session()->all()['com_id'];
		// }else{
		// 	$com_id = session()->all()['com_id'];
		// }
		
		$resultado = DocumentCoord::getListadoDocumentos(2,$request->comunas);
		//$resultado = DocumentCoord::where("usu_id",$usu_id)->whereIn('doc_tip_id',[2,3,4,5])->get();

		$data		= new \stdClass();
		$data->data = $resultado;
	
		echo json_encode($data); exit;
	}

	public function listarCoordinadorDocumentosMateriales(Request $request){
		// if(session()->all()['perfil'] == config("constantes.perfil_coordinador")){
		// 	$com_id = session()->all()['com_id'];
		// }else{
		// 	$com_id = session()->all()['com_id'];
		// }

		$resultado = DocumentCoord::getListadoDocumentos(6,$request->comunas);
		//$resultado = DocumentCoord::where("usu_id",$usu_id)->where('doc_tip_id',6)->get();

		$data		= new \stdClass();
		$data->data = $resultado;
	
		echo json_encode($data); exit;
	}

	
	/******************      Documentacion Coordinador         ***************/

	public function dataCasosEgresados(){
		$comuna = explode(',', session()->all()['com_cod']);

		if (session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			//CZ SPRINT 74
			return Datatables::of(CasosGestionEgresado::query()
            		->whereIn('cod_com', $comuna)
					->where('es_cas_id', config('constantes.egreso_paf')))->make(true);

		}else if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
			//CZ SPRINT 74
			return Datatables::of(CasosGestionEgresado::query()
		            ->whereIn('cod_com', $comuna)
		            ->where('es_cas_id', config('constantes.egreso_paf'))
		            ->where(function ($query) {
		                $query->where('usuario_id', '=',session()->all()['id_usuario']);
		            }))
		            ->make(true);

		}else if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			//CZ SPRINT 74
			return Datatables::of(CasosGestionEgresado::query()
		            ->whereIn('cod_com', $comuna)
		            ->where('est_tera_id', config('constantes.gtf_egreso'))
		            ->where(function ($query) {
		                $query->where('ter_id', '=',session()->all()['id_usuario']);
		            }))
		            ->make(true);
		}
	}

	/**
	 * Muestra el formulario de Casos por Evaluar
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function vistaCasosEgresados(){
		$comuna = explode(',',session()->all()['com_cod']);
		$cantidad_casos = 0;

		if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
			//CZ SPRINT 74
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->where('est_cas_fin','=',1)->where('usuario_id', '=',session()->all()['id_usuario'])->groupBy('cas_id')->get();

			$cantidad_casos = count($cantidad_casos);
		}
		
		//Inicio Andres F	
		if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			/*$cantidad_casos = NNAAlertaManualCaso::query()
		            ->whereIn('cod_com', $comuna)
		            ->where('est_tera_id', config('constantes.gtf_egreso'))
		            ->where(function ($query) {
		                $query->where('ter_id', '=',session()->all()['id_usuario']);*/

			//CZ SPRINT 74
						$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->where('est_tera_id', config('constantes.gtf_egreso'))->where('ter_id', '=',session()->all()['id_usuario'])->groupBy('cas_id')->get();
			

			//$cantidad_casos = NAAlertaManualCaso::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->where('est_tera_id', config('constantes.gtf_egreso'))->where('ter_id', '=',session()->all()['id_usuario'])->groupBy('cas_id')->get();	
			$cantidad_casos = count($cantidad_casos);	
		}
		
//CZ SPRINT 74
		if (session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))->whereIn('cod_com', $comuna)->where('est_cas_fin','=',1)->groupBy('cas_id')->get();

			$cantidad_casos = count($cantidad_casos);
		}
//CZ SPRINT 74
		$acciones = $this->perfil->acciones();
	 	foreach ($acciones as $c0 => $v0){
	 		if ($v0->ruta == "/casos/egresados"){
	 			$nombre_ventana = $v0->nombre;
	 			$icono = $v0->clase;
	 		
	 		}
	 	}
		
		return view('caso.egresados',
			[
				'nombre_ventana' 	=> $nombre_ventana,
				'acciones' 			=> $acciones,
				'cantidad_casos' 	=> $cantidad_casos,
				'icono' 			=> $icono

			]
		);
	}
		//Fin Andres F

	public function cambioVigenciaDireccion($id_dir, $run){
		try {
			if (!isset($id_dir) || $id_dir == ""){
				$mensaje = "No se encuentra el ID de la dirección. Por favor verifique e intente nuevamente.";

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
	        	$mensaje = "Hubo un error al momento validar el grabado de la dirección. Por favor verifique e intente nuevamente.";


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

	public function obtenerNNA(Request $request){
		$sql = "select * from ai_persona where per_run = {$request->run}";
		return DB::select($sql);
	}

	// INICO CZ SPRTIN 66
	public function revertir_estado(){
		$sql= DB::select("select * from AI_FUNCION where nombre = 'Revertir estado'");

	 	$icono = Funcion::iconos($sql[0]->id);
		 $acciones = $this->perfil->acciones();
		return view('administrador_central.revertir_estado',
			[
				// 'terapeutas' => $terapeutas,
				'acciones' => $acciones,
				// 'cantidad_casos' => $cantidad_casos,
				// 'desde_terapia' => $desde_terapia,
				'icono' => $icono

			]
		);
	}

	public function estadoCaso(Request $request){
		try{

			if($request->cas_id == null || $request->cas_id == ""){
				$mensaje = "Hubo un error al momento de obtener el listar los estados de casos. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			$sql= DB::select("select ai_estado_caso.* from ai_caso_estado_caso inner join ai_estado_caso on ai_caso_estado_caso.est_cas_id = ai_estado_caso.est_cas_id where cas_id = {$request->cas_id} order by est_cas_ord asc");
			return response()->json(array('estado' => '1','data' =>$sql), 200);	
		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de obtener el listado de casos. Por favor intente nuevamente.";
			return response()->json(array('mensaje' =>$mensaje), 200);
		}
	}
	public function estadoTerapia(Request $request){
		try{
			if($request->tera_id == null || $request->tera_id == ""){
				$mensaje = "Hubo un error al momento de obtener el listar los estados de casos. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
	
			$sql= DB::select("select ai_estado_terapia.* from ai_est_terapia_bitacora inner join ai_estado_terapia on ai_est_terapia_bitacora.est_tera_id = ai_estado_terapia.est_tera_id where tera_id =  {$request->tera_id} order by est_tera_ord asc");
			return response()->json(array('estado' => '1','data' =>$sql), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de obtener el listar los estados de casos. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' =>$mensaje), 200);
		}
	}

	public function revertir_estado_caso(Request $request){
		try {
			if($request->cas_id == null || $request->cas_id == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del caso, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			if($request->est_cas_id == null || $request->est_cas_id == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del caso, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			if($request->est_cas_id_actual == null || $request->est_cas_id_actual == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del caso, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			DB::beginTransaction();
			$caso = Caso::find($request->cas_id);
			//CZ SPRINT 73
			if($caso ->est_cas_id == 3 && $request->est_cas_id == 1){
				if($caso->fas_id == 1){
					$caso->fas_id = 0;
				}
				
			}
		//CZ SPRINT 73
			$caso->est_cas_id = $request->est_cas_id;
			$caso->save();

			//$bitacoraCaso = DB::table('ai_caso_estado_caso')->where('cas_id', $caso->cas_id)->where('est_cas_id',$request->est_cas_id_actual)->delete();
			DB::commit();
			$mensaje = "Cambio de estado realizado con exito!";
			return response()->json(array('estado' => '1','mensaje' =>$mensaje), 200);

		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error al momento de cambiar estado del caso, intente nuevamente.";
			return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
		}
	}
	public function revertir_estado_terapia(Request $request){
		try {
			if($request->id_tera == null || $request->id_tera == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del terapia, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			if($request->est_tera_id == null || $request->est_tera_id == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del terapia, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			if($request->est_tera_id_actual == null || $request->est_tera_id_actual == ""){
				$mensaje = "Ocurrio un error al momento de cambiar estado del terapia, intente nuevamente.";
				return response()->json(array('estado' => '0','mensaje' =>$mensaje), 200);
			}

			DB::beginTransaction();

			$terapia = Terapia::find($request->id_tera);
			$terapia->est_tera_id = $request->est_tera_id;
			$terapia->save();

			//$bitacoraTerapia= DB::table('ai_est_terapia_bitacora')->where('tera_id', $request->id_tera)->where('est_tera_id',$request->est_tera_id_actual)->delete();
			
			DB::commit();
			$mensaje = "Cambio de estado realizado con exito!";
			return response()->json(array('estado' => '1', 'mensaje' =>$mensaje), 200);
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error al momento de cambiar estado de la terapia, intente nuevamente.";
			return response()->json(array('estado' => '1', 'mensaje' =>$mensaje), 200);
		}
	}
	public function traspaso_nna(){
		$sql= DB::select("select * from AI_FUNCION where nombre = 'Traspaso de NNA'");

		$icono = Funcion::iconos($sql[0]->id);
		$acciones = $this->perfil->acciones();
		$perfil = Perfil::where('id','=',3)->orwhere('id','=',4)->get();
		return view('administrador_central.traspaso_nna',
			[
				// 'terapeutas' => $terapeutas,
				'acciones' => $acciones,
				// 'cantidad_casos' => $cantidad_casos,
				// 'desde_terapia' => $desde_terapia,
				'icono' => $icono, 
				'perfil' => $perfil

			]
		);
	}
	public function obtenerUsuario(Request $request){
		try{

			if($request->com_cod == null || $request->com_cod == "" ){
				$mensaje = "Hubo un error al momento de obtener el listado de usuarios solicitados. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}

			// CZ SPRINT 77
			$sql= DB::select("select *
			from ai_usuario 
			inner join ai_usuario_comuna 
			on ai_usuario.id = ai_usuario_comuna.usu_id
			inner join ai_comuna 
			on ai_usuario_comuna.com_id = ai_comuna.com_id
			where id_perfil = {$request->id_perfil}  and ai_comuna.com_cod = {$request->com_cod} and ai_usuario_comuna.vigencia = 1 and id in (select distinct usuario_id from VW_NNA_CASO where est_cas_fin <> 1)
			order by nombres asc");
			return response()->json(array('estado' => '1','data' =>$sql), 200);

		}catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
		
	}
	public function listarCaso(Request $request){

		try{
			if($request->id_perfil == null || $request->id_perfil == ""){
				$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
	
			if($request->usuario_id == null || $request->usuario_id ==  ""){
				$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			if($request->id_perfil == 3){
				// CZ SPRINT 76
				$sql= DB::select("select * from VW_NNA_CASO where usuario_id = {$request->usuario_id} and est_cas_fin <> 1 and cod_com = {$request->comuna} order by cas_id ");
				// CZ SPRINT 76
				return response()->json(array('estado' => '1', 'data' =>$sql), 200);
			}else if($request->id_perfil == 4 ){
				// CZ SPRINT 76
				$sql= DB::select("select * from VW_NNA_CASO where ter_id = {$request->usuario_id} and EST_TERA_FIN <> 1 and cod_com = {$request->comuna} est_cas_fin <> 1 order by cas_id");
				// CZ SPRINT 76
				return response()->json(array('estado' => '1','data' =>$sql), 200);
			}

			

		}catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
		
		
	}
	public function traspasar_nna(Request $request){

		try{
			if($request->tipo == null || $request->tipo == ""){
				$mensaje = "Hubo un error al momento de realizar el traspaso de nna. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			if($request->casos == null){
				$mensaje = "Hubo un error al momento de realizar el traspaso de nna. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			if($request->usu_id == null || $request->usu_id == ""){
				$mensaje = "Hubo un error al momento de realizar el traspaso de nna. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
	
			if($request->nombre_usuario == null || $request->nombre_usuario == null){
				$mensaje = "Hubo un error al momento de realizar el traspaso de nna. Por favor intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}

			if($request->tipo == 3){
				$traspasoGestor = $this->traspasoGestor($request);
				if($traspasoGestor == 1){
					$mensaje = "Cambio de estado realizado con exito!";
					return response()->json(array('estado' => '1','mensaje' =>$mensaje), 200);
				}else{
					$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' =>$mensaje), 200);
				}
				
			}else{
				$traspasoTerapetura = $this->traspasoTerapetura($request);
				if($traspasoTerapetura == 1){
					$mensaje = "Cambio de estado realizado con exito!";
					return response()->json(array('estado' => '1','mensaje' =>$mensaje), 200);
				}else{
					$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' =>$mensaje), 200);
				}
			}

		}catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}

	public function traspasoGestor( $request){
		try {
			DB::beginTransaction();
			foreach ($request->casos as $key => $value){
				$sql= DB::update("update ai_persona_usuario set usu_id = {$request->usu_id} where cas_id = $value");

				$caso = Caso::find($value);
				$caso->cas_des = 'Se asigna caso a gestor' . $request->nombre_usuario;
				$caso->save();

				$bitacora_caso= DB::update("update ai_caso_estado_caso set cas_est_cas_des = 'Se asigna caso a gestor {$request->nombre_usuario}'  where cas_id = $value and est_cas_id = 10");
			}
			DB::commit();
			return 1; 
		} catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
			return 0;
		}
	}
	public function traspasoTerapetura($request){
		try{

			DB::beginTransaction();
			foreach ($request->casos as $key => $value){
				$reasignar = DB::update("update AI_CASO_TERAPEUTA set ter_id='".$request->usu_id."' where cas_id=".$value);

				$reasignar = DB::update("update AI_TERAPIA set usu_id='".$request->usu_id."' where cas_id=".$value);

			}

			DB::commit();

			return 1;

		} catch (\Exception $e) {
			DB::rollback();
			return 0;
		}

	}
	// INICIO CZ SPRINT 72
	public function getEstadosDesestimados(Request $request){
			$resultado = array();
			$comuna = explode(',',session()->all()['com_cod']);
			
			if (session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
				$casos_desestimados = DB::select('select * from ai_estado_caso where est_cas_id in (select distinct es_cas_id from VW_CASOS_DESESTIMADOS where COD_COM in ('.$comuna[0].'))');
			}else if (session()->all()['perfil'] == config('constantes.perfil_gestor')){
				$casos_desestimados = DB::select('select * from ai_estado_caso where est_cas_id in (select distinct es_cas_id from VW_CASOS_DESESTIMADOS where COD_COM in ('.$comuna[0].') and usuario_id = ' . session()->all()['id_usuario'].')');
			}
			return 	$casos_desestimados;
	}
	// FIN CZ SPRINT 72
//CZ SPRINT 73
	public function resumenNNA(Request $request){
		$tablaNomina = true;
		$tablaCasoGestion = true;
		$tablaCasoDesestimados = true;
		$predictivo = Predictivo::find($request->run);
		$ai_persona_usuario = DB::select("select max(cas_id) as caso from ai_persona_usuario where run ={$request->run}");
		if($ai_persona_usuario[0]->caso != null){
			$datosPersona = DatosPersona::where("cas_id",$ai_persona_usuario[0]->caso)->first();
			if($predictivo != null){
				if($datosPersona->periodo < $predictivo->periodo ){
					$datos_NNA = $predictivo;
					$datos_NNA->per_nom = $datos_NNA->nombres. ' ' .$datos_NNA->ap_paterno. ' ' . $datos_NNA->ap_materno;
					$datos_NNA->per_ani = $datos_NNA->edad_agno;
					$datos_NNA->dv = $datos_NNA->dv_run;
					
				}else{
					$dv = Persona::where('per_run', $request->run)->first();
					$datos_NNA = $datosPersona;
					$datos_NNA->dv = $dv->per_dig;
				}
			}else{
				$dv = Persona::where('per_run', $request->run)->first();
				$tablaNomina = false;
				$datos_NNA = $datosPersona;
				$datos_NNA->dv =$dv->per_dig;
			}
		}else{
			$datos_NNA = $predictivo;
			$datos_NNA->per_nom = $datos_NNA->nombres. ' ' .$datos_NNA->ap_paterno. ' ' . $datos_NNA->ap_materno;
			$datos_NNA->per_ani = $datos_NNA->edad_agno;
			$datos_NNA->dv = $datos_NNA->dv_run;
		}

		$run_con_formato = Rut::parse($request->run.$datos_NNA->dv)->format();
		$ai_casos_gestion =  Caso::leftJoin('ai_estado_caso', "ai_caso.est_cas_id", "=", "ai_estado_caso.est_cas_id")
								->leftJoin('ai_persona_usuario', "ai_caso.cas_id", "=", "ai_persona_usuario.cas_id")->where('run', $request->run)->where('est_cas_fin', '<>', 1)->count();

								
		$ai_casos_desestimado =  Caso::leftJoin('ai_estado_caso', "ai_caso.est_cas_id", "=", "ai_estado_caso.est_cas_id")
								->leftJoin('ai_persona_usuario', "ai_caso.cas_id", "=", "ai_persona_usuario.cas_id")->where('run', $request->run)->where('est_cas_fin', '<>', 0)->count();

								
		if($ai_casos_gestion == 0){
			$tablaCasoGestion = false;
		}	
		
		if($ai_casos_desestimado == 0){
			$tablaCasoDesestimados = false;
		}

		return view('caso.resumenNNA',
		[
			'datos_NNA' => $datos_NNA,
			'run_formato' => $run_con_formato,
			'tablaNomina' => $tablaNomina,
			'tablaCasoGestion' => $tablaCasoGestion,
			'tablaCasoDesestimados' => $tablaCasoDesestimados, 
			'run' => $request->run
			// 'cantidad_casos' => $cantidad_casos,
			// 'desde_terapia' => $desde_terapia,
			// 'icono' => $icono

		]
	);
		return view('caso.resumenNNA');
	}

	public function casoDesestimado(Request $request){
		$desetimado = $this->caso->NNAdesetimado($request->run);
		return Datatables::of($desetimado)->make(true);	
		
	}

	public function casoGestion(Request $request){
		$gestion = $this->caso->NNcasoGestion($request->run);
		return Datatables::of($gestion)->make(true);	
		
	}

	public function nnaNomina(Request $request){
		return Datatables::of(NominaComunal::query()->where('run', $request->run))
		->addColumn('color', function ($caso){
			return $caso->score;
		}, true)
		->rawColumns(['color'])
		->make(true);
	}

	public function test(){
		$apiMds = new ApiMdsService;
		$rsh = $apiMds->getRsh('26606577');
		print_r($rsh);
		die();
	}
	//CZ SPRINT 73
//CZ SPRINT 74
	public function notificacion(){
		return view('caso.historial_notificacion');
	}

	//OBTENER NOTIFICACION DE TIEMPO DE INTERVENCION
	public function notificacionTiempoIntervencion(){
		return	NotificacionAsignacion::notificacionTiempoIntervencion();
	}

	public function notificacionTiempoIntervencionTabla(){
		// CZ SPRINT 77
		$notificaciones = TiempoIntervension::notificacionTiempoIntervencion();
		return Datatables::of(collect($notificaciones))->make(true);
	}

	//OBTENER NOTIFICACIONES DE ASINGACION (TOASTR)
	public function notificacionAsignacionToastr(Request $request){
		$comuna = explode(',',session()->all()['com_cod']);
		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			


			$notificaciones = DB::select("select * from AI_NOTIFICACION_ASIGNACION inner join ai_caso_persona_indice on
			AI_NOTIFICACION_ASIGNACION.id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_usuario_comuna on ai_usuario.id = ai_usuario_comuna.usu_id
			inner join ai_comuna on ai_usuario_comuna.com_id = ai_comuna.com_id
			inner join ai_persona_usuario on (ai_usuario.id = ai_persona_usuario.usu_id and ai_notificacion_asignacion.id = ai_persona_usuario.cas_id)
			inner join ai_caso_comuna on ai_comuna.com_id = ai_caso_comuna.com_id and ai_caso_persona_indice.cas_id = ai_caso_comuna.cas_id and ai_notificacion_asignacion.id = ai_caso_comuna.cas_id  
			where ID_USUARIO = ".session()->all()['id_usuario']." and ai_comuna.com_cod  = ".$comuna[0]." 
			 and tipo = 1 and estado_notificacion = 1 ");
			foreach($notificaciones as $key => $notificacion){
				$notificacion = NotificacionAsignacion::find($notificacion->id_notificacion);
			
				if($notificacion->estado_notificacion == 1){
					$notificacion->estado_notificacion = 2;
					
				}
		
				$respuesta = $notificacion->save();
			}
			return $notificaciones;
		}else if(session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			
			$notificaciones = DB::select("select * from AI_NOTIFICACION_ASIGNACION where ID_USUARIO = ".session()->all()['id_usuario']." and tipo = 2 and estado_notificacion = 1 ");
			foreach($notificaciones as $key => $notificacion){
				$notificacion = NotificacionAsignacion::find($notificacion->id_notificacion);
				if($notificacion->estado_notificacion == 1){
					$notificacion->estado_notificacion = 2;
				}
				
				$respuesta = $notificacion->save();
			}		
			
			return $notificaciones;
		}		
	}

	//CAMBIO DE ESTADO DE LA NOTIFICACION, CUANDO SE ENVIA Y CUANDO SE REVISA
	public function cambiarEstadoNotificacion(Request $request){
		
		$notificacion = $request->notificacion;
	
		if(!is_array($notificacion)){
			$notificacion = NotificacionAsignacion::find($notificacion);
			
			if($notificacion->estado_notificacion == 1){
				$notificacion->estado_notificacion = 2;
			}else if($notificacion->estado_notificacion == 2){
				$notificacion->estado_notificacion = 3;
			}
			
			$respuesta = $notificacion->save();
			if(!$respuesta){
				return response()->json(array('estado' => '0', 'mensaje' => 'Ha ocurrido un inconveniente al momento de cambiar el estado de la notificación. Por favor intentelo nuevamente.'), 200);
			}else{
				
				$obtenerCantidadNotificaciones = $this->cantidadNotificaciones();
				$request->session()->put('cantidad', $obtenerCantidadNotificaciones);

				$obtenerCantidadNotificacionesAsign = $this->cantidadNotificaciones_Asignacion();
				$request->session()->put('cantidad_asignacion', $obtenerCantidadNotificacionesAsign);
				
				return response()->json(array('estado' => '0', 'mensaje' => 'Cambio realizado con exito'), 200);
			}
		}else{
			
			foreach ($notificacion as $clave => $notif) {
				$notificacion = NotificacionAsignacion::find($notif);
				if($notificacion->estado_notificacion == 1){
					$notificacion->estado_notificacion = 2;
				}
			}
			$respuesta = $notificacion->save();
			if(!$respuesta){
				return response()->json(array('estado' => '0', 'mensaje' => 'Ha ocurrido un inconveniente al momento de cambiar el estado de la notificación. Por favor intentelo nuevamente.'), 200);
			}else{
				$obtenerCantidadNotificaciones = $this->cantidadNotificaciones();
				$request->session()->put('cantidad', $obtenerCantidadNotificaciones);

				$obtenerCantidadNotificacionesAsign = $this->cantidadNotificaciones_Asignacion();
				$request->session()->put('cantidad_asignacion', $obtenerCantidadNotificacionesAsign);

				return response()->json(array('estado' => '0', 'mensaje' => 'Cambio realizado con exito'), 200);
			}
		}


	}

	//OBTENER NOTIFICACION DE CASOS Y TERAPIAS ASIGNADAS
	public function notificacionAsignacionTabla(Request $request){
		$comuna = explode(',', session()->all()['com_id']);

		if(session()->all()['perfil'] == config('constantes.perfil_gestor')){
			// $caso = DB::select("select * from ai_caso c where c.cas_id in (select distinct c.cas_id from ai_caso c INNER JOIN ai_persona_usuario a ON (c.cas_id = a.cas_id)  where cas_fec >='". date("Y-m-d")."' and a.usu_id =". session()->all()['id_usuario'].")");
			$notificaciones = DB::select("select AI_NOTIFICACION_ASIGNACION.*, ai_persona.per_run 
			from AI_NOTIFICACION_ASIGNACION 
			inner join ai_caso_comuna on ai_notificacion_asignacion.id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on AI_NOTIFICACION_ASIGNACION.id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id 
			where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]."  and tipo = 1 and estado_notificacion = 2 and ai_caso_persona_indice.per_ind = 1");
			// return $notificaciones;
			// return Datatables::of($notificaciones);
			return Datatables::of(collect($notificaciones))->make(true);
		}else if(session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			$notificaciones = DB::select(" 
			select AI_NOTIFICACION_ASIGNACION.*, ai_persona.per_run, t.cas_id as id 
            from AI_NOTIFICACION_ASIGNACION
            inner join ai_terapia t on ai_notificacion_asignacion.id_usuario = t.usu_id and ai_notificacion_asignacion.id = t.tera_id
			inner join ai_caso_comuna on t.cas_id = ai_caso_comuna.cas_id  
            inner join ai_usuario on AI_NOTIFICACION_ASIGNACION.id_usuario = ai_usuario.id
            inner join ai_caso_persona_indice on t.cas_id = ai_caso_persona_indice.cas_id
			inner join ai_persona on ai_caso_persona_indice.per_id = ai_persona.per_id  
			where ID_USUARIO = ".session()->all()['id_usuario']." and ai_caso_comuna.com_id  = ".$comuna[0]." and tipo = 2 and estado_notificacion = 2 and ai_caso_persona_indice.per_ind = 1");
	
			return Datatables::of(collect($notificaciones))->make(true);
		}
	}

	//OBTENER LA CANTIDAD DE NOTIFICACIONES
	public function cantidadNotificaciones(){
		return NotificacionAsignacion::cantidadNotificaciones();
	}
	//OBTENER LA CANTIDAD DE NOTIFICACIONES ASIGNACION
	public function cantidadNotificaciones_Asignacion(){
		return NotificacionAsignacion::CantnotificacionesAsignacion();
	}

	//OBTENER LA CANTIDAD DE NOTIFICACIONES TIEMPO DE INTERVENCION
	public function cantidadNotificaciones_Tiempo(){
		return NotificacionAsignacion::CantnotificacionesTiempoIntervencion();
	}

	//CZ SPRINT 74

	public function validarAsignacionCasoPeriodo(Request $request){
		
		$periodo_persona = DB::select("select * from ai_predictivo  where run = " .$request->nna);

		if(count($periodo_persona) != 0){
			$casos = DB::select('select count(*) as cantidad from AI_CASO_PERSONA_INDICE 
		left join ai_persona  on ai_persona.per_id = AI_CASO_PERSONA_INDICE.per_id
		left join ai_caso on AI_CASO_PERSONA_INDICE.cas_id = ai_caso.cas_id
		left join ai_estado_caso on ai_caso.est_cas_id = ai_estado_caso.est_cas_id
			where ai_estado_caso.est_cas_fin = 1 and per_run = '. $request->nna .'and periodo = '.$periodo_persona[0]->periodo);
			return response()->json(array('estado' => '1', 'mensaje' => 'información obtenida con exito', 'cantidad_periodo' => $casos[0]->cantidad), 200);

		}else{
			return response()->json(array('estado' => '0', 'mensaje' => 'Ha ocurrido un error, NNA no encontrado en la nomina. Por favor vuelva a intentarlo', 'cantidad_periodo' => 'error'), 200);

			}
		}
}
