<?php
// INICIO CZ SPRINT 70
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaBaseDerechoNinos extends Model
{
    //
    protected $table 		= 'AI_LB_DERECHOS_NINOS';	
	protected $primaryKey	= 'der_id';
    public $incrementing = false;
}
// FIN CZ SPRINT 70