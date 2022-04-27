<?php
//app/Helpers/Helper.php
namespace App\Helpers;
use Rut;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modelos\{AlertaManual,
	AsignadosVista,
	Caso,
	Contacto,
	CasoEstado,
	CasoTerapeuta,
	Comuna,
	Dimension,
	EstadoCaso,
	NNAAlertaManual,
	Persona,
	Direccion,
	Liceo,
	Predictivo,
	Score,
	Region,
	Tercero,
	RegistradosVista,
	UsuarioComuna,
	Usuarios,
	Sesion,
	Perfil,
	GrupoFamiliar,
	CasoGrupoFamiliar,
	CasoPersonaIndice,
	ModalidadVisita,
	EstadoTerapiaBitacora,
	TerapiaSeguimientoModalidad,
	EstadoProceso};
 
class Helper{
     public static function alertasTerritorialesHistorial($run) {
       
       	//$alertas_territoriales_historial = AlertaChileCreceContigo::where("ALE_CHCC_RUN","=",$run)->get();
			$alertas_territoriales_historial = DB::select("SELECT * FROM ai_alerta_chile_crece_contigo WHERE ALE_CHCC_RUN = ".$run);

			
			
			//dd($alertas_territoriales_historial);
			if (!is_null($alertas_territoriales_historial) && count($alertas_territoriales_historial) > 0){
				foreach ($alertas_territoriales_historial as $c1 => $v1){
					$get_comuna = "";
					$comuna = "Sin información";
					$get_comuna = comuna::where("com_cod", "=", $v1->ale_chcc_cod_com)->get();
					if (!is_null($get_comuna) && count($get_comuna) > 0) $comuna = $get_comuna[0]->com_nom;
					//dd($c1, $v1);
					$alertas_territoriales_historial[$c1]->comuna_nombre = $comuna;

					$fecha = "Sin información";
					if (!is_null($v1->ale_chcc_fec_ing) && $v1->ale_chcc_fec_ing != "") $fecha = date('d-m-Y', strtotime($v1->ale_chcc_fec_ing));

					$alertas_territoriales_historial[$c1]->fecha_formateada = $fecha;

					$origen = "Sin información";
					if (!is_null($v1->ale_chcc_ori) && $v1->ale_chcc_ori != "") $origen = $v1->ale_chcc_ori;

					$alertas_territoriales_historial[$c1]->origen = $origen;					
				}
			}

		return $alertas_territoriales_historial;
    }

    public static function get_alertasManualXnna($run) {
       
        $result = DB::select("select at.ale_tip_id,ale_tip_nom ,cam.cas_id,
        	am.ale_man_id, am.ale_man_fec,ea.est_ale_nom
        	,u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as responsable
			from ai_alerta_manual am 
			left join ai_caso_alerta_manual cam on am.ale_man_id=cam.ale_man_id
			left join ai_alerta_manual_tipo amt on am.ale_man_id=amt.ale_man_id
			left join ai_alerta_tipo at on amt.ale_tip_id=at.ale_tip_id
			left join ai_estado_alerta_manual_estado eame on am.ale_man_id=eame.ale_man_id
			left join ai_estado_alerta ea on eame.est_ale_id=ea.est_ale_id
			left join ai_usuario u on am.id_usu=u.id
			where am.ale_man_run=".$run." and am.ale_man_tipo = 1");
         
        return $result;
    
    }

    public static function get_alertas($cas_id) {
       
        $alertas = DB::select("select at.ale_tip_id,ale_tip_nom 
				,cam.cas_id,am.ale_man_id, am.ale_man_fec
				from ai_alerta_manual am 
				inner join ai_caso_alerta_manual cam on am.ale_man_id=cam.ale_man_id
                inner join ai_alerta_manual_tipo amt on am.ale_man_id=amt.ale_man_id
				inner join ai_alerta_tipo at on amt.ale_tip_id=at.ale_tip_id
                where cam.cas_id=".$cas_id."");
         
        return $alertas;
    
    }

    public static function get_ofertas($alertasAsociadas) {
       
       		$cont=0;
			$ale_man_id=0;
			$arrayAlertasAsoc=[];

			foreach ($alertasAsociadas as $value) {
				if($cont==0){
					$ale_man_id = $value->ale_man_id;
					$arrayAlertasAsoc[0]= $value->cas_id;
					$cont=1;
				}
				else{

					$ale_man_id = $ale_man_id.",".$value->ale_man_id;
					array_push($arrayAlertasAsoc, $value->cas_id);
				}
			}

			$OfertasAsociadas = DB::select("select u.nombres, u.apellido_paterno, o.ofe_id , o.ofe_nom, am.ale_man_id, i.nom_ins, ea.est_ale_nom
				from ai_ofertas o 
				inner join ai_am_ofertas amf on amf.ofe_id=o.ofe_id
				inner join ai_alerta_manual am on amf.ale_man_id=am.ale_man_id
				inner join ai_usuario u on u.id=o.usu_resp
				inner join ai_institucion i on u.id_institucion=i.id_ins
				inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id
				where amf.ale_man_id in (".$ale_man_id.")");
         
        return $OfertasAsociadas;
    
    }

    public static function get_parentesco() {
      	$listaParentesco = DB::select("select par_gru_fam_id, par_gru_fam_nom 
		    	from ai_parentesco_grupo_familiar where not par_gru_fam_id = 99");
        return $listaParentesco;
    }

    public static function get_grupoFamiliarAsoc($caso_id) {
      	$grupoFamiliar = DB::select("SELECT * FROM ai_grupo_familiar gf
		    			INNER JOIN ai_caso_grupo_familiar cgf ON cgf.gru_fam_id=gf.gru_fam_id
		    			WHERE cgf.cas_id = ".$caso_id." and gru_fam_est=1");
      	
        return $grupoFamiliar;
    }
    //INICIO DC
    public static function get_cantTarCom($caso_id) {
        $cantidad = DB::select("select count(*) as cantidad 
            from 
			ai_objetivo_paf a
		    join ai_obj_tarea_paf b on (a.obj_id = b.obj_id)
			left join ai_obj_tar_estado_paf c on (b.est_tar_id = c.est_tar_id)
            where a.cas_id=".$caso_id."
            and b.est_tar_id IN (1,3,5,2)");
        
        return $cantidad;
    }
    //FIN DC
    public static function get_cantTarLog($caso_id) {
        $cantidad = DB::select("select count(*) as cantidad
            from
			ai_objetivo_paf a
		    join ai_obj_tarea_paf b on (a.obj_id = b.obj_id)
			left join ai_obj_tar_estado_paf c on (b.est_tar_id = c.est_tar_id)
            where a.cas_id=".$caso_id."
            and b.est_tar_id IN (3)");

        return $cantidad;
    }

    public static function get_grupoFamiliarGestorCaso($caso_id,$run_nna=null) {

   //  	    $grupoFamiliar = DB::select("SELECT 
   //  	    	gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat as gru_fam_nom, gf.gru_fam_id
			// FROM ai_grupo_familiar gf
			// INNER JOIN ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gf.gru_fam_id
			// WHERE cgf.cas_id=".$caso_id." and gf.gru_fam_est <> 0");

			// $gestor = DB::select("SELECT 
			// 		nombres||' '||apellido_paterno||' '||apellido_materno as gru_fam_nom, a.id as gru_fam_id
			// 	FROM 
			// 		ai_usuario a,
			// 		ai_persona_usuario b 
			// 	WHERE 
			// 		b.cas_id= ".$caso_id." and b.run=".$run_nna." and a.id= b.usu_id");

			// $responsables_array = [];

			// foreach ($grupoFamiliar as $value) {

			// 	array_push($responsables_array, 
			// 		array("id_responsable"  => $value->gru_fam_id, 
			// 			  "nom_responsable" => $value->gru_fam_nom, 
			// 			  "perfil"          => 0));

			// 	# code...
			// }

			//dd($gestor);

   			$grupoFamiliar = DB::select("select nombres||' '||apellido_paterno||' '||apellido_materno as gru_fam_nom, a.id as gru_fam_id,a.id_perfil as perfil
			from 
			ai_usuario a,
			ai_persona_usuario b 
			where b.cas_id= ".$caso_id." and b.run=".$run_nna." and a.id= b.usu_id
			union all
			select gru_fam_nom||' '||gru_fam_ape_pat||' '||gru_fam_ape_mat as gru_fam_nom, gf.gru_fam_id,null
			from ai_grupo_familiar gf
			inner join ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gf.gru_fam_id
			where cgf.cas_id=".$caso_id." and gf.gru_fam_est <> 0");
        return $grupoFamiliar;
    }

    public static function get_ofertasParentescoDos($ale_man_id = null) {
      	$ofertaParentesco = DB::select("select am_prog_id as am_ofe_id,prog_id as ofe_id, ale_man_id,gru_fam_id,est_prog_id as est_prest_id from ai_am_programas where ale_man_id=".$ale_man_id."");
        return $ofertaParentesco;
    }

    public static function get_ofertasParentesco($ale_man_id = null) {
      	$ofertaParentesco = DB::select("select am_ofe_id, ofe_id, ale_man_id,gru_fam_id,est_prest_id
			from ai_am_ofertas where ale_man_id=".$ale_man_id."");
        return $ofertaParentesco;
    }

   //  public static function get_prestaciones($ale_man_id = null) {
   //    	$ofertas = DB::select("select 
   //    		o.ofe_id,
   //    		o.ofe_cup,
   //    		o.ofe_nom, 
   //    		oat.ale_tip_id, 
   //    		am.ale_man_id, 
   //    		am.est_ale_id,
   //    		prog.pro_nom,
   //    		u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as usuario_nombre
			// from  ai_ofertas o 
			// inner join ai_ofertas_alerta_tipo oat on o.ofe_id = oat.ofe_id
			// inner join ai_alerta_tipo at on at.ale_tip_id = oat.ale_tip_id
			// inner join ai_alerta_manual_tipo amt on at.ale_tip_id=amt.ale_tip_id
			// inner join ai_alerta_manual am on amt.ale_man_id=am.ale_man_id
			// inner join ai_usuario u on u.id = o.usu_resp
			// inner join ai_programa prog on prog.prog_id = o.prog_id
   //          where am.ale_man_id=".$ale_man_id."");
   //      return $ofertas;
   //  }

     public static function get_prestacionesdos($ale_man_id = null) {
      	$ofertas = DB::select("select 
      		prog.prog_id as ofe_id,
      		'0' as ofe_cup,
      		prog.pro_nom as ofe_nom,
      		at.ale_tip_id,
      		am.ale_man_id,
      		am.est_ale_id,
      		prog.pro_cup,
      		prog.pro_nom as pro_nom,
      		u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as usuario_nombre from ai_programa prog
            inner join  ai_programa_alerta_tipo pat on prog.prog_id = pat.prog_id
			inner join ai_alerta_tipo at on at.ale_tip_id = pat.ale_tip_id
            left join ai_usuario u on u.id = prog.pro_usu_resp
            inner join ai_alerta_manual_tipo amt on at.ale_tip_id=amt.ale_tip_id
			inner join ai_alerta_manual am on amt.ale_man_id=am.ale_man_id
             where am.ale_man_id=".$ale_man_id."");
        return $ofertas;
    }

    public static function tituloModal() {
      	
      	$estado_caso = EstadoCaso::all();
      	//dd($estado_caso);
		$titulos_modal = array();
			foreach ($estado_caso AS $c01 => $v01){
				switch ($v01->est_cas_id){
					/*case config('constantes.en_prediagnostico'): //En pre diagnostico
					//dd("hola");
						$titulos_modal[0] = new \stdClass();
						$titulos_modal[0]->titulo = $v01->est_cas_nom;
						$titulos_modal[0]->id_est = $v01->est_cas_id;
					break;*/

					case config('constantes.en_diagnostico'): //En diagnostico
						$titulos_modal[0] = new \stdClass();
						$titulos_modal[0]->titulo = $v01->est_cas_nom;
						$titulos_modal[0]->id_est = $v01->est_cas_id;
					break;
									
					case config('constantes.en_elaboracion_paf'): //En elaboracion de PAF
						$titulos_modal[1] = new \stdClass();
						$titulos_modal[1]->titulo = $v01->est_cas_nom;
						$titulos_modal[1]->id_est = $v01->est_cas_id;
					break;
									
					case config('constantes.en_ejecucion_paf'): //En ejecucion de PAF
						$titulos_modal[2] = new \stdClass();
						$titulos_modal[2]->titulo = $v01->est_cas_nom;
						$titulos_modal[2]->id_est = $v01->est_cas_id;
					break;
									
					case config('constantes.en_cierre_paf'): //En cierre PAF
						$titulos_modal[3] = new \stdClass();
						$titulos_modal[3]->titulo = $v01->est_cas_nom;
						$titulos_modal[3]->id_est = $v01->est_cas_id;
					break;
									
					case config('constantes.en_seguimiento_paf'): //En seguimiento de PAF
						$titulos_modal[4] = new \stdClass();
						$titulos_modal[4]->titulo = $v01->est_cas_nom;
						$titulos_modal[4]->id_est = $v01->est_cas_id;
					break;

					case config('constantes.en_prediagnostico'): //En prediagnostico
						$titulos_modal[5] = new \stdClass();
						$titulos_modal[5]->titulo = $v01->est_cas_nom;
						$titulos_modal[5]->id_est = $v01->est_cas_id;
					break;
				}
			}

        return $titulos_modal;
    }

    public static function bitacorasEstados($caso_id) {

		$bitacoras_estados = array();
		$bitacoras_estados[0] = "";
		$bitacoras_estados[1] = "";
		$bitacoras_estados[2] = "";
		$bitacoras_estados[3] = "";
		$bitacoras_estados[4] = "";
		$bitacoras_estados[5] = "";
		$bit_est = CasoEstado::where("cas_id", "=", $caso_id)->get();
			foreach ($bit_est AS $c0 => $v0){
				switch ($v0->est_cas_id){
					case config('constantes.en_diagnostico'): //En diagnostico
						$bitacoras_estados[0] = $v0->cas_est_cas_des;
					break;
							
					case config('constantes.en_elaboracion_paf'): //En elaboracion de PAF
						$bitacoras_estados[1] = $v0->cas_est_cas_des;
					break;
							
					case config('constantes.en_ejecucion_paf'): //En ejecucion de PAF
						$bitacoras_estados[2] = $v0->cas_est_cas_des;
					break;
							
					case config('constantes.en_cierre_paf'): //En cierre PAF
						$bitacoras_estados[3] = $v0->cas_est_cas_des;
					break;
							
					case config('constantes.en_seguimiento_paf'): //En seguimiento de PAF
						$bitacoras_estados[4] = $v0->cas_est_cas_des;
					break;
					case config('constantes.en_prediagnostico'): //En prediagnostico
						$bitacoras_estados[5] = $v0->cas_est_cas_des;
					break;
						}
					}

        return $bitacoras_estados;
    }
    public static function bitacorasEstadosTerapia($tera_id) {

		$bitacoras_estados = array();
		$bitacoras_estados[0] = "";
		$bitacoras_estados[1] = "";
		$bitacoras_estados[2] = "";
		$bitacoras_estados[3] = "";

		$bit_est = EstadoTerapiaBitacora::where("tera_id", "=", $tera_id)->get();
			foreach ($bit_est AS $c0 => $v0){
				switch ($v0->est_tera_id){
					case config('constantes.gtf_invitacion'): //En invitacion
						$bitacoras_estados[0] = $v0->tera_est_tera_des;
					break;
							
					case config('constantes.gtf_diagnostico'): //En diagnostico
						$bitacoras_estados[1] = $v0->tera_est_tera_des;
					break;
							
					case config('constantes.gtf_ejecucion'): //En ejecucion
						$bitacoras_estados[2] = $v0->tera_est_tera_des;
					break;
							
					case config('constantes.gtf_seguimiento'): //En segimiento
						$bitacoras_estados[3] = $v0->tera_est_tera_des;
					break;
							
						}
					}

        return $bitacoras_estados;
    }

	public static function get_alertasXnna($caso_id) {
	      	
	    $ofertaAlerta = DB::select(" select p.per_id,p.per_nom||' '||p.per_pat||' '||p.per_mat as persona_nombre,am.ale_man_id,at.ale_tip_id,at.ale_tip_nom,am.est_ale_id,
	    	ea.est_ale_nom,pf.nombre as perfil,u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as responsable, u.telefono, u.email
            from ai_alerta_manual am
            inner join ai_alerta_manual_tipo amt on amt.ale_man_id=am.ale_man_id
            inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
            inner join ai_persona p on p.per_run=am.ale_man_run
            inner join ai_caso_persona_indice cpi on p.per_id=cpi.per_id
            inner join ai_estado_alerta ea on ea.est_ale_id=am.est_ale_id
            inner join ai_usuario u on u.id=am.id_usu
			inner join ai_perfil pf on u.id_perfil=pf.id			
			inner join ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
            where cpi.cas_id=".$caso_id." AND ea.est_ale_ini = 0 AND ea.est_ale_fin = 0 order by ale_tip_ord");
		
	    $alertaNnaDesc = array();

		$array = array();

		$alertaNna = array();

		$ex= array();

		$x=0;

		foreach ($ofertaAlerta as $nna) {

			$persona_nombre = $nna->persona_nombre;

			$per_id = $nna->per_id;

			foreach ($ofertaAlerta as $descripcion) {

				if($nna->per_id== $descripcion->per_id){

					array_push($alertaNnaDesc,array("est_ale_id" => $descripcion->est_ale_id,"ale_man_id" => $descripcion->ale_man_id, "ale_tip_id" => $descripcion->ale_tip_id, "ale_tip_nom" => $descripcion->ale_tip_nom,"est_ale_nom" => $descripcion->est_ale_nom,"perfil" => $descripcion->perfil,"responsable" => $descripcion->responsable,"telefono" => $descripcion->telefono,"email" => $descripcion->email));
				}

			}

			if (in_array($per_id, $ex)) {
				
				$alertaNnaDesc=[];
			
			}else {

				$array[$x] = array( "per_id" =>  $per_id , "persona_nombre" => $persona_nombre, "descripcion" => $alertaNnaDesc);

				$x++;
				$alertaNnaDesc=[];
				array_push($ex,$per_id); 
			}
			
		}

		$alertaNna = $array;

		return 	$alertaNna;

	}

	public static function getAlertaNNAxTipo($cas_id){

		$tipoAlerta = DB::select(" select at.ale_tip_id,at.ale_tip_nom
            from ai_alerta_manual am
            left join ai_alerta_manual_tipo amt on amt.ale_man_id=am.ale_man_id
            left join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
            left join ai_persona p on p.per_run=am.ale_man_run
            left join ai_caso_persona_indice cpi on p.per_id=cpi.per_id
            left join ai_usuario u on u.id=am.id_usu
			where cpi.cas_id=".$cas_id." GROUP BY at.ale_tip_id,at.ale_tip_nom" );
			
			return $tipoAlerta;
	}
	//DC inicio
	public static function insHistorialEstadoAlerta($idAlerta, $estado, $nomEstado){
	    $sql = "insert into ai_estado_alerta_manual_estado (est_ale_id, ale_man_id, est_ale_man_est_fec, ale_just_est)
        values(".$estado.", ".$idAlerta.", sysdate, 'Alerta Territorial en estado ".$nomEstado."')";
	    return DB::insert($sql);
	}
	
	public static function ActualizaEstadoAlertaObjetivo($idAlerta){
	    $sql = DB::update("update ai_alerta_manual set est_ale_id = 5 where ale_man_id = ".$idAlerta);
	    return $sql;
	}
	
	public static function getAlertaObjetivo($cas_id){
	    $sql = DB::select("select ai_alerta_id from AI_ALERTA_OBJETIVO where ai_caso_id = ".$cas_id);
	    return $sql;
	}
	
	//INICIO DC
	public static function getTiemposIntervencion($comunas, $inicio, $fin, $caso = null, $gestor = null){
	    $sql_nCaso = "";
	    $sql_gestor = "";
	    $filtro = "";
	    if($caso != 0){
	        $filtro = " and caso.cas_id = ".$caso;
	    }
	    if($gestor != null){
	        $sql_gestor = " and usu.id = ".$gestor;
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
        where (select max(cec.cas_est_cas_fec) from ai_caso_estado_caso cec where cec.est_cas_id = 10 and cec.cas_id = caso.cas_id) > to_date('".$inicio."', 'dd/mm/yyyy')
        and (select max(cec.cas_est_cas_fec) from ai_caso_estado_caso cec where cec.est_cas_id = 10 and cec.cas_id = caso.cas_id) < to_date('".$fin."', 'dd/mm/yyyy')
        and comuna.com_id in (".$comunas.") 
        ".$filtro.$sql_gestor;
        $resultado = DB::select($sql);
        return $resultado;
	}
	
	public static function getTiemposIntervencionTF($comunas, $inicio, $fin, $caso = null, $gestor = null){
	    $filtro = "";
	    $sql_gestor = "";
	    if($caso != 0){
	        $filtro = " and ter.cas_id = ".$caso;
	    }
	    if($gestor != null){
	        $sql_gestor = " and usu.id = ".$gestor;
	    }
	    $sql = "select distinct ter.cas_id,
        usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as nombre,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) as fecha_asignacion,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 4 and tera_id = ter.tera_id) as fecha_diagnostico,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 5 and tera_id = ter.tera_id) as fecha_ejecucion,
        (select to_char(max(tera_est_tera_fec), 'dd/mm/yyyy') from ai_est_terapia_bitacora where est_tera_id = 6 and tera_id = ter.tera_id) as fecha_seguimiento,
        (FN_MESES_INTERVENCION_TF(3, 4, ter.tera_id) +
        FN_MESES_INTERVENCION_TF(4, 5, ter.tera_id) +
        FN_MESES_INTERVENCION_TF(5, 6, ter.tera_id)) as meses,
        (FN_DIAS_INTERVENCION_TF(3, 4, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(4, 5, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(5, 6, ter.tera_id) +
        FN_DIAS_INTERVENCION_TF(6, 12, ter.tera_id)) as dias,
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
        where (select max(tera_est_tera_fec) from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) > to_date('".$inicio."', 'dd/mm/yyyy')
        and (select max(tera_est_tera_fec) from ai_est_terapia_bitacora where est_tera_id = 3 and tera_id = ter.tera_id) < to_date('".$fin."', 'dd/mm/yyyy')
        and comuna.com_id in (".$comunas.")
        ".$filtro.$sql_gestor;
	    $resultado = DB::select($sql);
	    return $resultado;
	}
	
	public static function listarDimensionVinculada($cas_id, $alerta_id){
	    $sql = DB::select("select de.dim_enc_nom as dimension
        from ai_am_dimension ad
        inner join ai_dimension_encuesta de on ad.dim_enc_id = de.dim_enc_id
        where ad.cas_id = ".$cas_id." and ad.ale_man_id = ".$alerta_id);
	    return $sql;
	}
	
	public static function alertaAddObjetivo($cas_id){
	    $sql = DB::select("SELECT 
            am.est_ale_id, 
            am.ale_man_id, 
            at.ale_tip_id, 
            at.ale_tip_nom, 
            ea.est_ale_nom
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
			WHERE cpi.cas_id=".$cas_id."
            GROUP BY at.ale_tip_id,at.ale_tip_nom, am.ale_man_id, am.est_ale_id, ea.est_ale_nom");
	    return $sql;
	}
	//FIN DC
	
	//AT EN EVALUACIÓN DIAGNÓSTICA
	//INICIO CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	public static function getAlertaNNAxTipoEva($cas_id,$est_cas_id = null, $run){
		if($est_cas_id == config('constantes.en_prediagnostico') || $est_cas_id == config('constantes.en_diagnostico')){
			$condicion = 'AND ea.est_ale_id BETWEEN 1 AND 6';
		}else{
			$condicion = 'AND ea.est_ale_id BETWEEN 2 AND 6' ;
		}
		// CZ SPRINT 77
		$tipoAlerta = DB::select("SELECT 
            am.est_ale_id, 
            am.ale_man_id, 
            am.ale_man_dir_usu,
            at.ale_tip_id, 
            at.ale_tip_nom, 
            count(at.ale_tip_id) as cantidad,
            ea.est_ale_nom,
            amt.ale_man_info_rel
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
			left join ai_caso_alerta_manual ca on am.ale_man_id = ca.ale_man_id
			WHERE cpi.cas_id=".$cas_id." and ca.cas_id = {$cas_id}
            GROUP BY at.ale_tip_id,
            at.ale_tip_nom, 
            am.ale_man_id, 
            am.est_ale_id, 
            ea.est_ale_nom, 
            am.ale_man_fec, 
            am.ale_man_dir_usu,
            amt.ale_man_info_rel
            ORDER BY am.ale_man_fec desc" );
			// CZ SPRINT 77		
			return $tipoAlerta;

	}
	//FIN CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	//FIN CZ SPRINT 63 Casos ingresados a ONL
	
	public static function vincularObjetivo($idAlerta,$idObj,$cas_id){
	    
	    $sql = DB::insert("insert into AI_ALERTA_OBJETIVO(ai_alerta_id, ai_obj_id, AI_TAR_ID, AI_CASO_ID)
            values(".$idAlerta.", ".$idObj.", '', ".$cas_id.")" );
	    
	    
	    return $sql;
	}
	
	public static function verVinculacion($alerta, $obj_id){
	    $tipoAlerta = DB::select("select count(*) vinculados from AI_ALERTA_OBJETIVO where ai_alerta_id = ".$alerta." and ai_obj_id = ".$obj_id);
	    
	    
	    return $tipoAlerta;
	    	    
	    
	}
	
	public static function porcentajeLogro($caso){
	    $tipoAlerta = DB::selectOne("select FN_PORCENTAJE_LOGRO(".$caso.") as porcentaje from dual" );
	    
	    
	    return $tipoAlerta;
	}
	
	public static function updMitigar($estado, $alerta){
	    $sql = DB::update("update ai_alerta_manual set est_ale_id = ".$estado." where ale_man_id = ".$alerta );
	    return $sql;
	}
	
	//INICIO DC
	public static function updNoMitigar($estado, $alerta, $motivo){
	    $sql = DB::update("update ai_alerta_manual set est_ale_id = ".$estado.", ALE_MAN_MOTIVO_NO_MITIGADA = '".$motivo."' where ale_man_id = ".$alerta );
	    return $sql;
	}
	
	public static function getEnAtencion($cas_id){
	    	    
		//INICIO CZ SPRINT 63 Casos ingresados a ONL
			//INICIO CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	    $tipoAlerta = DB::select(" SELECT 
            am.est_ale_id, 
            am.ale_man_id, 
            at.ale_tip_id, 
            at.ale_tip_nom, 
            count(at.ale_tip_id) as cantidad, 
            count(ao.ai_alerta_id) as vinculado,
            ea.est_ale_nom,
            am.ALE_MAN_MOTIVO_NO_MITIGADA
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
            LEFT JOIN AI_ALERTA_OBJETIVO ao ON ao.ai_alerta_id = am.ale_man_id
			left join ai_caso_alerta_manual on am.ale_man_id = ai_caso_alerta_manual.ale_man_id
			WHERE ai_caso_alerta_manual.cas_id=".$cas_id."
            and (am.est_ale_id = 5 or am.est_ale_id = 6 or am.est_ale_id = 7)
            GROUP BY at.ale_tip_id,at.ale_tip_nom, am.ale_man_id, am.est_ale_id, ea.est_ale_nom, am.ALE_MAN_MOTIVO_NO_MITIGADA" );
	    //FIN CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	    //FIN CZ SPRINT 63 Casos ingresados a ONL
	    return $tipoAlerta;
	}
	//FIN DC
	
	public static function listarAlertaDetectada($cas_id, $obj_id){
	    if($obj_id != null){
	        $sqlObj = "and ai_obj_id = ".$obj_id;
	        
	    }else{
	        $sqlObj = "";
	    }
	    
	    //INICIO DC
		// INICIO CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	    $tipoAlerta = DB::select(" SELECT 
            am.est_ale_id, 
            am.ale_man_id, 
            at.ale_tip_id, 
            at.ale_tip_nom, 
            count(at.ale_tip_id) as cantidad, 
            count(ao.ai_alerta_id) as vinculado,
            ea.est_ale_nom
            FROM ai_alerta_manual am
            LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
            LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id=amt.ale_tip_id
            LEFT JOIN ai_persona p ON p.per_run=am.ale_man_run
            LEFT JOIN ai_caso_persona_indice cpi ON p.per_id=cpi.per_id
            LEFT JOIN ai_usuario u ON u.id=am.id_usu
			LEFT JOIN ai_estado_alerta ea ON am.est_ale_id = ea.est_ale_id
			left join ai_caso_alerta_manual ca on am.ale_man_id = ca.ale_man_id
            LEFT JOIN AI_ALERTA_OBJETIVO ao ON ao.ai_alerta_id = am.ale_man_id and ao.AI_OBJ_ID = ".$obj_id."
			WHERE ca.cas_id=".$cas_id."
            and am.est_ale_id in (2, 4, 5, 6, 7)
            GROUP BY at.ale_tip_id,
            at.ale_tip_nom,
            am.ale_man_id,
            am.est_ale_id,
            ea.est_ale_nom" );
			//FIN CZ SPRINT 63 Casos ingresados a ONL CAMBIOS
	    //FIN DC
	    
			
			return $tipoAlerta;
	}

	public static function estadosRechazoTerapia() {
       
		  $result = DB::select("SELECT est_tera_id, est_tera_nom, est_tera_fin FROM ai_estado_terapia WHERE est_tera_fin=1 and est_tera_id!=".config('constantes.gtf_seguimiento')." and est_tera_id!=".config('constantes.gtf_egreso'));
         
        return $result;
    
    }


    public static function estadosRechazoCaso() {
       
		  $result = DB::select("SELECT est_cas_id, est_cas_nom, est_cas_fin FROM ai_estado_caso WHERE est_cas_fin=1 and est_cas_id!=".config('constantes.egreso_paf')."");
         
        return $result;
    
    }
    
    //INICIO DC
    public static function getRegiones() {
        
        $result = DB::select("select reg_id, reg_nom from ai_region order by reg_nom asc");
        
        return $result;
        
    }
    public static function getPerfiles() {
        // CZ SPRINT 77
        $result = DB::select("select id, nombre from ai_perfil where id_estado = 1 and id not in (1,9,6) order by nombre asc");
        // CZ SPRINT 77
        return $result;
        
    }
    public static function estadosRechazoCoordinador() { 
        $result = DB::select("SELECT est_cas_id, est_cas_nom, est_cas_fin FROM ai_estado_caso WHERE est_cas_fin=1 and est_cas_id!=".config('constantes.egreso_paf')." and est_cas_id in(20, 29, 30, 22, 27)");
        return $result;
    }
    public static function getInstituciones() {
        $result = DB::select("select id_ins, nom_ins from ai_institucion order by nom_ins asc");
        return $result;
    }
    public static function getEtapas() {
        $result = DB::select("select * from ai_estado_proceso where est_pro_ini = 1 and est_pro_id != 5 order by est_pro_ord asc");
        return $result;       
    }
    public static function getProceso($comunas) {
        $result = DB::select("select pro_an_id from ai_proceso_anual where com_id in (".$comunas.") order by pro_an_id desc");
        return $result;
    }
    public static function estuvoEtapa($pro_an_id, $est_pro_id) {
        $result = DB::select("select count(*) as existe from ai_proceso_estado_proceso where pro_an_id = ".$pro_an_id." and est_pro_id = ".$est_pro_id);
        return $result;
    }
    public static function cantidadLineaBase($pro_an_id) {
        $result = DB::select("select count(*) as cantidad from ai_linea_base_gc where pro_an_id = ".$pro_an_id);
        return $result;
    }
    public static function cantidadLineaSalida($pro_an_id) {
        $result = DB::select("select count(*) as cantidad from ai_linea_base_gc where pro_an_id = ".$pro_an_id);
        return $result;
    }
    public static function diasEtapa($pro_an_id, $est_pro_id) {
        $result = DB::select("select to_char(created_at, 'dd/mm/yyyy') as fecha_ini, 
        est_pro_id 
        from ai_proceso_estado_proceso 
        where pro_an_id = ".$pro_an_id." 
        and est_pro_id != 5
        order by created_at asc");
        $fecha_ter = '';       
        $result[] = (object) ['fecha_ini' => 'actual', 'est_pro_id' => 0];
        for($i = 0; $i < count($result); $i++){      
            if($result[$i]->est_pro_id == $est_pro_id){
                $fecha_ter = $result[$i+1]->fecha_ini;
            }
        }
        if($fecha_ter == 'actual'){
            $fecha_ter = date("d/m/Y");
        }
        $dias = DB::select("select to_date('".$fecha_ter."', 'dd/mm/yyyy') - to_date(to_char(created_at, 'dd/mm/yyyy'), 'dd/mm/yyyy') as dias
        from ai_proceso_estado_proceso where pro_an_id = ".$pro_an_id." and est_pro_id = ".$est_pro_id);
        if(count($dias) > 0){
            if($dias[0]->dias == 0){
                return 1;
            }else{
                return $dias[0]->dias;
            }   
        }else{
            return 0;
        }
    }
    
    public static function getGestores() {
        $result = DB::select("select usu.id, usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as nombre 
        from ai_usuario usu
        inner join ai_perfil perf
        on usu.id_perfil = perf.id
        where usu.id_perfil = 3
        order by usu.nombres asc");
        return $result;
    }
    
    public static function getTerapeutas() {
        $result = DB::select("select usu.id, usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno as nombre
        from ai_usuario usu
        inner join ai_perfil perf
        on usu.id_perfil = perf.id
        where usu.id_perfil = 4
        order by usu.nombres asc");
        return $result;
    }
    //FIN DC

    public static function estadosRechazoProceso(){
        //INICIO DC
    	$result = EstadoProceso::select('est_pro_id', 'est_pro_nom')->where('est_pro_fin', '=', 1)->where('est_pro_id', '<>', 3)->get();
    	//FIN DC
    	return $result;
    }

    public static function listadoModalidadVisita() {

   		$result = ModalidadVisita::all();
        return $result;

    }

    public static function listadoModalidadSeguimiento() {

   		$result = TerapiaSeguimientoModalidad::all();
        return $result;

    }

    public static function devuelveRutX($rutx) {
    	$respuesta = $rutx;
    	$activar_ofuscacion = config('constantes.ofuscacion_run');

    	if ($activar_ofuscacion){
	    	$rut = str_replace("-","",$rutx);

	    	$rut = str_replace(".","",$rut);

	    	$rut = Rut::parse($rut)->format();

	    	$array_rut = str_split($rut);

	    	$tot_ele = count($array_rut);

	    	$array_rut[$tot_ele-1] = "x";
	    	// $array_rut[$tot_ele-2] = "x";
	    	$array_rut[$tot_ele-3] = "x";
	    	$array_rut[$tot_ele-4] = "x";
	    	$array_rut[$tot_ele-5] = "x";

	    	$rut = implode($array_rut);
	    	$respuesta = $rut;
    	}
        
        return $respuesta;

    }

    public static function CodificarString($string){
    	$respuesta = $string;

    	if (isset($respuesta) && $respuesta != "") $respuesta = base64_encode($respuesta);

    	return $respuesta;

    }

    public static function DecodificarString($string){
    	$respuesta = $string;

    	if (isset($respuesta) && $respuesta != "") $respuesta = base64_decode($respuesta);

    	return $respuesta;
    }

    public static function crearRunAT(){
    	$alertM_id	= AlertaManual::max('ale_man_id');
		$alertM_id  = $alertM_id + 1;
		$run = $alertM_id.strtotime(now());
		$dv_run = "S";
		return $run."-".$dv_run;
    }
	// INICIO CZ SPRINT 78
	public static function getComunas(){
		$comuna = explode(',',session()->all()['com_cod']);
		$id = session()->all()['id_usuario'];

		if(session()->all()['perfil'] == config('constantes.perfil_coordinador') || session()->all()['perfil'] == config('constantes.perfil_terapeuta') || session()->all()['perfil'] == config('constantes.perfil_gestor') || session()->all()['perfil'] == config('constantes.perfil_gestor_comunitario') ){
			$result = DB::select("select ai_comuna.com_id, ai_comuna.com_nom, ai_comuna.com_cod from ai_comuna 
			inner join ai_usuario_comuna on ai_comuna.com_id = ai_usuario_comuna.com_id
			where OLN = 'S' and vigencia = 1 and usu_id = {$id} and ai_comuna.com_cod = {$comuna[0]} order by ai_comuna.com_nom");
		}else if(session()->all()['perfil'] == config('constantes.perfil_coordinador_regional') || session()->all()['perfil'] == config('constantes.perfil_administrador_central')){
			$result = DB::select("select ai_comuna.com_id, ai_comuna.com_nom, ai_comuna.com_cod from ai_comuna 
			inner join ai_usuario_comuna on ai_comuna.com_id = ai_usuario_comuna.com_id
			where OLN = 'S' and vigencia = 1 and usu_id = {$id} order by ai_comuna.com_nom");
		}
		return $result;
	}
	// FIN CZ SPRINT 78
}
