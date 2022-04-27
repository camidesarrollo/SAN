<?php

namespace App\Http\Controllers;

use Session;
use App\Modelos\{Sesion, Caso, SesionGrupal, Usuarios};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
	protected $caso;
	
	protected $sesion;
	
	protected $usuario;
	
	protected $sesion_grupal;
	
	public function __construct(
		Sesion			$sesion,
		Caso			$caso,
		Usuarios		$usuario,
		SesionGrupal	$sesion_grupal
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->middleware('verificar.perfil:coordinador,terapeuta');
		$this->caso					= $caso;
		$this->sesion				= $sesion;
		$this->usuario				= $usuario;
		$this->sesion_grupal		= $sesion_grupal;
	}
	
	/**
	 * Muestra la Vista de la Agenda
	 * @param null $caso
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show($caso=null){

		try {
			$teraputas = [];
			if (session('tipo_perfil')!=config('constantes.tipo_terapeuta')){
				$teraputas = $this->usuario->getTerapeutas();
			}
			
			return view('terapeuta.agenda')->with(['caso'=>$caso, 'terapeutas'=>$teraputas]);
		} catch(\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
	
	/**
	 * Devuelve el listado de las sesiones individuales para la agenda
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generar(Request $request){
		try{
			$sesiones = $this->sesion->getAgenda($request);
			
			return response()->json($sesiones);
		} catch(\Exception $e) {
			Log::info($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
	
	/**
	 * Devuelve el listado de las sesiones grupales para la agenda
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generarGrupal(Request $request){
		try{
			$sesiones = $this->sesion->getAgendaGrupal($request);
			
			return response()->json($sesiones);
		} catch(\Exception $e) {
			Log::info($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
	}
}
