<?php
// CZ SPRINT 75

namespace App\Http\Controllers;

use Session;
use App\Modelos\{Comuna, ProgramaComuna, Funcion, Usuarios, UsuarioComuna, CasosGestionEgresado,CasoGrupoFamiliar, CasosDesestimados, PersonaUsuario, DatosPersona, Persona, Caso, CasoReporteGestion,ReporteGestionCaso};
use Illuminate\Http\Request;
use DB;
use Log;
use DataTables;
use Illuminate\Support\Facades\File; 
class AdministracionController extends Controller
{

	protected $comuna;

	public function __construct(
        Comuna          $comuna
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
        $this->comuna       = $comuna;
	}
	
	/**
	 * Método que lista las prestaciones del mantenedor
	 *
	 * @return view
	 */
	public function administrarOLN(){
		$icono = Funcion::iconos(232);
		return view('administrador.administrar_oln.administrar_oln', [
            'icono'   			=> $icono,
        ]);
		
	}

    public function getOLN(){
       $oln = DB::select("select c.com_cod as id_comuna,  c.com_id, c.com_nom as comuna, c.oln as vigente, r.reg_cod as id_region, r.reg_nom as region from ai_comuna c
       left JOIN ai_provincia p ON c.pro_id = p.pro_id
       left JOIN ai_region r ON p.reg_id = r.reg_id order by r.reg_cod");

        return Datatables::of(collect($oln))
        ->make(true);
    }
		
    public function habilitarOLN(Request $request){

        $mensaje = "Se ha habilitado OLN con exito.";
        $comuna =  Comuna::find($request->id_comuna);
        $comuna->oln = 'S';
        $respuesta = $comuna->save();

        if(!$respuesta){
            DB::rollback();
			$mensaje = "Hubo un error al momento de habilitar la OLN. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
        }
        $ProgramaComuna = ProgramaComuna::where('com_id', $request->com_id)->get();
        
        if(count($ProgramaComuna) == 0){
            $crearMapa = DB::insert("INSERT INTO ai_pro_com (PROG_ID,com_id,PRO_COM_EST,USU_RESP_COM,PRO_COM_CUPOS,USU_RESP_COM_NOM)
            (SELECT pc.PROG_ID,{$request->id_comuna},1,null ,null , null 
             FROM ai_programa p 
             LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id 
             WHERE pc.com_id IN (306) and p.pro_tip  = 1)");

             if(!$crearMapa){
                DB::rollback();
                $mensaje = "Hubo un error al momento de crear el mapa de ofertas. Por favor verifique e intente nuevamente.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
             }

        }

        $buscarUsuarios = Usuarios::where('id_perfil', 7)->get();
       
        foreach($buscarUsuarios as $key => $usuarios){
            $max_id = DB::table('ai_usuario_comuna')->max('usu_com_id');
            $buscar = UsuarioComuna::where('com_id',$comuna->com_id)->where('usu_id', $usuarios->id)->get();
            if(count($buscar)== 0){
                $usuarioComuna = new UsuarioComuna();
                $usuarioComuna->com_id = $comuna->com_id;
                $usuarioComuna->usu_id = $usuarios->id;
                $usuarioComuna->usu_com_id = $max_id+1;
                $usuarioComuna->vigencia = 1;
                $usuarioComuna->save();

                if(!$usuarioComuna){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de crear el mapa de ofertas. Por favor verifique e intente nuevamente.";
        
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                 }
            }
            
           
        }
        $buscar_Usuario = Usuarios::where('run', '77777777')->get();
        foreach($buscar_Usuario as $key => $usuarios){
            $max_id = DB::table('ai_usuario_comuna')->max('usu_com_id');
            $buscar = UsuarioComuna::where('com_id',$comuna->com_id)->where('usu_id', $usuarios->id)->get();
            if(count($buscar)== 0){
                $usuarioComuna = new UsuarioComuna();
                $usuarioComuna->com_id = $comuna->com_id;
                $usuarioComuna->usu_id = $usuarios->id;
                $usuarioComuna->usu_com_id = $max_id+1;
                $usuarioComuna->vigencia = 1;
                $usuarioComuna->save();

                if(!$usuarioComuna){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de crear el mapa de ofertas. Por favor verifique e intente nuevamente.";
        
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                 }
            }
            
        }

        DB::commit();
        return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
    }

    public function deshabilitarOLN(Request $request){
        $mensaje = "Se ha deshabilitar OLN con exito.";
        $comuna =  Comuna::find($request->id_comuna);
        $comuna->oln = 'N';
        $respuesta = $comuna->save();

        if(!$respuesta){
            DB::rollback();
			$mensaje = "Hubo un error al momento de habilitar la OLN. Por favor verifique e intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
        }
        DB::commit();
        return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
    }
// INICIO CZ SPRINT 77
    public function listarCasosGestion(Request $request){
        if($request->estado == "0"){
            $comuna = explode(',',$request->comunas);
            return Datatables::of(CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('est_cas_fin', '<>', 1)
            ->where('es_cas_id','<>',10))
            ->make(true);
        }else if($request->estado == "1"){
            $comuna = explode(',',$request->comunas);
            return Datatables::of(CasosGestionEgresado::query()
            ->whereIn('cod_com', $comuna)
            ->where('es_cas_id', '=', 7)
            ->whereMonth('cas_est_cas_fec', '=', date('m'))
            ->whereYear('cas_est_cas_fec', '=', date('Y')))
            ->make(true);
        }else{
            $comuna = explode(',',$request->comunas);
            return Datatables::of($casos_desestimados = CasosDesestimados::whereIn('cod_com', $comuna)            
            ->whereMonth('cas_est_cas_fec', '=', date('m'))
            ->whereYear('cas_est_cas_fec', '=', date('Y')))
            ->make(true);
        }
		
	}

    public function agruparCaso(){
        $icono = Funcion::iconos(232);
		return view('administrador_central.agruparNNA', [
            'icono'   			=> $icono,
        ]);
    }

    public function casosComuna(Request $request){
        $comuna = explode(',',$request->comunas);
        return Datatables::of(CasosGestionEgresado::query()
        ->whereIn('cod_com', $comuna)
        ->where('est_cas_fin', '<>', 1)
        ->where('cas_id','<>',$request->caso_indice)
        ->whereNull('tera_id')
        )
        ->make(true);
    }

    public function unificarCaso(Request $request){
        // print_r("camila testing");
        // die();
        try{
            DB::beginTransaction();
            $casoString = "";
            $runString = "";
            $hoy = date("d-m-Y");
            $detalleString = $hoy .  " - AL CASO ACTUAL: {$request->caso_indice} SE LE UNIFICARAN LOS SIGUIENTES CASOS:  ";
            $ai_persona_indice = Persona::where('per_run', $request->run_indice)->first();
            $ai_persona_usuario_indice = PersonaUsuario::where('cas_id',$request->caso_indice)->where('run',$request->run_indice )->first();

            
            foreach($request->casos as $key_caso => $caso){

                    $ai_persona_usuario = PersonaUsuario::where('cas_id',$caso)->get();

                    DB::update("update ai_persona_usuario set usu_id = {$ai_persona_usuario_indice->usu_id}, cas_id  = $request->caso_indice where cas_id  in ({$caso})");

                $ai_persona_datosper = DatosPersona::where('cas_id', $caso)->get();
                   
                $detalleString.= $caso . " - ";
                foreach($ai_persona_datosper as $key =>  $datosPersona){
                    $ai_persona = Persona::find($datosPersona->per_id);
                    $detalleString.=  $ai_persona->per_run . " - " . $ai_persona->per_nom .  " " .  $ai_persona->per_pat . " " . $ai_persona->per_mat . " "; 
                    $runString .= $ai_persona->per_run . ", ";
                    if(count($ai_persona_datosper)-1 > $key){
                        $detalleString.= " Y ";
                    }
                }
                $detalleString.= " | ";

                $casoString.= $caso . ", ";

                $caso_data = Caso::find($caso);
    
                $destinationPath = 'doc/';
                $ruta_file = $destinationPath."/".$caso_data->cas_doc_cons;
                File::delete($destinationPath);
                $ruta_file = $destinationPath."/".$caso_data->cas_enc_sati;
                File::delete($destinationPath);
              
                $ai_caso_reporte_gestion = CasoReporteGestion::where('cas_id', $caso)->get();
                foreach($ai_caso_reporte_gestion as $key => $caso_reporte_gestion){
                    $ai_reporte_gestion_caso=ReporteGestionCaso::find($caso_reporte_gestion->ai_rgc_id);
                    $ai_reporte_gestion_caso->delete(); 
                }
                
                    DB::update("update  ai_persona_datosper set cas_id = {$request->caso_indice}  where cas_id in  $caso");
               

            }
            // DB::rollback();
            // print_r($detalleString);
            // die();

            $casoString = rtrim($casoString, ", ");
            $runString = rtrim($runString, ", ");
           
            $casogrupo = $casoString . "," . $request->caso_indice;
           $validarGrupoFamiliar = DB::select("select  * from (
            select gru_fam_id, count(gru_fam_id) as cantidad from ai_caso_grupo_familiar  group by gru_fam_id
             )  WHERE CANTIDAD = '2'");
          
            if(count($validarGrupoFamiliar) > 0){
           
                foreach($validarGrupoFamiliar as $key => $caso_grupo_familiar){
                    DB::update("update ai_caso_grupo_familiar set cas_id = {$request->caso_indice} where cas_id in ({$casoString}) and gru_fam_id <>" .$caso_grupo_familiar->gru_fam_id);
                    $casoGrupoFamiliar = DB::select("select * from ai_caso_grupo_familiar where gru_fam_id = ". $caso_grupo_familiar->gru_fam_id);
                    if(count($casoGrupoFamiliar) > 1 ){
                        foreach($casoGrupoFamiliar as $key => $casos->gru_fam_id ){
                            if (!in_array($casos->cas_id, $request->casos)){
                                $delete=CasoGrupoFamiliar::where('cas_id' , $casos->cas_id)->where('gru_fam_id',$casos->gru_fam_id);
                                $delete->delete(); 
                            }
                       
                        }
                    } 

                }
            //DB::delete("delete from ai_caso_grupo_familiar  where cas_id in ({$casoString})");
            }else{
                DB::update("update ai_caso_grupo_familiar set cas_id = {$request->caso_indice} where cas_id in ({$casoString})");
            }
            DB::update("update AI_CASO_PERSONA_INDICE set cas_id = {$request->caso_indice}, per_ind = 0 where cas_id in ({$casoString})");

            DB::update("update AI_CASO_PERSONA_INDICE set  per_ind = 0 where per_id <> $ai_persona_indice->per_id and cas_id = {$request->caso_indice}");

            DB::update("update AI_CASO_PERSONA_INDICE set  per_ind = 1 where per_id = $ai_persona_indice->per_id and cas_id = {$request->caso_indice}");
            
            DB::delete("delete ai_respuesta where cas_id  in ({$casoString})");
            DB::delete("delete from ai_estado_alerta_manual_estado where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
            DB::delete("delete from AI_AM_DIMENSION where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
            DB::delete("delete from ai_alerta_manual_tipo where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
            DB::delete("delete AI_ALERTA_OBJETIVO where ai_caso_id in ({$casoString})");
            DB::delete("delete from AI_ESTADOS_PROGRAMAS_BIT where am_prog_id in (select am_prog_id from ai_am_programas where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2))");
            DB::delete("delete from ai_am_programas where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
              
            
            DB::delete("delete FROM ai_obj_tarea_grup_fam_paf WHERE TAR_ID IN (SELECT TAR_ID FROM AI_OBJ_TAREA_PAF WHERE OBJ_ID
            IN (SELECT OBJ_ID  from ai_objetivo_paf where CAS_ID IN ({$casoString})))");

            DB::delete("delete FROM AI_OBJ_TAR_BIT_PAF WHERE TAR_ID 
            IN (SELECT TAR_ID FROM AI_OBJ_TAREA_PAF WHERE OBJ_ID IN (SELECT OBJ_ID  from ai_objetivo_paf where CAS_ID IN ({$casoString})))");

            DB::delete("delete from ai_sesion_tarea where tar_id IN (SELECT TAR_ID FROM AI_OBJ_TAREA_PAF WHERE OBJ_ID IN 
            (SELECT OBJ_ID  from ai_objetivo_paf where CAS_ID IN ({$casoString})))");

            DB::delete("delete from ai_objetivo_paf where CAS_ID IN ({$casoString})");
        
            DB::delete("delete from ai_am_programas  where ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("delete from ai_reporte_gestion_caso  where ai_rgc_ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("delete from ai_am_ofertas where gru_fam_id in (  select tar_id from AI_OBJ_TAREA_GRUP_FAM_PAF where gru_fam_id in (select gru_fam_id from ai_grupo_familiar where gru_fam_id 
            in (select gru_fam_id from ai_caso_grupo_familiar where cas_id in ({$casoString}))))");

            DB::delete("delete from ai_brecha_integrante_caso  where id_alerta_territorial in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("  delete from ai_alerta_manual_contactos  where ai_ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
            
            DB::delete("delete from ai_caso_alerta_manual  where ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("delete from ai_prio_at_caso_at where ale_man_id in 
            ( select ale_man_id from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("delete from ai_estado_alerta_manual_estado where ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");

            DB::delete("delete from ai_alerta_manual_tipo where ale_man_id in 
            ( select ale_man_id   from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2)");
           
            DB::delete("delete from ai_am_dimension where cas_id in ({$casoString})");

            DB::delete("delete ai_ses_dev where cas_id in ({$casoString})");  

            DB::delete("delete from ai_caso_reporte_gestion where cas_id in ({$casoString}) ");
                        
            DB::delete("delete  from ai_caso_estado_caso  where cas_id in ({$casoString})");

            DB::delete("delete  from ai_direccion  where cas_id in ({$casoString})");

            DB::delete("delete  from ai_prio_at_caso_at  where ale_man_id in (select ale_man_id from ai_alerta_manual  where ale_man_run in ({$casoString}) and ale_man_tipo = 2)");
            
            DB::delete("delete  from ai_caso_alerta_manual  where cas_id in ({$casoString})");

            DB::delete("delete  from ai_alerta_manual  where ale_man_run in ({$runString}) and ale_man_tipo = 2");

           DB::delete("delete ai_caso where cas_id in ({$casoString})");

           $caso_detalle_unif = Caso::find($request->caso_indice);
           $caso_detalle_unif->detalle_unif = $detalleString;
           $caso_detalle_unif->save();
           
           //DB::rollback();
           DB::commit();
           
           $mensaje = "Unificación realizada con exito!";
           return response()->json(array('estado' => '1', 'mensaje' =>   $mensaje), 200);

      
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            $mensaje = "Hubo un error al momento de realizar la unificación de los casos. Por favor intente nuevamente o contacte con el Administrador.";
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);

        }
    }

    public function UsuarioBaseDatos(Request $request){
        DB::beginTransaction();
        try{
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
                $usuario->flag_usuario_central = 0;
                $respuesta = $usuario->save();
                if (!$respuesta){ //ERROR USUARIO GUARDAR BASE DE DATOS
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";
            
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
            }else{
                $usuarioFind = Usuarios::where("run",$run)->first();
                $usuario_update = Usuarios::find($usuarioFind->id);
                $usuario_update->telefono = $request->fono;
                $usuario_update->email = $request->mail;
                $usuario_update->id_institucion = $request->institucion;
                $usuario_update->id_perfil = $request->perfil;
                $usuario_update->id_region = $request->region;
                $usuario_update->id_estado = $request->estado;
                $usuario_update->flag_usuario_central = 0;
                $respuesta = $usuario_update->save(); 
                if (!$respuesta){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de editar el Usuario. Por favor intente nuevamente.";
                    return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
                }
            }
            DB::commit();
            return $respuesta;
        }catch(\Exception $e){
            DB::rollback();
            $mensaje = "Hubo un error al momento de realizar accion con la base de datos. Por favor intente nuevamente.";
            return response()->json(array('estado' => '200', 'mensaje' => $mensaje), 200);
        }
		
		
	}

    public function guardarComunaUsuario(Request $request){
		$usuarioFind = Usuarios::where("run",$request->run)->first();
		$exitsUsuarioComuna = UsuarioComuna::where('usu_id', $usuarioFind->id)->count(); 
		
		if($exitsUsuarioComuna > 0){
			$cambiarVigecia = DB::update('update ai_usuario_comuna set vigencia = 0 where usu_id =  ' . $usuarioFind->id);
		}

        if($request->perfil_option != 10){
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
                DB::commit();
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
                DB::commit();
				return 1;
			}	
        }else{
            $comunas_region = DB::select("select ai_comuna.* from ai_comuna left join ai_provincia on ai_comuna.pro_id = ai_provincia.pro_id left join ai_region on ai_provincia.reg_id =  ai_region.reg_id where  ai_comuna.oln = 'S' and  ai_region.reg_cod = " . $request->region);
            foreach($comunas_region as $key => $comuna){
                $exitsUsuarioComuna = UsuarioComuna::where('usu_id', $usuarioFind->id)->where('com_id', $comuna->com_id)->first(); 
                if(count($exitsUsuarioComuna) == 0){ //SE CONSULTA SI YA EXISTE LA RELACION ENTRE EL USUARIO Y LA COMUNA
                    $max_id_comuna = DB::select("select max(usu_com_id) + 1 as max_id from ai_usuario_comuna");
                    $usuarioComuna = new UsuarioComuna();
                    $usuarioComuna->usu_com_id = $max_id_comuna[0]->max_id;
                    $usuarioComuna->usu_id = $usuarioFind->id;
                    $usuarioComuna->com_id = $comuna->com_id;
                    $usuarioComuna->vigencia = 1;
                    $respuesta = $usuarioComuna->save();
                    if (!$respuesta){
                        DB::rollback();
                        $mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";

                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }else{
                    $usuarioComuna =  UsuarioComuna::find($exitsUsuarioComuna->usu_com_id);
                    $usuarioComuna->vigencia = 1;
                    $respuesta = $usuarioComuna->save();
    
                    if (!$respuesta){
                        DB::rollback();
                        $mensaje = "Hubo un error al momento de registrar al usuario. Por favor verifique e intente nuevamente.";
                
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }	
            }
            DB::commit();
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
					
					$guardarUsuarioSSO = $this->guardarUsuarioSSO($request);

					if($guardarUsuarioSSO->getdata()->estado  == 1){
                        $mensaje = $guardarUsuarioSSO->getdata()->respuestaSSO->Detalle;
        
                        return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO->getdata()->respuestaSSO), 200);
    
					}else{
						$mensaje = "Ha ocurrido un error al momento de asignar roles.";
		
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

					}
				}else{
					$guardarUsuarioSSO = $this->guardarUsuarioSSO($request);

                    if($guardarUsuarioSSO->getdata()->estado == 1){
                        $mensaje = $guardarUsuarioSSO->getdata()->respuestaSSO->Detalle;
        
                        return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO->getdata()->respuestaSSO), 200);
                    }else{
                        
                        $mensaje = "Ha ocurrido un error al momento de eliminar el usuario.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'sso_respuesta' => $guardarUsuarioSSO->getdata()->respuestaSSO), 200);

                    }
					
				}
			}
		}
    }

    public function guardarUsuarioSSO(Request $request){
		
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
		
		if($respuesta->Estado == 1){
            $mensaje = "Se ha guardado usuario correctamente";
		
			return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'respuestaSSO' => $respuesta), 200);

		}else{
			$mensaje = "Hubo un error al momento de registrar al usuario en el SSO. Por favor verifique e intente nuevamente.";
		
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'respuestaSSO' => $respuesta), 200);
		}
}

    public function existeBaseDatos($run){
		$existe = DB::select("select count(*) as existe from ai_usuario where run = ".$run);
		return $existe[0];
	}
    public function buscarUsuarioSSO(Request $request){
		$consulta = ['rut' => $request->rut, 'AID' => config('constantes.sso_aid')];
	    $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
	    $respuestaServicio = $cliente->BuscarUsuario($consulta);
	    $respuesta =  $respuestaServicio ->BuscarUsuarioResult;
		return $respuestaServicio;
	}

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
       return response()->json(array('estado' => '1', 'respuesta_SSO' => $respuesta2), 200);
   }

   public function eliminarVigencia(Request $request){
        $consulta = [
            'rut' => $request->rut, 
            'AID' => config('constantes.sso_aid')
        ];
        $cliente = new \SoapClient(config('constantes.sso_ws'), ['encoding' => 'UTF-8', 'trace' => true]);
        $respuesta = $cliente->EliminarUsuario($consulta);
        $respuesta = $respuesta->EliminarUsuarioResult;
        return response()->json(array('estado' => '1', 'respuesta_SSO' => $respuesta), 200);
    }
}
// INICIO CZ SPRINT 77
