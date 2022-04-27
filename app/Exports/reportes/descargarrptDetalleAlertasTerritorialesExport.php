<?php

namespace App\Exports\reportes;

use DB;
use App\Modelos\AlertaManual;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Carbon\Carbon;

class descargarrptDetalleAlertasTerritorialesExport implements FromView, WithDrawings,  WithEvents
{
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro,$comuna, $tip_ale=null, $fec_ini = null, $fec_fin = null) {
        $this->parametro = $parametro;
        $this->comuna = $comuna;        
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
            $event->sheet->getDelegate()->getStyle('A8:J8')->applyFromArray($estilos_titulos_tabla_contenido);

            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac22'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;


            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // fecha por rango de Fecha
            if($this->fec_ini != ""){
                $fec_ini = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_ini)->format('d-m-Y');
                $fec_fin = Carbon::createFromFormat('Y-m-d H:i:s',$this->fec_fin)->format('d-m-Y');
                $event->sheet->setCellValue('C2','Periodo: ');
                $event->sheet->setCellValue('C3','Desde: '.$fec_ini.' Hasta: '.$fec_fin);
            }  

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(25);

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

    public function view(): View
    {

       $registros = AlertaManual::rptDetalleAlertasTerritoriales(null,$this->comuna,$this->fec_ini, $this->fec_fin,$this->tip_ale);
       //dd(collect($registros));

        return view('reportes.exports.excel_detalle_alertas_manuales', 
            [
                'registros' => collect($registros)
            ]
        );

    }
}
            