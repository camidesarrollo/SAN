<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Hito extends Model
{
    protected $table 		= 'ai_cb_hito';
    protected $primaryKey	= 'cb_hito_id';

    protected $fillable = array(
		'cb_hito_nom',
		'cb_hito_des',
		'cb_hito_act'
	);
	
    
    protected static function boot(){
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('cb_hito_nom', 'asc');
		});
	}
}
