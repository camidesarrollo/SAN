<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\{CasoTerapeuta, Sesion, Caso, EstadoSesion, EstadoCaso, SesionGrupal, Usuarios };
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Session;


/**
 * Class SesionController
 * @package App\Http\Controllers
 */
class SesionController extends Controller {
	
	protected $nombres = [
		'ses_id' => 'ID Sesion de Sesión',
		'cas_id' => 'ID Caso de Sesión',
		'ter_id' => 'ID Terapeta de Sesión',
		'ses_obs'=> 'Observación de Sesión',
		'ses_dia'=> 'Diagnostico de Sesión',
		'ses_fec' => 'Fecha de Sesión',
		'ses_tip' => 'Tipo de Sesión',
		'ses_num' => 'Numero de Sesión',
		'gru_rut' => 'Rut',
		'gru_fec' => 'Fecha',
		'gru_nom' => 'Nombre Comppleto',
		'gru_obs' => 'Observaciones',
	];
	
	protected $reglas_update = [
		'ses_id' => 'required',
		'cas_id' => 'required',
		'ter_id' => 'required',
		'ses_obs' => 'required',
		'ses_dia' => 'required',
		'ses_fec' => 'required|date_format:d/m/Y H:i',
		'ses_tip' => 'rsometimes|equired',
	];
	
	protected $reglas_create = [
		'cas_id' => 'required',
		'ses_num' => 'required',
		'ses_obs' => 'sometimes|required',
		'ses_dia' => 'sometimes|required',
		'ses_fec' => 'required|date_format:d/m/Y H:i',
		'ses_tip' => 'required',
	];
	
	protected $caso;
	
	protected $sesion;
	
	protected $estado_sesion;
	
	protected $estado_caso;
	
	protected $sesion_grupal;
	
	protected $caso_terapeuta;
	
	protected $usuario;
	
	public function __construct(
		Sesion				$sesion,
		Caso				$caso,
		EstadoSesion		$estado_sesion,
		EstadoCaso			$estado_caso,
		SesionGrupal		$sesion_grupal,
		CasoTerapeuta		$caso_terapeuta,
		Usuarios			$usuario
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		//$this->middleware('verificar.perfil:terapeuta');
		//$this->middleware('verificar.caso.terapeuta',['only' => ['index']]);
		$this->caso					= $caso;
		$this->sesion				= $sesion;
		$this->estado_sesion		= $estado_sesion;
		$this->estado_caso			= $estado_caso;
		$this->sesion_grupal		= $sesion_grupal;
		$this->caso_terapeuta		= $caso_terapeuta;
		$this->usuario				= $usuario;
	}
	
	/**
	 * Muestra vista con todas las sesiones individuales
	 * @param $cas_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mainIndividuales($cas_id)
	{

		// try {
			
			$caso = $this->caso->getConPersonaEstadosByCaso($cas_id);
			
			if (is_null($caso)) {
				$mensaje = "No se Pudo Encontrar el caso, intente nuevamente.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}
			

			$sesiones = $this->sesion->getIndividualesConEstadosByCaso($cas_id)->keyBy('ses_num');

			$val_btn_agr = false;
			$can_ses     = config('constantes.sesion_individual');
			if (count($sesiones) >= 8){
				$val_btn_agr = true;
				$can_ses     = count($sesiones);
			}
				
			//Negocio de validación de la cantidad de sesiones individuales en estados planificadas o finalizadas
			$val_ses_adi = false;
			$cons_est = [config('constantes.estado_finalizado')];

			$cant_ses_ind = $this->sesion->getSesionesEstadoNNA($cas_id, 'I', $cons_est);
			if (count($cant_ses_ind) >= 8) $val_ses_adi = true;

			//Negocio de las sesiones individuales de seguimiento
			$can_ses_seg = config('constantes.sesion_seguimiento');
			$lis_ses_seg = $this->sesion->getSesionesEstadoNNA($cas_id, 'C');
			if (count($lis_ses_seg) > 0) $can_ses_seg = count($lis_ses_seg);
			
			$lis_ssg_est = $this->sesion->getSesionesSeguimientoConEstadosByCaso($cas_id)->keyBy('ses_num');
			
			//Negocio de las sesiones individuales de retroalimentación
			$can_ses_ret = config('constantes.sesion_retroalimentación');
			$lis_ses_ret = $this->sesion->getSesionesEstadoNNA($cas_id, 'R');
			if (count($lis_ses_ret) > 0) $can_ses_ret = count($lis_ses_ret);
			
			$lis_srt_est = $this->sesion->getSesionesRetroalimentacionConEstadosByCaso($cas_id)->keyBy('ses_num');

			//Bitacora de los estados por cada sesión individual.
			$tot_bit_ses = $this->estado_sesion->getBitaEstSes($cas_id);
			

			$res_vis = ['sesiones'=>$sesiones, 'caso' => $caso, 'val_btn_agr' => $val_btn_agr,
				       'can_ses' => $can_ses, 'val_ses_adi' => $val_ses_adi, 'can_ses_seg' => $can_ses_seg,
			           'can_ses_ret' => $can_ses_ret, 'lis_ssg_est' => $lis_ssg_est, 'lis_srt_est' => $lis_srt_est , 'tot_bit_ses' => $tot_bit_ses];
			
			return view('sesiones.main')->with($res_vis);
			
		// } catch(\Exception $e) {
		// 	Log::error('error: '.$e);
		// 	$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
		// 	return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		// }
	}
	
	/**
	 * Crear una sesión individual
	 * @param Request $request
	 * @param $cas_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function grabarIndividuales(Request $request, $cas_id)
	{
		$data = $request->validate($this->reglas_create,[], $this->nombres);

		//dd($data);

		//Log::debug('An informational message.');
		
		try{
			DB::beginTransaction();
			
			//Validar la fecha no sea menor a una semana
			$fecha = Carbon::createFromFormat('d/m/Y H:i', $request->ses_fec);
			if ($fecha->lt(now()->subDays(8))){
				$mensaje = 'Error. La fecha no puede ser menor a una semana';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$final = Carbon::createFromFormat('d/m/Y H:i', $request->ses_fec)->addHours(1);
			
			$total = $this->sesion
				->terapeuta(session("id_usuario"))
				->when(request('ses_tip') == 'G', function ($query) {
					return $query->tipoIndividual();
				})
				->where(function ($query) use ($fecha,$final) {
					$query->where(function ($query) use ($fecha) {
						$query->where('ses_fec', '<=', $fecha)
							->whereRaw("? < (ses_fec+ INTERVAL '1' HOUR)", [$fecha]);
					})
					->orWhere(function ($query) use ($final) {
						$query->where('ses_fec', '<', $final)
							->whereRaw("? <= (ses_fec+ INTERVAL '1' HOUR)", [$final]);
					});
				})
				->count();
			
			Log::info('total: '.$total);
			if ($total != 0) {
				$mensaje = 'Error. Ya existe una Sesion en ese periodo de tiempo.';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			if ($request->ses_tip=='G'){
				$total = $this->sesion
					->where('ter_id', session("id_usuario"))
					->where('ses_tip','G')
					->where('cas_id',$cas_id)
					->where(function ($query) use ($fecha,$final) {
						$query->where(function ($query) use ($fecha) {
							$query->where('ses_fec', '<=', $fecha)
								->whereRaw("? < (ses_fec+ INTERVAL '1' HOUR)", [$fecha]);
						})
							->orWhere(function ($query) use ($final) {
								$query->where('ses_fec', '<', $final)
									->whereRaw("? <= (ses_fec+ INTERVAL '1' HOUR)", [$final]);
							});
					})
					->count();
				
				Log::info('total grupal caso: '.$total);
				if ($total != 0) {
					$mensaje = 'Error. Ya existe una Sesion Grupal para ese Caso en ese periodo de tiempo.';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
			}
			
			
			$caso = $this->caso->find($cas_id);
			if (is_null($caso)){
				DB::rollback();
				$mensaje = 'Error. No se pudo conseguir el Caso asociado a la Sesión';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			//Log::info('por aca');
			// ya no es necesario
			/*$encontrado = $this->sesion//
				->terapeuta(session("id_usuario"))
				->numero($request->ses_num)
				->caso($cas_id)
				->tipoIndividual()->exists();
			if ($encontrado) {
				DB::rollback();
				$mensaje = 'Error. Ya existe este numero de sesion';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}*/
			
			$total_tipo = $this->sesion->where(
				['cas_id' => $cas_id,
				'ter_id' => session("id_usuario"),
				'ses_tip'=> $request->ses_tip
				])->count();
			
			/*if ($request->ses_tip=='I'){
				if ($total_tipo>=config('constantes.sesion_individual')) {
					DB::rollback();
					$mensaje = 'Error. Solo Pueden haber un maximo de '.config('constantes.sesion_individual').' Sesiones Individuales';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
			}elseif($request->ses_tip=='G'){
				if ($total_tipo>=config('constantes.sesion_grupal')) {
					DB::rollback();
					$mensaje = 'Error. Solo Pueden haber un maximo de '.config('constantes.sesion_grupal').' Sesiones Grupales';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
			}*/
			
			$estado_caso = $this->estado_caso->planificado()->first();
			if (is_null($estado_caso)){
				DB::rollback();
				$mensaje = 'Error. No se pudo Conseguir el Estado Derivado';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$caso->estados()->syncWithoutDetaching([$estado_caso->est_cas_id => ['cas_est_cas_des' => 'Se agendo la sesiones']]);
			
			$this->sesion->fill($data);
			$this->sesion->ter_id = session('id_usuario');
			
			$resultado = $caso->sesiones()->save($this->sesion);
			if (!$resultado) {
				DB::rollback();
				$mensaje = "Error. Por Favor Selecione la Fecha de la Sesión";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			// me traigo el estado inicial para una sesion
			$estado = $this->estado_sesion->getPrimero();
			if (is_null($estado)) {
				DB::rollback();
				$mensaje = "Error. No se Pudo Encontrar el Estado Inicial de la sesion.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			// guardo el estado con la sesion
			$resultado = $this->sesion->estados()->save($estado);
			if (!$resultado) {
				DB::rollback();
				$mensaje = "Error. No se Pudo guardo el estado de la sesion.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			DB::commit();
			return response()->json(array('estado' => '1',
				'mensaje' => ' Se grabó correctamente la sesion.',
				'sesion'=>$this->sesion->toJson(),
				'sesion_estado'=>$estado->toJson()
				),201);
		} catch(\Exception $e) {
			DB::rollback();
			Log::info($e);
			//dd($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Muestra modal para modificación de sesión (grupal e individual del caso)
	 * @param $cas_id
	 * @param $ses_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request){
		
		try {
			
			$desabilitar = '';
			// Descomentar cuando se decida si el Caso luego de Derivado se puede crear sesiones
			/*$estado = $this->estado_caso->derivado()->first();
			$estado_caso = $caso->estados()->wherePivot('est_cas_id',$estado->est_cas_id)->first();
			if (!is_null($estado_caso)) {
				$desabilitar = 'disabled';
			}*/
			
			$sesion = $this->sesion->find($request->ses_id);
			if (is_null($sesion)) {
				$mensaje = "No se Pudo Encontrar la sesion, intente nuevamente.";
				//Log::error('No se Pudo Encontrar la sesion, intente nuevamente');
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			$estado_sesion = $this->estado_sesion->all('est_ses_nom', 'est_ses_id')
				->pluck('est_ses_nom', 'est_ses_id')->toArray();
			if (count($estado_sesion)==0) {
				$mensaje = "No se Pudo Encontrar los estados de las sesiones, intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			
			$estado = $sesion->estados()->latest('ses_est_ses_fec')->take(1)->first();
			if (is_null($estado_sesion)) {
				$mensaje = "No se Pudo Encontrar el ultimo estado de la sesion, intente nuevamente.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			}
			

			// se retorna formulario
			return view('sesiones.show')
				->with(['sesion' => $sesion,
					'estados' => $estado_sesion,
					'estado' => $estado,
					'desabilitar'=>$desabilitar
				]);
		}
		catch(\Exception $e)
		{
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/** Actualiza los Datos de una Sesion (individual o grupal caso)
	 * @param Request $request
	 * @param $cas_id
	 * @param $ses_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function actualizar(Request $request, $cas_id, $ses_id)
	{
		$data = $request->validate($this->reglas_update,[], $this->nombres);
		
		try {
			DB::beginTransaction();
			
			$sesion = $this->sesion->find($ses_id);
			if (is_null($sesion)){
				DB::rollback();
				$mensaje = " Error. No se pudo conseguir el Caso asociado a la Sesión";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$total_tipo = $this->sesion->where(
				['cas_id' => $cas_id,
					'ter_id' => session("id_usuario"),
					'ses_tip'=> $request->ses_tip
				])->where('ses_id','!=', $request->ses_id)
				->count();
			
			if ($request->ses_tip=='I'){
				if ($total_tipo>=config('constantes.sesion_individual')) {
					DB::rollback();
					$mensaje = 'Error. Solo Pueden haber un maximo de '.config('constantes.sesion_individual').' Sesiones Individuales';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
			}elseif($request->ses_tip=='G'){
				if ($total_tipo>=config('constantes.sesion_grupal')) {
					DB::rollback();
					$mensaje = 'Error. Solo Pueden haber un maximo de '.config('constantes.sesion_grupal').' Sesiones Grupales';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
			}
			
			$resultado = $sesion->fill($data)->save();
			if (!$resultado) {
				DB::rollback();
				$mensaje = ' Error. No se Pudo actualizar la sesión.';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}

			$resultado = $this->sesion->actualizarEstado($request);

			//$resultado = $sesion->estados()->syncWithoutDetaching($request->est_ses_id);

			if (!$resultado) {
				DB::rollback();
				$mensaje = ' Error. No se Pudo guardar el estado de la sesión.';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$estado_sesion = $sesion->getUltimoEstado();

			$current_time =  Carbon::createFromFormat('d/m/Y H:i', $request->ses_fec)->addHours(1);

			// DB::table('ai_sesion_estado_sesion')->insert(
			// 	array('ses_is' => 1 , 'est_ses_id' => 1 ,'ses_est_ses_fec' => '04/02/19 16:58:53,000000000' , 'ses_obs' => 1, 'ses_dia' => 1 ));

			DB::commit();
			return response()->json(array('estado' => '1',
				'mensaje' => ' Se actualizo correctamente la sesion.',
				'sesion_estado' => $estado_sesion->toJson(),
				'sesion'=>$sesion->toJson()),200);

		}
		catch(\Exception $e)
		{
			DB::rollback();
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Muestra index de sesiones grupales
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showGrupal(){
		try {
			return view('sesiones.grupal_main');
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Generar json para grilla de sesiones grupales
	 * @return mixed
	 * @throws \Exception
	 */
	public function getSesionesGrupales(){
		$sesiones = $this->sesion_grupal->with('estados')->select([
			'gru_id',
			'usu_id',
			'gru_rut',
			'gru_nom',
			'gru_fec'
		]);
		
		return Datatables::of($sesiones)
			->make();
	}
	
	/**
	 * Muestra el formulario para crrar las sesiones grupales
	 * @param null $gru_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getFormGrupal($gru_id=null){
		$grupal = null;
		
		$readonly = "";
		
		if (!is_null($gru_id)){
			$grupal = $this->sesion_grupal->find($gru_id);
			$readonly = "readonly";
		}
		
		return view('sesiones.grupal_crear')->with(['grupal'=>$grupal, 'readonly'=>$readonly]);
	}
	
	/**
	 * Crear o modifica una sesion grupal
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function crearGrupal(Request $request){
		$reglas = [
			'gru_rut' => 'required',
			'gru_nom' => 'required',
			'gru_obs' => '',
			'gru_fec' => 'required|date_format:d/m/Y H:i',
		];
		
		$data = $request->validate($reglas,[], $this->nombres);
		
		try{
			DB::beginTransaction();
			
			if ($request->gru_id==-1) {
				//Validar la fecha no sea menor a una semana
				$fecha = Carbon::createFromFormat('d/m/Y H:i', $request->gru_fec);
				if ($fecha->lt(now()->subDays(config('constantes.sesion_dias_minimo')))) {
					$mensaje = 'Error. La fecha no puede ser menor a una semana';
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$grupal = $this->sesion_grupal->create($data);
				if (is_null($grupal)) {
					DB::rollback();
					$mensaje = "Error. No se pudo crear la sesion grupal.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$estado = $this->estado_sesion->getPrimero();
				if (is_null($estado)) {
					DB::rollback();
					$mensaje = "Error. No se pudo obtener el estado inicial de la sesion grupal.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$resultado = $grupal->estados()->save($estado);
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error. No se pudo guarda el estado de la sesion grupal.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$mensaje = 'La Alerta Grupal ha Sido Creado Exitosamente.';
			} else {
				
				$grupal = $this->sesion_grupal->find($request->gru_id);
				$grupal->fill($data);
				$grupal->save();
				
				$estado = $grupal->estados()->first();
				
				$mensaje = 'La Alerta Grupal ha Sido Modificada Exitosamente.';
			
			}
			
			DB::commit();
			
			return response()->json(array('estado' => '1',
				'mensaje' => $mensaje,
				'sesion'=>$grupal->toJson(),
				'sesion_estado'=>$estado->toJson()
			),201);
		} catch(\Exception $e) {
			DB::rollback();
			Log::error($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
		
	}
	
	/**
	 * Muestra el formulario para asignar casos de un terapeuta a una sesion grupal
	 * @param null $gru_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getFormAsignar($gru_id=null){
		try {
			$grupal = $this->sesion_grupal->find($gru_id);
			if (is_null($grupal)){
				$mensaje = 'Error. No se pudo conseguir el Caso';
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			$casos = $this->caso_terapeuta->getConCasoPersona(session('id_usuario'));
			
			$sesiones = $this->sesion->getGrupalByTerapeuta($gru_id)->keyBy('cas_id');
			
			$grupales = $this->sesion->getGrupal($gru_id);
			
			return view('sesiones.grupal_asignar')
				->with(['grupal'=>$grupal,'casos'=>$casos,
					'sesiones' => $sesiones,
					'grupales' => $grupales
				]);
		} catch(\Exception $e) {
			Log::error('error ocurrido:'.$e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Asocia los casos a una sesion grupal
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function asignarGrupal(Request $request){
		try{
			DB::beginTransaction();
			
			$grupal = $this->sesion_grupal->find($request->gru_id);
			if (is_null($grupal)) {
				DB::rollback();
				$mensaje = "Error. No se pudo encontrar la sesion grupal.";
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
			}
			
			foreach ($request->casos as $caso){
				
				$asignar = [
					'cas_id' => $caso,
					'ter_id' => $request->user()->id,
					'ses_fec' => $grupal->gru_fec,
					'ses_tip' => 'G',
					'gru_id' => $request->gru_id
				];
				
				$sesion = $this->sesion->create($asignar);
				
				// me traigo el estado inicial para una sesion
				$estado = $this->estado_sesion->getPrimero();
				if (is_null($estado)) {
					DB::rollback();
					$mensaje = "Error. No se Pudo Encontrar el Estado Inicial de la sesion.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
				
				// guardo el estado con la sesion
				$resultado = $sesion->estados()->save($estado);
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error. No se Pudo guardo el estado de la sesion.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
				}
			}
			
			DB::commit();
			
			return response()->json(array('estado' => '1',
				'mensaje' => 'La Alerta Grupal ha Sido Creado Exitosamente.'
			/*,
				'sesion'=>$sesion->toJson(),
				'sesion_estado'=>$estado->toJson()*/
			),201);
		} catch(\Exception $e) {
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Genera lista de sesiones grupales de un terapeuta.
	 * @return mixed
	 * @throws \Exception
	 */
	public function getSesionesIndividuales(){
		$sesiones = $this->sesion->with('estados','caso.persona')
			->select([
				'ses_id',
				'cas_id',
				'ter_id',
				'ses_obs',
				'ses_dia',
				'ses_fec',
				'ses_num',
				'ses_tip',
				'gru_id'
			])->tipoGrupal()->terapeuta(session('id_usuario'));
		
		return Datatables::of($sesiones)
			->make();
	}
	
	/**
	 * Valida la cantidad de sesiones grupales que mantiene un NNA en estado planificado o finalizado.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 *
	 */
	public function valSesionesGrupalesNNA(Request $request){
	   try{
	   	   $val_res = true;
		
		   $cons_est = [config('constantes.estado_planificado'), config('constantes.estado_finalizado')];
		   $cant_ses_gru = $this->sesion->getSesionesEstadoNNA($request->caso_id, 'G', $cons_est);
		   
		   if (count($cant_ses_gru) >= 4) $val_res = false;
		
		   return response()->json(array('estado' => '1', 'respuesta' => $val_res), 200);
		   
	   }catch(\Exception $e){
		   Log::info('error ocurrido:'.$e);
		   $mensaje = "Error al momento de validar las sesiones grupales del NNA. ".$e;
		
		   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		   
	   }
	   
	}
	
	/**
	 * Valida la cantidad de sesiones individuales que mantiene un NNA en estado planificado o finalizado.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 *
	 */
	public function valSesionesIndividualesNNA(Request $request){
	   try{
	   	 $val_res_ind = true;
         
	   	 $cons_est = [config('constantes.estado_planificado'), config('constantes.estado_finalizado')];
	   	 $cant_ses_ind = $this->sesion->getSesionesEstadoNNA($request->caso_id, 'I', $cons_est);
	   	 
	   	 if (count($cant_ses_ind) >= 8) $val_res_ind = false;
		
	   	 return response()->json(array('estado' => '1', 'respuesta' => $val_res_ind), 200);
	   	 
	   }catch(\Exception $e){
		   Log::info('error ocurrido:'.$e);
		   $mensaje = "Error al momento de validar las sesiones individuales del NNA. ".$e;
		
		   return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
	   }
		
	}
}
