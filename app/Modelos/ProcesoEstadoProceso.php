<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProcesoEstadoProceso extends Model
{
    protected $table 		= 'ai_proceso_estado_proceso';
    protected $primaryKey	= 'id_pep';

    protected $fillable = array(
        'est_pro_id',
        'pro_an_id',
		'est_fec_cre'
    );

    public function procesoanual(){
        return $this->belongsTo('App\Modelos\ProcesoAnual', 'pro_an_id', 'pro_an_id');
    }

    public function estadoproceso(){
        return $this->belongsTo('App\Modelos\EstadoProceso', 'est_pro_id', 'est_pro_id');
    }
}
