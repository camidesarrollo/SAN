<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class PersonaUsuario extends Model
{
	protected $table = 'ai_persona_usuario';
	protected $primaryKey = 'cas_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'usu_id',
		'run',
		'cas_id'
	);
	
	public function getGestorAsignado($usu_id = null, $run = null, $cas_id = null){
	   $sql = "SELECT * FROM ai_persona_usuario pu LEFT JOIN ai_usuario u ON pu.usu_id = u.id WHERE 1 = 1";
	   
	   if (!is_null($usu_id) && $usu_id != "") $sql .= " AND pu.usu_id = ".$usu_id;
	   
	   if (!is_null($run) && $run != "") $sql .= " AND pu.run = ".$run;
	   
	   if (!is_null($cas_id) && $cas_id != "") $sql .= " AND pu.cas_id = ".$cas_id;
	  
	   return DB::select($sql);
	}
}
