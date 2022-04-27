<?php

namespace App\Http\Middleware;

use Closure;

class VerificarPerfil
{
	/**
	 * Verifica si el usuario pertenece a alguno de los perfiles dado
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param $perfiles array de perfiles
	 * @return mixed
	 */
	public function handle($request, Closure $next, ...$perfiles){
		if (!in_array(session('tipo_perfil'), $perfiles)){
			$mensaje = "Usted no Tiene Acceso a este Modulo.";
			return response(view('layouts.errores')->with(['mensaje'=>$mensaje]));
		}
		
		return $next($request);
	}
}
