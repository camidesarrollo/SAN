<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * @package App\Modelos
 */
class Categoria extends Model{
	
	protected $table 		= 'ai_categoria';
	
	protected $primaryKey	= 'cat_urg_id';
	
	public $timestamps		= false;
	
	
}