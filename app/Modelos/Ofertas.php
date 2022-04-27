<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * Class Ofertas
 * @package App\Modelos
 */
class Ofertas extends Model{
	
	protected $table 		= 'ai_ofertas';
	
	protected $primaryKey	= 'ofe_id';
	
	public $timestamps		= true;
	
	protected $fillable		= [
		'ofe_id',
		'ofe_nom',
		'ofe_des',
		'ofe_cup',
		'ofe_tip'
	];

	public function getOfertasAlertaTipo($id){
 		return DB::select("select * from ai_ofertas_alerta_tipo oat 
				inner join ai_alerta_tipo at on oat.ale_tip_id=at.ale_tip_id 
				where oat.ofe_id=11");
	}

    public function getOfertasTipoAlertas($ofe_id = null){
       $sql = "SELECT o.ofe_id, o.ofe_nom, o.ofe_hor_ate, o.ofe_cuo, o.prog_id, pro.pro_nom, dim.dim_nom, LISTAGG (at.ale_tip_nom, ' - ')
                WITHIN GROUP (ORDER BY at.ale_tip_nom) Alertas_Territoriales FROM ai_ofertas o
                LEFT JOIN ai_ofertas_alerta_tipo oat ON o.ofe_id = oat.ofe_id
                LEFT JOIN ai_alerta_tipo at ON oat.ale_tip_id = at.ale_tip_id
                LEFT JOIN ai_programa pro ON o.prog_id = pro.prog_id
                LEFT JOIN ai_dimension dim ON pro.dim_id  = dim.dim_id";
	
       if (!is_null($ofe_id) && $ofe_id != "") $sql .= " WHERE o.ofe_id IN (".implode($ofe_id, ",").")";
       
       $sql .= " GROUP BY o.ofe_id, o.ofe_nom, o.ofe_hor_ate, o.ofe_cuo, o.prog_id, pro.pro_nom, dim.dim_nom";
       
       $respuesta = DB::select($sql);
       
       return $respuesta;
    }

    public function getReportePorPrograma(){
		$msg_defecto = "Sin información";
		$respuesta   = array();
		
		//Obtenemos todos los sectores
		$dimension = DB::select("select * from ai_dimension");
		
		foreach($dimension as $c01 => $v01){
			$respuesta[$v01->dim_nom] = array();
			$programa = DB::select("SELECT * FROM ai_programa p LEFT JOIN ai_pro_com pc ON p.prog_id = pc.prog_id WHERE p.dim_id = ".$v01->dim_id." AND pc.com_id IN (".session()->all()['com_id'].")");
			
			if (count($programa) > 0){
				foreach($programa as $c02 => $v02){
					$respuesta[$v01->dim_nom][$c02] = array($v02->pro_nom => array());
					$prestacion = DB::select("SELECT * FROM ai_ofertas o LEFT JOIN ai_ofertas_comuna oc ON o.ofe_id = oc.ofe_id WHERE o.prog_id = ".$v02->prog_id." AND oc.com_id IN (".session()->all()['com_id'].")");
					
					if (count($prestacion) > 0){
					    foreach ($prestacion as $c03 => $v03){
							$respuesta[$v01->dim_nom][$c02][$v02->pro_nom][$c03] = array ($v03->ofe_nom => array());
					    	$tipo_alerta_territorial = DB::select("SELECT * FROM ai_ofertas_alerta_tipo oat LEFT JOIN ai_alerta_tipo at ON oat.ale_tip_id = at.ale_tip_id WHERE oat.ofe_id = ".$v03->ofe_id);
							
							if (count($tipo_alerta_territorial) > 0){
								foreach ($tipo_alerta_territorial as $c04 => $v04){
									$respuesta[$v01->dim_nom][$c02][$v02->pro_nom][$c03][$v03->ofe_nom][$c04] = $v04->ale_tip_nom;
								}
								
							}else if (count($tipo_alerta_territorial) == 0){ //sin tipo de alerta
								$respuesta[$v01->dim_nom][$c02][$v02->pro_nom][$c03][$v03->ofe_nom][0] = $msg_defecto;
								
							}
						}
						
					}else if (count($prestacion) == 0){ // no ofertas
						$respuesta[$v01->dim_nom][$c02][$v02->pro_nom][0] = array( $msg_defecto => array( 0 => $msg_defecto));
						
					}
					
				}
				
			}else if (count($programa) == 0){ //no programa
				$respuesta[$v01->dim_nom][0][$msg_defecto][0][$msg_defecto][0] = $msg_defecto;
				
			}
		}
		
		return $respuesta;
	}
}