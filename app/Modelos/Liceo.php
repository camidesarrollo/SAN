<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Liceo extends Model
{
    //
	protected $table = 'ai_rbd';
	protected $primaryKey = 'rbd_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'rbd_nom',
		'rbd_rbd',
		'rbd_dir',
		'per_id',
		// INICIO CZ SPRINT 68
		'cas_id'
		// FIN CZ SPRINT 68
	);
	
	/*
	public function persona()
	{
		return $this->belongsTo('App\Modelos\Persona');
	}*/
}
