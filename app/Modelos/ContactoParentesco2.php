<?php
//INICIO CZ SPRINT 58 
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ContactoParentesco2 extends Model
{
	protected $table = 'AI_CONTACTO_PARENTESCO_2';

	public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
	
	protected $fillable = array(
		'PERIODO',
		'RUN',
		'FECHA_INGRESO',
		'FUENTE',
		'NOMBRE_CONTACTO',
		'PARENTESCO',
		'NUMERO_CONTACTO',
		'TIPO_NUMERO',
		'ORDEN_CONTACTO',
        'TIPO_DATO',
        'COMUNA',
        'CATEGORIA'
	);
//FIN CZ SPRINT 58 
}

