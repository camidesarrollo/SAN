<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Respuesta extends Model
{
    //
	protected $table = 'ai_respuesta';
	
	protected $primaryKey = 'res_id';
	public $timestamps = false;
	protected $fillable = array(
		'cas_id',
		'fas_id',
		'pre_id',
		'alt_id',
		'res_com',
		'res_fec',
		'adj_id'
	);
	public function fases()
	{
		return $this->belongsTo('App\Modelos\Fase', 'fas_id','fas_id');
	}
	
	public function casos()
	{
		return $this->belongsTo('App\Modelos\Caso', 'cas_id','cas_id')->withDefault();
	}
	
	public function preguntas()
	{
		return $this->belongsTo('App\Modelos\Pregunta', 'pre_id','pre_id');
	}
	
	public function alternativas()
	{
		return $this->belongsTo('App\Modelos\Alternativa', 'alt_id','alt_id');
	}
	
	public function adjuntos(){
		
		return $this->hasMany('App\Modelos\Adjuntos','adj_id','adj_id');
	}
	
	public static function getRespuestaPreguntaDimension($cas_id = null, $fas_id = null, $pre_id = null, $alt_id = null, $dim_enc_id = null){
		$sql = "SELECT * FROM ai_respuesta r LEFT JOIN ai_pregunta p ON r.pre_id = p.pre_id
				LEFT JOIN ai_alternativa a ON a.alt_id = r.alt_id
				LEFT JOIN ai_fase f ON f.fas_id = r.fas_id
				LEFT JOIN ai_dimension_encuesta de ON p.dim_enc_id = de.dim_enc_id WHERE 1 = 1";
		
		// FILTRO X CASO
		if (!is_null($cas_id) && $cas_id != ""){
			if (is_array($cas_id)){
				$sql .= " AND r.cas_id IN (".implode(',',$cas_id).")";

			}else{
			  	$sql .= " AND r.cas_id = ".$cas_id."";

			}
		}


		// FILTRO X FASE
		if (!is_null($fas_id) && $fas_id != "" && count($fas_id) > 0){
			if (is_array($fas_id)){
				$sql .= " AND r.fas_id IN (".implode(',',$fas_id).")";

			}else{
				$sql .= " AND r.fas_id = ".$fas_id."";

			}
		}
		
		if (!is_null($pre_id) && $pre_id != "" && count($pre_id) > 0) $sql .= " AND r.pre_id IN (".implode(',',$pre_id).")";
		
		if (!is_null($alt_id) && $alt_id != "" && count($alt_id) > 0) $sql .= " AND r.alt_id IN (".implode(',',$alt_id).")";
		
		if (!is_null($dim_enc_id) && $dim_enc_id != "" && count($dim_enc_id) > 0) $sql .= " AND de.dim_enc_id IN (".implode(',',$dim_enc_id).")";


		//INICIO CZ SPRINT 62
			$sql .= " and r.pre_id in (7,18,27,36,44,51,58,67,74)";
		//FIN CZ SPRINT 62
		
		$sql.= " order by dim_enc_nom,alt_val";
		
		return DB::select($sql);
	}

	public static function consultaOriginalNCFAS($cas_id){
		$sql="select * 
				from 
				    ai_respuesta 
				where 
				   cas_id = ".$cas_id." 
				   and pre_id in (select 
				                        pre_id 
				                  from 
				                        ai_pregunta 
				                  where 
				                        dim_enc_id in (select 
				                                             dim_enc_id 
				                                       from 
				                                             ai_dimension_encuesta 
				                                       where 
				                                             dim_enc_id between ".config('constantes.a_entorno')." and ".config('constantes.h_salud_familiar').") 
				                        and pre_tip=".config('constantes.preguntas_nfcfas').") order by pre_id, fas_id";

		$respuesta = DB::select($sql);

		return $respuesta;
	}

	public static function obtenerComentarios($cas_id, $fase){
		$sql = "select r.*,p.dim_enc_id,p.pre_tip,f.fas_nom
					from ai_respuesta r
					inner join ai_pregunta p on p.pre_id = r.pre_id
					inner join ai_fase f on f.fas_id = r.fas_id
					where r.cas_id = ".$cas_id." and p.pre_tip = 2
					and r.fas_id = ".$fase."
					order by r.pre_id , r.fas_id";

		$respuesta = DB::select($sql);

		return $respuesta;
	}

	public static function obtenerArchivos($cas_id, $fase){
		$sql = "select
					r.*,
					p.dim_enc_id,
					p.pre_tip,
					f.fas_nom,
					a.adj_nom,
					a.adj_cod,
					a.adj_id
					from ai_respuesta r
					inner join ai_pregunta p on p.pre_id = r.pre_id
					inner join ai_fase f on f.fas_id = r.fas_id
					inner join ai_adjunto a on r.adj_id = a.adj_id
					where r.cas_id = ".$cas_id." and p.pre_tip = 3
					and r.fas_id = ".$fase."
					order by r.pre_id , r.fas_id";

		$respuesta = DB::select($sql);

		return $respuesta;

	}

	public static function rptRespuestaNcfas(){
		
		$sql = "SELECT
		    air.cas_id caso,
		    t3.com_nom comuna,
		    aif.fas_id fase_id,
		    aif.fas_nom fase_nombre,
		    aide.dim_enc_id dimension_id,
		    aide.dim_enc_nom dimension_nombre,
		    aide.dim_enc_ord dimension_orden,
		    --aide.dim_enc_not nota_de_la_dimension,
		    aip.pre_id pregunta_id,
		    aip.pre_ord pregunta_orden,
		    aip.nom_var pregunta_nombre,
		    aia.ALT_ID alternativa_id,
		    aia.alt_nom alternativa_nombre,
		    aia.alt_ord alternativa_orden,
		    aia.alt_val alternativa_valor
		--   air.res_com comentario
		from
		    ai_respuesta air
		    left join ai_caso t1 on t1.cas_id = air.cas_id
		    left join ai_caso_comuna t2 on t2.cas_id = t1.cas_id
		    left join ai_comuna t3 on t3.com_id = t2.com_id
		    left join ai_fase aif on aif.fas_id = air.fas_id 
		    left join ai_pregunta aip on aip.pre_id = air.pre_id
		    left join ai_alternativa aia on aia.alt_id = air.alt_id
		    left join ai_dimension_encuesta aide on aide.dim_enc_id = aip.dim_enc_id 
		    left join ai_fase aif on aif.fas_id = air.fas_id
		order by air.cas_id,aif.fas_id, aide.dim_enc_ord, aip.pre_ord";

		$resultado = DB::select($sql);
		
		return $resultado;
	}
	
	
}
