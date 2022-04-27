<?php
/**
 * Created by PhpStorm.
 * User: jmarquez
 * Date: 11-12-2018
 * Time: 14:25
 */

namespace App\Services;

use GuzzleHttp\Client as Client;

/**
 * Clase que maneja la conexiones a los servicios web de mds
 * Class ApiMdsService
 * @package App\Services
 */
class ApiMdsService
{
	protected $base_uri;
	
	protected $credenciales;
	
	protected $cabeceras = [
		'Accept'        => 'application/json',
		'cache-control' => 'no-cache',
	];
	
	protected $cabeceras_get;
	
	protected $token;
	
	public function __construct(){
		$this->credenciales = [
			'grant_type'	=> 'client_credentials',
			'client_id'		=> config('constantes.client_id'),
			'client_secret'	=> config('constantes.client_secret'),
		];
		
		$this->base_uri = config('constantes.client_api_uri');
		
		$this->autorizar();
		
		$this->cabeceras_get = array_merge($this->cabeceras,['authorization' => 'Bearer ' . $this->token]);
	}
	
	/**
	 * Funcion que se encarga de obtener el token de acceso del servicio rest
	 */
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
	
	/**
	 * Obtiene la informacion de RSH
	 * @param $run
	 * @return mixed
	 */
	public function getRsh($run){
		$client = new Client(['base_uri' => $this->base_uri]);
		
		$request = $client->get("ws/rsh/1/pass/$run", [
			'headers' => $this->cabeceras_get,
		]);
		
		return json_decode($request->getBody()->getContents());
	}
	
	/**
	 * Obtiene todas las regiones
	 * @return array
	 */
	public function getRegiones()
	{
		$client = new Client(['base_uri' => $this->base_uri]);
		
		$request = $client->get("ws/sit/regiones/8/67cd6d772b0495027734fbfd5397567d/-1", [
			'headers' => $this->cabeceras_get,
		]);
		
		$respuesta = json_decode($request->getBody()->getContents());
		
		if($respuesta->estado == 200){
			return $respuesta->regiones;
		}else{
			return [];
		}
	}
	
	/**
	 * Obtiene todas las instituciones, al parecer todavia este servicio no esta habilitado
	 * @return mixed
	 */
	public function getInstituciones()
	{
		$client = new Client(['base_uri' => $this->base_uri]);
		
		$request = $client->get("ws/institucion/16/8785d03380b8b6e3b06abfcefcfbead2/0", [
			'headers' => $this->cabeceras_get,
		]);
		
		$respuesta = json_decode($request->getBody()->getContents());
		
		/*if($respuesta->estado == 200){
			return $respuesta->institucion;
		}*/
		
		return $respuesta;
	}
}