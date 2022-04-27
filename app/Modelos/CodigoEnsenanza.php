<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CodigoEnsenanza extends Model
{
	protected $table = 'ai_nivel_ensenanza';
	protected $primaryKey = 'nivel_cod';
	public $timestamps = false;
}
