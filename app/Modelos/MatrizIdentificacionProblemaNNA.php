<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MatrizIdentificacionProblemaNNA extends Model
{
    protected $table 		= 'ai_matriz_ide_pro_nna';
    protected $primaryKey	= 'mat_ide_pro_nna_id';

    public $timestamps 		= true;
}
