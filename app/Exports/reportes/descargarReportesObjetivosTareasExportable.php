<?php

namespace App\Exports\reportes;
use App\Modelos\TareaObjetivoPaf;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class descargarReportesObjetivosTareasExportable implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings
{
    
    public function registerEvents(): array { 
        
        return [AfterSheet::class => function (AfterSheet $event) {
            
        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:O8')->applyFromArray($estilos_titulos_tabla_contenido);

            // titulo del reporte
            $event->sheet->setCellValue('A6', 'Reporte de Objetivos y Tareas')->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('C2','Fecha Reporte: ');
            $event->sheet->setCellValue('C3', date('d-m-Y'));     


             // ancho de celdas de resultados
             $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);
             $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
             $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(100);
             $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
             $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(100);
             $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
             $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
             $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(14);
             $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(100);
             $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(12);
             $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(100);
             $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(14);
             $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(14);
             $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(60);
             $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(18);

           

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

    // rescata la información que pobla el reporte
    public function collection() {
        return collect(TareaObjetivoPaf::rptObjetivoTareas());
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return ['Caso', 'Objetivo ID', 'Nombre Objetivo', 'Tarea ID', 'Descripción de la Tarea', 'Plazo', 'Gestor ID', 'Grupo Familiar ID', 'Tarea Observaciónes', 'Tarea Fecha', 'Tarea Comentario', 'Estado', 'Fecha Ingreso', 'Caso Descripción', 'Comuna' ];
    }
}
