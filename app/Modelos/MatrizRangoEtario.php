<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MatrizRangoEtario extends Model
{
    protected $table 		= 'ai_matriz_rango_etario';
    protected $primaryKey	= 'mat_ran_eta_id';

    public $timestamps 		= true;
}
