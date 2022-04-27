<?php

namespace App\Traits;

// INICIO CZ SPRINT 68
use Illuminate\Support\Facades\Log;
// FIN CZ SPRINT 68
use DB;
use App\Modelos\{AlertaManual,
	Persona, Predictivo, Contacto,
	Liceo, Comuna, Direccion,
	Usuarios, CasoPersonaIndice};

	
trait CasoTraitsGenericos{
	public function validarPredictivoPersonaCasoAlertas($run, $dv){
		$respuesta["integrante_familiar"] 	= false;
		$respuesta["predictivo"] 			= false;
		$respuesta["alerta"]     			= false;
		$respuesta["persona"]    			= false;
		$respuesta["caso"]       			= false;
		
		$val_pre = Predictivo::where('run', $run)->get();
		if (count($val_pre) > 0) $respuesta["predictivo"] = true;
		
		$alerta_manual = new AlertaManual();
		$val_ale = $alerta_manual->listarAlertasManualesNNA($run, null, true);
		if (count($val_ale) > 0) $respuesta["alerta"] = true;
		
		$grupo = DB::table('ai_grupo_familiar gf')
			->join('ai_caso_grupo_familiar cgf', 'gf.gru_fam_id', '=', 'cgf.gru_fam_id')
			->join('ai_caso c','cgf.cas_id', '=','c.cas_id')
			->join('ai_estado_caso ec','c.est_cas_id','=','ec.est_cas_id')
			->where('gf.gru_fam_run','=',$run)
			->where('gf.gru_fam_est','=',1)
			->where('ec.est_cas_fin', '=', 0)
			->get();
		
		if (count($grupo) > 0) $respuesta["integrante_familiar"] = true;
		
		$val_per = Persona::where("per_run", $run)->first();
		if (count($val_per) > 0){
			$respuesta["persona"] = true;
			
			$caso = DB::table('ai_caso c')
				->join("ai_estado_caso ec", "c.est_cas_id", "=", "ec.est_cas_id")
				->join("ai_caso_persona_indice cpi","cpi.cas_id","=","c.cas_id")
				->where("cpi.per_id", "=", $val_per->per_id)
				->where("ec.est_cas_fin", "!=", 1)->get();
			
			if (count($caso) > 0) $respuesta["caso"] = true;
		}
	
		return $respuesta;
	}
	
	public function asociarIntegranteFamiliarCaso($run_nna, $dv_nna, $cas_id, $id_gestor_asignado){
		try{
			DB::beginTransaction();
			
			/*Se obtiene información del NNA*/
			$datos_nna = Predictivo::where('run', $run_nna)->get();
			$datos_nna = $datos_nna[0];
			$persona_id = Persona::where("per_run", $run_nna)->where("per_dig", $dv_nna)->first();
			
			$val_inte = $this->validarPredictivoPersonaCasoAlertas($run_nna, $dv_nna);

			if ($val_inte["persona"] == false){ //NNA nunca creado en BD
				/*Se guardan datos básicos del NNA en la tabla AI_PERSONA*/
				$persona = new Persona;
				$persona->per_act = 1;
				$persona->per_run = $run_nna;
				$persona->per_dig = $datos_nna->dv_run;
				$persona->per_nom = strtoupper($datos_nna->nombres);
				$persona->per_pat = strtoupper($datos_nna->ap_paterno);
				$persona->per_mat = strtoupper($datos_nna->ap_materno);
				$persona->per_sex = $datos_nna->sexo;
				$persona->per_ani = $datos_nna->edad_agno ?? '';
				$persona->per_mes = $datos_nna->edad_meses ?? '';
				$persona->per_cod_ens = $datos_nna->cod_ens;
				$persona->per_cod_gra = $datos_nna->cod_gra;
				$persona->per_gra_let = $datos_nna->let_cur;
				
				$resultado = $persona->save();
				if (!$resultado) throw new Exception("Error al momento de guardar información del NNA. Por favor intente nuevamente.");
				
				/*Se guarda información de contacto 1 del NNA*/
				if (!is_null($datos_nna->info_nom_contacto_1) && $datos_nna->info_nom_contacto_1 != "" && !is_null($datos_nna->info_num_contacto_1) && $datos_nna->info_num_contacto_1 != "") {
					$contacto = new Contacto;
					$contacto->con_nom = $datos_nna->info_nom_contacto_1;
					$contacto->con_pat = $datos_nna->info_app_contacto_1;
					$contacto->con_mat = $datos_nna->info_apm_contacto_1;
					$contacto->con_tlf = $datos_nna->info_num_contacto_1;
					$contacto->con_ori = "RIS";
					$contacto->con_con = 1;
					$contacto->con_par = $datos_nna->relacion_contacto_1;
					
					$resultado = $persona->contactos()->save($contacto);
					if (!$resultado) throw new Exception("Error al momento de guardar información de contacto 1 del NNA. Por favor intente nuevamente.");
				}
				
				/*Se guarda información de contacto 2 del NNA*/
				if (!is_null($datos_nna->info_nom_contacto_2) && $datos_nna->info_nom_contacto_2 != "" && !is_null($datos_nna->info_num_contacto_2) && $datos_nna->info_num_contacto_2 != "") {
					$contacto = new Contacto;
					$contacto->con_nom = $datos_nna->info_nom_contacto_2;
					$contacto->con_pat = $datos_nna->info_app_contacto_2;
					$contacto->con_mat = $datos_nna->info_apm_contacto_2;
					$contacto->con_tlf = $datos_nna->info_num_contacto_2;
					$contacto->con_ori = "RIS";
					$contacto->con_con = 2;
					$contacto->con_par = null;
					
					$resultado = $persona->contactos()->save($contacto);
					if (!$resultado) throw new Exception("Error al momento de guardar información de contacto 2 del NNA. Por favor intente nuevamente.");
				}
				
				/*Se guarda información de estudios del NNA*/
				if (!is_null($datos_nna->rbd) && $datos_nna->rbd != "") {
					$dir_rbd = null;
					if (!is_null($datos_nna->dir_rbd) && $datos_nna->dir_rbd != "" && !is_null($datos_nna->dir_num_rbd) && $datos_nna->dir_num_rbd != ""){
						$dir_rbd = $datos_nna->dir_rbd." #".$datos_nna->dir_num_rbd;

						if (!is_null($datos_nna->cod_com_rbd) && $datos_nna->cod_com_rbd != ""){
							$comuna = Comuna::where('com_cod', $datos_nna->cod_com_rbd)->first();
							
							if (count($comuna) > 0) $dir_rbd .= ", ".$comuna->com_nom;
						}
					}

					$liceo = new Liceo;
					$liceo->rbd_nom = $datos_nna->nombre_rbd;
					$liceo->rbd_rbd = $datos_nna->rbd;
					$liceo->rbd_dir = $dir_rbd;
					// INICIO CZ SPRINT 68
					$liceo->RBD_COD_GRA = $datos_nna->per_COD_GRA;
					$liceo->RBD_COD_ENS = $datos_nna->per_COD_ENS;
					$liceo->RBD_GRA_LET = $datos_nna->PER_GRA_LET;
					$liceo->CAS_ID = $cas_id;
					// FIN CZ SPRINT 68
					$resultado = $persona->liceos()->save($liceo);
					if (!$resultado) throw new Exception("Error al momento de guardar información de educación del NNA. Por favor intente nuevamente.");
				}
				
				/*Se guarda información de Dirección 1 del NNA*/
				if (!is_null($datos_nna->dir_calle_1) && $datos_nna->dir_calle_1 != "" && !is_null($datos_nna->dir_num_1) && $datos_nna->dir_num_1 != ""){
					$comuna = Comuna::where('com_cod', $datos_nna->dir_com_1)->first();
					if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° 1 no válida del NNA secundario. Por Favor Verifique.");
					
					$direccion = new Direccion;
					// INICIO CZ SPRINT 68
					$max = Direccion::max('dir_id');	
					$direccion->dir_id = $max+1;
					// FIN CZ SPRINT 68
					$direccion->com_id = $comuna->com_id;
					$direccion->dir_ord = 1;
					$direccion->dir_call = $datos_nna->dir_calle_1;
					$direccion->dir_num = $datos_nna->dir_num_1;
					$direccion->dir_sit 	= $datos_nna->dir_sitio_1;
					$direccion->dir_block 	= $datos_nna->dir_block_1;
					$direccion->dir_casa 	= $datos_nna->dir_casa_1;
					// INICIO CZ SPRINT 68
					$direccion->cas_id   = $cas_id;
					// FIN CZ SPRINT
					$resultado = $persona->direcciones()->save($direccion);
					if (!$resultado) throw new Exception("Error al momento de guardar dirección 1 del NNA. Por favor intente nuevamente.");
				}
				
				/*Se guarda información de Dirección 2 del NNA*/
				if (!is_null($datos_nna->dir_calle_2) && $datos_nna->dir_calle_2 != "" && !is_null($datos_nna->dir_num_2) && $datos_nna->dir_num_2 != ""){
					$comuna = Comuna::where('com_cod', $datos_nna->dir_com_2)->first();

					
					if (count($comuna) > 0){
						$direccion = new Direccion;
						// INCIO CZ SPRINT 68
						$max = Direccion::max('dir_id');	
						$direccion->dir_id = $max+1;
						// FIN CZ SPRINT 68
						$direccion->com_id = $comuna->com_id;
						$direccion->dir_ord = 2;
						$direccion->dir_call = $datos_nna->dir_calle_2;
						$direccion->dir_num = $datos_nna->dir_num_2;
						$direccion->dir_sit 	= $datos_nna->dir_sitio_2;
						$direccion->dir_block 	= $datos_nna->dir_block_2;
						$direccion->dir_casa 	= $datos_nna->dir_casa_2;
						// INICIO CZ SPRINT 68
						$direccion->cas_id   = $cas_id;
						// FIN CZ SPRINT
						$resultado = $persona->direcciones()->save($direccion);
						if (!$resultado) throw new Exception("Error al momento de guardar dirección 2 del NNA. Por favor intente nuevamente.");
					}
				}
				
				/*Se guarda información de Dirección 3 del NNA*/
				if (!is_null($datos_nna->dir_calle_3) && $datos_nna->dir_calle_3 != "" && !is_null($datos_nna->dir_num_3) && $datos_nna->dir_num_3 != ""){
					$comuna = Comuna::where('com_cod', $datos_nna->dir_com_3)->first();
					
					if (count($comuna) > 0){
						$direccion = new Direccion;
						$direccion->com_id = $comuna->com_id;
						$direccion->dir_ord = 3;
						$direccion->dir_call = $datos_nna->dir_calle_3;
						$direccion->dir_num = $datos_nna->dir_num_3;
						$direccion->dir_sit 	= $datos_nna->dir_sitio_3;
						$direccion->dir_block 	= $datos_nna->dir_block_3;
						$direccion->dir_casa 	= $datos_nna->dir_casa_3;
						
						$resultado = $persona->direcciones()->save($direccion);
						if (!$resultado) throw new Exception("Error al momento de guardar dirección 3 del NNA. Por favor intente nuevamente.");
					}
				}
				
				
				/*Se busca la información del gestor que se esta asignando*/
				$gestor_asignado = Usuarios::where("id", $id_gestor_asignado)->get();
				$comentario = 'Se asigna caso a gestor ' . $gestor_asignado[0]->nombres . ' ' . $gestor_asignado[0]->apellido_paterno . ' ' . $gestor_asignado[0]->apellido_materno . '.';
				
				/*Se vincula al integrante con el caso*/
				$caso_indice = new CasoPersonaIndice();
				$caso_indice->cas_id = $cas_id;
				$caso_indice->per_id = $persona->per_id;
				$caso_indice->cpi_n_alertas = $datos_nna->n_alertas;
				$caso_indice->cpi_prioridad = $datos_nna->score;
				$caso_indice->periodo = $datos_nna->periodo;
				
				$resultado = $caso_indice->save();
				if (!$resultado) throw new Exception("Error al momento de vincular al integrante con el caso. Por favor intente nuevamente.");
				
				//Se obtiene las Alertas Territoriales sin gestionar que mantiene el NNA.
				$alerta_manual = new AlertaManual();
				$alertas_levantadas = $alerta_manual->listarAlertasManualesNNA($run_nna, null, true);
				
				//Se vincula las Alertas obtenidas al Caso recién creado.
				foreach ($alertas_levantadas as $valor) {
					$resultado = DB::insert("INSERT INTO AI_CASO_ALERTA_MANUAL (cas_id, ale_man_id)
								  VALUES ('".$cas_id."','".$valor->ale_man_id."')");
					
					if (!$resultado) throw new Exception("Error al momento de vincular las alertas territoriales al caso. Por favor intente nuevamente.");
				}
				
				/*Se asigna caso a gestor.*/
				$resultado = DB::table('ai_persona_usuario')->insert(['usu_id' => $id_gestor_asignado, 'run' => $run_nna, 'cas_id' => $cas_id]);
				if (!$resultado) throw new Exception("Error al momento de asignar gestor a caso. Por favor intente nuevamente.");
				
			}else if ($val_inte["persona"] == true){ //NNA ya creado en BD
				if ($val_inte["caso"] == false){
					//Actualizamos la información personal del NNA
					$persona = Persona::find($persona_id->per_id);
					$persona->per_sex = $datos_nna->sexo;
					$persona->per_ani = $datos_nna->edad_agno ?? '';
					$persona->per_mes = $datos_nna->edad_meses ?? '';
					$persona->per_cod_ens = $datos_nna->cod_ens;
					$persona->per_cod_gra = $datos_nna->cod_gra;
					$persona->per_gra_let = $datos_nna->let_cur;						
					$resultado 		  	  = $persona->save();
					if (!$resultado) throw $resultado;

					//Obtenemos la informacion de contacto del NNA
					$contactos = array();
					$contactos[0] = new \stdClass;
					$contactos[0]->con_nom = $datos_nna->info_nom_contacto_1;
					$contactos[0]->con_pat = $datos_nna->info_app_contacto_1;
					$contactos[0]->con_mat = $datos_nna->info_apm_contacto_1;
					$contactos[0]->con_tlf = $datos_nna->info_num_contacto_1;
					$contactos[0]->con_ori = "RIS";
					$contactos[0]->con_con = 1;
					$contactos[0]->con_par = $datos_nna->relacion_contacto_1;

					$contactos[1] = new \stdClass;
					$contactos[1]->con_nom = $datos_nna->info_nom_contacto_2;
					$contactos[1]->con_pat = $datos_nna->info_app_contacto_2;
					$contactos[1]->con_mat = $datos_nna->info_apm_contacto_2;
					$contactos[1]->con_tlf = $datos_nna->info_num_contacto_2;
					$contactos[1]->con_ori = "RIS";
					$contactos[1]->con_con = 2;
					$contactos[0]->con_par = null;


					foreach($contactos AS $c1 => $v1){
						if (!is_null($v1->con_tlf) && $v1->con_tlf != "" && !is_null($persona_id->per_id) && $persona_id->per_id != "" && !is_null($v1->con_nom) && $v1->con_nom != ""){
							$actualizar_contacto = DB::select("SELECT * FROM ai_contacto WHERE  con_nom LIKE '%".$v1->con_nom."%' AND con_tlf LIKE '%".$v1->con_tlf."%' AND per_id = ".$persona_id->per_id);

							$obj_con = new Contacto;
							if (count($actualizar_contacto) > 0) $obj_con = Contacto::find($actualizar_contacto[0]->con_id);

							$obj_con->con_nom = $v1->con_nom;
							$obj_con->con_pat = $v1->con_pat;
							$obj_con->con_mat = $v1->con_mat;
							$obj_con->con_tlf = $v1->con_tlf;
							$obj_con->con_ori = $v1->con_ori;
							$obj_con->con_con = $v1->con_con;
							$obj_con->con_par = $v1->con_par;
							$obj_con->per_id  = $persona_id->per_id;
							$resultado 		  = $obj_con->save();
							if (!$resultado) throw $resultado;
						}
					}

					//Obtenemos la informacion de ubicación del NNA
					$direcciones = array();
					$direcciones[0] = new \stdClass;
					$direcciones[0]->dir_call 	= $datos_nna->dir_calle_1;
					$direcciones[0]->dir_num 	= $datos_nna->dir_num_1;
					$direcciones[0]->dir_com 	= $datos_nna->dir_com_1;
					$direcciones[0]->dir_ord 	= 1;
					$direcciones[0]->dir_sit 	= $datos_nna->dir_sitio_1;
					$direcciones[0]->dir_block 	= $datos_nna->dir_block_1;
					$direcciones[0]->dir_casa 	= $datos_nna->dir_casa_1;

					$direcciones[1] = new \stdClass;
					$direcciones[1]->dir_call 	= $datos_nna->dir_calle_2;
					$direcciones[1]->dir_num 	= $datos_nna->dir_num_2;
					$direcciones[1]->dir_com 	= $datos_nna->dir_com_2;
					$direcciones[1]->dir_ord 	= 2;
					$direcciones[1]->dir_sit 	= $datos_nna->dir_sitio_2;
					$direcciones[1]->dir_block 	= $datos_nna->dir_block_2;
					$direcciones[1]->dir_casa 	= $datos_nna->dir_casa_2;

					$direcciones[2] = new \stdClass;
					$direcciones[2]->dir_call 	= $datos_nna->dir_calle_3;
					$direcciones[2]->dir_num 	= $datos_nna->dir_num_3;
					$direcciones[2]->dir_com 	= $datos_nna->dir_com_3;
					$direcciones[2]->dir_ord 	= 3;
					$direcciones[2]->dir_sit 	= "";
					$direcciones[2]->dir_block 	= "";
					$direcciones[2]->dir_casa 	= "";

					foreach ($direcciones AS $c1 => $v1){
						if (!is_null($v1->dir_call) && $v1->dir_call != "" && !is_null($v1->dir_num) && $v1->dir_num != "" && !is_null($persona_id->per_id) && $persona_id->per_id != ""){
					
							$guardar_direccion = true;
							$comuna = Comuna::where('com_cod', $v1->dir_com)->first();

							if ($c1 == 0){
								if (count($comuna) == 0) throw new \Exception("Código de comuna de la Dirección N° ".$c1." no válida del NNA secundario. Por Favor Verifique.");
								
							}else{
								if (count($comuna) == 0) $guardar_direccion = false;

							}


							if ($guardar_direccion){
								$actualizar_direccion = DB::select("SELECT * FROM ai_direccion WHERE dir_call LIKE '%".$v1->dir_call."%' AND dir_num LIKE '%".$v1->dir_num."%' AND per_id = ".$persona_id->per_id);

								//INICIO CZ SPRINT 68 
								if (count($actualizar_direccion) > 0){
									$obj_dir = Direccion::find($actualizar_direccion[0]->dir_id);
								}else{
									$max = Direccion::max('dir_id');
								$obj_dir = new Direccion;							
									$obj_dir->dir_id = $max+1;	
								} 
								// FIN CZ SPRINT 68
								$obj_dir->dir_call 	= $v1->dir_call;
								$obj_dir->dir_num 	= $v1->dir_num;
								$obj_dir->com_id 	= $comuna->com_id;
								$obj_dir->dir_ord 	= $v1->dir_ord;
								$obj_dir->dir_sit 	= $v1->dir_sit;
								$obj_dir->dir_block = $v1->dir_block;
								$obj_dir->dir_casa 	= $v1->dir_casa;
								$obj_dir->per_id 	= $persona_id->per_id;
								// INICIO CZ SPRINT 68
								$obj_dir->cas_id   = $cas_id;
								// FIN CZ SPRINT
								$resultado 			= $obj_dir->save();
								if (!$resultado) throw $resultado;
							}

						}
					}

					//Agregamos o actualizamos la información de educación
					if (!is_null($datos_nna->rbd) && $datos_nna->rbd != ""){
						$actualizar_liceo = DB::select("SELECT * FROM ai_rbd WHERE rbd_rbd LIKE '%".$datos_nna->rbd."%' AND per_id = ".$persona_id->per_id);

						$liceo = new Liceo;
						if (count($actualizar_liceo) > 0) $liceo = Liceo::find($actualizar_liceo[0]->rbd_id);

						$dir_rbd = null;
						if (!is_null($datos_nna->dir_rbd) && $datos_nna->dir_rbd != "" && !is_null($datos_nna->dir_num_rbd) && $datos_nna->dir_num_rbd != ""){
							$dir_rbd = $datos_nna->dir_rbd." #".$datos_nna->dir_num_rbd;

							if (!is_null($datos_nna->cod_com_rbd) && $datos_nna->cod_com_rbd != ""){
								$comuna = Comuna::where('com_cod', $datos_nna->cod_com_rbd)->first();
								
								if (count($comuna) > 0) $dir_rbd .= ", ".$comuna->com_nom;
							}
						}

						$liceo->rbd_nom = $datos_nna->nombre_rbd;
						$liceo->rbd_rbd = $datos_nna->rbd;
						$liceo->rbd_dir = $dir_rbd;
						$liceo->per_id 	= $persona_id->per_id;
						// INICIO CZ SPRINT 68
						$liceo->RBD_COD_GRA = $datos_nna->per_COD_GRA;
						$liceo->RBD_COD_ENS = $datos_nna->per_COD_ENS;
						$liceo->RBD_GRA_LET = $datos_nna->PER_GRA_LET;
						$liceo->CAS_ID = $cas_id;
						// FIN CZ SPRINT 68
						$resultado 		= $liceo->save();
						if (!$resultado) throw $resultado;
					}

					/*Se busca la información del gestor que se esta asignando*/
					$gestor_asignado = Usuarios::where("id", $id_gestor_asignado)->get();
					$comentario = 'Se asigna caso a gestor ' . $gestor_asignado[0]->nombres . ' ' . $gestor_asignado[0]->apellido_paterno . ' ' . $gestor_asignado[0]->apellido_materno . '.';
					
					/*Se vincula al integrante con el caso*/
					$caso_indice = new CasoPersonaIndice();
					$caso_indice->cas_id = $cas_id;
					$caso_indice->per_id = $persona_id->per_id;
					$caso_indice->cpi_n_alertas = $datos_nna->n_alertas;
					$caso_indice->cpi_prioridad = $datos_nna->score;
					$caso_indice->periodo = $datos_nna->periodo;
					$resultado = $caso_indice->save();
					if (!$resultado) throw new Exception("Error al momento de vincular al integrante con el caso. Por favor intente nuevamente.");
					
					//Se obtiene las Alertas Territoriales sin gestionar que mantiene el NNA.
					$alerta_manual = new AlertaManual();
					$alertas_levantadas = $alerta_manual->listarAlertasManualesNNA($run_nna, null, true);
					
					//Se vincula las Alertas obtenidas al Caso recién creado.
					foreach ($alertas_levantadas as $valor) {
						$resultado = DB::insert("INSERT INTO AI_CASO_ALERTA_MANUAL (cas_id, ale_man_id)
								  VALUES ('".$cas_id."','".$valor->ale_man_id."')");
						if (!$resultado) throw new Exception("Error al momento de vincular las alertas territoriales al caso. Por favor intente nuevamente.");
					}
					
					/*Se asigna caso a gestor.*/
					$resultado = DB::table('ai_persona_usuario')->insert(['usu_id' => $id_gestor_asignado, 'run' => $run_nna, 'cas_id' => $cas_id]);
					if (!$resultado) throw new Exception("Error al momento de asignar gestor a caso. Por favor intente nuevamente.");
					
				}
			}
			
			DB::commit();
			$mensaje = "Integrante familiar se vincula al caso con éxito.";
			return $respuesta = ['estado' => '1', 'mensaje' => $mensaje];
			
		}catch(\Exception $e){
			DB::rollback();
			
			Log::info('error ocurrido:'.$e);
			$mensaje = "Error al momento de vincular integrante con caso. Por favor intente nuevamente.";
			return $respuesta = ['estado' => '0', 'mensaje' => $mensaje];
		}
	}

// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public function ObtenerCasoActualAbierto($run, $dv,$idcaso){
		// FIN CZ SPRINT 63 Casos ingresados a ONL
		//SPRINT 55
			$caso = array();
			if (!is_null($run) && $run != "" && !is_null($dv) && $dv != ""){
				// $caso = DB::select("SELECT * FROM ai_persona p
				// 		LEFT JOIN ai_caso_persona_indice cpi ON cpi.per_id = p.per_id 
				// 		LEFT JOIN ai_caso c ON cpi.cas_id = c.cas_id
				// 		LEFT JOIN ai_caso_estado_caso cec ON c.cas_id = cec.cas_id
				// 		LEFT JOIN ai_estado_caso ec ON cec.est_cas_id = ec.est_cas_id 
				// 		,(SELECT cas_id, max(cas_est_cas_fec) AS max_fec FROM ai_caso_estado_caso GROUP BY cas_id) subQuery
				// 		WHERE subQuery.cas_id = cpi.cas_id AND subQuery.max_fec = cec.cas_est_cas_fec 
				// 		AND p.per_run = ".$run." AND (ec.est_cas_id = ".config('constantes.egreso_paf')." OR ec.est_cas_fin != 1) AND rownum = 1 ORDER BY c.created_at DESC");	
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
				$caso = DB::select("SELECT * FROM ai_persona p
						LEFT JOIN ai_caso_persona_indice cpi ON cpi.per_id = p.per_id 
						LEFT JOIN ai_caso c ON cpi.cas_id = c.cas_id
						LEFT JOIN ai_caso_estado_caso cec ON c.cas_id = cec.cas_id
						LEFT JOIN ai_estado_caso ec ON cec.est_cas_id = ec.est_cas_id 
					WHERE c.cas_id = {$idcaso}
						AND p.per_run = ".$run." AND (ec.est_cas_id = ".config('constantes.egreso_paf')." OR ec.est_cas_fin != 1) AND rownum = 1 ORDER BY c.created_at DESC");	
				// INICIO CZ SPRINT 63 Casos ingresados a ONL
			}
			return $caso;
	}
}