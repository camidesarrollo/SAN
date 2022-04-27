<?php

namespace App\Exports\reportes;

use DB;
use App\Modelos\Terapia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Carbon\Carbon;

class EstadoSeguimientoGestionTerapiasExport implements FromView, WithDrawings,  WithEvents
{
    public function __construct($parametros,$comunas, $fec_ini = null, $fec_fin = null)
    {   
        $this->parametros   = $parametros;
        $this->comunas      = $comunas;
        $this->fec_ini = $fec_ini;
        $this->fec_fin = $fec_fin;
    }

    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

            // estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:E8')->applyFromArray($estilos_titulos_tabla_contenido);

            $event->sheet->getDelegate()->getStyle('A9:E9')->applyFromArray($estilos_titulos_tabla_contenido);

            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac34'");
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
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(23);

            // totales generales del reporte
            if ( $event->sheet->getHighestRow() > 8){
                $linea_totales = $event->sheet->getHighestRow()+1;
                $event->sheet->setCellValue('A'.($linea_totales), 'Total')->getStyle('A'.($linea_totales))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('B'. ($linea_totales), '=SUM(B9:B'.($linea_totales-1).')')->getStyle('B'.($linea_totales))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('C'. ($linea_totales), '=SUM(C9:C'.($linea_totales-1).')')->getStyle('C'.($linea_totales))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('D'. ($linea_totales), '=SUM(D9:D'.($linea_totales-1).')')->getStyle('D'.($linea_totales))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('E'. ($linea_totales), '=SUM(E9:E'.($linea_totales-1).')')->getStyle('E'.($linea_totales))->applyFromArray($estilos_linea_totales);

                // promedios:
                $event->sheet->setCellValue('A'.($linea_totales+2), 'Promedio mensual de contactos presenciales ')->getStyle('A'.($linea_totales+2))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('B'.($linea_totales+2), '=AVERAGE(C9:C'.($linea_totales-1).')')->getStyle('B'.($linea_totales+2))->applyFromArray($estilos_linea_totales);

                $event->sheet->setCellValue('A'.($linea_totales+3), 'Promedio mensual de contactos telefónicos ')->getStyle('A'.($linea_totales+3))->applyFromArray($estilos_linea_totales);
                
                $event->sheet->setCellValue('B'.($linea_totales+3), '=AVERAGE(B9:B'.($linea_totales-1).')')->getStyle('B'.($linea_totales+3))->applyFromArray($estilos_linea_totales);

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

    public function view(): View
    {

       $registros = Terapia::rptEstadoSeguimientoTerapia($this->comunas, $this->fec_ini, $this->fec_fin);

        return view('reportes.exports.excel_estado_seguimiento_gestion_terapias', 
            [
                'registros' => $registros
            ]
        );

    }
}
            