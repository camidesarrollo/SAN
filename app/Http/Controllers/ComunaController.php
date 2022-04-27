<?php

namespace App\Http\Controllers;

use Session;
use App\Modelos\Comuna;

class ComunaController extends Controller
{
	protected $comuna;
	
	public function __construct(
		Comuna		$comuna
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->comuna		= $comuna;
	}
	
	/**
	 * Genera listado de comunas por provincia
	 * @param null $id_provincia
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function porProvincia($id_provincia=null){
		$comunas = $this->comuna->getByProvincia($id_provincia);
		
		return response()->json($comunas);
	}
	
}
