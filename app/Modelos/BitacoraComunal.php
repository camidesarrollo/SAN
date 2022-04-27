<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class BitacoraComunal extends Model
{
    protected $table 		= 'ai_bitacora';
    protected $primaryKey	= 'bit_id';

    protected $fillable = array(
		    'usu_id',
        'pro_an_id',
        'bit_fec_act',
        'bit_tit'
    );

    public function usuariobitacora(){
      return $this->hasOne('App\Modelos\UsuarioBitacora', 'bit_id', 'bit_id');
    }

    public function procesoanual(){
      return $this->belongsTo('App\Modelos\ProcesoAnual', 'pro_an_id', 'pro_an_id');
    }

    public function actividad(){
      return $this->hasMany('App\Modelos\Actividad', 'bit_id', 'bit_id');
    }

    public function direccionbit(){
      return $this->hasOne('App\Modelos\DireccionBit', 'bit_id', 'bit_id');
    }

    public function usuarios(){
      return $this->belongsTo('App\Modelos\Usuarios', 'usu_id','id');
    }


    public static function listarBitacora($pro_id, $bit_id = null){
        $sql = "SELECT ac.act_fec_act, c.cb_tip_act_nom, h.cb_hito_nom, u.nombres, b.bit_id
          FROM ai_bitacora b 
            LEFT JOIN ai_actividad ac ON (ac.bit_id = b.bit_id)
            LEFT JOIN ai_cb_tipo_actor c ON (c.cb_tip_act_id = ac.tip_act_id)
            LEFT JOIN ai_cb_hito h ON (h.cb_hito_id = ac.hito_id)
            LEFT JOIN ai_usuario u ON (u.id = b.usu_id)
          WHERE b.pro_an_id = ({$pro_id}) 
          AND rownum <= 1
        ";
        return DB::select($sql);
    }
}
