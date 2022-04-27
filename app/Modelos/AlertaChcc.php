<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modelos\Alerta
 *
 * @property-read \App\Modelos\Problematica $problematica
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta problematica($problematica)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modelos\Alerta run($run)
 * @mixin \Eloquent
 */
class AlertaChcc extends Model
{
    //
	protected $table = 'ai_alerta_chcc';
	//protected $primaryKey = 'ale_id';
	//public $timestamps = false;
	
	protected $fillable = [
		'ID_ALERTA',
		'ALERTA',
		'ACCION',
		'ID_ESTADO',
		'ESTADO',
		'ID_NINO',
		'RUN_NINO'
	];
	
}