<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DescartePredictivo extends Model
{
	protected $table 		= 'ai_descarte_predictivo';
	protected $primaryKey 	= 'des_pre_id';
	public $timestamps 		= false;
	
	protected $fillable = [
		'des_pre_id',
		'run',
		'des_pre_per',
		'des_pre_act',
		'des_pre_com',
		'des_pre_fec'
	];
}