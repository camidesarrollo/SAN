<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

/**
 * Class Programa
 * @package App\Modelos
 */

 
class Programa extends Model{
	
	protected $table 		= 'ai_programa';
	
	protected $primaryKey	= 'prog_id';
	
	public $timestamps		= true;
	
	
	/**
	 * Validar Método
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	/*public function programaComuna(){
		return $this->hasMany('App\Modelos\ProgramaComuna','prog_id','prog_id');
	}*/

	public static function getPrograma($prog_id){
 		return DB::select("SELECT 
 							p.prog_id,
 							p.pro_nom
						  FROM 
						  	ai_programa p 
						  WHERE 
						    p.prog_id=".$prog_id."");
	}

	public function getProgramaComuna(){
 		return DB::select("select p.prog_id,p.pro_nom,p.pro_tip 
				from ai_programa p inner join ai_pro_com pc on p.prog_id=pc.prog_id
				where pc.com_id in (".Session::get('com_id').")");
	}

	public static function proGesPen($cas_id) {
    
    	$programas = "SELECT
						prog.prog_id,
						prog.pro_nom,
						ep.est_prog_nom,
						e.estab_nom,
						rgc.ai_rgc_prog_id
					  FROM
						ai_programa prog
					  INNER JOIN 	
					  	ai_am_programas aprog on aprog.prog_id=prog.prog_id
					  LEFT JOIN
					  	ai_establecimientos e on e.estab_id=aprog.estab_id
					  INNER JOIN 	
					  	ai_grupo_familiar gfam on gfam.gru_fam_id=aprog.gru_fam_id
                      INNER JOIN 	
					  	ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gfam.gru_fam_id
					  INNER JOIN 	
					  	ai_estados_programas ep on ep.est_prog_id=aprog.est_prog_id
					  LEFT JOIN	
					  	-- ai_reporte_gestion_caso rgc on rgc.ai_rgc_prog_id=prog.prog_id
					  	(select * from
    					ai_reporte_gestion_caso a
						where
    					a.ai_rgc_fec_seg = (select max(ai_rgc_fec_seg) from ai_reporte_gestion_caso b where b.ai_rgc_prog_id = a.ai_rgc_prog_id))  rgc  on rgc.ai_rgc_prog_id=prog.prog_id  WHERE cgf.cas_id = '".$cas_id."' AND (ep.est_prog_id = ".config('constantes.sin_gestionar')." OR ep.est_prog_id = ".config('constantes.pendiente').") AND (rgc.ai_rgc_ter = 0 OR rgc.ai_rgc_ter IS NULL)";

	    $resultado = DB::select($programas);

	    $programas_sin_at = "SELECT
					    	prog.prog_id,
							prog.pro_nom,
							ep.est_prog_nom,
							e.estab_nom,
					    	rgc.ai_rgc_prog_id
						FROM
							ai_programa prog
						INNER JOIN 	
					 		ai_grup_fam_programas gfp on gfp.prog_id=prog.prog_id
						INNER JOIN 
					    	ai_caso_grupo_familiar cgf on cgf.gru_fam_id=gfp.gru_fam_id    
						INNER JOIN 	
					    	ai_estados_programas ep on ep.est_prog_id=gfp.est_prog_id
						LEFT JOIN
					  		ai_establecimientos e on e.estab_id=gfp.estab_id
						LEFT JOIN	
						    (select * from
						    ai_reporte_gestion_caso a
							where
						    a.ai_rgc_fec_seg = (select max(ai_rgc_fec_seg) from ai_reporte_gestion_caso b where b.ai_rgc_prog_id = a.ai_rgc_prog_id)) rgc  on rgc.ai_rgc_prog_id=prog.prog_id
						WHERE
							cgf.cas_id = '".$cas_id."' AND (ep.est_prog_id = ".config('constantes.sin_gestionar')." OR ep.est_prog_id = ".config('constantes.pendiente').") AND (rgc.ai_rgc_ter = 0 OR rgc.ai_rgc_ter IS NULL)";

	    	$resultado_sin_at = DB::select($programas_sin_at);

	    	$result = array_collapse([$resultado,$resultado_sin_at]);

		return $result;
    }

	public static function rptMapaOferta($comunas = null){

		$where_com_id = "";
		if (session()->all()['perfil'] ==  config('constantes.perfil_coordinador')){
			//inicio ch
			$com_id = session()->all()['com_id'];
			//fin ch
		
		}

		if(session()->all()['perfil'] ==  config('constantes.perfil_administrador_central') || session()->all()['perfil'] ==  config('constantes.perfil_coordinador_regional') ){
			if(!is_null($comunas) && trim($comunas) != ''){
				//inicio ch
				$com_id = "({$comunas})";
				//fin ch
			
			}
		}
		//inicio ch
		$sql = "SELECT t2.PRO_NOM,
        CASE WHEN t1.USU_RESP_COM IS NULL THEN 'Sin información' ELSE i.NOM_INS END                                                             AS institucion,
        t2.PRO_CUP,
        CASE WHEN t1.USU_RESP_COM IS NULL THEN 'Sin información' ELSE t4.DIM_NOM END                                                            AS sector,   
        CASE WHEN (t1.PRO_COM_EST = 1) THEN 'SI' ELSE 'NO' END                                                                                  AS disponible,
        CASE WHEN t1.USU_RESP_COM IS NULL THEN 'Sin información' ELSE u.NOMBRES ||' '|| u.APELLIDO_PATERNO ||' '|| u.APELLIDO_MATERNO END       AS Contacto,
        CASE WHEN t8.ale_tip_nom IS NULL THEN 'Sin información' ELSE t8.ale_tip_nom END                                                         AS Tipo_AT,
        CASE WHEN t6.estab_nom IS NULL THEN 'Sin información' ELSE t6.estab_nom END                                                             AS Establecimiento,
        CASE WHEN t6.ESTAB_USU_RESP IS NULL THEN 'Sin información' ELSE ue.NOMBRES ||' '|| ue.APELLIDO_PATERNO ||' '|| ue.APELLIDO_MATERNO END  AS Responsable,
        t2.UPDATED_AT                                                                                                                           AS fecha_actualizacion,
        case when t2.PRO_TIP IS NULL THEN 'Sin Información' when t2.PRO_TIP = 0 THEN 'Local' when t2.PRO_TIP =1 THEN 'Nacional' END             AS Tipo
		from ai_pro_com t1
        left join ai_programa t2 on t2.prog_id = t1.prog_id
        left join ai_comuna t3 on t3.com_id = t1.com_id
        left join ai_dimension t4 on t4.dim_id = t2.dim_id
        left join ai_fuent_de_financ t5 on t5.ID_FUEN_DE_FINANC = t2.ID_FUEN_DE_FINANC
        left join (select a1.prog_id, 
                          a2.estab_id, 
                          a2.estab_nom, 
                          a2.estab_usu_resp
                   from ai_pro_com a1
                   left join ai_establecimientos a2 on a2.prog_id = a1.prog_id
                   where a1.com_id in ".$com_id."
                   and a2.estab_id in ( select estab_id 
                                        from ai_establecimiento_comuna b1 
                                        where b1.com_id in ".$com_id.")) t6 on t6.prog_id = t1.prog_id
        left join ai_programa_alerta_tipo t7 on t7.prog_id = t1.prog_id
        left join ai_alerta_tipo t8 on t8.ale_tip_id = t7.ale_tip_id
        LEFT JOIN ai_usuario ue ON ue.id = t6.estab_usu_resp
        LEFT JOIN ai_usuario u ON t1.USU_RESP_COM = u.id
		LEFT JOIN ai_institucion i ON u.ID_INSTITUCION = i.ID_INS 
		where t1.com_id in ".$com_id." order by PRO_NOM";
		//fin ch
		$resultado = DB::select($sql);

		return $resultado;
	}

	public static function rptMapaOfertaBrecha($comunas = null, $fec_ini = null, $fec_fin = null, $origen=null){

		$where_com_id = $between_fec = "";
		if (session()->all()['perfil'] ==  config('constantes.perfil_coordinador')){
			// INICIO CZ SPRINT 57
			// $where_com_id = " and aioc.com_id = " . session()->all()['com_id'];
			$where_com_id = "comuna.COM_ID = " . session()->all()['com_id'];
			// if($fec_ini != null){
			// 	$between_fec = " AND TRUNC(aibr.fecha_ingreso) BETWEEN TO_DATE('".$fec_ini."') AND TO_DATE('".$fec_fin."')";
			// }
			if($fec_ini != null){
				$between_fec = " AND TRUNC(brecha.fecha_ingreso) BETWEEN TO_DATE('".$fec_ini."') AND TO_DATE('".$fec_fin."')";
			}
			//FIN CZ SPRINT 57
		}

		if(session()->all()['perfil'] ==  config('constantes.perfil_administrador_central') || session()->all()['perfil'] ==  config('constantes.perfil_coordinador_regional') ){
			if(!is_null($comunas) && trim($comunas) != ''){
				// INICIO CZ SPRINT 57
				//$where_com_id = " and aioc.com_id IN ({$comunas}) ";
				$where_com_id = "comuna.COM_ID in (" .$comunas . ")" ;
				// if($fec_ini != null){
				// 	$between_fec = " AND TRUNC(aibr.fecha_ingreso) BETWEEN TO_DATE('".$fec_ini."') AND TO_DATE('".$fec_fin."')";
				// }
				if($fec_ini != null){
					$between_fec = " AND TRUNC(brecha.fecha_ingreso) BETWEEN TO_DATE('".$fec_ini."') AND TO_DATE('".$fec_fin."')";
				}
		
			}
		}

		// $sql = "select distinct
    	// 			aiat.ale_tip_nom,
    	// 			aip.pro_nom,
    	// 			decode(aip.pro_inst_resp,null,'Sin Información', aip.pro_inst_resp) pro_inst_resp,
    	// 			'Sin Información' brecha,
    	// 			'Sin Información' tipo_brecha
		// 		from
    	// 			ai_programa aip
    	// 			left join ai_programa_alerta_tipo aipat on aipat.prog_id = aip.prog_id
    	// 			left join ai_alerta_tipo aiat on aiat.ale_tip_id = aipat.ale_tip_id   
    	// 			left join ai_ofertas aio on aio.prog_id = aip.prog_id
		// 			left join ai_ofertas_comuna aioc on aioc.ofe_id = aio.ofe_id
		// 			left join ai_brecha aibr on aibr.id_programa = aip.prog_id
		// 		where 
		// 			aiat.ale_tip_nom is not null". $where_com_id.$between_fec;



		$sql ="select 
        programa.pro_nom as nombre_programa,
		decode(programa.pro_inst_resp,null,'Sin Información', programa.pro_inst_resp) as institucion,
        decode(aiat.ale_tip_nom,null,'Sin Alerta Territorial', aiat.ale_tip_nom) as alerta,
					DECODE (
						LENGTH (aigf.gru_fam_run || '-' || aigf.gru_fam_dv),
						10,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 6, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 9, 2),
						9,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 5, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 8, 2),
						8,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 3)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 4, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 7, 2),
						7,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 6, 2),
						6,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| '.'
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 5, 2),
						5,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 3)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 4, 2),
						4,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 2)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 3, 2),
						3,    SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 1, 1)
						|| SUBSTR (aigf.gru_fam_run || '-' || aigf.gru_fam_dv, 2, 2)) run,
						comuna.com_nom as comuna
				from
					ai_brecha_integrante_caso aibc
					left join ai_usuario aiu on aiu.id = aibc.id_usuario
					left join ai_grupo_familiar aigf on aigf.gru_fam_id = aibc.id_integrante
					left join ai_alerta_manual aiam on aiam.ale_man_id = aibc.id_alerta_territorial
					left join ai_alerta_manual_tipo aiamt on aiamt.ale_man_id = aiam.ale_man_id
					left join ai_alerta_tipo aiat on aiat.ale_tip_id = aiamt.ale_tip_id
                    INNER JOIN ai_brecha brecha on brecha.id_brecha = aibc.id_brecha
                    inner join ai_brecha_comuna brecha_comuna on brecha_comuna.id_brecha = brecha.id_brecha
                    inner join ai_programa programa on brecha.id_programa = programa.prog_id
                    inner join ai_comuna comuna on comuna.com_id = brecha_comuna.id_comuna
				where aibc.estado = 1 and ".$where_com_id.$between_fec;
				//FIN CZ SPRINT 57

		/*$sql = "select distinct
    				aiat.ale_tip_nom,
    				aip.pro_nom,
    				decode(aip.pro_inst_resp,null,'Sin Información', aip.pro_inst_resp) pro_inst_resp,
    				'Sin Información' brecha,
    				'Sin Información' tipo_brecha
				from
					ai_brecha aibr    
					inner join ai_programa aip on aibr.id_programa = aip.prog_id
					left join ai_programa_alerta_tipo aipat on aipat.prog_id = aip.prog_id
					left join ai_alerta_tipo aiat on aiat.ale_tip_id = aipat.ale_tip_id					
				where 
					aiat.ale_tip_nom is not null".$between_fec;*/

		$resultado = DB::select($sql);
		return $resultado;
	}
}