<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class DocumentCoord extends Model
{
    protected $table        = 'ai_doc_coor';
    protected $primaryKey   = 'doc_act_id';

    public static function getListadoDocumentos($tip_doc, $com_id = null){

        if(session()->all()['perfil'] == config("constantes.perfil_coordinador")){
            $usuario = " AND usu.id = ".session()->all()['id_usuario'];
            $comuna  = " AND com.com_id = ".$com_id;
        }else{
            $usuario = "";
            if($com_id != ""){
                $comuna  = " AND com.com_id IN (".$com_id.")";
            }else{
                $comuna  = " AND com.com_id = 0";
            }
            
        }

        if($tip_doc == 2){
            $tipo = " doc_tip_id IN (2,3,4,5)";
        }else{
            $tipo = " doc_tip_id = ".$tip_doc;
        }

        $sql = "SELECT adc.doc_act_nom, adc.created_at, usu.nombres||' '||usu.apellido_paterno||' '||usu.apellido_materno AS usuario, com.com_nom
                FROM ai_doc_coor adc
                LEFT JOIN ai_usuario usu ON adc.usu_id = usu.id
                LEFT JOIN ai_comuna com ON adc.com_id = com.com_id
                WHERE ".$tipo.' '.$usuario.' '.$comuna. 'ORDER BY usu.id';
        
        return DB::select($sql);
    }
}
