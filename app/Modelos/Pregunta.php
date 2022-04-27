<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pregunta extends Model
{
    //
	protected $table = 'ai_pregunta';
	protected $primaryKey = 'pre_id';
	public $timestamps = false;
	
	public function dimensionesEncuesta()
	{
		return $this->belongsTo('App\Modelos\DimensionEncuesta', 'dim_enc_id','dim_enc_id');
	}
	
	public function respuestas(){
		
		return $this->hasMany('App\Modelos\Respuesta','pre_id','pre_id')->orderBy('fas_id','asc');
		
	}

	public static function listar_ncfas($cas_id){

			$preguntas = DB::Select("SELECT 
						a.dim_enc_id, b.dim_enc_nom, a.nom_var,fase_uno.pre_id,
						fase_uno.fas_id,fase_uno.alt_id,fase_uno.res_com as comentario_fase_uno,fase_uno.alt_val as alt_val,
						fase_dos.pre_id as fase_dos_pre_id,fase_dos.alt_id as fase_dos_alt_id,fase_dos.res_com as comentario_fase_dos,fase_dos.alt_val as fase_dos_alt_val,
                        fase_tres.pre_id as fase_tres_pre_id,fase_tres.alt_id as fase_tres_alt_id,fase_tres.res_com as comentario_fase_tres,fase_tres.alt_val as fase_tres_alt_val

                        FROM ai_pregunta a
						INNER JOIN ai_dimension_encuesta b on a.dim_enc_id=b.dim_enc_id
						LEFT JOIN 
						(select c.pre_id ,c.cas_id,c.fas_id,c.alt_id,c.res_com,d.alt_val 
						from ai_respuesta c
						LEFT JOIN ai_alternativa d on c.alt_id=d.alt_id   
						where c.fas_id=1 and c.cas_id='".$cas_id."') fase_uno on a.pre_id=fase_uno.pre_id
                        
                        LEFT JOIN 
						(select e.pre_id ,e.cas_id,e.fas_id,e.alt_id,e.res_com,f.alt_val  
						from ai_respuesta e
						left join ai_alternativa f on e.alt_id=f.alt_id   
						where e.fas_id=3 and e.cas_id='".$cas_id."') fase_dos on a.pre_id=fase_dos.pre_id
                        
						LEFT JOIN 
						(select g.pre_id ,g.cas_id,g.fas_id,g.alt_id,g.res_com,h.alt_val  
						from ai_respuesta g
						left join ai_alternativa h on g.alt_id=h.alt_id   
						where g.fas_id=2 and g.cas_id='".$cas_id."') fase_tres on a.pre_id=fase_tres.pre_id
						WHERE nom_var!='Archivo' AND a.dim_enc_id<10 order by a.pre_id");

			$cas = Caso::where("cas_id", "=", $cas_id)->first();


					$array_ncfas = [];

					$array_preg = [];

					$array_fas_uno = [];

					$array_fas_dos = [];

					$array_fas_tres = [];

					$dim_enc_id = 1;

					foreach ($preguntas as $value) {

						if(($value->dim_enc_id==$dim_enc_id)){

							if($value->nom_var!="Comentarios:"){
								array_push($array_preg, 
									array('pre_id'  => $value->pre_id,
										  'nom_var' => $value->nom_var));

								array_push($array_fas_uno, 
									array('pre_id'  => $value->pre_id,
										  'alt_id'  => $value->alt_id,
										  'alt_val' => $value->alt_val));

								array_push($array_fas_dos, 
									array('pre_id'  => $value->fase_dos_pre_id,
										  'alt_id'  => $value->fase_dos_alt_id,
										  'alt_val' => $value->fase_dos_alt_val));

								array_push($array_fas_tres, 
									array('pre_id'  => $value->fase_tres_pre_id,
										  'alt_id'  => $value->fase_tres_alt_id,
										  'alt_val' => $value->fase_tres_alt_val));

								$dim_enc_id = $value->dim_enc_id;
								$dim_enc_nom = $value->dim_enc_nom;

							}else{

								$comentario = $value->comentario_fase_uno;
								$comentario_fase_dos = $value->comentario_fase_dos;
								$comentario_fase_tres = $value->comentario_fase_tres;

							}

						}else{

							array_push($array_ncfas, 
								array(
									'dim_enc_id'   => $dim_enc_id,
									'dim_enc_nom'  => $dim_enc_nom,
									'pregunta'     => $array_preg,
									'res_fase_uno' => $array_fas_uno,
									'res_fase_dos' => $array_fas_dos,
									'res_fase_tres' => $array_fas_tres,
									'comentario'   => $comentario,
									'comentario_fase_dos' => $comentario_fase_dos,
									'comentario_fase_tres' => $comentario_fase_tres,
									'caso_ter'   => $cas->nec_ter
									 ));
							
							$dim_enc_id = $value->dim_enc_id;

							$array_preg = [];

							$array_fas_uno = [];

							$array_fas_dos = [];

							$array_fas_tres = [];

							array_push($array_preg, 
								array('pre_id'  => $value->pre_id,
									  'nom_var' => $value->nom_var));

							array_push($array_fas_uno, 
								array('pre_id'  => $value->pre_id,
									  'alt_id'  => $value->alt_id,
									  'alt_val' => $value->alt_val));

							array_push($array_fas_dos, 
								array('pre_id'  => $value->fase_dos_pre_id,
									  'alt_id'  => $value->fase_dos_alt_id,
									  'alt_val' => $value->fase_dos_alt_val));

							array_push($array_fas_tres, 
								array('pre_id'  => $value->fase_tres_pre_id,
									  'alt_id'  => $value->fase_tres_alt_id,
									  'alt_val' => $value->fase_tres_alt_val));

						}
					}

					return $array_ncfas;
	}



	
}
