<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
	protected $table = 'ai_score';
	
	protected $primaryKey = 'sco_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
		'sco_id',
		'sco_dec',
		'sco_sco',
		'cas_id'
	);
	
	public function casos(){
		return $this->belongsTo('App\Modelos\Caso', 'cas_id','cas_id');
	}

}
