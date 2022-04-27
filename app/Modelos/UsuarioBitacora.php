<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class UsuarioBitacora extends Model
{
    protected $table 		= 'ai_usuario_bitacora';
    protected $primaryKey	= 'usu_bit_id';

    protected $fillable = array(
        'bit_id',
        'usu_id',
        'pro_an_id'
    );

    public function bitacorausu(){
        return $this->belongsTo('App\Modelos\BitacoraComunal', 'bit_id', 'bit_id');
    }

    public function procesoanualusu(){
        return $this->belongsTo('App\Modelos\ProcesoAnual', 'pro_an_id', 'pro_an_id');
    }

    public function usuarios(){
        return $this->belongsTo('App\Modelos\Usuarios', 'usu_id','id');
    }
}
