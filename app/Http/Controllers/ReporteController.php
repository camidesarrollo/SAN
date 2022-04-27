<?php

namespace App\Http\Controllers;
use App\Exports\reportes\AlertasTerritorialesPorComunaExport;
use App\Exports\reportes\AlertasTerritorialesPorNnaExport;
use App\Exports\reportes\AlertasChileCreceContigoExport;
use App\Exports\reportes\RutAsignadoGestorExport;
use App\Exports\reportes\RutAsignadoTerapeutaExport;
use App\Exports\reportes\CasosDesestimadosGestorExport;
use App\Exports\reportes\CasosDesestimadosTerapeutaExport;
use App\Exports\reportes\EstadoActividadGestionCasoExport;
use App\Exports\reportes\MapaOfertasExport;
use App\Exports\reportes\EstadoAvanceExport;
use App\Exports\reportes\EstadoAvanceTerapiaExport;
use App\Exports\reportes\AlertasTerritorialesInfoTipoAlertaExport;
use App\Exports\reportes\EstadoSeguimientoGestionCasosExport;
use App\Exports\reportes\EstadoSeguimientoGestionTerapiasExport;
use App\Exports\reportes\GestionCasoTerapiaExport;
use App\Exports\reportes\AlertasTerritorialPorPrioridadExport;
use App\Exports\reportes\descargarrptDetalleAlertasTerritorialesExport;
use App\Exports\reportes\descargarrptDetalleAlertasChccExport;
use App\Exports\reportes\descargarrptMapaOfertaBrechaExport;
use App\Exports\reportes\descargarAlertasTerritorialesExport;
use App\Exports\reportes\descargarIntervencionesExport;
use App\Exports\reportes\descargarUsuarioPorPerfilExportable;
use App\Exports\reportes\descargarUsuarioPorOlnExportable;
use App\Exports\reportes\descargarReportesObjetivosTareasExportable;
use App\Exports\reportes\descargarReportesResultadosNcfasExportable;
use App\Exports\reportes\descargarReportesIntegrantesGfamiliarExportable;
use App\Exports\reportes\descargarReportesRespuestasTerapiafamiliarExportable;
use App\Exports\reportes\descargarExcelPrueba;
use App\Exports\reportes\descargarGestionComunitariaBitacora;
use App\Exports\reportes\descargarPlanComunalBitacora;
use App\Exports\reportes\descargarGestionComunitariaDocumentos;
use App\Exports\reportes\descargarPlanComunalDocumentos;
use App\Exports\reportes\descargaLineaBaseExport;
use App\Exports\reportes\descargarGestionComunitariaEtapas;
use App\Exports\reportes\descargarTiemposIntervencion;
use App\Exports\reportes\descargarTiemposIntervencionTF;
use DB;
use DataTables;
use App\Modelos\AlertaManual;
use App\Modelos\AlertaTipo;
use App\Modelos\Caso;
use App\Modelos\Terapia;
use App\Modelos\Perfil;
use App\Modelos\Usuarios;
// CZ SPRINT 76
use App\Modelos\CasosGestionEgresado;
// CZ SPRINT 76
// INICIO CZ SPRINT 72
use App\Modelos\UsuarioComuna;
// FIN CZ SPRINT 72
use App\Modelos\Sesion;
use App\Modelos\Programa;
use App\Modelos\NNAAlertaManualCaso;
use App\Modelos\EstadoCaso;
use App\Modelos\EstadoTerapia;
use App\Modelos\Funcion;
use App\Modelos\Predictivo;
use App\Modelos\AlertaChileCreceContigo;
use App\Modelos\UsuarioProceso;
use App\Modelos\LineaBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
// INICIO CZ SPRINT 70
use App\Exports\reportes\descargaLineaBaseExport_2021;
// FIN CZ SPRINT 70

class ReporteController extends Controller
{
	protected $usuario;
	protected $perfil;

	public function __construct(
		Usuarios			$usuario,
		Perfil              $perfil
	)
	{
		$this->usuario				= $usuario;
		$this->perfil				= $perfil;
	}
	public function mainReportes(){
		$acciones = $this->perfil->acciones();
		//dd(session()->all()["perfil"]);

		/*echo('perfil: '.session()->all()["perfil"]);
		echo('id_usu: '.session()->all()["id_usuario"]);
		echo('comuna_sel: '.session()->all()["com_cod"]);*/
		/*foreach(session()->all()["comunas"] AS $c1 => $v1)
			echo($v1->com_id.' nom: '.$v1->com_nom);*/
		
		//echo('id_usu: '.session()->all()["id_usuario"]);	
		$icono = Funcion::iconos(162);

		return view('reportes.main_reportes', 
			[
				'acciones' => $acciones,
				'icono' => $icono,
				'comuna_ingresada' => session()->all()["com_cod"],
				'perfil_usuario'	=> session()->all()["perfil"]
			]);
	}

	public function mainDescargar(){
		$acciones = $this->perfil->acciones();

		$icono = Funcion::iconos(200);

		return view('reportes.main_descargar', 
			[
				'acciones' => $acciones,
				'icono' => $icono
			]);
	}
	public function mainGestionUsuarios(){
		$acciones = $this->perfil->acciones();

		$icono = Funcion::iconos(199);

		return view('reportes.main_gestion_usuarios', 
			[
				'acciones' => $acciones,
				'icono' => $icono
			]);
	}

	public function mainUsuariosPerfil(){
		$acciones = $this->perfil->acciones();
		//dd(session()->all()["perfil"]);

		$icono = Funcion::iconos(162);

		return view('reportes.main_usuario_perfil', 
			[
				'acciones' => $acciones,
				'icono' => $icono
			]);
	}

	public function mainUsuariosOln(){
		$acciones = $this->perfil->acciones();
		//dd(session()->all()["perfil"]);

		$icono = Funcion::iconos(162);

		return view('reportes.main_usuario_oln', 
			[
				'acciones' => $acciones,
				'icono' => $icono
			]);
	}
	
	public function gestionarUsuariosOln(){
	    $acciones = $this->perfil->acciones();
	    //dd(session()->all()["perfil"]);
	    //
	    $icono = Funcion::iconos(162);
	    // CZ SPRINT 75
	    return view('administrador.usuario.gestionar_Usuarios_oln',
	        [
	            'acciones' => $acciones,
	            'icono' => $icono
	        ]);
	}
	
	public function getComunasUsuario(Request $request){
	    $result = DB::select("select distinct uc.com_id, c.com_nom 
        from ai_usuario_comuna uc
        inner join ai_comuna c
        on uc.com_id = c.com_id
		inner join ai_provincia t6 on c.pro_id = t6.pro_id
        inner join ai_region t7  on t6.reg_id = t7.reg_id	
        where uc.vigencia = 1 and uc.usu_id = ".$request->id."
		and t7.reg_cod = ".$request->region."
        order by c.com_nom asc");
	    
	    echo json_encode($result); exit;
	}
	
	//INICIO DC SPRINT 66
	
	public function getComunas(Request $request){
		//INICIO CZ SPRINT 72
		if(!isset($request->region)){
	    $result = DB::select("select com_id, com_nom from ai_comuna comuna
        inner join ai_provincia prov
        on comuna.pro_id = prov.pro_id
			where comuna.oln = 'S' order by com_nom asc");
			return $result;
			
		}else{

			$result = DB::select("select com_id, com_nom from ai_comuna comuna
			inner join ai_provincia prov
			on comuna.pro_id = prov.pro_id
			inner join ai_region 
			on prov.reg_id = ai_region.reg_id
			where comuna.oln = 'S' and ai_region.reg_cod ={$request->region} order by com_nom asc");
			return $result;

			
		}
	   
	}	
	    
	public function getRegion(){
		$result = DB::select("select * from ai_region where reg_cod in(select  reg_cod from ai_comuna comuna
        inner join ai_provincia prov
        on comuna.pro_id = prov.pro_id
        inner join ai_region on prov.reg_id = ai_region.reg_id
        where comuna.oln = 'S') order by reg_cod ");
		return $result;
	}
	
	
	public function getInstituciones(Request $request){
	    $result = DB::select("select id_ins, nom_ins from ai_institucion order by nom_ins asc");
	    return $result;
	}
	
	public function verificarCasos(Request $request){
		// CZ SPRINT 76
		$usuario = Usuarios::find($request->id);
		$desde_terapia = 0;
		if ($usuario->id_perfil  == config('constantes.perfil_gestor')){
			// CZ SPRINT 74
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))
			->where('est_cas_fin','<>',1)
			// CZ SPRINT 75
			->where('usuario_id', '=',$request->id)->where('vigencia', 1)->groupBy('cas_id')->get();
			// CZ SPRINT 74
			$cantidad_casos = count($cantidad_casos);

		}else if ($usuario->id_perfil  == config('constantes.perfil_terapeuta')){
			// CZ SPRINT 74
			$cantidad_casos = CasosGestionEgresado::select('cas_id', DB::raw('count(cas_id) AS total'))
				->where('ter_id', '=',$request->id)
				->where('est_tera_fin', '<>', 1)
				// CZ SPRINT 75
				->where('vigencia', 1)
				->where(function ($query) {
					$query->where('est_cas_fin', '<>', 1);
					$query->orwhere('es_cas_id', '=', 7);
				})
				->groupBy('cas_id')->get();
			

			$cantidad_casos = count($cantidad_casos);
		}else{
			$cantidad_casos = 0;
		}

	    return $cantidad_casos;
		// CZ SPRINT 76
	}
	//INICIO DC SPRINT 67
	public function addInstitucion(Request $request){
		
		$array_intitucion = DB::select("SELECT TRANSLATE(UPPER(NOM_INS),'ÁÉÍÓÚ','AEIOU') as nombre_inst FROM ai_institucion");
		$nombre_intitucion = strtoupper($this->eliminar_acentos($request->nomInst));
		$needleField =  'nombre_inst';
		if (!in_array($nombre_intitucion, array_column($array_intitucion, $needleField))){
	    $result = DB::insert("insert into ai_institucion(id_ins, nom_ins)
        values((select max(id_ins) + 1 from ai_institucion), '".$request->nomInst."')");
	    if($result){
	        $mensaje = "Institucion ingresada.";
	        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	    }else{
	        $mensaje = "Ha ocurrido un error.";
	        return response()->json(array('estado' => '-1', 'mensaje' => $mensaje), 200);
	    }
		}else{
			$mensaje = "La institucion ingresada ya se encuentra dentro del listado.";
				return response()->json(array('estado' => '-1', 'mensaje' => $mensaje), 200);
		}

	   
	}

	public function addVigenciaSSO(Request $request){
	    $consulta = [
	        'rut' => $request->rut,
	        'roles' => [
	            'int' => config('constantes.sso_rol')
	        ],
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->AsignarRoles($consulta);
	    $respuesta = $respuesta->AsignarRolesResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	}
	
	public function vigenciaSSO(Request $request){
	    $consulta = [
	        'rut' => $request->rut, 
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->EliminarUsuario($consulta);
	    $respuesta = $respuesta->EliminarUsuarioResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	}
	//FIN DC SPRINT 67
	public function verSSO(Request $request){
	    $consulta = ['rut' => $request->rut, 'AID' => config('constantes.sso_aid')];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->BuscarUsuario($consulta);
	    $respuesta = $respuesta->BuscarUsuarioResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	}
	//INICIO DC SPRINT 68
	public function actualizarPass(Request $request){
	    $consulta = [
	        'rut' => $request->rut, 
	        'claveActual' => $request->passactual,
	        'claveNueva' => $request->passnew,
	        'AID' => config('constantes.sso_aid')	        
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->CambiarClave($onsulta);
	    $respuesta = $respuesta->CambiarClaveResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	}
	//FIN DC SPRINT 68
	//INICIO CZ SPRINT 72
	function eliminar_acentos($cadena){
	    
		//Reemplazamos la A y a
	    $cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
	        $cadena
	        );
	    
		//Reemplazamos la E y e
	    $cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
	        $cadena );
	    
		//Reemplazamos la I y i
	    $cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
	        $cadena );
	    
		//Reemplazamos la O y o
	    $cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
	        $cadena );
	    
		//Reemplazamos la U y u
	    $cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
	        $cadena );
	    
		//Reemplazamos la N, n, C y c
	    $cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
	        $cadena
	        );
	    
	    return $cadena;
	}
	// FIN CZ SPRINT 72
	public function guardarSSO(Request $request){
	    //Genera clave
	    //Reemplaza acentos
		//INICIO CZ SPRINT 72
	    $cadena =$request->apePat;
	    
		$cadena = $this->eliminar_acentos($cadena);
		//FIN CZ SPRINT 72
	    $clave1 = substr($cadena, 0, 3);
	    $clave2 = substr($request->rut, 0, 4);
	    $clave = ucfirst(strtolower(strrev($clave1))).'.'.$clave2;
		//INICIO CZ SPRINT 72
		if($clave != $request->clave){
			$clave = $request->clave;
		}
		//FIN CZ SPRINT 72
	    //Ingresa usuario al SSO
	    $consulta = [
	        'Usuario' => [
	            'Clave' => $clave,
	            'Correo' => $request->mail,
	            'Habilitado' => 1,
	            'Nombre' => $request->nombres.' '.$request->apePat.' '.$request->apeMat,
	            'Path' => '',
	            'Roles' => [
	                'Rol' => [
	                    'ID' => config('constantes.sso_rol'),
	                    'Id_Aplicacion' => config('constantes.sso_aplicacion'),
	                    'Nombre' => ''
	                ]
	            ],
	            'RUT' => $request->rut,
	            'Tipo' => ''
	        ],
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->CrearUsuario($consulta);
	    $respuesta = $respuesta->CrearUsuarioResult;
	    //Asigna roles en SSO
	    $consulta = [
	        'rut' => $request->rut,
	        'roles' => [
	            'int' => config('constantes.sso_rol')
	        ],
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta2 = $cliente->AsignarRoles($consulta);
	    $respuesta2 = $respuesta2->AsignarRolesResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta2), 200);
	}
	//FIN DC SPRINT 67
	
	public function editarUsuario(Request $request){
		//INICIO CZ SPRINT 72
		//BUSCAR USUARIO EN EL SSO
		$consulta = ['rut' => $request->rut, 'AID' => config('constantes.sso_aid')];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuestaServicio = $cliente->BuscarUsuario($consulta);
	    $respuesta =  $respuestaServicio ->BuscarUsuarioResult;
		if($respuestaServicio->BuscarUsuarioResult->Cantidad > 0){ //ENCUENTRA USUARIO EN EL SSO 
			
			if(is_object($respuesta->Resultado->Usuario) == 1 ){ //OBTENER CORREO SI EL USUARIO EXISTE UNA SOLA VEZ
				$email = $respuesta->Resultado->Usuario->Correo;
				$nombre = $respuesta->Resultado->Usuario->Nombre;
			}else if(is_array($respuesta->Resultado->Usuario) == 1 ){ //OBTENER CORREO SI EL USUARIO EXISTE MAS DE UNA VEZ EN EL SSO 
				$email = $respuesta->Resultado->Usuario[0]->Correo;
				$nombre = $respuesta->Resultado->Usuario[0]->Nombre;
			}
	    
			if($email == $request->mail){//CORREO ES IGUAL AL CORREO DEL SERVICIO NO SE CAMBIA
				$usuario = Usuarios::find($request->id);
				if(count($usuario)>0){
					$usuario->telefono = $request->fono;
					$usuario->email = $request->mail;
					$usuario->id_institucion = $request->institucion;
					$usuario->id_perfil = $request->perfil;
					$usuario->id_estado = $request->estado;
					$respuesta = $usuario->save(); 
					if (!$respuesta){
						$mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
						return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
					}else{
						return response()->json(array('estado' => 0, 'mensaje' => 'Usuario editado correctamente'), 200);
					}
				}else{
					$mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
					return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
				}
				
			}else{ //EL CORREO ES DIFERENTE AL DEL SERVICIO, SE DEBE CAMBIAR
				$consulta = [
					'Usuario' => [
						'RUT' => $request->rut,
						'Tipo' => '',
						'Nombre' => $nombre,
						'Correo' => $request->mail,
						'Habilitado' => 1,
					],
					'AID' => config('constantes.sso_aid')
				];
				$cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
				$respuesta = $cliente->CrearUsuario($consulta);
				$respuesta = $respuesta->CrearUsuarioResult;
				if($respuesta->Estado == 1){
					$usuario = Usuarios::find($request->id);
					if(count($usuario)>0){
						$usuario->telefono = $request->fono;
						$usuario->email = $request->mail;
						$usuario->id_institucion = $request->institucion;
						$usuario->id_perfil = $request->perfil;
						$usuario->id_estado = $request->estado;
						$respuesta = $usuario->save(); 
						$respuesta = $usuario->save(); 
						if (!$respuesta){
	        $mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
	        return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
	    }else{
	        return response()->json(array('estado' => 0, 'mensaje' => 'Usuario editado correctamente'), 200);
	    }
					}else{
						$mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
						return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
					}
				}
			}
	}
	}
	//FIN CZ SPRINT 72
	
	//FIN DC SPRINT 66
	//INICIO DC SPRINT 67
	public function guardarComunas(Request $request){
	    $existe = DB::select("select * from ai_usuario_comuna where usu_id = ".$request->idUsuario." and com_id = ".$request->idComuna);
	    
	    if(count($existe) == 0){
	        $result = DB::insert("insert into ai_usuario_comuna(usu_com_id, usu_id, com_id)
            values((select max(usu_com_id) + 1 from ai_usuario_comuna), ".$request->idUsuario.", ".$request->idComuna.")");
	        if (!$result){
	            $mensaje = "Hubo un error al momento de guardar la Comuna del Usuario. Por favor intente nuevamente.";
	            return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
	        }else{
	            return response()->json(array('estado' => 0, 'mensaje' => 'Usuario ingresado correctamente'), 200);
	        }
	    }else{
	        return response()->json(array('estado' => '0', 'mensaje' => 'Usuario ingresado correctamente'), 200);
	    }
	    
	}
	//FIN DC SPRINT 67
	
	public function quitarComunas(Request $request){
	    $result = DB::delete("delete from ai_usuario_comuna where usu_id = ".$request->idUsuario." and com_id = ".$request->idComuna);
	    if (!$result){
	        $mensaje = "Hubo un error al momento de guardar la Comuna del Usuario. Por favor intente nuevamente.";
	        return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
	    }else{
	        return response()->json(array('estado' => 0, 'mensaje' => 'Usuario eliminado correctamente'), 200);
	    }
	}
	public function getUsuario(Request $request){
		// CZ SPRINT 75
		if(!isset($request->id)){
			// CZ SPRINT 77
			if(!isset($request->com_id)){
			$result = DB::select("SELECT t1.id, t1.run, 
			t1.nombres,
			t1.apellido_paterno,
			t1.apellido_materno, 
			t1.email, 
			t1.telefono, 
			t1.id_perfil, 
			t1.id_institucion,
			t1.id_estado,
				t7.reg_id,
				t7.reg_cod,
				t5.com_id,
				CASE WHEN t1.FLAG_USUARIO_CENTRAL <> 0 THEN 'SI' ELSE 'NO' END  AS FLAG_USUARIO_CENTRAL
			FROM ai_usuario t1
			LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id
			LEFT JOIN ai_perfil t3 on t3.cod_perfil = t1.id_perfil
			LEFT JOIN ai_institucion t4 on t4.id_ins = t1.id_institucion
			INNER JOIN ai_comuna t5 on t5.com_id = t2.com_id
			inner join ai_provincia t6 on t5.pro_id = t6.pro_id
			inner join ai_region t7  on t6.reg_id = t7.reg_id			
			WHERE t1.run	= ".$request->run . " and t2.vigencia = 1");
		}else{
	    $result = DB::select("SELECT t1.run, 
                t1.nombres,
                t1.apellido_paterno,
                t1.apellido_materno, 
                t1.email, 
                t1.telefono, 
                t1.id_perfil, 
                t1.id_institucion,
				t1.id_estado,
				t7.reg_id,
				t7.reg_cod,
				t5.com_id,
				CASE WHEN t1.FLAG_USUARIO_CENTRAL <> 0 THEN 'SI' ELSE 'NO' END  AS FLAG_USUARIO_CENTRAL
				FROM ai_usuario t1			
			LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id
			LEFT JOIN ai_perfil t3 on t3.cod_perfil = t1.id_perfil
			LEFT JOIN ai_institucion t4 on t4.id_ins = t1.id_institucion
			INNER JOIN ai_comuna t5 on t5.com_id = t2.com_id
			inner join ai_provincia t6 on t5.pro_id = t6.pro_id
			inner join ai_region t7  on t6.reg_id = t7.reg_id		
				WHERE t1.run	= ".$request->run . " and t2.vigencia = 1 and t5.com_id = ".$request->com_id."");
			}
		
		}else{
	    $result = DB::select("SELECT t1.run, 
                t1.nombres,
                t1.apellido_paterno,
                t1.apellido_materno, 
                t1.email, 
                t1.telefono, 
                t1.id_perfil, 
                t1.id_institucion,
				t1.id_estado,
				t7.reg_id,
				t7.reg_cod,
			t5.com_id,
			CASE WHEN t1.FLAG_USUARIO_CENTRAL <> 0 THEN 'SI' ELSE 'NO' END  AS FLAG_USUARIO_CENTRAL
				FROM ai_usuario t1			
			LEFT JOIN ai_usuario_comuna t2 on t2.usu_id = t1.id
			LEFT JOIN ai_perfil t3 on t3.cod_perfil = t1.id_perfil
			LEFT JOIN ai_institucion t4 on t4.id_ins = t1.id_institucion
			INNER JOIN ai_comuna t5 on t5.com_id = t2.com_id
			inner join ai_provincia t6 on t5.pro_id = t6.pro_id
			inner join ai_region t7  on t6.reg_id = t7.reg_id		
				WHERE t1.id	= ".$request->id . " and t2.vigencia = 1 and t5.com_id = ".$request->com_id."");
		}
	    //FIN CZ SPRINT 72
	    
	    echo json_encode($result); exit;
	}
	

	public function reporteFecha(){

		$fecha = Caso::select('created_at')->orderBy('created_at', 'asc')->first();

		return response()->json(array('fecha' => $fecha));
	}

	public function reporteAlertaLista(){

		$tip_ale = AlertaTipo::select('ale_tip_id','ale_tip_nom')->get();

		return response()->json(array('tip_ale' => $tip_ale));
	}

	public function listUsuarioPerfil(){

		$perfil = Perfil::select('id','nombre')->whereNotIn('id',[1,6,7,9])->get();

		return response()->json(array('perfil' => $perfil));

	}

	public function procesarUsuarioReportes(Request $request){
		try{

			if (!isset($request->option) || $request->option == ""){
				$mensaje = "No se ingreso una opción valida de reporte. Por favor verificar y volver a intentar.";

				return response()->json(array('estado' => 0, 'respuesta' => '', 'mensaje' => $mensaje));
			}

			$vista = "";
			$parametros = array();
			switch($request->option){
				case 0:
					$vista = "reportes.rpt_usuarios_por_perfil";
					// $registros = Usuarios::rptUsuarioPerfil($request->id_perfil);
					// $parametros['registros'] = $registros;
					//dd($registros);
				break;

				case 1: 					
					$vista = "reportes.rpt_usuarios_por_oln";
				break;
				
				case 2:
				    $vista = "reportes.rpt_gestionar_usuarios";
				break;
			}			

			$returnHTML = view($vista, $parametros)->render();
			return response()->json(array('estado' => 1, 'respuesta' => $returnHTML), 200);

		}catch(\Exception $e){
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error al momento de buscar la información del reporte solicitado. Por favor intente nuevamente.";

			return response()->json(array('estado' => 0, 'respuesta' => $e->getMessage(), 'mensaje' => $mensaje));
		}
	}

	public function procesarReportes(Request $request){

		// dd($request);
		// die();
		try{

			$vista = "";
			$parametros = array();
			$fec_ini = "";
			$fec_fin = "";
			// CZ SPRINT 75
			$año = $request->año;
			$mes = $request->mes;
			$tipofecha =  $request->filtro_fecha2;
			//$acciones = $this->perfil->acciones();
			
			if (!isset($request->option) || $request->option == ""){
			    
				$mensaje = "No se ingreso una opción valida de reporte. Por favor verificar y volver a intentar.";

				return response()->json(array('estado' => 0, 'respuesta' => '', 'mensaje' => $mensaje));
			}
			
			if((isset($request->fec_ini) && ($request->fec_ini != "")) && (isset($request->fec_fin) && ($request->fec_fin != ""))){
			
				// INICIO CZ SPRINT 72
				if($request->option == 6 || $request->option == 8 || $request->option == 10 ){
					$fec_ini = $request->fec_ini;
					$fec_fin = $request->fec_fin;
				}else{
				$fec_ini = Carbon::createFromFormat( 'd/m/Y', $request->fec_ini)->startOfDay();
				$fec_fin = Carbon::createFromFormat( 'd/m/Y', $request->fec_fin)->endOfDay();
				}
			}			
			switch ($request->option){

			    case 1: //REPORTE AT POR COMUNA
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac18'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_alertas_territoriales_por_comuna";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 2: //REPORTE AT POR TIPO
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac19'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_alerta_territorial_por_tipo";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
					$parametros['tip_ale'] = $request->tip_ale;
			    break;

			    case 3: //REPORTE AT POR PRIORIDAD
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac20'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_alerta_territorial_por_prioridad";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    break;

			    case 4: //REPORTE CANTIDAD AT SAN
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac21'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_alertas_territoriales_por_nna";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
					$parametros['tip_ale'] = $request->tip_ale;
			    break;

			    case 5: //REPORTE DETALLE AT 
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac22'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	//$vista = "reportes.rpt_detalle_alerta_territorial_san_chcc";
			    	$vista = "reportes.rpt_detalle_alerta_territorial";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
					$parametros['tip_ale'] = $request->tip_ale;
			    break;

			    case 6: //REPORTE NNA ASIGNADO A GESTOR
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac23'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_rut_asignado_gestor";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
					// CZ SPRINT 75
					$parametros['año'] = $año;
					$parametros['mes'] = $mes;
					$parametros['tipofecha'] = $tipofecha;
				break;
				
			    case 7: //REPORTE CASOS EN GESTIÓN Y CASOS EN TERAPIA FAMILIAR
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac24'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

					//$registros = Caso::rptCasosGestionCasosTerapia();
					$registros = Caso::rptCasosGestionCasosTerapia($request->comunas, $fec_ini, $fec_fin);

			    	$vista = "reportes.rpt_gestion_caso_gestion_terapia";
			    	$parametros['registros'] = $registros;
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 8: //REPORTE ESTADO DE AVANCE GESTIÓN DE CASOS
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac25'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
					
					$registros = Caso::rptEstadoAvance($request->comunas, $fec_ini, $fec_fin, $request->fec_ini, $request->fec_fin, $año, $mes);
				
			    	
					// return response()->json(array('estado' => 1, 'respuesta' =>$registros ), 200);
					// $array_titulos = array();
					// foreach ($registros as $detalle){
						
					// 	$array_titulos = array_keys($detalle);
					// 	break;
					// }

					$titulo_prediagnostico =  EstadoCaso::find(config('constantes.en_prediagnostico'));
  					$titulo_diagnostico = EstadoCaso::find(config('constantes.en_diagnostico'));
  					$titulo_elaboracion_paf = EstadoCaso::find(config('constantes.en_elaboracion_paf'));
  					$titulo_ejecucion_paf = EstadoCaso::find(config('constantes.en_ejecucion_paf'));
  					$titulo_evaluacion_paf = EstadoCaso::find(config('constantes.en_cierre_paf'));
  					$titulo_seguimiento_paf = EstadoCaso::find(config('constantes.en_seguimiento_paf'));
			    	$vista = "reportes.rpt_estado_avance_gestion_caso";
			    	// $parametros['titulos'] = $array_titulos;
			    	$parametros['titulo_prediagnostico'] = $titulo_prediagnostico->est_cas_nom;
			    	$parametros['titulo_diagnostico'] = $titulo_diagnostico->est_cas_nom;
			    	$parametros['titulo_elaboracion_paf'] = $titulo_elaboracion_paf->est_cas_nom;
			    	$parametros['titulo_ejecucion_paf'] = $titulo_ejecucion_paf->est_cas_nom;
			    	$parametros['titulo_evaluacion_paf'] = $titulo_evaluacion_paf->est_cas_nom;
			    	$parametros['titulo_seguimiento_paf'] = $titulo_seguimiento_paf->est_cas_nom;
			    	$parametros['registros'] = $registros;

					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 9: //REPORTE ESTADO DE AVANCE TERAPIA FAMILIAR
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac26'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	//$registros = Terapia::rptEstadoAvanceTerapia();
			    	$registros = Terapia::rptEstadoAvanceTerapia($request->comunas, $fec_ini, $fec_fin);

					$array_titulos = array();
					foreach ($registros as $detalle){
						$array_titulos = array_keys($detalle);
						break;
					}

					$titulo_invitacion =  EstadoTerapia::find(config('constantes.gtf_invitacion'));
  					$titulo_diagnostico = EstadoTerapia::find(config('constantes.gtf_diagnostico'));
  					$titulo_ejecucion = EstadoTerapia::find(config('constantes.gtf_ejecucion'));
  					$titulo_seguimiento = EstadoTerapia::find(config('constantes.gtf_seguimiento'));


			    	$vista = "reportes.rpt_estado_avance_gestion_terapia";
			    	$parametros['titulos'] = $array_titulos;
			    	$parametros['titulo_invitacion'] = $titulo_invitacion->est_tera_nom;
			    	$parametros['titulo_diagnostico'] = $titulo_diagnostico->est_tera_nom;
			    	$parametros['titulo_ejecucion'] = $titulo_ejecucion->est_tera_nom;
			    	$parametros['titulo_seguimiento'] = $titulo_seguimiento->est_tera_nom;
			    	$parametros['registros'] = $registros;
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 10: //REPORTE POR DESESTIMACION DE CASOS GC
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac27'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$registrosCasosDesestimados = Caso::rptDesestimacionDeCasoGestor($request->comunas, $fec_ini, $fec_fin, $año, $mes);

						$sql_motivos_desestimacion = "SELECT est_cas_id, est_cas_nom, est_cas_fin FROM ai_estado_caso WHERE est_cas_fin=1 and est_cas_id not in (".config('constantes.egreso_paf').")";
						$registros_desestimacion = DB::select($sql_motivos_desestimacion);
			    	$vista = "reportes.rpt_desestimacion_caso_gestor";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    	$parametros['registrosCasosDesestimados'] 	= $registrosCasosDesestimados;
					$parametros['titulosMotivosDesestimacion'] 	= $registros_desestimacion; 
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 11: //REPORTE POR DESESTIMACION DE CASOS GTF
		   		 	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac28'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$registrosCasosDesestimados = Terapia::rptDesestimacionDeCasoTerapeuta($request->comunas, $fec_ini, $fec_fin);

					$array_titulos = array();
					foreach ($registrosCasosDesestimados as $detalle){
						$array_titulos = array_keys($detalle);
						break;
					}

			    	$vista = "reportes.rpt_desestimacion_caso_gestion_terapia";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    	$parametros['registrosCasosDesestimados'] 	= $registrosCasosDesestimados;
					$parametros['titulosMotivosDesestimacion'] 	= collect($array_titulos); 
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 12: //REPORTE MAPA DE OFERTA
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac29'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_mapa_ofertas";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    break;

			    case 13: //REPORTE MAPA DE OFERTA (BRECHAS)
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac30'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_reporte_mapa_ofertas_brechas";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    case 14: //REPORTE ESTADOS DE ACTIVIDAD GESTION DE CASOS
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac31'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	//$registrosCasos = Caso::rptEstadoActividad();
					$registrosCasos = Caso::rptEstadoActividad($request->comunas, $fec_ini, $fec_fin, $año, $mes);


			    	$vista = "reportes.rpt_estado_actividad_gestion_caso";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    	$parametros['registrosCasos'] 	= $registrosCasos;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin; 
			    break;

			    case 15: //REPORTE ESTADOS DE ACTIVIDAD GESTION TERAPIA
	    			$nombre_reporte = "";
			   		$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac32'");
			   		if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			    	
			    	$vista = "reportes.rpt_estado_actividad_gestion_terapia";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    break;

			    case 16: //REPORTE ESTADO DE SEGUIMIENTO GESTION DE CASOS
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac33'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$registros = Caso::rptEstadoSeguimientoCaso($request->comunas, $fec_ini, $fec_fin);

			    	$vista = "reportes.rpt_estado_seguimiento_gestion_casos";
			    	$parametros['registros'] 	= $registros;
					$parametros['nombre_reporte'] = $nombre_reporte;					
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin; 
			    break;

			    case 17: //REPORTE ESTADO DE SEGUIMIENTO GESTION TERAPIA
					$nombre_reporte = "";
					$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac34'");
					if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
										
			    	$registros = Terapia::rptEstadoSeguimientoTerapia($request->comunas, $fec_ini, $fec_fin);

			    	$vista = "reportes.rpt_estado_seguimiento_gestion_terapias";
			    	$parametros['registros'] 	= $registros;
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin; 
			    break;

			    case 18: //REPORTE CANTIDAD ALERTAS CHCC
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac40'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_alertas_chcc_por_nna";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    break;

			    

			    case 19: //REPORTE DETALLE ALERTAS CHCC 
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac41'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_detalle_alerta_chcc";
			    	$parametros['nombre_reporte'] = $nombre_reporte;
			    break;


				
				case 20: //REPORTE NNA ASIGNADO A TERAPEUTA
			    	$nombre_reporte = "";
			    	$info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac42'");
			    	if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

			    	$vista = "reportes.rpt_rut_asignado_terapeuta";
					$parametros['nombre_reporte'] = $nombre_reporte;
					$parametros['fec_ini'] = $fec_ini;
					$parametros['fec_fin'] = $fec_fin;
			    break;

			    
			    //INICIO DC
			    case 23: //REPORTE GESTION COMUNITARIA BITACORA
			        
			        $nombre_reporte = "";
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac43'");
			        
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_gestion_comunitaria_bitacora";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			        
			    break;
			    case 24: //REPORTE PLAN COMUNAL BITACORA
			        $nombre_reporte = "";
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac44'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_plan_comunal_bitacora";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			    break;
			    case 25: //REPORTE Gesti�n Comunitaria: Documentos
			        $nombre_reporte = "";
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac45'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_gestion_comunitaria_documentos";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			    break;
			    case 26: //REPORTE Plan comunal: Documentos
			        $nombre_reporte = "";
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac45'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_plan_comunal_documentos";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			    break;
			    case 27: //REPORTE GESTION COMUNITARIA: ETAPAS
			        $nombre_reporte = "";
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac47'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_gestion_comunitaria_etapas";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			    break;
			    case 28: //REPORTE TIEMPOS DE INTERVENCION
			        $nombre_reporte = "";
			        
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac48'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_tiempos_intervencion";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			        $parametros['fInicio'] = $request->fAsignacionIni;
			        $parametros['fFin'] = $request->fAsignacionFin;
			        $parametros['nCaso'] = $request->nCaso;
			        $parametros['gestor'] = $request->gestor;
			       
			    break;
			    case 29: //REPORTE TIEMPOS DE INTERVENCION TERAPIA FAMILIAR
			        $nombre_reporte = "";
			        
			        $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac48'");
			        if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;
			        
			        $vista = "reportes.rpt_tiempos_intervencion_tf";
			        $parametros['nombre_reporte'] = $nombre_reporte;
			        $parametros['comunas'] = $request->comunas;
			        $parametros['fInicio'] = $request->fAsignacionIni;
			        $parametros['fFin'] = $request->fAsignacionFin;
			        $parametros['nCaso'] = $request->nCaso;
			        $parametros['terapeuta'] = $request->terapeuta;
			        
			   break;
			    //FIN DC
			}

			$returnHTML = view($vista, $parametros)->render();
			
			return response()->json(array('estado' => 1, 'respuesta' => $returnHTML), 200);

		}catch(\Exception $e){
			Log::error('error: '.$e);
			$mensaje = "Ocurrio un error al momento de buscar la información del reporte solicitado. Por favor intente nuevamente.";

			return response()->json(array('estado' => 0, 'respuesta' => $e->getMessage(), 'mensaje' => $mensaje));
		}
	}

	////////////////////////////////
	// AlertasTerritorialesPorComuna
	////////////////////////////////

	public function rptVistaAlertasTerritorialesPorComuna(){
		return view('reportes.rpt_alertas_territoriales_por_comuna');
	}

	public function rptDataAlertasTerritorialesPorComuna(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		$resultado = AlertaManual::rptAlertasTerritorialesPorComuna($filtro_comunas, $fec_ini, $fec_fin);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarAlertasTerritorialesPorComunaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new AlertasTerritorialesPorComunaExport($filtro_comunas, $fec_ini, $fec_fin), "Reporte Alertas Territoriales por Comuna ingresadas por sectorialista_".date('d-m-Y').".xlsx");

	}

	////////////////////////////////
	// AlertasTerritorialesPorNna
	////////////////////////////////

	public function rptVistaAlertasTerritorialesPorNna(){
		return view('reportes.rpt_alertas_territoriales_por_nna');
	}

	public function rptDataAlertasTerritorialesPorNna(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		$resultado = AlertaManual::rptAlertasTerritorialesPorNna($filtro_comunas, $tip_ale, $fec_ini, $fec_fin);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarAlertasTerritorialesPorNnaExportable(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new AlertasTerritorialesPorNnaExport($filtro_comunas, $tip_ale, $fec_ini, $fec_fin), "Reporte_Alertas_Territoriales_por_Nna_".date('d-m-Y').".xlsx");
	}

	public function rptDataAlertasChileCreceContigo(String $filtro_comunas){
		$resultado = AlertaManual::rptAlertasChileCreceContigo($filtro_comunas);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarAlertasChileCreceContigoExportable(String $filtro_comunas){
		return \Excel::download(new AlertasChileCreceContigoExport($filtro_comunas), "Reporte_Alertas_Chile_Crece_Contigo Homologadas_".date('d-m-Y').".xlsx");

	}

	////////////////////////////////
	// Descargar linea base y Linea de salida
	////////////////////////////////
	//inicio ch
	//SPRINT 55
	public function rptLineaBase(Request $request){
		$pro_an_id = $request->id;
		$fase = $request->fas;
		$nombre_archivo = '';
		$tipo_pregunta = 1;
		if($fase == 1){
			$nombre_archivo = 'Reporte_LineaBase';
		}else{
			$nombre_archivo = 'Reporte_LineaSalida';
		}
		return \Excel::download(new descargaLineaBaseExport($pro_an_id, $fase, $tipo_pregunta), $nombre_archivo.date('d-m-Y').".xlsx");
	}

	//fin ch

	////////////////////////////////
	// RutAsignadoGestor
	////////////////////////////////

	public function rptVistaRutAsignadoGestor(){
		return view('reportes.rpt_rut_asignado_gestor');
	}

	public function rptDataRutAsignadoGestor(Request $request){
		// INICIO CZ SPRINT 75 MANTIS 10067
		$filtro_comunas = $request->comunas; 
		$fec_ini = $request->fec_ini;
		$fec_fin =  $request->fec_fin;
		$tipo = $request->tipofecha;
		$año = $request->año;
		$mes = $request->mes;
		$resultado = collect(Caso::rptRutAsignadoGestor('vista', $filtro_comunas, $fec_ini, $fec_fin, $tipo, $año, $mes));
		return Datatables::of($resultado)->make(true);
		// FIN CZ SPRINT 75 MANTIS 10067
	}


	public function descargarRutAsignadoGestorExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null, $tipo = null){
		return \Excel::download(new RutAsignadoGestorExport($filtro_comunas, $fec_ini, $fec_fin, $tipo), "Reporte_RUT_Asignados_a_Gestor_".date('d-m-Y').".xlsx");

	}

	public function rptDataRutAsignadoTerapeuta(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		$resultado = collect(Caso::rptRutAsignadoTerapeuta('vista', $filtro_comunas, $fec_ini, $fec_fin));
		return Datatables::of($resultado)->make(true);
	}


	public function descargarRutAsignadoTerapeutaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new RutAsignadoTerapeutaExport($filtro_comunas, $fec_ini, $fec_fin), "Reporte_RUT_Asignados_a_Terapeuta_".date('d-m-Y').".xlsx");

	}

	////////////////////////////////
	// rptDesestimacionDeCasoGestor
	////////////////////////////////

	public function rptVistaDesestimacionDeCasoGestor(){
		
		$registrosCasosDesestimados = Caso::rptDesestimacionDeCasoGestor();

		$array_titulos = array();
		foreach ($registrosCasosDesestimados as $detalle){
			$array_titulos = array_keys($detalle);
			break;
		}

		return view('reportes.rpt_desestimacion_caso_gestor', 
			[
				'registrosCasosDesestimados' => $registrosCasosDesestimados,
				'titulosMotivosDesestimacion' => collect($array_titulos), 
			]
		);
	}

	public function descargarrptDesestimacionDeCasoGestorExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new CasosDesestimadosGestorExport($filtro_comunas, $fec_ini, $fec_fin), "Casos_desestimados_Gestor_".date('d-m-Y').".xlsx");

	}

	//////////////////////////////////
	// rptDesestimacionDeCasoTerapeuta
	//////////////////////////////////

	public function descargarrptDesestimacionDeCasoTerapeutaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new CasosDesestimadosTerapeutaExport($filtro_comunas, $fec_ini, $fec_fin), "Casos_desestimados_Terapeuta_".date('d-m-Y').".xlsx");

	}


	//////////////////////////////////
	// rptEstadoActividadGestionCaso
	//////////////////////////////////

	public function descargarrptEstadoCasoActividadGestionCasoExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new EstadoActividadGestionCasoExport($filtro_comunas, $fec_ini, $fec_fin), "Estado_Caso_Actividad_Gestor_".date('d-m-Y').".xlsx");

	}

	public function rptDataMapaOfertas(String $filtro_comunas){
		$resultado = collect(Programa::rptMapaOferta($filtro_comunas));
		return Datatables::of($resultado)->make(true);
	}

	public function descargarrptMapaOfertasExportable(String $filtro_comunas){
		return \Excel::download(new MapaOfertasExport($filtro_comunas), "Mapa_Oferta_".date('d-m-Y').".xlsx");

	}

	public function descargarrptEstadoAvanceExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new EstadoAvanceExport($filtro_comunas, $fec_ini, $fec_fin), "Estado_Avance_Caso_".date('d-m-Y').".xlsx");

	}

	public function descargarrptEstadoAvanceTerapiaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new EstadoAvanceTerapiaExport($filtro_comunas, $fec_ini, $fec_fin), "Estado_Avance_Terapia_".date('d-m-Y').".xlsx");

	}

	public function rptDataAlertasTerritorialesInfoTipoAlerta(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		//dd($fec_fin);
		$resultado = AlertaManual::rptAlertasTerritorialesInfoTipoAlerta($filtro_comunas, $fec_ini, $fec_fin, $tip_ale);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarrptAlertasTerritorialesInfoTipoAlertaExportable(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new AlertasTerritorialesInfoTipoAlertaExport($filtro_comunas,'excel', $fec_ini, $fec_fin, $tip_ale), "Alerta_Territorial_Detalle_".date('d-m-Y').".xlsx");

	}

	public function descargarrptEstadoSeguimientoGestionCasosExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new EstadoSeguimientoGestionCasosExport('excel', $filtro_comunas, $fec_ini, $fec_fin), "Estado_Seguimiento_Gestion_Casos_".date('d-m-Y').".xlsx");

	}

	public function descargarrptEstadoSeguimientoGestionTerapiasExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new EstadoSeguimientoGestionTerapiasExport('excel', $filtro_comunas, $fec_ini, $fec_fin), "Estado_Seguimiento_Gestion_Terapias_".date('d-m-Y').".xlsx");
	}

	public function descargarrptGestionCasoTerapiaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		
		return \Excel::download(new GestionCasoTerapiaExport('excel', $filtro_comunas, $fec_ini, $fec_fin), "Gestion_Caso_Terapia".date('d-m-Y').".xlsx");
	}

	public function rptPrioridadAlerta(String $filtro_comunas){
		$resultado = Predictivo::rptPrioridadAlerta(null, $filtro_comunas);
		return Datatables::of($resultado)->make(true);
	}
	
	//INICIO DC
	public function rptGestionComunitariaBitacora(Request $request){
	        
	    $data   = new \stdClass();
	    $data->data = array();
	    $sql = "select distinct hito.cb_hito_nom,
        cta.cb_tip_act_nom,
        count(act.act_id) as actividad,
        sum(act.act_num_part) as num_part, 
        sum(act.act_num_nna) as act_num_nna,
        sum(act.act_num_adult) as num_adult
        from ai_proceso_anual pa
        inner join ai_usuario_bitacora ub
        on ub.pro_an_id = pa.pro_an_id
        inner join ai_usuario_actividad ua
        on ua.bit_id = ub.bit_id
        inner join ai_actividad act
        on act.act_id = ua.act_id
        inner join ai_cb_hito hito
        on hito.cb_hito_id = hito_id
        inner join AI_CB_TIPO_ACTOR cta
        on cta.cb_tip_act_id = act.tip_act_id
        inner join ai_bitacora bit
        on bit.bit_id = ua.bit_id
        where pa.com_id in (".$request->comunas.")
        and pa.est_pro_id not in (3, 4)
        and bit.bit_tip = 0
        group by hito.cb_hito_nom, cta.cb_tip_act_nom
        order by hito.cb_hito_nom asc";
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptPlanComunalBitacora(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    
	    $sql = "select distinct hito.cb_hito_nom,
        cta.cb_tip_act_nom,
        count(act.act_id) as actividad,
        sum(act.act_num_part) as num_part, 
        sum(act.act_num_nna) as act_num_nna,
        sum(act.act_num_adult) as num_adult
        from ai_proceso_anual pa
        inner join ai_usuario_bitacora ub
        on ub.pro_an_id = pa.pro_an_id
        inner join ai_usuario_actividad ua
        on ua.bit_id = ub.bit_id
        inner join ai_actividad act
        on act.act_id = ua.act_id
        inner join ai_cb_hito hito
        on hito.cb_hito_id = hito_id
        inner join AI_CB_TIPO_ACTOR cta
        on cta.cb_tip_act_id = act.tip_act_id
        inner join ai_bitacora bit
        on bit.bit_id = ua.bit_id
        where pa.com_id in (".$request->comunas.")
        and pa.est_pro_id not in (3, 4)
        and bit.bit_tip = 1
        group by hito.cb_hito_nom, cta.cb_tip_act_nom
        order by hito.cb_hito_nom asc";
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptGestionComunitariaDocumentos(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $sql = "select tdg.tip_nom, 
        count(dg.doc_gc_id) as cantidad
        from ai_documentos_gc dg
        inner join ai_tipo_doc_gc tdg
        on dg.tip_id = tdg.tip_id
        inner join ai_proceso_anual pa
        on pa.pro_an_id = dg.pro_an_id
        where dg.tip_id in (5, 6, 7)
        and dg.tip_gest = 0
        and pa.com_id in (".$request->comunas.")
        and pa.est_pro_id in(7, 8, 9, 10, 1, 2, 11, 12, 5, 6)
        group by tdg.tip_nom";
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptTiemposIntervencion(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    if($request->nCaso != ''){
	        $sql_nCaso = "and caso.cas_id = ".$request->nCaso;
	    }else{
	        $sql_nCaso = "";
	    }
	    if($request->gestor != ''){
	        $sql_gestor = "and usu.id = ".$request->gestor;
	    }else{
	        $sql_gestor = "";
	    }
	    $sql = "select distinct caso.cas_id,
        usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as gestor,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 10 and cec.cas_id = caso.cas_id) as fecha_asignacion,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 1 and cec.cas_id = caso.cas_id) as fecha_evaluacion_diagnostica,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 3 and cec.cas_id = caso.cas_id) as fecha_elaboracion_paf,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 4 and cec.cas_id = caso.cas_id) as fecha_ejecucion_paf,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 5 and cec.cas_id = caso.cas_id) as fecha_ev_paf_cierre_caso,
        (select to_char(max(cec.cas_est_cas_fec), 'dd/mm/yyyy') from ai_caso_estado_caso cec where cec.est_cas_id = 6 and cec.cas_id = caso.cas_id) as fecha_seguimiento_paf,
        FN_MESES_INTERVENCION(10, 1, caso.cas_id) +
        FN_MESES_INTERVENCION(1, 3, caso.cas_id) +
        FN_MESES_INTERVENCION(3, 4, caso.cas_id) +
        FN_MESES_INTERVENCION(4, 5, caso.cas_id) +
        FN_MESES_INTERVENCION(5, 6, caso.cas_id) as meses,
        (FN_DIAS_INTERVENCION(10, 1, caso.cas_id) +
        FN_DIAS_INTERVENCION(1, 3, caso.cas_id) +
        FN_DIAS_INTERVENCION(3, 4, caso.cas_id) +
        FN_DIAS_INTERVENCION(4, 5, caso.cas_id) +
        FN_DIAS_INTERVENCION(5, 6, caso.cas_id) +
        FN_DIAS_INTERVENCION(6, 7, caso.cas_id)) as dias,
        FN_DIAS_INTERVENCION(10, 1, caso.cas_id) as dias_prediagnostico,
        FN_DIAS_INTERVENCION(1, 3, caso.cas_id) as dias_evaluacion_diagnostica,
        FN_DIAS_INTERVENCION(3, 4, caso.cas_id) as dias_elaboracion_paf,
        FN_DIAS_INTERVENCION(4, 5, caso.cas_id) as dias_ejecucion_paf,
        FN_DIAS_INTERVENCION(5, 6, caso.cas_id) as dias_evaluacion_paf_cierre,
        FN_DIAS_INTERVENCION(6, 7, caso.cas_id) as dias_seguimiento_paf
        from ai_caso caso
        inner join ai_persona_usuario perUsu
        on perUsu.cas_id = caso.cas_id
        inner join ai_usuario usu
        on usu.id = perUsu.usu_id
        inner join ai_caso_comuna comuna
        on comuna.cas_id =  caso.cas_id
        where (select max(cec.cas_est_cas_fec) from ai_caso_estado_caso cec where cec.est_cas_id = 10 and cec.cas_id = caso.cas_id) > to_date('".$request->fInicio."', 'dd/mm/yyyy')
        and (select max(cec.cas_est_cas_fec) from ai_caso_estado_caso cec where cec.est_cas_id = 10 and cec.cas_id = caso.cas_id) < to_date('".$request->fFin."', 'dd/mm/yyyy')
        and comuna.com_id in (".$request->comunas.")
        ".$sql_nCaso.$sql_gestor;
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptTiemposIntervencionTF(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    if($request->nCaso != ''){
	        $sql_nCaso = "and ter.cas_id = ".$request->nCaso;
	    }else{
	        $sql_nCaso = "";
	    }
	    if($request->terapeuta != ''){
	        $sql_terapeuta = "and usu.id = ".$request->terapeuta;
	    }else{
	        $sql_terapeuta = "";
	    }
	    $sql = "select distinct ter.cas_id,
        usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as nombre,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) as fecha_asignacion,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 4 and tera_id = ter.tera_id) as fecha_diagnostico,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 5 and tera_id = ter.tera_id) as fecha_ejecucion,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 6 and tera_id = ter.tera_id) as fecha_seguimiento,
        (FN_DIAS_INTERVENCION_TF(3, 4, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(4, 5, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(5, 6, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(6, 12, ter.tera_id)) as dias,
        (FN_MESES_INTERVENCION_TF(3, 4, ter.tera_id) +
        FN_MESES_INTERVENCION_TF(4, 5, ter.tera_id) +
        FN_MESES_INTERVENCION_TF(5, 6, ter.tera_id)) as meses,
        FN_DIAS_INTERVENCION_TF(3, 4, ter.tera_id) as dias_invitacion,
        FN_DIAS_INTERVENCION_TF(4, 5, ter.tera_id) as dias_diagnostico,
        FN_DIAS_INTERVENCION_TF(5, 6, ter.tera_id) as dias_ejecucion,
        FN_DIAS_INTERVENCION_TF(6, 12, ter.tera_id) as dias_seguimiento
        from ai_terapia ter
        inner join ai_usuario usu
        on ter.usu_id = usu.id
        inner join ai_est_terapia_bitacora bit
        on bit.tera_id = ter.tera_id
        inner join ai_caso_comuna comuna
        on comuna.cas_id =  ter.cas_id
        where (select max(tera_est_tera_fec) from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) > to_date('".$request->fInicio."', 'dd/mm/yyyy')
        and (select max(tera_est_tera_fec) from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) < to_date('".$request->fFin."', 'dd/mm/yyyy')
        and comuna.com_id in (".$request->comunas.")
        ".$sql_nCaso." ".$sql_terapeuta;
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptPlanComunalDocumentos(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $sql = "select tdg.tip_nom,
        count(dg.doc_gc_id) as cantidad
        from ai_documentos_gc dg
        inner join ai_tipo_doc_gc tdg
        on dg.tip_id = tdg.tip_id
        inner join ai_proceso_anual pa
        on pa.pro_an_id = dg.pro_an_id
        where dg.tip_id in (5, 6)
        and dg.tip_gest = 1
        and pa.com_id in (".$request->comunas.") 
        and pa.est_pro_id in(7, 8, 9, 10, 1, 2, 11, 12, 5, 6)
        group by tdg.tip_nom";
	    $resultado = DB::select($sql);
	    
	    $data->data = $resultado;
	    
	    echo json_encode($data); exit;
	}
	
	public function rptExportGestionComunitariaBitacora(String $filtro_comunas){
	    return \Excel::download(new descargarGestionComunitariaBitacora('excel', $filtro_comunas), "GestionComunitariaBitacora".date('d-m-Y').".xlsx");
	}
	
	public function rptExportPlanComunalBitacora(String $filtro_comunas){
	    return \Excel::download(new descargarPlanComunalBitacora('excel', $filtro_comunas), "PlanComunalBitacora".date('d-m-Y').".xlsx");
	}
	
	public function rptExportGestionComunitariaDocumentos(String $filtro_comunas){
	    return \Excel::download(new descargarGestionComunitariaDocumentos('excel', $filtro_comunas), "GestionComunitariaDocumentos".date('d-m-Y').".xlsx");
	}
	
	public function rptExportPlanComunalDocumentos(String $filtro_comunas){
	    return \Excel::download(new descargarPlanComunalDocumentos('excel', $filtro_comunas), "PlanComunalDocumentos".date('d-m-Y').".xlsx");
	}
	
	public function rptExportGestionComunitariaEtapas(String $filtro_comunas){
	    return \Excel::download(new descargarGestionComunitariaEtapas('excel', $filtro_comunas), "GestionComunitariaEtapas".date('d-m-Y').".xlsx");
	}
	
	public function rptExportTiemposIntervencion(String $filtro_comunas, $inicio, $fin, $caso = null, $gestor = null){
	    return \Excel::download(new descargarTiemposIntervencion('excel', $filtro_comunas, $inicio, $fin, $caso, $gestor), "TiemposIntervencion".date('d-m-Y').".xlsx");
	}
	
	public function rptExportTiemposIntervencionTF(String $filtro_comunas, $inicio, $fin, $caso = null, $gestor = null){
	    return \Excel::download(new descargarTiemposIntervencionTF('excel', $filtro_comunas, $inicio, $fin, $caso, $gestor), "TiemposIntervencionTF".date('d-m-Y').".xlsx");
	}
	//FIN DC

	public function descargarrptPrioridadAlertaExportable(String $filtro_comunas){
		return \Excel::download(new AlertasTerritorialPorPrioridadExport('excel', $filtro_comunas), "Alertas_Por_Prioridad".date('d-m-Y').".xlsx");
	}

	public function rptDetalleAlertasTerritoriales(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		
		$resultado = AlertaManual::rptDetalleAlertasTerritoriales(null, $filtro_comunas, $fec_ini, $fec_fin, $tip_ale);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarrptDetalleAlertasTerritorialesExportable(String $filtro_comunas, $tip_ale = null, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new descargarrptDetalleAlertasTerritorialesExport('excel', $filtro_comunas, $tip_ale, $fec_ini, $fec_fin), "Detalle_Alertas_Territoriales".date('d-m-Y').".xlsx");
	}

	public function rptDetalleAlertasChcc(String $filtro_comunas){
		$resultado = AlertaChileCreceContigo::rptDetalleAlertasChcc(null, $filtro_comunas);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarrptDetalleAlertasChccExportable(String $filtro_comunas){
		return \Excel::download(new descargarrptDetalleAlertasChccExport('excel', $filtro_comunas), "Detalle_Alertas_Chcc".date('d-m-Y').".xlsx");
	}

	public function rptMapaOfertaBrecha(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		$resultado = Programa::rptMapaOfertaBrecha($filtro_comunas, $fec_ini, $fec_fin);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarrptMapaOfertaBrechaExportable(String $filtro_comunas, $fec_ini = null, $fec_fin = null){
		return \Excel::download(new descargarrptMapaOfertaBrechaExport('excel',$filtro_comunas, $fec_ini, $fec_fin), "Mapa_Oferta_Brecha_".date('d-m-Y').".xlsx");
	}

	public function descargarAlertasTerritorialesExport(Request $request){
		return \Excel::download(new descargarAlertasTerritorialesExport($request), "Alertas_Territoriales".date('d-m-Y').".xlsx");

	}

	public function descargarIntervencionesExport(Request $request){
		return \Excel::download(new descargarIntervencionesExport($request), "Intervenciones".date('d-m-Y').".xlsx");

	}

	////////////////////////////////
	// Gestion de Usuarios
	////////////////////////////////
	

	public function rptUsuarioPerfil(String $id_perfil){
		$resultado = Usuarios::rptUsuarioPerfil($id_perfil);
		return Datatables::of($resultado)->make(true);
	}

	public function descargarUsuariosPorPerfil(String $id_perfil){
		return \Excel::download(new descargarUsuarioPorPerfilExportable($id_perfil), "Reporte de Usuarios Por Perfil_".date('d-m-Y').".xlsx");
	}

	public function rptUsuarioOln(String $com_id){
		$resultado = Usuarios::rptUsuarioOln($com_id);
		return Datatables::of($resultado)->make(true);
	}
	
	//INICIO DC
	public function rptUsuarioOln2(Request $request){
	    $resultado = Usuarios::rptUsuarioOln2($request);
	    return Datatables::of($resultado)->make(true);
	}
	//FIN DC

	public function descargarUsuariosPorOln(String $com_id){
		return \Excel::download(new descargarUsuarioPorOlnExportable($com_id), "Reporte de Usuarios Por OLN_".date('d-m-Y').".xlsx");
	}

	public function descargarReportesObjetivosTareas($file){
		if(config('constantes.reporte_mensual')){
			return response()->download(storage_path().'\app\reportes\\'.$file);
		}else{
			return \Excel::download(new descargarReportesObjetivosTareasExportable(), "Objetivos y Tareas_".date('d-m-Y').".xlsx");
		}
	}

	public function descargarReportesResultadosNcfas($file){
		if(config('constantes.reporte_mensual')){
			return response()->download(storage_path().'\app\reportes\\'.$file);
		}else{
			return \Excel::download(new descargarReportesResultadosNcfasExportable(), "Resultados NCFAS_".date('d-m-Y').".xlsx");
		}
	}

	public function descargarReportesIntegrantesGfamiliar($file){

		if(config('constantes.reporte_mensual')){
			return response()->download(storage_path().'\app\reportes\\'.$file);
		}else{
			return \Excel::download(new descargarReportesIntegrantesGfamiliarExportable(), "Integrantes Grupo Familiar_".date('d-m-Y').".xlsx");
		}
	}

	public function descargarReportesRespuestasTerapiafamiliar($file){
		
		if(config('constantes.reporte_mensual')){
			return response()->download(storage_path().'\app\reportes\\'.$file);
		}else{
			return \Excel::download(new descargarReportesRespuestasTerapiafamiliarExportable(), "Respuestas Terapia Familiar_".date('d-m-Y').".xlsx");
		}

	}

	public function listadoReporteMensual(Request $request){

		switch($request->opcion){
			case 0:
				$nombre_archivo = "Objetivos_Tareas";
			break;

			case 1:
				$nombre_archivo = "Resultados_NCFAS";
			break;

			case 2:
				$nombre_archivo = "Respuestas_Terapia_Familiar";
			break;
			
			case 3:
				$nombre_archivo = "Integrantes_Grupo_Familiar";
			break;
		}
		
		$reporte = array(); $i = 0;
		$path = storage_path().'\app\reportes';
		if(is_dir($path)){
			$files = scandir($path);
			$files = array_diff(scandir($path), array('.', '..'));
			foreach($files as $lista){
				$pos = strpos($lista, $nombre_archivo);
				
				if($pos === 0){		
					$reporte[$i] = new \stdClass;			
					$reporte[$i]->nombre = $lista;
					$reporte[$i]->fecha = date ("d/m/Y", filemtime($path.'\\'.$lista));
					$reporte[$i]->ruta = $path.'\\'.$lista;
					$reporte[$i]->opcion = $request->opcion;
					$i++;
				}
			}
		}
		$data		= new \stdClass();
		$data->data = $reporte;
		echo json_encode($data); exit;
	}
	// INICIO CZ SPRINT 70
	public function rptLineaBase_2021(Request $request){
		$pro_an_id = $request->id;
		$fase = $request->fas;
		$nombre_archivo = '';
		$tipo_pregunta = 1;
		if($fase == 1){
			$nombre_archivo = 'Reporte_LineaBase';
		}else{
			$nombre_archivo = 'Reporte_LineaSalida';
		}
		return \Excel::download(new descargaLineaBaseExport_2021($pro_an_id, $fase, $tipo_pregunta), $nombre_archivo.date('d-m-Y').".xlsx");
	}
	//FIN CZ SPRINT 70

	public function buscarUsuariSSO(){

	}
	// CZ 75
	public function existeBaseDatos($run){
		$existe = DB::select("select count(*) as existe from ai_usuario where run = ".$run);
		return $existe[0];
	}

	public function UsuarioBaseDatos(Request $request){
		$run = $request->run; 
		$existeBD = $this->existeBaseDatos($run);
		if($existeBD->existe == 0){
			$max_id = DB::select("select max(id) + 1 as max_id from ai_usuario");
			$usuario = new Usuarios();
			$usuario->id = $max_id[0]->max_id;
			$usuario->run = $request->run;
			$usuario->nombres = $request->nombres;
			$usuario->apellido_paterno = $request->apePat;
			$usuario->apellido_materno = $request->apeMat;
			$usuario->telefono = $request->fono;
			$usuario->email = $request->mail;
			$usuario->id_region = $request->region;
			$usuario->id_institucion = $request->institucion;
			$usuario->id_perfil = $request->perfil;
			$usuario->id_estado = $request->estado;
			$respuesta = $usuario->save();
			if (!$respuesta){ //ERROR USUARIO GUARDAR BASE DE DATOS
				DB::rollback();
				$mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";
		
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
			}
		}else{
			$usuarioFind = Usuarios::where("run",$request->run)->first();
			$usuario = Usuarios::find($usuarioFind->id);
			$usuario->telefono = $request->fono;
			$usuario->email = $request->mail;
			$usuario->id_institucion = $request->institucion;
			$usuario->id_perfil = $request->perfil;
			$usuario->id_region = $request->region;
			$usuario->id_estado = $request->estado;
			$respuesta = $usuario->save(); 
			if (!$respuesta){
				// CZ SPRINT 77
				DB::rollback();
				$mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
				return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
			}
		}

		return $respuesta;
		
	}

	
	public function guardarComunaUsuario($request){
		$usuarioFind = Usuarios::where("run",$request->run)->first();
		$exitsUsuarioComuna = UsuarioComuna::where('usu_id', $usuarioFind->id)->count(); 
		if($exitsUsuarioComuna > 0){
			$cambiarVigecia = DB::update('update ai_usuario_comuna set vigencia = 0 where usu_id =  ' . $usuarioFind->id);
		}
			$exitsUsuarioComuna = UsuarioComuna::where('usu_id', $usuarioFind->id)->where('com_id', $request->comuna)->first(); 
			if(count($exitsUsuarioComuna) == 0){ //SE CONSULTA SI YA EXISTE LA RELACION ENTRE EL USUARIO Y LA COMUNA
				$max_id_comuna = DB::select("select max(usu_com_id) + 1 as max_id from ai_usuario_comuna");
				$usuarioComuna = new UsuarioComuna();
				$usuarioComuna->usu_com_id = $max_id_comuna[0]->max_id;
				$usuarioComuna->usu_id = $usuarioFind->id;
				$usuarioComuna->com_id = $request->comuna;
				$usuarioComuna->vigencia = 1;
				$respuesta = $usuarioComuna->save();
				if (!$respuesta){
					DB::rollback();
					$mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";
			
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}
				return 1;
			}else{
				$usuarioComuna =  UsuarioComuna::find($exitsUsuarioComuna->usu_com_id);
				$usuarioComuna->vigencia = 1;
				$respuesta = $usuarioComuna->save();

				if (!$respuesta){
					DB::rollback();
					$mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";
			
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
				}

				return 1;
			}	
	}
	public function guardarUsuario(Request $request){
		$run = $request->run; 
		$UsuarioBaseDatos = $this->UsuarioBaseDatos($request);
		
		if($UsuarioBaseDatos == 1){
			$guardarComunaUsuario = $this->guardarComunaUsuario($request);
			
			if($guardarComunaUsuario == 1){
				$buscarUsuarioSSO = $this->buscarUsuarioSSO($request);
				
				if($buscarUsuarioSSO->BuscarUsuarioResult->Cantidad == 0){
					$usuarioFind = Usuarios::where("run",$request->run)->first();
					$tipo = 1; //GUARDAR 
					$guardarUsuarioSSO = $this->guardarUsuarioSSO($request, $tipo);
					if($guardarUsuarioSSO->Estado == 1){
						$mensaje = "Se ha registrado persona con exito.";
		
						return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
					}else{
						$mensaje = "Ha ocurrido un error al momento de asignar roles.";
		
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

					}
				}else{
					$tipo = 2; //EDITAR 
					$guardarUsuarioSSO = $this->guardarUsuarioSSO($request, $tipo);
				
					if($request->estado == 1){
						if($guardarUsuarioSSO->Estado == 1){
							$mensaje = "Se ha registrado persona con exito.";
			
							return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO), 200);
						}else{
							$mensaje = "Ha ocurrido un error al momento de asignar roles.";
			
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO), 200);
	
						}
					}else{

						if($guardarUsuarioSSO->getdata()->estado == 1){
			
							$mensaje = $guardarUsuarioSSO->getdata()->respuesta->Detalle;
			
							return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO->getdata()), 200);
						}else{
			
							$mensaje = "Ha ocurrido un error al momento de eliminar el usuario.";
			
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO->getdata()), 200);
	
						}
					}
					
				}
			}
		}
		
	}

	public function guardarUsuarioSSO(Request $request, $tipo){
		
	    $cadena =$request->apePat;
	    
		$cadena = $this->eliminar_acentos($cadena);
	    $clave1 = substr($cadena, 0, 3);
	    $clave2 = substr($request->rut, 0, 4);
	    $clave = ucfirst(strtolower(strrev($clave1))).'.'.$clave2;
		if($request->clave != ""){
			if($clave != $request->clave){
				$clave = $request->clave;
			}
		}
	    //Ingresa usuario al SSO
		if($tipo == 1){
	    $consulta = [
	        'Usuario' => [
	            'Clave' => $clave,
	            'Correo' => $request->mail,
	            'Habilitado' => 1,
	            'Nombre' => $request->nombres.' '.$request->apePat.' '.$request->apeMat,
	            'Path' => '',
	            'Roles' => [
	                'Rol' => [
	                    'ID' => config('constantes.sso_rol'),
	                    'Id_Aplicacion' => config('constantes.sso_aplicacion'),
	                    'Nombre' => ''
	                ]
	            ],
	            'RUT' => $request->rut,
	            'Tipo' => ''
	        ],
	        'AID' => config('constantes.sso_aid')
	    ];
		}else{
			$consulta = [
				'Usuario' => [
					'Correo' => $request->mail,
					'Habilitado' => 1,
					'Nombre' => $request->nombres.' '.$request->apePat.' '.$request->apeMat,
					'Path' => '',
					'Roles' => [
						'Rol' => [
							'ID' => config('constantes.sso_rol'),
							'Id_Aplicacion' => config('constantes.sso_aplicacion'),
							'Nombre' => ''
						]
					],
					'RUT' => $request->rut,
					'Tipo' => ''
				],
				'AID' => config('constantes.sso_aid')
			];
		}
	    
	
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->CrearUsuario($consulta);
	    $respuesta = $respuesta->CrearUsuarioResult;
		
		if($respuesta->Estado == 1){
			if($request->estado == 1){
				$asignarRolesUsuario = $this->asignarRolesUsuario($request);
				return $asignarRolesUsuario;
			}else{
				$eliminarVigencia =  $this->eliminarVigencia($request);
		
				return $eliminarVigencia;
				
			}
		
		}else{
			$mensaje = "Hubo un error al momento de registrar al usuario en el SSO. Por favor verifique e intente nuevamente.";
		
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
		}
	}

	public function eliminarVigencia(Request $request){
		$consulta = [
	        'rut' => $request->rut, 
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta = $cliente->EliminarUsuario($consulta);
	    $respuesta = $respuesta->EliminarUsuarioResult;
	    return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
	}
	public function asignarRolesUsuario(Request $request){
		 //Asigna roles en SSO
		 $consulta = [
	        'rut' => $request->rut,
	        'roles' => [
	            'int' => config('constantes.sso_rol')
	        ],
	        'AID' => config('constantes.sso_aid')
	    ];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuesta2 = $cliente->AsignarRoles($consulta);
	    $respuesta2 = $respuesta2->AsignarRolesResult;
		return $respuesta2;
		// if()
	    // return response()->json(array('estado' => '1', 'respuesta' => $respuesta2), 200);
	}

	public function buscarUsuarioSSO(Request $request){
		$consulta = ['rut' => $request->rut, 'AID' => config('constantes.sso_aid')];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuestaServicio = $cliente->BuscarUsuario($consulta);
	    $respuesta =  $respuestaServicio ->BuscarUsuarioResult;
		return $respuestaServicio;
	}

	// CZ SPRINT 77
}