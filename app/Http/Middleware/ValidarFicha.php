<?php

namespace App\Http\Middleware;

use Closure;
use Freshwork\ChileanBundle\Rut;
use App\Helpers\helper;

class ValidarFicha
{
	/**
	 * Verifica si el usuario pertenece a alguno de los perfiles dado
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param $perfiles array de perfiles
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		$request->run = Helper::DecodificarString($request->run);
		//dd($request);
		//dd($request->run);
		
		if (!is_numeric($request->run)){
			$mensaje = "Run consultado no válido. Por favor verifique información e intente nuevamente.";

			return response(view('layouts.errores')->with(['mensaje'=>$mensaje]));
		} 

		return $next($request);
	}
}
