<?php
namespace App\Exports\reportes;
use DB;
use App\Modelos\LineaBase;
use App\Modelos\RespuestasLB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class descargaLineaBaseExport implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings, WithMultipleSheets, WithTitle {
    //SPRINT 55
    // recibe parametros para realizar la consulta que pobla el reporte
    public function __construct($parametro, $fase, $tipo_pregunta) {
        $this->parametro = $parametro;
        $this->fase = $fase;
        $this->tipo_pregunta = $tipo_pregunta;
    }
	
    public function registerEvents(): array { 
        return [AfterSheet::class => function (AfterSheet $event) {

        	// estilos
            $estilos_titulos_tabla_contenido = ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'ebebeb']], 'font' => ['bold' => true]];
            $estilos_titulo_reporte = ['color' => ['argb' => '000000'], 'font' => array('name' => 'Calibri', 'size' => 20, 'bold' => false, 'color' => ['argb' => '000000'],), 'blackgroud-color' => ['argb' => 'fff'], ];
            $estilos_linea_totales = ['font' => array('name' => 'Calibri', 'size' => 12, 'bold' => true)];

            // titulo de tabla contenido
            $event->sheet->getDelegate()->getStyle('A11:AF11')->applyFromArray($estilos_titulos_tabla_contenido);

            $nombre_reporte = "";

            if($this->fase == 1){
                $nombre_reporte = 'INFORME LINEA BASE';
            }else{
                $nombre_reporte = 'INFORME LINEA SALIDA';
            }
            
            // titulo del reporte
            $event->sheet->setCellValue('A6', $nombre_reporte)->getStyle('A6')->applyFromArray($estilos_titulo_reporte);

            // fecha de ejecución de reporte
            $event->sheet->setCellValue('B2','Fecha Reporte: ');
            $event->sheet->setCellValue('B3', date('d-m-Y'));
            if($this->tipo_pregunta == 2)
                $event->sheet->setCellValue('c9','1. ¿CUÁL DE LOS SERVICIOS PÚBLICOS CONOCE A NIVEL COMUNAL?');           
            elseif($this->tipo_pregunta == 3)
                $event->sheet->setCellValue('c9','2. DE LOS SIGUIENTES PROGRAMAS SOCIALES Y PRESTACIONES ¿CUÁLES CONOCE USTED A NIVEL DE SU COMUNA?');           
            elseif($this->tipo_pregunta == 4)
                $event->sheet->setCellValue('c9','3. ¿CUÁL DE LOS SIGUIENTES SERVICIOS SE ENCUENTRAN EN SU SECTOR?');           
            elseif($this->tipo_pregunta == 5)
                $event->sheet->setCellValue('c9','1. ¿CUÁL DE LOS SIGUIENTES BIENES COMUNITARIOS CONOCES EN TU SECTOR?');           
            elseif($this->tipo_pregunta == 6)
                $event->sheet->setCellValue('c9','2. ¿CUÁL DE LAS SIGUIENTES ORGANIZACIONES CONOCE EN SU SECTOR?');           
            
            // ancho de celdas de resultados
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
            $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
            // INICIO CZ Y AF SPRINT 62
            if($this->tipo_pregunta == 1){
            $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
            $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(25);

            }else if($this->tipo_pregunta =! 7){
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(40);
            }else{
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(50);
            }
            // FIN CZ Y AF SPRINT 62

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
        // INICIO CZ Y AF SPRINT 62
        $condicion = '';
        $condicion_fas_id = '';
        $otro = '';
        $fase = $this->fase;
        // INICIO CZ SPRINT 62
        if($this->fase == 2){
            $condicion = "and res.LB_FAS_ID = {$this->fase}";
        }else{
            // INICIO CZ SPRINT 67
            $condicion_fas_id = "and (res.LB_FAS_ID = 1 or res.LB_FAS_ID is null)";
            // FIN CZ SPRINT 67
        }
        // FIN CZ SPRINT 62


        if($this->tipo_pregunta == 1){
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM, lb.LIN_BAS_COM,lb.LIN_BAS_CAL,lb.LIN_BAS_NUM,
                        (CASE WHEN lb.LIN_BAS_BLOC IS NULL THEN 'Sin información' ELSE lb.LIN_BAS_BLOC end) AS Bloc,
                        (CASE WHEN lb.LIN_BAS_DEP IS NULL THEN 'Sin información' ELSE lb.LIN_BAS_DEP end) AS Departamento,
                        (CASE WHEN lb.LIN_BAS_TEL IS NULL THEN 'Sin información' ELSE to_char(lb.LIN_BAS_TEL) end) AS Telefono,
                        (CASE WHEN lb.LIN_BAS_COR IS NULL THEN 'Sin información' ELSE  lb.LIN_BAS_COR end) as Correo,
                            lb.LIN_BAS_EDA
                            from AI_LINEA_BASE_GC lb where LB.PRO_AN_ID = {$this->parametro} order by LB.LIN_BAS_NOM ASC"));
            }
        else if($this->tipo_pregunta == 2){
            if($fase == 2){
                $otro = 'lb.lin_bas_otr1_1';
            }else{
                $otro = ' lb.lin_bas_otr1 as otro';
            }
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,preg.lb_pre_nom as servicios,
            CASE WHEN res.lb_res_pre1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.lb_res_pre2 = 1 THEN 'X' END as utiliza, 
            {$otro}
            from AI_LINEA_BASE_GC lb 
            inner join AI_LB_RESPUESTAS res on LB.LIN_BAS_ID = RES.LIN_BAS_ID 
            inner join AI_LB_PREGUNTAS preg on RES.LB_PRE_ID = PREG.LB_PRE_ID 
            where LB.PRO_AN_ID = {$this->parametro} and res.lb_res_tip = 1 {$condicion} {$condicion_fas_id} order by lb.LIN_BAS_NOM asc, PREG.LB_PRE_ID asc"));

        }
        else if($this->tipo_pregunta == 3){
            if($this->fase == 2){
                $otro = 'lb.lin_bas_otr2_1';
            }else{
                $otro = 'lb.lin_bas_otr2 as otro';
            }
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,preg.lb_pre_nom as sociales_prestaciones,
            CASE WHEN res.lb_res_pre1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.lb_res_pre2 = 1 THEN 'X' END as utiliza, 
            {$otro}
            from AI_LINEA_BASE_GC lb 
            inner join AI_LB_RESPUESTAS res on LB.LIN_BAS_ID = RES.LIN_BAS_ID 
            inner join AI_LB_PREGUNTAS preg on RES.LB_PRE_ID = PREG.LB_PRE_ID 
            where LB.PRO_AN_ID = {$this->parametro} and res.lb_res_tip = 2 {$condicion} {$condicion_fas_id} order by lb.LIN_BAS_NOM asc, PREG.LB_PRE_ID asc"));
        }
        else if($this->tipo_pregunta == 4){
            if($this->fase == 2){
                $otro = 'lb.lin_bas_otr3_1';
            }else{
                $otro = 'lb.lin_bas_otr3 as otro';
            }
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,preg.lb_pre_nom as Servicios,
            CASE WHEN res.lb_res_pre1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.lb_res_pre2 = 1 THEN 'X' END as utiliza, 
            {$otro}
            from AI_LINEA_BASE_GC lb 
            inner join AI_LB_RESPUESTAS res on LB.LIN_BAS_ID = RES.LIN_BAS_ID 
            inner join AI_LB_PREGUNTAS preg on RES.LB_PRE_ID = PREG.LB_PRE_ID 
            where LB.PRO_AN_ID = {$this->parametro} and  res.lb_res_tip = 0 {$condicion} {$condicion_fas_id} order by lb.LIN_BAS_NOM asc, PREG.LB_PRE_ID asc"));
        }     
        elseif($this->tipo_pregunta == 5){
            if($this->fase == 2){
                $otro = 'lb.lin_bas_otr4_1 as otro';
            }else{
                $otro = 'lb.lin_bas_otr4 as otro';
            }
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,preg.lb_pre_nom as Bienes,
            CASE WHEN res.lb_res_pre1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.lb_res_pre2 = 1 THEN 'X' END as utiliza, 
            {$otro}
            from AI_LINEA_BASE_GC lb 
            inner join AI_LB_RESPUESTAS res on LB.LIN_BAS_ID = RES.LIN_BAS_ID 
            inner join AI_LB_PREGUNTAS preg on RES.LB_PRE_ID = PREG.LB_PRE_ID 
            where LB.PRO_AN_ID = {$this->parametro} and  res.lb_res_tip = 3 {$condicion} {$condicion_fas_id} order by lb.LIN_BAS_NOM asc, PREG.LB_PRE_ID asc"));
        }   
        elseif($this->tipo_pregunta == 6){
            if($this->fase == 2){
                $otro = 'lb.lin_bas_otr5_1 as otro, lb.lin_bas_part_1';
            }else{
                $otro = 'lb.lin_bas_otr5 as otro, lb.lin_bas_part';
            }
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,preg.lb_pre_nom as Organizaciones,
            CASE WHEN res.lb_res_pre1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.lb_res_pre2 = 1 THEN 'X' END as utiliza, 
            CASE WHEN res.lb_res_pre3 = 1 THEN 'X' END as dirigentes, 
            {$otro}
            from AI_LINEA_BASE_GC lb 
            inner join AI_LB_RESPUESTAS res on LB.LIN_BAS_ID = RES.LIN_BAS_ID 
            inner join AI_LB_PREGUNTAS preg on RES.LB_PRE_ID = PREG.LB_PRE_ID 
            where LB.PRO_AN_ID = {$this->parametro} and  res.lb_res_tip = 4 {$condicion} {$condicion_fas_id} order by lb.LIN_BAS_NOM asc, PREG.LB_PRE_ID asc"));
        }       
        elseif($this->tipo_pregunta == 7){
            // INICIO CZ SPRINT 62
            if($this->fase == 2){
                $condicion = "and lb.LB_FAS_ID = {$this->fase}";
            }
            // FIN CZ SPRINT 62

            if($this->fase == 2){
                $otro = "(case when lb.LIN_BAS_RES1_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES1_1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES1_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES1_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES1_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES1_1 = 6 then 'No corresponde' END) AS Respuesta_1,
                (case when lb.LIN_BAS_RES2_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES2_1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES2_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES2_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES2_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES2_1 = 6 then 'No corresponde' END) AS Respuesta_2,
                (case when lb.LIN_BAS_RES3_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES3_1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES3_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES3_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES3_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES3_1 = 6 then 'No corresponde' END) AS Respuesta_3,
                (case when lb.LIN_BAS_RES4_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES4_1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES4_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES4_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES4_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES4_1 = 6 then 'No corresponde' END) AS Respuesta_4,
                (case when lb.LIN_BAS_RES5_1 = 1 then 'Muy en desacuerdo' when lb.lin_bas_res5_1 = 2 then 'En desacuerdo'  when lb.lin_bas_res5_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES5_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES5_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES5_1 = 6 then 'No corresponde' END) AS Respuesta_5,
                (case when lb.LIN_BAS_RES6_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES6_1 = 2 then 'En desacuerdo'  when lb.lin_bas_res6_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES6_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES6_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES6_1 = 6 then 'No corresponde' END) AS Respuesta_6,
                (case when lb.LIN_BAS_RES7_1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES7_1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES7_1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES7_1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES7_1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES7_1 = 6 then 'No corresponde' END) AS Respuesta_7";
            }else{
                $otro = "(case when lb.LIN_BAS_RES1 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES1 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES1 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES1 = 4 then 'De acuerdo' when lb.LIN_BAS_RES1 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES1 = 6 then 'No corresponde' END) AS Respuesta_1,
                (case when lb.LIN_BAS_RES2 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES2 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES2 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES2 = 4 then 'De acuerdo' when lb.LIN_BAS_RES2 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES2 = 6 then 'No corresponde' END) AS Respuesta_2,
                (case when lb.LIN_BAS_RES3 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES3 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES3 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES3 = 4 then 'De acuerdo' when lb.LIN_BAS_RES3 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES3 = 6 then 'No corresponde' END) AS Respuesta_3,
                (case when lb.LIN_BAS_RES4 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES4 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES4 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES4 = 4 then 'De acuerdo' when lb.LIN_BAS_RES4 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES4 = 6 then 'No corresponde' END) AS Respuesta_4,
                (case when lb.LIN_BAS_RES5 = 1 then 'Muy en desacuerdo' when lb.lin_bas_res5 = 2 then 'En desacuerdo'  when lb.lin_bas_res5 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES5 = 4 then 'De acuerdo' when lb.LIN_BAS_RES5 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES5 = 6 then 'No corresponde' END) AS Respuesta_5,
                (case when lb.LIN_BAS_RES6 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES6 = 2 then 'En desacuerdo'  when lb.lin_bas_res6 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES6 = 4 then 'De acuerdo' when lb.LIN_BAS_RES6 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES6 = 6 then 'No corresponde' END) AS Respuesta_6,
                (case when lb.LIN_BAS_RES7 = 1 then 'Muy en desacuerdo' when lb.LIN_BAS_RES7 = 2 then 'En desacuerdo'  when lb.LIN_BAS_RES7 = 3 then 'Ni en desacuerdo / ni de acuerdo'  when lb.LIN_BAS_RES7 = 4 then 'De acuerdo' when lb.LIN_BAS_RES7 = 5 then 'Muy de acuerdo' when lb.LIN_BAS_RES7 = 6 then 'No corresponde' END) AS Respuesta_7";
            }
            
            return collect(DB::select("select DECODE (
               LENGTH (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV),
               16,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 12, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 15, 2),
               15,  SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 11, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 14, 2),
               10,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                   || '.'
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 3)
                   || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 9, 2),
               9,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 8, 2),
               8,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 7, 2),
               7,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 6, 2),
               6,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || '.'
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 5, 2),
               5,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 3)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 4, 2),
               4,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 2)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 3, 2),
               3,    SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 1, 1)
                  || SUBSTR (lb.LIN_BAS_RUT || '-' || lb.LIN_BAS_DV, 2, 2)) rut, lb.LIN_BAS_NOM,
            {$otro}
            from AI_LINEA_BASE_GC lb where lb.PRO_AN_ID = {$this->parametro} {$condicion} order by lb.LIN_BAS_NOM asc, lb.LIN_BAS_ID DESC"));
        }     
        // FIN CZ Y AF SPRINT 62              
    }

    // se inicia en la fila 8, pues de la fila 1 a a 7 va el logo y titulo del reporte
    public function startCell(): string { 
        return 'A11';
    } 
            
    // nombre de los titulos de la tabla de contenido
    public function headings(): array {
        $titulos_excel = [];
        // INICIO CZ Y AF SPRINT 62
        if($this->tipo_pregunta == 1){
            $titulos_excel = ['RUT', 
            'Nombre',
            'Comuna',
            'Calle', 
            'N°',
            'Bloc',
            'Depto', 
            'Teléfono', 
            'Correo', 
            'Edad'
            ];
        }
        elseif($this->tipo_pregunta == 2){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Servicios',
            'Marque aquellos que usted conoce a nivel Comunal',
            'Marque aquellos que utiliza usted o una persona de su familia', 
            'Otro'
           
        ];
        }
        elseif($this->tipo_pregunta == 3){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Programas sociales y prestaciones',
            'Marque aquellos que usted conoce a nivel Comunal',
            'Marque aquellos que utiliza usted o una persona de su familia', 
            'Otro'
           
        ];
        }
        elseif($this->tipo_pregunta == 4){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Servicios',
            'Marque aquellos que usted conoce a nivel Comunal',
            'Marque aquellos que utiliza usted o una persona de su familia', 
            'Otro'
           
        ];
        }
        elseif($this->tipo_pregunta == 5){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Bienes',
            'Marque aquellos que usted conoce a nivel Comunal',
            'Marque aquellos que utiliza usted o una persona de su familia', 
            'Otro'
           
        ];
        }
        elseif($this->tipo_pregunta == 6){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Organizaciones',
            'Marque aquellos que usted conoce a nivel Comunal',
            'Marque aquellos que utiliza usted o una persona de su familia',
            'Marque aquellas de las cuales usted conoce a sus dirigentes', 
            'Otro',
            'Si Usted No Participa en Ninguna Organización, ¿le Gustaría Participar en Alguna Organización?:'
           
        ];
    }
        elseif($this->tipo_pregunta == 7){
            $titulos_excel = ['Rut', 
            'Nombre',
            'Conozco los derechos de los niños, niñas y adolescentes',
            'Conozco mi rol para que los derechos de los niños, niñas y adolescentes se cumplan',
            'Sé cómo actuar cuando conozco una vulneración de derechos que afecta a los niños, niñas y adolescentes',
            'Conozco en mi comunidad organizaciones en donde participan niños, niñas y adolescentes',
            'Es importante que los niños, niñas y adolescentes participen en la comunidad',
            'Es importante proteger los derechos de los niños, niñas y adolescentes',
            'Es importante que en mi comunidad existan organizaciones donde participen niños, niñas y adolescentes', 

           
        ];
        }        
        // FIN CZ Y AF SPRINT 62
        return $titulos_excel;
    }    

    public function sheets(): array{
        $sheets = [];
        // INICIO CZ Y AF SPRINT 62
        foreach(range(1, 7, 1) as $tipo){
            $sheets[] =  new descargaLineaBaseExport($this->parametro, $this->fase, $tipo);
        }
        // FIN CZ Y AF SPRINT 62

        return $sheets;
    }
    
    public function title(): string{
        $titulo = '';
        // INICIO CZ Y AF SPRINT 62
        if($this->tipo_pregunta == 1){
            $titulo = "I Identificacion";
        }elseif($this->tipo_pregunta == 2){
            $titulo = "II Servicios y Prestaciones P1";
        }
        elseif($this->tipo_pregunta == 3){
            $titulo = "II Servicios y Prestaciones P2";
        }
        elseif($this->tipo_pregunta == 4){
            $titulo = "II Servicios y Prestaciones P3";
        }
        elseif($this->tipo_pregunta == 5){
            $titulo = "III Organización Comunitaria P1";
        }
        elseif($this->tipo_pregunta == 6){
            $titulo = "III Organización Comunitaria P2";
        }
        elseif($this->tipo_pregunta == 7){
            $titulo = "IV Derechos y Participación NNA";
        }
        // FIN CZ Y AF SPRINT 62
        return $titulo;
    }
}