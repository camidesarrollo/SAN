<?php
//Inicio Andres F. 
namespace App\Http\Controllers;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class MailController extends Mailable
{
	
	use Queueable, SerializesModels;
    /**
     * Instancia objeto Demo
     *
     * @var Demo
     */
    public $datos;
    /**
     * Instancia a nuevo mensaje.
     *
     * @return void
     */
    public function __construct($datos)
    {
        $this->datos = $datos;
    }
    /**
     * Definición de mensaje.
     *
     * @return $this
     */
    public function build()
    {
	    if($this->datos->tipo_correo == 'sectorialistas'){
		    
			return $this->from(env('MAIL_FROM_ADDRESS')) //se debe pedir cuenta para salir
                        ->subject("Derivación a Programa")
	                    ->view('mails.sectorialista')
	                    ->with(
	                      [
	                            'testVarOne' => '1',
	                            'testVarTwo' => '2',
	                      ]);
    
	    } //Inicio Andres F
        else if($this->datos->tipo_correo == 'asignacion'){
            return $this->from(env('MAIL_FROM_ADDRESS')) //se debe pedir cuenta para salir
                        ->subject("Asignación a Gestor")
	                    ->view('mails.asignacion_nna')
	                    ->with(
	                      [
	                            'testVarOne' => '1',
	                            'testVarTwo' => '2',
	                      ]);
        //Fin Andres F.
        //Se puede establer nuevos tipos de correo creando la vista para destinatarios
      // INICIO CZ SPRINT 74  
      }else if($this->datos->tipo_correo == 'asignacionGestor'){
          return $this->from(env('MAIL_FROM_ADDRESS')) //se debe pedir cuenta para salir
                        ->subject("Asignación a Gestor")
	                    ->view('mails.asignacion_nna_Gestor')
	                    ->with(
	                      [
	                            'testVarOne' => '1',
	                            'testVarTwo' => '2',
	                      ]);
        }else if($this->datos->tipo_correo == 'asignacionTerapeuta'){
          return $this->from(env('MAIL_FROM_ADDRESS')) //se debe pedir cuenta para salir
                        ->subject("Asignación a Terapia")
	                    ->view('mails.asignacion_nna_Terapia')
	                    ->with(
	                      [
	                            'testVarOne' => '1',
	                            'testVarTwo' => '2',
	                      ]);
        }
// INICIO CZ SPRINT 74  
	                                  
    }
}
//Fin Andres F.