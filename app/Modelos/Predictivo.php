<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modelos\Region;
use App\Modelos\Comuna;
use App\Modelos\AlertaChileCreceContigo;
use App\Modelos\AlertaManual;

class Predictivo extends Model
{
    //
    protected $table = 'ai_predictivo';
    protected $primaryKey = 'run';
    public $timestamps = false;
	
	public function getNombreCompletoAttribute()
	{
		return "{$this->nombres} {$this->ap_paterno} {$this->ap_materno}";
	}
	
	public function getByRutExterno($run){
		$run_dv = limpiarRut($run);
		$rut = preg_replace('/[^0-9]/','',$run_dv[0]);
		
		$persona = $this->find($rut, ['run','nombres','ap_paterno','ap_materno','dir_com_1','dv_run','sexo','fecha_nac','edad_agno','edad_meses','info_nom_contacto_1','info_num_contacto_1','dir_calle_1','dir_num_1','dir_reg_1']);
		
		if (!is_null($persona)){
			$persona = $persona->setAppends(['nombre_completo']);
		}
		
		return $persona;
	}

	public static function rptPrioridadAlerta($origen=null, $comunas = null){

		$sql_predictivo = "select 
								run, 
								dv_run, 
								edad_agno, 
								score, 
								sexo, 
								dir_reg_1, 
								dir_com_1,
								decode (
									length (run || '-' || dv_run),
									16,    substr (run || '-' || dv_run, 1, 2)
									|| '.'
									|| substr (run || '-' || dv_run, 3, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 6, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 9, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 12, 3)
									|| substr (run || '-' || dv_run, 15, 2),
									15,    substr (run || '-' || dv_run, 1, 1)
									|| '.'
									|| substr (run || '-' || dv_run, 2, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 5, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 8, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 11, 3)
									|| substr (run || '-' || dv_run, 14, 2),
									10,    substr (run || '-' || dv_run, 1, 2)
									|| '.'
									|| substr (run || '-' || dv_run, 3, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 6, 3)
									|| substr (run || '-' || dv_run, 9, 2),
									9,    substr (run || '-' || dv_run, 1, 1)
									|| '.'
									|| substr (run || '-' || dv_run, 2, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 5, 3)
									|| substr (run || '-' || dv_run, 8, 2),
									8,    substr (run || '-' || dv_run, 1, 3)
									|| '.'
									|| substr (run || '-' || dv_run, 4, 3)
									|| substr (run || '-' || dv_run, 7, 2),
									7,    substr (run || '-' || dv_run, 1, 2)
									|| '.'
									|| substr (run || '-' || dv_run, 3, 3)
									|| substr (run || '-' || dv_run, 6, 2),
									6,    substr (run || '-' || dv_run, 1, 1)
									|| '.'
									|| substr (run || '-' || dv_run, 2, 3)
									|| substr (run || '-' || dv_run, 5, 2),
									5,    substr (run || '-' || dv_run, 1, 3)
									|| substr (run || '-' || dv_run, 4, 2),
									4,    substr (run || '-' || dv_run, 1, 2)
									|| substr (run || '-' || dv_run, 3, 2),
									3,    substr (run || '-' || dv_run, 1, 1)
									|| substr (run || '-' || dv_run, 2, 2)
								) run_con_formato
							from 
								ai_predictivo 
							where 1 = 1";

		if (session()->all()["perfil"] == config('constantes.perfil_administrador_central')){
			if (!is_null($comunas) && trim($comunas) != ""){
				$com_cod	= array();
				$comunas	= Comuna::find(explode(',', $comunas));
				foreach ($comunas as $k => $v) { array_push($com_cod, $v->com_cod); }
				$com_cod	= implode(',', $com_cod);
			}
			$sql_predictivo	.= " and dir_com_1 in ({$com_cod}) ";
		}else{
			$sql_predictivo	.= " and dir_com_1 = ".session()->all()['com_cod'];//." and rownum < 100";
		}

		$registros_predictivo = DB::select($sql_predictivo);

		$array_resultado = array();
		
		foreach ($registros_predictivo as $predictivo){

			$sexo = ($predictivo->sexo==1)?'Masculino':'Femenino';
			$reg_cod = str_pad($predictivo->dir_reg_1, 2, "0", STR_PAD_LEFT);
			$region = Region::where('reg_cod', $reg_cod)->first();
			$comuna = Comuna::where('com_cod', $predictivo->dir_com_1)->first();
			$nombre_region = ($region)?$region->reg_nom:'';
			$nombre_comuna = ($comuna)?$comuna->com_nom:'';
			$alertas_chccc = strval(AlertaChileCreceContigo::where('ale_chcc_run', $predictivo->run)->count());
			$alertas_territoriales = strval(AlertaManual::where('ale_man_run', $predictivo->run)->count());

			$array_resultado[$predictivo->run]['runconformato'] = $predictivo->run_con_formato; 

			if (!$origen){
				$array_resultado[$predictivo->run]['run'] = $predictivo->run; 
			}

			$array_resultado[$predictivo->run]['Edad'] = $predictivo->edad_agno; 
			$array_resultado[$predictivo->run]['Sexo'] = $sexo; 
			$array_resultado[$predictivo->run]['Cantidad_de_Alertas_CHCC'] = $alertas_chccc; 
			$array_resultado[$predictivo->run]['Cantidad_de_Alertas_Territoriales'] = $alertas_territoriales; 
			$array_resultado[$predictivo->run]['Prioridad'] = $predictivo->score; 
			$array_resultado[$predictivo->run]['Region'] = $nombre_region; 
			$array_resultado[$predictivo->run]['Comuna'] = $nombre_comuna; 



		}
		return collect($array_resultado);
	}
}
