<?php

namespace App\Modelos;


use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class AlertaChileCreceContigo
 * @package App\Modelos
 */

class AlertaChileCreceContigo extends Model{
	
	protected $table 		= 'AI_ALERTA_CHILE_CRECE_CONTIGO';
	
	protected $primaryKey	= 'ale_chcc_id';
	public $timestamps		= false;
	
	protected $fillable		= [
		'ale_chcc_ind',
		'ale_chcc_run',
		'ale_chcc_pro',
		'ale_chcc_ori',
		'ale_chcc_fec_ing',
		'ale_chcc_en_nom',
		'ale_chcc_cod_com',
		'ale_chcc_est'
	];


	public static function rptDetalleAlertasChcc($origen=null,$comunas=null){

		$where_com_id = $where_id_usu = "";
		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and aic.com_cod = " . session()->all()['com_cod'];
		}

		/*if (session()->all()["perfil"] == config('constantes.perfil_sectorialista')){
			$where_com_id = " and aiam.com_id = " . session()->all()['com_id'];
			$where_id_usu = " and aiam.id_usu = " . session()->all()["id_usuario"];
		}*/

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$com_cod	= array();
				$comunas	= Comuna::find(explode(',', $comunas));
				foreach ($comunas as $k => $v) { array_push($com_cod, $v->com_cod); }
				$com_cod	= implode(',', $com_cod);
			}
			$where_com_id = " and aic.com_cod in ({$com_cod}) ";
		}else{
			$where_com_id = " and aic.com_cod = ".session()->all()['com_cod'];//." and rownum < 100";
		}

		$sql = "
			select
    			aiachcc.ale_chcc_ind,
    			decode(aip.per_nom||' '||aip.per_pat||' '||aip.per_mat,'  ','No en Nómina',null,'No en Nómina',' ','No en Nómina','','No en Nómina',aip.per_nom||' '||aip.per_pat||' '||aip.per_mat) nombre_nna,
    			aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run) nna_run,   
				DECODE (
				               LENGTH (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run)),
				               10,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 2)
				                   || '.'
				                   || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 3, 3)
				                   || '.'
				                   || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 6, 3)
				                   || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 9, 2),
				               9,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 1)
				                  || '.'
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 2, 3)
				                  || '.'
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 5, 3)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 8, 2),
				               8,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 3)
				                  || '.'
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 4, 3)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 7, 2),
				               7,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 2)
				                  || '.'
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 3, 3)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 6, 2),
				               6,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 1)
				                  || '.'
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 2, 3)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 5, 2),
				               5,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 3)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 4, 2),
				               4,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 2)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 3, 2),
				               3,    SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 1, 1)
				                  || SUBSTR (aiachcc.ale_chcc_run||'-'||FN_DV_RUT(aiachcc.ale_chcc_run), 2, 2))
				               nna_run_con_formato,
    			decode(aip.per_ani,null,'No en Nómina',aip.per_ani) per_ani,
    			decode(aip.per_sex,1,'Masculino',2,'Femenino','No en Nómina') ale_man_nna_sexo,
    			decode(aic.com_nom,null,'Sin Información',INITCAP(lower(aic.com_nom))) com_nom,
    			decode(air.reg_nom,null,'Sin Información',INITCAP(lower(air.reg_nom))) reg_nom,
    			'Sin Información' nombre_usuario,
    			'Sin Información' sector,
    			substr(aiachcc.ale_chcc_fec_ing,7,2)||'-'||substr(aiachcc.ale_chcc_fec_ing,5,2)||'-'||substr(aiachcc.ale_chcc_fec_ing,1,4) ale_chcc_fec_ing    
			from
    			ai_alerta_chile_crece_contigo aiachcc
			    left join ai_persona aip on aip.per_run = aiachcc.ale_chcc_run
			    left join ai_comuna aic on aic.com_cod = lpad(aiachcc.ale_chcc_cod_com,5,'0')
			    left join ai_provincia aip on aip.pro_id = aic.pro_id
			    left join ai_region air on air.reg_id = aip.reg_id
			where 1 = 1
    			and aiachcc.ale_chcc_en_nom = 1"
    		.$where_com_id.$where_id_usu;

    	$resultado = DB::select($sql);

		return $resultado;

   
	}
}

