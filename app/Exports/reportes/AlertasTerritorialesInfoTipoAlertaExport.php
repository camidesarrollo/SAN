<?php
namespace App\Exports\reportes;
use DB;
use App\Modelos\AlertaManual;
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

class AlertasTerritorialesInfoTipoAlertaExport implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {

    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($comunas, $parametro, $fec_ini = null, $fec_fin = null, $tip_ale = null) {
        $this->parametro = $parametro;
        $this->comunas   = $comunas;
        $this->fec_ini = $fec_ini;
        $this->fec_fin = $fec_fin;
        $this->tip_ale = $tip_ale;
    }

    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:F8')->applyFromArray($estilos_titulos_tabla_contenido);

            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac19'");

            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // fecha por Filtro Fecha
            if($this->fec_ini != ""){
                $fec_ini = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_ini)->format('d-m-Y');
                $fec_fin = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_fin)->format('d-m-Y');
                $event->sheet->setCellValue('C2','Periodo: ');
                $event->sheet->setCellValue('C3','Desde: '.$fec_ini.' Hasta: '.$fec_fin);
            }   

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(80);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);



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

        return collect(AlertaManual::rptAlertasTerritorialesInfoTipoAlerta($this->comunas, $this->fec_ini, $this->fec_fin, $this->tip_ale,'excel'));

    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {

        return ['Tipo de Alerta Territorial', 'Fecha Asignación Caso', 'Sectorialista', 'Fecha de Ingreso Alerta', 'Rut NNA', 'Comuna' ];
    }    
}      
