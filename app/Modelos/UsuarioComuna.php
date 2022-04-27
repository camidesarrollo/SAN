<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioComuna extends Model
{
    //
	protected $table = 'ai_usuario_comuna';
	protected $primaryKey = 'usu_com_id';
	public $timestamps = false;
	
	
	public function buscarComunasUsuario($usu_id){
		return DB::select("SELECT uc.usu_id, uc.com_id, c.com_cod FROM ai_usuario_comuna uc RIGHT OUTER JOIN ai_comuna c ON uc.com_id = c.com_id WHERE uc.usu_id = ".$usu_id." ");
	}
	
}
