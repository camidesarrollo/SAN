<?php

namespace App\Http\Controllers;
use App\Modelos\{
    Region,
    Comuna,
    Funcion,
    Hito,
    LugarBitacora,
    TipoActor,
    BitacoraComunal,
    DireccionBit,
    Actividad,
    EstadoProceso,
    UsuarioProceso,
    ProcesoAnual,
    ProcesoEstadoProceso,
    UsuarioActividad,
    UsuarioBitacora,
    Perfil,
    DocumentoGcomunitaria,
    ComPriorizada,
    LugarGcomunitaria,
    ZonaRural,
    GradoFormalizacion,
    TipoOrganizacion,
    TipoInstServicio,
    FactoresGC,
    RespuestaFactoresGC,
    BienesComnitarios,
    DgOrgComunal,
    DgInstServicios,
    DgIdentidadCom,
    DgBienesComunes,
    DiagnosticoParticipativo,
    LineaBase,
    PreguntasLB,
    DerechoParticipacion,
    RespuestasLB,
    MatrizEjesTematico,
    MatrizIdentificacionProblemaNNA,
    MatrizRangoEtario,
    MatrizRangoEtarioProblema,
    MatrizFactores,
    AnexoDPC,
    IntegrantesDPC,
    InformeDPC,
    InformeCaractGenerales,
    InformeEjecucion,
    InformePEC,
    // INICIO CZ SPRINT 70
    LineaBaseContinuidadProyecto,
    LineaBaseDerechoNinos,
    LineaBaseOrganizacionesComunitarias,
    LineaBaseProgramasSocialesPrestaciones,
    LineaBaseServiciosComunales,
    LineaBaseIdentificacion,
    LineaBaseBienesComunitarios,
    LineaBaseOtro,
    ContinuidadProyecto

    // FIN CZ SPRINT 70
};

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Session;
use DataTables;
use PDF;
use Carbon\Carbon;
use App\Traits\CasoTraitsGenericos;
use Illuminate\Support\Facades\Validator;
//INICIO CH
use Illuminate\Support\Facades\Redirect;
//FIN CH
// INICIO CZ SPRINT 67
use Illuminate\Support\Facades\File; 
// FIN CZ SPRINT 67
use App\Http\Controllers\Console;
use Freshwork\ChileanBundle\Rut;
use App\Exports\reportes\descargarReporteMatrizFactoresExportable;
use App\Exports\reportes\descargarReporteMatrizIdentProbExportable;
use App\Exports\reportes\descargarReporteMatrizRangoEtarioExportable;
use App\Exports\reportes\descargarReportePlanEstrategico;
use App\Exports\reportes\descargarReporteInformePlanEstrategico;

class GestionComunitariaController extends Controller
{
    protected $hito;	
	protected $actor;	
    protected $lugar;
    // protected $reglas_doc = [
	// 	'archivo' => 'file|mimes:pdf,jpeg,png|max:3072'
    // ];
    
    // INICIO CZ SPRINT 60
    protected $reglas_doc = [
        	'archivo' => 'file|mimes:pdf,jpeg,png|max:4096'
    ];
    // FIN CZ SPRINT 60
    public function __construct(
        Hito            $hito,
        TipoActor       $actor,
        LugarBitacora   $lugar,
        Perfil          $perfil

    )
    {
        $this->hito     = $hito;
        $this->actor    = $actor;
        $this->lugar    = $lugar;
        $this->perfil   = $perfil;
    }
    
    public function planIndex(){

		try {

            $icono = Funcion::iconos(32);
            $region = Region::all();
            $comuna = Comuna::all();
            $hito  = Hito::where("cb_hito_act", "=", 1)->get();
            $actor = TipoActor::where("cb_tip_act_act", "=", 1)->get();
            $lugar = LugarBitacora::where("cb_lug_bit_act", "=", 1)->get();
            $bit_id = 8;
        
            $act_dir = DireccionBit::where('bit_id', '=', $bit_id)->first();
            
            $dir_est = count($act_dir);
			
			return view('gestor_comunitario.plan_comunal.main',[
                'icono'=>$icono,
                'hito'=>$hito,
                'actor'=>$actor, 
                'lugar' => $lugar, 
                'region' => $region, 
                'comuna' => $comuna, 
                'bit_id' => $bit_id,
                'dir_est' => $dir_est, 
                'dir_reg' => $act_dir->ciudad_id,
                'dir_com' => $act_dir->com_id,
                'dir_cal' => $act_dir->calle_id,
                'dir_num' => $act_dir->act_dir_num
            ]
            );

		} catch(\Exception $e) {
			
			Log::error('error: '.$e);
			$mensaje = "Hubo error al momento de buscar la información solicitada. Por favor intente nuevamente o contacte con el administrador.";
			
			return view('layouts.errores')->with(['mensaje'=>$mensaje]);
		}
	}
    
	public function insPlanEstrategico(Request $request){
	    $idProb = $request->idProb;
	    $Objetivo = $request->Objetivo;
	    $Resultado = $request->Resultado;
	    $Indicador = $request->Indicador;	    
	    $result = DB::insert("insert into AI_PLAN_ESTRATEGICO(pe_objetivo, pe_resultado, pe_indicador, PE_MAT_IDE_PRO_NNA_ID)
        values('".$Objetivo."', '".$Resultado."', '".$Indicador."', ".$idProb.")");
	    return DB::getPdo()->lastInsertId('SEQ_AI_PLAN_ESTRATEGICO');
	}
	
	//INICIO DC SPRINT 67
	public function getPlanEstrategico(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
        // INICIO CZ SPRINT 67
	    $result = DB::select("select
         mipn.mat_ide_pro_nna_id as idprob,
          pe_id as id,
          mipn.mat_ide_pro_nna_pro_iden as prob_priorizado,
          pe.pe_objetivo as objetivo,
          pe_resultado as resultado,
          pe_indicador as indicador,
          (select count (*) from ai_actividad_pec where act_id_pe = pe.pe_id ) as num_acti  
          from ai_matriz_ide_pro_nna mipn
          left join AI_PLAN_ESTRATEGICO pe
          on mipn.mat_ide_pro_nna_id = pe.pe_mat_ide_pro_nna_id
          where mipn.mat_ide_pro_nna_id IN (select AI_MATRIZ_IDE_PRO_NNA.mat_ide_pro_nna_id from AI_MATRIZ_IDE_PRO_NNA left join AI_MATRIZ_EJES_TEMATICOS met 
          on AI_MATRIZ_IDE_PRO_NNA.MAT_EJE_TEM_ID = MET.MAT_EJE_TEM_ID inner join 
        AI_MATRIZ_RANGO_ETARIO_PROB mrep2 on AI_MATRIZ_IDE_PRO_NNA.MAT_IDE_PRO_NNA_ID = MREP2.MAT_IDE_PRO_NNA_ID 
        where AI_MATRIZ_IDE_PRO_NNA.PRO_AN_ID = {$request->pro_an_id}) and mipn.pro_an_id = ".$request->pro_an_id);
        // FIN CZ SPRINT 67
	    $data->data = $result;
	    echo json_encode($data); exit;
	}
	//FIN DC SPRINT 67
	public function getDatosPec(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $result = DB::select("select
          pe_id as id,
          PE_RESULTADO2 as resultado,
          PE_FACILITADORES as facilitadores,
          PE_OBSTACULIZADORES as obstaculizadores,
          PE_APRENDIZAJES as aprendizajes
          from AI_PLAN_ESTRATEGICO 
          where pe_id = ".$request->id);
	    echo json_encode($result); exit;
	}
	//INICIO DC
	public function guardarDatosPec(Request $request){
	    $id = $request->idProb;
	    $resultado = $request->inf_resultado;
	    $Facilitadores = $request->inf_faqcilitadores;
	    $Obstaculizadores = $request->inf_obstaculizaciones;
	    $Aprendizajes = $request->inf_aprendisaje;
	    $doc_paf = DB::update("update AI_PLAN_ESTRATEGICO set
          PE_RESULTADO2 = '".$resultado."',
          PE_FACILITADORES = '".$Facilitadores."',
          PE_OBSTACULIZADORES = '".$Obstaculizadores."',
          PE_APRENDIZAJES = '".$Aprendizajes."'
          where pe_id = ".$id);
	    return 1;
	}
	//FIN DC
	public function verificaEstadoPec(Request $request){
	    $result = DB::select("select est_pro_id from ai_proceso_anual
        where pro_an_id = ".$request->pro_an_id);
	    
	    echo json_encode($result); exit;
	}
	
	public function validaObjetivos(Request $request){
        // INICIO CZ SPRINT 67
	    $result = DB::select("select
          CASE WHEN pe.pe_objetivo IS NULL THEN 0 ELSE 1 END as existe
          from ai_matriz_ide_pro_nna mipn
          left join AI_PLAN_ESTRATEGICO pe
          on mipn.mat_ide_pro_nna_id = pe.pe_mat_ide_pro_nna_id
          where mipn.mat_ide_pro_nna_id IN (select AI_MATRIZ_IDE_PRO_NNA.mat_ide_pro_nna_id from AI_MATRIZ_IDE_PRO_NNA left join AI_MATRIZ_EJES_TEMATICOS met 
          on AI_MATRIZ_IDE_PRO_NNA.MAT_EJE_TEM_ID = MET.MAT_EJE_TEM_ID inner join 
        AI_MATRIZ_RANGO_ETARIO_PROB mrep2 on AI_MATRIZ_IDE_PRO_NNA.MAT_IDE_PRO_NNA_ID = MREP2.MAT_IDE_PRO_NNA_ID 
        where AI_MATRIZ_IDE_PRO_NNA.PRO_AN_ID = {$request->pro_an_id})
        and mipn.pro_an_id =".$request->pro_an_id);
	    // FIN CZ SPRINT 67
	    
	    echo json_encode($result); exit;
	}
	
	public function getAnexosPec(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $result = DB::select("select
        dg.doc_gc_id,  
        dg.DOC_NOM,
        tdg.TIP_NOM,
        usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as usuario
        from ai_documentos_gc dg
        inner join ai_tipo_doc_gc tdg
        on dg.tip_id = tdg.tip_id
        inner join ai_usuario usu
        on dg.USU_ID = usu.id
        where dg.TIP_ID = 8 and pro_an_id = ".$request->pro_an_id);
//CZ SPRINT 73
        $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
        $comuna = Comuna::where('com_id',$proceso->com_id)->first();
        $destinationPath = 'doc/'.$comuna->com_nom;
        foreach($result as $key=> $documento){
        
            $ruta = "../../".$destinationPath."/".$documento->doc_nom;
            $ruta_file = $destinationPath."/".$documento->doc_nom;
            if (!is_file($ruta_file)) {
                $ruta = "../../doc/".$documento->doc_nom;
            }
            $result[$key]->ruta = $ruta;
        }
        //CZ SPRINT 73
	    $data->data = $result;
	    echo json_encode($data); exit;
	}
	
	
	public function obtenerPlanEstrategico(Request $request){
	    $result = DB::select("select
          pe_id as id,
          mipn.mat_ide_pro_nna_pro_iden as prob_priorizado,
          pe.pe_objetivo as objetivo,
          pe_resultado as resultado,
          pe_indicador as indicador,
          mipn.mat_ide_pro_nna_id as idprob
          from ai_matriz_ide_pro_nna mipn
          left join AI_PLAN_ESTRATEGICO pe
          on mipn.mat_ide_pro_nna_id = pe.pe_mat_ide_pro_nna_id
          where mipn.mat_ide_pro_nna_id = ".$request->idprob." 
          and pe_id = ".$request->idPlan);
	    echo json_encode($result); exit;
	}
	
	//INICIO DC SPRINT 67
	public function getActividadPlanEstrategico(Request $request){
	    if($request->idPlan != ''){
	    $result = DB::select("select 
        ACT_NOMBRE,
        ACT_CHECKRELCOM, 
        ACT_CHECKTALLCOM, 
        ACT_CHECKINICOM, 
        ACT_METODOLOGIA, 
        ACT_RESPONSABLES, 
        ACT_PLAZO,
        act_checkcomDifCap, 
        act_checkotros
        from AI_ACTIVIDAD_PEC
        where ACT_ID_PE = ".$request->idPlan);
	    }else{
	        $result = '';
	    }
	    echo json_encode($result); exit;
	}
	//FIN DC SPRINT 67
	public function getActividadInf(Request $request){
	    $data   = new \stdClass();
	    $data->data = array();
	    $result = DB::select("select
        ACT_ID_PE,
        ACT_NOMBRE,
        ACT_METODOLOGIA,
        ACT_RESPONSABLES,
        ACT_PLAZO
        from AI_ACTIVIDAD_PEC
        where ACT_ID_PE = ".$request->idPlan);
	    $data->data = $result;
	    echo json_encode($data); exit;
	}
	
	public function getEstrategiaPlan(Request $request){
	    
	    $result = DB::select("select
        act_checkrelcom, 
        act_checktallcom, 
        act_checkinicom
        from AI_ACTIVIDAD_PEC 
        where ACT_ID_PE = ".$request->id. " and ACT_ID = ".$request->id_act);
	    return json_encode($result); exit;
	}
	
	public function editPlanEstrategico(Request $request){
	    
	    $idProb = $request->idProb;
	    $idPlan = $request->idPlan;
	    $Objetivo = $request->Objetivo;
	    $Resultado = $request->Resultado;
	    $Indicador = $request->Indicador;
	    DB::update("update AI_PLAN_ESTRATEGICO 
        set pe_objetivo = '".$Objetivo."',
        pe_resultado = '".$Resultado."',
        pe_indicador = '".$Indicador."'
        where pe_id = ".$idPlan." 
        and PE_MAT_IDE_PRO_NNA_ID = ".$idProb);
	    return $idPlan;
	}
	
	//INICIO DC SPRINT 67
	public function editActividadPe(Request $request){
	    
	    $Actividad = $request->Actividad;
	    $checkRelCom = $request->checkRelCom;
	    $checkTallCom = $request->checkTallCom;
	    $checkIniCom = $request->checkIniCom;
	    $Metodologia = $request->Metodologia;
	    $Responsables = $request->Responsables;
	    $Plazo = $request->Plazo;
	    $idPlan = $request->idPlan;
	    $ActComDifCap = $request->ActComDifCap;
	    $otro = $request->otro;
	    $result = DB::insert("insert into AI_ACTIVIDAD_PEC(ACT_NOMBRE, ACT_CHECKRELCOM, ACT_CHECKTALLCOM, ACT_CHECKINICOM, ACT_METODOLOGIA, ACT_RESPONSABLES, ACT_PLAZO, ACT_ID_PE, act_checkcomDifCap, act_checkotros)
        values('".$Actividad."', ".$checkRelCom.", ".$checkTallCom.", ".$checkIniCom.", '".$Metodologia."', '".$Responsables."', ".$Plazo.", ".$idPlan.", ".$ActComDifCap.", '".$otro."')");
	    return 1;
	}
	//FIN DC SPRINT 67
	
	public function deleteActividadPe(Request $request){
	    $idPlan = $request->idPlan;
	    $result = DB::delete("delete from AI_ACTIVIDAD_PEC where act_id_pe = ".$idPlan);
	    return $idPlan;
	}
	
	public function guardarInformePe(Request $request){
	    $nomGestorComCar = $request->inf_nomGestorComCar;
	    $comuna = $request->h_inf_comuna;
	    $com_pri = $request->h_inf_com_pri;
	    $fec_pri_con = $request->info_fec_pri_con;
	    $fec_ter_dpc = $request->info_fec_ter_dpc;
	    $info_intro = $request->info_intro;
	    $info_result = $request->info_result;
	    $info_con_rec = $request->info_con_rec;
	    $pro_an_id = $request->pro_an_id_inf;
	    $usuario = session()->all()["id_usuario"];
	    DB::beginTransaction();
	    if (!isset($pro_an_id) || $pro_an_id == ""){
	        $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";	        
	        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	    }
	    	    
	    if($request->info_fec_pri_con == ""){
	        
	        $info_fec_pri = $request->info_fec_pri_con;
	    }else{
	        $fec_pri_con = explode(" ", $request->info_fec_pri_con);
	        $info_fec_pri = Carbon::createFromFormat('m/d/Y',$fec_pri_con[0]);
	    }
	    
	    if($request->info_fec_ter_dpc == ""){
	        $info_fec_ter = $request->info_fec_ter_dpc;
	    }else{
	        $fec_ter_dpc = explode(" ", $request->info_fec_ter_dpc);
	        $info_fec_ter = Carbon::createFromFormat('m/d/Y',$fec_ter_dpc[0]);
	    }
	    
	    $info_diag = InformePEC::where("pro_an_id",$pro_an_id)->first();
        //CZ SPRINT 73
	    if(count($info_diag) == 0){	        
            $info_diag =  new InformePEC();  
            $info_diag->INFO_RESP = $nomGestorComCar;
            $info_diag->INFO_COM = $comuna;
            $info_diag->COM_PRI_ID = $com_pri;
            $info_diag->INFO_FEC_PRI = $info_fec_pri;
            $info_diag->INFO_FEC_TER = $info_fec_ter;
            $info_diag->INFO_INTRO = $info_intro;
            $info_diag->INFO_ACT_PLAN = $info_result;
            $info_diag->INFO_ACT_REAL = $info_con_rec;
            $info_diag->USU_ID = $usuario;
            $info_diag->PRO_AN_ID  = $pro_an_id;    
            $resultado = $info_diag->save();    
	    }else{
            $info_diag->INFO_RESP = $nomGestorComCar;
            $info_diag->INFO_COM = $comuna;
            $info_diag->COM_PRI_ID = $com_pri;
            $info_diag->INFO_FEC_PRI = $info_fec_pri;
            $info_diag->INFO_FEC_TER = $info_fec_ter;
            $info_diag->INFO_INTRO = $info_intro;
            $info_diag->INFO_ACT_PLAN = $info_result;
            $info_diag->INFO_ACT_REAL = $info_con_rec;
            $info_diag->USU_ID = $usuario;
            $info_diag->PRO_AN_ID = $pro_an_id;
            $resultado = $info_diag->save();    
	    }

        if(!$resultado){
            DB::commit();
            return response()->json(array('estado' => '0', "mensaje" => 'Ha ocurrido un error al momento de guardar el informe PEC'), 200);
        }else{
	    DB::commit();
	    return response()->json(array('estado' => '1', "mensaje" => 'Se guardado el informe PEC'), 200);
        }
	    //CZ SPRINT 73
	    
	}
	
	public function getInformePec(Request $request){
	    //INICIO DC
	    $respuesta = DB::select("select 
        gip.INFO_RESP,
        gip.INFO_COM,
        gip.INFO_FEC_PRI,
        gip.INFO_FEC_TER,
        gip.INFO_INTRO,
        gip.INFO_ACT_PLAN,
        gip.INFO_ACT_REAL,
        dic.com_pri_id
        from ai_gc_informe_pec gip
        left join ai_dg_ident_comunidad dic
        on gip.PRO_AN_ID = dic.PRO_AN_ID
        where gip.PRO_AN_ID = ".$request->pro_an_id);
	    echo json_encode($respuesta); exit;
	    //FIN DC
	}
	
	public function doc(Request $request){
	    $str = str_replace("doc1AnexoPEC","",url()->current().'doc/'.$request->archivo);
	    return $str;
	}
	
	public function eliminaAnexoPec(Request $request){
	    $respuesta = DB::delete("delete from ai_documentos_gc where doc_gc_id = ".$request->id);
	    return 1;
	}
    
    public function crearBitacora(){
        $region = Region::all();
        $comuna = Comuna::all();
        $hito  = Hito::where("cb_hito_act", "=", 1)->get();
        $actor = TipoActor::where("cb_tip_act_act", "=", 1)->get();
        $lugar = LugarBitacora::where("cb_lug_bit_act", "=", 1)->get();
        $pro_an_id = 5;
        return view('gestor_comunitario.bitacora.registrar_bitacora', ['hito'=>$hito,'actor'=>$actor, 'lugar' => $lugar, 'region' => $region, 'comuna' => $comuna, 'pro_an_id' => $pro_an_id]);

    }

    public function crearActividad(){

        
        $region = Region::all();
        $comuna = Comuna::all();
        $hito  = Hito::where("cb_hito_act", "=", 1)->get();
        $actor = TipoActor::where("cb_tip_act_act", "=", 1)->get();
        $lugar = LugarBitacora::where("cb_lug_bit_act", "=", 1)->get();
        $bit_id = 8;
    
        $act_dir = DireccionBit::where('bit_id', '=', $bit_id)->first();
        
        $dir_est = count($act_dir);
        //dd($act_dir);
        return view('gestor_comunitario.bitacora.registrar_bitacora', 
        [
            'hito'=>$hito,
            'actor'=>$actor, 
            'lugar' => $lugar, 
            'region' => $region, 
            'comuna' => $comuna, 
            'bit_id' => $bit_id,
            'dir_est' => $dir_est, 
            'dir_reg' => $act_dir->ciudad_id,
            'dir_com' => $act_dir->com_id,
            'dir_cal' => $act_dir->calle_id,
            'dir_num' => $act_dir->act_dir_num
        ]);

    }

    public function registrarBitacora(Request $request){
		try{
            $pro_an_id      = $request->pro_an_id;
            $fecha_ingreso  = $request->fecha_ingreso;
            $nombre         = $request->nombre_bitacora;
            $tipo           = $request->tipo;
            $est_pro_id     = $request->est_pro_id;

            DB::beginTransaction();

            $bit = new BitacoraComunal();
            $bit->bit_fec_cre   = Carbon::createFromFormat('d/m/Y', $fecha_ingreso);
            $bit->bit_tit       = $nombre;
            $bit->bit_tip       = $tipo;
            $bit->est_pro_id    = $est_pro_id;
            
			
            $resultado = $bit->save();
            if(!$resultado){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la Bitácora. Por favor intente nuevamente o contacte con el Administrador.";
            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $usuBit = new UsuarioBitacora();
            $usuBit->usu_id        = session()->all()["id_usuario"];            
            $usuBit->pro_an_id     = $pro_an_id;
            $usuBit->bit_id        = $bit->bit_id;

            $resultado = $usuBit->save();
            if(!$resultado){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la Bitácora. Por favor intente nuevamente o contacte con el Administrador.";
            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

  			DB::commit();

            $mensaje = "Bitácora registrada con éxito";

  			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		}catch(\Exception $e){
			DB::rollback();
            
            return response()->json($e->getMessage(), 400);
		}
    }

    public function registrarActividad(Request $request){
		try{

            DB::beginTransaction();   

            if($request->reg_opc == 0){
                $fec_act= Carbon::createFromFormat('d/m/Y', $request->fec);
            
                $act = new Actividad;            
                
                $act->hito_id       = $request->act_hito;
                // INICIO CZ SPRINT 67
                $act->hito_otro       = $request->act_hito_otro;
                // FIN CZ SPRINT 67
                $act->act_plan      = $request->act_plan;
                $act->act_real      = $request->act_real;
                $act->act_desc      = $request->act_desc;
                $act->act_mat_ins   = $request->act_mate;
                $act->act_obs       = $request->act_obsv;
                $act->act_fec_act   = $fec_act;                
                $act->lug_bit_id    = $request->lug;
                $act->tip_act_id    = $request->act_act;
                $act->act_num_part  = $request->act_par;
                $act->act_num_nna   = $request->act_nna;
                $act->act_num_adult = $request->act_adl;
                $act->est_pro_id    = $request->est_pro_id;
                // INCIO CZ SPRINT 67
                $act->lug_bit_otro    = $request->lug_bit_otro;
                // FIN CZ SPRINT 67
                //$act->act_otro      = $request->hito_otro;
                $resultado = $act->save();     
                
                if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la Actividad. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

                $act_dir = new DireccionBit;
                    
                $act_dir->act_id        = $act->act_id;
                $act_dir->com_id        = $request->com;
                $act_dir->ciudad_id     = $request->reg;
                //$act_dir->calle_id      = $request->cal;
                $act_dir->dir_bit_num   = $request->num;
                $act_dir->dir_bit_dep   = $request->dep;
                $act_dir->dir_bit_block = $request->blo;
                $act_dir->dir_bit_casa  = $request->cas;
                $act_dir->dir_bit_km    = $request->sit;
                $act_dir->dir_bit_ref   = $request->ref;
                $resultado = $act_dir->save();

                if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la Actividad. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
               
                $usuAct = new UsuarioActividad();
                $usuAct->act_id     = $act->act_id;
                $usuAct->bit_id     = $request->bit_id;
                $usuAct->usu_id     = session()->all()["id_usuario"];
                $resultado = $usuAct->save();

                if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la Actividad. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
            }else{
                $fec_act= Carbon::createFromFormat('d/m/Y', $request->fec);
                
                $act = Actividad::find($request->act_id);            
                
                $act->hito_id       = $request->act_hito;
                // INICIO CZ SPRINT 67
                $act->hito_otro       = $request->act_hito_otro;
                // FIN CZ SPRINT 67
                $act->act_plan      = $request->act_plan;
                $act->act_real      = $request->act_real;
                $act->act_desc      = $request->act_desc;
                $act->act_mat_ins   = $request->act_mate;
                $act->act_obs       = $request->act_obsv;
                $act->act_fec_act   = $fec_act;                
                $act->lug_bit_id    = $request->lug;
                $act->tip_act_id    = $request->act_act;
                $act->act_num_part  = $request->act_par;
                $act->act_num_nna   = $request->act_nna;
                $act->act_num_adult = $request->act_adl;
                // INICIO CZ SPRINT 67
                $act->lug_bit_otro    = $request->lug_bit_otro;
                // FIN CZ SPRINT 67
                //$act->act_otro      = $request->hito_otro;
               
                $resultado = $act->save();
                if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la Actividad. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

                $dir = DireccionBit::select('dir_bit_id')->where('act_id', '=', $request->act_id)->first();

                $act_dir = DireccionBit::find($dir->dir_bit_id);
                //dd($act_dir);
                $act_dir->act_id        = $request->act_id;
                $act_dir->com_id        = $request->com;
                $act_dir->ciudad_id     = $request->reg;
                //$act_dir->calle_id      = $request->cal;
                $act_dir->dir_bit_num   = $request->num;
                $act_dir->dir_bit_dep   = $request->dep;
                $act_dir->dir_bit_block = $request->blo;
                $act_dir->dir_bit_casa  = $request->cas;
                $act_dir->dir_bit_km    = $request->sit;
                $act_dir->dir_bit_ref   = $request->ref;
                
                $resultado = $act_dir->save();
                if(!$resultado){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la Actividad. Por favor intente nuevamente o contacte con el Administrador.";
                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

                
            } 
            

			DB::commit();

			$mensaje = "Actividad creada con éxito!";

			return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

		}catch(\Exception $e){
			DB::rollback();
			Log::error('Error: '.$e);

			$mensaje = "Hubo un error desconocido al momento de guardar la Actividad. Por favor intente nuevamente.";
			if (!is_null($e->getMessage()) && $e->getMessage() != "") $mensaje = $e->getMessage();

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
		}
    }

    public function listarproceso(){

        $usu_id 	= session()->all()["id_usuario"];
        $respuesta 	= array();
        $respuesta = UsuarioProceso::where('usu_id', '=', $usu_id)->with(['procesoanual','usuarios'])->get();
       
		$data	= new \stdClass();
		$data->data = $respuesta;
        //dd(json_encode($data));
		echo json_encode($data); exit;
    }

    public function listarBitacoraData(Request $request){
        $pro_an_id = $request->pro_an_id;
        $bit_tip = $request->tipo;
        //$respuesta = BitacoraComunal::listarBitacora($pro_an_id);
        
        $respuesta = UsuarioBitacora::where('pro_an_id', '=', $pro_an_id)
                                    ->with('bitacorausu','usuarios')
                                    ->whereHas('bitacorausu', function($query) use($bit_tip){
                                        $query->where('bit_tip', '=', $bit_tip);
                                    })->get();

        foreach($respuesta as $bit){
            $bit->actividades = UsuarioActividad::where('bit_id', '=', $bit->bit_id)->count();
        }
        if (count($respuesta) == 0){
          $respuesta = array();
        }
        
		    $data	= new \stdClass();
            $data->data = $respuesta;
            //dd(json_encode($data));
		    echo json_encode($data); exit;
    }

    public function listarActividad(Request $request){
        
        $bit_id = $request->bit_id;
        $respuesta = UsuarioActividad::where('bit_id', '=', $bit_id)->get();
        foreach($respuesta as $list){
            $list->actividad = Actividad::where('act_id', '=', $list->act_id)->with('hito','lugarbitacora')->get();

        }
        $data	= new \stdClass();
		$data->data = $respuesta;
        //dd(json_encode($data));
		echo json_encode($data); exit;
    }
    

    public function actividadEditar(Request $request){

        try{
            
            $act_id = $request->act_id;
            $act_data= Actividad::find($act_id);
            $dir = DireccionBit::where('act_id', '=', $act_id)->first();            
            
            $reg = Region::all();
            $com = Comuna::all();
            $lug = LugarBitacora::all();
            $act = TipoActor::all();
            // INICIO CZ SPRINT 67
            if($request->tip_ges == 0){
                // INICIO CZ SPRINT 67
                $hit = Hito::where("cb_hito_tip",$request->tip_ges)->whereIn('cb_hito_id', [1, 2, 3,16,17,18,19,20,21,22,23,24,25,26])->get();
                // FIN CZ SPRINT 67
            }else{
            $hit = Hito::where("cb_hito_tip",$request->tip_ges)->get();
            }
            // FIN CZ SPRINT 67
            
            

            $acts_dir = json_encode($dir);
            $acts_reg = json_encode($reg);
            $acts_com = json_encode($com);
            $acts_lug = json_encode($lug);
            $acts_act = json_encode($act);
            $acts_hit = json_encode($hit);           
            $data = json_encode($act_data);
           
            return response()->json(
                array(
                    'act_dir' => $acts_dir,
                    'act_reg' => $acts_reg,
                    'act_com' => $acts_com,
                    'act_lug' => $acts_lug,
                    'act_act' => $acts_act,
                    'act_hit' => $acts_hit,
                    'act_data' => $data    
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }

    }
    
    public function editarBitacora(Request $request){
    	try{
            $pro_an_id = $request->pro_an_id;
            if (!isset($pro_an_id) || $pro_an_id == ""){
               $mensaje = "No se encuentra ID del proceso. Por favor verifique e intente nuevamente.";


                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }


            $bit_id = $request->bit_id;
            if (!isset($bit_id) || $bit_id == ""){
               $mensaje = "No se encuentra ID de la Bitácora. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $respuesta = BitacoraComunal::find($bit_id);

            return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
    	}catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }

    public function listarProcesoAnual(){
        try{
            $acciones = $this->perfil->acciones();
            $icono = Funcion::iconos(190);
                    
            return view('gestor_comunitario.gestion_comunitaria.listar_proceso_anual', 
                [
                    'acciones' => $acciones,
                    'icono' => $icono                    
                ]
            );

        }catch(\Exception $e){
           $mensaje = "Hubo inconvenientes al momento de desplegar el listado de procesos. Por favor intente nuevamente o contacte con el Administrador.";

            return view('layouts.errores')->with(['mensaje' => $mensaje]);
        }
    }

    public function listarProcesoAnualData(){
            $respuesta = ProcesoAnual::listarProcesosAnuales();

            $data   = new \stdClass();
            $data->data = $respuesta;

            echo json_encode($data); exit;
    }

    // INICIO CZ SPRINT 56 
    public function obtenerComentarioDesestimacion(Request $request){

        $respuesta = ProcesoEstadoProceso::where("pro_an_id", "=",$request->id)->where("est_pro_id","=",4)->get();
        return response()->json(array('estado' => $respuesta), 200); 
    }
    // FIN CZ SPRINT 56
    public function verificarProcesoAnual(Request $request){
       
        try{
           
            $com_id = $request->com_id; 
                     
            $estado = ProcesoAnual::where('com_id', '=', $com_id)
                                            ->whereHas('estadoproceso', function($query){
                                                $query->where('est_pro_ini', '=', 1);
                                            })->count();
            
            return response()->json(array('estado' => $estado), 200);

        }catch(\Exception $e){
            DB::rollback();

            return response()->json($e->getMessage(), 400);
        }

    }
    public function crearProcesoAnual(Request $request){
        try{
            $mensaje = "Hubo un error al momento de registrar el proceso. Por favor intente nuevamente o contacte con el Administrador.";

            DB::beginTransaction();
            $proceso = new ProcesoAnual();
            $proceso->com_id        = session()->all()["com_id"];
            $proceso->pro_an_nom    = $request->pro_an_nom;
            $proceso->pro_an_fec    = Carbon::createFromFormat('Y',$request->pro_an_fec);
            $proceso->est_pro_id    = 1;
            // INICIO CZ SPRINT 68
            $proceso->FLAG_VERSION_LINEA_BASE    = 2;
            // FIN CZ SPRINT 68
            $respuesta = $proceso->save();
            if (!$respuesta){
                DB::rollback();

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $usuario_proceso = new UsuarioProceso();
            $usuario_proceso->usu_id        = session()->all()["id_usuario"];
            $usuario_proceso->pro_an_id     = $proceso->pro_an_id;
            $usuario_proceso->usu_pro_per   = 1;
            $respuesta = $usuario_proceso->save();

            if (!$respuesta){
                DB::rollback();

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

            }

            $estado_proceso = new ProcesoEstadoProceso();     
            $estado_proceso->usu_id     = Session::get('id_usuario'); 
            $estado_proceso->pro_an_id  = $proceso->pro_an_id;
            $estado_proceso->est_pro_id = 1;
            $estado_proceso->pro_est_des = "Se crea un nuevo proceso";
            $respuesta = $estado_proceso->save();

            if (!$respuesta){
                DB::rollback();

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

            }

            $diagnotico = new DiagnosticoParticipativo();     
            $diagnotico->usu_id     = Session::get('id_usuario'); 
            $diagnotico->pro_an_id  = $proceso->pro_an_id;
            $diagnotico->dg_est_id = 1;
            $respuesta = $diagnotico->save();

            if (!$respuesta){
                DB::rollback();

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);

            }

            DB::commit();

            $mensaje = "Proceso Anual registrado con éxito";

            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();

            return response()->json($e->getMessage(), 400);
        }
    }

    public function gestionProcesoAnual(Request $request){
        try{
            if (!isset($request->tipo_gestion) || $request->tipo_gestion == ""){
                throw new \Exception("No se encuentra el tipo de gestión a desplegar.");
            }

            $data = array();
            $tipo_gestion   = $request->tipo_gestion;
            $comuna         = session()->all()['com_id'];
            
            switch($tipo_gestion){
                case 1: //PLAN COMUNAL
                    // INICIO CZ SPRINT 61
                    if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                        throw new \Exception("No se encuentra ID del proceso. Por favor verifique e intente nuevamente.");
                    }
                    // FIN CZ SPRINT 61
                    $menu = "Plan Comunal";
                    //INICIO CZ SPRINT 61
                     //$proceso = ProcesoAnual::where("com_id", $comuna)->leftJoin("ai_estado_proceso ep", "ai_proceso_anual.est_pro_id", "=", "ep.est_pro_id")->where("est_pro_fin", 0)->first();
                    // $proceso = ProcesoAnual::orderBy('pro_an_fec', 'DESC')->leftJoin("ai_estado_proceso ep", "ai_proceso_anual.est_pro_id", "=", "ep.est_pro_id")->where("est_pro_fin", 0)->where("com_id", $comuna)->get();
                    $proceso = ProcesoAnual::find($request->pro_an_id);
                    // print_r($proceso);
                    // die();
                    //FIN CZ SPRINT 61
                    if (count($proceso) == 0){
                        DB::beginTransaction();
                        
                        $registrar_proceso = new ProcesoAnual();
                        $registrar_proceso->com_id        = session()->all()["com_id"];
                        $registrar_proceso->pro_an_nom    = "Proceso Creado Automaticamente / ".session()->all()["comuna"];
                        $registrar_proceso->pro_an_fec    = Carbon::createFromFormat('Y', date("Y"));
                        $registrar_proceso->est_pro_id    = 1;

                        $respuesta = $registrar_proceso->save();
                        if (!$respuesta){
                            DB::rollback();

                            $mensaje = "Hubo un error al momento de crear el Proceso. Por favor intente nuevamente o contacte a su Administrador.";
                            return view('layouts.errores')->with(['mensaje' => $mensaje]);
                        }

                        $usuario_proceso = new UsuarioProceso();
                        $usuario_proceso->usu_id        = session()->all()["id_usuario"];
                        $usuario_proceso->pro_an_id     = $registrar_proceso->pro_an_id;
                        $usuario_proceso->usu_pro_per   = 1;
                        $respuesta = $usuario_proceso->save();

                        if (!$respuesta){
                            DB::rollback();

                            $mensaje = "Hubo un error al momento de vincular al usuario en el Proceso Actual. Por favor intente nuevamente o contacte a su Administrador.";
                            return view('layouts.errores')->with(['mensaje' => $mensaje]);
                        }

                        $estado_proceso = new ProcesoEstadoProceso();     
                        $estado_proceso->usu_id     = Session::get('id_usuario'); 
                        $estado_proceso->pro_an_id  = $registrar_proceso->pro_an_id;
                        $estado_proceso->est_pro_id = 1;
                        $estado_proceso->pro_est_des = "Se crea un nuevo proceso.";
                        $respuesta = $estado_proceso->save();

                        if (!$respuesta){
                            DB::rollback();

                            $mensaje = "Hubo un error al momento de actualizar el estado del Proceso Actual. Por favor intente nuevamente o contacte a su Administrador.";
                            return view('layouts.errores')->with(['mensaje' => $mensaje]);
                        }

                        $diagnotico = new DiagnosticoParticipativo();     
                        $diagnotico->usu_id     = Session::get('id_usuario'); 
                        $diagnotico->pro_an_id  = $registrar_proceso->pro_an_id;
                        $diagnotico->dg_est_id = 1;
                        $respuesta = $diagnotico->save();

                        if (!$respuesta){
                            DB::rollback();

                            $mensaje = "Hubo un error al momento de crear el Diagnostico Participativo. Por favor intente nuevamente o contacte a su Administrador.";
                            return view('layouts.errores')->with(['mensaje' => $mensaje]);
                        }

                        DB::commit();

                        $pro_an_id      = $registrar_proceso->pro_an_id;
                        $nombre_proceso = $registrar_proceso->pro_an_nom;
                        $est_pro_id     = $registrar_proceso->est_pro_id;
                        $año_proceso    = Carbon::createFromFormat('Y-m-d H:i:s', $registrar_proceso->created_at)->format('Y');
                        $fecha          = Carbon::createFromFormat('Y-m-d H:i:s', $registrar_proceso->created_at)->format('d-m-Y');

                    }else if (count($proceso) > 0){
                        $pro_an_id      = $proceso->pro_an_id;
                        $nombre_proceso = $proceso->pro_an_nom;
                        $est_pro_id     = $proceso->est_pro_id;
                        $año_proceso    = Carbon::createFromFormat('Y-m-d H:i:s',$proceso->created_at)->format('Y');
                        $fecha          = Carbon::createFromFormat('Y-m-d H:i:s',$proceso->created_at)->format('d-m-Y');
                    
                    }
                    // INICIO CZ MANTIS 9878
                    $flag_linea = $proceso->flag_version_linea_base;
                    // FIN CZ MANTIS 9878
                    
                    $data["diag_estado"] = 1;
                break;

                case 0: //GESTION COMUNITARIA
                default:
                    if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                        throw new \Exception("No se encuentra ID del proceso. Por favor verifique e intente nuevamente.");
                    }

                    $menu = "Gestión Comunitaria";
                    $pro_an_id = $request->pro_an_id; 
                    $proceso = ProcesoAnual::find($pro_an_id);
                    $estado_proceso = EstadoProceso::find($proceso->est_pro_id);
                    $data["estado_proceso"] = $estado_proceso->est_pro_nom;
                    if (count($proceso) == 0){
                        $mensaje = "No se encontró un Proceso Anual actualmente disponible. Por favor intente nuevamente o contacte con el Administrador.";

                        return view('layouts.errores')->with(['mensaje' => $mensaje]);
                    }

                    $nombre_proceso = $proceso->pro_an_nom;
                    $est_pro_id     = $proceso->est_pro_id;
                    // INICIO CZ SPRINT 70
                    $flag_linea = $proceso->flag_version_linea_base;
                    // FIN CZ SPRINT 70
                    $año_proceso    = Carbon::createFromFormat('Y-m-d H:i:s',$proceso->pro_an_fec)->format('Y');
                    $fecha          = Carbon::createFromFormat('Y-m-d H:i:s',$proceso->pro_an_fec)->format('d-m-Y');

                    $diagnostico = DiagnosticoParticipativo::where("pro_an_id", $pro_an_id)->first();
                    if (count($diagnostico) > 0){
                        $data["diag_par_id"] = $diagnostico->diag_par_id;
                        $data["diag_estado"] = $diagnostico->dg_est_id;

                    }
                    
            }
            $acciones = $this->perfil->acciones();
            // INICIO CZ SPRINT 70
            $data["flag_linea"] = $flag_linea;
            // FIN CZ SPRINT 70
            $data["pro_an_id"] = $pro_an_id;
            $data["menu"] = $menu;
            $data["nombre_proceso"] = $nombre_proceso;
            $data["año_proceso"] = $año_proceso;
            $data["est_pro_id"] = $est_pro_id;
            $data["fecha"] = $fecha;
            $data["acciones"] = $acciones;
            $data["tipo_gestion"] = $tipo_gestion;
            return view('gestor_comunitario.gestion_comunitaria.gestion_proceso_anual', $data);

        }catch(\Exception $e){
           $mensaje = "Hubo inconvenientes al momento de desplegar la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";

            return view('layouts.errores')->with(['mensaje' => $mensaje]);
        }
    }

    // INICIO CZ SPRINT 61
        public function listarProcesoAnualPlanComunal(){
            try{
                $acciones = $this->perfil->acciones();
                $icono = Funcion::iconos(190);
                        
                return view('gestor_comunitario.gestion_comunitaria.listar_proceso_anual_plan_comunal', 
                    [
                        'acciones' => $acciones,
                        'icono' => $icono                    
                    ]
                );
    
            }catch(\Exception $e){
               $mensaje = "Hubo inconvenientes al momento de desplegar el listado de procesos. Por favor intente nuevamente o contacte con el Administrador.";
    
                return view('layouts.errores')->with(['mensaje' => $mensaje]);
            }
        }
    // FIN CZ SPRINT 61

    public function cambioEstadoProceso(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->opcion) || $request->opcion == "" || !isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "Falta datos para completar el proceso. Por favor intente nuevamente.";
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            $cambio_estado = true;

            switch ($request->opcion){
                case 4:
                    $pro_an_id  = $request->pro_an_id;
                    $est_pro    = $request->opcion;
                    $comentario = $request->comentario;
                break;
            }

            if ($cambio_estado == true){

				$proceso_estado = ProcesoEstadoProceso::where('pro_an_id',$pro_an_id)
                    ->where('est_pro_id',$est_pro)->get();
                    
				if ($proceso_estado->count()==0){
					$proceso_estado = new ProcesoEstadoProceso();
				}

                $proceso_estado->usu_id     = Session::get('id_usuario');
				$proceso_estado->pro_an_id = $pro_an_id;
				$proceso_estado->est_pro_id = $est_pro;
				$proceso_estado->pro_est_des = $comentario;
				$resultado = $proceso_estado->save();
				
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error al momento de realizar el cambio de estado del proceso. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$proceso = ProcesoAnual::find($pro_an_id);
				$proceso->est_pro_id = $est_pro;
				$resultado = $proceso->save();
				
				if (!$resultado) {
					DB::rollback();
					$mensaje = "Error al momento de actualizar estado del proceso. Por favor intente nuevamente.";
					return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
				}
				
				$mensaje = "Cambio de estado realizado con éxito.";
            }
			
		    DB::commit();
			
		    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
		
            
        }catch(\Exception $e){
			DB::rollback();
			Log::info('error ocurrido:'.$e);
			
			$mensaje = "Hubo un error en el proceso de actualización de estado. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		
		}
    }

    //Inicio dc
    public function cargarDocumentosPEC(Request $request){
        try {
            $pro_an_id=$request->pro_an_id;
            $destinationPath = 'doc';
            if(!$request->file('doc_anex')){
                $mensaje = "Hubo un error al momento dergar el documento. Por favor intente nuevamente.";
                return -2;
            }
            $files = $request->file('doc_anex');  
            $extension = $files->getClientOriginalExtension();
            if($extension == 'pdf' or $extension == 'jpg' or $extension == 'doc' or $extension == 'docx'){
                //CZ SPRINT 73
                $doc  = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_id",8)->get();
                $getcorrelativo = count($doc)+1;
                $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
                $comuna = Comuna::where('com_id',$proceso->com_id)->first();
                $destinationPath = 'doc/'.$comuna->com_nom;
                $date = date('Y', strtotime($proceso->pro_an_fec));
                $filename = $comuna->abrev. '_GC_'.$date.'_'.$pro_an_id.'_Info_AnePlaEst_'.$getcorrelativo.".".$extension;
                
                $upload_success = $files->move($destinationPath, $filename);
                //CZ SPRINT 73
                DB::beginTransaction();
                $doc = new DocumentoGcomunitaria();
                $doc->doc_nom   = $filename;
                $doc->tip_id    = 8;
                $doc->usu_id    = session()->all()["id_usuario"];
                $doc->pro_an_id = $pro_an_id;
                $respuesta = $doc->save();
                DB::commit();
               return 1;
            }else{
                return -1;
            }

        } catch(\Exception $e) {
            
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento dergar el documento. Por favor intente nuevamente.";
            // INICIO CZ SPRINT 66
            return -2;
        } 
    }
    
    public function getPlazo(Request $request){
        // INICIO CZ SPRINT 58 
        if($request->pro_an_id != null && $request->tipo != null){
        $plazo = DB::selectOne("select FN_PLAZO_INTERVENCION(".$request->tipo.", ".$request->pro_an_id.") as plazo from dual" );
        echo json_encode($plazo); exit;
    }
        // FIN CZ SPRINT 58
    }
    
    public function getEstado(Request $request){
        $estado = DB::select("select est_pro_id from ai_proceso_anual where pro_an_id = ".$request->pro_an_id);
        echo json_encode($estado); exit;
    }
    
    public function getEstadoTera(Request $request){
        $estado = DB::select("select est_tera_id from ai_terapia where tera_id = ".$request->idTera);
        echo json_encode($estado); exit;
    }
    
    public function getEstadoNNA(Request $request){
        if($request->idCaso !=null){
        $estado = DB::select("select est_cas_id from ai_caso where cas_id = ".$request->idCaso);
        echo json_encode($estado); exit;
    }
    }
    //Fin dc

    public function cargarDocumentos(Request $request){
        
        // INICIO CZ SPRINT 60
        //VALIDACION DE TAMAÑO DE ARCHIVO 
        $validacion_size = "";
        
        switch($request->tipo){
            case 1:                    
            $validacion_size = Validator::make($request->all(), ['doc_comp' => 'file|mimes:pdf,jpeg,png|max:4096']);
            break;
            case 2:
                $validacion_size = Validator::make($request->all(), ['doc_cons' => 'file|mimes:pdf,jpeg,png|max:4096']);
            break;
            case 3:
                $validacion_size = Validator::make($request->all(), ['doc_acc' => 'file|mimes:pdf,jpeg,png|max:4096']);
            break;
            case 4:
                $validacion_size = Validator::make($request->all(), ['doc_asam' => 'file|mimes:pdf,jpeg,png|max:4096']);
            break;
        }

        if ($validacion_size->fails()){
            $mensaje = "Error al subir documento, tamaño máximo permitido 4 MB. Por favor verificar e intentar nuevamente.";

            return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
        }

        // FIN CZ SPRINT 60

        $request->validate($this->reglas_doc,[]);

  		try {
            
			DB::beginTransaction();
            $pro_an_id=$request->pro_an_id;
            //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            $year = date('Y', strtotime($proceso->pro_an_fec));
            $name = $comuna->abrev."_GC_".$year."_".$pro_an_id;
            $queryCorrelativo = DB::select("select count(doc_nom)+1 as correlativo from ai_documentos_gc where pro_an_id = ". $pro_an_id . " and  tip_id = " .$request->tipo  );
            $getcorrelativo = $queryCorrelativo['0']->correlativo;
            //CZ SPRINT 73
            switch($request->tipo){
                case 1:                    
                    if(!$request->file('doc_comp')){
                        $mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                    }
                    $files = $request->file('doc_comp');    
                    $extension = $files->getClientOriginalExtension();
                    $filename = $name."_Docu_CarComCom_".$getcorrelativo.".".$extension;
                break;
                case 2:
                    if(!$request->file('doc_cons')){
                        $mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                    }
                    $files = $request->file('doc_cons');
                    $extension = $files->getClientOriginalExtension();
                    $filename = $name."_Docu_ActConGru_".$getcorrelativo.".".$extension;
                break;
                case 3:
                    if(!$request->file('doc_acc')){
                        $mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                    }
                    $files = $request->file('doc_acc');
                    $extension = $files->getClientOriginalExtension();
                    $filename = $name."_Docu_ActReuGru_".$getcorrelativo.".".$extension;
                break;
                case 4:
                    if(!$request->file('doc_asam')){
                        $mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                    }
                    $files = $request->file('doc_asam');
                    $extension = $files->getClientOriginalExtension();
                    $filename = $name."_Docu_ActReuAsa_".$getcorrelativo.".".$extension;
                break;
            }
        	
            $upload_success = $files->move($destinationPath, $filename);
            
            $doc = DocumentoGcomunitaria::select("doc_gc_id")->where("pro_an_id",$pro_an_id)->where("tip_id",$request->tipo)->get();
            //INICIO CH
            if(count($doc) == 0){
                $doc = new DocumentoGcomunitaria();
            }else{
                $tipo = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_id",$request->tipo)->first(); // ch
                if ($tipo->tip_id == 3 || $tipo->tip_id == 4) {
                    $doc = new DocumentoGcomunitaria();
                }else{
                $doc = DocumentoGcomunitaria::find($doc[0]->doc_gc_id);
                      // INICIO CZ SPRINT 60
                        $doc->updated_at = Carbon::now();
                    //FIN CZ SPRINT 60
                }//FIN CH
            }

            $doc->doc_nom   = $filename;
            $doc->tip_id    = $request->tipo;
            $doc->usu_id    = session()->all()["id_usuario"];
            $doc->pro_an_id = $request->pro_an_id;
            $respuesta = $doc->save();

            

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'),200);
		
		} catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }        
        
    }
//INICIO CH
    public function documentosData(Request $request){
        try{
            $pro_an_id = $request->pro_an_id;
            //inicio ch
            // INICO CZ SPRINT 60
            $doc = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_gest", $request->tipo_gestion)->orderBy('updated_at', 'desc')->get();
            // FIN CZ SPRINT 60
            $comp = $cons = "";
            $acc = $asam = "";
            //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            //CZ SPRINT 73
            foreach($doc as $v1){
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $v1->updated_at)->format('d/m/Y'); 
                //CZ SPRINT 73
                $ruta = "../../".$destinationPath."/".$v1->doc_nom;
                $ruta_file = $destinationPath."/".$v1->doc_nom;
                if (!is_file($ruta_file)) {
                    $ruta = "../../doc/".$v1->doc_nom;
                }

                if(session()->all()['perfil'] == config('constantes.perfil_coordinador_regional') || session()->all()['perfil'] == config('constantes.perfil_coordinador')){
                                    //CZ SPRINT 73
                    switch($v1->tip_id){            //inicio ch
                        case 1:
                            //$comp   = $v1->doc_nom;
                            $comp .= '<tr>';
                            // INICIO CZ SPRINT 67
                            $comp .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td>';
                            // FIN CZ SPRINT 67
                            $comp .= '</tr>';
                        break;
                        case 2:
                            //$cons   = $v1->doc_nom;
                            $cons .= '<tr>';
                            // INICIO CZ SPRINT 67
                            $cons .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td>';
                            // FIN CZ SPRINT 67
                            $cons .= '</tr>';
                        break;
                        case 3:
                            //$acc    .= $v1->doc_nom."&nbsp".$date."-"; 
                            $acc .= '<tr>';
                            // INICIO CZ SPRINT 67
                            $acc .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td>';
                            // FIN CZ SPRINT 67
                            $acc .= '</tr>';
                        break;
                        case 4:
                            //$asam   .= $v1->doc_nom."&nbsp".$date."-";
                            $asam .= '<tr>';
                            // INICIO CZ SPRINT 67
                            $asam .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td>';
                            // FIN CZ SPRINT 67
                            $asam .= '</tr>';
                        break;
                    }//fin ch
                }else{
                //CZ SPRINT 73
                switch($v1->tip_id){            //inicio ch
                    case 1:
                        //$comp   = $v1->doc_nom;
                        $comp .= '<tr>';
                        // INICIO CZ SPRINT 67
                        $comp .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDoc('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#eliminarDocumento">Eliminar</button></td>';
                        // FIN CZ SPRINT 67
                        $comp .= '</tr>';
                    break;
                    case 2:
                        //$cons   = $v1->doc_nom;
                        $cons .= '<tr>';
                        // INICIO CZ SPRINT 67
                        $cons .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDoc('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#eliminarDocumento">Eliminar</button></td>';
                        // FIN CZ SPRINT 67
                        $cons .= '</tr>';
                    break;
                    case 3:
                        //$acc    .= $v1->doc_nom."&nbsp".$date."-"; 
                        $acc .= '<tr>';
                        // INICIO CZ SPRINT 67
                        $acc .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDoc('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#eliminarDocumento">Eliminar</button></td>';
                        // FIN CZ SPRINT 67
                        $acc .= '</tr>';
                    break;
                    case 4:
                        //$asam   .= $v1->doc_nom."&nbsp".$date."-";
                        $asam .= '<tr>';
                        // INICIO CZ SPRINT 67
                        $asam .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'.$ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDoc('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#eliminarDocumento">Eliminar</button></td>';
                        // FIN CZ SPRINT 67
                        $asam .= '</tr>';
                    break;
                }//fin ch
            }
            }

        return response()->json(array('estado' => '1', 'asam' =>$asam, 'acc' =>$acc ,'cons' =>$cons, 'comp' =>$comp), 200);

        //FIN CH

        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    //inicio CH
    public function cargarhistorialDoc(Request $request){
       
        $request->validate($this->reglas_doc,[]);
		try {

            $documento = $request->file('doc_actas')->getClientOriginalName();
            $doc_particion = explode('.', $documento);
            $ext = $doc_particion[1];
            DB::beginTransaction();
            $pro_an_id=$request->pro_an_id;
            //CZ SPRINT 73
                $tipo_id = $request->tipo;
            $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            $year = date('Y', strtotime($proceso->pro_an_fec));
            //CZ SPRINT 73
                //INICIO CZ
                $queryCorrelativo = DB::select("select count(doc_nom)+1 as correlativo from ai_documentos_gc where tip_gest = ". $request->tipo_gestion ." and tip_id = ".$request->tipo." and pro_an_id = ".$request->pro_an_id);
                $getcorrelativo = $queryCorrelativo['0']->correlativo;
                //FIN CZ
            if($ext == 'png' || $ext == 'jpg' || $ext == 'pdf'){
                switch($request->tipo){
                    case 5:                    
                        if(!$request->file('doc_actas')){
                            $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                            return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
        
                        }
                        $files = $request->file('doc_actas');    
                        $extension = $files->getClientOriginalExtension();
                            //INICIO CZ
                            if($request->tipo_gestion == 1){
                                $filename = $comuna->abrev. "_PC_".$year."_".$pro_an_id."_Hist_ActLisAsi_".$getcorrelativo.".".$extension;
                            }else{
                                $filename = $comuna->abrev. "_GC_".$year."_".$pro_an_id."_Hist_ActLisAsi_".$getcorrelativo.".".$extension;
                            }
                            //FIN CZ
    
                    break;
                    case 6:
                        if(!$request->file('doc_actas')){
                            $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                            return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
        
                        }
                        $files = $request->file('doc_actas');
                        $extension = $files->getClientOriginalExtension();
                            //INICIO CZ
                            
                            if($request->tipo_gestion == 1){
                                $filename = $comuna->abrev. "_PC_".$year."_".$pro_an_id."_Hist_Materiale_".$getcorrelativo.".".$extension;
                            }else{
                                $filename = $comuna->abrev. "_GC_".$year."_".$pro_an_id."_Hist_Materiale_".$getcorrelativo.".".$extension;
                            }
                            //FIN CZ
                    break;
                    case 7:
                        if(!$request->file('doc_actas')){
                            $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                            return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
        
                        }
                        $files = $request->file('doc_actas');
                        $extension = $files->getClientOriginalExtension();
                            //INICIO CZ
                            if($request->tipo_gestion == 1){
                                $filename = $comuna->abrev. "_PC_".$year."_".$pro_an_id."_Hist_AseConsen_".$getcorrelativo.".".$extension;
                            }else{
                                $filename = $comuna->abrev. "_GC_".$year."_".$pro_an_id."_Hist_AseConsen_".$getcorrelativo.".".$extension;
                            }
                            //FIN CZ
                    break;
    
                }
                
                $upload_success = $files->move($destinationPath, $filename);
                
                $doc = DocumentoGcomunitaria::select("doc_gc_id")->where("pro_an_id",$pro_an_id)->where("tip_id",$request->tipo)->get();
                    $doc = new DocumentoGcomunitaria();
                   //INICIO CZ
       
                   // if(count($doc) == 0){
                    //     $doc = new DocumentoGcomunitaria();
                    // }else{
                    //     $tipo = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_id",$request->tipo)->first(); // ch
                    //     if ($tipo->tip_id == 5 || $tipo->tip_id == 6 || $tipo->tip_id == 7) {
                    //         $doc = new DocumentoGcomunitaria();
                    //     }else{
                    //         $doc = DocumentoGcomunitaria::find($doc[0]->doc_gc_id);
                    //     }
                    // }
    
                    //FIN CZ
                $doc->doc_nom   = $filename;
                $doc->tip_id    = $request->tipo;
                $doc->usu_id    = session()->all()["id_usuario"];
                $doc->pro_an_id = $request->pro_an_id;
                $doc->tip_gest  = $request->tipo_gestion;
                $respuesta = $doc->save();

                    //INICIO CZ

                    if(!$respuesta){
                        DB::rollback();
                        $mensaje = "Hubo un error al momento de registrar la Bitácora. Por favor intente nuevamente o contacte con el Administrador.";

                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }

                DB::commit();
                    
                    $mensaje = "Archivo guardado exitosamente";

                    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);

                    // $request->session()->flash('success', 'Archivo guardado exitosamente.');



                    // if ( $request->tipo_gestion == 0) {

                    //     return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 0, 'pro_an_id' => $pro_an_id,]);
                    // }else{

                    //     return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 1]);
                    // }

                    // FIN CZ
                }else{

                    //INICIO CZ
                    $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                    return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
                    // $request->session()->flash('danger', 'Hubo un error al momento de subir el documento. Por favor respetar el formato del archivo(pdf, png, jpg).');
                    // if ( $request->tipo_gestion == 0) {

                    //     return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 0, 'pro_an_id' => $pro_an_id]);
                    // }else{

                    //     return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 1]);
                    // }

                    //FIN CZ
            }    
		} catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
                //INICIO CZ SPRINT 66
    			$mensaje = "Hubo un error al momento de cargar el historial de documentos. Por favor intente nuevamente.";
                // FIN CZ SPRINT 66
                return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
                // $request->session()->flash('danger', 'Hubo un error al momento de subir el documento. Por favor intente nuevamente.');
                //     if ( $request->tipo_gestion == 0) {
                    
                //         return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 0, 'pro_an_id' => $pro_an_id]);
                //     }else{

                //         return redirect()->route("gestion.proceso.anual",['tipo_gestion' => 1]);
                //     }
                //FIN CZ
        }
    }

    public function cargarDocPercepcion(Request $request){
        $request->validate($this->reglas_doc,[]);
        try {

            if(!$request->file('doc_percepcion')){
                $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);

            }  
            $files = $request->file('doc_percepcion');    
            $extension = $files->getClientOriginalExtension();
            DB::beginTransaction();
            $pro_an_id=$request->pro_an_id;
            //CZ SPRINT 73
            $tipo_id = $request->tipo;
            $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();

            $queryCorrelativo = DB::select("select count(doc_nom)+1 as correlativo from ai_documentos_gc where tip_gest = ". $request->tipo_gestion ." and tip_id = ".$request->tipo." and pro_an_id = ".$request->pro_an_id);
            $getcorrelativo = $queryCorrelativo['0']->correlativo;
            $destinationPath = 'doc/'.$comuna->com_nom;
            $date = date('Y', strtotime($proceso->pro_an_fec));

            if($extension == 'png' || $extension== 'jpg' || $extension == 'pdf'){
                
                    $filename = $comuna->abrev. '_GC_'.$date.'_'.$pro_an_id.'_encu_percepcion_'.$getcorrelativo.".".$extension;

                    $upload_success = $files->move($destinationPath, $filename);
                    
                    $doc = DocumentoGcomunitaria::select("doc_gc_id")->where("pro_an_id",$pro_an_id)->where("tip_id",$request->tipo)->get();
                    $doc = new DocumentoGcomunitaria();
                    $doc->doc_nom   = $filename;
                    $doc->tip_id    = $request->tipo;
                    $doc->usu_id    = session()->all()["id_usuario"];
                    $doc->pro_an_id = $request->pro_an_id;
                    $doc->tip_gest  = $request->tipo_gestion;
                    $respuesta = $doc->save();

                    if(!$respuesta){
                        DB::rollback();
                        $mensaje = "Hubo un error al momento de registrar la Bitácora. Por favor intente nuevamente o contacte con el Administrador.";

                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }

                    DB::commit();
                    
                    $mensaje = "Archivo guardado exitosamente";

                    return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
                }else{
                    $mensaje = "EL formato del archivo no es permitido. Sólo subir archivos con las siguientes extensiones: '.pdf', '.jpg' y '.png'.";

                    return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);

            }    
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
    			$mensaje = "Hubo un error al momento de cargar el documento de percepción. Por favor intente nuevamente.";
                return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function gethistorialData(Request $request){    
        try{
            //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            //CZ SPRINT 73
            $pro_an_id = $request->pro_an_id;
            $doc = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_gest", $request->tipo_gestion)->orderBy('created_at', 'desc')->get();
            $alas = $mater = $asycon = "";
            foreach($doc as $v1){
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $v1->created_at)->format('d/m/Y'); 
               //CZ SPRINT 73
                $ruta = "../../".$destinationPath."/".$v1->doc_nom;
                $ruta_file = $destinationPath."/".$v1->doc_nom;
                if (!is_file($ruta_file)) {
                    $ruta = "../../doc/".$v1->doc_nom;
                }
                //CZ SPRINT 73
                if(session()->all()['perfil'] == config('constantes.perfil_coordinador_regional') || session()->all()['perfil'] == config('constantes.perfil_coordinador')){
                    switch($v1->tip_id){//inicio ch
                        case 5:
                            $alas .= '<tr>';
                            $alas .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td>';
                            $alas .= '</tr>';
                        break;
                        case 6:
                            $mater .= '<tr>';
                            $mater .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td>';
                            $mater .= '</tr>';
                        break;
                        case 7:
                            $asycon .= '<tr>';
                            $asycon .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td>';
                            $asycon .= '</tr>';
                        break;
                    }//fin ch
                }else{
                switch($v1->tip_id){//inicio ch
                    case 5:
                        $alas .= '<tr>';
                        $alas .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td>'. '<td><button type="button" class="btn btn-danger" onclick="eliminarDocumento('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#confirm-delete">Eliminar</button></td>';
                        $alas .= '</tr>';
                    break;
                    case 6:
                        $mater .= '<tr>';
                        $mater .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDocumento('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#confirm-delete">Eliminar</button></td>';
                        $mater .= '</tr>';
                    break;
                    case 7:
                        $asycon .= '<tr>';
                        $asycon .= '<td>'.$v1->doc_nom.'</td>'.'<td>'.$date.'</td>'.'<td><a download href="'. $ruta.'">Descargar aquí</a></td><td><button type="button" class="btn btn-danger" onclick="eliminarDocumento('.$v1->tip_id.','.$v1->doc_gc_id.')" data-toggle="modal" data-target="#confirm-delete">Eliminar</button></td>';
                        $asycon .= '</tr>';
                    break;
                }//fin ch
            }

            }

        return response()->json(array('estado' => '1', 'alas' =>$alas, 'mater' =>$mater ,'asycon' =>$asycon), 200);
          
        
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
			//FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    //fin ch

    public function dataIdentificacionPrioritaria(){
        
        try{
            
            $com_pri = ComPriorizada::select("com_pri_id","com_pri_nom")->get();
            $lug_gc = LugarGcomunitaria::select("lug_gc_id","lug_gc_nom")->get();
            $zon_rur = ZonaRural::select("zon_rur_id","zon_rur_nom")->get();
            

            $com_pri = json_encode($com_pri);
            $lug_gc  = json_encode($lug_gc);          
            $zon_rur = json_encode($zon_rur);
           
            return response()->json(
                array(
                    'com_pri' => $com_pri,
                    'lug_gc'  => $lug_gc,
                    'zon_rur' => $zon_rur    
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }

    public function getDataIdentComuna(Request $request){
        try{

            $pro_an_id = $request->pro_an_id;
            $iden_com = DgIdentidadCom::where("pro_an_id",$pro_an_id)->first();
            $com_pri = ComPriorizada::select("com_pri_id","com_pri_nom")->get();
            $lug_gc = LugarGcomunitaria::select("lug_gc_id","lug_gc_nom")->get();
            $zon_rur = ZonaRural::select("zon_rur_id","zon_rur_nom")->get();
            
            
            $com_pri = json_encode($com_pri);
            $lug_gc  = json_encode($lug_gc);          
            $zon_rur = json_encode($zon_rur);
            
            if(count($iden_com) > 0){
                if($iden_com->iden_fec_lev!=""){
                    $iden_com->iden_fec_lev = Carbon::createFromFormat('Y-m-d H:i:s',$iden_com->iden_fec_lev)->format('d/m/Y');
                
                }

                $iden_com = json_encode($iden_com);
                
                return response()->json(array('estado' => '1', 'iden_com' =>$iden_com, 'com_pri' => $com_pri , 'lug_gc' => $lug_gc, 'zon_rur' => $zon_rur), 200);
            
            }else{
                return response()->json(array('estado' => '0', 'com_pri' => $com_pri , 'lug_gc' => $lug_gc, 'zon_rur' => $zon_rur), 200);
            
            }           
        }catch(\Exception $e) {
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de realizar la información solicitada. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function registrarIdentComuna(Request $request){
        
        try{
            DB::beginTransaction();
            $pro_an_id = $request->pro_an_id;
            $iden_com = DgIdentidadCom::where("pro_an_id",$pro_an_id)->first();

            if(count($iden_com) == 0){
                $iden_com = new DgIdentidadCom();
            }else{
                $iden_com = DgIdentidadCom::find($iden_com->iden_id);
            }
            
            if($request->iden_fec_lev == ""){
                $fec_lev = $request->iden_fec_lev;
            }else{                
                $fec_lev = Carbon::createFromFormat('d/m/Y',$request->iden_fec_lev);
            }
            
            $iden_com->iden_fec_lev     = $fec_lev;
            $iden_com->com_pri_id       = $request->iden_com_pri;
            $iden_com->zon_rur_id       = $request->iden_zon_geo;
            $iden_com->lug_gc_id        = $request->iden_dir_lug;
            $iden_com->iden_dir         = $request->iden_dir_dir;
            $iden_com->iden_cal         = $request->iden_dir_cal;
            $iden_com->iden_num         = $request->iden_dir_num;
            $iden_com->iden_bloc        = $request->iden_dir_bloc;
            $iden_com->iden_dep         = $request->iden_dir_dep;
            $iden_com->iden_nom_rep     = $request->iden_rep_nom;
            $iden_com->iden_rut         = $request->iden_rep_rut;
            $iden_com->iden_telf        = $request->iden_rep_tel;
            $iden_com->iden_cor         = $request->iden_rep_cor;
            $iden_com->iden_num_fam     = $request->iden_num_fam;
            $iden_com->iden_num_nna     = $request->iden_num_nna;
            // INICIO CZ SPRINT 67
            $iden_com->iden_num_total_personas = $request->iden_num_total_personas;
            // FIN CZ SPRINT 67
            $iden_com->iden_num_adl     = $request->iden_num_adu;
            $iden_com->iden_num_org     = $request->iden_num_org;
            $iden_com->iden_num_ins     = $request->iden_num_ins;
            $iden_com->pro_an_id        = $request->pro_an_id;
            $iden_com->usu_id           = session()->all()["id_usuario"];
            $respuesta = $iden_com->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();

            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', 'iden_com' =>$iden_com, "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
            // FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function dataIdentificacionOrganizacion(){

        try{
            
            $gra_for = GradoFormalizacion::select("gra_for_id","gra_for_nom")->get();
            $tip_org = TipoOrganizacion::select("tip_org_id","tip_org_nom")->get();
            

            $gra_for = json_encode($gra_for);
            $tip_org  = json_encode($tip_org);   
           
            return response()->json(
                array(
                    'gra_for' => $gra_for,
                    'tip_org'  => $tip_org  
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }

    public function guardarProblematica(Request $request){
        $existe = DB::select("select * from ai_matriz_rango_etario where mat_idePro_nna_id = ".$request->id." and pro_an_id = ".$request->pro_an_id." and mat_tip_ran_eta_id = ".$request->tipo);
        if(count($existe) > 0){
            $resp = DB::update("update ai_matriz_rango_etario set mat_ran_eta_mag = '".$request->Magnitud."', mat_ran_eta_grav = '".$request->Gravedad."', mat_ran_eta_cap = '".$request->Capacidad."', mat_ran_eta_alt_sol = '".$request->AlterSol."', mat_ran_eta_ben = '".$request->Beneficio."', updated_at = sysdate
            where mat_idePro_nna_id = ".$request->id." and pro_an_id = ".$request->pro_an_id." and mat_tip_ran_eta_id = ".$request->tipo);
        }else{
            $resp = DB::insert("insert into ai_matriz_rango_etario(mat_ran_eta_mag, mat_ran_eta_grav, mat_ran_eta_cap, mat_ran_eta_alt_sol, mat_ran_eta_ben, mat_idePro_nna_id, mat_tip_ran_eta_id, pro_an_id, USU_ID, created_at)
            values('".$request->Magnitud."', '".$request->Gravedad."', '".$request->Capacidad."', '".$request->AlterSol."', '".$request->Beneficio."', ".$request->id.", ".$request->tipo.", ".$request->pro_an_id.", ".session('id_usuario').", sysdate)");
        }
        
        return 1;
    }
    
    public function cargarProblematica(Request $request){
        $datos = DB::select("select * from ai_matriz_rango_etario mre 
        where mre.mat_idePro_nna_id = ".$request->id." 
        and mre.pro_an_id = ".$request->pro_an_id." 
        and mre.mat_tip_ran_eta_id = ".$request->tipo);
        return $datos;
    }

    //INICIO DC SPRINT 67
    public function despriorizarProblematica(Request $request){
        $respuesta = DB::delete("delete from ai_matriz_rango_etario_prob where mat_ide_pro_nna_id = ".$request->mat_idePro_nna_id);
        if($respuesta){
            return response()->json(array('estado' => '1', 'mensaje' =>'Se ha despriorizado la problematica' ), 200);
        }else{
            return response()->json(array('estado' => '0', 'mensaje' =>'Se ha despriorizado la problematica' ), 200);
        }
    }
    
    public function verificaPriorizacion(Request $request){
        $datos = DB::select("select count(*) as cantidad from ai_matriz_rango_etario mre
        inner join ai_matriz_rango_etario_prob mrep
        on mrep.mat_ide_pro_nna_id = mre.mat_idepro_nna_id
        where pro_an_id = ".$request->pro_an_id);
        return $datos;
    }
	//FIN DC SPRINT 67

    public function listarOrganizacionesFuncionales(Request $request){
        
        $respuesta = DgOrgComunal::where("pro_an_id", $request->id)->get();
        if(count($respuesta) > 0){
            foreach($respuesta as $v1){

                if($v1->tip_org_id == 17){
                    $v1->tip_org = $v1->tip_org_otr;
                }else{

                    $tip_org_nom = TipoOrganizacion::select("TIP_ORG_NOM")->where("tip_org_id",$v1->tip_org_id)->get();
                    
                    $v1->tip_org = $tip_org_nom[0]->tip_org_nom;
                }

                if($v1->gra_for_id == 5){
                    $v1->gra_for = $v1->gra_for_otr;
                }else{
                    $gra_for_nom = GradoFormalizacion::select("GRA_FOR_NOM")->where('gra_for_id',$v1->gra_for_id)->get();
                    $v1->gra_for = $gra_for_nom[0]->gra_for_nom;
                }
            }
        }


        $data   = new \stdClass();
        $data->data = $respuesta;

        echo json_encode($data); exit;
    }

    public function eliminarOrganizacionFuncional(Request $request){
        try{            
            if (!isset($request->dg_org_id) || $request->dg_org_id == ""){
                $mensaje = "No se encuentra ID de Organización. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200); 
            }

            DB::beginTransaction();

            $org_com = DgOrgComunal::find($request->dg_org_id);
            
            $respuesta = $org_com->delete();
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de eliminar la organización. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            $cont = DgOrgComunal::where("pro_an_id",$request->pro_an_id)->count();

            $iden_com = DgIdentidadCom::where("pro_an_id",$request->pro_an_id)->first();

            if(count($iden_com) == 0){
                $iden_com = new DgIdentidadCom();
            
            }else{
                $iden_com = DgIdentidadCom::find($iden_com->iden_id);
            
            }
            
            $iden_com->iden_num_org = $cont;
            $respuesta = $iden_com->save();
            if (!$respuesta){
                DB::rollback();
                    // INICIO CZ SPRINT 66
                    $mensaje = "Hubo un error al momento de eliminar la organización. Por favor intente nuevamente.";
                    // FIN CZ SPRINT 66 
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();

            $mensaje = "Registro Eliminado exitosamente";
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje, 'cont' => $cont ), 200);
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de eliminar la organización. Por favor intente nuevamente.";
            // FIN CZ SPRINT 66
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function agregarOrganizacionFuncional(Request $request){
        try{   
            $opc        = $request->opc;
            if ($opc == 1){
                $dg_org_id = $request->dg_org_id;
            }

            $request    = $request->info;
            if (!isset($request["org_nom"]) || $request["org_nom"] == ""){
                $mensaje = "No se encuentra el Nombre de la Organización. Por favor verifique e intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request["org_tip_id"]) || $request["org_tip_id"] == ""){
                $mensaje = "No se encuentra ID del Tipo de Organización. Por favor verifique e intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request["org_gra_id"]) || $request["org_gra_id"] == ""){
                $mensaje = "No se encuentra ID de Grado de Formalización. Por favor verifique e intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request["org_rep"]) || $request["org_rep"] == ""){
                $mensaje = "No se encuentra Nombre de Representante. Por favor verifique e intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request["org_tel"]) || $request["org_tel"] == ""){
                $mensaje = "No se encuentra número de Teléfono. Por favor verifique e intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            //INICIO CZ SPRINT 67
            // if (!isset($request["org_cor"]) || $request["org_cor"] == ""){
            //     $mensaje = "No se encuentra . Por favor verifique e intente nuevamente.";

            //     return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            // }
            // FIN CZ SPRINT 67
            DB::beginTransaction();

            if ($opc == 0){
                $mensaje = "Registro Guardar Exitosamente";

                $org_com = new DgOrgComunal();
            }else if ($opc == 1){
                $mensaje = "Registro Actualizado Exitosamente.";

                $org_com = DgOrgComunal::where("dg_org_id", $dg_org_id)->first();
            }

            $org_com->DG_ORG_NOM     = $request["org_nom"];
            $org_com->TIP_ORG_ID     = $request["org_tip_id"];
            $org_com->TIP_ORG_OTR    = $request["org_tip_ot"];
            $org_com->GRA_FOR_ID     = $request["org_gra_id"];
            $org_com->GRA_FOR_OTR    = $request["org_gra_ot"];
            $org_com->DG_ORG_NOM_REP = $request["org_rep"];
            $org_com->DG_ORG_TELF    = $request["org_tel"];
            $org_com->DG_ORG_COR     = $request["org_cor"];
            $org_com->PRO_AN_ID      = $request["pro_an_id"];
            $org_com->USU_ID         = session()->all()["id_usuario"];
            $respuesta = $org_com->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de registrar la organización. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $cont = DgOrgComunal::where("pro_an_id",$request["pro_an_id"])->count();

            $iden_com = DgIdentidadCom::where("pro_an_id",$request["pro_an_id"])->first();

            if(count($iden_com) == 0){
                $iden_com = new DgIdentidadCom();
            
            }else{
                $iden_com = DgIdentidadCom::find($iden_com->iden_id);
            
            }
            
            $iden_com->iden_num_org = $cont;
            $respuesta = $iden_com->save();
            if (!$respuesta){
                DB::rollback();
                    $mensaje = "Hubo un error al momento realizar la acción solicitada. Por favor intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            
            DB::commit();
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje, 'cont' => $cont ), 200);
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente.";
			
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }

    }

    public function dataInstitucionesServicios(){

        try{
            
            $ins_ser_tip = TipoInstServicio::select("tip_int_id","tip_int_nom")->get();
            

            $ins_ser_tip = json_encode($ins_ser_tip);  
           
            return response()->json(
                array(
                    'ins_ser_tip' => $ins_ser_tip,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }

    public function listarInstitucionesServicios(Request $request){
        
        $respuesta = DgInstServicios::where("pro_an_id", $request->id)->get();

        if(count($respuesta) > 0){
            foreach($respuesta as $v1){
                
                if($v1->tip_int_id == 17){
                    $v1->dg_ins = $v1->dg_ins_otr;
                }else{

                    $tip_int_nom = TipoInstServicio::select("TIP_INT_NOM")->where("tip_int_id",$v1->tip_int_id)->get();
                    
                    $v1->dg_ins = $tip_int_nom[0]->tip_int_nom;
                }
            }
        }
        
        $data   = new \stdClass();
        $data->data = $respuesta;

        echo json_encode($data); exit;
    }

    public function eliminarInstitucionesServicios(Request $request){
        try{            
            if (!isset($request->dg_ins_id) || $request->dg_ins_id == ""){
                $mensaje = "No se encuentra ID de institución / Servicio. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();

            $int_ser = DgInstServicios::where("dg_ins_id", $request->dg_ins_id)->first();

            $respuesta = $int_ser->delete();
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de eliminar la Institución / Servicio. Por favor verifique e intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            $cont = DgInstServicios::where("pro_an_id",$request->pro_an_id)->count();

            $iden_com = DgIdentidadCom::where("pro_an_id",$request->pro_an_id)->first();

            if(count($iden_com) == 0){
                $iden_com = new DgIdentidadCom();
            
            }else{
                $iden_com = DgIdentidadCom::find($iden_com->iden_id);
            
            }
            
            $iden_com->iden_num_org = $cont;
            
            $respuesta = $iden_com->save();
            if (!$respuesta){
                DB::rollback();
                // INICIO CZ SPRINT 66
                    $mensaje = "Hubo un error al momento de eliminar la Institución / Servicio. Por favor intente nuevamente.";
                //FIN CZ SPRINT 66
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            $mensaje = "Registro Eliminado exitosamente";
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje, 'cont' => $cont ), 200);
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de eliminar la Institución / Servicio. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function agregarInstitucionesServicios(Request $request){
        try{            
            $opc = $request->opc;
            $data = $request->info;
            if ($opc == 1){
                $dg_ins_id = $request->dg_ins_id;

                if (!isset($dg_ins_id) || $dg_ins_id == ""){
                    $mensaje = "No se encuentra ID de la Institución o Servicio. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
            }


            if (!isset($data["ins_ser_nom"]) || $data["ins_ser_nom"] == ""){
                $mensaje = "No se encuentra el Nombre de la Institución o Servicio. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($data["ins_ser_tip"]) || $data["ins_ser_tip"] == ""){
                $mensaje = "No se encuentra el ID del Tipo de Institución. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($data["ins_ser_acc"]) || $data["ins_ser_acc"] == ""){
                $mensaje = "No se encuentra el valor del Acceso seleccionado. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();

            if ($opc == 0){ //AGREGAR
                $mensaje = "Registro guardado exitosamente.";
                
                $ins_ser = new DgInstServicios();

            }else if ($opc == 1){ //EDITAR
                $mensaje = "Registro actualizado exitosamente.";

                $ins_ser = DgInstServicios::where("dg_ins_id", $dg_ins_id)->first();
            }


            $ins_ser->DG_INS_NOM     = $data["ins_ser_nom"];
            $ins_ser->TIP_INT_ID     = $data["ins_ser_tip"];
            $ins_ser->DG_INS_OTR     = $data["ins_ser_otr"];
            $ins_ser->DG_INS_ACC     = $data["ins_ser_acc"];
            $ins_ser->PRO_AN_ID      = $data["pro_an_id"];
            $ins_ser->USU_ID         = session()->all()["id_usuario"];
            $respuesta = $ins_ser->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de registrar la institución. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            $cont = DgInstServicios::where("pro_an_id", $data["pro_an_id"])->count();

            $iden_com = DgIdentidadCom::where("pro_an_id", $data["pro_an_id"])->first();

            if(count($iden_com) == 0){
                $iden_com = new DgIdentidadCom();
            
            }else{
                $iden_com = DgIdentidadCom::find($iden_com->iden_id);
            
            }

            // $iden_com->iden_num_org = $cont;
            // INICIO CZ SPRINT 75 MANTIS 10079
            $iden_com->iden_num_ins = $cont;
            //FIN CZ SPRINT 75 MANTIS 10079
            $respuesta = $iden_com->save();
            if (!$respuesta){
                DB::rollback();
                // INICIO CZ SPRINT 66
                    $mensaje = "Hubo un error al momento de registrar la institución. Por favor intente nuevamente.";
                // FIN CZ SPRINT 66
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje, 'cont' => $cont), 400);
            }
            
            DB::commit();
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje, 'cont' => $cont ), 200);
        }catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de registrar la institución. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }

    }

    public function dataBienesComunitarios(){

        try{
            
            $bien_com_tip = BienesComnitarios::select("bien_id","bien_nom")->get();
            

            $bien_com_tip = json_encode($bien_com_tip);  
           
            return response()->json(
                array(
                    'bien_com_tip' => $bien_com_tip,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }

    public function listarBienesComunes(Request $request){
        
        $respuesta = DgBienesComunes::where("pro_an_id", $request->id)->get();

        if(count($respuesta) > 0){
            foreach($respuesta as $v1){
                if($v1->bien_id == 6){
                    $v1->dg_bn = $v1->dg_bn_otr;
                }else{

                    $bien_nom = BienesComnitarios::select("bien_nom")->where("bien_id",$v1->bien_id)->get();
                    
                    $v1->dg_bn = $bien_nom[0]->bien_nom;
                }
                
            }
        }
        
        $data   = new \stdClass();
        $data->data = $respuesta;

        echo json_encode($data); exit;
    }

    public function eliminarBienesComunes(Request $request){
        try{ 
            if (!isset($request->dg_bn_id) || $request->dg_bn_id == ""){
                    $mensaje = "No se encuentra ID del Bien Común. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            DB::beginTransaction();

            $bn_com = DgBienesComunes::find($request->dg_bn_id);
            
            $respuesta = $bn_com->delete();
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de eliminar el Bienes Común. Por favor verifique e intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }
            
            DB::commit();
            $mensaje = "Registro eliminado exitosamente.";
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje ), 200);
        }catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de eliminar el Bienes Común. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function agregarBienesComunes(Request $request){
        try{       
            $opc = $request->opc;

            if ($opc == 1){ //EDITAR
                $dg_bn_id = $request->dg_bn_id;

                if (!isset($dg_bn_id) || $dg_bn_id == ""){
                    $mensaje = "No se encuentra ID del Bien Común. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
                }
            }

            $data = $request->info;

            if (!isset($data["bien_com_nom"]) || $data["bien_com_nom"] == ""){
                $mensaje = "No se encuentra el Nombre del Bien Común. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            if (!isset($data["bien_com_tip"]) || $data["bien_com_tip"] == ""){
                $mensaje = "No se encuentra el ID del Tipo de Bienes. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            if (!isset($data["bien_com_acc"]) || $data["bien_com_acc"] == ""){
                $mensaje = "No se encuentra valor de Acceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' =>$mensaje ), 200);
            }

            if ($opc == 0){ //AGREGAR
                $bn_com = new DgBienesComunes();

                $mensaje = "Registro guardado exitosamente.";
            }else if ($opc == 1){ // EDITAR
                $bn_com = DgBienesComunes::where("dg_bn_id", $dg_bn_id)->first();

                $mensaje = "Registro actualizado exitosamente.";
            }

            DB::beginTransaction();

            $bn_com->DG_BN_NOM      = $data["bien_com_nom"];
            $bn_com->BIEN_ID        = $data["bien_com_tip"];
            $bn_com->DG_BN_OTR      = $data["bien_com_otr"];
            $bn_com->DG_BN_ACC      = $data["bien_com_acc"];
            $bn_com->PRO_AN_ID      = $data["pro_an_id"];
            $bn_com->USU_ID         = session()->all()["id_usuario"];

            $respuesta = $bn_com->save();
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de registrar los bienes comunes. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            return response()->json(array('estado' => '1', 'mensaje' =>$mensaje ), 200);
        }catch(\Exception $e) {
			DB::rollback();
			Log::error('error: '.$e);
            // INCIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de registrar los bienes comunes. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    // FACTORES DE RIESGO SOCIONATURALES 
    public function listarSocioNaturales(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
       
        if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
        $respuesta = FactoresGC::where("fac_gc_tip", 1)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach ($data->data AS $i => $v){
                $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $v->fac_gc_id)->get();

                $v["checked"] = false;
                if (count($consulta) > 0){
                    $v["checked"] = true;

                }
            }
        }
        }else{
            $respuesta = FactoresGC::where("fac_gc_tip", 1)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')
            ->leftJoin("ai_respuestas_factores_gc rf", "ai_factores_gc.fac_gc_id", "=", "rf.fac_gc_id")
            ->where("pro_an_id", $request->pro_an_id)
            ->get();
            if (count($respuesta) > 0){
                $data->data = $respuesta;

                foreach ($data->data AS $i => $v){
                    $v["checked"] = true;
                }  
            }
        }
        

        echo json_encode($data); exit; 
    }

    // FACTORES DE RIESGO INFRAESTRUCTURA
    public function listarRiesgoInfraEstructura(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
        $respuesta = FactoresGC::where("fac_gc_tip", 2)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach ($data->data AS $i => $v){
                $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $v->fac_gc_id)->get();

                $v["checked"] = false;
                if (count($consulta) > 0){
                    $v["checked"] = true;

                }
            }

        }
        }else{
            $respuesta = FactoresGC::where("fac_gc_tip", 2)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')
            ->leftJoin("ai_respuestas_factores_gc rf", "ai_factores_gc.fac_gc_id", "=", "rf.fac_gc_id")
            ->where("pro_an_id", $request->pro_an_id)
            ->get();
            if (count($respuesta) > 0){
                $data->data = $respuesta;

                foreach ($data->data AS $i => $v){
                    $v["checked"] = true;
                }  
            }
        }


        echo json_encode($data); exit; 
    }

    // FACTORES DE RIESGO SOCIOCOMUNITARIOS
    public function listarRiesgoSocioComunitarios(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
        $respuesta = FactoresGC::where("fac_gc_tip", 3)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach ($data->data AS $i => $v){
                $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $v->fac_gc_id)->get();

                $v["checked"] = false;
                if (count($consulta) > 0){
                    $v["checked"] = true;

                }
            }

        }
        }else{
            $respuesta = FactoresGC::where("fac_gc_tip", 3)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')
            ->leftJoin("ai_respuestas_factores_gc rf", "ai_factores_gc.fac_gc_id", "=", "rf.fac_gc_id")
            ->where("pro_an_id", $request->pro_an_id)
            ->get();
            if (count($respuesta) > 0){
                $data->data = $respuesta;

                foreach ($data->data AS $i => $v){
                    $v["checked"] = true;
                }  
            }
        }

        echo json_encode($data); exit; 
    }

    // FACTORES PROTECTORES INFRAESTRTUCTURA
     public function listarProtectoresInfraEstructura(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
        $respuesta = FactoresGC::where("fac_gc_tip", 4)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach ($data->data AS $i => $v){
                $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $v->fac_gc_id)->get();

                $v["checked"] = false;
                if (count($consulta) > 0){
                    $v["checked"] = true;

                }
            }

        }
        }else{
            $respuesta = FactoresGC::where("fac_gc_tip", 4)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')
            ->leftJoin("ai_respuestas_factores_gc rf", "ai_factores_gc.fac_gc_id", "=", "rf.fac_gc_id")
            ->where("pro_an_id", $request->pro_an_id)
            ->get();
            if (count($respuesta) > 0){
                $data->data = $respuesta;

                foreach ($data->data AS $i => $v){
                    $v["checked"] = true;
                }  
            }
        }
        

        echo json_encode($data); exit; 
    }

    // FACTORES PROTECTORES SOCIOCOMUNITARIOS
     public function listarProtectoresSocioComunitarios(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        if (Session::get('perfil') == config('constantes.perfil_gestor_comunitario')){
        $respuesta = FactoresGC::where("fac_gc_tip", 5)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach ($data->data AS $i => $v){
                $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $v->fac_gc_id)->get();

                $v["checked"] = false;
                if (count($consulta) > 0){
                    $v["checked"] = true;

                }
            }
        }
        }else{
            $respuesta = FactoresGC::where("fac_gc_tip", 5)->where("fac_gc_act", 1)->orderBy('fac_gc_ord', 'ASC')
            ->leftJoin("ai_respuestas_factores_gc rf", "ai_factores_gc.fac_gc_id", "=", "rf.fac_gc_id")
            ->where("pro_an_id", $request->pro_an_id)
            ->get();
            if (count($respuesta) > 0){
                $data->data = $respuesta;

                foreach ($data->data AS $i => $v){
                    $v["checked"] = true;
                }  
            }
        }
        

        echo json_encode($data); exit; 
    }

    

    

    

    public function guardarRespuestaFactor(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra el ID del proceso. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->fac_gc_id) || $request->fac_gc_id == ""){
                $mensaje = "No se encuentra el ID del Factor. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            // if (){
            //     if (isset($request->) || $request-> == ""){
            //         $mensaje = "";

            //         return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            //     }   
            // }

            $consulta = RespuestaFactoresGC::where("pro_an_id", $request->pro_an_id)->where("fac_gc_id", $request->fac_gc_id)->first();

            DB::beginTransaction();

            if ($request->accion == "Agregar" && count($consulta) == 0){
                $resp = new RespuestaFactoresGC();
                $resp->pro_an_id = $request->pro_an_id;
                $resp->usu_id = session()->all()["id_usuario"];
                $resp->fac_gc_id = $request->fac_gc_id;
                // $resp->re_fa_gc_des = ;
                $respuesta = $resp->save();
                if (!$respuesta){
                    $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
            
            }else if ($request->accion == "Eliminar"){
                $respuesta = RespuestaFactoresGC::where('re_fa_gc_id', $consulta->re_fa_gc_id)->delete();
                if (!$respuesta){
                    $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }
            }

            DB::commit();
            $mensaje = "Acción registrada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66 
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRITN 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }    
    }

    public function editarOrganizacionFuncional(Request $request){
        try{
            if (!isset($request->dg_org_id) || $request->dg_org_id == ""){
                $mensaje = "No se encuentra el ID de la información solicitada. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
        
            $consulta  = DgOrgComunal::where("dg_org_id", $request->dg_org_id)->first();

            if (count($consulta) == 0){
                $mensaje = "No se encuentra la información solicitada. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            return response()->json(array('estado' => '1', 'respuesta' => $consulta), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        
        }    
    }


    public function editarInstitucionesServicios(Request $request){
         try{
            if (!isset($request->dg_ins_id) || $request->dg_ins_id == ""){
                $mensaje = "No se encuentra el ID de la información solicitada. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }


            $consulta = DgInstServicios::where("dg_ins_id", $request->dg_ins_id)->first();

            if (count($consulta) == 0){
                $mensaje = "No se encuentra la información solicitada. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            return response()->json(array('estado' => '1', 'respuesta' => $consulta), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        
        }    
    }

    public function editarBienesComunes(Request $request){
         try{
            if (!isset($request->dg_bn_id) || $request->dg_bn_id == ""){
                $mensaje = "No se encuentra el ID del Bien Comunitario solicitado. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $consulta = DgBienesComunes::where("dg_bn_id", $request->dg_bn_id)->first();

            if (count($consulta) == 0){
                $mensaje = "No se encuentra la información solicitada. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            return response()->json(array('estado' => '1', 'respuesta' => $consulta), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de realizar la acción solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        
        }    
    }



    /*********************** LINEA BASE ***********************/

    public function listarLineaBase(Request $request){
        
        $data   = new \stdClass();

        $pro_an_id = $request->pro_an_id;
        
        $data->data = array();
        //inicio ch
        $respuesta = LineaBase::where("pro_an_id", $pro_an_id)->get();
        //fin ch
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach($respuesta as $v){
                $v->lin_bas_rut = Rut::parse($v->lin_bas_rut.$v->lin_bas_dv)->format();
            }
        }

        echo json_encode($data); exit;
    }

    public function listarPreguntasServicios(Request $request){
        $data   = new \stdClass();

        $tipo = $request->pre_tip;
        if($request->pre_tip == 0) $tipo = 1;
        
        $data->data = array();
        $respuesta = PreguntasLB::where("lb_pre_tip", $tipo)->where("lb_pre_act", 1)->orderBy('lb_pre_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                    $consulta = RespuestasLB::where("lb_pre_id",$v->lb_pre_id)->where("lin_bas_id", $request->lin_bas_id)->where("lb_res_tip", $request->pre_tip)->first();
                    
                    if (count($consulta) > 0){
                        $v["resp1"] = $consulta->lb_res_pre1;
                        $v["resp2"] = $consulta->lb_res_pre2;
                        $v["resp3"] = $consulta->lb_res_pre3;
                    }
                }
            }
        }

        echo json_encode($data); exit; 
    }

    public function listarPreguntasParticipacion(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        $respuesta = DerechoParticipacion::where("lb_par_act", 1)->orderBy('lb_par_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                    $consulta = LineaBase::find($request->lin_bas_id);
                    $n = $i+1;
                    
                    if (count($consulta) > 0){
                        $v["resp"] = $consulta["lin_bas_res".$n];
                    }
                }
            }
            
        }

        echo json_encode($data); exit;
    }

    public function editarLineaIdent(Request $request){

        try{
            
            $iden_lb = LineaBase::find($request->id);
                        
            $iden_lb->lin_bas_rut = Rut::parse($iden_lb->lin_bas_rut.$iden_lb->lin_bas_dv)->format();
            $iden_lb = json_encode($iden_lb);  
           
            return response()->json(
                array(
                    'iden_lb' => $iden_lb,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }

    }

    public function guardarLineaBase(Request $request){

        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra el ID del proceso. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();
            $lin_bas_id = $request->lin_bas_id;
            if($lin_bas_id == ""){
                $lineabase = new LineaBase();
            }else{
                $lineabase = LineaBase::find($lin_bas_id);
            }
            
            
            $lineabase->pro_an_id = $request->pro_an_id;
            $lineabase->usu_id = session()->all()["id_usuario"];

            $lineabase->lin_bas_nom = $request->iden["lin_bas_nom"];
            $lineabase->lin_bas_rut = $request->iden["lin_bas_rut"];
            $lineabase->lin_bas_dv =  $request->iden["lin_bas_dv"];
            $lineabase->lin_bas_com = $request->iden["lin_bas_com"];
            // $lineabase->lin_bas_dir = $request->iden["lin_bas_dir"];
            $lineabase->lin_bas_cal = $request->iden["lin_bas_cal"];
            $lineabase->lin_bas_num = $request->iden["lin_bas_num"];
            $lineabase->lin_bas_bloc = $request->iden["lin_bas_bloc"];
            $lineabase->lin_bas_dep = $request->iden["lin_bas_dep"];
            $lineabase->lin_bas_tel = $request->iden["lin_bas_tel"];
            $lineabase->lin_bas_cor = $request->iden["lin_bas_cor"];
            $lineabase->lin_bas_eda = $request->iden["lin_bas_eda"];

            $lineabase->lin_bas_otr1 = $request->preg["ser_niv_com"];
            $lineabase->lin_bas_otr2 = $request->preg["ser_pro_soc"];
            $lineabase->lin_bas_otr3 = $request->preg["ser_ser_sec"];
            $lineabase->lin_bas_otr4 = $request->preg["bie_com"];
            $lineabase->lin_bas_otr5 = $request->preg["bien_org_otr"];
            $lineabase->lin_bas_part = $request->preg["bien_org_part"];

            $lineabase->lin_bas_res1 = $request->part["lin_bas_res1"];
            $lineabase->lin_bas_res2 = $request->part["lin_bas_res2"];
            $lineabase->lin_bas_res3 = $request->part["lin_bas_res3"];
            $lineabase->lin_bas_res4 = $request->part["lin_bas_res4"];
            $lineabase->lin_bas_res5 = $request->part["lin_bas_res5"];
            $lineabase->lin_bas_res6 = $request->part["lin_bas_res6"];
            $lineabase->lin_bas_res7 = $request->part["lin_bas_res7"];
            //inicio ch
            $lineabase->lb_fas_id = 1;
            //fin ch

            
            $respuesta = $lineabase->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if(isset($request->preg["preguntas"])){
                foreach($request->preg["preguntas"] as $c1 => $v1){
                    if($v1 != null){

                        if(($v1["resp1"] != 0)||($v1["resp2"] != 0)||($v1["resp3"] != 0)){

                            if($lin_bas_id == ""){
                                $resp = new RespuestasLB();
                            }else{
                                $resultado = RespuestasLB::where("lin_bas_id",$lin_bas_id)->where("lb_res_tip",$v1["tipo"])->where("lb_pre_id",$v1["id"])->first();
                                if(count($resultado)>0){
                                    $resp = RespuestasLB::find($resultado->lb_res_id);
                                }else{
                                    $resp = new RespuestasLB();
                                }
                                
                            }
                            $resp->lb_pre_id    = $v1["id"];
                            $resp->lb_res_tip   = $v1["tipo"];
                            $resp->lb_res_pre1  = $v1["resp1"];
                            $resp->lb_res_pre2  = $v1["resp2"];
                            $resp->lb_res_pre3  = $v1["resp3"];
                            $resp->lb_fas_id    = 1;
                            $resp->lin_bas_id   = $lineabase->lin_bas_id;

                            $respuesta = $resp->save();
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }
                        }else{
                            $resultado = RespuestasLB::where("lin_bas_id",$lin_bas_id)->where("lb_res_tip",$v1["tipo"])->where("lb_pre_id",$v1["id"])->where("lb_fas_id",1)->first();
                                if(count($resultado)>0){
                                    $resp = RespuestasLB::find($resultado->lb_res_id);
                                    $respuesta = $resp->delete();
                                    if (!$respuesta){
                                        $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
                        
                                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                                    }
                                }
                        }
                    }
                }
            }

            DB::commit();
            $mensaje = "Acción registrada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INCIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }
    //INICIO CH
    public function descargarLineaBase( Request $request){

        $lineabase = Lineabase::where('lin_bas_id', $request->lin_bas_id)->first();


        /* TABLA 1 */
        $res1_tab1 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 1)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res1_tab1 as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->lb_pre_id)->value('lb_pre_nom');
        }
        
        /* TABLA 2 */
        $res2_tab2 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res2_tab2 as $res2_tab2u){
            $res2_tab2u->nombre = PreguntasLB::where('lb_pre_id', $res2_tab2u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 3 */
        $res3_tab3 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 0)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res3_tab3 as $res3_tab3u){
            $res3_tab3u->nombre = PreguntasLB::where('lb_pre_id', $res3_tab3u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 4 */
        $res4_tab4 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip',3)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res4_tab4 as $res4_tab4u){
            $res4_tab4u->nombre = PreguntasLB::where('lb_pre_id', $res4_tab4u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 5 */
        $res5_tab5 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2','lb_res_pre3')->where('lb_res_tip', 4)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res5_tab5 as $res5_tab5u){
            $res5_tab5u->nombre = PreguntasLB::where('lb_pre_id', $res5_tab5u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 6 */
        $res1_tab7 = Lineabase::select('LIN_BAS_RES1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res2_tab7 = Lineabase::select('LIN_BAS_RES2 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res3_tab7 = Lineabase::select('LIN_BAS_RES3 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res4_tab7 = Lineabase::select('LIN_BAS_RES4 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res5_tab7 = Lineabase::select('LIN_BAS_RES5 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res6_tab7 = Lineabase::select('LIN_BAS_RES6 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        $res7_tab7 = Lineabase::select('LIN_BAS_RES7 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->get();

        foreach($res1_tab7 as $res1_tab7u){
            $res1_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'1')->value('lb_par_nom');
        }
        foreach($res2_tab7 as $res2_tab7u){
            $res2_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'2')->value('lb_par_nom');
        }
        foreach($res3_tab7 as $res3_tab7u){
            $res3_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'3')->value('lb_par_nom');
        }
        foreach($res4_tab7 as $res4_tab7u){
            $res4_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'4')->value('lb_par_nom');
        }
        foreach($res5_tab7 as $res5_tab7u){
            $res5_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'5')->value('lb_par_nom');
        }
        foreach($res6_tab7 as $res6_tab7u){
            $res6_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'6')->value('lb_par_nom');
        }
        foreach($res7_tab7 as $res7_tab7u){
            $res7_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'7')->value('lb_par_nom');
        }

        $tabla7 = array(
            'resp1' => $res1_tab7,
            'resp2' => $res2_tab7,
            'resp3' => $res3_tab7,
            'resp4' => $res4_tab7,
            'resp5' => $res5_tab7,
            'resp6' => $res6_tab7,
            'resp7' => $res7_tab7
        );

        $pdf = new \PDF();

        $pdf = \PDF::loadView('gestor_comunitario/gestion_comunitaria/diagnostico_participativo/linea_base_pdf',[
            'nombre' => $lineabase->lin_bas_nom,
            'rut' =>$lineabase->lin_bas_rut,
            'dv' => $lineabase->lin_bas_dv,
            'comuna' =>$lineabase->lin_bas_com,
            'direccion' =>$lineabase->lin_bas_dir,
            'calle' => $lineabase->lin_bas_cal,
            'numero_calle'=> $lineabase->lin_bas_num,
            'bloc' => $lineabase->lin_bas_bloc,
            'depto' => $lineabase->lin_bas_dep,
            'telefono' => $lineabase->lin_bas_tel,
            'correo' => $lineabase->lin_bas_cor,
            'edad' => $lineabase->lin_bas_eda,
            'res1_tab1' => $res1_tab1,
            'res2_tab2' => $res2_tab2,
            'res3_tab3' => $res3_tab3,
            'res4_tab4' => $res4_tab4,
            'res5_tab5' => $res5_tab5,
            'res7_tab7' => $tabla7,
            'otro1' =>  $lineabase->lin_bas_otr1,
            'otro2' =>  $lineabase->lin_bas_otr2,
            'otro3' =>  $lineabase->lin_bas_otr3,
            'otro4' =>  $lineabase->lin_bas_otr4,
            'parte' => $lineabase->lin_bas_part,
            'otro5' =>  $lineabase->lin_bas_otr5
        ]);

       return $pdf->stream('Linea_Base.pdf');
       
    }
    //FIN CH
    public function eliminarLineaBase(Request $request){

        try{

            DB::beginTransaction();
            
            $resp = RespuestasLB::where("lin_bas_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = RespuestasLB::find($v->lb_res_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $lineabase = LineaBase::find($request->id);
            $respuesta = $lineabase->delete();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción eliminada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    /*********************** LINEA BASE ***********************/

    //inicio ch
    /*********************** LINEA SALIDA ***********************/
    public function listarLineaSalida(Request $request){
        
        $data   = new \stdClass();

        $pro_an_id = $request->pro_an_id;
        
        $data->data = array();
        $respuesta = LineaBase::where("pro_an_id", $pro_an_id)->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach($respuesta as $v){
                $v->lin_bas_rut = Rut::parse($v->lin_bas_rut.$v->lin_bas_dv)->format();
            }
        }
        echo json_encode($data); exit;
    }
// INICIO CZ SPRINT 70
    public function listarLineaSalida_2021(Request $request){
        $data   = new \stdClass();

        $pro_an_id = $request->pro_an_id;
        
        $data->data = array();
        $respuesta = LineaBaseIdentificacion::where("IDEN_PRO_AN_ID", $pro_an_id)->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach($respuesta as $key => $v){
                $v->iden_run = rut::parse($v->iden_run.$v->iden_dv)->format();
                $respuestaPersona = LineaBaseDerechoNinos::where("PRO_AN_ID", $pro_an_id)->where("DER_IDENT_ID",$v->iden_id)->where("DER_ID_LINEA_BASE",2)->get();
                if(count($respuestaPersona)>0){
                    $respuesta[$key]->tiene_respuesta = true;
                }else{
                    $respuesta[$key]->tiene_respuesta = false;
                }
               
            }
        }

        echo json_encode($data); exit;
    }
    // FIN CZ SPRINT 70
    public function guardarLineaSalida(Request $request){

        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra el ID del proceso. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();
            $lin_bas_id = $request->lin_bas_id;

            $lineabase = LineaBase::find($lin_bas_id);

            $lineabase->lin_bas_otr1_1 = $request->preg["ser_niv_com2"];
            $lineabase->lin_bas_otr2_1 = $request->preg["ser_pro_soc2"];
            $lineabase->lin_bas_otr3_1 = $request->preg["ser_ser_sec2"];
            $lineabase->lin_bas_otr4_1 = $request->preg["bie_com2"];
            $lineabase->lin_bas_otr5_1 = $request->preg["bien_org_otr2"];
            $lineabase->lin_bas_part_1 = $request->preg["bien_org_part2"];

            $lineabase->lin_bas_res1_1 = $request->part["lin_bas_res1_1"];
            $lineabase->lin_bas_res2_1 = $request->part["lin_bas_res2_1"];
            $lineabase->lin_bas_res3_1 = $request->part["lin_bas_res3_1"];
            $lineabase->lin_bas_res4_1 = $request->part["lin_bas_res4_1"];
            $lineabase->lin_bas_res5_1 = $request->part["lin_bas_res5_1"];
            $lineabase->lin_bas_res6_1 = $request->part["lin_bas_res6_1"];
            $lineabase->lin_bas_res7_1 = $request->part["lin_bas_res7_1"];
            $lineabase->lb_fas_id = 2;

            $respuesta = $lineabase->save();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if(isset($request->preg["preguntas"])){
                foreach($request->preg["preguntas"] as $c1 => $v1){
                    if($v1 != null){

                        if(($v1["resp11"] != 0)||($v1["resp21"] != 0)||($v1["resp31"] != 0)){

                            if($lin_bas_id == ""){
                                $resp = new RespuestasLB();
                            }else{
                                $resultado = RespuestasLB::where("lin_bas_id",$lin_bas_id)->where("lb_res_tip",$v1["tipo"])->where("lb_pre_id",$v1["id"])->first();
                                if(count($resultado)>0){
                                    $resp = RespuestasLB::find($resultado->lb_res_id);
                                }else{
                                }
                                $resp = new RespuestasLB();
                                
                            }
                            $resp->lb_pre_id    = $v1["id"];
                            $resp->lb_res_tip   = $v1["tipo"];
                            $resp->lb_res_pre1  = $v1["resp11"];
                            $resp->lb_res_pre2  = $v1["resp21"];
                            $resp->lb_res_pre3  = $v1["resp31"];
                            $resp->lb_fas_id = 2;
                            $resp->lin_bas_id   = $lineabase->lin_bas_id;
                            $respuesta = $resp->save();
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }
                        }else{
                            $resultado = RespuestasLB::where("lin_bas_id",$lin_bas_id)->where("lb_res_tip",$v1["tipo"])->where("lb_pre_id",$v1["id"])->first();
                                if(count($resultado)>0){
                                    $resp = RespuestasLB::find($resultado->lb_res_id);
                                    $respuesta = $resp->delete();
                                    if (!$respuesta){
                                        $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
                        
                                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                                    }
                                }
                        }
                    }
                }
            }

            DB::commit();
            $mensaje = "Acción registrada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }
    public function listarPreguntasServiciosLS(Request $request){
        $data   = new \stdClass();

        $tipo = $request->pre_tip;
        if($request->pre_tip == 0) $tipo = 1;
        
        $data->data = array();
        $respuesta = PreguntasLB::where("lb_pre_tip", $tipo)->where("lb_pre_act", 1)->orderBy('lb_pre_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                    $consulta = RespuestasLB::where("lb_pre_id",$v->lb_pre_id)->where("lin_bas_id", $request->lin_bas_id)->where("lb_res_tip", $request->pre_tip)->first();
                    
                    if (count($consulta) > 0){
                        $v["resp1"] = $consulta->lb_res_pre1;
                        $v["resp2"] = $consulta->lb_res_pre2;
                        $v["resp3"] = $consulta->lb_res_pre3;
                    }
                }
            }
        }

        echo json_encode($data); exit; 
    }
    public function listarPreguntasParticipacionLS(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        
        $respuesta = DerechoParticipacion::where("lb_par_act", 1)->orderBy('lb_par_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                    $consulta = LineaBase::find($request->lin_bas_id);
                    $n = $i+1;
                    
                    if (count($consulta) > 0){
                        $v["resp"] = $consulta["lin_bas_res".$n."_1"];
                    }
                }
            }
            
        }

        echo json_encode($data); exit;
    }
    public function editarLineaIdentLs(Request $request){

        try{
            
            $iden_lb = LineaBase::find($request->id);
                        
            $iden_lb->lin_bas_rut = Rut::parse($iden_lb->lin_bas_rut.$iden_lb->lin_bas_dv)->format();
            $iden_lb = json_encode($iden_lb);  
           
            return response()->json(
                array(
                    'iden_lb' => $iden_lb,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }

    }
    public function eliminarLineaSalida(Request $request){

        try{

            DB::beginTransaction();
            
            $resp = RespuestasLB::where("lin_bas_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = RespuestasLB::find($v->lb_res_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $lineabase = LineaBase::find($request->id);
            $respuesta = $lineabase->delete();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción eliminada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
            //FIN CZ SPRINT 66   
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }
        //INICIO CH
    public function descargarLineaSalida( Request $request){

        $lineabase = Lineabase::where('lin_bas_id', $request->lin_bas_id)->where("lb_fas_id", 2)->first();


        /* TABLA 1 */
        $res1_tab1 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 1)->where("lb_fas_id", 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res1_tab1 as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->lb_pre_id)->value('lb_pre_nom');
        }
        
        /* TABLA 2 */
        $res2_tab2 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 2)->where("lb_fas_id", 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res2_tab2 as $res2_tab2u){
            $res2_tab2u->nombre = PreguntasLB::where('lb_pre_id', $res2_tab2u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 3 */
        $res3_tab3 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip', 0)->where("lb_fas_id", 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res3_tab3 as $res3_tab3u){
            $res3_tab3u->nombre = PreguntasLB::where('lb_pre_id', $res3_tab3u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 4 */
        $res4_tab4 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2')->where('lb_res_tip',3)->where("lb_fas_id", 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res4_tab4 as $res4_tab4u){
            $res4_tab4u->nombre = PreguntasLB::where('lb_pre_id', $res4_tab4u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 5 */
        $res5_tab5 = RespuestasLB::select('lb_pre_id','lb_res_pre1','lb_res_pre2','lb_res_pre3')->where('lb_res_tip', 4)->where("lb_fas_id", 2)->where('lin_bas_id', $lineabase->lin_bas_id)->get();
        foreach($res5_tab5 as $res5_tab5u){
            $res5_tab5u->nombre = PreguntasLB::where('lb_pre_id', $res5_tab5u->lb_pre_id)->value('lb_pre_nom');
        }

        /* TABLA 6 */
        $res1_tab7 = Lineabase::select('LIN_BAS_RES1_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res2_tab7 = Lineabase::select('LIN_BAS_RES2_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res3_tab7 = Lineabase::select('LIN_BAS_RES3_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res4_tab7 = Lineabase::select('LIN_BAS_RES4_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res5_tab7 = Lineabase::select('LIN_BAS_RES5_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res6_tab7 = Lineabase::select('LIN_BAS_RES6_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();
        $res7_tab7 = Lineabase::select('LIN_BAS_RES7_1 AS valor')->where('lin_bas_id', $lineabase->lin_bas_id)->where("lb_fas_id", 2)->get();

        foreach($res1_tab7 as $res1_tab7u){
            $res1_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'1')->value('lb_par_nom');
        }
        foreach($res2_tab7 as $res2_tab7u){
            $res2_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'2')->value('lb_par_nom');
        }
        foreach($res3_tab7 as $res3_tab7u){
            $res3_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'3')->value('lb_par_nom');
        }
        foreach($res4_tab7 as $res4_tab7u){
            $res4_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'4')->value('lb_par_nom');
        }
        foreach($res5_tab7 as $res5_tab7u){
            $res5_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'5')->value('lb_par_nom');
        }
        foreach($res6_tab7 as $res6_tab7u){
            $res6_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'6')->value('lb_par_nom');
        }
        foreach($res7_tab7 as $res7_tab7u){
            $res7_tab7u->nombre = DerechoParticipacion::where('LB_PAR_ACT', '1')->where("lb_par_id",'7')->value('lb_par_nom');
        }

        $tabla7 = array(
            'resp1' => $res1_tab7,
            'resp2' => $res2_tab7,
            'resp3' => $res3_tab7,
            'resp4' => $res4_tab7,
            'resp5' => $res5_tab7,
            'resp6' => $res6_tab7,
            'resp7' => $res7_tab7
        );

        $pdf = new \PDF();

        $pdf = \PDF::loadView('gestor_comunitario/gestion_comunitaria/plan_estrategico/linea_salida/linea_salida_pdf',[
            'nombre' => $lineabase->lin_bas_nom,
            'rut' =>$lineabase->lin_bas_rut,
            'dv' => $lineabase->lin_bas_dv,
            'comuna' =>$lineabase->lin_bas_com,
            'direccion' =>$lineabase->lin_bas_dir,
            'calle' => $lineabase->lin_bas_cal,
            'numero_calle'=> $lineabase->lin_bas_num,
            'bloc' => $lineabase->lin_bas_bloc,
            'depto' => $lineabase->lin_bas_dep,
            'telefono' => $lineabase->lin_bas_tel,
            'correo' => $lineabase->lin_bas_cor,
            'edad' => $lineabase->lin_bas_eda,
            'res1_tab1' => $res1_tab1,
            'res2_tab2' => $res2_tab2,
            'res3_tab3' => $res3_tab3,
            'res4_tab4' => $res4_tab4,
            'res5_tab5' => $res5_tab5,
            'res7_tab7' => $tabla7,
            'otro1' =>  $lineabase->lin_bas_otr1_1,
            'otro2' =>  $lineabase->lin_bas_otr2_1,
            'otro3' =>  $lineabase->lin_bas_otr3_1,
            'otro4' =>  $lineabase->lin_bas_otr4_1,
            'parte' => $lineabase->lin_bas_part_1,
            'otro5' =>  $lineabase->LIN_BAS_OTR5_1
        ]);

       return $pdf->stream('Linea_Salida.pdf');
       
    }
    //FIN CH

    /*********************** LINEA SALIDA ***********************/
    //fin ch

    public function cambiarEstadoGestorComunitario(Request $request){
        try{
            $comentario = "";

            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->estado_actual) || $request->estado_actual == ""){
                
                $mensaje = "No se encuentra ID del estado actual del Proceso. Por favor verifique e intente nuevamente.";
                
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $estado = 1;
            
            switch ($request->estado_actual) {
                
                case config('constantes.identificacion_comunidad'): //CARTA DE COMPROMISO DE COMUNIDAD
                    $estado = config('constantes.carta_compromiso_comunidad');
                    $comentario = "";
                break;
                
                case config('constantes.carta_compromiso_comunidad'): //LINEA BASE
                    $estado = config('constantes.linea_base');
                    $comentario = "";
                break;

                case config('constantes.linea_base'): //MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA
                    $estado = config('constantes.matriz_identificación_problemas');
                    $comentario = "";
                break;

                case config('constantes.matriz_identificación_problemas'): //MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO
                    $estado = config('constantes.matriz_priorización_problemas');
                    $comentario = "";
                break;

                case config('constantes.matriz_priorización_problemas'): // MATRIZ DE FACTORES PROTECTORES
                    $estado = config('constantes.matriz_factores_protectores');
                    $comentario = "";
                break;

                case config('constantes.matriz_factores_protectores'): // INFORME DIAGNÓSTICO PARTICIPATIVO
                    $estado = config('constantes.informe_dpc');
                    $comentario = "";
                break;

                case config('constantes.informe_dpc'): // INFORME DPC INICIO CH
                    $estado = config('constantes.plan_estrategico');
                    $comentario = "";
                break;
                case config('constantes.plan_estrategico'): // PLAN ESTRATEGICO
                    $estado = config('constantes.linea_salida');
                    $comentario = "";
                break;
                case config('constantes.linea_salida'): // LINEA DE SALIDA
                    $estado = config('constantes.informe_plan_estrategico');
                    $comentario = "";
                break;
                
                case config('constantes.informe_plan_estrategico'): // INFORME PLAN ESTRATEGICO COMUNITARIO
                    $estado = config('constantes.informe_plan_estrategico');
                    $comentario = "";
                break;
                // FIN CH
                default:
                    $mensaje = "No se encuentra ID del estado siguiente del Proceso. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                break;
            }
            //dd($request->estado_actual);
            $proceso = ProcesoAnual::where("pro_an_id", $request->pro_an_id)->first();
            $proceso->est_pro_id = $estado;

            
            $respuesta = $proceso->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de actualizar el estado del Proceso. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            if(session()->all()['id_usuario']){
            $bitacora_estado = new ProcesoEstadoProceso();
            $bitacora_estado->usu_id = session()->all()['id_usuario'];
            $bitacora_estado->pro_an_id = $request->pro_an_id;
            $bitacora_estado->est_pro_id = $estado;
            $bitacora_estado->pro_est_des = $comentario;

            $estado_proceso = EstadoProceso::find($proceso->est_pro_id);
            $respuesta = $bitacora_estado->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar el estado del Proceso. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();

            $mensaje = "Cambio de Estado registrado con éxito.";
            // dd($estado);
            return response()->json(array('estado' => '1', 'est_pro_id' => $estado, 'est_pro_nom' => $estado_proceso->est_pro_nom,  'mensaje' => $mensaje), 200);
            }else{
                $mensaje = "Hubo un error al momento de registrar el estado del Proceso. Por favor intente nuevamente o contacte con el Administrador.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }
           
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de registrar el estado del Proceso. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function listarMatrizIdentificacionProblema(Request $request){
        // $usu_id   = session()->all()["id_usuario"];

        $consulta = "";
        if (isset($request->pro_an_id) && $request->pro_an_id != ""){
            $consulta = MatrizIdentificacionProblemaNNA::where('pro_an_id', '=', $request->pro_an_id)->leftJoin('ai_matriz_ejes_tematicos met','ai_matriz_ide_pro_nna.mat_eje_tem_id','=','met.mat_eje_tem_id')->get();

        }

        $data   = new \stdClass();
        $data->data = $consulta;

        echo json_encode($data); exit;
    }

    public function levantarFormularioMatrizIdentificacionProblema(Request $request){
        try{
            if (!isset($request->opc) || $request->opc == ""){
                $mensaje = "No se encuentra opción de levantamiento de formulario. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID de Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $respuesta = new \stdClass();

            $matriz = MatrizEjesTematico::all();
            $respuesta->matriz = $matriz;

            if ($request->opc == 1){ //EDITAR
                if (!isset($request->mat_ide_pro_nna_id) || $request->mat_ide_pro_nna_id == ""){
                    $mensaje = "No se encuentra ID de Proceso. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

                $consulta = MatrizIdentificacionProblemaNNA::where('mat_ide_pro_nna_id', '=', $request->mat_ide_pro_nna_id)->first();

                $respuesta->consulta = $consulta;
            }

            // dd($respuesta);

            $mensaje = "Cambio de Estado registrado con éxito.";
            return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de levantar el formulario. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

     public function guardarFormularioMatrizIdentificacionProblema(Request $request){
        try{
            if (!isset($request->opc) || $request->opc == ""){
                $mensaje = "No se encuentra opción de levantamiento de formulario. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID de Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_eje_tem_id) || $request->mat_eje_tem_id == ""){
                $mensaje = "No se encuentra ID de Categorías o Ejes Temáticos. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_pro_iden) || $request->mat_ide_pro_nna_pro_iden == ""){
                $mensaje = "No se encuentra Problemática Identificada. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_cau) || $request->mat_ide_pro_nna_cau == ""){
                $mensaje = "No se encuentran Causas. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_efe) || $request->mat_ide_pro_nna_efe == ""){
                $mensaje = "No se encuentran Efectos. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_acc_abo) || $request->mat_ide_pro_nna_acc_abo == ""){
                $mensaje = "No se encuentran Acciones que se han realizado para abordar el problema. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_ava) || $request->mat_ide_pro_nna_ava == ""){
                $mensaje = "No se encuentran Avances. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_con_per_com) || $request->mat_ide_pro_nna_con_per_com == ""){
                $mensaje = "No se encuentra Convergencia de percepciones de la comunidad. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_ide_pro_nna_div_per_com) || $request->mat_ide_pro_nna_div_per_com == ""){
                $mensaje = "No se encuentra Divergencia de percepciones de la comunidad. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }


            if ($request->opc == 0){ //AGREGAR
                $registrar = new MatrizIdentificacionProblemaNNA();
                $registrar->usu_id = session()->all()["id_usuario"];

            }else if ($request->opc == 1){ //EDITAR
                $registrar = MatrizIdentificacionProblemaNNA::where("mat_ide_pro_nna_id", $request->mat_ide_pro_nna_id)->first();

            }

            $registrar->pro_an_id = $request->pro_an_id;
            $registrar->mat_eje_tem_id = $request->mat_eje_tem_id;
            $registrar->mat_ide_pro_nna_pro_iden = $request->mat_ide_pro_nna_pro_iden;
            $registrar->mat_ide_pro_nna_cau = $request->mat_ide_pro_nna_cau;
            $registrar->mat_ide_pro_nna_efe = $request->mat_ide_pro_nna_efe;
            $registrar->mat_ide_pro_nna_acc_abo = $request->mat_ide_pro_nna_acc_abo;
            $registrar->mat_ide_pro_nna_ava = $request->mat_ide_pro_nna_ava;
            $registrar->mat_ide_pro_nna_con_per_com = $request->mat_ide_pro_nna_con_per_com;
            $registrar->mat_ide_pro_nna_div_per_com = $request->mat_ide_pro_nna_div_per_com;

            $respuesta = $registrar->save();
            if (!$respuesta){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);                
            }

            DB::commit();

            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de levantar el formulario. Por favor intente nuevamente o contacte con el Administrador.";
            
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }


    //INICIO DC SPRINT 67
    public function listarMatrizRangoEtario(Request $request){
        $consulta = "";

        if (isset($request->pro_an_id) && $request->pro_an_id != "" && isset($request->mat_tip_ran_eta_id) && $request->mat_tip_ran_eta_id != ""){
            // $usu_id   = session()->all()["id_usuario"];

            $consulta = MatrizIdentificacionProblemaNNA::where('ai_matriz_ide_pro_nna.pro_an_id', '=', $request->pro_an_id)
            ->leftJoin('ai_matriz_ejes_tematicos met','ai_matriz_ide_pro_nna.mat_eje_tem_id','=','met.mat_eje_tem_id')
            ->leftJoin('ai_matriz_rango_etario mre','ai_matriz_ide_pro_nna.mat_ide_pro_nna_id','=','mre.mat_idepro_nna_id')
            ->get();

            foreach ($consulta as $c1 => $v1){
                $priorizado = MatrizRangoEtarioProblema::where("mat_ide_pro_nna_id", $v1->mat_ide_pro_nna_id)
                ->leftJoin("ai_matriz_rango_etario mre", "ai_matriz_rango_etario_prob.mat_ran_eta_id", "=", "mre.mat_ran_eta_id")
                ->where("mat_tip_ran_eta_id", $request->mat_tip_ran_eta_id)
                ->first();
                
                $v1->priorizado = false;
                if (count($priorizado) > 0){
                    $v1->priorizado = true;

                }
            }
        }

        $data   = new \stdClass();
        $data->data = $consulta;

        echo json_encode($data); exit;
    }

    public function listarProblemasPriorizados(Request $request){
        $consulta = "";

        if (isset($request->pro_an_id) && $request->pro_an_id != ""){
            // $usu_id   = session()->all()["id_usuario"];

            $consulta = MatrizIdentificacionProblemaNNA::where('pro_an_id', '=', $request->pro_an_id)
            ->leftJoin('ai_matriz_ejes_tematicos met','ai_matriz_ide_pro_nna.mat_eje_tem_id','=','met.mat_eje_tem_id')
            ->Join("ai_matriz_rango_etario_prob mrep","ai_matriz_ide_pro_nna.mat_ide_pro_nna_id","=","mrep.mat_ide_pro_nna_id")
            ->get();
        }

        $data   = new \stdClass();
        $data->data = $consulta;

        echo json_encode($data); exit;
    }
    //FIN DC SPRINT 67

    public function cargarMatrizRangoEtario(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_tip_ran_eta_id) || $request->mat_tip_ran_eta_id == ""){
                $mensaje = "No se encuentra ID del Tipo de Rango Etario. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $consulta = MatrizRangoEtario::where("pro_an_id", $request->pro_an_id)->where("mat_tip_ran_eta_id", $request->mat_tip_ran_eta_id)->get();

            return response()->json(array('estado' => '1', 'respuesta' => $consulta), 200);
        }catch(\Exception $e){
            $mensaje = "Hubo un error al momento de cargar las respuestas del formulario. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function regitrarDataMatrizRangoEtario(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->mat_tip_ran_eta_id) || $request->mat_tip_ran_eta_id == ""){
                $mensaje = "No se encuentra ID del Tipo de Rango Etario. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if ((!isset($request->mat_ran_eta_mag) || $request->mat_ran_eta_mag == "") && 
                (!isset($request->mat_ran_eta_grav) || $request->mat_ran_eta_grav == "") &&   
                (!isset($request->mat_ran_eta_cap) || $request->mat_ran_eta_cap == "") &&   
                (!isset($request->mat_ran_eta_alt_sol) || $request->mat_ran_eta_alt_sol == "") &&   
                (!isset($request->mat_ran_eta_ben) || $request->mat_ran_eta_ben == "")){
                $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (isset($request->mat_ran_eta_id) && $request->mat_ran_eta_id != ""){
                $registrar = MatrizRangoEtario::where("mat_ran_eta_id", $request->mat_ran_eta_id)->first();

            }else{
                $registrar = new MatrizRangoEtario();
                $registrar->pro_an_id = $request->pro_an_id;
                $registrar->mat_tip_ran_eta_id = $request->mat_tip_ran_eta_id;
                $registrar->usu_id = session()->all()["id_usuario"];

            }

            DB::beginTransaction();

            if (isset($request->mat_ran_eta_mag) && $request->mat_ran_eta_mag != ""){
                if ((strlen($request->mat_ran_eta_mag) < 3) || (strlen($request->mat_ran_eta_mag) > config('constantes.cantidad_caracteres_TextArea_GCM'))){
                    $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }

                $registrar->mat_ran_eta_mag = $request->mat_ran_eta_mag;

            }

            if (isset($request->mat_ran_eta_grav) && $request->mat_ran_eta_grav != ""){
                if ((strlen($request->mat_ran_eta_grav) < 3) || (strlen($request->mat_ran_eta_grav) > config('constantes.cantidad_caracteres_TextArea_GCM'))){
                    $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }


                $registrar->mat_ran_eta_grav = $request->mat_ran_eta_grav;

            }

            if (isset($request->mat_ran_eta_cap) && $request->mat_ran_eta_cap != ""){
                if ((strlen($request->mat_ran_eta_cap) < 3) || (strlen($request->mat_ran_eta_cap) > config('constantes.cantidad_caracteres_TextArea_GCM'))){
                    $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }


                $registrar->mat_ran_eta_cap = $request->mat_ran_eta_cap;

            }

            if (isset($request->mat_ran_eta_alt_sol) && $request->mat_ran_eta_alt_sol != ""){
                if ((strlen($request->mat_ran_eta_alt_sol) < 3) || (strlen($request->mat_ran_eta_alt_sol) > config('constantes.cantidad_caracteres_TextArea_GCM'))){
                    $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }


                $registrar->mat_ran_eta_alt_sol = $request->mat_ran_eta_alt_sol;

            }

            if (isset($request->mat_ran_eta_ben) && $request->mat_ran_eta_ben != ""){
                if ((strlen($request->mat_ran_eta_ben) < 3) || (strlen($request->mat_ran_eta_ben) > config('constantes.cantidad_caracteres_TextArea_GCM'))){
                    $mensaje = "Información ingresada no cumple la cantidad de caracteres permitidos.Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                }


                $registrar->mat_ran_eta_ben = $request->mat_ran_eta_ben;

            }

            $respuesta = $registrar->save();

            if (!$respuesta){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);                
            }

            DB::commit();

            $mat_ran_eta_id = $registrar->mat_ran_eta_id;
            return response()->json(array('estado' => '1', 'mat_ran_eta_id' => $mat_ran_eta_id), 200);
         }catch(\Exception $e){
            DB::rollback();

            $mensaje = "Hubo un error al momento de cargar las respuestas del formulario. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);

        }
    }


    public function priorizarProblemaMatrizRangoEtario(Request $request){
        try{
            if (!isset($request->mat_ide_pro_nna_id) || $request->mat_ide_pro_nna_id == ""){
                $mensaje = "No se encuentra ID del Problema. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $mat_ran_eta_id = $request->mat_ran_eta_id;
            if (!isset($mat_ran_eta_id) || $mat_ran_eta_id == ""){
                $mre = new MatrizRangoEtario();
                $mre->pro_an_id = $request->pro_an_id;
                $mre->mat_tip_ran_eta_id = $request->mat_tip_ran_eta_id;
                $mre->usu_id = session()->all()["id_usuario"];

                $respuesta = $mre->save();
                if (!$respuesta){
                    DB::rollback();
                    $mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);                
                }

                $mat_ran_eta_id = $mre->mat_ran_eta_id;
            }

            $registrar = new MatrizRangoEtarioProblema();
            $registrar->mat_ran_eta_id = $mat_ran_eta_id;
            $registrar->mat_ide_pro_nna_id = $request->mat_ide_pro_nna_id;
            $registrar->usu_id = session()->all()["id_usuario"];

            $respuesta = $registrar->save();

            if (!$respuesta){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la información. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);                
            }

            DB::commit();

            $mensaje = "Problema Priorizado con éxito.";
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje, 'mat_ran_eta_id' => $mat_ran_eta_id), 200);
        }catch(\Exception $e){   
            DB::rollback();

            $mensaje = "Hubo un error al momento de priorizar el Problema seleccionado. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    /************************* MATRIZ FACTORES PROTECTORES ****************************/

    public function listarMatrizFactores(Request $request){

        $data   = new \stdClass();
        $pro_an_id = $request->pro_an_id;
        
        $data->data = array();
        $respuesta = MatrizFactores::where("pro_an_id", $pro_an_id)->get();
        $data->data = $respuesta;        

        echo json_encode($data); exit;
        
    }

    public function guardarMatrizFactores(Request $request){
        try{
            
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();           
            
            $mat_fac_id = $request->mat_fac_id;

            if($mat_fac_id == ""){
                $mat_fac = new MatrizFactores();
            }else{
                $mat_fac = MatrizFactores::find($mat_fac_id);
            }

            $mat_fac->mat_fac_pro = $request->mat_fac;
            $mat_fac->mat_fac_fam = $request->mat_fam;
            $mat_fac->mat_fac_esc = $request->mat_esc;
            $mat_fac->mat_fac_com = $request->mat_com;
            $mat_fac->mat_fac_ins = $request->mat_ins;
            $mat_fac->pro_an_id   = $request->pro_an_id;
            $mat_fac->usu_id      = session()->all()['id_usuario'];
            $mat_fac->mat_fac_otros   = $request->mat_otros;

            $respuesta = $mat_fac->save();

            if (!$respuesta){

                $mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción guardada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de guardar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function editarMatrizFactores(Request $request){

        try{
            
            $mat_fac = MatrizFactores::find($request->mat_fac_id);
                        
            
            $mat_fac = json_encode($mat_fac);  
           
            return response()->json(
                array(
                    'mat_fac' => $mat_fac,
                ), 200);
            

        }catch(\Exception $e){
                return response()->json($e->getMessage(), 400);
            
        }

    }

    public function eliminarMatrizFactores(Request $request){

        try{

            DB::beginTransaction();                        

            $mat_fac = MatrizFactores::find($request->mat_fac_id);
            $respuesta = $mat_fac->delete();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción eliminada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function descargarReporteMatrizFactores(Request $request){
        return \Excel::download(new descargarReporteMatrizFactoresExportable($request->id), "Matriz_Factores_Protectores_".date('d-m-Y').".xlsx");

    }

    public function descargarReporteMatrizIdentProb(Request $request){
        return \Excel::download(new descargarReporteMatrizIdentProbExportable($request->id), "Matriz_Identificacion_Problemas_".date('d-m-Y').".xlsx");

    }

    public function descargarReporteMatrizRangoEtario(Request $request){
        return \Excel::download(new descargarReporteMatrizRangoEtarioExportable($request->id), "Matriz_Identificacion_Problemas_".date('d-m-Y').".xlsx");

    }

    public function descargarReportePlanEstrategico(Request $request){
        return \Excel::download(new descargarReportePlanEstrategico($request->id), "Plan_estrategico_comunitario_".date('d-m-Y').".xlsx");
        
    }
    
    public function descargaReporteInfPlanEstrategico(Request $request){
        return \Excel::download(new descargarReporteInformePlanEstrategico($request->id), "Informe_Plan_estrategico_comunitario_".date('d-m-Y').".xlsx");
        
    }

    public function descargarInformePlanEstrategico(Request $request){
        //INICIO DC
        $datos = DB::select("select
        inf.info_resp,
        inf.info_com,
        com.com_pri_nom,
        to_char(inf.info_fec_pri, 'dd/mm/yyyy') as info_fec_pri,
        to_char(inf.info_fec_ter, 'dd/mm/yyyy') as info_fec_ter,
        inf.info_intro,
        inf.info_act_plan,
        inf.info_act_real
        from ai_gc_informe_pec inf
        inner join ai_comuna_priorizada com
        on com.com_pri_id = inf.com_pri_id
        where pro_an_id = ".$request->id);
        //FIN DC
        // INICIO CZ SPRINT 67
        $datosPE = DB::select("select
         mipn.mat_ide_pro_nna_id as idprob,
          pe_id as id,
          mipn.mat_ide_pro_nna_pro_iden as prob_priorizado,
          pe.pe_objetivo as objetivo,
          pe_resultado as resultado,
          pe_indicador as indicador,
          PE_RESULTADO2 as resultado2,
          PE_FACILITADORES as facilitadores,
          PE_OBSTACULIZADORES as obstaculizadores,
          PE_APRENDIZAJES as aprendizajes
          from ai_matriz_ide_pro_nna mipn
          left join AI_PLAN_ESTRATEGICO pe
          on mipn.mat_ide_pro_nna_id = pe.pe_mat_ide_pro_nna_id
          where mipn.pro_an_id = ".$request->id. " and  mipn.mat_ide_pro_nna_id IN (select AI_MATRIZ_IDE_PRO_NNA.mat_ide_pro_nna_id from AI_MATRIZ_IDE_PRO_NNA left join AI_MATRIZ_EJES_TEMATICOS met 
          on AI_MATRIZ_IDE_PRO_NNA.MAT_EJE_TEM_ID = MET.MAT_EJE_TEM_ID inner join 
        AI_MATRIZ_RANGO_ETARIO_PROB mrep2 on AI_MATRIZ_IDE_PRO_NNA.MAT_IDE_PRO_NNA_ID = MREP2.MAT_IDE_PRO_NNA_ID 
        where AI_MATRIZ_IDE_PRO_NNA.PRO_AN_ID = {$request->id})");
        // FIN CZ SPRINT 67
        $pdf = new \PDF();
        
        $pdf = \PDF::loadView('gestor_comunitario/gestion_comunitaria/plan_estrategico/informe_pec/informe_pec_pdf',[
            'id' => $request->id,
            'datos' => $datos,
            'ejecucion' => $datosPE
        ]);
        
        return $pdf->stream('Informe_PEC.pdf');
    }

    //INICIO DC
    public function finalizarPec(Request $request){
        $update = DB::update("update ai_proceso_anual set est_pro_id = 3 where pro_an_id = ".$request->pro_an_id);
        return $update;
    }
    public function descargarInformeDPC(Request $request){
        //Identificacion
        $datos = InformeDPC::where('pro_an_id',$request->id)->first();
        $com_pri = ComPriorizada::where("com_pri_id", $datos->com_pri_id)->first();
        //Introduccion
        $pro_an_id = $request->id;
        $data_DgIdentidadCom = DgIdentidadCom::where("pro_an_id", $pro_an_id)->get();
        $data_DgOrgComunal = DgOrgComunal::where("pro_an_id", $pro_an_id)->get();
        $data_DgInstServicios = DgInstServicios::where("pro_an_id", $pro_an_id)->get();
        $data_DgBienesComunes = DgBienesComunes::where("pro_an_id", $pro_an_id)->get();
        $primer = true;
        foreach($data_DgOrgComunal as $organizacion){
            if(!$primer){
                $data_DgIdentidadCom[0]->organizacion .= ' - '.$organizacion->dg_org_nom;;
            }else{
                $data_DgIdentidadCom[0]->organizacion = $organizacion->dg_org_nom;
            }
            $primer = false;
        }
        
        $primer = true;
        foreach($data_DgInstServicios as $instituciones){
            if(!$primer){
                $data_DgIdentidadCom[0]->instituciones .= ' - '.$instituciones->dg_ins_nom;;
            }else{
                $data_DgIdentidadCom[0]->instituciones = $instituciones->dg_ins_nom;
            }
            $primer = false;
        }
        
        $primer = true;
        foreach($data_DgBienesComunes as $bienes){
            if(!$primer){
                $data_DgIdentidadCom[0]->bienes .= ' - '.$bienes->dg_bn_nom;;
            }else{
                $data_DgIdentidadCom[0]->bienes = $bienes->dg_bn_nom;
            }
            $primer = false;
        }
       //grupo de accion        
        $respuesta = IntegrantesDPC::where('pro_an_id',$request->id)->get();
        //ejecucion
        $respEje = InformeEjecucion::where('pro_an_id',$request->id)->get();  
       
        $pdf = new \PDF();
        
        $pdf = \PDF::loadView('gestor_comunitario/gestion_comunitaria/diagnostico_participativo/informe_dpc/informe_dpc_pdf',[
            'id' => $request->id,
            'datos' => $datos,
            'com_pri' => $com_pri,
            'introduccion' => $data_DgIdentidadCom,
            'grupoAccion' => $respuesta,
            'ejecucion' => $respEje
        ]);
        
        return $pdf->stream('Informe_DPC.pdf');
    }
    //FIN DC

    /************************* MATRIZ FACTORES PROTECTORES ****************************/

    /************************* INFORME DIAGNOSTICO PARTICIPATIVO **********************/

    public function dataInformeDiagnostico(Request $request){

        try{

            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
                 
            $pro_an_id = $request->pro_an_id;
            
            $data = InformeDPC::where('pro_an_id',$pro_an_id)->first();
            $com_pri = ComPriorizada::select("com_pri_id","com_pri_nom")->get();
            //INICIO DC
            $iden_com = DgIdentidadCom::select("*")->leftJoin("ai_comuna_priorizada cp","cp.com_pri_id","=","ai_dg_ident_comunidad.com_pri_id")
            ->where("pro_an_id",$pro_an_id)->get();
            //$iden_com = DgIdentidadCom::where("pro_an_id",$pro_an_id)->first();
            
            return response()->json(array('estado' => '1', 'data' => $data, 'com_pri' => $com_pri, 'iden_com' => $iden_com), 200);
            //FIN DC
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function listarIntegrantesDPC(Request $request){

        try{
                 
            $pro_an_id = $request->pro_an_id;
            
            $respuesta = IntegrantesDPC::where('pro_an_id',$pro_an_id)->get();

            $data   = new \stdClass();  
            $data->data = $respuesta;        

            echo json_encode($data); exit;
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener  la acción solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function resgristrarInformeDPC(Request $request){
        try{

            DB::beginTransaction();
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $pro_an_id = $request->pro_an_id;
            $info_diag = InformeDPC::where("pro_an_id",$pro_an_id)->first();

            if(count($info_diag) == 0){
                $info_diag = new InformeDPC();
            }else{
                $info_diag = InformeDPC::find($info_diag->info_id);
            }
            
            if($request->info_fec_pri == ""){
                $info_fec_pri = $request->info_fec_pri;
            }else{                
                $info_fec_pri = Carbon::createFromFormat('d/m/Y',$request->info_fec_pri);
            }

            if($request->info_fec_ter == ""){
                $info_fec_ter = $request->info_fec_ter;
            }else{                
                $info_fec_ter = Carbon::createFromFormat('d/m/Y',$request->info_fec_ter);
            }
            
            $info_diag->info_resp        = $request->info_resp;
            $info_diag->info_com         = $request->info_com;
            $info_diag->com_pri_id       = $request->com_pri_id;
            $info_diag->info_fec_pri     = $info_fec_pri;
            $info_diag->info_fec_ter     = $info_fec_ter;
            $info_diag->info_intro       = $request->info_intro;
            $info_diag->info_vin_oln     = $request->info_vin_oln;
            $info_diag->info_act_clav    = $request->info_act_clav;
            $info_diag->info_org_fun     = $request->info_org_fun;
            $info_diag->info_int_ong     = $request->info_int_ong;
            $info_diag->info_par_nna     = $request->info_par_nna;
            $info_diag->info_bie_com     = $request->info_bie_com;
            $info_diag->info_gru_acc     = $request->info_gru_acc;
            $info_diag->info_plan_act    = $request->info_plan_act;
            $info_diag->info_act_plan    = $request->info_act_plan;
            $info_diag->info_act_real    = $request->info_act_real;
            $info_diag->info_dest        = $request->info_dest;
            $info_diag->info_med_dif     = $request->info_med_dif;
            $info_diag->info_met         = $request->info_met;
            $info_diag->info_can_par     = $request->info_can_par;
            $info_diag->info_fac         = $request->info_fac;
            $info_diag->info_obst        = $request->info_obst;
            $info_diag->info_res         = $request->info_res;
            $info_diag->info_con_res     = $request->info_con_res;
            $info_diag->pro_an_id        = $request->pro_an_id;
            $info_diag->usu_id           = session()->all()["id_usuario"];
            $respuesta = $info_diag->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', 'iden_com' =>$info_diag, "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function resgistrarIntegrantesInforme(Request $request){
        try{

            DB::beginTransaction();
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $pro_an_id = $request->pro_an_id;
            
            if($request->int_id == ""){
                $info_int = new IntegrantesDPC();
            }else{
                $info_int = IntegrantesDPC::find($request->int_id);
            }
            
            $info_int->int_info_nom     = $request->grupo_nom;
            $info_int->int_info_rut     = $request->grupo_rut;
            $info_int->int_info_tel     = $request->grupo_tele;
            $info_int->int_info_cor     = $request->grupo_cor;
            $info_int->int_info_rol     = $request->grupo_rol;
            $info_int->pro_an_id        = $request->pro_an_id;
            $respuesta = $info_int->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function editarIntegrantesDPC(Request $request){

        try{

            if (!isset($request->int_id) || $request->int_id == ""){
                $mensaje = "No se encuentra ID del Integrantes. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
                 
            $int_id = $request->int_id;
            
            $data = IntegrantesDPC::find($int_id);
                      
            return response()->json(array('estado' => '1', 'data' => $data), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function eliminarIntegrantesInforme(Request $request){

        try{

            DB::beginTransaction();

            if (!isset($request->int_id) || $request->int_id == ""){
                $mensaje = "No se encuentra ID del Integrantes. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $info_int = IntegrantesDPC::find($request->int_id);
            $respuesta = $info_int->delete();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }

    }

    public function listarInformeAnexos(Request $request){

        try{
                 
            $pro_an_id = $request->pro_an_id;
            
            $respuesta = AnexoDPC::where('pro_an_id',$pro_an_id)->get();
           //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            foreach($respuesta as $key=> $documento){

                $ruta = "../../".$destinationPath."/".$documento->anex_nom;
                $ruta_file = $destinationPath."/".$documento->anex_nom;
                if (!is_file($ruta_file)) {
                    $ruta = "../../doc/".$documento->anex_nom;
                }
                $respuesta[$key]->ruta = $ruta;
            }
            //CZ SPRINT 73
            $data   = new \stdClass();  
            $data->data = $respuesta;        

            echo json_encode($data); exit;
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            //FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function cargarInformeAnexos(Request $request){
        $request->validate($this->reglas_doc,[]);
        
		try {

            //VALIDACION DE EXTENSIÓN DE ARCHIVO
			$validacion_extension = Validator::make($request->all(), ['doc_anexoDiag' => 'file|mimes:doc,docx,pdf']);
			if ($validacion_extension->fails()){
				$mensaje = "Extensión de archivo no permitida. Por favor subir un documento con las siguientes extensiones: doc, docx o pdf.";

	           return response()->json(array('estado' => '2', 'mensaje' => $mensaje), 200);
	        }

	        //VALIDACION DE TAMAÑO DE ARCHIVO
	 		$validacion_size = Validator::make($request->all(), ['doc_anexoDiag' => 'file|max:5120']);
	 		if ($validacion_size->fails()){
				$mensaje = "Error al subir documento, tamaño máximo permitido 5 MB. Por favor verificar e intentar nuevamente.";

	           return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
	        }
            
			DB::beginTransaction();
            $pro_an_id=$request->pro_an_id;
            $files = $request->file('doc_anexoDiag');    
            $extension = $files->getClientOriginalExtension();

            $doc = AnexoDPC::where("pro_an_id",$pro_an_id)->get();
            //CZ SPRINT 73
            $getcorrelativo = count($doc)+1;
            $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            $date = date('Y', strtotime($proceso->pro_an_fec));
            $filename = $comuna->abrev. '_GC_'.$date.'_'.$pro_an_id.'_Info_AneDiaPar_'.$getcorrelativo.".".$extension;
            //CZ SPRINT 73
            $upload_success = $files->move($destinationPath, $filename);
            
            $doc = new AnexoDPC();
            
            $doc->anex_nom   = $filename;
            $doc->pro_an_id = $request->pro_an_id;
            $respuesta = $doc->save();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

			DB::commit();
			return response()->json(array('estado' => '1', 'mensaje' => 'Archivo guardado exitosamente.'),200);
		
		} catch(\Exception $e) {
            
			DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al momento de subir el documento. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function listarInformeCaracGenerales(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            } 
            $pro_an_id = $request->pro_an_id;
            $data_DgIdentidadCom = DgIdentidadCom::where("pro_an_id", $pro_an_id)->get();
            $data_DgOrgComunal = DgOrgComunal::where("pro_an_id", $pro_an_id)->get();
            $data_DgInstServicios = DgInstServicios::where("pro_an_id", $pro_an_id)->get();
            $data_DgBienesComunes = DgBienesComunes::where("pro_an_id", $pro_an_id)->get();
            
            //$respuesta = InformeCaractGenerales::where('pro_an_id',$pro_an_id)->get();
                        
            $primer = true;
            foreach($data_DgOrgComunal as $organizacion){
                if(!$primer){
                    $data_DgIdentidadCom[0]->organizacion .= ' - '.$organizacion->dg_org_nom;;
                }else{
                    $data_DgIdentidadCom[0]->organizacion = $organizacion->dg_org_nom;
                } 
                $primer = false;
            }

            $primer = true;
            foreach($data_DgInstServicios as $instituciones){
                if(!$primer){
                    $data_DgIdentidadCom[0]->instituciones .= ' - '.$instituciones->dg_ins_nom;;
                }else{
                    $data_DgIdentidadCom[0]->instituciones = $instituciones->dg_ins_nom;
                } 
                $primer = false;
            }

            $primer = true;
            foreach($data_DgBienesComunes as $bienes){
                if(!$primer){
                    $data_DgIdentidadCom[0]->bienes .= ' - '.$bienes->dg_bn_nom;;
                }else{
                    $data_DgIdentidadCom[0]->bienes = $bienes->dg_bn_nom;
                } 
                $primer = false;
            }
            
            $data   = new \stdClass();              
            $data->data = $data_DgIdentidadCom; 
            
            echo json_encode($data); exit;
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function registrarInformeCaractGenerales(Request $request){
        try{

            DB::beginTransaction();
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $pro_an_id = $request->pro_an_id;
            
            if($request->car_gen_id == ""){
                $carac_gen = new InformeCaractGenerales();
            }else{
                $carac_gen = InformeCaractGenerales::find($request->car_gen_id);
            }
            
            $carac_gen->car_gen_act     = $request->actores;
            $carac_gen->car_gen_org     = $request->organizaciones;
            $carac_gen->car_gen_int     = $request->instituciones;
            $carac_gen->car_gen_par     = $request->participacion;
            $carac_gen->car_gen_bie     = $request->bienes;
            $carac_gen->pro_an_id        = $request->pro_an_id;
            $respuesta = $carac_gen->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function editarInformeCaractGenerales(Request $request){

        try{

            if (!isset($request->car_gen_id) || $request->car_gen_id == ""){
                $mensaje = "No se encuentra ID del Integrantes. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
                 
            $car_gen_id = $request->car_gen_id;
            
            $data = InformeCaractGenerales::find($car_gen_id);
                      
            return response()->json(array('estado' => '1', 'data' => $data), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66 
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function eliminarInformeCaractGenerales(Request $request){

        try{

            DB::beginTransaction();

            if (!isset($request->car_gen_id) || $request->car_gen_id == ""){
                $mensaje = "No se encuentra ID de la característica. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $car_gen = InformeCaractGenerales::find($request->car_gen_id);
            $respuesta = $car_gen->delete();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }

    }

    public function listarInformeEjecucion(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            } 
            $pro_an_id = $request->pro_an_id;
            $respuesta = InformeEjecucion::where('pro_an_id',$pro_an_id)->get();            
            
            $data   = new \stdClass();              
            $data->data = $respuesta; 
            
            echo json_encode($data); exit;
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function registrarInformeEjecucion(Request $request){
        try{

            DB::beginTransaction();
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra ID del Proceso. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $pro_an_id = $request->pro_an_id;
            
            if($request->eje_id == ""){
                $info_eje = new InformeEjecucion();
            }else{
                $info_eje = InformeEjecucion::find($request->eje_id);
            }
            
            $info_eje->eje_act_plan     = $request->eje_plan;
            $info_eje->eje_act_real     = $request->eje_real;
            $info_eje->eje_dest         = $request->eje_dest;
            $info_eje->eje_med_dif      = $request->eje_mdif;
            $info_eje->eje_met          = $request->eje_meto;
            $info_eje->eje_can_par      = $request->eje_cant;
            $info_eje->eje_fac          = $request->eje_faci;
            $info_eje->eje_obst         = $request->eje_obst;
            $info_eje->pro_an_id        = $request->pro_an_id;
            $respuesta = $info_eje->save();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información registrada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback();
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al registra la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function editarInformeEjecucion(Request $request){

        try{

            if (!isset($request->eje_id) || $request->eje_id == ""){
                $mensaje = "No se encuentra ID del Integrantes. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
                 
            $eje_id = $request->eje_id;
            
            $data = InformeEjecucion::find($eje_id);
                      
            return response()->json(array('estado' => '1', 'data' => $data), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }

    }

    public function eliminarInformeEjecucion(Request $request){

        try{

            DB::beginTransaction();

            if (!isset($request->eje_id) || $request->eje_id == ""){
                $mensaje = "No se encuentra ID de la característica. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $eje_dpc = InformeEjecucion::find($request->eje_id);
            $respuesta = $eje_dpc->delete();
            
            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            
            $mensaje = "Información eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			// FIN CZ SPRINT 66
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    // INICIO CZ SPRINT 67
    public function eliminarDocumento(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->id) || $request->id == ""){
                $mensaje = "No se encuentra ID del documento. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->id_pro_an_id) || $request->id_pro_an_id == ""){
                $mensaje = "No se encuentra ID del proceso anual . Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->tipo_gest) || $request->tipo_gest == ""){
                $mensaje = "No se encuentra ID del tipo de gestion. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $DocumentoGcomunitaria = DocumentoGcomunitaria::find($request->id);
            $respuesta = $DocumentoGcomunitaria->delete();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();

            $proceso = ProcesoAnual::where('pro_an_id',$request->id_pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();    
            $destinationPath = 'doc/'.$comuna->com_nom;
            $ruta = $destinationPath."/".$DocumentoGcomunitaria->doc_nom;
            $ruta_file = $destinationPath."/".$DocumentoGcomunitaria->doc_nom;
            if (!is_file($ruta_file)) {
                $ruta = "doc/".$DocumentoGcomunitaria->doc_nom;
            }
            File::delete($ruta);
            $mensaje = "Documento eliminado con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    public function eliminarAnexo(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->id) || $request->id == ""){
                $mensaje = "No se encuentra ID del documento. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->id_pro_an_id) || $request->id_pro_an_id == ""){
                $mensaje = "No se encuentra ID del proceso anual . Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $AnexoDPC = AnexoDPC::find($request->id);
            $respuesta = $AnexoDPC->delete();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$request->id_pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            $ruta = "../../".$destinationPath."/".$AnexoDPC->doc_nom;
            $ruta_file = $destinationPath."/".$AnexoDPC->doc_nom;
            if (!is_file($ruta_file)) {
                $ruta = "../../doc/".$AnexoDPC->doc_nom;
            }
            //CZ SPRINT 73
            File::delete($destinationPath.'/'.$AnexoDPC->doc_nom);
            $mensaje = "Documento eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    public function eliminarBitacora(Request $request){

        try{

            DB::beginTransaction();

            if (!isset($request->bit_id) || $request->bit_id == ""){
                $mensaje = "No se encuentra ID de la bitacora a eliminar. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $sqlDireccionBit = DB::select('select * from "AI_DIRECCION_BIT" where "AI_DIRECCION_BIT"."ACT_ID" in
            (select act_id from "AI_USUARIO_ACTIVIDAD" where "AI_USUARIO_ACTIVIDAD"."BIT_ID" 
            in (select BIT_ID from "AI_BITACORA" where "AI_BITACORA"."BIT_ID" ='.$request->bit_id.'))');

            $UsuarioActividad = DB::select('select *  from AI_USUARIO_ACTIVIDAD where bit_id ='.$request->bit_id);
            
            $sql = DB::select('select *  from ai_actividad where act_id  in (select act_id  from AI_USUARIO_ACTIVIDAD where bit_id ='.$request->bit_id.')');
            
            $sqlusuBit = DB::select('select * from ai_usuario_bitacora  where BIT_ID ='.$request->bit_id);
            
            if(count($sqlDireccionBit) > 0){
                foreach($sqlDireccionBit as $sqlBit){
                    $DireccionBit = DireccionBit::find($sqlBit->dir_bit_id); 
                    $respuesta = $DireccionBit->delete();
                }
                if (!$respuesta){
                    DB::rollback();
                        $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                }
            }

           
           if(count($UsuarioActividad)> 0){
                foreach($UsuarioActividad as $sqlusuAct){
                    $UsuarioActivi = UsuarioActividad::find($sqlusuAct->usu_act_id);
                    $respuestausuAct = $UsuarioActivi->delete();
                }
                if (!$respuestausuAct){
                    DB::rollback();
                        $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                }
           }
           

            if(count($sql)> 0){
                foreach($sql as $actividad ){
                    $Actividad = Actividad::find($actividad->act_id);
                    $respuestaAct = $Actividad->delete();    
                }

                if (!$respuestaAct){
                    DB::rollback();
                        $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                }
            }


           
            if(count($sqlusuBit)> 0){
                foreach($sqlusuBit as $usuario_bitacora ){
                    $usuBit = UsuarioBitacora::find($usuario_bitacora->usu_bit_id);
                    $respuestausubit = $usuBit->delete();    
                }

                if (!$respuestausubit){
                    DB::rollback();
                        $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                                
                    return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
                }
    
            }
            
          
            $bitacoraComunal = BitacoraComunal::find($request->bit_id);
            $respuestaBitacora = $bitacoraComunal->delete();

            if (!$respuestaBitacora){
                DB::rollback();
                    $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }
            DB::commit();
            $mensaje = "Información eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }        
    }
    public function eliminarActividad(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->act_id) || $request->act_id == ""){
                $mensaje = "No se encuentra ID de la actividad a eliminar. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $sql = DB::select('select * from AI_DIRECCION_BIT where ACT_ID ='. $request->act_id);
            foreach($sql as $DireccionBit){
                $DireccionBit = DireccionBit::find($DireccionBit->dir_bit_id); 
                $respuesta = $DireccionBit->delete();
            }

            if (!$respuesta){
                DB::rollback();
                    $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            $sqlusuAct  = DB::select('select * from AI_USUARIO_ACTIVIDAD where "ACT_ID" = '. $request->act_id);  
            
            $UsuarioActividad = UsuarioActividad::find($sqlusuAct[0]->usu_act_id);
            $respuestausuAct = $UsuarioActividad->delete();

            if (!$respuestausuAct){
                DB::rollback();
                    $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }


            $Actividad = Actividad::find($request->act_id);
            $respuestaAct = $Actividad->delete();


            if (!$respuestaAct){
                DB::rollback();
                    $mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
                            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }



            DB::commit();
            $mensaje = "Información eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    public function realizadopec(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->id) || $request->id == ""){
                $mensaje = "No se encuentra ID realizar priorizacion. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }



            $sql=DB::update('update AI_PLAN_ESTRATEGICO set check_realizado = 1 where pe_id ='. $request->id);
            		
            if (!$sql) {
                DB::rollback();
                $mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
                    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }
            DB::commit();
            $mensaje = "Realizado con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de priozar la información. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
    public function norealizadopec(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->id) || $request->id == ""){
                $mensaje = "No se encuentra ID realizar priorizacion. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }



            $sql=DB::update('update AI_PLAN_ESTRATEGICO set check_realizado = 0 where pe_id ='. $request->id);
            		
            if (!$sql) {
                DB::rollback();
                $mensaje = "Error al momento de guardar el registro. Por favor intente nuevamente.";
                    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }
            DB::commit();
            $mensaje = "No realizado con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al momento de priozar la información. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }

    public function editarDatosBitacora(Request $request){
        try{
            $pro_an_id      = $request->pro_an_id;
            $fecha_ingreso  = $request->fecha_ingreso;
            $nombre         = $request->nombre_bitacora;
            $tipo           = $request->tipo;
            $est_pro_id     = $request->est_pro_id;

            $pro_an_id = $request->pro_an_id;
            if (!isset($pro_an_id) || $pro_an_id == ""){
               $mensaje = "No se encuentra ID del proceso. Por favor verifique e intente nuevamente.";


                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $bit_id = $request->bit_id;
            if (!isset($bit_id) || $bit_id == ""){
               $mensaje = "No se encuentra ID de la Bitácora. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $bit = BitacoraComunal::find($bit_id);
            
            $bit->bit_fec_cre   = Carbon::createFromFormat('d/m/Y', $fecha_ingreso);
            $bit->bit_tit       = $nombre;
            $resultado = $bit->save();
            
            if(!$resultado){
                DB::rollback();
                $mensaje = "Hubo un error al momento de registrar la Bitácora. Por favor intente nuevamente o contacte con el Administrador.";
            
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
            $respuesta = 'Se ha realizado cambio de datos con exito!';
            return response()->json(array('estado' => '1', 'respuesta' => $respuesta), 200);
    	}catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }
    // FIN CZ SPRINT 67
    // INICIO CZ SPRINT 70
    public function listarLineaBase_2021(Request $request){
        
        $data   = new \stdClass();

        $pro_an_id = $request->pro_an_id;
        
        $data->data = array();
        $respuesta = LineaBaseIdentificacion::where("IDEN_PRO_AN_ID", $pro_an_id)->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            foreach($respuesta as $v){
                $v->iden_run = rut::parse($v->iden_run.$v->iden_dv)->format();
            }
        }

        echo json_encode($data); exit;
    }
    public function listarPreguntasServicios_2021(Request $request){
        $data   = new \stdClass();
        $numero = 0;
            $tipo = $request->pre_tip;
            
            $data->data = array();
            $respuesta = PreguntasLB::where("lb_pre_tip", $tipo)->where("lb_pre_act", 1)->where("flag_tipo_linea_base",2)->orderBy('lb_pre_ord', 'ASC')->get();
            if($tipo == 0){
                $respuesta = PreguntasLB::where("lb_pre_tip", 3)->where("lb_pre_act", 1)->where("flag_tipo_linea_base",2)->orderBy('lb_pre_ord', 'ASC')->get();
            }
           
            if (count($respuesta) > 0){
                $data->data = $respuesta;
    
                if($request->accion == 1){
                    foreach ($data->data AS $i => $v){
                        if($tipo == 2){
                            $numero = $i+1;
                            $v->lb_pre_nom = "<label><b>2.2.".$numero.".</b> ".$v->lb_pre_nom."</label>";
                            $consulta = LineaBaseProgramasSocialesPrestaciones::where("sp_id_programas",$v->lb_pre_id)->where("PRO_AN_ID", $request->pro_an_id)->where("SP_TIPO","=",$request->tipo_linea)->where("SP_IDENT_ID", $request->lin_bas_id)->first();
                            if (count($consulta) > 0){
                                $v["resp1"] = $consulta->sp_preg1;
                                $v["resp2"] = $consulta->sp_preg2;
                                $v["resp3"] = $consulta->sp_preg3;
                                $v['sp_mesyear'] = $consulta->sp_mesyear;
                            }
                        }else if($tipo == 0){
                            $numero = $i+1;
                            $v->lb_pre_nom = "<label><b>3.1.".$numero.".</b> ".$v->lb_pre_nom."</label>";

                            $consulta = LineaBaseBienesComunitarios::where("ORG_ID_BIENES",$v->lb_pre_id)->where("PRO_AN_ID", $request->pro_an_id)->where("ORG_BC_TIPO","=",$request->tipo_linea)->where("ORG_BC_IDENT_ID", $request->lin_bas_id)->first();
                            if (count($consulta) > 0){
                                $v["resp1"] = $consulta->org_bc_preg1;
                                $v["resp2"] = $consulta->org_bc_preg2;
                                $v["resp3"] = $consulta->org_bc_preg3;
                                $v["resp4"] = $consulta->org_bc_preg4;
                                $v['sp_mesyear'] = $consulta->org_bc_mesyear;
                            }
                           
                        }else if($tipo == 1){
                            $numero = $i+1;
                            $v->lb_pre_nom = "<label><b>2.1.".$numero.".</b> ".$v->lb_pre_nom."</label>";
                            $consulta = LineaBaseServiciosComunales::where("sc_id_servicio",$v->lb_pre_id)->where("PRO_AN_ID", $request->pro_an_id)->where("SC_TIPO","=",$request->tipo_linea)->where("SC_IDENT_ID", $request->lin_bas_id)->first();
                        
                            if (count($consulta) > 0){
                                $v["resp1"] = $consulta->sc_preg1;
                                $v["resp2"] = $consulta->sc_preg2;
                                $v["resp3"] = $consulta->sc_preg3;
                                $v['sp_mesyear'] = $consulta->sc_mesyear;
                            }
                        }else if($tipo == 4){
                            $numero = $i+1;
                            $v->lb_pre_nom = "<label><b>3.2.".$numero.".</b> ".$v->lb_pre_nom."</label>";
                            $consulta = LineaBaseOrganizacionesComunitarias::where("org_id_org",$v->lb_pre_id)->where("PRO_AN_ID", $request->pro_an_id)->where("ORG_TIPO","=",$request->tipo_linea)->where("ORG_IDENT_ID", $request->lin_bas_id)->first();
                        
                            if (count($consulta) > 0){
                                $v["resp1"] = $consulta->org_preg1;
                                $v["resp2"] = $consulta->org_preg2;
                                $v["resp3"] = $consulta->org_preg3;
                                $v["resp4"] = $consulta->org_preg4;
                                $v["resp5"] = $consulta->org_preg5;
                                $v["org_mesyear"] = $consulta->org_mesyear;
                            }
                        }
                    }
                }else{
                    
                    foreach ($data->data AS $i => $v){
                        if($tipo == 2){
                            $v->lb_pre_nom = "<label><b>2.2.".$v->lb_pre_ord.".</b> ".$v->lb_pre_nom."</label>";
                        }else if($tipo == 0){
                            $v->lb_pre_nom = "<label><b>3.1.".$v->lb_pre_ord.".</b> ".$v->lb_pre_nom."</label>";
                        }else if($tipo == 1){
                            $v->lb_pre_nom = "<label><b>2.1.".$v->lb_pre_ord.".</b> ".$v->lb_pre_nom."</label>";
                        }else if($tipo == 4){
                            $v->lb_pre_nom = "<label><b>3.2.".$v->lb_pre_ord.".</b> ".$v->lb_pre_nom."</label>";
                        }
                    }
                }
            }
            echo json_encode($data); exit; 
            die();
    }
    public function listarPreguntasParticipacion_2021(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        $respuesta = DerechoParticipacion::where("lb_par_act", 1)->where("flag_tipo_linea_base",2)->orderBy('lb_par_ord', 'ASC')->get();

        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                     $consulta = LineaBaseDerechoNinos::where("PRO_AN_ID", $request->pro_an_id)->where("DER_ID_LINEA_BASE", $request->tipo_linea)->where("DER_IDENT_ID", $request->lin_bas_id)->first();
                     $n = $i+1;
                     $numero = $i+1;
                     $v->lb_par_nom = "<label><b>4.".$numero.".</b> ".$v->lb_par_nom."</label>";
                    if (count($consulta) > 0){
                        if($v->lb_par_id == 8){
                            $v["resp"] = $consulta->der_preg1;
                        }else if($v->lb_par_id == 9){
                            $v["resp"] = $consulta->der_preg2;
                            
                        }else if($v->lb_par_id == 10){
                            $v["resp"] = $consulta->der_preg3;
                            
                        }else if($v->lb_par_id == 11){
                            $v["resp"] = $consulta->der_preg4;
                        }else if($v->lb_par_id == 12){
                            $v["resp"] = $consulta->der_preg5;
                            
                        }else if($v->lb_par_id == 13){
                            $v["resp"] = $consulta->der_preg6;

                        }else if($v->lb_par_id == 14){
                            $v["resp"] = $consulta->der_preg7;
                        }
                        
                    }
                }
            }else{
                foreach ($data->data AS $i => $v){
                    $numero = $i+1;
                    $v->lb_par_nom = "<label><b>4.".$numero.".</b> ".$v->lb_par_nom."</label>";
               }
            }
        }
        echo json_encode($data); exit;
    }

    public function listarPreguntasContinuidadProyecto_2021(Request $request){
        $data   = new \stdClass();
        
        $data->data = array();
        $respuesta = ContinuidadProyecto::where("lb_cont_act", 1)->orderBy('lb_cont_ord', 'ASC')->get();
        if (count($respuesta) > 0){
            $data->data = $respuesta;

            if($request->accion == 1){
                foreach ($data->data AS $i => $v){
                    $consulta = LineaBaseContinuidadProyecto::where("PRO_AN_ID", $request->pro_an_id)->where("CONT_ID_LINEA_BASE", $request->tipo_linea)->where("CONT_IDENT_ID",$request->lin_bas_id)->first();
                    $n = $i+1;
                    $numero = $i+1;
                    $v->lb_cont_nom = "<label><b>5.".$numero.".</b> ".$v->lb_cont_nom."</label>";
                    if (count($consulta) > 0){
                        
                        if($v->lb_cont_id == 1){
                            $v["resp"] = $consulta->cont_preg1;
                        }else if($v->lb_cont_id == 2){
                            $v["resp"] = $consulta->cont_preg2;
                            
                        }else if($v->lb_cont_id == 3){
                            $v["resp"] = $consulta->cont_preg3;
                            
                        }else if($v->lb_cont_id == 4){
                            $v["resp"] = $consulta->cont_preg4;
                        }else if($v->lb_cont_id == 5){
                            $v["resp"] = $consulta->cont_preg5;
                            
                        }else if($v->lb_cont_id == 6){
                            $v["resp"] = $consulta->cont_preg6;
                        }else if($v->lb_cont_id == 7){
                            $v["resp"] = $consulta->cont_preg7;
                        }
                        
                    }
                }
            }else{
                foreach ($data->data AS $i => $v){
                    $numero = $i+1;
                    $v->lb_cont_nom = "<label><b>5.".$numero.".</b> ".$v->lb_cont_nom."</label>";
                }
            }
            
        }

        echo json_encode($data); exit;
    }
    public function editarLineaIdent_2021(Request $request){

        try{
            
            $iden_lb = LineaBaseIdentificacion::find($request->id);
                        
            $iden_lb->lin_bas_rut = Rut::parse($iden_lb->iden_run.$iden_lb->iden_dv)->format();
            $iden_lb = json_encode($iden_lb);  
           
            return response()->json(
                array(
                    'iden_lb' => $iden_lb,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }

    }
    public function getOtro_2021(Request $request){
        try{
            
           
            $lineabase = LineaBaseOtro::where('otro_iden_id', $request->id)->where('id_otro_linea_base', "=",$request->tipo_line_base)->where("PRO_AN_ID", $request->pro_an_id)->get();

            return response()->json(
                array(
                    'otro' => $lineabase,
                ), 200);
            

        }catch(\Exception $e){
    			return response()->json($e->getMessage(), 400);
    		
        }
    }
    public function guardarLineaBase_2021(Request $request){
        try{
            if (!isset($request->pro_an_id) || $request->pro_an_id == ""){
                $mensaje = "No se encuentra el ID del proceso. Por favor intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            DB::beginTransaction();
            $identidad = LineaBaseIdentificacion::where('iden_pro_an_id', $request->pro_an_id)->where("iden_run",$request->iden["iden_run"])->first();

            $identidad = $this->guardarIdentidadComunidad($identidad,$request->pro_an_id,$request->iden);
            $this->guardarRespuestas_2021($request->preg,$request->pro_an_id, $identidad->iden_id,$request->tipo_line_base);
            $this->guardarDerechoNNA($identidad, $request->part,$request->pro_an_id,$request->tipo_line_base);
            $this->guardarContinuidadProyecto($identidad, $request->cont,$request->pro_an_id,$request->tipo_line_base);
            $this->guardarRespuestaOtro($identidad, $request->otros,$request->pro_an_id,$request->tipo_line_base);
            DB::commit();
            $mensaje = "Acción registrada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INCIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
            // FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }
    public function guardarIdentidadComunidad($identidad,$pro_an_id, $data){
        if($identidad != null){
            $iden_id = $identidad->iden_id;
        }else{
            $iden_id ="";
        }
        if($iden_id == ""){
            $lineabase = new LineaBaseIdentificacion();
            $lineabase->iden_id =  LineaBaseIdentificacion::max('iden_id')+1;
        }else{
            $lineabase = LineaBaseIdentificacion::find($iden_id);
        }
        $lineabase->iden_pro_an_id = $pro_an_id;
        $lineabase->iden_usuario = session()->all()["id_usuario"];
        $lineabase->iden_nombre = $data["iden_nombre"];
        $lineabase->iden_run = $data["iden_run"];
        $lineabase->iden_dv =  $data["iden_dv"];
        $lineabase->iden_comuna = $data["iden_comuna"];
        $lineabase->iden_calle = $data["iden_calle"];
        $lineabase->iden_sexo = $data["iden_sexo"];
        $lineabase->iden_numero = $data["iden_numero"];
        $lineabase->iden_block = $data["iden_block"];
        $lineabase->iden_departamento = $data["iden_departamento"];
        $lineabase->iden_fono = $data["iden_fono"];
        $lineabase->iden_correo = $data["iden_correo"];
        $lineabase->iden_edad = $data["iden_edad"];
        $lineabase->iden_internet = $data["iden_internet"];
        $lineabase->iden_electronicos = $data["iden_electronicos"];
        $lineabase->iden_hogar_nna = $data["iden_hogar_nna"];
        // CZ SPRINT 76
        if($data["iden_hogar_nna"]==1){
            $lineabase->iden_cant_rang_1 = $data["rango_edad_0_3_linea_base"];
            $lineabase->iden_cant_rang_2 = $data["rango_edad_4_5_linea_base"];
            $lineabase->iden_cant_rang_3 = $data["rango_edad_6_13_linea_base"];
            $lineabase->iden_cant_rang_4 = $data["rango_edad_14_17_linea_base"];
        }else{
            $lineabase->iden_cant_rang_1 = 0;
            $lineabase->iden_cant_rang_2 = 0;
            $lineabase->iden_cant_rang_3 = 0;
            $lineabase->iden_cant_rang_4 = 0;
        }
        // CZ SPRINT 76
        $respuesta = $lineabase->save();
        if (!$respuesta){
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
        }else{
            return $lineabase;
        }
    }
    public function guardarDerechoNNA($identidad, $part, $pro_an_id,$tipo_linea){
        
        if($identidad != null){
            $iden_id = $identidad->iden_id;
        }else{
            $iden_id ="";
        }
        
        if($iden_id == ""){
            $DerechoNNA = new LineaBaseDerechoNinos();
            $max= LineaBaseDerechoNinos::max('der_id');
            $DerechoNNA->der_id = $max+1;
        }else{   
            $DerechoNNA = LineaBaseDerechoNinos::where("pro_an_id",$pro_an_id)->where("der_ident_id", $iden_id)->where("DER_ID_LINEA_BASE", $tipo_linea)->first();
            if(count($DerechoNNA ) == 0){
                $DerechoNNA = new LineaBaseDerechoNinos();
                $max= LineaBaseDerechoNinos::max('der_id');
                $DerechoNNA->der_id = $max+1;
            }
        }

        $DerechoNNA->der_preg1 = $part["lin_bas_res1"];
        $DerechoNNA->der_preg2 = $part["lin_bas_res2"];
        $DerechoNNA->der_preg3 = $part["lin_bas_res3"];
        $DerechoNNA->der_preg4 = $part["lin_bas_res4"];
        $DerechoNNA->der_preg5 = $part["lin_bas_res5"];
        // CZ SPRINT 77
        $DerechoNNA->der_preg6 = 0;
        $DerechoNNA->der_preg7 = $part['lin_bas_res7'];
        $DerechoNNA->der_usuario = session()->all()["id_usuario"];
        $DerechoNNA->pro_an_id = $pro_an_id;
        $DerechoNNA->der_id_linea_base = $tipo_linea;
        $DerechoNNA->der_ident_id = $iden_id;
        $respuesta = $DerechoNNA->save();
        if (!$respuesta){
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
        }
       

    }

    public function guardarContinuidadProyecto($identidad, $cont, $pro_an_id,$tipo_linea){
        if($identidad != null){
            $iden_id = $identidad->iden_id;
        }else{
            $iden_id ="";
        }
        if($iden_id == ""){
            $continuidadProyecto = new LineaBaseContinuidadProyecto();
            $max= LineaBaseContinuidadProyecto::max('cont_id');
            $continuidadProyecto->cont_id = $max+1;
        }else{
            $continuidadProyecto = LineaBaseContinuidadProyecto::where("pro_an_id",$pro_an_id)->where("cont_ident_id","=", $iden_id)->where("cont_id_linea_base","=",$tipo_linea)->first();

            if(count($continuidadProyecto ) == 0){
                $continuidadProyecto = new LineaBaseContinuidadProyecto();
                $max= LineaBaseContinuidadProyecto::max('cont_id');
                $continuidadProyecto->cont_id = $max+1;
            }
        }
    
        $continuidadProyecto->cont_preg1 = $cont["lb_cont_res1"];
        $continuidadProyecto->cont_preg2 = $cont["lb_cont_res2"];
        $continuidadProyecto->cont_preg3 = $cont["lb_cont_res3"];
        $continuidadProyecto->cont_preg4 = $cont["lb_cont_res4"];
        $continuidadProyecto->cont_preg5 = $cont["lb_cont_res5"];
        $continuidadProyecto->cont_preg6 = $cont["lb_cont_res6"];
        $continuidadProyecto->cont_preg7 = $cont["lb_cont_res7"];
        $continuidadProyecto->cont_usuario = session()->all()["id_usuario"];
        $continuidadProyecto->pro_an_id = $pro_an_id;
        $continuidadProyecto->cont_id_linea_base = $tipo_linea;
        $continuidadProyecto->cont_ident_id = $iden_id;
        $respuesta = $continuidadProyecto->save();
        // print_r($continuidadProyecto);die();
        if (!$respuesta){
            $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

            return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
        }
    }
    public function guardarRespuestas_2021($preguntas, $pro_an_id, $iden_id,$tipo_linea){
        $respuesta = "";
        if(isset($preguntas['preguntas'])){
                foreach($preguntas['preguntas'] as $c1 => $v1){
                    if($v1 != null){
                        if($v1["tipoTabla"] == 1){
                            $resultado = LineaBaseServiciosComunales::where("pro_an_id",$pro_an_id)->where("sc_ident_id", $iden_id)->where("sc_id_servicio",$v1["id"])->where("SC_TIPO" ,$tipo_linea)->first();
                            // print_r($v1["resp1"]);
                            // die();
                            if(count($resultado)==0){
                                if($v1["resp1"] != 0 || $v1["resp2"] != 0 || $v1["resp3"] != 0){
                                $max_id= LineaBaseServiciosComunales::max('sc_id');
                                $newLinea= new LineaBaseServiciosComunales();
                                $newLinea->sc_id  = $max_id+1;
                                $newLinea->sc_preg1  = $v1["resp1"];
                                $newLinea->sc_preg2   =$v1["resp2"];
                                $newLinea->sc_preg3   =$v1["resp3"];
                                
                                $newLinea->sc_mesyear  = $v1["expire"];
                                $newLinea->usuario  =  session()->all()["id_usuario"];
                                $newLinea->pro_an_id  = $pro_an_id;
                                $newLinea->sc_id_servicio    =  $v1["id"];
                                $newLinea->sc_tipo    = $tipo_linea;
                                $newLinea->sc_ident_id   = $iden_id;

                                $respuesta = $newLinea->save();
                                }
                                
                            }else{
               
                                $findLinea = LineaBaseServiciosComunales::find($resultado->sc_id);
                                if($v1["resp1"] == 0 && $v1["resp2"] == 0 && $v1["resp3"] == 0){
                                    $respuesta = $findLinea->delete();
                                }else{
                                $findLinea->sc_preg1  = $v1["resp1"];
                                $findLinea->sc_preg2   = $v1["resp2"];
                                $findLinea->sc_preg3   = $v1["resp3"];
                                $findLinea->sc_mesyear  = $v1["expire"];
                                $findLinea->usuario  =  session()->all()["id_usuario"];
                                $findLinea->pro_an_id  = $pro_an_id;
                                $findLinea->sc_id_servicio    =  $v1["id"];
                                $findLinea->sc_tipo   = $tipo_linea;
                                $findLinea->sc_ident_id   = $iden_id;
                                $respuesta = $findLinea->save();
                            }
                            
                            }
                            
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }else{
                                DB::commit();
                            }
                        }else if($v1["tipoTabla"] == 2){
                            $resultado = LineaBaseProgramasSocialesPrestaciones::where("pro_an_id",$pro_an_id)->where("sp_ident_id", $iden_id)->where("sp_id_programas",$v1["id"])->where("SP_TIPO",$tipo_linea)->first();
                            if(count($resultado)==0){
                                if($v1["resp1"] != 0 || $v1["resp2"] != 0){
                                $max_id= LineaBaseProgramasSocialesPrestaciones::max('sp_id');
                                
                                $newLinea= new LineaBaseProgramasSocialesPrestaciones();
                                $newLinea->sp_id  = $max_id+1;
                                $newLinea->sp_preg1  = $v1["resp1"];
                                $newLinea->sp_preg2   = $v1["resp2"];
                                $newLinea->sp_mesyear  = $v1["expire"];
                                $newLinea->sp_usuario  =  session()->all()["id_usuario"];
                                $newLinea->pro_an_id  = $pro_an_id;
                                $newLinea->sp_id_programas    =  $v1["id"];
                                $newLinea->sp_tipo   = $tipo_linea;
                                $newLinea->sp_ident_id   = $iden_id;
                                $respuesta = $newLinea->save();
                                }
                            }else{
                                $findLinea = LineaBaseProgramasSocialesPrestaciones::find($resultado->sp_id);
                                if($v1["resp1"] == 0 && $v1["resp2"] == 0){
                                    $respuesta = $findLinea->delete();
                                }else{
                                $findLinea->sp_preg1  = $v1["resp1"];
                                $findLinea->sp_preg2   = $v1["resp2"];
                                $findLinea->sp_mesyear  = $v1["expire"];
                                $findLinea->sp_usuario  =  session()->all()["id_usuario"];
                                $findLinea->pro_an_id  = $pro_an_id;
                                $findLinea->sp_id_programas    =  $v1["id"];
                                $findLinea->sp_tipo   = $tipo_linea;
                                $findLinea->sp_ident_id   = $iden_id;
                                $respuesta = $findLinea->save();
                            }
                            
                            }
                            
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }else{
                                DB::commit();
                            }
                        }else if($v1["tipoTabla"] == 3){
                            $resultado = LineaBaseBienesComunitarios::where("pro_an_id",$pro_an_id)->where("org_bc_ident_id", $iden_id)->where("org_id_bienes",$v1["id"])->where("org_bc_tipo",$tipo_linea)->first();
                            if(count($resultado)==0){
                                if($v1["resp1"] != 0 || $v1["resp2"] != 0 || $v1["resp3"] != 0 || $v1["resp4"] != 0){
                                $max_id= LineaBaseBienesComunitarios::max('org_bc_id');
                                
                                $newLinea= new LineaBaseBienesComunitarios();
                                $newLinea->org_bc_id  = $max_id+1;
                                $newLinea->org_bc_preg1  = $v1["resp1"];
                                $newLinea->org_bc_preg2   = $v1["resp2"];
                                $newLinea->org_bc_preg3   = $v1["resp3"];
                                $newLinea->org_bc_preg4   = $v1["resp4"];
                                $newLinea->org_bc_mesyear  = $v1["expire"];
                                $newLinea->org_bc_usuario  =  session()->all()["id_usuario"];
                                $newLinea->pro_an_id  = $pro_an_id;
                                $newLinea->org_id_bienes    =  $v1["id"];
                                $newLinea->org_bc_tipo   = $tipo_linea;
                                $newLinea->org_bc_ident_id   = $iden_id;
                                $respuesta = $newLinea->save();
                                }
                            }else{
                                $findLinea = LineaBaseBienesComunitarios::find($resultado->org_bc_id);

                                if($v1["resp1"] == 0 && $v1["resp2"] == 0 && $v1["resp3"] == 0 && $v1["resp4"] == 0){
                                    $respuesta = $findLinea->delete();
                                }else{
                                $findLinea->org_bc_preg1  = $v1["resp1"];
                                $findLinea->org_bc_preg2   = $v1["resp2"];
                                $findLinea->org_bc_preg3   = $v1["resp3"];
                                $findLinea->org_bc_preg4   = $v1["resp4"];
                                $findLinea->org_bc_mesyear  = $v1["expire"];
                                $respuesta = $findLinea->save();
                            }
                            
                            }
                            
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }else{
                                DB::commit();
                            }
                        }else if($v1["tipoTabla"] == 4){
                            $resultado = LineaBaseOrganizacionesComunitarias::where("pro_an_id",$pro_an_id)->where("org_ident_id", $iden_id)->where("org_id_org",$v1["id"])->where("ORG_TIPO",$tipo_linea)->first();
                            if(count($resultado)==0){
                                if($v1["resp1"] != 0 || $v1["resp2"] != 0 || $v1["resp3"] != 0 || $v1["resp4"] != 0 || $v1["resp5"] != 0){
                                $max_id= LineaBaseOrganizacionesComunitarias::max('org_id');
                                
                                $newLinea= new LineaBaseOrganizacionesComunitarias();
                                $newLinea->org_id  = $max_id+1;
                                $newLinea->org_preg1  = $v1["resp1"];
                                $newLinea->org_preg2   = $v1["resp2"];
                                $newLinea->org_preg3   = $v1["resp3"];
                                $newLinea->org_preg4   = $v1["resp4"];
                                $newLinea->org_preg5   = $v1["resp5"];
                                $newLinea->org_mesyear  = $v1["expire"];
                                $newLinea->org_usuario  =  session()->all()["id_usuario"];
                                $newLinea->pro_an_id  = $pro_an_id;
                                $newLinea->org_id_org    =  $v1["id"];
                                $newLinea->org_tipo   = $tipo_linea;
                                $newLinea->org_ident_id   = $iden_id;
                                $respuesta = $newLinea->save();
                                }  
                            }else{
                                $findLinea = LineaBaseOrganizacionesComunitarias::find($resultado->org_id);
                                if($v1["resp1"] == 0 && $v1["resp2"] == 0 && $v1["resp3"] == 0 && $v1["resp4"] == 0&& $v1["resp5"] == 0){
                                    $respuesta = $findLinea->delete();
                                }else{
                                $findLinea->org_preg1  = $v1["resp1"];
                                $findLinea->org_preg2   = $v1["resp2"];
                                $findLinea->org_preg3   = $v1["resp3"];
                                $findLinea->org_preg4   = $v1["resp4"];
                                $findLinea->org_preg5   = $v1["resp5"];
                                $findLinea->org_mesyear  = $v1["expire"];
                                $respuesta = $findLinea->save();
                            }
                            }
                            
                            if (!$respuesta){
                                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";

                                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                            }else{
                                DB::commit();
                            }
                        }
                    }
                }
            }
    }
    public function guardarRespuestaOtro($identidad, $otros,$pro_an_id,$tipo_line_base){
        if($identidad != null){
            $iden_id = $identidad->iden_id;
        }else{
            $iden_id ="";
        }

        if($otros[0] != ''){
            if($iden_id == ""){
                $lineabase = new LineaBaseOtro();
                $lineabase =  LineaBaseOtro::max('otro_id')+1;
            }else{
                $lineabase = LineaBaseOtro::where('otro_iden_id', $iden_id)->where('otro_tipo', "=", "2.1")->where('id_otro_linea_base', "=",$tipo_line_base)->first();
                if(count($lineabase) > 0){
                    $lineabase = LineaBaseOtro::find($lineabase->otro_id);
                }else{
                    $lineabase = new LineaBaseOtro();
                    $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
                }
            }    
            $lineabase->otro_seccion = 'Servicios Comunales';
            $lineabase->otro_tipo = '2.1';
            $lineabase->otro_descripcion = $otros[0];
            $lineabase->otro_usuario = session()->all()["id_usuario"];
            $lineabase->pro_an_id = $pro_an_id;
            $lineabase->id_otro_linea_base = $tipo_line_base;
            $lineabase->otro_iden_id = $iden_id;
            $respuesta = $lineabase->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
        }
        if($otros[1] != ''){
            if($iden_id == ""){
                $lineabase = new LineaBaseOtro();
                $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
            }else{
                $lineabase = LineaBaseOtro::where('otro_iden_id', $iden_id)->where('otro_tipo', "=", "2.2")->where('id_otro_linea_base', "=",$tipo_line_base)->first();
                if(count($lineabase) > 0){
                    $lineabase = LineaBaseOtro::find($lineabase->otro_id);
                }else{
                    $lineabase = new LineaBaseOtro();
                    $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
                }
            } 
            $lineabase->otro_seccion = 'Programas Sociales y Prestaciones';
            $lineabase->otro_tipo = '2.2';
            $lineabase->otro_descripcion = $otros[1];
            $lineabase->otro_usuario = session()->all()["id_usuario"];
            $lineabase->pro_an_id = $pro_an_id;
            $lineabase->id_otro_linea_base = $tipo_line_base;
            $lineabase->otro_iden_id = $iden_id;
            $respuesta = $lineabase->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
        }
        if($otros[2] != ''){
            if($iden_id == ""){
                $lineabase = new LineaBaseOtro();
                $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
            }else{
                $lineabase = LineaBaseOtro::where('otro_iden_id', $iden_id)->where('otro_tipo', "=", "3.1")->where('id_otro_linea_base', "=",$tipo_line_base)->first();
                if(count($lineabase) > 0){
                    $lineabase = LineaBaseOtro::find($lineabase->otro_id);
                }else{
                    $lineabase = new LineaBaseOtro();
                    $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
                }
            } 
            $lineabase->otro_seccion = 'Bienes Comunitarios';
            $lineabase->otro_tipo = '3.1';
            $lineabase->otro_descripcion = $otros[2];
            $lineabase->otro_usuario = session()->all()["id_usuario"];
            $lineabase->pro_an_id = $pro_an_id;
            $lineabase->id_otro_linea_base = $tipo_line_base;
            $lineabase->otro_iden_id = $iden_id;
            $respuesta = $lineabase->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
        }

        if($otros[3] != ''){
            if($iden_id == ""){
                $lineabase = new LineaBaseOtro();
                $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
            }else{
                $lineabase = LineaBaseOtro::where('otro_iden_id', $iden_id)->where('otro_tipo', "=", "3.2")->where('id_otro_linea_base', "=",$tipo_line_base)->first();
                if(count($lineabase) > 0){
                    $lineabase = LineaBaseOtro::find($lineabase->otro_id);
                }else{
                    $lineabase = new LineaBaseOtro();
                    $lineabase->otro_id =  LineaBaseOtro::max('otro_id')+1;
                }
            } 
            $lineabase->otro_seccion = ' Organizaciones Comunitarias';
            $lineabase->otro_tipo = '3.2';
            $lineabase->otro_descripcion = $otros[3];
            $lineabase->otro_usuario = session()->all()["id_usuario"];
            $lineabase->pro_an_id = $pro_an_id;
            $lineabase->id_otro_linea_base = $tipo_line_base;
            $lineabase->otro_iden_id = $iden_id;
            $respuesta = $lineabase->save();
            if (!$respuesta){
                $mensaje = "Hubo un error al momento de registrar la información. Por favor intente nuevamente o contacte con el Administrador.";
    
                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }
        }
    }
    public function descargarLineaBase_2021( Request $request){
        //Identificación
        $tipo = $request->tipo;
        $identificacion = LineaBaseIdentificacion::where("IDEN_ID", "=",$request->id)->where('IDEN_PRO_AN_ID',$request->pro_an_id)->first();
        if($identificacion->iden_sexo == 0){
            $identificacion->sexo = "Masculino"; 
        }else{
            $identificacion->sexo = "Femenino";
        }

        if($identificacion->iden_internet == 0){
            $identificacion->iden_internet = "No"; 
        }else{
            $identificacion->iden_internet = "Si";
        }

        if($identificacion->iden_electronico == 0){
            $identificacion->iden_electronico = "No"; 
        }else{
            $identificacion->iden_electronico = "Si";
        }

        if($identificacion->iden_hogar_nna == 0){
            $identificacion->iden_hogar_nna = "No"; 
        }else{
            $identificacion->iden_hogar_nna = "Si";
        }

        
        // Servicios Comunales
        $serviciosComunales = LineaBaseServiciosComunales::where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('sc_tipo', '=', $tipo)->where('sc_ident_id', "=" ,$identificacion->iden_id)->orderBy('SC_ID_SERVICIO', 'ASC')->get();

        foreach($serviciosComunales as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->sc_id_servicio)->value('lb_pre_nom');
        }

        // Programas Sociales y Prestaciones
        $programasSocialesPrestaciones = LineaBaseProgramasSocialesPrestaciones::where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('sp_tipo', '=', $tipo)->where('sp_ident_id', "=" ,$identificacion->iden_id)->orderBy('SP_ID_PROGRAMAS', 'ASC')->get();
        foreach($programasSocialesPrestaciones as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->sp_id_programas)->value('lb_pre_nom');
        }
        // Bienes Comunitarios
        $bienesComunitarios = LineaBaseBienesComunitarios::where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('org_bc_tipo', '=', $tipo)->where('org_bc_ident_id', "=" ,$identificacion->iden_id)->orderBy('ORG_ID_BIENES', 'ASC')->get();

        foreach($bienesComunitarios as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->org_id_bienes)->value('lb_pre_nom');
        }
        //  Organizaciones Comunitarias
        $organizacionesComunitarias = LineaBaseOrganizacionesComunitarias::where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('org_tipo', '=', $tipo)->where('org_ident_id', "=" ,$identificacion->iden_id)->orderBy('ORG_ID_ORG', 'ASC')->get();
        
        foreach($organizacionesComunitarias as $res1_tab1u){
            $res1_tab1u->nombre = PreguntasLB::where('lb_pre_id', $res1_tab1u->org_id_org)->value('lb_pre_nom');
        }

        // DERECHOS Y PARTICIPACIÓN DE NIÑOS, NIÑAS Y ADOLESCENTES.

        $derechoNNA = DerechoParticipacion::where('flag_tipo_linea_base',2)->get();
        foreach ($derechoNNA as $key =>$testing){
              $numero = $key+1;
            if ($testing->lb_par_id == 8){
                $valor = LineaBaseDerechoNinos::select('der_preg1 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();                
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
            if ($testing->lb_par_id == 9){
                $valor = LineaBaseDerechoNinos::select('der_preg2 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->numero = "4.".$numero;
                $testing->valor = $valor->valor;
            }
            if ($testing->lb_par_id == 10){
                $valor = LineaBaseDerechoNinos::select('der_preg3 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
            if ($testing->lb_par_id == 11){
                $valor = LineaBaseDerechoNinos::select('der_preg4 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
            if ($testing->lb_par_id == 12){
                $valor = LineaBaseDerechoNinos::select('der_preg5 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
            if ($testing->lb_par_id == 13){
                $valor = LineaBaseDerechoNinos::select('der_preg6 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
            if ($testing->lb_par_id == 14){
                $valor = LineaBaseDerechoNinos::select('der_preg7 AS valor')->where("der_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('der_id_linea_base', '=', $tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "4.".$numero;
            }
        }

        // CONTINUIDAD DEL PROYECTO

        $test = continuidadproyecto::get();
        
        foreach ($test as $key =>$testing){
                $numero = $key+1;
                
            if ($testing->lb_cont_id == 1){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg1 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 2){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg2 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 3){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg3 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 4){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg4 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 5){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg5 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 6){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg6 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
            if ($testing->lb_cont_id == 7){
                $valor = LineaBaseContinuidadProyecto::select('cont_preg7 AS valor')->where("cont_ident_id", "=", $identificacion->iden_id)->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('cont_id_linea_base','=',$tipo)->first();
                $testing->valor = $valor->valor;
                $testing->numero = "5.".$numero;
            }
        }
        // OTRO
        // CZ SPRINT 76
        $otroserviciosComunales = LineaBaseOtro::select('OTRO_DESCRIPCION')->where('otro_tipo', '=', "2.1")->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('id_otro_linea_base', '=', $tipo)->where('OTRO_IDEN_ID',$identificacion->iden_id)->first();
        $otroprogramasSocialesPrestaciones = LineaBaseOtro::select('OTRO_DESCRIPCION')->where('otro_tipo', '=', "2.2")->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('id_otro_linea_base', '=', $tipo)->where('OTRO_IDEN_ID',$identificacion->iden_id)->first();
        $otrobienesComunitarios = LineaBaseOtro::select('OTRO_DESCRIPCION')->where('otro_tipo', '=', "3.1")->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('id_otro_linea_base', '=', $tipo)->where('OTRO_IDEN_ID',$identificacion->iden_id)->first();
        $otrorganizacionesComunitarias = LineaBaseOtro::select('OTRO_DESCRIPCION')->where('otro_tipo', '=', "3.2")->where('pro_an_id','=',$identificacion->iden_pro_an_id)->where('id_otro_linea_base', '=', $tipo)->where('OTRO_IDEN_ID',$identificacion->iden_id)->first();
        // CZ SPRINT 76
        $pdf = \PDF::loadView('gestor_comunitario/gestion_comunitaria/diagnostico_participativo/linea_base_2021_pdf',[
            'identificacion' => $identificacion,
            'serviciosComunales' => $serviciosComunales,
            'programasSocialesPrestaciones' => $programasSocialesPrestaciones,
            'bienesComunitarios' => $bienesComunitarios,
            'organizacionesComunitarias' => $organizacionesComunitarias,
            'otro1' =>  $otroserviciosComunales, 
            'otro2' => $otroprogramasSocialesPrestaciones,
            'otro3' => $otrobienesComunitarios, 
            'otro4' => $otrorganizacionesComunitarias,
            'tabla_continuidadProyecto' => $test,
            'derechoNNA' => $derechoNNA
        ]);

       

       return $pdf->stream('Linea_Base.pdf');

        // return view('gestor_comunitario/gestion_comunitaria/diagnostico_participativo/linea_base_2021_pdf',[
        //     'identificacion' => $identificacion,
        //     'serviciosComunales' => $serviciosComunales,
        //     'programasSocialesPrestaciones' => $programasSocialesPrestaciones,
        //     'bienesComunitarios' => $bienesComunitarios,
        //     'organizacionesComunitarias' => $organizacionesComunitarias,
        //     'otro1' =>  $otroserviciosComunales, 
        //     'otro2' => $otroprogramasSocialesPrestaciones,
        //     'otro3' => $otrobienesComunitarios, 
        //     'otro4' => $otrorganizacionesComunitarias,
        //     'tabla_continuidadProyecto' => $test,
        //     'derechoNNA' => $derechoNNA
        // ]);
    }
    public function eliminarLineaBase_2021(Request $request){
        
        try{

            DB::beginTransaction();
            
            $resp = LineaBaseContinuidadProyecto::where("cont_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseContinuidadProyecto::find($v->cont_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $resp = LineaBaseDerechoNinos::where("der_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseDerechoNinos::find($v->der_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            
            $resp = LineaBaseOrganizacionesComunitarias::where("org_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseOrganizacionesComunitarias::find($v->org_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $resp = LineaBaseBienesComunitarios::where("org_bc_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseBienesComunitarios::find($v->org_bc_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $resp = LineaBaseProgramasSocialesPrestaciones::where("sp_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseProgramasSocialesPrestaciones::find($v->sp_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $resp = LineaBaseServiciosComunales::where("sc_ident_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseServiciosComunales::find($v->sc_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            $resp = LineaBaseOtro::where("otro_iden_id",$request->id)->get();

            if(count($resp) > 0){

                foreach($resp as $v){
                    $resultdos = LineaBaseOtro::find($v->otro_id);
                    $respuesta = $resultdos->delete();
                    if (!$respuesta){
                        $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
        
                        return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
                    }
                }
            }

            
            $lineabase = LineaBaseIdentificacion::find($request->id);
            $respuesta = $lineabase->delete();

            if (!$respuesta){
                $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }            

            DB::commit();
            $mensaje = "Acción eliminada con éxito.";
            
            return response()->json(array('estado' => '1', 'mensaje' => $mensaje), 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            $mensaje = "Hubo un error al momento de eliminar la información. Por favor intente nuevamente o contacte con el Administrador.";
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }
    //FIN CZ SPRINT 70

    public function getDocPercepcion(Request $request){
        // try{
        //     //CZ SPRINT 73
        //     $proceso = ProcesoAnual::where('pro_an_id',$request->pro_an_id)->first();
        //     $comuna = Comuna::where('com_id',$proceso->com_id)->first();
        //     $destinationPath = 'doc/'.$comuna->com_nom;
        //     //CZ SPRINT 73
        //     $pro_an_id = $request->pro_an_id;
        //     $doc = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_gest", $request->tipo_gestion)->orderBy('created_at', 'desc')->get();
        //     $alas = $mater = $asycon = "";
        //         foreach($doc as $v1){
        //             $date = Carbon::createFromFormat('Y-m-d H:i:s', $v1->created_at)->format('d/m/Y'); 
        //         //CZ SPRINT 73
        //             $ruta = "../../".$destinationPath."/".$v1->doc_nom;
        //             $ruta_file = $destinationPath."/".$v1->doc_nom;
        //             if (!is_file($ruta_file)) {
        //                 $ruta = "../../doc/".$v1->doc_nom;
        //             }
        //         }

            

        //         return Datatables::of( $doc)
        //         ->make(true);
          
        
        // }catch(\Exception $e) {
            
		// 	Log::error('error: '.$e);
        //     // INICIO CZ SPRINT 66
		// 	$mensaje = "Hubo un error al momento de obtener la informacion solicitada. Por favor intente nuevamente.";
		// 	//FIN CZ SPRINT 66
		// 	return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
        // }
        try{
                 
            $pro_an_id = $request->pro_an_id;
            
            $respuesta = DocumentoGcomunitaria::where("pro_an_id",$pro_an_id)->where("tip_gest",0)->where("tip_id", 9)->orderBy('created_at', 'desc')->get();

           //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            foreach($respuesta as $key=> $documento){

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $documento->created_at)->format('d/m/Y'); 
                $ruta_file = "../../".$destinationPath."/".$documento->doc_nom;
                $respuesta[$key]->ruta = $ruta_file;
            }  

            // print_r($respuesta);
            // die();
            // echo json_encode($data); exit;
            return Datatables::of( $respuesta)->make(true);
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error('error: '.$e);
            // INICIO CZ SPRINT 66
            $mensaje = "Hubo un error al momento de obtener la información solicitada. Por favor intente nuevamente o contacte con el Administrador.";
            //FIN CZ SPRINT 66
            return response()->json(array('estado' => '0', 'mensaje' => $e->getMessage()), 400);
        }
    }

    public function eliminarDocPercepion(Request $request){
        try{

            DB::beginTransaction();

            if (!isset($request->id) || $request->id == ""){
                $mensaje = "No se encuentra ID del documento. Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            if (!isset($request->id_pro_an_id) || $request->id_pro_an_id == ""){
                $mensaje = "No se encuentra ID del proceso anual . Por favor verifique e intente nuevamente.";

                return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 200);
            }

            $docPercepcion = DocumentoGcomunitaria::find($request->id);
            $respuesta = $docPercepcion->delete();

            if (!$respuesta){
            	DB::rollback();
					$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
							
				return response()->json(array('estado' => '0', 'mensaje' => $mensaje), 400);
            }

            DB::commit();
            //CZ SPRINT 73
            $proceso = ProcesoAnual::where('pro_an_id',$request->id_pro_an_id)->first();
            $comuna = Comuna::where('com_id',$proceso->com_id)->first();
            $destinationPath = 'doc/'.$comuna->com_nom;
            $ruta = "../../".$destinationPath."/".$docPercepcion->doc_nom;
            //CZ SPRINT 73
            File::delete($ruta.'/'.$docPercepcion->doc_nom);
            $mensaje = "Documento eliminada con éxito.";
            return response()->json(array('estado' => '1', "mensaje" => $mensaje), 200);
        }catch(\Exception $e) {
            
            DB::rollback(); dd($e);
			Log::error('error: '.$e);
			$mensaje = "Hubo un error al eliminar la informacion. Por favor intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
        }
    }
}

