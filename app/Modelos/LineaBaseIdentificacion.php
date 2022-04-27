<?php
// INICIO CZ SPRINT 70
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaBaseIdentificacion extends Model
{
    //
    protected $table 		= 'ai_lb_identificacion';	
	protected $primaryKey	= 'iden_id';
    public $incrementing = false;

    protected $fillable = array(
		"iden_id",
        "iden_run",
        "iden_dv",
        "iden_nombre",
        "iden_sexo",
        "iden_edad",
        "iden_fono",
        "iden_correo",
        "iden_internet",
        "iden_electronicos",
        "iden_calle",
        "iden_numero",
        "iden_block",
        "iden_departamento",
        "iden_comuna",
        "iden_pro_an_id",
        "iden_usuario",
        "iden_hogar_nna",
        "iden_hogar_rango_nna"
);
}
// FIN CZ SPRINT 70