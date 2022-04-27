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
class descargarGestionComunitariaDocumentos implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings {

    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro, $filtro_comunas) {
        $this->parametro        = $parametro;
        $this->filtro_comunas   = $filtro_comunas;
    }
	
	
	
    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A8:H8')->applyFromArray($estilos_titulos_tabla_contenido);


            $nombre_reporte = "";
            $info_reporte = DB::SELECT("SELECT * FROM ai_funcion WHERE cod_accion = 'ac45'");
            if (count($info_reporte)) $nombre_reporte = $info_reporte[0]->nombre;


            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));

            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(18);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(18);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(40);

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
        return collect(DB::select("select tdg.tip_nom, 
        count(dg.doc_gc_id) as cantidad
        from ai_documentos_gc dg
        inner join ai_tipo_doc_gc tdg
        on dg.tip_id = tdg.tip_id
        inner join ai_proceso_anual pa
        on pa.pro_an_id = dg.pro_an_id
        where dg.tip_id in (5, 6, 7)
        and dg.tip_gest = 0
        and pa.com_id in (".$this->filtro_comunas.")
        and pa.est_pro_id in(7, 8, 9, 10, 1, 2, 11, 12, 5, 6)
        group by tdg.tip_nom
        order by tdg.tip_nom asc"));
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A8';
    }
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        return [
                    'Tipo de Documento', 
                    'Cantidad de Documentos'
                ];
    }
            
}
            