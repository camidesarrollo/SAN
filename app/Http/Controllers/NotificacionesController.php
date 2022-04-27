<?php

namespace App\Http\Controllers;

use App\Modelos\{Notificaciones, Caso, Usuarios};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Session;

class NotificacionesController extends Controller
{
	protected $notificaciones;
	
	public function __construct(
		Notificaciones  $notificaciones,
		Caso			$caso,
		Usuarios		$usuario
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->notificaciones       = $notificaciones;
		$this->caso					= $caso;
		$this->usuario				= $usuario;
	}
	
	/**
	 * Muestra la Vista de la Agenda
	 * @param null $caso
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function Notificaciones(request $request){
		try{
			$respuesta = true;
			DB::beginTransaction();
			
			switch ($request->option){
				case 1: //CONTAR CANTIDAD DE NOTIFICACIONES
				    $respuesta = DB::select("SELECT COUNT(*) AS cantidad FROM ai_notificaciones WHERE usu_id =".session()->all()['id_usuario']." AND not_est = 1");
					
				break;
				
				case 2: //OBTENER NOTIFICACIONES
					$respuesta = DB::select("SELECT * FROM ai_notificaciones n LEFT JOIN ai_persona p ON n.per_id = p.per_id
												WHERE n.usu_id = ".session()->all()['id_usuario']." AND n.not_est = 1");
				
				break;
				
				case 3: //CAMBIAR ESTADO NOTIFICACIONES
                     $notificaciones = Notificaciones::where("not_id", "=", $request->not_id)->first();
					 $notificaciones->not_est = 0;
					 $resultado = $notificaciones->save();
				
					 if (!$resultado){
						 DB::rollBack();
						 $mensaje = "Error al momento de actualizar el estado de la notificación. Por favor intente nuevamente.";
						 return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
					 }
				break;
				
			}
			
			DB::commit();
			
			return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
		}catch (\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
			
		}
	}
	
}
