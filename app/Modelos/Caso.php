<?php
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Modelos\AlertaChileCreceContigo;
use App\Modelos\NNAAlertaManualCaso;
use App\Modelos\EstadoCaso;
use App\Modelos\Terapia;


class Caso extends Model
{
	
	protected $table = 'ai_caso';
	protected $primaryKey = 'cas_id';
	//public $timestamps = false;
	protected $fillable = array(
		//'per_id',
		'cas_nom',
		'cas_des',
		'cas_fec',
		'cas_ori',
		'cas_sco',
		'dim_id',
		'prediagnostico_des_1',
		'prediagnostico_fec_1',
		'prediagnostico_des_2',
		'prediagnostico_fec_2',
		'prediagnostico_des_3',
		'prediagnostico_fec_3',
		'prediagnostico_des_4',
		'prediagnostico_fec_4',
		'prediagnostico_des_5',
		'prediagnostico_fec_5',
		'prediagnostico_des_6',
		'prediagnostico_fec_6',
		'cas_enc_sati',
		'cas_just_rech_coord',
		'fec_just_rech_coord',
		'id_just_rech_coord',
		'cas_comen_desest',
		'cas_comen_desest_fec',
		'cas_can_tar'

	);
	
	// Relaciones
	
	public function caso_estados(){
		return $this->hasMany('App\Modelos\CasoEstado','cas_id','cas_id');
	}
	
	public function terapeutas(){
		return $this->belongsToMany('App\Modelos\Usuarios', 'ai_caso_terapeuta',
			'cas_id', 'ter_id', 'cas_id','id')
			->using('App\Modelos\CasoTerapeuta');
	}
	
	/*public function persona(){
		return $this->belongsTo('App\Modelos\Persona', 'per_id','per_id');
	}*/
	
	public function sesiones(){
		return $this->hasMany('App\Modelos\Sesion','cas_id','cas_id');
	}
	
	public function terceros(){
		return $this->belongsToMany('App\Modelos\Tercero', 'ai_caso_tercero', 'cas_id', 'ter_id', 'cas_id','ter_id')
			->withPivot('cas_ter_fec')
			->latest('cas_ter_fec');
	}
	
	public function estados(){
		return $this->belongsToMany('App\Modelos\EstadoCaso', 'ai_caso_estado_caso', 'cas_id', 'est_cas_id', 'cas_id','est_cas_id')
			->using('App\Modelos\CasoEstado')
			->withPivot('cas_est_cas_fec','cas_est_cas_des')
			->latest('cas_est_cas_fec');
	}
	
	public function scores(){
		return $this->hasMany('App\Modelos\Score','cas_id','cas_id');
	}
	
	// Metodos
	
	public function getConPersonaEstadosByCaso($caso){
		return $this->with('persona','estados')->find($caso);
	}

	//selects

	public function informacionNNAPredictivo($run){
		
		$sql = "SELECT  '' as estado,
						'' as est_pau,
							'' as cas_id,
							'' as fas_id,
							score,
							'' as per_id,
							nombres || ' ' || ap_paterno || ' ' || ap_materno as nombre,
							run || '-' || dv_run as rut,
							run,
							dv_run as dig,
							'' as nacimiento,
							case sexo when '1' then 'Masculino'
							when '2' then 'Femenino' end as sexo,
							edad_agno as edad_ani,
							edad_meses as edad_mes,
							cod_ens,
							cod_gra,
							let_cur,
							nombre_rbd as rbd_nom,
							rbd as rbd_rbd,
							dir_calle_1,
							dir_num_1,
							dir_com_1,
							dir_reg_1,
							dir_fuente_1,
							dir_fecha_ingr_1,
							dir_calle_2,
							dir_num_2,
							dir_com_2,
							dir_reg_2,
							dir_fuente_2,
							dir_fecha_ingr_2,
							dir_calle_3,
							dir_num_3,
							dir_com_3,
							dir_reg_3,
							dir_fuente_3,
							dir_fecha_ingr_3,
							info_nom_contacto_1,
							info_app_contacto_1,
							info_apm_contacto_1,
							info_num_contacto_1,
							info_nom_contacto_2,
							info_app_contacto_2,
							info_apm_contacto_2,
							info_num_contacto_2,
							to_char(FEC_FUE_RBD,'dd/mm/YYYY') as fecha_act,
							FUE_RBD as fuente,
							des_pre_act AS descartado,
							-- INICIO CZ SPRINT 61
							nna_sename as programaSename
							-- FIN CZ SPRINT 61
						FROM ai_predictivo
						WHERE run =".$run." AND rownum = 1";

		return DB::select($sql);
	}

	// INICIO CZ SPRINT 69
	public function informacionNNAPersona($run, $idcaso){
		/*$sql = "SELECT
				cec.est_cas_id AS estado,
				ca.cas_id,
				ca.cas_sco AS score,
				ca.cas_doc_cons as cas_doc_cons,
				pe.per_id,
				pe.per_nom || ' ' || pe.per_pat || ' ' || pe.per_mat AS nombre,
				pe.per_run || '-' || pe.per_dig AS rut,
				pe.per_run AS run,
				pe.per_dig AS dig,
				pe.per_nac AS nacimiento,
				case pe.per_sex when 1 then 'Masculino'
				when 2 then 'Femenino' end AS sexo,
				pe.per_ani AS edad_ani,
				pe.per_mes AS edad_mes,
				pe.per_cod_ens AS cod_ens,
				pe.per_cod_gra AS cod_gra,
				pe.per_gra_let AS let_cur,
				rbd.rbd_nom,
				rbd.rbd_rbd,
				rbd.rbd_dir,
				ai_d.dir_ord,
				ai_d.dir_call,
				ai_d.dir_num,
				ai_d.dir_dep,
				ai_d.dir_des,
				ai_d.com_id,
				ai_c.com_nom,
				ai_c.com_cod,
				ai_p.pro_nom,
				ai_r.reg_nom
				FROM ai_caso ca
				INNER JOIN ai_caso_persona_indice cpi ON ca.cas_id = cpi.cas_id 
				INNER JOIN ai_persona pe ON cpi.per_id = pe.per_id
				INNER JOIN (SELECT * FROM ai_caso_estado_caso
				WHERE cas_est_cas_fec ||'-'|| cas_id IN 
				(SELECT max(cas_est_cas_fec)||'-'|| cas_id FROM ai_caso_estado_caso
				GROUP BY cas_id))cec ON ca.cas_id = cec.cas_id
				LEFT JOIN ai_rbd rbd ON rbd.per_id = pe.per_id
				LEFT JOIN ai_direccion ai_d ON pe.per_id = ai_d.per_id AND ai_d.dir_ord = 1
				LEFT JOIN ai_comuna ai_c ON ai_d.com_id = ai_c.com_id
				LEFT JOIN ai_provincia ai_p ON ai_c.pro_id = ai_p.pro_id
				LEFT JOIN ai_region ai_r ON ai_p.reg_id = ai_r.reg_id
				WHERE pe.per_run = ".$run." AND rownum = 1
				ORDER BY cec.est_cas_id DESC";*/

				//rruiz 05082019 =se modifica query para que siempre traiga el ultimo caso
				// INCIO CZ SPRINT 61
				// $sql = "
				// 		SELECT * FROM (
				// 		SELECT
				// cec.est_cas_id AS estado,
				// ca.cas_id,
				// ca.cas_sco AS score,
				// ca.cas_doc_cons as cas_doc_cons,
				// ca.cas_est_pau as est_pau,
				// to_char(rbd.fec_fue_rbd,'dd/mm/YYYY') as fecha_act,
				// rbd.fue_rbd as fuente,
				// pe.per_id,
				// pe.per_nom || ' ' || pe.per_pat || ' ' || pe.per_mat AS nombre,
				// pe.per_run || '-' || pe.per_dig AS rut,
				// pe.per_run AS run,
				// pe.per_dig AS dig,
				// pe.per_nac AS nacimiento,
				// case pe.per_sex when 1 then 'Masculino'
				// when 2 then 'Femenino' end AS sexo,
				// pe.per_ani AS edad_ani,
				// pe.per_mes AS edad_mes,
				// pe.per_cod_ens AS cod_ens,
				// pe.per_cod_gra AS cod_gra,
				// pe.per_gra_let AS let_cur,
				// rbd.rbd_nom,
				// rbd.rbd_rbd,
				// rbd.rbd_dir,
				// ai_d.dir_ord,
				// ai_d.dir_call,
				// ai_d.dir_num,
				// ai_d.dir_dep,
				// ai_d.dir_des,
				// case when ai_d.com_id = ".session('com_id')." then ai_d.com_id else ".session('com_id')." end AS com_id,
				// ai_d.dir_fue,
				// ai_d.dir_fecha,
				// case when ai_c.com_nom = '".session('comuna')."' then ai_c.com_nom else '".session('comuna')."' end AS com_nom,
				// case when ai_c.com_cod = '".session('com_cod')."' then ai_c.com_cod else '".session('com_cod')."' end AS com_cod,
				// ai_p.pro_nom,
				// ai_r.reg_nom,
				// '0' AS descartado,
				// pre.nna_sename as programasename
				// FROM ai_caso ca
				// INNER JOIN ai_caso_persona_indice cpi ON ca.cas_id = cpi.cas_id 
				// INNER JOIN ai_persona pe ON cpi.per_id = pe.per_id
				// INNER JOIN (SELECT * FROM ai_caso_estado_caso
				// WHERE cas_est_cas_fec ||'-'|| cas_id IN 
				// (SELECT max(cas_est_cas_fec)||'-'|| cas_id FROM ai_caso_estado_caso
				// GROUP BY cas_id))cec ON ca.cas_id = cec.cas_id
				// LEFT JOIN ai_rbd rbd ON rbd.per_id = pe.per_id
				// LEFT JOIN ai_direccion ai_d ON pe.per_id = ai_d.per_id AND ai_d.dir_ord = 1
				// LEFT JOIN ai_comuna ai_c ON ai_d.com_id = ai_c.com_id
				// LEFT JOIN ai_provincia ai_p ON ai_c.pro_id = ai_p.pro_id
				// LEFT JOIN ai_region ai_r ON ai_p.reg_id = ai_r.reg_id
				// LEFT JOIN ai_predictivo pre on pe.per_run = pre.run
				// WHERE pe.per_run = ".$run." 
				// ORDER BY ca.cas_id DESC) WHERE rownum=1";
				// FIN CZ SPRINT 61
				// FIN CZ SPRINT 62 Casos ingresados a ONL
				if($idcaso != 0){
					$sql = "
					SELECT * FROM (
					SELECT
					cec.est_cas_id AS estado,
					ca.cas_id,
					ca.cas_sco AS score,
					ca.cas_doc_cons as cas_doc_cons,
					ca.cas_est_pau as est_pau,
					to_char(rbd.fec_fue_rbd,'dd/mm/YYYY') as fecha_act,
					rbd.fue_rbd as fuente,
					pe.per_id,
					pe.per_nom || ' ' || pe.per_pat || ' ' || pe.per_mat AS nombre,
					pe.per_run || '-' || pe.per_dig AS rut,
					pe.per_run AS run,
					pe.per_dig AS dig,
					pe.per_nac AS nacimiento,
					case pe.per_sex when 1 then 'Masculino'
					when 2 then 'Femenino' end AS sexo,
					pe.per_ani AS edad_ani,
					pe.per_mes AS edad_mes,
					pe.per_cod_ens AS cod_ens,
					pe.per_cod_gra AS cod_gra,
					pe.per_gra_let AS let_cur,
					rbd.rbd_nom,
					rbd.rbd_rbd,
					rbd.rbd_dir,
					ai_d.dir_ord,
					ai_d.dir_call,
					ai_d.dir_num,
					ai_d.dir_dep,
					ai_d.dir_des,
					case when ai_d.com_id = ".session('com_id')." then ai_d.com_id else ".session('com_id')." end AS com_id,
					ai_d.dir_fue,
					ai_d.dir_fecha,
					case when ai_c.com_nom = '".session('comuna')."' then ai_c.com_nom else '".session('comuna')."' end AS com_nom,
					case when ai_c.com_cod = '".session('com_cod')."' then ai_c.com_cod else '".session('com_cod')."' end AS com_cod,
					ai_p.pro_nom,
					ai_r.reg_nom,
					'0' AS descartado,
					pre.nna_sename as programasename
					FROM ai_caso ca
					INNER JOIN ai_caso_persona_indice cpi ON ca.cas_id = cpi.cas_id 
					INNER JOIN ai_persona pe ON cpi.per_id = pe.per_id
					INNER JOIN (SELECT * FROM ai_caso_estado_caso
					WHERE cas_est_cas_fec ||'-'|| cas_id IN 
					(SELECT max(cas_est_cas_fec)||'-'|| cas_id FROM ai_caso_estado_caso
					GROUP BY cas_id))cec ON ca.cas_id = cec.cas_id
					LEFT JOIN ai_rbd rbd ON rbd.per_id = pe.per_id
					LEFT JOIN ai_direccion ai_d ON pe.per_id = ai_d.per_id AND ai_d.dir_ord = 1
					LEFT JOIN ai_comuna ai_c ON ai_d.com_id = ai_c.com_id
					LEFT JOIN ai_provincia ai_p ON ai_c.pro_id = ai_p.pro_id
					LEFT JOIN ai_region ai_r ON ai_p.reg_id = ai_r.reg_id
					LEFT JOIN ai_predictivo pre on pe.per_run = pre.run
					WHERE pe.per_run = ".$run." and ca.cas_id = {$idcaso} 
					ORDER BY ca.cas_id DESC) WHERE rownum=1";
				}else{
				$sql = "
						SELECT * FROM (
						SELECT
				cec.est_cas_id AS estado,
				ca.cas_id,
				ca.cas_sco AS score,
				ca.cas_doc_cons as cas_doc_cons,
				ca.cas_est_pau as est_pau,
				to_char(rbd.fec_fue_rbd,'dd/mm/YYYY') as fecha_act,
				rbd.fue_rbd as fuente,
				pe.per_id,
				pe.per_nom || ' ' || pe.per_pat || ' ' || pe.per_mat AS nombre,
				pe.per_run || '-' || pe.per_dig AS rut,
				pe.per_run AS run,
				pe.per_dig AS dig,
				pe.per_nac AS nacimiento,
				case pe.per_sex when 1 then 'Masculino'
				when 2 then 'Femenino' end AS sexo,
				pe.per_ani AS edad_ani,
				pe.per_mes AS edad_mes,
				pe.per_cod_ens AS cod_ens,
				pe.per_cod_gra AS cod_gra,
				pe.per_gra_let AS let_cur,
				rbd.rbd_nom,
				rbd.rbd_rbd,
				rbd.rbd_dir,
				ai_d.dir_ord,
				ai_d.dir_call,
				ai_d.dir_num,
				ai_d.dir_dep,
				ai_d.dir_des,
				case when ai_d.com_id = ".session('com_id')." then ai_d.com_id else ".session('com_id')." end AS com_id,
				ai_d.dir_fue,
				ai_d.dir_fecha,
				case when ai_c.com_nom = '".session('comuna')."' then ai_c.com_nom else '".session('comuna')."' end AS com_nom,
				case when ai_c.com_cod = '".session('com_cod')."' then ai_c.com_cod else '".session('com_cod')."' end AS com_cod,
				ai_p.pro_nom,
				ai_r.reg_nom,
				'0' AS descartado,
				pre.nna_sename as programasename
				FROM ai_caso ca
				INNER JOIN ai_caso_persona_indice cpi ON ca.cas_id = cpi.cas_id 
				INNER JOIN ai_persona pe ON cpi.per_id = pe.per_id
				INNER JOIN (SELECT * FROM ai_caso_estado_caso
				WHERE cas_est_cas_fec ||'-'|| cas_id IN 
				(SELECT max(cas_est_cas_fec)||'-'|| cas_id FROM ai_caso_estado_caso
				GROUP BY cas_id))cec ON ca.cas_id = cec.cas_id
				LEFT JOIN ai_rbd rbd ON rbd.per_id = pe.per_id
				LEFT JOIN ai_direccion ai_d ON pe.per_id = ai_d.per_id AND ai_d.dir_ord = 1
				LEFT JOIN ai_comuna ai_c ON ai_d.com_id = ai_c.com_id
				LEFT JOIN ai_provincia ai_p ON ai_c.pro_id = ai_p.pro_id
				LEFT JOIN ai_region ai_r ON ai_p.reg_id = ai_r.reg_id
				LEFT JOIN ai_predictivo pre on pe.per_run = pre.run
				WHERE pe.per_run = ".$run." 
				ORDER BY ca.cas_id DESC) WHERE rownum=1";
				}
		return DB::select($sql);
	}
	// FIN CZ SPRINT 69
	public function origen_1($run){
		return DB::select("SELECT
							1  as estado,
							'' as cas_id,
							'' as fas_id,
							score,
							'' as per_id,
							nombres || ' ' || ap_paterno || ' ' || ap_materno as nombre,
							run || '-' || dv_run as rut,
							run,
							dv_run as dig,
							'' as nacimiento,
							case sexo when 1 then 'Masculino'
							when 2 then 'Femenino' end as sexo,
							edad_agno as edad_ani,
							edad_meses as edad_mes,
							cod_ens,
							cod_gra,
							let_cur as gra_let,
							nombre_rbd as rbd_nom,
							rbd as rbd_rbd,
							dir_calle_1,
							dir_num_1,
							dir_com_1,
							dir_reg_1,
							dir_calle_2,
							dir_num_2,
							dir_com_2,
							dir_reg_2,
							dir_calle_3,
							dir_num_3,
							dir_com_3,
							dir_reg_3,
							info_nom_contacto_1,
							info_app_contacto_1,
							info_apm_contacto_1,
							info_num_contacto_1,
							info_nom_contacto_2,
							info_app_contacto_2,
							info_apm_contacto_2,
							info_num_contacto_2
						FROM ai_predictivo
						WHERE run =".$run." AND rownum = 1");
	}
	
	public static function estadoActualCaso($cas_id){
		$sql = "SELECT acec.cas_id, acec.est_cas_id, subquery1.max_fec, acec.id_cec, acec.cas_est_cas_des, acec.adj_id
				FROM ai_caso_estado_caso acec, (SELECT cas_id, max(cas_est_cas_fec) AS max_fec FROM ai_caso_estado_caso
				GROUP BY cas_id) subquery1 WHERE subquery1.cas_id = acec.cas_id AND acec.cas_est_cas_fec = subquery1.max_fec
				AND acec.cas_id= ".$cas_id;

		return DB::select($sql);
	}

	public function documentosPaf(){
		return $this->hasMany('App\Modelos\DocPaf','cas_id','cas_id');
	}

	/*public function origen_2($run){
		return DB::select("select
				cec.est_cas_id as estado,
				ca.cas_id,
				ca.cas_sco as score,
				pe.per_id,
				pe.per_nom || ' ' || pe.per_pat || ' ' || pe.per_mat as nombre,
				pe.per_run || '-' || pe.per_dig as rut,
				pe.per_run as run,
				pe.per_dig as dig,
				pe.per_nac as nacimiento,
				case pe.per_sex when 1 then 'Masculino'
				when 2 then 'Femenino' end as sexo,
				pe.per_ani as edad_ani,
				pe.per_mes as edad_mes,
				pe.per_cod_ens as cod_ens,
				pe.per_cod_gra as cod_gra,
				pe.per_gra_let as gra_let,
				rbd.rbd_nom,
				rbd.rbd_rbd,
				rbd.rbd_dir,
				ai_d.dir_ord,
				ai_d.dir_call,
				ai_d.dir_num,
				ai_d.dir_dep,
				ai_d.dir_des,
				ai_d.com_id,
				ai_c.com_nom,
				ai_p.pro_nom,
				ai_r.reg_nom
				from ai_caso ca
				inner join ai_persona pe on ca.per_id = pe.per_id
				inner join  (select *
				from ai_caso_estado_caso
				where cas_est_cas_fec ||'-'|| cas_id in (
				select  max(cas_est_cas_fec)||'-'|| cas_id
				from ai_caso_estado_caso
				group by cas_id)
				)cec on ca.cas_id = cec.cas_id
				left join ai_rbd rbd on rbd.per_id = pe.per_id
				left join ai_direccion ai_d on pe.per_id = ai_d.per_id AND ai_d.dir_ord = 1
				left join ai_comuna ai_c on ai_d.com_id = ai_c.com_id
				left join ai_provincia ai_p on ai_c.pro_id = ai_p.pro_id
				left join ai_region ai_r on ai_p.reg_id = ai_r.reg_id
				where pe.per_run = ".$run."
				order by cec.est_cas_id desc");
	}*/

	public function informacionNNATerapia($cas_id){

		$sql = "select * from ai_terapia a where a.cas_id = " .$cas_id. " and a.tera_id = (select max(b.tera_id) from ai_terapia b where a.cas_id = b.cas_id )";

		//$sql = "select * from ai_terapia where cas_id=".$cas_id;

		return DB::select($sql);
	}

	// INICIO CZ SPRINT 75 MANTIS 10067
	public static function rptRutAsignadoGestor($tipo_visualizacion, $comunas = null, $fec_ini = null, $fec_fin = null, $tipo = null, $mes = null, $año = null){
		// CZ SPRINT 75
		$where_usuario_id = "";
		$between_fec = "";
		$date_1 = str_replace('/', '-', $fec_ini);
		$date_2 = str_replace('/', '-', $fec_fin);
		$fec_ini_1 = new \DateTime(date('Y-m-d', strtotime($date_1)));
		$fec_fin_1 = new \DateTime(date('Y-m-d', strtotime($date_2)));
		// CZ SPRINT 75
		if ($tipo_visualizacion=='vista'){
			$campos = " vista.RUN,
				vista.NNA_RUN,
				vista.NNA_RUN_CON_FORMATO,
				vista.score,
				vista.n_am alertas_territoriales,
				0 alertas_chcc,
				INITCAP(lower(aic.com_nom)) as com_nom,
				INITCAP(lower(air.reg_nom)) as reg_nom,
				vista.cas_id,
				vista.fec_cre,
				vista.est_cas_nom,
				vista.usuario_nomb,
				caso_creacion";
		}else{
			$campos = " vista.NNA_RUN_CON_FORMATO,
				vista.score,
				vista.n_am alertas_territoriales,
				0 alertas_chcc,
				INITCAP(lower(aic.com_nom)) as com_nom,
				INITCAP(lower(air.reg_nom)) as reg_nom,
				vista.cas_id,
				vista.fec_cre,
				vista.est_cas_nom,
				vista.usuario_nomb,
				caso_creacion";		
		}
		// CZ SPRINT 75
		if($tipo == 1){
			if($mes != null && $año !=  null){
				$between_fec = " AND EXTRACT( MONTH FROM CASO_CREACION) IN (".$mes.") and EXTRACT( YEAR FROM CASO_CREACION) IN (".$año.")";
			}
		}else if($tipo == 2){
			if($fec_ini != null){
				$between_fec = " AND to_number(to_char(CASO_CREACION,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(CASO_CREACION,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";
			}
		}
		// CZ SPRINT 75
		if($fec_ini != null){
			$between_fec = " AND to_number(to_char(CASO_CREACION,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(CASO_CREACION,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";
		}
// CZ SPRINT 77
		if($fec_ini == 0 && $fec_fin == 0 ){
			$between_fec = "";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_gestor')){
			// CZ SPRINT 75
			$where_usuario_id = "  vista.usuario_id = " . session()->all()["id_usuario"] . "and";
			$where_com_id = "  vista.id_com = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			// CZ SPRINT 75
			$where_com_id = "  vista.id_com = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()["perfil"] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				// CZ SPRINT 75
				$where_com_id = "  vista.id_com IN ({$comunas})";				
			}
		}

		$sql = "select 
		".$campos."
		from VW_REPORTES_CASO vista
		left join ai_comuna aic on aic.com_id = vista.id_com  
		left join ai_provincia aip on aip.pro_id = aic.pro_id
		left join ai_region air on air.reg_id = aip.reg_id
		where".
		$where_usuario_id.
		$where_com_id.
		$between_fec.
		" order by vista.score desc";
		
		$registros = DB::select($sql);

		return $registros;

	}
	// FIN CZ SPRINT 75 MANTIS 10067

	public static function rptRutAsignadoTerapeuta($tipo_visualizacion, $comunas = null, $fec_ini = null, $fec_fin = null){

		if ($tipo_visualizacion=='vista'){
			$campos = " vista.RUN,
				vista.NNA_RUN,
				vista.NNA_RUN_CON_FORMATO,
				vista.score,
				vista.n_am alertas_territoriales,
				0 alertas_chcc,
				INITCAP(lower(aic.com_nom)) as com_nom,
				INITCAP(lower(air.reg_nom)) as reg_nom,
				vista.cas_id,
				etb.tera_est_tera_fec,
				vista.est_tera_nom,
				vista.usuario_nomb ";
		}else{//inicio CH
			$campos = " vista.NNA_RUN_CON_FORMATO,
				vista.score,
				vista.n_am alertas_territoriales,
				0 alertas_chcc,
				INITCAP(lower(aic.com_nom)) as com_nom,
				INITCAP(lower(air.reg_nom)) as reg_nom,
				vista.cas_id,
				vista.tera_est_tera_fec,
				est_tera_nom,
				vista.usuario_nomb ";			
		}//Fin CH. Se edita la fila n° 465, borrando etb.est_tera_nom, dejando solo el nombre de la columna, ya que la inicial causaba el problema

		$where_usuario_id = "";
		$where_com_id = "";
		$between_fec = "";

		if($fec_ini != null){
			$between_fec = " AND etb.tera_est_tera_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_terapeuta')){
			$where_usuario_id = " and at.usu_id = " . session()->all()["id_usuario"];
			$where_com_id = " and vista.id_com = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and vista.id_com = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$where_com_id = " and vista.id_com IN ({$comunas})";				
			}
		}


		$sql = "SELECT 
		".$campos."
		FROM vw_ai_nna_am_caso vista
		LEFT JOIN ai_comuna aic ON aic.com_id = vista.id_com  
		LEFT JOIN ai_provincia aip ON aip.pro_id = aic.pro_id
		LEFT JOIN ai_region air ON air.reg_id = aip.reg_id
		LEFT JOIN ai_terapia at on vista.tera_id = at.tera_id
		LEFT JOIN ai_est_terapia_bitacora etb on at.tera_id = etb.tera_id
		WHERE vista.nec_ter = 1 AND vista.est_tera_fin = 0 AND etb.est_tera_id = 3".
		$where_usuario_id.
		$where_com_id.
		$between_fec.
		" ORDER BY vista.score DESC";
		
		$registros = DB::select($sql);
		
		foreach($registros as $casos){
			$terapia = Terapia::where("cas_id", $casos->cas_id)->where("etb.est_tera_id",3)
								->leftJoin("ai_usuario u", "ai_terapia.usu_id","=","u.id")
								->leftJoin("ai_est_terapia_bitacora etb","ai_terapia.tera_id","=","etb.tera_id")->get();
			$casos->usuario_nomb = $terapia[0]->nombres.' '.$terapia[0]->apellido_paterno.' '.$terapia[0]->apellido_materno;
			//$casos->fec_cre = $terapia[0]->tera_est_tera_fec;
		}
		return $registros;

	}

	public static function rptDesestimacionDeCasoGestor($comunas = null, $fec_ini = null, $fec_fin = null,  $año = null, $mes =null){
		$where_usuario_id = "";
		$where_com_id = "";
		$between_fec = "";
		if (session()->all()["perfil"] == config('constantes.perfil_gestor')){
			$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
			$where_com_id = " and ai_usuario_comuna.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and ai_usuario_comuna.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()["perfil"] == config('constantes.perfil_coordinador_regional') ){
			if(!is_null($comunas) && trim($comunas) != ''){
				$where_com_id = " and ai_usuario_comuna.com_id IN ({$comunas})";
			}
		}

		if($fec_ini != null){
			if($mes != null && $año !=  null){
				$between_fec = " AND EXTRACT( MONTH FROM ai_caso.cas_fec) IN (".$mes.") and EXTRACT( YEAR FROM ai_caso.cas_fec) IN (".$año.")";
			}else{
				$date_1 = str_replace('/', '-', $fec_ini);
				$date_2 = str_replace('/', '-', $fec_fin);
				$fec_ini_1 = new \DateTime(date('Y-m-d', strtotime($date_1)));
				$fec_fin_1 = new \DateTime(date('Y-m-d', strtotime($date_2)));
				$between_fec = " AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";	
			}
		}

		$where = $where_com_id . $between_fec . $where_usuario_id;
		// $sql_motivos_desestimacion = "SELECT est_cas_id, est_cas_nom, est_cas_fin FROM ai_estado_caso WHERE est_cas_fin=1 and est_cas_id not in (".config('constantes.egreso_paf').")";
		// $registros_desestimacion = DB::select($sql_motivos_desestimacion);
		// // dd($registros_desestimacion);

		// $sql_gestores = "select * from ai_usuario left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id where ai_usuario.id_perfil = ".config('constantes.perfil_gestor').$where_usuario_id.$where_com_id;

		// $registros_gestores = DB::select($sql_gestores);

		// $array_resultado = array();

		// if (session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
		// 	foreach ($registros_gestores as $gestor){
		// 		$nombre_gestor = $gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno;

		// 		foreach ($registros_desestimacion as $desestimacion){
		// 			// $respuesta = NNAAlertaManualCaso::where('usuario_id',$gestor->id)->where('es_cas_id',$desestimacion->est_cas_id)->where('id_com',$gestor->com_id)
		// 			// ->where(function($query) use ($fec_ini, $fec_fin){
		// 			// 	if($fec_ini != null){
		// 			// 		$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			// 	}					
		// 			// })->count(); 
		// 				// INICIO CZ SPRINT 75 MANTIS 10071
		// 			$respuesta = CasosDesestimados::select('cas_id', DB::raw('count(cas_id) as tota_nna'))
		// 			->where('usuario_id',$gestor->id)->where('es_cas_id',$desestimacion->est_cas_id)
		// 			->where('id_com',$gestor->com_id)
					// ->where(function($query) use ($fec_ini, $fec_fin){
					// 	if($fec_ini != null){
					// 		$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
					// 	}					
		// 			})->groupBy('cas_id')->get();
		// 			// FIN CZ SPRINT 75 MANTIS 10071		

		// 			$array_resultado[$nombre_gestor][$desestimacion->est_cas_nom] = count($respuesta);

		// 		}
		// 	}
		// }else{
		// 	foreach ($registros_gestores as $gestor){
		// 		$nombre_gestor = $gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno;

		// 		foreach ($registros_desestimacion as $desestimacion){
		// 			// CZ SPRINT 77
		// 			$respuesta = CasosDesestimados::select('cas_id', DB::raw('count(cas_id) as tota_nna'))
		// 			->where('usuario_id',$gestor->id)->where('es_cas_id',$desestimacion->est_cas_id)
		// 			->where('id_com',$gestor->com_id)
		// 			->where(function($query) use ($fec_ini, $fec_fin){
		// 				if($fec_ini != null){
		// 					$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 				}					
		// 			})->groupBy('cas_id')->get();

		// 			$array_resultado[$nombre_gestor][$desestimacion->est_cas_nom] = count($respuesta);
		// 		}
		// 	}
		// }

		if(session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()["perfil"] == config('constantes.perfil_coordinador_regional')){
			$sql = "select   
			ai_usuario.nombres || ' ' || ai_usuario.apellido_paterno  || ' ' || ai_usuario.apellido_materno as nombre_gestor,  	
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 9  then 1 end) AS rech_por_fami,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 8  then 1 end) AS desc_gest,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 27  then 1 end) AS direc_incon,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 28  then 1 end) AS direc_desact,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 20  then 1 end) AS program_senam,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 21  then 1 end) AS vulner_derec,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 22  then 1 end) AS medi_protec,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 23  then 1 end) AS fam_no_aplic,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 24  then 1 end) AS fam_inu,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 25  then 1 end) AS fam_rec_oln,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 26  then 1 end) AS fam_renun_oln,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 29  then 1 end) AS dere_cont_del,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 30  then 1 end) AS dere_no_cont_del
				from  ai_caso
					 LEFT JOIN AI_ESTADO_CASO ON ai_caso.est_cas_id = ai_estado_caso.est_cas_id
					 LEFT JOIN (SELECT *
								  FROM ai_caso_estado_caso a
								  WHERE a.cas_est_cas_fec = (SELECT max (cas_est_cas_fec)
															 FROM ai_caso_estado_caso b
															 JOIN AI_CASO C ON C.EST_CAS_ID = B.EST_CAS_ID AND C.CAS_ID = B.CAS_ID
															 WHERE b.cas_id = a.cas_id)) BITACORA_CASO  ON (BITACORA_CASO.CAS_ID = ai_caso.cas_id)
					 LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
					 LEFT JOIN AI_CASO_GRUPO_FAMILIAR ON AI_CASO.CAS_ID = AI_CASO_GRUPO_FAMILIAR.CAS_ID
					 LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
					 LEFT JOIN AI_PERSONA ON ai_persona_usuario.run = AI_PERSONA.PER_RUN
					 LEFT JOIN AI_CASO_PERSONA_INDICE ON AI_PERSONA.PER_ID = AI_CASO_PERSONA_INDICE.PER_ID
					 LEFT JOIN AI_USUARIO_COMUNA ON AI_USUARIO.ID = ai_usuario_comuna.usu_id
					 where est_cas_fin = 1 ".$where."
					GROUP BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno 
					ORDER BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno";
		}else{
			$sql = "select   
			ai_usuario.nombres || ' ' || ai_usuario.apellido_paterno  || ' ' || ai_usuario.apellido_materno as nombre_gestor,  	
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 9  then 1 end) AS rech_por_fami,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 8  then 1 end) AS desc_gest,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 27  then 1 end) AS direc_incon,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 28  then 1 end) AS direc_desact,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 20  then 1 end) AS program_senam,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 21  then 1 end) AS vulner_derec,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 22  then 1 end) AS medi_protec,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 23  then 1 end) AS fam_no_aplic,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 24  then 1 end) AS fam_inu,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 25  then 1 end) AS fam_rec_oln,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 26  then 1 end) AS fam_renun_oln,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 29  then 1 end) AS dere_cont_del,
			COUNT(case when AI_ESTADO_CASO.est_cas_id = 30  then 1 end) AS dere_no_cont_del
				from  ai_caso
					 LEFT JOIN AI_ESTADO_CASO ON ai_caso.est_cas_id = ai_estado_caso.est_cas_id
					 LEFT JOIN (SELECT *
								  FROM ai_caso_estado_caso a
								  WHERE a.cas_est_cas_fec = (SELECT max (cas_est_cas_fec)
															 FROM ai_caso_estado_caso b
															 JOIN AI_CASO C ON C.EST_CAS_ID = B.EST_CAS_ID AND C.CAS_ID = B.CAS_ID
															 WHERE b.cas_id = a.cas_id)) BITACORA_CASO  ON (BITACORA_CASO.CAS_ID = ai_caso.cas_id)
					 LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
					 LEFT JOIN AI_CASO_GRUPO_FAMILIAR ON AI_CASO.CAS_ID = AI_CASO_GRUPO_FAMILIAR.CAS_ID
					 LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
					 LEFT JOIN AI_PERSONA ON ai_persona_usuario.run = AI_PERSONA.PER_RUN
					 LEFT JOIN AI_CASO_PERSONA_INDICE ON AI_PERSONA.PER_ID = AI_CASO_PERSONA_INDICE.PER_ID
					 LEFT JOIN AI_USUARIO_COMUNA ON AI_USUARIO.ID = ai_usuario_comuna.usu_id
					 where est_cas_fin = 1 and ai_caso_persona_indice.per_ind = 1 ".$where."
					GROUP BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno 
					ORDER BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno";
		}

		$sql_consulta =  DB::select($sql);
		return $sql_consulta;
	}

	public static function rptEstadoActividad($comunas = null, $fec_ini = null, $fec_fin = null, $año = null, $mes = null){

		$where_usuario_id = "";
		$where_com_id = "";
		$between_fec = "";
		if (session()->all()["perfil"] == config('constantes.perfil_gestor')){
			$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
			$where_com_id = " and ai_usuario_comuna.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and ai_usuario_comuna.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()["perfil"] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$where_com_id = " and ai_usuario_comuna.com_id IN ({$comunas})";
					}					
					}					

					if($fec_ini != null){
			if($mes != null && $año !=  null){
				$between_fec = " AND EXTRACT( MONTH FROM ai_caso.cas_fec) IN (".$mes.") and EXTRACT( YEAR FROM ai_caso.cas_fec) IN (".$año.")";
			}else{
				$date_1 = str_replace('/', '-', $fec_ini);
				$date_2 = str_replace('/', '-', $fec_fin);
				$fec_ini_1 = new \DateTime(date('Y-m-d', strtotime($date_1)));
				$fec_fin_1 = new \DateTime(date('Y-m-d', strtotime($date_2)));
				$between_fec = " AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";	
					}					
		}

		$where = $where_com_id.$between_fec . $where_usuario_id;
		$sql ="select
		ai_usuario.nombres || ' ' || ai_usuario.apellido_paterno  || ' ' || ai_usuario.apellido_materno as nombre_gestor,  	
		COUNT(case when ai_caso.cas_visit_mod_1 = 1 or ai_caso.cas_visit_mod_2 = 1 or ai_caso.cas_visit_mod_3 = 1 then 1 end) as total_visita_domiciliaria,
		COUNT(case when ai_caso.cas_visit_mod_1 = 2 or ai_caso.cas_visit_mod_2 = 2 or ai_caso.cas_visit_mod_3 = 2 then 1 end) as total_entrevista,
		COUNT(case when ai_caso.cas_visit_mod_1 = 3 or ai_caso.cas_visit_mod_2 = 3 or ai_caso.cas_visit_mod_3 = 3 then 1 end) as total_contacto_telefonico,
		COUNT(case when AI_ESTADO_CASO.est_cas_id = 24  then 1 end) AS fam_inu,
		COUNT(ai_caso.cas_id) AS total_casos
						from  ai_caso
							 LEFT JOIN AI_ESTADO_CASO ON ai_caso.est_cas_id = ai_estado_caso.est_cas_id
							 LEFT JOIN (SELECT *
										  FROM ai_caso_estado_caso a
										  WHERE a.cas_est_cas_fec = (SELECT max (cas_est_cas_fec)
																	 FROM ai_caso_estado_caso b
																	 JOIN AI_CASO C ON C.EST_CAS_ID = B.EST_CAS_ID AND C.CAS_ID = B.CAS_ID
																	 WHERE b.cas_id = a.cas_id)) BITACORA_CASO  ON (BITACORA_CASO.CAS_ID = ai_caso.cas_id)
							 LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
							 LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
							 LEFT JOIN AI_PERSONA ON ai_persona_usuario.run = AI_PERSONA.PER_RUN
							 LEFT JOIN AI_CASO_PERSONA_INDICE ON AI_PERSONA.PER_ID = AI_CASO_PERSONA_INDICE.PER_ID
							 LEFT JOIN AI_USUARIO_COMUNA ON AI_USUARIO.ID = ai_usuario_comuna.usu_id
							 where  ai_caso_persona_indice.per_ind = 1
							 ".$where."
							GROUP BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno 
							ORDER BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno";
		// print_r($sql);
		// die();
		$sql_consulta =  DB::select($sql);
		return 	$sql_consulta;

	}

	public static function rptEstadoAvance($comunas = null, $fec_ini = null, $fec_fin = null, $request_fec_ini = null, $request_fec_fin = null, $año = null, $mes =null){
	
	

		$where_usuario_id 	= "";
		$where_com_id 		= " where ai_usuario_comuna.com_id in (".$comunas.")";
		$id_com 			= "";
		$between_fec = "";
		
		if($fec_ini != null){
			if($mes != null && $año !=  null){
				$between_fec = " AND EXTRACT( MONTH FROM ai_caso.cas_fec) IN (".$mes.") and EXTRACT( YEAR FROM ai_caso.cas_fec) IN (".$año.")";
			}else{
				$date_1 = str_replace('/', '-', $request_fec_ini);
				$date_2 = str_replace('/', '-', $request_fec_fin);
				$fec_ini_1 = new \DateTime(date('Y-m-d', strtotime($fec_ini)));
				$fec_fin_1 = new \DateTime(date('Y-m-d', strtotime($fec_fin)));
				$between_fec = " AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";	
			}
		}

		$where = 	$where_com_id  . $between_fec;


		if (session()->all()["perfil"] == config('constantes.perfil_gestor')){
		 	$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
		}

		$where = 	$where_com_id  . $between_fec . $where_usuario_id ;

		// if ((session()->all()["perfil"] == config('constantes.perfil_coordinador')) || (session()->all()["perfil"] == config('constantes.perfil_super_usuario'))){
		//  	$where_com_id = " and aiuc.com_id = " . session()->all()['com_id'];
		// 	$id_com = session()->all()['com_id'];
		// }

		// if (session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
		// 	if (!is_null($comunas) && trim($comunas) != ""){
		// 		$where_com_id = " and aiuc.com_id IN ({$comunas})";
		// 		$id_com = $comunas;
		// 	}
		// }

		// $sql_gestores = "select * from ai_usuario 
		// left join ai_usuario_comuna aiuc on aiuc.usu_id = ai_usuario.id
		// where ai_usuario.id_perfil = ".config('constantes.perfil_gestor').
		// $where_usuario_id.
		// $where_com_id;

		// $registros_gestores = DB::select($sql_gestores);

		// $array_resultado = array();

		// $pre_diagnostico = EstadoCaso::find(config('constantes.en_prediagnostico'));
		// $diagnostico = EstadoCaso::find(config('constantes.en_diagnostico'));
		// $elaborar_paf = EstadoCaso::find(config('constantes.en_elaboracion_paf'));
		// $ejecucion_paf = EstadoCaso::find(config('constantes.en_ejecucion_paf'));
		// $cierre_paf = EstadoCaso::find(config('constantes.en_cierre_paf'));
		// $seguimiento_paf = EstadoCaso::find(config('constantes.en_seguimiento_paf'));


		// // print_r($sql_gestores  );
		// // die();


		// // iteración para obtener la información fuente del reporte
		// foreach ($registros_gestores as $gestor){

		// 	$casos_asignados = NNAAlertaManualCaso::select('cas_id')->distinct()
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_pre_diagnostico = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_prediagnostico'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');
				
		// 	$casos_diagnostico = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_diagnostico'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_elaborar_paf = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_elaboracion_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_ejecucion_paf = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_ejecucion_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_cierre_paf = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_cierre_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_seguimiento_paf = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.en_seguimiento_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$casos_egresados = NNAAlertaManualCaso::select('cas_id')->distinct()->where('es_cas_id', config('constantes.egreso_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->count('cas_id');

		// 	$total_casos = $casos_pre_diagnostico + $casos_diagnostico + $casos_elaborar_paf + $casos_ejecucion_paf + $casos_cierre_paf + $casos_seguimiento_paf;

		// 	$nna_asignados = NNAAlertaManualCaso::
		// 		where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_pre_diagnostico = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_prediagnostico'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_diagnostico = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_diagnostico'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_elaborar_paf = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_elaboracion_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_ejecucion_paf = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_ejecucion_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_cierre_paf = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_cierre_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$nna_seguimiento_paf = NNAAlertaManualCaso::where('es_cas_id', config('constantes.en_seguimiento_paf'))
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_id')
		// 		->count();

		// 	$total_nna = $nna_pre_diagnostico + $nna_diagnostico + $nna_elaborar_paf + $nna_ejecucion_paf + $nna_cierre_paf + $nna_seguimiento_paf;


		// 	$total_encuesta_satisfaccion = NNAAlertaManualCaso::where('cas_enc_sati','<>', null)
		// 		->where('usuario_id', $gestor->id)
		// 		->whereIn('id_com', explode(',',$id_com))
		// 		->where(function($query) use ($fec_ini, $fec_fin){
		// 			if($fec_ini != null){
		// 				$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
		// 			}					
		// 		})
		// 		->select('cas_enc_sati')->count();

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Cobertura Inicial'] = config('constantes.cobertura_inicial_gestor');

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Casos Asignados']['N° Casos'] = $casos_asignados;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Casos Asignados']['N° NNA'] = $nna_asignados;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$pre_diagnostico->est_cas_id]['N° Casos'] = $casos_pre_diagnostico;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$pre_diagnostico->est_cas_id]['N° NNA'] = $nna_pre_diagnostico;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$diagnostico->est_cas_id]['N° Casos'] = $casos_diagnostico;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$diagnostico->est_cas_id]['N° NNA'] = $nna_diagnostico;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$elaborar_paf->est_cas_id]['N° Casos'] = $casos_elaborar_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$elaborar_paf->est_cas_id]['N° NNA'] = $nna_elaborar_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$ejecucion_paf->est_cas_id]['N° Casos'] = $casos_ejecucion_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$ejecucion_paf->est_cas_id]['N° NNA'] = $nna_ejecucion_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$cierre_paf->est_cas_id]['N° Casos'] = $casos_cierre_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$cierre_paf->est_cas_id]['N° NNA'] = $nna_cierre_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$seguimiento_paf->est_cas_id]['N° Casos'] = $casos_seguimiento_paf;
				
		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno][$seguimiento_paf->est_cas_id]['N° NNA'] = $nna_seguimiento_paf;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Total Atendidos']['N° Casos'] = $total_casos;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Total Atendidos']['N° NNA'] = $total_nna;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['N° de Encuestas de Satisfacción'] = $total_encuesta_satisfaccion;

		// 	$array_resultado[$gestor->nombres.' '.$gestor->apellido_paterno.' '.$gestor->apellido_materno]['Total de Casos Egresados'] = $casos_egresados;


		// }


		$consulta = "select ai_usuario.nombres || ' ' || ai_usuario.apellido_paterno  || ' ' || ai_usuario.apellido_materno as nombre_gestor,  
		COUNT(case when ai_caso_persona_indice.per_ind = 1 then 1 end) AS CANT_CASOS,
		COUNT(case when ai_caso_persona_indice.per_ind = 1 OR ai_caso_persona_indice.per_ind = 0  then 1 end) AS CANT_NNA,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 10 then 1 end) AS CANT_CASOS_PRE_DIAG,
		 COUNT(case when ai_caso.est_cas_id = 10 then 1 end) AS CANT_NNA_PRE_DIAG,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 1 then 1 end) AS CANT_CASOS_DIAG,
		 COUNT(case when  ai_caso.est_cas_id = 1 then 1 end) AS CANT_NNA_DIAG,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 3 then 1 end) AS CANT_CASOS_ELAB_PAF,
		 COUNT(case when ai_caso.est_cas_id = 3 then 1 end) AS CANT_NNA_ELAB_PAF,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 4 then 1 end) AS CANT_CASOS_EJEC_PAF,
		 COUNT(case when ai_caso.est_cas_id = 4 then 1 end) AS CANT_NNA_EJEC_PAF,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 5 then 1 end) AS CANT_CASOS_CIERRE_PAF,
		 COUNT(case when ai_caso.est_cas_id = 5 then 1 end) AS CANT_NNA_CIERRE_PAF,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and ai_caso.est_cas_id = 6 then 1 end) AS CANT_CASOS_SEG_PAF,
		 COUNT(case when ai_caso.est_cas_id = 6 then 1 end) AS CANT_NNA_SEG_PAF,
		 COUNT(case when ai_caso_persona_indice.per_ind = 1 and est_cas_fin <> 1 then 1 end) AS CANT_CASOS_GESTION,
		 COUNT(case when est_cas_fin <> 1 then 1 end) AS CANT_NNA_GESTION,
		 COUNT(case when cas_enc_sati <> NULL then 1 end) AS CANT_ENCUENTA_SATIF,
		 COUNT(case when est_cas_fin <> 0 then 1 end) AS CANT_EGRESADOS
		 from ai_caso
		 LEFT JOIN AI_ESTADO_CASO ON ai_caso.est_cas_id = ai_estado_caso.est_cas_id
		 LEFT JOIN (SELECT *
                      FROM ai_caso_estado_caso a
                      WHERE a.cas_est_cas_fec = (SELECT max (cas_est_cas_fec)
                                                 FROM ai_caso_estado_caso b
                                                 JOIN AI_CASO C ON C.EST_CAS_ID = B.EST_CAS_ID AND C.CAS_ID = B.CAS_ID
                                                 WHERE b.cas_id = a.cas_id)) BITACORA_CASO  ON (BITACORA_CASO.CAS_ID = ai_caso.cas_id)
		 LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
		 LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
		 LEFT JOIN AI_PERSONA ON ai_persona_usuario.run = AI_PERSONA.PER_RUN
		 LEFT JOIN AI_CASO_PERSONA_INDICE ON AI_PERSONA.PER_ID = AI_CASO_PERSONA_INDICE.PER_ID
		 LEFT JOIN AI_USUARIO_COMUNA ON AI_USUARIO.ID = ai_usuario_comuna.usu_id".
		 $where." and ai_usuario.id_perfil = 3
		 GROUP BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno 
		 ORDER BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno";
		$sql_consulta =  DB::select($consulta);
		return 	$sql_consulta;
	}

	public static function rptEstadoSeguimientoCaso($comunas = null, $fec_ini = null, $fec_fin = null, $año = null, $mes = null){

		$where_usuario_id = "";
		$where_com_id = "";
		$between_fec = "";

		if($fec_ini != null){
			$between_fec = " AND aic.cas_est_cas_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_gestor')){
			$where_usuario_id = " and ai_usuario.id = " . session()->all()["id_usuario"];
			$where_com_id = " and AI_USUARIO_COMUNA.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and AI_USUARIO_COMUNA.com_id = " . session()->all()['com_id'];
		}

		if(session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()["perfil"] == config('constantes.perfil_coordinador_regional')){
			if(!is_null($comunas) && trim($comunas != '')){
				$where_com_id = " and AI_USUARIO_COMUNA.com_id IN ({$comunas})"; 				
			}
		}

		if($fec_ini != null){
			if($mes != null && $año !=  null){
				$between_fec = " AND EXTRACT( MONTH FROM ai_caso.cas_fec) IN (".$mes.") and EXTRACT( YEAR FROM ai_caso.cas_fec) IN (".$año.")";
			}else{
				$date_1 = str_replace('/', '-', $fec_ini);
				$date_2 = str_replace('/', '-', $fec_fin);
				$fec_ini_1 = new \DateTime(date('Y-m-d', strtotime($date_1)));
				$fec_fin_1 = new \DateTime(date('Y-m-d', strtotime($date_2)));
				$between_fec = " AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) >= '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_ini_1->format('Y-m-d H:i:s'))))).'000000000'."' AND to_number(to_char(ai_caso.cas_fec,'rrrrmmddhh24missff9')) <=  '".implode("", explode(" ", str_replace(':', '', str_replace('-', '', $fec_fin_1->format('Y-m-d H:i:s'))))).'000000000'."'";	
			}
		}

		$where = $where_usuario_id . $where_com_id . $between_fec;

		$sql = "select ai_usuario.nombres || ' ' || ai_usuario.apellido_paterno  || ' ' || ai_usuario.apellido_materno as nombre_gestor,  	
		COUNT(case when airgc.ai_rgc_mod = 1 then 1 end) as llamadas,
		COUNT(case when airgc.ai_rgc_mod = 2 then 1 end) as visitas,
		COUNT(case when airgc.ai_rgc_mod = 3 then 1 end) as revision,
		COUNT(case when airgc.ai_rgc_mod = 1  or  airgc.ai_rgc_mod = 2 then 1 end) as total,
		casos_egresados.cant_caso as casos_egresados
                                from ai_caso 
							 LEFT JOIN AI_ESTADO_CASO ON ai_caso.est_cas_id = ai_estado_caso.est_cas_id
							 LEFT JOIN (SELECT *
										  FROM ai_caso_estado_caso a
										  WHERE a.cas_est_cas_fec = (SELECT max (cas_est_cas_fec)
																	 FROM ai_caso_estado_caso b
																	 JOIN AI_CASO C ON C.EST_CAS_ID = B.EST_CAS_ID AND C.CAS_ID = B.CAS_ID
																	 WHERE b.cas_id = a.cas_id)) BITACORA_CASO  ON (BITACORA_CASO.CAS_ID = ai_caso.cas_id)
			
							 LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
							 LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
							 LEFT JOIN (SELECT ai_usuario.id,  count( distinct ai_caso.cas_id) as CANT_CASO
							FROM AI_CASO
										LEFT JOIN AI_PERSONA_USUARIO ON ai_caso.cas_id = AI_PERSONA_USUARIO.cas_id
										LEFT JOIN AI_USUARIO ON ai_persona_usuario.usu_id = AI_USUARIO.ID
										LEFT JOIN AI_CASO_PERSONA_INDICE ON ai_caso.CAS_ID =ai_caso_persona_indice.cas_id
										WHERE EST_CAS_ID = 7 
										and ai_caso_persona_indice.per_ind = 1 
										and ai_usuario.id = 81
										GROUP BY AI_USUARIO.ID ) CASOS_EGRESADOS ON AI_USUARIO.ID = CASOS_EGRESADOS.ID                                         
							 LEFT JOIN AI_CASO_PERSONA_INDICE ON ai_caso.CAS_ID =ai_caso_persona_indice.cas_id
							 LEFT JOIN AI_USUARIO_COMUNA ON AI_USUARIO.ID = ai_usuario_comuna.usu_id
							 LEFT JOIN ai_caso_reporte_gestion aicrp ON ai_caso.cas_id = aicrp.cas_id
							Left join ai_reporte_gestion_caso airgc on airgc.ai_rgc_id = aicrp.ai_rgc_id
							 where est_cas_fin = 1  and ai_caso_persona_indice.per_ind = 1   ".$where."
							  GROUP BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno, casos_egresados.cant_caso 
							ORDER BY ai_usuario.nombres,  ai_usuario.apellido_paterno, ai_usuario.apellido_materno"; 

		$sql_consulta =  DB::select($sql);
		return $sql_consulta;

	}

	public static function rptCasosGestionCasosTerapia($comuna = null, $fec_ini = null, $fec_fin = null){

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$comunas = Comuna::where('com_id',session()->all()['com_id'])->get();
		}else{
			$comunas = Comuna::whereIn('com_id', explode(',', $comuna))->get();
		}

		$array_resultado = array();
		foreach ($comunas as $comuna) {
			
			$nna_casos = NNAAlertaManualCaso::where('id_com',$comuna->com_id)
						->select('cas_id')
						->where(function($query) use ($fec_ini, $fec_fin){
							if($fec_ini != null){
								$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
							}					
						})
						->count();

			$familia_casos = NNAAlertaManualCaso::select('cas_id')->distinct()
							->where('id_com',$comuna->com_id)
							->where(function($query) use ($fec_ini, $fec_fin){
								if($fec_ini != null){
									$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
								}					
							})
							->count('cas_id');

			$nna_terapias = NNAAlertaManualCaso::where('id_com',$comuna->com_id)
						->where('ter_id','<>',null)
						->select('cas_id')
						->where(function($query) use ($fec_ini, $fec_fin){
							if($fec_ini != null){
								$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
							}					
						})
						->count();

			$familia_terapias = NNAAlertaManualCaso::select('cas_id')->distinct()
							->where('id_com',$comuna->com_id)
							->where('ter_id','<>',null)
							->where(function($query) use ($fec_ini, $fec_fin){
								if($fec_ini != null){
									$query->whereBetween('cas_est_cas_fec',[$fec_ini,$fec_fin]);
								}					
							})
							->count('cas_id');

			$array_resultado[$comuna->com_nom][$comuna->provincias->regiones->reg_nom]['casos']['Cantidad de RUN'] = $nna_casos;

			$array_resultado[$comuna->com_nom][$comuna->provincias->regiones->reg_nom]['casos']['Cantidad de Familias'] = $familia_casos; 

			$array_resultado[$comuna->com_nom][$comuna->provincias->regiones->reg_nom]['terapias']['Cantidad de RUN'] = $nna_terapias;

			$array_resultado[$comuna->com_nom][$comuna->provincias->regiones->reg_nom]['terapias']['Cantidad de Familias'] = $familia_terapias; 
			
		}

		return collect($array_resultado);

	}

	public static function casoActividadesRealizadas($cas_id){

		$sql = "SELECT * FROM ai_objetivo_paf aop 
				LEFT JOIN ai_obj_tarea_paf aotp ON aop.obj_id = aotp.obj_id
				WHERE aop.cas_id = ".$cas_id." AND aotp.est_tar_id = 3";

		return DB::select($sql);
	}
	// INICIO CZ SPRINT 63 Casos ingresados a ONL
	public static function getCasoGestion($run){

		$sql = "select ai_caso.cas_id from ai_caso 
		left join ai_estado_caso on ai_caso.est_cas_id = ai_estado_caso.est_cas_id 
		left join ai_persona_usuario on ai_caso.cas_id = ai_persona_usuario.cas_id
		where est_cas_fin != 1 and ai_persona_usuario.run = {$run}";

		return DB::select($sql);
	}
	// FIN CZ SPRINT 63 Casos ingresados a ONL
//CZ SPRINT 73
	public static function cantidadCasosNNA($run){
		$sql = DB::select("select count(*) as cantidad from ai_persona per 
		left join ai_caso_persona_indice per_ind on per.per_id = per_ind.per_id
		left join ai_caso cas on per_ind.cas_id = cas.cas_id 
		where per.per_run = {$run}");
		return $sql[0]->cantidad; 
}

	public static function NNcasoGestion($run){
		// $caso = CasoPersonaIndice::leftJoin('ai_persona', 'ai_persona.per_id', '=', 'ai_caso_persona_indice.per_id')->where('ai_persona.per_run','=', $run)->get();
		// $casos_gestion = CasosGestionEgresado::where('run',$run)->where('es_cas_id', '<>',7)->WhereIn('cas_id', $caso)->get();
		$casos_gestion = DB::select("select * from VW_NNA_CASO where RUN = {$run} and ES_CAS_ID <> 7 and CAS_ID in (select ai_caso_persona_indice.cas_id from ai_caso_persona_indice left join ai_persona on  ai_caso_persona_indice.per_id = ai_persona.per_id where ai_persona.per_run = {$run})");
		return $casos_gestion;
	}
	public static function NNAdesetimado($run){
		$sql = DB::select(" select  DISTINCT
        c.cas_id                                           cas_id,
        p.per_run                                              AS run,
        p.per_run || '-' || p.per_dig                        AS nna_run,
       DECODE (
           LENGTH (p.per_run || '-' || p.per_dig),
           16,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 2)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 3, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 6, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 9, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 12, 2)
               || SUBSTR (p.per_run || '-' || p.per_dig, 15, 2),
           15,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 1)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 2, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 5, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 8, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 11, 3)
               || SUBSTR (p.per_run || '-' || p.per_dig, 14, 2),
           10,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 2)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 3, 3)
               || '.'
               || SUBSTR (p.per_run || '-' || p.per_dig, 6, 3)
               || SUBSTR (p.per_run || '-' || p.per_dig, 9, 2),
           9,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 1)
              || '.'
              || SUBSTR (p.per_run || '-' || p.per_dig, 2, 3)
              || '.'
              || SUBSTR (p.per_run || '-' || p.per_dig, 5, 3)
              || SUBSTR (p.per_run || '-' || p.per_dig, 8, 2),
           8,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 3)
              || '.'
              || SUBSTR (p.per_run || '-' || p.per_dig, 4, 3)
              || SUBSTR (p.per_run || '-' || p.per_dig, 7, 2),
           7,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 2)
              || '.'
              || SUBSTR (p.per_run || '-' || p.per_dig, 3, 3)
              || SUBSTR (p.per_run || '-' || p.per_dig, 6, 2),
           6,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 1)
              || '.'
              || SUBSTR (p.per_run || '-' || p.per_dig, 2, 3)
              || SUBSTR (p.per_run || '-' || p.per_dig, 5, 2),
           5,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 3)
              || SUBSTR (p.per_run || '-' || p.per_dig, 4, 2),
           4,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 2)
              || SUBSTR (p.per_run || '-' || p.per_dig, 3, 2),
           3,    SUBSTR (p.per_run || '-' || p.per_dig, 1, 1)
              || SUBSTR (p.per_run || '-' || p.per_dig, 2, 2))
           nna_run_con_formato,
            C.nec_ter,   
            to_char(C.created_at,'dd-mm-yyyy') fec_cre,
            aict.ter_id,
            pdp.per_nom as nna_nom,
           pdp.per_pat as nna_ape_pat,
           pdp.per_nom || ' ' || pdp.per_pat || ' ' || pdp.per_mat AS nna_nombre_completo,
            pc.n_alertas,
            CASE WHEN am.n_am IS NULL THEN 0 ELSE am.n_am END     AS n_am, 
            ec.est_cas_nom                            est_cas_nom,
            CASE WHEN estado_terapia.est_tera_nom IS NULL THEN 'SIN TERAPIA' ELSE estado_terapia.est_tera_nom END AS est_tera_nom,
            c.est_cas_id                                    es_cas_id, 
            ai_comuna.com_cod as COD_COM,
            u.id as USUARIO_ID, 
            u.nombres, 
            u.apellido_paterno,
            u.apellido_materno,
            CASE WHEN  (select ai_usuario.nombres from ai_usuario  where ai_usuario.id = aict.ter_id) IS NULL THEN 'SIN TERAPIA' ELSE  (select ai_usuario.nombres from ai_usuario where ai_usuario.id = aict.ter_id) END AS nombre_ter,
            (select ai_usuario.apellido_paterno from ai_usuario where ai_usuario.id = aict.ter_id) as ap_paterno_ter,
            (select ai_usuario.apellido_materno from ai_usuario where ai_usuario.id = aict.ter_id) as ap_materno_ter,            pc.periodo,
            pc.per_ind, 
            pc.cpi_prioridad                                      score
        from ai_caso c 
        LEFT JOIN ai_caso_comuna ON (ai_caso_comuna.cas_id = c.cas_id)
       LEFT JOIN ai_comuna ON (ai_caso_comuna.com_id = ai_comuna.com_id)
        INNER JOIN ai_estado_caso ec ON (c.est_cas_id = ec.est_cas_id)
        INNER JOIN ai_persona_usuario a ON (c.cas_id = a.cas_id)
        INNER JOIN ai_persona p on (p.per_run = a.run)
        INNER JOIN ai_persona_datosper pdp on (p.per_id = pdp.per_id)
        INNER JOIN ai_usuario u on (a.usu_id = u.id)
        LEFT JOIN ai_caso_terapeuta aict ON (aict.cas_id = c.cas_id)
         LEFT JOIN ai_terapia aiter ON (c.cas_id = aiter.cas_id)
        LEFT JOIN (  SELECT pers.per_run,
                           pers_ind.cpi_prioridad,
                           pers_ind.per_ind,
                           MAX (pers_ind.cas_id)      cas_id,
                           COUNT (pers_ind.cas_id)    n_caso,
                           SUM (pers_ind.cpi_n_alertas) n_alertas,
                           pers_ind.periodo
                      FROM ai_caso_persona_indice pers_ind, ai_persona pers
                     WHERE pers_ind.per_id = pers.per_id
                  GROUP BY pers.per_run, pers_ind.cpi_prioridad, pers_ind.per_ind, pers_ind.periodo) pc ON (a.run = pc.per_run AND pc.cas_id = a.cas_id)
        LEFT JOIN (  SELECT count(a.ale_man_run) as n_am, ps.cas_id
                          FROM ai_alerta_manual a
                            left join ai_caso_alerta_manual ps  on a.ale_man_id = ps.ale_man_id 
                         WHERE a.est_ale_id IN (SELECT est_ale_id
                                                      FROM ai_estado_alerta
                                                     WHERE est_ale_id = 1)                   
                      GROUP BY ps.cas_id) am ON (a.cas_id = am.cas_id)   
         LEFT JOIN (SELECT a.tera_id,
                             a.est_tera_id,
                             tera_est_tera_fec,
                             est_tera_des,
                             est_tera_ini,
                             est_tera_fin,
                             c.est_tera_nom
                            FROM ai_est_terapia_bitacora  a
                           JOIN ai_estado_terapia c ON (a.est_tera_id = c.est_tera_id)
                            WHERE a.tera_est_tera_fec = (SELECT max (tera_est_tera_fec)
                                                 FROM ai_est_terapia_bitacora b
                                                 JOIN ai_terapia D ON D.EST_TERA_ID = B.EST_TERA_ID AND D.TERA_ID= B.TERA_ID
                                                WHERE b.tera_id = a.tera_id)) estado_terapia
                            ON (estado_terapia.tera_id = aiter.tera_id)              
                            WHERE ec.est_cas_fin = 1 and c.cas_id in (select ai_caso_persona_indice.cas_id from ai_caso_persona_indice left join ai_persona on  ai_caso_persona_indice.per_id = ai_persona.per_id where ai_persona.per_run = {$run})");
		return $sql;
				

	}
	//CZ SPRINT 73
}