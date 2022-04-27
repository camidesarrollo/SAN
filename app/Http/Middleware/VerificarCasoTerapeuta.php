<?php

namespace App\Http\Middleware;

use App\Modelos\CasoTerapeuta;
use App\Modelos\Persona;
use Closure;
use Illuminate\Support\Facades\Log;
use App\Traits\CasoTraitsGenericos;
use Freshwork\ChileanBundle\Rut;

class VerificarCasoTerapeuta
{
	use CasoTraitsGenericos;

	protected $persona;
	
	protected $caso_terapeuta;
	
	public function __construct(
		Persona			$persona,
		CasoTerapeuta	$caso_terapeuta
	)
	{
		$this->persona				= $persona;
		$this->caso_terapeuta		= $caso_terapeuta;
	}
	
	/**
	 * Verifica si el Caso pertenece Terapeuta
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		if (session()->all()['perfil'] == config('constantes.perfil_terapeuta')){
			$existe = true;
			//$caso = $request->caso ?? null;
			$run = $request->run ?? null;
			$idCaso = $request->idcaso ?? null;
			if (!is_null($run)){
				$dv = Rut::set($run)->calculateVerificationNumber();
				$val_run = $this->validarPredictivoPersonaCasoAlertas($run, $dv);

				if ($val_run['persona'] == true){
						// INICIO CZ SPRINT 63 Casos ingresados a ONL
					$caso = $this->ObtenerCasoActualAbierto($run, $dv, $idCaso);
						// FIN CZ SPRINT 63 Casos ingresados a ONL
					if (count($caso) > 0){
						$caso = $caso[0]->cas_id;
						$existe = $this->caso_terapeuta->verificarCasoTerapeuta($caso);

						if (!$existe){
							$mensaje = "El Caso no esta asignado a usted. Por favor verificar.";
							return response(view('layouts.errores')->with(['mensaje' => $mensaje]));
						}

					}else if (count($caso) == 0){
						$mensaje = "No se encuentra un Caso abierto para el RUN consultado. Por favor verificar";
					
						return response(view('layouts.errores')->with(['mensaje' => $mensaje]));
					}
				}else if ($val_run['persona'] == false){
					$mensaje = "El RUN consultado no tiene un caso creado. Por favor verificar";
					
					return response(view('layouts.errores')->with(['mensaje' => $mensaje]));
				}
			}



			
			/*if (!is_null($caso)) {
				$existe = $this->caso_terapeuta->verificarCasoTerapeuta($caso);
			}
			if (!is_null($run)) {
				$persona = $this->persona->getByRunConCaso($run);
				if (is_null($persona)){
					$existe = false;
				}else{
					$existe = $this->caso_terapeuta->verificarCasoTerapeuta($persona->casos[0]->cas_id);
				}
			}
			
			if (!$existe) {
				$mensaje = "El Caso no Pertene a Usted.";
				return response(view('layouts.errores')->with(['mensaje' => $mensaje]));
			}*/
		}
		
		return $next($request);
	}
}
