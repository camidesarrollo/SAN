<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use File;
use App\Modelos\Adjunto;
use Session;

/**
 * Class FileController
 * @package App\Http\Controllers
 */
class FileController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
	}
	
	/**
	 * @param $adj_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function getFile($adj_id){
		try{
			$archivo = Adjunto::find($adj_id);
			$exists = Storage::disk('local')->exists($archivo->adj_cod);
			
			if($exists){
				$url = Storage::disk('local')->url($archivo->adj_cod);
				return response()->download($url,$archivo->adj_nom);
			}else{
				$mensaje = "No se Pudo Encontrar el archivo en el servidor.";
				return view('layouts.errores')->with(['mensaje'=>$mensaje]);
			}
		} catch (\Exception $e) {
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
}
