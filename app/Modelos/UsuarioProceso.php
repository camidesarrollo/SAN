<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class UsuarioProceso extends Model
{
    protected $table 		= 'ai_usuario_proceso';
    protected $primaryKey	= 'usu_pro_id';

    protected $fillable = array(
        'usu_id',
        'pro_an_id',
        'usu_pro_per'
    );

    public function procesoanual(){
        return $this->belongsTo('App\Modelos\ProcesoAnual', 'pro_an_id', 'pro_an_id');
    }

    public function usuarios(){
        return $this->belongsTo('App\Modelos\Usuarios', 'usu_id','id');
    }
}
