<?php
namespace App\Http\Controllers;
use Auth;
use Session;
use Illuminate\Http\Request;
use DB;
use SoapClient;
use App\Modelos\{Usuarios, Perfil, Region, NotificacionAsignacion};

class LoginController extends Controller
{
	protected $usuario;
	
	protected $perfil;
	
	protected $region;
	
	public function __construct(
		Usuarios	$usuario,
		Perfil		$perfil,
		Region		$region
	)
	{
		$this->middleware('auth')->only('logout');
		$this->usuario				= $usuario;
		$this->perfil				= $perfil;
		$this->region				= $region;
	}
	
	public function index(Request $request){
		if (!Auth::check()) {
			$t = $request->get("t");

			if (!$t) {
				return redirect()->away(config('constantes.sso_url') . "?AID=" . config('constantes.sso_aid'));
			} else {
				if (strlen($t) > 15) {
					try {
						$ws = @new SoapClient(config('constantes.sso_ws'), array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => true,));
					} catch (Exception $e) {
						echo $e->getMessage();
						exit;
					}

					$r = $ws->autorizar(array('token' => $t));

					if ($r->AutorizarResult) {
						if ($r->AutorizarResult->Estado == 1) {
							// formato rut es: 15224092-9
							$rut = $r->AutorizarResult->Usuario->RUT;

							//separo el rut del dv
							$run_dv = explode("-", $rut);
							$run = $run_dv[0];

							$usuario = $this->usuario->where('run', $run)->first();

							if (count($usuario) == 0) {
								return "ERROR: Error: No Autorizado 1 (no existe en BD el RUT)";
							}
							else {
								/* logeamos usando laravel auth */

								//dd($usuario);
								Auth::login($usuario); //return null
								
								$oPerfil	= $this->perfil->find($usuario->id_perfil);
								$token		= $this->usuario->getToken();
								
								$comunas = $usuario->comunas()->where('oln', 'S')->where('vigencia', 1)->get();
								$comuna = $comunas->first();
								$region = $this->region->where('reg_cod',$usuario->id_region)->first();

								$com_cod="";
								$com_id="";
								$cont=0;

								foreach ($comunas as $comuna ) {
									if($cont==0){
										$com_cod = $comuna->com_cod;
										$com_id = $comuna->com_id;
										$cont=1;
									}
									else{
										$com_cod = $com_cod.",".$comuna->com_cod;
										$com_id = $com_id.",".$comuna->com_id;
									}
								}

								//dd("Codigos:".$com_cod."Ids:".$com_id);
								$accion_menu=0;

								$request->session()->put([
									"token_usuario"		=> $token,
									"id_usuario"		=> $usuario->id,
									"rut_usuario"		=> $usuario->run,
									"rut"				=> $usuario->rut,
									"email_usuario"		=> $usuario->email,
									"nombre_usuario"	=> $usuario->nombre,
									"perfil"			=> $oPerfil->cod_perfil,
									"nombre_perfil"		=> $oPerfil->nombre,
									"tipo_perfil"		=> $oPerfil->tipo,
									"accion_menu"		=> $accion_menu,
									"region"			=> "",//$region->reg_nom,
									"comunas"			=> $comunas,
									"comuna"			=> $comuna->com_nom,
									"com_cod"			=> $com_cod,
									"com_id"			=> $com_id,
									"configurar_comuna" => false
								]);

								$menupri = $this->perfil->MenuPri($usuario->id_perfil);

								//dd($comunas);

								$request->session()->put("menupri",$menupri);

								$lstFunciones = $this->perfil->funciones($usuario->id_perfil);
								$request->session()->put("funciones",$lstFunciones);


								// PERMISO DE EDICION
								$permisos = array();
								$request->session()->put("editar", false);
								$editar = $this->perfil->permisos($usuario->id_perfil, 'edicion');		
								if (count($editar) > 0){
									array_push($permisos, $editar[0]);
									$request->session()->put("editar", true);	
								
								} 

								// PERMISO DE VISUALIZAR
								$request->session()->put("visualizar", false);
								$visualizar = $this->perfil->permisos($usuario->id_perfil, 'visualizacion');	
								if (count($visualizar) > 0){
									array_push($permisos, $visualizar[0]);
									$request->session()->put("visualizar", true);	
								
								} 

								// TODOS LOS PERMISOS	
								$request->session()->put("permisos", $permisos);

								if (count(session()->all()["comunas"]) > 1) $request->session()->put("configurar_comuna", true);

								return redirect()->route('main');
								
							}
						} else {
							echo "ERROR: No autorizado, ha ocurrido un error en la autenticación del usuario.";
						}
					} else {
						return redirect()->away(config('constantes.sso_url') . "?AID=" . config('constantes.sso_aid'));
					}
				}
			}
		}
		else {
			return redirect()->route('main');
		}
	}

	public function logout(Request $request) {
		$request->user()->destroyToken();
		Auth::logout();
		$request->session()->flush();
		
		Session::flush();

		//setcookie("estadoMenu");
		
		return redirect()->to(config('constantes.sso_url')."/libre/salir.aspx");
	}

	public function AplicarConfiguracionDeComuna(Request $request){
		$tipo_perfil = session('tipo_perfil');
		$indice = $request->comuna_seleccionada;
		$comuna = session()->all()["comunas"];

		$request->session()->put("comuna",	$comuna[$indice]->com_nom);
		$request->session()->put("com_cod",	$comuna[$indice]->com_cod);
		$request->session()->put("com_id",	$comuna[$indice]->com_id);
		$request->session()->put("configurar_comuna", false);

		$codigocomuna = session('com_cod');
		$region = Region::leftjoin('ai_provincia', 'ai_region.reg_id', '=', 'ai_provincia.reg_id')
						->leftjoin('ai_comuna', 'ai_provincia.pro_id', '=', 'ai_comuna.pro_id')->where('ai_comuna.com_cod',session('com_cod'))->get();
		
		$request->session()->put("region",$region[0]->reg_id);
		
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
		
		if (view()->exists('dashboard.'.$tipo_perfil)){
			return view('dashboard.'.$tipo_perfil);
			
		}else{
			return view('layouts.main');
			
		}
	}
	

}