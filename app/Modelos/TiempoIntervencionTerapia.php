<?php
// CZ SPRINT 77
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
class TiempoIntervencionTerapia extends Model
{
    protected $table 		= 'AI_TIME_INTER_TERA';
    protected $primaryKey	= 'id_time';
	public $timestamps = false;

	public static function crearTiempoIntervencion($tera_id){
		$maxId = DB::select('select max(id_time)+1 as max from AI_TIME_INTER_TERA');
		$tiempo = new TiempoIntervencionTerapia();
		$tiempo->id_time = $maxId[0]->max;
		$tiempo->tera_id = $tera_id;
		$tiempo->tera_estado = 'A TIEMPO';
		$save = $tiempo->save();
		return $save;
	}
}
