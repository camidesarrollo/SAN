<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Terapeuta extends Model
{
    //
	protected $table = 'ai_terapeuta';
	protected $primaryKey = 'ter_id';
	public $timestamps = false;
	
	protected $fillable = array(
		'ter_cup'
	);
}
