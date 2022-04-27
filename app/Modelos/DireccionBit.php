<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DireccionBit extends Model
{
    //
    protected $table        = 'ai_direccion_bit';
    protected $primaryKey   = 'dir_bit_id';
    
    protected $fillable		= [
        'act_id',
        'dir_wg_id',
        'com_id',
        'ciudad_id',
        'calle_id',
        'dir_bit_num',
        'dir_bit_dep',
        'dir_bit_block',
        'dir_bit_km',
        'dir_bit_ref'
    ];

    public function actividad(){
        return $this->hasOne('App\Modelos\Actividad', 'act_id', 'act_id');
    }
}
