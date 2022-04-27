<?php
namespace App\Modelos;

use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class DatosPersona extends Model
{
	protected $table = 'AI_PERSONA_DATOSPER';
	
	protected $primaryKey  = 'per_id';
	
	public $timestamps = false;
	
	protected $fillable = array(
        'CAS_ID',
        'PER_ID',
        'PER_NOM',
        'PER_PAT',
        'PER_MAT',
        'PER_ANI',
        'PER_MES',
        'PER_SEX'
	);
}
// FIN CZ SPRINT 68
