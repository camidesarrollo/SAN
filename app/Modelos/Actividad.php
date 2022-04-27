<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'ai_actividad';
    protected $primaryKey = 'act_id';
    
    protected $fillable		= [
        'act_id',
        'bit_id',
        'hito_id',
        'act_plan',
        'act_real',
        'act_desc',
        'act_mat_ins',
        'act_obs', 
        'act_fec_act',       
        'lug_bit_id',
        'tip_act_id',
    ];
    
    public function bitacoracomunal(){
      return $this->belongsTo('App\Modelos\BitacoraComunal', 'bit_id', 'bit_id');
    }

    public function hito(){
      return $this->hasMany('App\Modelos\Hito', 'cb_hito_id', 'hito_id');
    }

    public function lugarbitacora(){
      return $this->hasMany('App\Modelos\LugarBitacora', 'cb_lug_bit_id', 'lug_bit_id');
    }

    public function tipoactor(){
      return $this->hasMany('App\Modelos\TipoActor', 'cb_tip_act_id', 'tip_act_id');
    }

    public function direccion(){
      return $this->hasOne('App\Modelos\DireccionBit', 'act_id', 'act_id');
    }
    
}
