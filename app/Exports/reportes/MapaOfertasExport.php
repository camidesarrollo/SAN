<?php
namespace App\Exports\reportes;
use DB;
use App\Modelos\Programa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class MapaOfertasExport implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {

    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro) {
        $this->parametro = $parametro;
    }

    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido inicio ch
            $event->sheet->getDelegate()->getStyle('A8:K8')->applyFromArray($estilos_titulos_tabla_contenido);
            //fin ch

            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac29'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(60);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(45);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(45);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(60);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(60);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(50);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
            //inicio ch
            $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
            //fin ch

            // totales generales del reporte
    //         if ( $event->sheet->getHighestRow() > 8){
	   //          $linea_totales = $event->sheet->getHighestRow()+1;
	   //          $event->sheet->setCellValue('A'.($linea_totales), 'Total')->getStyle('A'.($linea_totales))->applyFromArray($estilos_linea_totales);
				// $event->sheet->setCellValue('B'. ($linea_totales), '=COUNT(C9:C'.($linea_totales-1).')')->getStyle('B'.($linea_totales))->applyFromArray($estilos_linea_totales);
    //         }


        }, ];
    }

    // inserta el logo de MDS en el reporte
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
        
        return collect(Programa::rptMapaOferta($this->parametro));
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return [
            'Nombre Programa', 
            'Institución Responsable', 
            'Cupos Comunales Programa',
            'Sector',
            'Disponible en la Comuna',
            'Contacto Comunal',
            'Tipo AT Que Mitiga',
            'Establecimiento',
            'Responsable',
            'Fecha de Actualización'
        ];
    }
            
}