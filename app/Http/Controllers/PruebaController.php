<?php
namespace App\Http\Controllers;

use App\Services\ApiMdsService;
use Auth;
use Illuminate\Support\Facades\App;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Modelos\{AlertaManual,
	AsignadosVista,
	Caso,
	Contacto,
	CasoEstado,
	CasoTerapeuta,
	Comuna,
	Dimension,
	EstadoCaso,
	NNAAlertaManual,
	Persona,
	Direccion,
	Liceo,
	Predictivo,
	Score,
	Region,
	Tercero,
	RegistradosVista,
	UsuarioComuna,
	Usuarios,
	Sesion,
	Perfil};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Helpers\helper;

class PruebaController extends Controller
{
	protected $nombres = [
		'cas_id' => 'Casos',
		'ter_id' => 'Terceros',
		'cas_est_cas_des' => 'Comentario',
		'est_cas_id' => 'Estado',
	];
	
	protected $reglas_derivar = [
		'adjunto'           => 'sometimes|file|mimes:pdf,jpeg,bmp,png,txt,xls,xlsx,doc,docx|max:1024',
		'cas_id'            => 'required',
		'ter_id'            => 'required|numeric',
		'cas_est_cas_des'   => 'required',
		'est_cas_id'        => '',
	];
	
	protected $caso;
	protected $estado_caso;
	protected $usuario;
	protected $dimension;
	protected $tercero;
	protected $persona;
	protected $contacto;
	protected $direccion;
	
	protected $caso_terapeuta;
	
	protected $caso_estado;
	
	protected $registrados_vista;
	
	protected $asignados_vista;
	
	protected $alertaManual;
	
	protected $usuario_comuna;
	
	public function __construct(
		//Pruebas unitarias
		Caso				$caso,
		EstadoCaso			$estado_caso,
		Usuarios			$usuario,
		Dimension			$dimension,
		Tercero				$tercero,
		Persona				$persona,
		Contacto			$contacto,
		Direccion			$direccion,
		CasoTerapeuta		$caso_terapeuta,
		CasoEstado			$caso_estado,
		RegistradosVista	$registrados_vista,
		AsignadosVista		$asignados_vista,
		Perfil              $perfil,
		AlertaManual		$alertaManual,
		UsuarioComuna       $usuario_comuna
	)
	{
		$this->middleware('auth');
		$this->middleware('verificar.configuracion.comuna');
		$this->middleware('verificar.perfil:coordinador')
			->only(['mostrarFrmManuales','listar']);
		$this->middleware('verificar.perfil:coordinador,terapeuta,gestor')
			->only(['mostrarFrmManuales','ficha']);
		$this->middleware('verificar.caso.terapeuta',['only' => ['ficha']]);
		$this->caso					= $caso;
		$this->estado_caso			= $estado_caso;
		$this->usuario				= $usuario;
		$this->dimension			= $dimension;
		$this->tercero				= $tercero;
		$this->persona				= $persona;
		$this->contacto				= $contacto;
		$this->direccion			= $direccion;
		$this->caso_terapeuta		= $caso_terapeuta;
		$this->caso_estado			= $caso_estado;
		$this->registrados_vista	= $registrados_vista;
		$this->asignados_vista		= $asignados_vista;
		$this->perfil				= $perfil;
		$this->alertaManual			= $alertaManual;
		$this->usuario_comuna       = $usuario_comuna;
	}
	
	public function show()
	{
		return view('layouts.main');
	}

	public function prueba()
	{

		  // // getting all of the post data
    //     $files = $request->file('images');
    //     $destinationPath = 'uploads';
        
    //     // recorremos cada archivo y lo subimos individualmente
    //     foreach($files as $file) {
    //         $filename = $file->getClientOriginalName();
    //         $upload_success = $file->move($destinationPath, $filename);
    //     }

    //     // Demas codigo para crear producto

    //     return redirect()->to('product.index')->with('success', 'Archivos cargador éxitosamente');
   
		return "prueba ok";
	}



	public function crear_comunas()
	{
		
		/*if (($handle = fopen ( public_path () . '/regiones.csv', 'r' )) !== FALSE) {
			while ( ($data = fgetcsv ( $handle, 1000, ';' )) !== FALSE ) {
				//dd ($data);
				$Region = new Region();
				//$Region->reg_id = strtoupper($data[1]);
				$Region->reg_nom = strtoupper($data[1]);
				$Region->reg_cod = $data[0];
				$Region->save ();
			}
			fclose ( $handle );
		}*/
		/*if (($handle = fopen ( public_path () . '/provincias.csv', 'r' )) !== FALSE) {
			while ( ($data = fgetcsv( $handle, 1000, ';' )) !== FALSE ) {
				//dd ($data);
				$Region = Region::where('reg_cod',substr($data[0],0,2))->first();
				//dd ($Region);
				$provincia = new Provincia();
				$provincia->pro_nom = strtoupper($data[1]);
				$provincia->pro_cod = $data[0];
				
				$Region->provincias()->save($provincia);
			}
			fclose ( $handle );
		}*/
		/*if (($handle = fopen ( public_path () . '/comunas.csv', 'r' )) !== FALSE) {
			while ( ($data = fgetcsv( $handle, 1000, ';' )) !== FALSE ) {
				//dd ($data);
				$provincia = Provincia::where('pro_cod',substr($data[0],0,3))->first();
				//dd ($Region);
				$comuna = new Comuna();
				$comuna->com_nom = strtoupper($data[1]);
				$comuna->com_cod = $data[0];
				
				$provincia->comunas()->save($comuna);
			}
			fclose ( $handle );
		}*/
	}
	
	public static function authorizeclient()
	{
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://wsmds.mideplan.cl/api/auth/authorize-client",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n\t\"grant_type\":\"client_credentials\",\n\t\"client_id\":".env('client_id').",\n\t\"client_secret\":\"".env('client_secret')."\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			$response = json_decode($response);
			
			return $response->access_token;
		}
		
	}
	
	public static function rsh($run){
		
		
		$curl = curl_init();


		$token = PruebaController::authorizeclient();
		
		//dd();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://wsmds.mideplan.cl/api/ws/rsh/1/pass/$run",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$token."",
				"cache-control: no-cache"
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);

			//dd($curl);
		
		curl_close($curl);
		
		if ($err) {
			echo "cURL Error #:" . $err;

			dd("ok2");
		} else {

			//dd("ok2");
			//$result = json_decode($response);
			//return $result;
			dd($response);
			
			
			if($result->estado == 200){
				//return $result->regiones;
				//return $result->integrantes; o return $result->grupo;
				//dd ($result);
			}
			
			
		}
		
		
	}
	
	public static function comunas($run){
		
		
		$curl = curl_init();
		$token = PruebaController::authorizeclient();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://wsmds.mideplan.cl/api/ws/rsh/1/pass/$run",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$token."",
				"cache-control: no-cache"
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			dd ($response);
			$result = json_decode($response);
			
			if($result->estado == 200){
				//return $result->regiones;
				//return $result->integrantes; o return $result->grupo;
				dd ($result);
			}
			
			
		}
		
		
	}
	
	public function autorizar()
	{
		$client = new Client(['base_uri' => $this->base_uri]);
		
		$request = $client->post("auth/authorize-client", [
			'headers' => $this->cabeceras,
			'form_params' => $this->credenciales
		]);
		
		$response = json_decode($request->getBody()->getContents());
		$this->token = $response->access_token;
	}
	
	public function rsh2($run, ApiMdsService $apiMds){
		/*try {
			$client = new Client(['base_uri' => $this->base_uri]);
			
			$this->autorizar();
			
			$request = $client->get("ws/rsh/1/pass/$run", [
				'headers' => $this->cabeceras_get,
			]);
			
			//$response = json_decode($request->getBody()->getContents());
			//return $response;
			return $request->getBody()->getContents();
		} catch (RequestException $e) {
			echo Psr7\str($e->getRequest());
			if ($e->hasResponse()) {
				echo Psr7\str($e->getResponse());
			}
		}*/
		//$apiMds->getRegiones();
		//return "hola";
		//$apiMds->getRegiones();
		//$rsh = new ApiMdsService();
		//dd($apiMds->getRsh($run));
		dd($apiMds->getRegiones());
		//return json_encode($apiMds->getRsh($run));
		//return json_encode($apiMds->getRegiones());
	}
	
	public function cartola(){
		/*$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML('<h1>Test</h1>');
		return $pdf->stream();*/
		
		$c = file_get_contents("http://rshmunicipal.mideplan.cl/cartola/ciudadano/xGskkru12zDpa/16943477/true");
		
		$c = json_decode($c);
		
		if ($c) {
			
			if ($c->estado == 1) {
				$html = base64_decode($c->contenido);
			} else {
				echo "erro1";
			}
			
		}else {
			echo "error2";
		}
		
		$pdf = App::make('dompdf.wrapper');
		//$pdf->loadHTML($html, );
		
		return $pdf->loadHTML($html)->setPaper('a4', 'portrait')->download('cartola_RUN_'.date('Y-m-d-His'));
	}

	public function test_prueba()
	{

		dd("PRUEBA TEST...");

	}
	
}
