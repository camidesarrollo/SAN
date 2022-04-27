<?php

namespace App\Http\Controllers;

use App\Modelos\Region;
use Session;

class RegionController extends Controller
{
    //
	protected $region;
	
	public function __construct(
		Region		$region
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->region		= $region;
	}
	
	/**
	 * Genera listado de todas las regiones
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getRegiones(){
		$regiones = $this->region->all();
		
		return response()->json($regiones);
	}
	
}
