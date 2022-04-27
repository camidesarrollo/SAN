<?php

namespace App\Exports\reportes;

use App\Modelos\MatrizFactores;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class descargarReporteMatrizFactoresExportable implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings
{
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($pro_an_id) {
        $this->pro_an_id = $pro_an_id;
    }

    public function registerEvents(): array { 
        
        return [AfterSheet::class => function (AfterSheet $event) {
            
        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:E8')->applyFromArray($estilos_titulos_tabla_contenido);

            // titulo del reporte
            $event->sheet->setCellValue('A6', 'Matriz de Factores Protectores')->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));     


             // ancho de celdas de resultados
             $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);

            $event->sheet->getStyle('A1:A999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('B1:B999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('C1:C999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('D1:D999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('E1:E999')->getAlignment()->setWrapText(true);

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
        return collect(MatrizFactores::select('mat_fac_pro', 'mat_fac_fam', 'mat_fac_esc', 'mat_fac_com', 'mat_fac_ins')->where('pro_an_id',$this->pro_an_id)->get());
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return ['Factores protectores', 'A nivel familiar', 'A nivel escolar', 'A nivel comunitario', 'A nivel institucional'];
    }
}
