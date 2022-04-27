<?php

namespace App\Http\Controllers;

use App\Modelos\Ofertas;
use Auth;
use Illuminate\Http\Request;
use App\Exports\AlertasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Modelos\{AlertaTipo,
	OfertaAlerta,
	Responsable,
	Categoria,
	OfertaComuna,
	Usuarios,
	Programa,
	Comuna,
	CategoriaOfertaComuna};
use DB;
use Illuminate\Support\Facades\Log;
use Session;

/**
 * Class OfertasController
 * @package App\Http\Controllers
 */
class OfertasController extends Controller
{

	protected $ofertas;

	protected $nombres = [
		'ofe_id'	=> 'ID Oferta',
		'ofe_nom'	=> 'Nombre Oferta',
		'ofe_des'	=> 'Descripción Oferta',
		'hora_ini' => 'Horario de inicio',
		'hora_fin' => 'Horario de fin',
		'ofe_pob_obj' => 'Población objetivo',
		'ofe_cuo'	=> 'Cuota Oferta',
		'prog'      => 'Programa',
		'res_run'   => 'rut Responsable'
	];


	/**
	 * OfertasController constructor.
	 * @param Ofertas $ofertas
	 */
	public function __construct(
		Ofertas		$ofertas,
		Usuarios	$usuarios,
		programa    $programas,
		Comuna      $comuna
	){
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->ofertas = $ofertas;
		$this->usuarios = $usuarios;
		$this->programas = $programas;
		$this->comuna = $comuna;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main(){

		return view('oferta.main');
	}

	public function mapa(){

		return view('oferta.mapa');
	}

	/**
	 * Método que lista el reporte del mapa de ofertas por dimension
	 */
	public function reportePorPrograma(){
		try{
			$ofertas 	= $this->ofertas->getReportePorPrograma();

			return response()->json(array('estado' => '1', 'respuesta' => $ofertas));
		}catch (\Exception $e){
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
		}
	}

	/**
	 * Método que lista las ofertas que se se encuentren registradas
	 */
	public function listarOfertas(){

		//$ofertas 	= $this->ofertas->getOfertasAlertaTipo(1);

		$ofertas 	= $this->ofertas->getOfertasTipoAlertas();
        //dd($ofertas);

		$data		= new \stdClass();
		$data->data = $ofertas;

		echo json_encode($data); exit;

	}

	// public function OfertasNombre(){

	// 	$ofertas 	= $this->ofertas->getOfertas(1);

	// 	$data		= new \stdClass();
	// 	$data->data = $ofertas;

	// 	echo json_encode($data); exit;

	// }

	public function buscarResponsable($id=null){

		$usuario = DB::table('ai_usuario')
				->where('id', '=', $id)
				->select('run', 'nombres','email','telefono','id_institucion')
				->get();

		$data = new \stdClass();
		$data = $usuario;

		echo json_encode($data); exit;

	}

	public function listarComunaPrograma($id){

		$user = Auth::id();

		$comuna = DB::table('ai_comuna')
				->join('ai_usuario_comuna','ai_usuario_comuna.com_id','=','ai_comuna.com_id')
				->join('ai_pro_com','ai_comuna.com_id','=','ai_pro_com.com_id')
				->where('ai_usuario_comuna.usu_id', '=', $user)
				->where('ai_pro_com.prog_id', '=', $id)
				->select('ai_comuna.com_id', 'ai_comuna.com_nom')
				->get();

		$data		= new \stdClass();
		$data= $comuna;

		echo json_encode($data); exit;


	}


	/**
	 * Método que permite ingresar crear ofertas
	 * @param null $ofe_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function crearOferta($prog_id=null){

		try{

			DB::beginTransaction();

			$alerta_tipo = AlertaTipo::all();

			//$comunas	= session()->all()['comunas'];
			$comunas	= array();
			$com_id = session()->all()['com_id'];
			if (isset($com_id) && $com_id != ""){
				$com_id = explode(",", $com_id);
				if (count($com_id) > 0) $comunas = Comuna::whereIn("com_id", $com_id)->get();

			}

			$programas = DB::select("SELECT p.prog_id, p.pro_nom, p.pro_tip, p.dim_id, count(*) FROM ai_pro_com pc
				     LEFT JOIN ai_programa p ON pc.prog_id = p.prog_id WHERE pc.com_id in (".Session::get('com_id').")
				     GROUP BY p.prog_id, p.pro_nom, p.pro_tip, p.dim_id");

			$responsables = $this->usuarios->getUsuarioResponsable();

			$tip_serv = DB::select("select * from ai_tipo_serv");

			$tip_benf = DB::select("SELECT id_tip_ben, nombre from ai_tipo_beneficio");

			$fuent_finz = DB::select("SELECT id_fuen_de_financ, nombre from ai_fuent_de_financ");

			DB::commit();

			return view('oferta.crear')
				->with(['responsables'=>$responsables,
				'alerta_tipo'=>$alerta_tipo,
				'programas'=>$programas,
				'prog_id'=>$prog_id,
				'comunas'=>$comunas,
				'tip_serv'=>$tip_serv,
				'tip_benf' => $tip_benf,
				'fuent_finz' =>$fuent_finz
			]);

		}catch(\Exception $e){

			DB::rollback();
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);

		}

	}


	/**
	 * Método que realiza la inserción de la oferta en la base de datos
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function insertarOferta(Request $request){

		try{

			if ($request->input('ofe_nom')=='' || $request->input('ofe_des')=='' || $request->input('hora_ini')=='' ||
 				$request->input('hora_fin')=='' || $request->input('ofe_pob_obj')=='' || $request->input('ofe_cup')=='' || $request->input('ofe_est')=='' || $request->input('fecha_ini')=='' || $request->input('fecha_ter')=='' || $request->input('ofe_tie_res')=='' || $request->input('ofe_estab')=='' || $request->input('id_fuen_de_financ')=='' || $request->input('id_tip_ben')=='' || $request->input('ofe_direc')=='' || $request->input('ofe_cant_mes' )=='' || $request->input('ofe_fec_prox_pos' )=='') {
				return response()->json(array('estado' => '0', 'mensaje' => 'Faltan datos en Oferta.'),400);
			}

			if ($request->input('prog_id')==''){
				return response()->json(array('estado' => '0', 'mensaje' => 'Seleccione un Programa.'),400);
			}

			/*if ($request->input('responsable')==0){
				return response()->json(array('estado' => '0', 'mensaje' => 'Debe selecionar un reponsable.'),400);
			}*/

			/*if ($request->input('tip_ale')==''){
				return response()->json(array('estado' => '0', 'mensaje' => 'Debe seleccionar  Alertas.'),400);
			}*/

			DB::beginTransaction();

			$hora_atencion = $request->input('hora_ini').' - '.$request->input('hora_fin');
			$oferta_tipo = $request->input('ofe_tip_'.$request->input('prog'));
			$rut_completo = TransversalController::eliminar_simbolos($request->input('res_run'));
			$rut_completo = substr($rut_completo, 0, -2);

			if($oferta_tipo == 'Local'){
			$oferta_tipo = 0;
			}
			elseif($oferta_tipo == 'Nacional'){
			$oferta_tipo = 1;
			}

			//REGISTRO OFERTAS

			$ofe_id	= Ofertas::max('ofe_id');

			$ofe_id = $ofe_id+1;
			$oferta  = new Ofertas();
			$oferta->ofe_id = $ofe_id+1;
			$oferta->ofe_nom = $request->ofe_nom;
			$oferta->ofe_des = $request->ofe_des;
			$oferta->ofe_hor_ate = $hora_atencion;
			$oferta->ofe_pob_obj = $request->ofe_pob_obj;
			$oferta->ofe_cup = $request->ofe_cup;
			$oferta->ofe_tip = $oferta_tipo;
			$oferta->prog_id = $request->prog_id;
			//$oferta->usu_resp = $request->responsable;
			$oferta->ofe_est = $request->ofe_est;
			$oferta->ofe_fec_ini = $request->fecha_ini;
			$oferta->ofe_fec_ter = $request->fecha_ter;
			$oferta->ofe_tie_res = $request->ofe_tie_res;
			$oferta->ofe_estab = $request->ofe_estab;
			// $oferta->tip_serv_id = $request->tip_serv_id;
			$oferta->id_tip_ben = $request->id_tip_ben;
			$oferta->id_fuen_de_financ = $request->id_fuen_de_financ;
			$oferta->ofe_direc = $request->ofe_direc;
			$oferta->ofe_cant_mes = $request->ofe_cant_mes;
			$oferta->ofe_fec_prox_pos = $request->ofe_fec_prox_pos;
			$oferta->save();

			//foreach ($request['com_id'] as $tai => $tav) {
			// $tipoALerta	= new OfertaComuna();
			// $tipoALerta->ofe_id = $oferta->ofe_id;
			// $tipoALerta->ale_tip_id	= $request->com_id;
			// $tipoALerta->save();
			// }

			//REGISTRO OFERTA ALERTA TIPO

			if (count($request['tip_ale'])>0){
			foreach ($request['tip_ale'] as $tai => $tav) {
				$tipoALerta	= new OfertaAlerta();
				$tipoALerta->ofe_id = $oferta->ofe_id;
				$tipoALerta->ale_tip_id	= $request['tip_ale'][$tai];
				$tipoALerta->save();
			}
			}

			// foreach ($request['cat_of_com'] as $cof => $coc) {
		 	// 	$categoria_oferta_comuna                  = new CategoriaOfertaComuna();
		 	// 		$categoria_oferta_comuna->cat_urg_id      = $cof+1;
		 	// 		$categoria_oferta_comuna->cat_ofe_com_tie = $coc;
		 	// 		$categoria_oferta_comuna->ofe_com_id      = $ofertaComuna->ofe_com_id;
		 	// 		$categoria_oferta_comuna->save();
		 	// 	}

		   DB::commit();

		$mensaje = "La oferta ha sido creada exitosamente.";
		return response()->json(array('estado' => '1', 'datatable' => '#tabla_ofertas', 'mensaje' => $mensaje),201);


		}catch(\Exception $e){
			//dd($e);
			Log::error('error: ok--' . $e);
			Log::info('This is some useful information.');
			error_log('Some message here.');
			DB::rollback();
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);

		}

	}


	/**
	 * Método que realiza la modificación de la oferta en la base de datos
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function editarOferta($ofe_id){

		$alerta_tipo = AlertaTipo::all();
		//$comunas	= session()->all()['comunas'];
		$comunas	= array();
		$com_id = session()->all()['com_id'];
		if (isset($com_id) && $com_id != ""){
				$com_id = explode(",", $com_id);
				if (count($com_id) > 0) $comunas = Comuna::whereIn("com_id", $com_id)->get();

		}

		//OFERTAS
		$ofertas = $this->ofertas->find($ofe_id);
		if (empty($ofertas->ofe_hor_ate)){
			$hora_ini =  "00:00"; 
			$hora_fin =  "00:00";
			
		}else{
			$horas = explode("-", $ofertas->ofe_hor_ate);
			$hora_ini =  $horas[0]; // hora_inicio
			$hora_fin =  $horas[1]; // hora_fin

		}

		//PROGRAMAS
		$programas = DB::select("SELECT p.prog_id, p.pro_nom, p.pro_tip, p.dim_id, count(*) FROM ai_pro_com pc
				     LEFT JOIN ai_programa p ON pc.prog_id = p.prog_id WHERE pc.com_id in (".session()->all()["com_id"].")
				     GROUP BY p.prog_id, p.pro_nom, p.pro_tip, p.dim_id");

		$responsables = $this->usuarios->getUsuarioResponsable();

		$tip_serv = DB::select("select * from ai_tipo_serv");
		$tip_benf = DB::select("SELECT id_tip_ben, nombre from ai_tipo_beneficio");

			$fuent_finz = DB::select("SELECT id_fuen_de_financ, nombre from ai_fuent_de_financ");

		//ALERTAS
		$ofertaAlerta	= OfertaAlerta::where('ofe_id', '=', $ofe_id);

		foreach ($alerta_tipo as $ai => $av) {
		$av->checked	= "";
			if ((!is_null($ofertaAlerta))) {
				foreach ($ofertaAlerta->get() as $oai => $oav) {
					if ($av->ale_tip_id == $oav->ale_tip_id){
							$av->checked	= "checked";
					}
				}
			}
		}

		return view('oferta.editar')
		->with(['ofertas'=>$ofertas,
				'hora_ini'=>$hora_ini,
				'hora_fin'=>$hora_fin,
				'responsables'=>$responsables,
				'alerta_tipo'=>$alerta_tipo,
				'programas'=>$programas,
				'comunas'=>$comunas,
				'tip_serv'=>$tip_serv,
				'tip_benf' =>$tip_benf,
				'fuent_finz' =>$fuent_finz
			]);
	}

	/**
	 * Método que realiza la modificación de la actualización en la base de datos
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function actualizarOferta(Request $request){

		try {

			if ($request->input('ofe_nom')=='' || $request->input('ofe_des')=='' || $request->input('hora_ini')=='' ||
 				$request->input('hora_fin')=='' || $request->input('ofe_pob_obj')=='' || $request->input('ofe_cup')==''	|| $request->input('ofe_est')=='' || $request->input('fecha_ini')=='' || $request->input('fecha_ter')=='' || $request->input('ofe_tie_res')=='' || $request->input('ofe_estab')=='' || $request->input('id_fuen_de_financ')=='' || $request->input('id_tip_ben')=='' || $request->input('ofe_direc')=='' || $request->input('ofe_cant_mes' )=='' || $request->input('ofe_fec_prox_pos' )=='' || $request->input('ofe_cant_mes' )=='' || $request->input('ofe_fec_prox_pos' )==''){
				return response()->json(array('estado' => '0', 'mensaje' => 'Faltan datos en Oferta.'),400);
			}

			if ($request->input('prog_id')==''){
				return response()->json(array('estado' => '0', 'mensaje' => 'Seleccione un Programa.'),400);
			}

			/*if ($request->input('responsable')==0){
				return response()->json(array('estado' => '0', 'mensaje' => 'Debe selecionar un reponsable.'),400);
			}*/


			/*if ($request->input('tip_ale')==''){
				return response()->json(array('estado' => '0', 'mensaje' => 'Debe seleccionar  Alertas.'),400);
			}*/

			$hora_atencion = $request->input('hora_ini').' - '.$request->input('hora_fin');


			DB::beginTransaction();

				$oferta = $this->ofertas->find($request->ofe_id);
				$oferta->ofe_id		 = $request->ofe_id;
				$oferta->ofe_nom	 = $request->ofe_nom;
				$oferta->ofe_des	 = $request->ofe_des;
				$oferta->ofe_hor_ate = $hora_atencion;
				$oferta->ofe_pob_obj = $request->ofe_pob_obj;
				$oferta->ofe_cup	 = $request->ofe_cup;
				$oferta->ofe_tip	 = 0;
				$oferta->prog_id     = $request->prog_id;
				$oferta->ofe_est	 = $request->ofe_est;
				$oferta->ofe_fec_ini = $request->fecha_ini;
				$oferta->ofe_fec_ter = $request->fecha_ter;
				$oferta->ofe_tie_res = $request->ofe_tie_res;
				$oferta->ofe_estab = $request->ofe_estab;
				// $oferta->tip_serv_id = $request->tip_serv_id;
				$oferta->id_tip_ben = $request->id_tip_ben;
				$oferta->id_fuen_de_financ = $request->id_fuen_de_financ;
				$oferta->ofe_direc = $request->ofe_direc;
				$oferta->ofe_cant_mes = $request->ofe_cant_mes;
				$oferta->ofe_fec_prox_pos = $request->ofe_fec_prox_pos;
				$oferta->save();

				$tipoALerta = OfertaAlerta::find($request->ofe_id);

				(!is_null($tipoALerta)) ? $tipoALerta->delete() : null;
				if (count($request['tip_ale'])>0){
				foreach ($request->tip_ale as $tai => $tav) {
					$tipoALerta				= new OfertaAlerta();
					$tipoALerta->ofe_id	    = $request->ofe_id;
					$tipoALerta->ale_tip_id	= $request->tip_ale[$tai];
					$tipoALerta->save();
				}
				}

				// $categoria_oferta_comuna = CategoriaOfertaComuna::find($data['ofe_com_id']);
				// (!is_null($categoria_oferta_comuna)) ? $categoria_oferta_comuna->delete() : null;
				// foreach ($data['cat_of_com'] as $cof => $coc) {
		 		// 		$categoria_oferta_comuna                  = new CategoriaOfertaComuna();
		 		// 		$categoria_oferta_comuna->cat_urg_id      = $cof+1;
		 		// 		$categoria_oferta_comuna->cat_ofe_com_tie = $coc;
		 		// 		$categoria_oferta_comuna->ofe_com_id      = $data['ofe_com_id'];
		 		// 		$categoria_oferta_comuna->save();
		 		//}

			DB::commit();

			$mensaje = "La oferta ha sido modificada exitosamente.";
			return response()->json(array('estado' => '1','datatable' => '#tabla_ofertas', 'mensaje' => $mensaje),201);


		} catch(\Exception $e) {

			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";
			return view('layouts.errores')->with(['mensaje' => $mensaje]);

		}

	}

	public function descargarMapaExportable(){
		return \Excel::download(new AlertasExport, "Reporte Mapa de Ofertas ".date('d-m-Y').".xlsx");

		// return \Excel::download(new AlertasExportStyling, "Reporte Mapa de Ofertas ".date('d-m-Y').".xlsx");
	}

	/**
	 * Método que lista el reporte del mapa de ofertas por alerta territorial
	 */
	public function reportePorTipoAlerta(){
		try{
			$tipo_alerta = new AlertaTipo;
			$reporte =  $tipo_alerta->getReportePorTipoAlerta();
			//dd($reporte);

			return response()->json(array('estado' => '1', 'respuesta' => $reporte));
		}catch(\Exception $e){
			Log::error('error: ' . $e);
			$mensaje = "Ocurrio un error inesperado, intente nuevamente.";

			return response()->json(array('estado' => '0', 'mensaje' => $mensaje),400);
		}


	}

}