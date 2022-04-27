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


class descargarTiemposIntervencion implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {

    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro, $filtro_comunas, $inicio, $fin, $caso = null, $gestor = null) {
        $this->parametro        = $parametro;
        $this->filtro_comunas   = $filtro_comunas;
        $this->inicio   = $inicio;
        $this->fin   = $fin;
        $this->caso   = $caso;
        $this->gestor   = $gestor;
    }
//
    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:P8')->applyFromArray($estilos_titulos_tabla_contenido);


            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac48'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;


            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: '.$this->gestor);
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(18);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(30);

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
        return collect(Helper::getTiemposIntervencion($this->filtro_comunas, $this->inicio, $this->fin, $this->caso, $this->gestor));
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return [
                    'ID Caso', 
                    'Nombre gestor(a)',
                    'Fecha de asignación/Prediagnóstico',
                    'Evaluación diagnóstica',
            'Elaboración PAF',
            'Ejecución PAF',
            'Evaluación PAF y Cierre de Caso',
            'Seguimiento PAF',
            'Cantidad Meses Intervención',
            'Total Días Intervención',
            'Prediagnóstico',
            'Evaluación Diagnóstica',
            'Elaboración PAF',
            'Ejecución PAF',
            'Evaluación PAF y Cierre de Caso',
            'Seguimiento PAF'
                ];
    }
            
}
            