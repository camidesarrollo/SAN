<?php

namespace App\Exports\reportes;

use App\Modelos\MatrizRangoEtario;
use App\Modelos\MatrizIdentificacionProblemaNNA;
use App\Modelos\MatrizRangoEtarioProblema;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class descargarReporteMatrizRangoEtarioExportable implements WithDrawings,  WithEvents, FromView
{
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($pro_an_id) {
        $this->pro_an_id = $pro_an_id;
    }

    public function registerEvents(): array { 
        
        return [AfterSheet::class => function (AfterSheet $event) {
            
        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => false]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:G8')->applyFromArray($estilos_titulos_tabla_contenido);

            // titulo del reporte
            $event->sheet->setCellValue('A6', 'Matriz de Priorización de Problemas')->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));     


             // ancho de celdas de resultados
             $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
             $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(50);

            $event->sheet->getStyle('A9:A999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('B9:B999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('C9:C999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('D9:D999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('E9:E999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('F9:F999')->getAlignment()->setWrapText(true);
            $event->sheet->getStyle('G9:G999')->getAlignment()->setWrapText(true);

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
        //INICIO DC
        $eta = DB::select("select distinct mat_eje_tem_nom || ' - ' || mat_ide_pro_nna_pro_iden as problematica,
        mat_ran_eta_mag,
        mat_ran_eta_grav,
        mat_ran_eta_cap,
        mat_ran_eta_alt_sol,
        mat_ran_eta_ben,
        mat_tip_ran_eta_nom
        from ai_matriz_ejes_tematicos met
        left join ai_matriz_ide_pro_nna mipn
        on mipn.mat_eje_tem_id = met.mat_eje_tem_id
        left join ai_matriz_rango_etario_prob mrep
        on mrep.mat_ide_pro_nna_id = mipn.mat_ide_pro_nna_id
        left join ai_matriz_rango_etario mre
        on mre.mat_idePro_nna_id = mrep.mat_ide_pro_nna_id
        left join ai_matriz_tipo_rango_etario mtre
        on mre.mat_tip_ran_eta_id = mtre.mat_tip_ran_eta_id
        where mipn.pro_an_id = ".$this->pro_an_id."
        and mtre.mat_tip_ran_eta_id = 1");
        
        $eta2 = DB::select("select distinct mat_eje_tem_nom || ' - ' || mat_ide_pro_nna_pro_iden as problematica,
        mat_ran_eta_mag,
        mat_ran_eta_grav,
        mat_ran_eta_cap,
        mat_ran_eta_alt_sol,
        mat_ran_eta_ben,
        mat_tip_ran_eta_nom
        from ai_matriz_ejes_tematicos met
        left join ai_matriz_ide_pro_nna mipn
        on mipn.mat_eje_tem_id = met.mat_eje_tem_id
        left join ai_matriz_rango_etario_prob mrep
        on mrep.mat_ide_pro_nna_id = mipn.mat_ide_pro_nna_id
        left join ai_matriz_rango_etario mre
        on mre.mat_idePro_nna_id = mrep.mat_ide_pro_nna_id
        left join ai_matriz_tipo_rango_etario mtre
        on mre.mat_tip_ran_eta_id = mtre.mat_tip_ran_eta_id
        where mipn.pro_an_id = ".$this->pro_an_id."
        and mtre.mat_tip_ran_eta_id = 2");
        
        $eta3 = DB::select("select distinct mat_eje_tem_nom || ' - ' || mat_ide_pro_nna_pro_iden as problematica,
        mat_ran_eta_mag,
        mat_ran_eta_grav,
        mat_ran_eta_cap,
        mat_ran_eta_alt_sol,
        mat_ran_eta_ben,
        mat_tip_ran_eta_nom
        from ai_matriz_ejes_tematicos met
        left join ai_matriz_ide_pro_nna mipn
        on mipn.mat_eje_tem_id = met.mat_eje_tem_id
        left join ai_matriz_rango_etario_prob mrep
        on mrep.mat_ide_pro_nna_id = mipn.mat_ide_pro_nna_id
        left join ai_matriz_rango_etario mre
        on mre.mat_idePro_nna_id = mrep.mat_ide_pro_nna_id
        left join ai_matriz_tipo_rango_etario mtre
        on mre.mat_tip_ran_eta_id = mtre.mat_tip_ran_eta_id
        where mipn.pro_an_id = ".$this->pro_an_id."
        and mtre.mat_tip_ran_eta_id = 3");
        //FIN DC
        

        return view('reportes.exports.excel_matriz_rango_etario', 
            [
                'prob' => $eta,
                'prob2' => $eta2,
                'prob3' => $eta3
            ]
        );
    }
}
