<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LugarBitacora extends Model
{
    protected $table 		= 'ai_cb_lugar_bit';
    protected $primaryKey	= 'cb_lug_bit_id';

    protected $fillable = array(
		'cb_lug_bit_nom',
		'cb_lug_bit_des',
		'cb_lug_bit_act'
    );
    
    protected static function boot(){
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('cb_lug_bit_nom', 'asc');
		});
	}
}
