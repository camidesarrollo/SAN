<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MatrizRangoEtarioProblema extends Model
{
    protected $table 		= 'ai_matriz_rango_etario_prob';
    protected $primaryKey	= 'mat_ran_eta_id';

    public $timestamps		= true;
}
