<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class BrechaComuna extends Model
{

	protected $table = 'ai_brecha_comuna';
	protected $primaryKey = 'id_brecha_comuna';
	public $timestamps = false;
	
	protected $fillable = [
		'id_brecha',
		'id_comuna'
	];
	
}