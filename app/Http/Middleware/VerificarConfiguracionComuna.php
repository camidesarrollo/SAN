<?php

namespace App\Http\Middleware;

use Closure;
//use Session;
//use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
//use App\Modelos\Persona;


class VerificarConfiguracionComuna{
	/**
	 * Verifica configuración de la comuna por defecto en variable de sesion
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		//dd(session()->all()['comunas'], session()->all()['configurar_comuna']);
		if (count(session()->all()['comunas']) > 1){
			if (session()->all()['configurar_comuna'] == true) return redirect('main'); //redirect()->route('main');
		
		}
		
		return $next($request);
	}
}
