<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class AlertaPriorizadaporTipo extends Model
{
    //
    protected $table = 'ai_prio_alertas_casos';
	protected $primaryKey = 'prio_at_id';
}
