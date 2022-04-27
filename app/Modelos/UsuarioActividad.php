<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class UsuarioActividad extends Model
{
    protected $table 		= 'ai_usuario_actividad';
    protected $primaryKey	= 'usu_act_id';

    protected $fillable = array(
        'bit_id',
        'usu_id',
        'act_id'
    );

    public function usuActBit(){
        return $this->belongsTo('App\Modelos\BitacoraComunal', 'bit_id', 'bit_id');
    }

    public function usuActAct(){
        return $this->belongsTo('App\Modelos\Actividad', 'act_id', 'act_id');
    }
}
