<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
//CZ SPRINT 74
use App\Modelos\{Usuarios, Perfil, Region, NotificacionAsignacion};

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('index');
	}
	
	public function index(){
		if (!Auth::check()) {
			return view('layouts.login');
		}else{
			return redirect()->route('main');
		}
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function main(){
		$tipo_perfil = session('tipo_perfil');

		if (count(session()->all()["comunas"]) > 1 && session()->all()["configurar_comuna"] == true){
			return view('layouts.configuracion_comuna');

		}else{
			if (view()->exists('dashboard.'.$tipo_perfil)){
				$codigocomuna = session('com_cod');
			
				$region = Region::leftjoin('ai_provincia', 'ai_region.reg_id', '=', 'ai_provincia.reg_id')
						->leftjoin('ai_comuna', 'ai_provincia.pro_id', '=', 'ai_comuna.pro_id')->where('ai_comuna.com_cod',session('com_cod'))->get();
						session()->put("region",$region[0]->reg_id);
				
				if(session()->all()['perfil'] == config('constantes.perfil_gestor') || session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
					$cantidad = NotificacionAsignacion::cantidadNotificaciones();
					$cantidad_asignacion = NotificacionAsignacion::CantnotificacionesAsignacion();
					// $notificacionesToaster = NotificacionAsignacion::notificacionAsignacionToastr();
					$nowlogin = true;
					
				}else{
					$cantidad = 0;
					$cantidad_asignacion = 0;
					$cantidad_tiempo_intervencion = 0;
					$tiempoIntervencion = 0;
					$nowlogin = false;
				}
				session()->put("cantidad",$cantidad);
				session()->put("cantidad_asignacion",$cantidad_asignacion);
				session()->put("nowlogin",$nowlogin);
				
				return view('dashboard.'.$tipo_perfil);
			
			}else{
				$codigocomuna = session('com_cod');


				if(session()->all()['perfil'] == config('constantes.perfil_gestor') || session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
					$cantidad = NotificacionAsignacion::cantidadNotificaciones();
					$cantidad_asignacion = NotificacionAsignacion::CantnotificacionesAsignacion();
					// $notificacionesToaster = NotificacionAsignacion::notificacionAsignacionToastr();
					$nowlogin = true;
					
				}else{
					$cantidad = 0;
					$cantidad_asignacion = 0;
					$cantidad_tiempo_intervencion = 0;
					$tiempoIntervencion = 0;
					$nowlogin = false;
				}
				session()->put("cantidad",$cantidad);
				session()->put("cantidad_asignacion",$cantidad_asignacion);
				session()->put("nowlogin",$nowlogin);
			
				$region = Region::leftjoin('ai_provincia', 'ai_region.reg_id', '=', 'ai_provincia.reg_id')
						->leftjoin('ai_comuna', 'ai_provincia.pro_id', '=', 'ai_comuna.pro_id')->where('ai_comuna.com_cod',session('com_cod'))->get();
				session()->put("region",$region[0]->reg_id);
				// FIN CZ SPRINT 71
				return view('layouts.main');
			
			}
		}
	}

}
