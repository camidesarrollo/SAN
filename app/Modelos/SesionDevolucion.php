<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class SesionDevolucion extends Model
{
	protected $table		= 'ai_ses_dev';
	protected $primaryKey	= 'ses_dev_id';
	protected $fillable		= array('ses_dev_id','cas_id','usu_id');

	public $timestamps		= true;
	
	public function caso(){
		return $this->belongsTo('App\Modelos\Caso', 'cas_id','cas_id');
	}

	/*public function usuario(){
		return $this->belongsTo('App\Modelos\Usuario', 'usu_id','id');
	}*/
	
}