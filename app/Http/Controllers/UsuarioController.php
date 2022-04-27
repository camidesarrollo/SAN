<?php

namespace App\Http\Controllers;

use App\Services\ApiMdsService;
use Auth;
use Session;
use Illuminate\Http\Request;
use DB;
use App\Modelos\{Parametro, Perfil, Usuarios};
use App\Http\Controllers\TransversalController;
use Illuminate\Support\Facades\Log;
use DataTables;

class UsuarioController extends Controller
{
	protected $usuarios;
	
	protected $perfil;
	
	protected $parametro;
	
	protected $api_mds;

	public function __construct(
		Usuarios		$usuarios,
		Perfil			$perfil,
		Parametro		$parametro,
		ApiMdsService	$api_mds
	) {
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->usuarios		= $usuarios;
		$this->perfil		= $perfil;
		$this->parametro	= $parametro;
		$this->api_mds		= $api_mds;
	}

	//ai
	
	/**
	 * Genera vista de usuarios
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function listar(){
		return view('.administrador.usuarios.listar');
	}
	
	/**
	 * Genera el json para la grilla de usuarios
	 * @return mixed
	 */
	function apiGetUsuario(){
		$usuarios = $this->usuarios->with('perfil')
			->select(
				'id',
				'run',
				'nombres',
				'apellido_paterno',
				'apellido_materno',
				'id_perfil',
				'id_region',
				'id_estado',
				'id_institucion'
			);
		
		return Datatables::of($usuarios)
			->addColumn('nombre_estado', function ($usuario) {
				if ($usuario->id_estado==1){
					return 'Activo';
				} else {
					return 'Inactivo';
				}
			}, true)
			->make();
	}
	
	/**
	 * Muestra formulario para editar o crear un usuario
	 * @param int $id = id del usuario, -1 para crear
	 * @return mixed
	 */
	public function showFormGrabar($id=-1){
		
		// consumir servicio rest para las regiones
		//$lstRegion = TransversalController::getRegiones();
		$lstRegion = $this->api_mds->getRegiones();
		
		$lstPerfil = $this->perfil->getActivos();
		
		// consumir servicio rest para las getInstituciones
		$lstInstitucion = TransversalController::getInstitucionesDummy();
		
		$lstEstado =  $this->parametro->getEstados();
		
		if($id==-1) {
			$oUsuario = $this->usuarios;
		} else {
			$oUsuario = $this->usuarios->find($id);
		}
		
		return view('administrador.usuarios.grabar')
			->with([
				'id'				=> $id,
				'lstRegion'			=> $lstRegion,
				'lstPerfil'			=> $lstPerfil,
				'lstInstitucion'	=> $lstInstitucion,
				'oUsuario'			=> $oUsuario,
				'lstEstado'			=> $lstEstado
			]);
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function aGrabar(Request $request){
		try {
			DB::beginTransaction();
			
			//$data = $request->validate($this->reglas_update,[], $this->nombres);

			if ($request->input('run')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Rut del usuario.'));
			}
			if ($request->input('nombres')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Nombre del usuario.'));
			}
			if ($request->input('apellido_paterno')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Apellido Paterno del usuario.'));
			}
			if ($request->input('apellido_materno')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Apellido Materno del usuario.'));
			}
			/*if ($request->input('telefono')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Teléfono del usuario.'));
			}*/
			if ($request->input('email')==''){
				return response()->json(array('estado' => '0', 'msg' => 'Debe ingresar el Email del usuario.'));
			}
			if ($request->input('id_region')==0){
				return response()->json(array('estado' => '0', 'msg' => 'Debe seleccionar la Región del usuario.'));
			}
			if ($request->input('id_institucion')==0){
				return response()->json(array('estado' => '0', 'msg' => 'Debe seleccionar la Institución del usuario.'));
			}
			if ($request->input('id_perfil')==0){
				return response()->json(array('estado' => '0', 'msg' => 'Debe seleccionar el Perfil del usuario.'));
			}
			if ($request->input('id_estado')==0){
				return response()->json(array('estado' => '0', 'msg' => 'Debe seleccionar el Estado del usuario.'));
			}
			
			$params = array('soap_version' => SOAP_1_2,
				'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
				'encoding' => 'UTF-8', 'trace' => 1,
				'exceptions' => true,
				'cache_wsdl' => WSDL_CACHE_NONE,
				'features' => SOAP_SINGLE_ELEMENT_ARRAYS);
			$sso = new \SoapClient(env('SSO_WS'), $params);
			
			if($request->input('id')==-1)
			{
				$rut_completo = TransversalController::eliminar_simbolos($request->input('run'));
				$userSSO = $sso->BuscarUsuario(array('rut' => $rut_completo, 'AID' => env('SSO_AID')));
				if ($userSSO->BuscarUsuarioResult->Cantidad == 0):
					//CREA USUARIO Y ASIGNA ROLES A USUARIO
					try {
						//crear un usuario eln el sso y AD
						$crearUsuarioSSO = $sso->CrearUsuario(array(
							'Usuario' => array(
								'Nombre'		=> $request->input('nombres'),
								'Habilitado'	=> 'true',
								'Correo'		=> $request->input('email'),
								'Clave'			=> $this->generarClave(),
								'RUT'			=> $rut_completo),
								'AID'			=> env('SSO_AID'))
						);
						
						if($request->input('id_estado')==1){
							$asignaRolUserSSO = $sso->AsignarRoles(array(
								'rut' => $request->input('run'),
								'roles' => array('int' => env('SSO_ROL')),
								'AID' => env('SSO_AID')));
						} elseif ($request->input('id_estado')==2){
							$asignaRolUserSSO = $sso->EliminarUsuario(array('rut' => $rut_completo, 'AID' => env('SSO_AID')));
						}
					} catch (Exception $e) {
						DB::rollback();
						return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al crear el usuario en SSO.'));
					}
				else:
					//ASIGNA ROLES A USUARIO

					try {
						 if($request->input('id_estado')==1){
							$asignaRolUserSSO = $sso->AsignarRoles(array('rut' => $rut_completo, 'roles' => array('int' => env('SSO_ROL')), 'AID' => env('SSO_AID')));
						}
						if($request->input('id_estado')==2){
							$asignaRolUserSSO = $sso->EliminarUsuario(array('rut' => $rut_completo, 'AID' => env('SSO_AID')));
						}
					} catch (Exception $e) {
						DB::rollback();
						return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al asignar roles al usuario en SSO.'));
					}
				endif;
				
				//insert
				$rut_completo = TransversalController::eliminar_simbolos($request->input('run'));
				$rut_completo = substr($rut_completo, 0, -2);
				$oUsuario = new Usuarios();
				$oUsuario->fill($request->all());
				$oUsuario->run = $rut_completo;
				
				$resultado = $oUsuario->save();
				if(!$resultado){
					DB::rollback();
					return response()->json(array('estado' => '0', 'msg' => 'Error: No se grabo el usuario.'));
				}
				
				DB::commit();
				return response()->json(array('estado' => '1', 'msg' => ' Se grabó correctamente el usuario.'));
			}
			else {
				$rut_completo = TransversalController::eliminar_simbolos($request->input('run'));
				$userSSO = $sso->BuscarUsuario(array('rut' => $request->input('run'), 'AID' => env('SSO_AID')));
				if ($userSSO->BuscarUsuarioResult->Cantidad == 0){
					//crear un usuario en el sso y AD
					
					if($request->input('id_estado')==1){
						$asignaRolUserSSO = $sso->AsignarRoles(array('rut' => $rut_completo, 'roles' => array('int' => env('SSO_ROL')), 'AID' => env('SSO_AID')));

						if($asignaRolUserSSO->AsignarRolesResult->Estado != 1){
							DB::rollback();
							return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al asignar roles al usuario en SSO.'));
						}
					}
					if($request->input('id_estado')==2){
						$asignaRolUserSSO = $sso->EliminarUsuario(array('rut' => $rut_completo, 'AID' => env('SSO_AID')));
						if($asignaRolUserSSO->EliminarUsuarioResult->Estado != 1){
							DB::rollback();
							return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al desasignar roles al usuario en SSO.'));
						}
					}
				}
				else
				{
					//ASIGNA ROLES A USUARIO
					try {
						if($request->input('id_estado')==1){
							$asignaRolUserSSO = $sso->AsignarRoles(array('rut' => $rut_completo, 'roles' => array('int' => env('SSO_ROL')), 'AID' => env('SSO_AID')));

							if($asignaRolUserSSO->AsignarRolesResult->Estado != 1){
								DB::rollback();
								return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al asignar roles al usuario en SSO.'));
							}

						}
						if($request->input('id_estado')==2){
							$asignaRolUserSSO = $sso->EliminarUsuario(array('rut' => $rut_completo, 'AID' => env('SSO_AID')));
							if($asignaRolUserSSO->EliminarUsuarioResult->Estado != 1){
								DB::rollback();
								return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al desasignar roles al usuario en SSO.'));
							}
						}

					} catch (Exception $e) {
						DB::rollback();
						return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al asignar roles al usuario en SSO.'));
					}
				}

				//update
				$rut_completo = TransversalController::eliminar_simbolos($request->input('run'));
				$rut_completo = substr($rut_completo, 0, -2);
				//$save = Usuarios::where('id',$request->input('id'))->update(['run' => $rut_completo,'nombres' => $request->input('nombre'),'apellido_paterno' => $request->input('apellidoP'),'apellido_materno' => $request->input('apellidoM'),'telefono' => $request->input('telefono'),'email' => $request->input('email'),'id_estado' => $request->input('id_estado'),'id_region' => $request->input('reg_id'),'id_perfil' => $request->input('id_perfil'),'id_institucion' => $request->input('id_institucion')]);
				$save = Usuarios::find($request->input('id'))
					->fill($request->except('run'))->save();

				if($save){
					DB::commit();
					//generar nueva clave
					$pass_nueva = $this->generarClave();
					Log::info('clave: '.$pass_nueva);

					$generarPassSSO = $sso->CambiarClave(array('rut' => $rut_completo,'claveNueva' => $pass_nueva, 'AID' => env('SSO_AID')));
					if($generarPassSSO){
						$crearUsuarioSSO = $sso->CrearUsuario(array('Usuario' => array('Nombre' => Session::get('nombre_usuario'),'Habilitado' => 'true','Correo' => Session::get('email_usuario'),'Clave' => $pass_nueva,'RUT' => $rut_completo),'AID' => env('SSO_AID')));
						return response()->json(array('estado' => '1', 'msg' => 'Se grabo correctamente el usuario.'));

					}else{
						DB::rollback();
						return response()->json(array('estado' => '0', 'msg' => 'Error: No se grabo el usuario.'));
					}
				}else{
					DB::rollback();
					return response()->json(array('estado' => '0', 'msg' => 'Error: No se grabo el usuario.'));
				}
			}
		}catch (Exception $ex)
		{
			DB::rollback();
			return response()->json(array('estado' => '0', 'msg' => 'Error: No se grabo el usuario.'));
		}
	}
	
	/**
	 * @return array|bool|string
	 */
	static function generarClave()
	{
		$clave = substr(str_shuffle(implode(range('a', 'z'))), 0, 5);
		$i = rand(0, 4);
		$clave = str_split($clave);
		$clave[$i] = strtoupper($clave[$i]);
		$clave = implode($clave);
		$digitos = substr(str_shuffle(implode(range('0', '9'))), 0, 3);
		$clave = $clave . '.' . $digitos;
		return $clave;
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	function aPass(Request $request)
	{
		$params = array('soap_version' => SOAP_1_2, 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP, 'encoding' => 'UTF-8', 'trace' => 1, 'exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'features' => SOAP_SINGLE_ELEMENT_ARRAYS);
		$sso = new \SoapClient(env('SSO_WS'), $params);
		
		try {
			//generar nueva clave
			$pass_nueva = $this->generarClave();
			$generarPassSSO = $sso->CambiarClave(array('rut' => Session::get('rut_usuario'),'claveActual' => $request->input('pass_actual'),'claveNueva' => $pass_nueva, 'AID' => env('SSO_AID')));
			if($generarPassSSO)
			{
				$crearUsuarioSSO = $sso->CrearUsuario(array('Usuario' => array('Nombre' => Session::get('nombre_usuario'),'Habilitado' => 'true','Correo' => Session::get('email_usuario'),'Clave' => $pass_nueva,'RUT' => Session::get('rut_usuario')),'AID' => env('SSO_AID')));
				
				return response()->json(array('estado' => '1', 'msg' => 'Se ha generado una nueva contraseña, enviada por correo electrónico a la dirección que usted ingresó al momento de registrarse.'));
			}else
			{
				return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al generar la contraseña para el usuario en SSO.'));
			}
		} catch (Exception $e)
		{
			DB::rollback();
			return response()->json(array('estado' => '0', 'msg' => 'Error: Problema al generar la contraseña para el usuario en SSO.'));
		}
	}




}
