<?php

namespace App\Http\Controllers;

use Session;
use App\Modelos\{Accion, Ofertas, AlertaTipo, TipoUrgencia};

class AccionController extends Controller
{
	protected $accion;
	protected $ofertas;
	protected $alertatipo;
	protected $tipourgencia;
	
	public function __construct(
		Accion			$accion,
		Ofertas			$ofertas,
		AlertaTipo		$alertatipo,
		TipoUrgencia	$tipourgencia
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->accion		= $accion;
		$this->ofertas		= $ofertas;
		$this->alertatipo	= $alertatipo;
		$this->tipourgencia	= $tipourgencia;
	}
	
	/**
	 * Método que lista las prestaciones del mantenedor
	 *
	 * @return view
	 */
	public function main(){
		
		return view('accion.main');
		
	}
	
	
	public function listarAccion(){
		
		$accion 	= $this->accion->all();
		
		$data		= new \stdClass();
		$data->data = $accion;
		
		echo json_encode($data); exit;
		
	}
	
	
	public function crearAccion($acc_id=null){
		
		$accion	= null;
		if (!is_null($acc_id)){
			$accion = $this->accion->find($acc_id);
		}
		
		return view('accion.crear')->with(['accion'=>$accion]);
		
	}
	
	
}