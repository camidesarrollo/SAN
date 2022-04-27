<?php
namespace App\Exports\reportes;
use DB;
use App\Modelos\Caso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class RutAsignadoGestorExport implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {

    
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro, $fec_ini = null, $fec_fin = null, $tipo) {
        $this->parametro = $parametro;
        $this->fec_ini = $fec_ini;
        $this->fec_fin = $fec_fin;
        // CZ SPRINT 75
        $this->tipo = $tipo;
    }

    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:J8')->applyFromArray($estilos_titulos_tabla_contenido);


            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac23'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // Periodo Fecha
            if($this->fec_ini != ""){
                // $fec_ini = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_ini)->format('d-m-Y');
                // $fec_fin = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_fin)->format('d-m-Y');
                // INICIO CZ SPRINT 75 MANTIS 10067
                $date_1 = str_replace('-', '/', $this->fec_ini);
                $date_2 = str_replace('-', '/', $this->fec_fin);
                // FIN CZ SPRINT 75 MANTIS 10067
                $event->sheet->setCellValue('D2','Periodo: ');
                // CZ SPRINT 75
                $event->sheet->setCellValue('D3','Desde: '.$date_1.' Hasta: '.$date_2);
                // CZ SPRINT 75
            } 

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(38);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(38);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(38);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(38);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(38);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(38);

            // totales generales del reporte
            if ( $event->sheet->getHighestRow() > 8){
	            $linea_totales = $event->sheet->getHighestRow()+1;
	            $event->sheet->setCellValue('A'.($linea_totales), 'Total')->getStyle('A'.($linea_totales))->applyFromArray($estilos_linea_totales);
				$event->sheet->setCellValue('B'. ($linea_totales), '=COUNT(C9:C'.($linea_totales-1).')')->getStyle('B'.($linea_totales))->applyFromArray($estilos_linea_totales);
            }


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

        /*
            $collection = collect(Caso::rptRutAsignadoGestor('xls'));
            $filtered = $collection->except(['nna_run']);
            dd($collection,$filtered);
        */

        // RUT Asignados a Gestor - Descarga
        // $this->parametro : Comunas separadas por coma.
        // CZ SPRINT 75
        return collect(Caso::rptRutAsignadoGestor('xls', $this->parametro, $this->fec_ini, $this->fec_fin, $this->tipo));
        // CZ SPRINT 75
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return [
            'RUN', 
            'Prioridad', 
            'Cantidad de Alertas Territoriales', 
            'Cantidad de Alertas ChCC Homologadas', 
            'Comuna',
            'Región',
            'ID Caso',
            'Fecha Intervención',
            'Estado',
            'Nombre Gestor/a'
        ];
    }
            
}
            