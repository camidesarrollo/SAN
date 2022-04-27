<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class AlertaPriorizadaCaso extends Model
{
    //
    protected $table = 'ai_prio_at_caso_at';
    protected $primaryKey = 'prio_cas_id';
    public $timestamps = false;
}
