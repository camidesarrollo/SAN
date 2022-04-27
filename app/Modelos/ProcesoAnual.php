<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProcesoAnual extends Model
{
    protected $table 		= 'ai_proceso_anual';
    protected $primaryKey	= 'pro_an_id';

    protected $fillable = array(
        'pro_an_fec',
        'pro_an_nom',
		'com_id'
    );

    public function usuariobitacora(){
        return $this->hasOne('App\Modelos\UsuarioBitacora', 'pro_an_id', 'pro_an_id');
    }

    public function usuarioProceso(){
        return $this->hasMany('App\Modelos\UsuarioProceso', 'pro_an_id');
    }

    public function bitacoracomunal(){
        return $this->hasMany('App\Modelos\BitacoraComunal', 'pro_an_id');
    }

    public function estadoproceso(){
        return $this->belongsTo('App\Modelos\EstadoProceso', 'est_pro_id', 'est_pro_id');
    }

    public static function listarProcesosAnuales(){
        $comuna = session('com_id');
        //INICIO DC
        $sql = "SELECT pa.pro_an_id, pa.pro_an_fec, pa.pro_an_nom, u.nombres ||' '|| u.apellido_paterno ||' '|| u.apellido_materno AS nombre, ep.est_pro_nom FROM ai_proceso_anual pa LEFT JOIN ai_usuario_proceso up ON pa.pro_an_id = up.pro_an_id LEFT JOIN ai_usuario u ON up.usu_id = u.id LEFT JOIN ai_estado_proceso ep ON pa.est_pro_id = ep.est_pro_id WHERE pa.com_id IN ({$comuna})";
        //FIN DC
        $respuesta = DB::select($sql);

        return $respuesta;
    }

}