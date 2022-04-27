<?php

namespace App\Http\Controllers;

use App\Modelos\Provincia;
use Session;

class ProvinciaController extends Controller
{
	protected $provincia;
	
	public function __construct(
		Provincia		$provincia
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->provincia		= $provincia;
	}
	
	/**
	 * Genera listado de provincias por region
	 * @param null $id_region
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function porRegion($id_region=null){
		$provincias = $this->provincia->getByRegion($id_region);
		
		return response()->json($provincias);
	}
	
}
