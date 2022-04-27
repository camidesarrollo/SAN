<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Responsable
 * @package App\Modelos
 */
class Responsable extends Model{
	
	protected $table 		= 'ai_responsable';
	
	protected $primaryKey	= 'res_id';
	
	public $timestamps		= false;
	
	
}