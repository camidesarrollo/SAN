<?php

namespace App\Exports\reportes;

use App\Modelos\MatrizIdentificacionProblemaNNA;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class descargarReporteMatrizIdentProbExportable implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings
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
            $event->sheet->getDelegate()->getStyle('A8:I8')->applyFromArray($estilos_titulos_tabla_contenido);

            // titulo del reporte
            $event->sheet->setCellValue('A6', 'Matriz de Identificación de Problema')->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));     


             // ancho de celdas de resultados
             $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(80);
             $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);

            $event->sheet->getStyle('A9:A999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('B9:B999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('C9:C999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('D9:D999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('E9:E999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('F9:F999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('G9:G999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('H9:H999')->getAlignment()->setWrapText(true);

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
        $result = MatrizIdentificacionProblemaNNA::select('mip.mat_eje_tem_nom', 'mat_ide_pro_nna_pro_iden', 'mat_ide_pro_nna_cau', 'mat_ide_pro_nna_efe', 'mat_ide_pro_nna_acc_abo','mat_ide_pro_nna_ava','mat_ide_pro_nna_con_per_com','mat_ide_pro_nna_div_per_com')
        ->leftJoin("ai_matriz_ejes_tematicos mip", "ai_matriz_ide_pro_nna.mat_eje_tem_id", "=", "mip.mat_eje_tem_id")
        ->where('pro_an_id',$this->pro_an_id)->get();
        
        return collect($result);
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return ['Categorías o Ejes Temáticos', 'Problemática Identificada', 'Causas', 'Efectos', 'Acciones que se han Realizado para Abordar el Problema','Avances','Convergencia de Percepciones de la Comunidad','Divergencia de Percepciones de la Comunidad'];
    }
}
