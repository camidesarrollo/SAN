<?php

namespace App\Http\Controllers;

use App\Modelos\{Caso,GrupoFamiliar};
use Session;
use Illuminate\Http\Request;
use Freshwork\ChileanBundle\Rut;

class GrupoFamiliarController extends Controller
{
	protected $caso;
	
	public function __construct(
		Caso			$caso
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->caso		= $caso;
	}
	
	public function verFamiliar(Request $request){
		try{
			
			$familiar = GrupoFamiliar::find($request->id_familiar);

			if($familiar==[]){

				$estado = 2;

				$fam_des = [];

			} else {

				$estado = 1;

				$nombre = $familiar["gru_fam_nom"]." ".$familiar["gru_fam_ape_pat"]." ".$familiar["gru_fam_ape_mat"];

				$dv_rut = Rut::parse($familiar["gru_fam_run"])->calculateVerificationNumber();
				//$dv_rut = Rut::parse($familiar["gru_fam_run"])->vn();

				$run_format = Rut::parse($familiar["gru_fam_run"].$dv_rut)->format();

				$gru_fam_id = $familiar["gru_fam_id"];

				$fam_des = array('nombre' => $nombre, 
								 'run' => $run_format, 
								 'gru_fam_id' => $gru_fam_id);

			}

			return response()->json(array(
				'estado'  => $estado, 
				'fam_des' => $fam_des,
				'mensaje' => 'La consulta ha sido exitosa'));

		} catch(\Exception $e) {
			//DB::rollback();
			dd($e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $e), 400);
		}
	}
}