<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Freshwork\ChileanBundle\Rut;

/**
 * App\Modelos\Alerta
 *
 * @property-read \App\Modelos\Problematica $problematica
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta problematica($problematica)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta run($run)
 * @mixin \Eloquent
 */

class AlertaManual extends Model
{
    //
	protected $table = 'ai_alerta_manual';
	protected $primaryKey = 'ale_man_id';
	public $timestamps = false;
	
	protected $fillable = [
		'ale_man_id',
		'ale_man_run',
		'ale_man_obs',
		'ale_man_fec',
		'id_usu',
		'cat_urg_id',
		'est_ale_id'
	];
	

	public function registroAlertaManual($id){

		return DB::select("
			select 
				at.ale_tip_id, 
				at.ale_tip_nom, 
				am.ale_man_id, 
				am.ale_man_nna_nombre, 
				am.ale_man_run, 
				am.ale_man_obs, 
				am.ale_man_fec, 
				am.id_usu, 
				am.est_ale_id, 
				am.dim_id, 
				am.ale_man_dir_usu, 
				am.ale_man_car_usu, 
				am.ale_man_nna_edad, 
				am.ale_man_nna_fec_nac, 
				am.ale_man_nna_calle, 
				am.ale_man_nna_dir, 
				am.ale_man_nna_nom_cui, 
				am.ale_man_nna_num_cui, 
				am.ale_man_est_edu, 
				am.ale_man_cur, 
				am.ale_man_asi, 
				am.ale_man_ren, 
				am.ale_man_pre, 
				am.ale_man_cen_sal, 
				am.ale_man_ant_rel, 
				am.ale_man_ante_hist_fam, 
				am.ale_man_ante_aspec_fam, 
				am.ale_man_ante_interv_fam, 
				am.ale_man_nna_depto, 
				am.ale_man_nna_block, 
				am.ale_man_nna_casa, 
				am.ale_man_nna_km_sitio, 
				am.ale_man_nna_ref, 
				am.reg_id, 
				am.com_id, 
				am.ale_man_nna_sexo, 
				u.telefono, 
				int.nom_ins, 
				u.run,u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as responsable
			from 
				ai_alerta_manual am 
				inner join ai_alerta_manual_tipo amt on am.ale_man_id=amt.ale_man_id
				inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
				inner join ai_usuario u on u.id=am.id_usu
				inner join ai_institucion int on u.id_institucion=int.id_ins
			where am.ale_man_id=".$id);
	}

	public function regUrgencia($id){
		
		return DB::select("select c.cat_urg_id, c.cat_urg
			from ai_categoria c 
			where c.cat_urg_id=".$id);
	}

	public function categoriaUrgencia(){
		
		return DB::select("select c.cat_urg_id, c.cat_urg
			from ai_categoria c");
	}

	public function listadoAlertasManuales($com_cod, $perfil){
		//dd($com_cod, $perfil);

		/*$sql = "SELECT am.ale_man_id, am.ale_man_run, at.ale_tip_nom, am.ale_man_fec, am.ale_man_obs, u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario, ea.est_ale_nom FROM ai_alerta_manual am LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu 
			WHERE u.id = 5";*/


		$sql = "SELECT am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, am.ale_man_fec, am.ale_man_obs, u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario, ea.est_ale_nom FROM ai_alerta_manual am LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu 
			WHERE u.id = ".Session::get('id_usuario')."";

		return DB::select($sql);

		// Si el perfil de usuario es Sectorialista
		/*if($perfil==5) {
			return DB::select("select at.ale_tip_nom, am.ale_man_id, am.ale_man_run, am.ale_man_obs ,am.ale_man_fec, us.nombres,us.apellido_paterno as apellido, ea.est_ale_nom,
			    CASE WHEN p.score IS NULL THEN 0 ELSE p.score END AS score from ai_predictivo p 
			    inner join ai_alerta_manual am on p.run = am.ale_man_run 
                inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
                inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id
			    inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
			    inner join ai_usuario us on am.id_usu=us.id 
			    where us.id=".Session::get('id_usuario')."");
		}
		// Si el perfil de usuario es Gestor
		elseif($perfil==3){
			//dd("ok");




			return DB::select("select at.ale_tip_nom,am.ale_man_id, am.ale_man_run,am.ale_man_fec, us.nombres,us.apellido_paterno as apellido,ea.est_ale_nom,am.ale_man_obs,
			    CASE WHEN p.score IS NULL THEN 0 ELSE p.score END AS score from ai_predictivo p 
			    inner join ai_alerta_manual am on p.run = am.ale_man_run 
			    inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
                inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id
			    inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
			    inner join ai_usuario us on am.id_usu=us.id");
		}
		// Si el perfil de usuario es Coordinador
		elseif($perfil==2){
			return DB::select("select at.ale_tip_nom,am.ale_man_id, am.ale_man_run,am.ale_man_fec, us.nombres,us.apellido_paterno as apellido,ea.est_ale_nom,am.ale_man_obs,
			    CASE WHEN p.score IS NULL THEN 0 ELSE p.score END AS score from ai_predictivo p 
			    inner join ai_alerta_manual am on p.run = am.ale_man_run 
			    inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
                inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id
			    inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
			    inner join ai_usuario us on am.id_usu=us.id 
			    where p.dir_com_1 in (".$com_cod.") and us.id<>".Session::get('id_usuario')."");
		}*/

	}

	public function misAlertasManuales(){
		return DB::select("select at.ale_tip_nom,am.ale_man_id, am.ale_man_run,am.ale_man_fec, us.nombres,us.apellido_paterno as apellido,ea.est_ale_nom, am.ale_man_obs,
			CASE WHEN p.score IS NULL THEN 0 ELSE p.score END AS score from ai_predictivo p 
			inner join ai_alerta_manual am on p.run = am.ale_man_run 
			inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
            inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id	
			inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
			inner join ai_usuario us on am.id_usu=us.id 
			where us.id=".Session::get('id_usuario')."");
	}

	/**
	 * Método que lista las alertas manuales que pertenecen al NNA
	 * @param $run
	 * @return 
	 */

	// public function alertaManualTipos($cas_id){

	// 	    return DB::select("select p.per_id,p.per_nom||' '||p.per_pat||' '||p.per_mat as persona_nombre,
 //            listagg(at.ale_tip_nom||'*'||ea.est_ale_nom||'*'||u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno||'*'||pf.nombre||'*'||am.ale_man_id||'*'||am.est_ale_id||'*'||u.telefono||'*'||u.email||' - ')
	// 		within group (order by at.ale_tip_nom) as ale_nom
 //            from ai_alerta_manual am
 //            inner join ai_alerta_manual_tipo amt on amt.ale_man_id=am.ale_man_id
 //            inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
 //            inner join ai_persona p on p.per_run=am.ale_man_run
 //            inner join ai_caso_persona_indice cpi on p.per_id=cpi.per_id
 //            inner join ai_estado_alerta ea on ea.est_ale_id=am.est_ale_id
 //            inner join ai_usuario u on u.id=am.id_usu
 //            inner join ai_perfil pf on u.id_perfil=pf.id
 //            where cpi.cas_id=".$cas_id." group by p.per_id,p.per_nom,p.per_pat,p.per_mat");

		// return DB::select("select at.ale_tip_nom,am.ale_man_id, am.ale_man_run,am.ale_man_fec,am.ale_man_obs, almt.ale_tip_id,
		//  	ea.est_ale_nom, u.nombres, u.apellido_paterno,
		//  	u.apellido_materno, per.tipo, am.est_ale_id
		// 	from ai_alerta_manual am 
		// 	inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
		// 	inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id	
		// 	inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
		// 	inner join ai_usuario u on am.id_usu=u.id
		// 	inner join ai_perfil per on per.id=u.id_perfil
		// 	where am.ale_man_run=".$run." order by ale_man_id");
	// }


	// public function alertaManualTiposRes($run){
			
	// 		return DB::select("select at.ale_tip_nom,am.ale_man_id, am.ale_man_run,am.ale_man_fec,am.ale_man_obs, almt.ale_tip_id,
	// 	 	ea.est_ale_nom, u.nombres, u.apellido_paterno,
	// 	 	u.apellido_materno, per.tipo, am.est_ale_id
	// 		from ai_alerta_manual am 
	// 		inner join ai_alerta_manual_tipo almt on am.ale_man_id = almt.ale_man_id 
	// 		inner join ai_alerta_tipo at on almt.ale_tip_id = at.ale_tip_id	
	// 		inner join ai_estado_alerta ea on am.est_ale_id=ea.est_ale_id 
	// 		inner join ai_usuario u on am.id_usu=u.id
	// 		inner join ai_perfil per on per.id=u.id_perfil
	// 		where am.ale_man_run=".$run." order by ale_man_id");

	// }


	/**
	 * Método que lista las alertas manuales que pertenecen al NNA
	 * @param $run
	 * @return 
	 */

	public function alertaManualTipoOfertas($run){
		return DB::select("select distinct(o.ofe_id),o.ofe_nom, oat.ale_tip_id, 
			am.ale_man_id, am.est_ale_id 
			from  ai_ofertas o 
			inner join ai_ofertas_alerta_tipo oat on o.ofe_id = oat.ofe_id 
			inner join ai_alerta_tipo at on at.ale_tip_id = oat.ale_tip_id
			inner join ai_alerta_manual_tipo amt on at.ale_tip_id=amt.ale_tip_id
			inner join ai_alerta_manual am on amt.ale_man_id=am.ale_man_id
			where am.ale_man_run=".$run." order by ale_man_id");
	}
	
	/**
	 * Método que lista las alertas manuales que pertenecen al NNA
	 * @param $run
	 * @param $est_ale_id
	 * @return AlertaManual[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
	 */
	public function listarAlertasManualesNNA($run, $est_ale_id = null, $est_ale_ini = false, $est_ale_fin = false){
		$sql = "SELECT * FROM ai_alerta_manual am LEFT JOIN ai_usuario u ON am.id_usu=u.id
               LEFT JOIN ai_alerta_manual_tipo amt ON amt.ale_man_id=am.ale_man_id
               LEFT JOIN ai_alerta_tipo ta ON amt.ale_tip_id=ta.ale_tip_id
               LEFT JOIN ai_estado_alerta ea ON am.est_ale_id=ea.est_ale_id
               WHERE am.ale_man_run =".$run;
		
		if (count($est_ale_id) > 0 && !empty($est_ale_id)) $sql .= " AND am.est_ale_id IN (".implode($est_ale_id).")";
		
		if ($est_ale_ini) $sql .= " AND ea.est_ale_ini = 1";
		
		if ($est_ale_fin) $sql .= " AND ea.est_ale_fin = 1";
		
		return DB::select($sql);
	}
	
	public function listarOfertasVinculadasAlertas($ale_man_id = null){
		$sql = "SELECT * FROM ai_am_ofertas ao LEFT JOIN ai_ofertas o ON ao.ofe_id = o.ofe_id WHERE 1 = 1";
		
		if (!is_null($ale_man_id) && $ale_man_id != "") $sql .= " AND ao.ale_man_id = ".$ale_man_id;
		
		return DB::select($sql);
		
	}

	public static function rptAlertasTerritorialesPorComuna($comunas = null, $fec_ini = null, $fec_fin = null){

		$where_com_id = $between_fec = "";

		if($fec_ini != null){
			$between_fec = " AND ale_man_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and am.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()['perfil'] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ''){
				$where_com_id = " and am.com_id IN ({$comunas})";				
			}
		}
		//INICIO DC
		$sql = "SELECT 
			INITCAP(lower(comu.com_nom)) com_nom,
			count(am.ale_man_id) total
			from ai_alerta_manual am
			left join ai_comuna comu on comu.com_id = am.com_id
            left join ai_usuario usu on usu.id = am.id_usu
            left join ai_persona per on am.ale_man_run = per.per_run
            left join ai_caso_persona_indice caso_per_in on per.per_id = caso_per_in.per_id 
            where 1 = 1 and usu.id_perfil in (".config('constantes.perfil_sectorialista').") and ale_man_tipo = 1"
            .$where_com_id.$between_fec.
			" GROUP BY comu.com_nom
			order by 2 desc";
        //FIN DC
		$resultado = DB::select($sql);
		
		$com_sql = "SELECT INITCAP(lower(com_nom)) com_nom FROM ai_comuna WHERE com_id IN (".$comunas.")";
		$com_nom = DB::select($com_sql);
		
		foreach($com_nom as $c1 => $comuna){
			$ingresar = true;
			foreach($resultado as $result){
				if($result->com_nom == $comuna->com_nom) $ingresar = false;
			}
			
			if($ingresar){
				
				$com = new \stdClass;
				$com->com_nom = $comuna->com_nom;
				$com->total = 0;
				$n = count($resultado);
				$resultado[$n] = $com;
			}
		}

		return $resultado;
	}

	public static function rptAlertasTerritorialesPorNna($comunas=null, $tip_ale = null, $fec_ini = null, $fec_fin = null){

		$where_com_id = "";
		$where_id_usu = "";
		$where_ale_tip_id = "";
		$between_fec = "";

		if(($tip_ale != null) && ($tip_ale > 0)){
			$where_ale_tip_id = " AND at.ale_tip_id = ".$tip_ale;
		}

		if($fec_ini != null){
			$between_fec = " AND ale_man_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and am.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_sectorialista')){
			$where_com_id = " and am.com_id = " . session()->all()['com_id'];
			$where_id_usu = " and am.id_usu = " . session()->all()["id_usuario"];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$where_com_id = " and am.com_id IN ({$comunas})";	
			}
		}

		/*$sql = "select 
    		ale_tip_nom,
    		count(ale_man_run) total
			from
    		ai_alerta_manual am
			left join ai_alerta_manual_tipo amt on am.ale_man_id = amt.ale_man_id
			left join ai_alerta_tipo at on at.ale_tip_id = amt.ale_tip_id
			left join ai_usuario usu on usu.id = am.id_usu
			where 1 = 1 and usu.id_perfil = ".config('constantes.perfil_sectorialista')
			.$where_com_id.$where_id_usu." group by ale_tip_nom	order by 2 desc";*/
		
		$sql = "select 
    		ale_tip_nom,
    		count(ale_man_run) total
			from
    		ai_alerta_manual am
			left join ai_alerta_manual_tipo amt on am.ale_man_id = amt.ale_man_id
			left join ai_alerta_tipo at on at.ale_tip_id = amt.ale_tip_id
			left join ai_usuario usu on usu.id = am.id_usu
			where 1 = 1 ".$where_com_id.$where_id_usu.$where_ale_tip_id.$between_fec." group by ale_tip_nom	order by 2 desc";
		//dd($sql);
		$resultado = DB::select($sql);

		return $resultado;
	}

	public static function rptAlertasChileCreceContigo($comunas = null){

		$where_com_cod = "";
		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_cod = " and ale_chcc_cod_com = " . session()->all()['com_cod'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_sectorialista')){
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$com_cod	= array();
				$comunas	= Comuna::find(explode(',', $comunas));
				foreach ($comunas as $k => $v) { array_push($com_cod, $v->com_cod); }
				$com_cod	= implode(',', $com_cod);
			}
			$where_com_cod = " and ale_chcc_cod_com in ({$com_cod}) ";
		}else{
			$where_com_cod = " and ale_chcc_cod_com = ".session()->all()['com_cod'];//." and rownum < 100";
		}

		$sql = "select 
			ale_chcc_ind,
			count(ale_chcc_run) total
			from ai_alerta_chile_crece_contigo
			where 1 = 1 and ale_chcc_en_nom = 1
			".$where_com_cod."
			group by ale_chcc_ind
			order by 2 desc";

		$resultado = DB::select($sql);

		return $resultado;
	}

	public static function aleGesPen($cas_id) {
    
    	$alertas = "SELECT
						am.ale_man_id,
						am.ale_man_fec,
						at.ale_tip_nom,
						ea.est_ale_nom,
						p.per_nom||' '||p.per_pat||' '||p.per_mat as integrante,
						u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno as sectorialista
					  from ai_alerta_manual am
                        inner join ai_alerta_manual_tipo amt on amt.ale_man_id=am.ale_man_id
                        inner join ai_alerta_tipo at on at.ale_tip_id=amt.ale_tip_id
                        inner join ai_persona p on p.per_run=am.ale_man_run
                        inner join ai_caso_persona_indice cpi on p.per_id=cpi.per_id
                        inner join ai_estado_alerta ea on ea.est_ale_id=am.est_ale_id
                        left join
                         (select * from
    					ai_reporte_gestion_caso a
						where
                            a.ai_rgc_fec_seg = (select max(ai_rgc_fec_seg) from ai_reporte_gestion_caso b 
                            where b.ai_rgc_ale_man_id = a.ai_rgc_ale_man_id ))
                            rgc on rgc.AI_RGC_ALE_MAN_ID=am.ALE_MAN_ID
                        inner join ai_usuario u on u.id=am.id_usu
					  WHERE  
					  	ea.est_ale_id='1' AND cpi.cas_id='".$cas_id."' and (ai_rgc_id is null OR ai_rgc_ter='0')";


		$resultado = DB::select($alertas);

		return $resultado;

    }

    public static function getTipoAlerta($ale_man_id){

    	$sql = "select 
    				aiat.ale_tip_nom
				from
    				ai_alerta_manual aiam
    				left join ai_alerta_manual_tipo aiamt on aiamt.ale_man_id = aiam.ale_man_id
    				left join ai_alerta_tipo aiat on aiat.ale_tip_id = aiamt.ale_tip_id
				where 
					aiam.ale_man_id = ". $ale_man_id;

		$resultado = DB::select($sql);
		return collect($resultado);

    }

	public static function rptAlertasTerritorialesInfoTipoAlerta($comunas=null, $fec_ini = null, $fec_fin = null, $tip_ale = null, $origen=null){


		$where_com_id = $where_id_usu = $between_fec = $where_ale_tip_id = "";

		if($fec_ini != null){
			$between_fec = " AND ale_man_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}

		if(($tip_ale != null) && ($tip_ale > 0)){
			$where_ale_tip_id = " AND aiat.ale_tip_id = ".$tip_ale;
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and aiam.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_sectorialista')){
			$where_com_id = " and aiam.com_id = " . session()->all()['com_id'];
			$where_id_usu = " and aiam.id_usu = " . session()->all()["id_usuario"];
		}
		
		if (session()->all()['perfil'] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ''){
				$where_com_id = " and aiam.com_id IN ({$comunas})";				
			}
		}
		//INICIO DC
		$sql = "select 
		    		aiat.ale_tip_nom ale_tip_nom, to_char(caso.created_at, 'dd-mm-yyyy') as ale_ing_nomina,
		    		usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno nombre,
		    		to_char(aiam.ale_man_fec,'dd-mm-yyyy') ale_man_fec,
		    		aiam.ale_man_run, cma.com_nom
				from 
		    		ai_alerta_manual aiam
		    		left join ai_alerta_manual_tipo aiamt on aiamt.ale_man_id = aiam.ale_man_id
		    		left join ai_alerta_tipo aiat on aiat.ale_tip_id = aiamt.ale_tip_id
		    		left join ai_usuario usu on usu.id = aiam.id_usu
					left join ai_comuna cma on cma.com_id = aiam.com_id
					left join ai_persona per on aiam.ale_man_run = per.per_run
                    left join ai_caso_persona_indice caso_per_in on per.per_id = caso_per_in.per_id 
					left join ai_caso caso on caso_per_in.cas_id = caso.cas_id					
				where
		    		usu.id_perfil in (".config('constantes.perfil_sectorialista').") and ale_man_tipo = 1"
            	.$where_com_id.$where_id_usu.$where_ale_tip_id.$between_fec;
		//FIN DC
		$resultado = DB::select($sql);

        foreach ($resultado as $alerta) {

        	$ale_man_run = $alerta->ale_man_run; 

        	$rut = $ale_man_run.'-'.Rut::set($ale_man_run)->calculateVerificationNumber();

        	if ($origen=='excel'){
				$alerta->ale_man_run = Rut::parse($rut)->format(); 
			}else{
				$alerta->ale_man_run_sin_formato = $rut;
				$alerta->ale_man_run_con_formato = Rut::parse($rut)->format(); 
			}

        }

		return $resultado;
	}

	public static function rptDetalleAlertasTerritoriales($origen=null, $comunas=null, $fec_ini = null, $fec_fin = null, $tip_ale = null){


		$where_com_id = $where_id_usu = $where_per_sec = $between_fec = $where_ale_tip_id = "";
		
		if($fec_ini != null){
			$between_fec = " AND ale_man_fec BETWEEN '".$fec_ini."' AND '".$fec_fin."'";
		}
		
		if(($tip_ale != null) && ($tip_ale > 0)){
			$where_ale_tip_id = " AND aiat.ale_tip_id = ".$tip_ale;
		}

		if (session()->all()["perfil"] == config('constantes.perfil_coordinador')){
			$where_com_id = " and aiam.com_id = " . session()->all()['com_id'];
		}

		if (session()->all()["perfil"] == config('constantes.perfil_sectorialista')){
			$where_com_id = " and aiam.com_id = " . session()->all()['com_id'];
			$where_id_usu = " and aiam.id_usu = " . session()->all()["id_usuario"];
			$where_per_sec = " and aiu.id_perfil = ".config('constantes.perfil_sectorialista');
		}

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central') || session()->all()['perfil'] == config('constantes.perfil_coordinador_regional')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$where_com_id = " and aiam.com_id IN ({$comunas})";				
			}
		}


		$sql = "SELECT
			    aiat.ale_tip_nom,
			    aiam.ale_man_nna_nombre,
			    aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run) ale_man_run,   
				DECODE (
			       LENGTH (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run)),
			       16,    SUBSTR (aiam.ale_man_run||'-'||'S', 1, 2)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 3, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 6, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 9, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 12, 3)
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 15, 2),
			       15,    SUBSTR (aiam.ale_man_run||'-'||'S', 1, 1)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 2, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 5, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 8, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 11, 3)
			           || SUBSTR (aiam.ale_man_run||'-'||'S', 14, 2),
			       10,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 2)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 3, 3)
			           || '.'
			           || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 6, 3)
			           || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 9, 2),
			       9,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 1)
			          || '.'
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 2, 3)
			          || '.'
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 5, 3)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 8, 2),
			       8,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 3)
			          || '.'
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 4, 3)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 7, 2),
			       7,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 2)
			          || '.'
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 3, 3)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 6, 2),
			       6,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 1)
			          || '.'
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 2, 3)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 5, 2),
			       5,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 3)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 4, 2),
			       4,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 2)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 3, 2),
			       3,    SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 1, 1)
			          || SUBSTR (aiam.ale_man_run||'-'||FN_DV_RUT(aiam.ale_man_run), 2, 2))
			               nna_run_con_formato,
			    aiam.ale_man_nna_edad,
			    decode(aiam.ale_man_nna_sexo,1,'Masculino','Femenino') ale_man_nna_sexo,
			    INITCAP(lower(aic.com_nom)) as com_nom,
			    INITCAP(lower(air.reg_nom)) as reg_nom,
			    aiu.nombres||' '||aiu.apellido_paterno||' '||aiu.apellido_materno nombre_usuario,
			    decode(aid.dim_nom,null,'Sin Información',aid.dim_nom) dim_nom, 
				to_char(aiam.ale_man_fec,'dd-mm-yyyy') fecha,
				inst.nom_ins    
			from
			    ai_alerta_manual aiam
			    left join ai_alerta_manual_tipo aiamt on aiamt.ale_man_id = aiam.ale_man_id
			    left join ai_alerta_tipo aiat on aiat.ale_tip_id = aiamt.ale_tip_id
			    left join ai_dimension aid on aid.dim_id = aiam.dim_id
			    left join ai_usuario aiu on aiu.id = aiam.id_usu
			    left join ai_comuna aic on aic.com_id = aiam.com_id
				left join ai_region air on air.reg_id = aiam.reg_id
				lefT join ai_institucion inst on aiu.id_institucion = inst.id_ins
			    where 1 = 1".$where_per_sec.$where_com_id.$where_id_usu.$where_ale_tip_id.$between_fec;

		$resultado = DB::select($sql);

		return $resultado;
	}

	public static function listarAlertasGestor($cas_id = null){
		$sql = "SELECT am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, 
			am.ale_man_fec, am.ale_man_obs, ea.est_ale_nom, 
			u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario 
			FROM ai_alerta_manual am 
			LEFT JOIN ai_caso_alerta_manual cam ON am.ale_man_id = cam.ale_man_id 
			LEFT JOIN ai_caso c ON cam.cas_id = c.cas_id 
			LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id 
			LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id 
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu WHERE (c.cas_id IN (".$cas_id.") OR am.id_usu = ".session()->all()['id_usuario'].")AND ec.est_cas_fin <> 1 AND am.com_id = ".Session::get('com_id');

		return DB::select($sql);
	}

	public static function ActualizarEstadoAlerta($idAlerta, $estado){
	    $sql = "update ai_alerta_manual set est_ale_id = ".$estado." where ale_man_id = ".$idAlerta;
	    
	    return DB::update($sql);
	}

	public static function HistorialEstadoAlerta($idAlerta, $estado, $nomEstado){
	    $sql = "insert into ai_estado_alerta_manual_estado (est_ale_id, ale_man_id, est_ale_man_est_fec, ale_just_est)
        values(".$estado.", ".$idAlerta.", sysdate, 'Alerta Territorial en estado ".$nomEstado."')";
	    return DB::insert($sql);
	}

	public static function listarAlertasporTipo($cas_id, $ale_tip_id){
		$sql = "SELECT am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, 
			am.ale_man_fec, am.ale_man_obs, ea.est_ale_nom, 
			u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario 
			FROM ai_alerta_manual am 
			LEFT JOIN ai_caso_alerta_manual cam ON am.ale_man_id = cam.ale_man_id 
			LEFT JOIN ai_caso c ON cam.cas_id = c.cas_id 
			LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id 
			LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id 
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu WHERE c.cas_id IN (".$cas_id.") AND at.ale_tip_id = ".$ale_tip_id." AND ec.est_cas_fin <> 1 AND am.com_id = ".Session::get('com_id');

		return DB::select($sql);
	}

	public static function listarAlertasDetectadas($cas_id,$ale_man_id){
		if($ale_man_id != ""){
			$alertas = " AND am.ale_man_id NOT IN (".$ale_man_id.")";
		}else{
			$alertas = "";
		}

		$sql = "SELECT am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, 
			am.ale_man_fec, am.ale_man_obs, ea.est_ale_nom, 
			u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario 
			FROM ai_alerta_manual am 
			LEFT JOIN ai_caso_alerta_manual cam ON am.ale_man_id = cam.ale_man_id 
			LEFT JOIN ai_caso c ON cam.cas_id = c.cas_id 
			LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id 
			LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id 
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu 
			WHERE c.cas_id = ".$cas_id.$alertas." AND ec.est_cas_fin <> 1 AND ea.est_ale_fin <> 1 AND am.com_id = ".Session::get('com_id');

		return DB::select($sql);
	}

	public static function listarAlertasVinculadas($cas_id,$ale_man_id,$dim_id){
		if($ale_man_id != ""){
			$alertas = " AND am.ale_man_id IN (".$ale_man_id.")";
		}else{
			$alertas = "";
		}

		$sql = "SELECT am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, ea.est_ale_nom, 
			u.nombres||' '||u.apellido_paterno||' '||u.apellido_materno AS usuario 
			FROM ai_alerta_manual am 
			LEFT JOIN ai_caso_alerta_manual cam ON am.ale_man_id = cam.ale_man_id 
			LEFT JOIN ai_caso c ON cam.cas_id = c.cas_id 
			LEFT JOIN ai_estado_caso ec ON c.est_cas_id = ec.est_cas_id 
			LEFT JOIN ai_alerta_manual_tipo amt ON am.ale_man_id = amt.ale_man_id 
			LEFT JOIN ai_alerta_tipo at ON at.ale_tip_id = amt.ale_tip_id 
			LEFT JOIN ai_estado_alerta ea ON ea.est_ale_id = am.est_ale_id
			LEFT JOIN ai_usuario u ON u.id = am.id_usu 
			LEFT JOIN ai_am_dimension amd ON amd.cas_id = c.cas_id 
			WHERE c.cas_id = ".$cas_id.$alertas." AND amd.dim_enc_id = ".$dim_id." AND ec.est_cas_fin <> 1 AND am.com_id = ".Session::get('com_id')."
			GROUP BY am.ale_man_id, am.ale_man_run, am.ale_man_nna_nombre, at.ale_tip_nom, ea.est_ale_nom, u.nombres, u.apellido_paterno, u.apellido_materno";
		return DB::select($sql);
	}

	//INICO CZ SPRINT 63 Casos ingresados a ONL
	public static function AlertaSinCaso($run){
		$cas_id = DB::select("select ai_caso.cas_id from ai_caso 
		left join ai_estado_caso on ai_caso.est_cas_id = ai_estado_caso.est_cas_id 
		left join ai_persona_usuario on ai_caso.cas_id = ai_persona_usuario.cas_id
		where est_cas_fin != 1 and ai_persona_usuario.run = {$run}");

		$sql = DB::select("select * from ai_alerta_manual where cas_id is null and ale_man_run = {$run}");
		for($i = 0; $i<count($sql); $i++){
			$update = "update ai_alerta_manual set cas_id = {$cas_id[0]->cas_id} where ALE_MAN_ID = {$sql[$i]->ALE_MAN_ID}";
		}
		DB::commit();
	}
	//FIN CZ SPRINT 63 Casos ingresados a ONL
}
