<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Modelos\Parametro;


class ParametroController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
	}

  
		public function listar()
								{
		$lstMantenedor = Parametro::orderBy('orden','asc')->where('valor',-1)->pluck('nombre', 'id');
		return view('administrador.parametro.index')->with('lstMantenedor',$lstMantenedor);
								}

	function apiGetParametro(){

		if(Input::get('id_padre')>0){
			$sql="SELECT P.*,CASE   WHEN P.id_estado=1 THEN 'Activo' WHEN P.id_estado=0 THEN 'Desactivado' ELSE 'Desactivado' END as nombre_estado FROM AI_PARAMETRO P WHERE P.VALOR <>-1 and P.id_padre=".Input::get('id_padre')." order by P.orden";
		}else{
			$sql="SELECT P.*,CASE   WHEN P.id_estado=1 THEN 'Activo' WHEN P.id_estado=0 THEN 'Desactivado' ELSE 'Desactivado' END as nombre_estado FROM AI_ARAMETRO P WHERE P.VALOR <>-1 order by P.orden";
		}
	 
		$lstParametro = DB::select($sql);
		return $lstParametro ;
		
	}

  //ai
   public function grabar($id=-1){     
  
		if($id==-1){
			$oParametro = new Parametro();
		}else{
			$oParametro = Parametro::where('id',$id)->get();
		}

		$lstEstado =  Parametro::where('id_padre',1)->where('id_estado',1)->where('valor','>',0)->orderBy('orden', 'asc')->get();
		return view('administrador.parametro.grabar')->with('oParametro',$oParametro[0])->with('lstEstado',$lstEstado);
	}

	public function aGrabar(){

		try {
			  if (Input::get('nombre')==''){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe ingresar el Nombre del parametro.'));
			  }
			  if (Input::get('valor')==''){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe ingresar el Valor del parametro.'));
			  }
			  if (Input::get('id_estado')==0){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe seleccionar el Estado del parametro.'));
			  }
			  if (Input::get('orden')==''){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe seleccionar el Orden que se despliega el parametro.'));
			  }

			  DB::connection()->getPdo()->beginTransaction();
			  if(Input::get('id')==-1){
					$oParametro = new Parametro();
					$sequence = DB::getSequence();
					$oParametro->id = $sequence->nextValue('AI_PARAMETRO_SEQ');
					$oParametro->id_padre = Input::get('id_padre');
					$oParametro->valor = Input::get('valor');
					$oParametro->nombre = Input::get('nombre');
					$oParametro->orden = Input::get('orden');
					$oParametro->id_estado = Input::get('id_estado');
					$save = $oParametro->save();
			  }else{
				$save = Parametro::where('id',Input::get('id'))->update(['nombre'    => Input::get('nombre'),'valor'    => Input::get('valor'),'id_estado'  => Input::get('id_estado'),'orden'   => Input::get('orden')]);
			  }


				if($save){
					DB::connection()->getPdo()->commit();
					return \Response::json(array('estado' => '1', 'msg' => 'Se grabo correctamente el parametro'));
				}else{
					DB::connection()->getPdo()->rollBack();
					return \Response::json(array('estado' => '0', 'msg' => 'Error: No se pudo grabar el parametro'));
				}

		}catch (Exception $ex) {

			DB::connection()->getPdo()->rollBack();
			return \Response::json(array('estado' => '0', 'msg' => 'Error: No se pudo grabar el parametro'));
		}
		
	}

  //ai
   public function ingresar($id_padre=-1){     
		$oParametro = new Parametro();
		$oParametro->id = -1;
		$oParametro->id_padre = $id_padre;
		$oParametro->nombre='';
		$oParametro->valor='';
		$oParametro->id_estado=0;
		$oParametro->orden='';
		$lstEstado =  Parametro::where('id_padre',1)->where('id_estado',1)->where('valor','>',0)->orderBy('orden', 'asc')->get();
		return view('administrador.parametro.grabar')->with('oParametro',$oParametro)->with('lstEstado',$lstEstado);
	}

  //ai
   public function grabarMantenedor(){     

		$lstEstado =  Parametro::where('id_padre',1)->where('id_estado',1)->where('valor','>',0)->orderBy('orden', 'asc')->get();
		return view('administrador.parametro.grabarmantenedor')->with('lstEstado',$lstEstado);
	}

	public function aGrabarMantenedor(){

		try {

			  if (Input::get('nombre')==''){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe ingresar el Nombre del mantenedor.'));
			  }
			  if (Input::get('id_estado')==0){
				  return \Response::json(array('estado' => '0', 'msg' => 'Debe seleccionar el Estado del mantenedor.'));
			  }

				DB::connection()->getPdo()->beginTransaction();
					$oParametro = new Parametro();
					$sequence = DB::getSequence();
					$id = $sequence->nextValue('AI_PARAMETRO_SEQ');
					$oParametro->id = $id;
					$oParametro->id_padre =  $id;
					$oParametro->valor = -1;
					$oParametro->nombre = Input::get('nombre');
					$oParametro->orden = 1;
					$oParametro->id_estado = Input::get('id_estado');
					if($oParametro->save()){
					DB::connection()->getPdo()->commit();
					return \Response::json(array('estado' => '1', 'msg' => 'Se grabo correctamente el mantenedor'));
				}else{
					DB::connection()->getPdo()->rollBack();
					return \Response::json(array('estado' => '0', 'msg' => 'Error: No se pudo grabar el mantenedor'));
				}

		}catch (Exception $ex) {

			DB::connection()->getPdo()->rollBack();
			return \Response::json(array('estado' => '0', 'msg' => 'Error: No se pudo grabar el mantenedor'));
		}
	
		
	}

}