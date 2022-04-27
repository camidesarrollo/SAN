<?php

namespace App\Http\Controllers;

use App\Modelos\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;

/**
 * Class MapaController
 * @package App\Http\Controllers
 */
class MapaController extends Controller
{
    //
	protected $usuarios;
	
	public function __construct(
		Usuarios	$usuarios
	)
	{
		$this->middleware('verificar.configuracion.comuna');
		$this->usuarios		= $usuarios;
	}
	
	/**
	 * Recive la llamada del servicio de mapas y verifica que un token sea valido para generar el mapa
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function verificar(Request $request){
		try{
			//Log::info('info: entro en verificar');
			
			if (!$request->post('token',false)){
				Log::error('error: token no suministrado\'');
				return response()->json([false,'token no suministrado']);
			}
			
			if (!$request->post('userId',false)){
				Log::error('error: usuario no suministrado');
				return response()->json([false,'usuario no suministrado']);
			}
			
			$usuario = $this->usuarios->where('run',$request->userId)->first();
			
			if (is_null($usuario)){
				Log::error('error: run no existe');
				return response()->json([false,'run no existe']);
			}
			
			if ($usuario->token != $request->token){
				Log::error('error: token no coincide');
				return response()->json([false,'token no coincide']);
			}
			
			if ($usuario->expires_at->lt(now())){
				Log::error('error: token expirado');
				return response()->json([false,'token expirado']);
			}
			
			return response()->json(true);
		} catch(\Exception $e) {
			Log::error('error: '.$e);
			return response()->json([false,'ha ocurrido un error']);
		}
	}
}
