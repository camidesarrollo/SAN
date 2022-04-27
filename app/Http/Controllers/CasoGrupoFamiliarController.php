<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Modelos\{Caso, CasoGrupoFamiliar, 
	ParentescoGrupoFamiliar, 
	GrupoFamiliar, 
	Persona, 
	CasoPersonaIndice
};
use App\Traits\CasoTraitsGenericos;
use Session;


class CasoGrupoFamiliarController extends Controller
{
	use CasoTraitsGenericos;
	
	protected $caso;
	
	protected $casoGrupoFamiliar;
	
	protected $parentescoGrupoFamiliar;
	
	protected $grupoFamiliar;
	
	public function __construct(
		Caso                    $caso,
		CasoGrupoFamiliar       $casoGrupoFamiliar,
		ParentescoGrupoFamiliar $parentescoGrupoFamiliar,
		GrupoFamiliar           $grupoFamiliar
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->caso                    = $caso;
		$this->casoGrupoFamiliar       = $casoGrupoFamiliar;
		$this->parentescoGrupoFamiliar = $parentescoGrupoFamiliar;
		$this->grupoFamiliar           = $grupoFamiliar;
	}
	
	public function listarGrupoFamiliar(Request $request){
		$lis_gru_fam = "";
		if (isset($request->caso_id) && $request->caso_id != ""){ 
			if ($request->has('grupo_familiar_activo')) {
		 		$lis_gru_fam = $this->casoGrupoFamiliar->listarGrupoFamiliar($request->caso_id,null, 1, null);
			}else{
		 		$lis_gru_fam = $this->casoGrupoFamiliar->listarGrupoFamiliar($request->caso_id);
			}
		}

		 $data		= new \stdClass();
		 $data->data = $lis_gru_fam;
		
		 echo json_encode($data); exit;
	}
	
	public function listarGrupoFamiliarAraña(Request $request){
		 $lis_gru_fam = "";
		 if (isset($request->caso_id) && $request->caso_id != "") $lis_gru_fam = $this->casoGrupoFamiliar->listarGrupoFamiliar($request->caso_id);

		 foreach ($lis_gru_fam as $persona){
		 	$ai_persona = Persona::where('per_run',$persona->gru_fam_run)->get();
			$persona->indice = ($ai_persona->count()>0)?'1':'0';
		 }

		 return collect($lis_gru_fam);
		
	}

	public function accionesFormularioFamiliar(Request $request){
	     try{
		    DB::beginTransaction();
	     
		    $respuesta = "";
		    $edicion = false;
	        
	        switch ($request->option){
	        	case 1: //Buscar información integrante familiar
					$edicion = true;
					
					$respuesta = $this->casoGrupoFamiliar->listarGrupoFamiliar(null, $request->gru_fam_id);
					
					if (!$respuesta){
						DB::rollBack();
						$mensaje = "Error al recolectar información del familiar solicitado. Por favor intente nuevamente.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}
	        	break;
		
				case 2: //Registrar nuevo integrante familiar
					// INICIO CZ SPRINT 58
					$run_grupoFamiliar = "";
					$dv_grupoFamiliar = "";

					if($request->run != null){
						$run_grupoFamiliar = $request->run;
						$dv_grupoFamiliar = $request->dv;
					}else{
						$grupoFamiliar_id	= GrupoFamiliar::max('gru_fam_id');
						$grupoFamiliar_id  = $grupoFamiliar_id + 1;
						$run_grupoFamiliar  = $grupoFamiliar_id.strtotime(now());

						$dv_grupoFamiliar = "S";
					}

					$val_nna = $this->validarPredictivoPersonaCasoAlertas($run_grupoFamiliar, $dv_grupoFamiliar);
			
					//Validamos que persona no se encuentre ya como integrante dentro del grupo familiar del caso
					$int_caso = DB::table('ai_caso_grupo_familiar cgf')
								->join('ai_grupo_familiar gf','cgf.gru_fam_id','=','gf.gru_fam_id')
								->where('cgf.cas_id', '=', $request->cas_id)
								->where('gf.gru_fam_run','=', $run_grupoFamiliar)
								->get();
				
					if (count($int_caso) > 0){
						DB::rollback();
						$mensaje = "No se puede vincular integrante debido a que ya se encuentra vinculado en el caso.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					} 

					//validamos que persona no se encuentre asociado algun caso abierto como integrante de un grupo familiar
				    if ($val_nna["integrante_familiar"] == true){
						DB::rollback();
						$mensaje = "No se puede vincular integrante debido a que ya se encuentra vinculado en otro caso actualmente abierto.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
				  
					}

					$nna_vinculado_caso = false;
					$caso = CasoPersonaIndice::leftJoin('ai_persona', 'ai_persona.per_id', '=', 'ai_caso_persona_indice.per_id')->where('ai_persona.per_run','=', $run_grupoFamiliar)->where('ai_caso_persona_indice.cas_id', '=', $request->cas_id)->get();
					if (count($caso) > 0){
						$nna_vinculado_caso = true;
					
					}

					$fec_cre = now()->format('d/m/Y');
					if ($val_nna["caso"] == false || $nna_vinculado_caso == true){
						$data = ["gru_fam_nom" 		=> $request->nom,
								"gru_fam_ape_pat" 	=> $request->paterno,
								"gru_fam_ape_mat" 	=> $request->materno,
								"gru_fam_run" 		=> $run_grupoFamiliar,
								"gru_fam_dv" 		=> $dv_grupoFamiliar,
								"gru_fam_nac" 		=> Carbon::createFromFormat( 'd/m/Y', $request->nac),
								"gru_fam_sex"		=> $request->sexo,
								"gru_fam_par" 		=> $request->parentesco,
								"gru_fam_est" 		=> $request->estado,
								"gru_fam_telefono" 	=> $request->fono,
								"gru_fam_email" 	=> $request->email,
								"gru_fam_fue"		=> "SAN",
								"gru_fam_fec_cre"	=> Carbon::createFromFormat( 'd/m/Y', $fec_cre)
							];
						
						$resultado = GrupoFamiliar::create($data);
						if (!$resultado){
							DB::rollback();
							$mensaje = "Error al guardar información del integrante familiar ingresado. Por favor intente nuevamente.";
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
						}
						
						
						$registro_nuevo = new CasoGrupoFamiliar();
						$registro_nuevo->cas_id = $request->cas_id;
						$registro_nuevo->gru_fam_id = $resultado->gru_fam_id;
						
						$resultado = $registro_nuevo->save();
						if (!$resultado){
							DB::rollback();
							$mensaje = "Error al guardar información del integrante familiar ingresado. Por favor intente nuevamente.";
							return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
						}
						
						if ($request->edad < 18){
							if ($val_nna["predictivo"] == true && $nna_vinculado_caso == false){
								$resultado = $this->asociarIntegranteFamiliarCaso($run_grupoFamiliar, $dv_grupoFamiliar, $request->cas_id, $request->ges_id);
								
								if ($resultado["estado"] != 1){
									DB::rollback();
									$mensaje = "Ocurrio un Error al Vincular Integrante Familiar con Caso. Por Favor Verifique.";
									return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
								}
							}
						}
					}else if ($val_nna["caso"] == true){
						DB::rollback();
						$mensaje = "No se puede vincular integrante debido a que ya se encuentra con un caso actualmente abierto.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}
					// FIN CZ SPRINT 58
				break;
				
				case 3: //Actualizar integrante familiar
					$actualizar_registro = GrupoFamiliar::where("gru_fam_id", "=", $request->id)->first();
					$actualizar_registro->gru_fam_nom 		= $request->nom;
					$actualizar_registro->gru_fam_ape_pat 	= $request->paterno;
					$actualizar_registro->gru_fam_ape_mat 	= $request->materno;
					$actualizar_registro->gru_fam_run 		= $request->run;
					$actualizar_registro->gru_fam_dv 		= $request->dv;
					$actualizar_registro->gru_fam_nac 		= Carbon::createFromFormat( 'd/m/Y', $request->nac);
					$actualizar_registro->gru_fam_sex 		= $request->sexo;
					$actualizar_registro->gru_fam_par 		= $request->parentesco;
					$actualizar_registro->gru_fam_est 		= $request->estado;
					$actualizar_registro->gru_fam_telefono 	= $request->fono;
					$actualizar_registro->gru_fam_email 	= $request->email;
					$resultado 								= $actualizar_registro->save();
					
					if (!$resultado){
						DB::rollback();
						$mensaje = "Error al actualizar información del integrante familiar. Por favor intente nuevamente.";
						return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'edicion' => $edicion), 200);
					}
				break;
			}
		 
			DB::commit();
	     
		    return response()->json(array('estado' => '1', 'respuesta' => $respuesta, 'edicion' => $edicion), 200);
		 }catch (\Exception $e){
			 DB::rollback();
			 Log::info('error ocurrido:'.$e);
			
			 return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		 }
	}
}