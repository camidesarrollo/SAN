<?php
namespace App\Exports\reportes;
use DB;
use App\Modelos\Predictivo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Helpers\helper;
class descargarGestionComunitariaEtapas implements WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro, $filtro_comunas) {
        $this->parametro        = $parametro;
        $this->filtro_comunas   = $filtro_comunas;
    }
	
	
	
	
    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:H8')->applyFromArray($estilos_titulos_tabla_contenido);


            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac47'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

            $pro_an_id = Helper::getProceso(session()->all()["com_id"]);
            
            
            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));
            
            $etapas = Helper::getEtapas();
            $i = 9;
            foreach($etapas as $value){
                $et = Helper::estuvoEtapa($pro_an_id[0]->pro_an_id, $value->est_pro_id);
                if($et[0]->existe == 0){
                    $estuvo = 'No';
                }else{
                    $estuvo = 'Sí';
                }
                $cant = Helper::diasEtapa($pro_an_id[0]->pro_an_id, $value->est_pro_id);
                $registros = 0;
                if($et[0]->existe != 0){
                    if($value->est_pro_id == 6){ //L�nea Base
                        $cantLB = Helper::cantidadLineaBase($pro_an_id[0]->pro_an_id);
                        $registros = $cantLB[0]->cantidad;
                    }else if($value->est_pro_id == 11){ //Linea Salida
                        $cantLS = Helper::cantidadLineaSalida($pro_an_id[0]->pro_an_id);
                        $registros = $cantLS[0]->cantidad;
                    }else{
                        $registros = 'No aplica';
                    }
                }
                $event->sheet->setCellValue('A'.$i, $value->est_pro_nom);
                $event->sheet->setCellValue('B'.$i, $estuvo);
                $event->sheet->setCellValue('C'.$i, $cant);
                $event->sheet->setCellValue('D'.$i, $registros);
                $i++;
            }
            
            

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(18);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(18);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(40);

        }, ];
    }

    // inserta el logo de la empresa en el reporte
    public function drawings() {
        $drawing = new Drawing();
        $drawing->setPath(public_path('/img/logo-mds-familia.jpg'));
        $drawing->setHeight(100);
        $drawing->setWidth(100);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

    

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return [
                    'Nombre Etapa', 
                    'Estuvo en la etapa',
                    'Cantidad de días en etapa',
                    'Cantidad de registros'
                ];
    }
            
}
            