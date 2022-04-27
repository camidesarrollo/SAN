<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * @package App\Modelos
 */
class documentoPlanTerapiaFamiliar extends Model{
	
	protected $table 		= 'ai_doc_fir_pla_ter';
	
	protected $primaryKey	= 'doc_fir_pla_ter_id';
	
	public $timestamps		= false;
	
	protected $fillable		= [
		'doc_fir_pla_ter_id',
		'tera_id',
		'doc_fir_pla_ter_arc',
		'doc_fir_pla_ter_fec'
	];
}