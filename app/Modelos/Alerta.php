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
class Alerta extends Model
{
    //
	protected $table = 'ai_alerta';
	protected $primaryKey = 'ale_id';
	//public $timestamps = false;
	
	protected $fillable = [
		'usu_id',
		'pro_id',
		'ale_run',
		'ale_nom'
	];
	
	public function problematica()
	{
		return $this->belongsTo('App\Modelos\Problematica', 'pro_id','pro_id');
	}
	
	public function scopeRun($query, $run){
		return $query->where('ale_run', $run);
	}
	
	public function scopeProblematica($query, $problematica){
		return $query->where('pro_id', $problematica);
	}
	
	public function verificarProblematica($run, $problematica){
		return $this->run($run)->problematica($problematica)->exists();
	}
}