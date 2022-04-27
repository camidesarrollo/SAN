<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TipoActor extends Model
{
    protected $table 		= 'ai_cb_tipo_actor';
    protected $primaryKey	= 'cb_tip_act_id';

    protected $fillable = array(
		'cb_tip_act_nom',
		'cb_tip_act_des',
		'cb_tip_act_act'
    );
    
    protected static function boot(){
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('cb_tip_act_nom', 'asc');
		});
	}
}
