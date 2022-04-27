<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class AlertaTipo
 * @package App\Modelos
 */
class AlertaTipo extends Model{
	
	protected $table 		= 'ai_alerta_tipo';
	
	protected $primaryKey	= 'ale_tip_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'ale_tip_id',
		'ale_tip_nom',
		'ale_tip_des'
	];

	public function AlertasTiposReg($id){
		return DB::select("select at.ale_tip_id, at.ale_tip_nom, amt.ale_man_info_rel
			from ai_alerta_manual am
			inner join ai_alerta_manual_tipo amt on am.ale_man_id=amt.ale_man_id  
			inner join ai_alerta_tipo at on amt.ale_tip_id=at.ale_tip_id 
			where am.ale_man_id=".$id);
	}

	public function listadoAlertasTipos(){
		return DB::select("select at.ale_tip_id, at.ale_tip_nom, at.ale_tip_des
			  from ai_alerta_tipo at");

			// return DB::select("select at.ale_tip_id, at.ale_tip_nom,ale_tip_des
			//   from ai_alerta_tipo at 
			//   inner join ai_ofertas_alerta_tipo oat on at.ale_tip_id=oat.ale_tip_id 
			//   inner join ai_ofertas o on oat.ofe_id=o.ofe_id 
			//   inner join ai_ofertas_comuna oc on oc.ofe_id=o.ofe_id 
			//   where oc.com_id in (".$com_cod.")");
	}

	public function listadoOfertasTipos($ids,$cod_com){
		return DB::select("select distinct o.ofe_id, o.ofe_nom from ai_ofertas o 
				inner join ai_ofertas_alerta_tipo oat on o.ofe_id=oat.ofe_id 
				inner join ai_alerta_tipo at on oat.ale_tip_id=at.ale_tip_id
				inner join ai_ofertas_comuna oc on o.ofe_id=oc.ofe_id
				where oat.ale_tip_id in (".$ids.") and oc.com_id=".$cod_com."");
	}

	public function alertaOfertaDos($ofe_id, $ale_man_id, $parent_id, $est_prest_id){

		return DB::insert("INSERT INTO AI_AM_PROGRAMAS
		 		(prog_id,ale_man_id,gru_fam_id,est_prog_id) VALUES('".$ofe_id."','".$ale_man_id."','".$parent_id."',2)");
	}


	public function alertaOferta($ofe_id, $ale_man_id, $parent_id, $est_prest_id){

		$maxId = DB::select("select max(am_ofe_id) as id from AI_AM_OFERTAS");

        $id = $maxId[0]->id+1;

		return DB::insert("INSERT INTO AI_AM_OFERTAS
		 		(ofe_id,ale_man_id,am_ofe_id,gru_fam_id,est_prest_id) VALUES('".$ofe_id."','".$ale_man_id."','".$id."','".$parent_id."','".$est_prest_id."')");
	}

	public function busAlertaOfertaDos($ofe_id,$ale_man_id,$parent_id){
		return DB::select("select * from AI_AM_PROGRAMAS Where prog_id=".$ofe_id." and ale_man_id=".$ale_man_id."and gru_fam_id=".$parent_id."");
	}

	public function busAlertaOferta($ofe_id,$ale_man_id,$parent_id){
		return DB::select("select * from AI_AM_OFERTAS Where ofe_id=".$ofe_id." and ale_man_id=".$ale_man_id."and gru_fam_id=".$parent_id."");
	}


	public function elimAlertaOfertaDos($ofe_id,$ale_man_id,$parent_id){
		return DB::delete("DELETE AI_AM_PROGRAMAS where prog_id=".$ofe_id." and ale_man_id=".$ale_man_id." and gru_fam_id=".$parent_id."");
	}

	public function elimAlertaOferta($ofe_id,$ale_man_id,$parent_id){
		return DB::delete("DELETE AI_AM_OFERTAS where ofe_id=".$ofe_id." and ale_man_id=".$ale_man_id." and gru_fam_id=".$parent_id."");
	}

	public function getIdCom($cod_com){
		return DB::select("select com_id from ai_comuna
				where com_cod=".$cod_com."");
	}

	public function amOfertas($id){
		return DB::select("select ofe_id, ale_man_id from ai_am_ofertas where ale_man_id=".$id."");
	}
	
	public function getReportePorTipoAlerta(){
		$respuesta = array();
		$res01 = $this::all();
		$defecto = "Sin información";
		
		if (count($res01) == 0){
			$respuesta["estado"] = false;
			$respuesta["respuesta"] = "No existen datos para mostrar.";
			
		}else if (count($res01) > 0){
			$respuesta["estado"] = true;
			
			foreach($res01 as $c01 => $v01){
				$respuesta["respuesta"][$c01] = array($res01[$c01]->ale_tip_nom => "");
				
				$res02 = DB::table("ai_ofertas_alerta_tipo oat")->join("ai_ofertas_comuna oc", "oat.ofe_id","=","oc.ofe_id")
					->whereIn("oc.com_id", explode(",", session()->all()["com_id"]))->where("oat.ale_tip_id","=", $res01[$c01]->ale_tip_id)->get();
				
				$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom] = array();
				if (count($res02) > 0){
					foreach($res02 as $c02 => $v02){
						$res03 = DB::table("ai_ofertas o")->join("ai_programa p", "o.prog_id", "=", "p.prog_id")
							->join("ai_dimension d", "p.dim_id", "=", "d.dim_id")->join("ai_usuario u", "o.usu_resp","=", "u.id")
							->join("ai_institucion i", "u.id_institucion", "=", "i.id_ins")->where("o.ofe_id", "=", $v02->ofe_id)->get();
						
						if (count($res03) > 0){
							$ofe_nom     = $defecto;
							$pro_nom     = $defecto;
							$dim_nom     = $defecto;
							$inst_nom    = $defecto;
							$resp_nom    = $defecto;
							$opo_acc     = $defecto;
							$ofe_hor_ate = $defecto;
							$ofe_cup     = $defecto;
							
							foreach ($res03 as $c03 => $v03){
								if ($v03->ofe_nom != "" && isset($v03->ofe_nom)){ //Nombre Prestación
									$ofe_nom = $v03->ofe_nom;
								}
								
								if ($v03->pro_nom != "" && isset($v03->pro_nom)){ // Nombre Programa
									$pro_nom = $v03->pro_nom;
								}
								
								if ($v03->dim_nom != "" && isset($v03->dim_nom)){ //Nombre Sector
									$dim_nom = $v03->dim_nom;
								}
								
								if ($v03->nom_ins != "" && isset($v03->nom_ins)){ //Nombre Institución
									$inst_nom = $v03->nom_ins;
								}
								
								if ($v03->nombres != "" && isset($v03->nombres) && $v03->apellido_paterno != "" && isset($v03->apellido_paterno)
									&& $v03->apellido_materno != "" && isset($v03->apellido_materno)){ //Nombre Responsable
									$resp_nom = $v03->nombres." ".$v03->apellido_paterno." ".$v03->apellido_materno;
								}
								
								if ($v03->ofe_hor_ate != "" && isset($v03->ofe_hor_ate)){ //Horario de Atención
									$ofe_hor_ate = $v03->ofe_hor_ate;
								}
								
								if ($v03->ofe_cup != "" && isset($v03->ofe_cup)){ //Cantidad de Cupos
									$ofe_cup = $v03->ofe_cup;
								}
							}
							
							$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][$c02] = array(
								"ofe_nom"     => $ofe_nom,
								"pro_nom"     => $pro_nom,
								"dim_nom"     => $dim_nom,
								"inst_nom"    => $inst_nom,
								"resp_nom"    => $resp_nom,
								"opo_acc"     => $opo_acc,
								"ofe_hor_ate" => $ofe_hor_ate,
								"ofe_cup"     => $ofe_cup,
							);
						}else if (count($res03) == 0){
							$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][$c02] = array(
								"ofe_nom"     => $defecto,
								"pro_nom"     => $defecto,
								"dim_nom"     => $defecto,
								"inst_nom"    => $defecto,
								"resp_nom"    => $defecto,
								"opo_acc"     => $defecto,
								"ofe_hor_ate" => $defecto,
								"ofe_cup"     => $defecto,
							);
						}
					}
				}else if (count($res02) == 0){
					$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][0] = array(
						"ofe_nom"     => $defecto,
						"pro_nom"     => $defecto,
						"dim_nom"     => $defecto,
						"inst_nom"    => $defecto,
						"resp_nom"    => $defecto,
						"opo_acc"     => $defecto,
						"ofe_hor_ate" => $defecto,
						"ofe_cup"     => $defecto,
					);
				}
			}
		}
		
		return $respuesta;
	}
	
}