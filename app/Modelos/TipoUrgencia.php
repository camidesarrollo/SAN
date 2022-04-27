<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoUrgencia
 * @package App\Modelos
 */
class TipoUrgencia extends Model{
	
	protected $table 		= 'ai_tipo_urgencia';
	
	protected $primaryKey	= 'tip_urg_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'tip_urg_id',
		'tip_urg_nom',
		'tip_urg_des',
		'tip_urg_tie_max_acc'
	];
	
}