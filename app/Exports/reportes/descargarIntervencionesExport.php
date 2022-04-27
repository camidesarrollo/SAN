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
use App\Http\Controllers\CasoController;

class descargarIntervencionesExport implements FromView, WithDrawings,  WithEvents
{

    public function __construct($parametro) {
        $this->parametro = $parametro;
    }

    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

            // estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:J8')->applyFromArray($estilos_titulos_tabla_contenido);


            $nombre_reporte = "Intervenciones";
            // $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac22'");
            // if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;

            $event->sheet->setAutoFilter('A8:J8');

            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(45);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(45);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(50);

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

          $intervenciones = CasoController::ExcelIntervenciones($this->parametro);

    	// $intervenciones = DB::select("SELECT p.per_run, c.cas_id, ec.est_cas_nom, pi.per_ind, u.nombres, u.apellido_paterno, op.obj_nom, tp.tar_descripcion, te.est_tar_nom, st.fecha
					// 		FROM ai_caso c
					// 		 LEFT JOIN ai_caso_persona_indice pi on c.cas_id = pi.cas_id
					// 		 LEFT JOIN ai_persona p on pi.per_id = p.per_id
					// 		 LEFT JOIN ai_estado_caso ec on c.est_cas_id = ec.est_cas_id
					// 		 LEFT JOIN ai_persona_usuario pu on c.cas_id = pu.cas_id and p.per_run = pu.run
					// 		 LEFT JOIN ai_usuario u on pu.usu_id = u.id
					// 		 LEFT JOIN ai_objetivo_paf op on op.cas_id = c.cas_id
					// 		 LEFT JOIN ai_obj_tarea_paf tp on op.obj_id = tp.obj_id
					// 		 LEFT JOIN ai_obj_tar_estado_paf te on tp.est_tar_id = te.est_tar_id
					// 		 LEFT JOIN ai_sesion_tarea st on tp.tar_id = st.tar_id /*NUMERICO*/
					// 		 LEFT JOIN ai_caso_comuna cc ON c.cas_id = cc.cas_id

					// 		WHERE pi.per_ind = 1 AND cc.com_id =306");


        return view('reportes.exports.excel_intervenciones', 
            [
                'registros' => collect($intervenciones)
            ]
        );

    }
}
            