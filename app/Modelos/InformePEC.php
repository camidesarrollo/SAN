<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class InformePEC extends Model
{
    //
    protected $table 		= 'ai_gc_informe_pec';	
	protected $primaryKey	= 'info_id';
    //CZ SPRINT 73
    public $timestamps = false;
    //CZ SPRINT 73
}
