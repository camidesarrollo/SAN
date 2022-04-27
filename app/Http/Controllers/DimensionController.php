<?php

namespace App\Http\Controllers;

use App\Modelos\{Dimension, Respuesta};
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Session;


class DimensionController extends Controller
{
	protected $dimension;
	
	protected $respuesta;
	
	protected $table		= 'ai_dimension';
	
	protected $primaryKey	= 'dim_id';
	
	protected $nombres = [
		'dim_id'	=> 'ID Dimensión',
		'dim_nom'	=> 'Nombre Dimensión',
		'dim_des'	=> 'Descripción Dimensión',
		'dim_act'	=> 'Estado Dimensión'
	];
	
	public function __construct(
		Dimension		$dimension,
		Respuesta       $respuesta
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->dimension		= $dimension;
		$this->respuesta        = $respuesta;
	}
	
	/**
	 * Método que lista las dimensiones del mantenedor
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main(){
		
		//$dimensiones = $this->dimension->all();
		//echo "<pre>"; print_r($dimensiones); echo "</pre>";
		//return view('dimension.main')->with(['dimensiones'=>$dimensiones]);
		return view('dimension.main');
	}
	
	
	public function listarDimension(){
		
		$dimensiones = $this->dimension->all();
		
		foreach ($dimensiones as $di => $dv){
			if ($dv->dim_act == 0){
				$dv->dim_act	= "Inactivo";
			}elseif ($dv->dim_act == 1){
				$dv->dim_act	= "Activo";
			}
		}
		
		$data	= new \stdClass();
		$data->data = $dimensiones;
		
		//echo json_encode($dimensiones); exit;
		echo json_encode($data); exit;
		
	
	}
	
	
	/**
	 * @param null $dim_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function crearDimension($dim_id=null){
		
		$dimension	= null;
		if (!is_null($dim_id)){
			$dimension = $this->dimension->find($dim_id);
		}
		
		return view('dimension.crear')->with(['dimension'=>$dimension]);
		
	}
	
	
	/**
	 *
	 */
	public function insertarDimension(Request $request){
	
		try {
			
			dd('insertarDimension');
			
			$reglas = [
				'dim_nom' => 'required',
				'dim_des' => 'required',
				'dim_act' => 'required'
			];
			
			$data = $request->validate($reglas,[], $this->nombres);
			
			DB::beginTransaction();
			
				/*$dimension	= new Dimension();
				$dimension->dim_nom	= $data['dim_nom'];
				$dimension->dim_des	= $data['dim_des'];
				$dimension->dim_act	= $data['dim_act'];
				$resultado = $dimension->save();*/
				
				//$this->dimension->fill($data);
				//$resultado = $this->dimension->save();

				//$resultado = $this->dimension->fill($data)->save();
				
				//$resultado	= Dimension::create($data);
			
				/*$resultado = DB::table('ai_dimension')->insertGetId(
					['dim_nom' => '1', 'dim_des' => '2', 'dim_act' => 0]
				);*/
			
				//dd($resultado);
			
			DB::commit();
			
			return redirect()->back()
				->with('success', 'La dimensión ha sido creada exitosamente.');
		
		} catch(\Exception $e) {
			
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje' => $mensaje]);
			
		}
	
	}
	
	
	/**
	 *
	 */
	public function actualizarDimension(Request $request){
		
		try {
			
			$reglas = [
				'dim_id'	=> 'required',
				'dim_nom'	=> 'required',
				'dim_des'	=> 'required',
				'dim_act'	=> 'required'
			];
			
			$data = $request->validate($reglas,[], $this->nombres);
			
			DB::beginTransaction();
			
				$ai_dim = $this->dimension->find($data['dim_id']);
			
				$ai_dim->dim_id		= $data['dim_id'];
				$ai_dim->dim_nom	= $data['dim_nom'];
				$ai_dim->dim_des	= $data['dim_des'];
				$ai_dim->dim_act	= $data['dim_act'];
				$ai_dim->save();
			
			DB::commit();
			
			return redirect()->back()
				->with('success', 'La dimensión ha sido modificada exitosamente.');
			
		} catch(\Exception $e) {
			
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje' => $mensaje]);
			
		}
		
	}
	
	public function resultadoNCFAS(Request $request){
		$respuestas = "";
		if (isset($request->caso_id) && $request->caso_id != ""){
			$dimensiones = [config('constantes.a_entorno'),
				config('constantes.b_competencias_parentales'),
				config('constantes.c_interacciones_familiares'),
				config('constantes.d_proteccion_familiar'),
				config('constantes.e_bienestar_del_niño/a'),
				config('constantes.f_vida_social_comunitaria'),
				config('constantes.g_autonomia'),
				config('constantes.h_salud_familiar')];
			
			if(isset($request->estado) && $request->estado == config('constantes.en_diagnostico')){
				$respuestas = $this->respuesta->getRespuestaPreguntaDimension([$request->caso_id], [config('constantes.ncfas_fs_ingreso')],
				null, [config('constantes.ncfas_al_clara_fortaleza'),config('constantes.ncfas_al_leve_Fortaleza'),config('constantes.ncfas_al_linea_base_adecuado'),
						config('constantes.ncfas_al_problema_leve'), config('constantes.ncfas_al_problema_moderado'),
						config('constantes.ncfas_al_problema_serio')], $dimensiones);
			}else{
				$respuestas = $this->respuesta->getRespuestaPreguntaDimension([$request->caso_id], [config('constantes.ncfas_fs_ingreso')],
					null, [config('constantes.ncfas_al_problema_leve'), config('constantes.ncfas_al_problema_moderado'),
						config('constantes.ncfas_al_problema_serio')], $dimensiones);
			}

		}

		$data		= new \stdClass();
		$data->data = $respuestas;
		//dd($respuestas);
		echo json_encode($data); exit;
    }
}