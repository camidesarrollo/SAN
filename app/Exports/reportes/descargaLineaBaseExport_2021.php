<?php
// INICIO CZ SPRINT 70

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

class descargaLineaBaseExport_2021 implements FromCollection, WithDrawings,  WithEvents, WithCustomStartCell, WithHeadings, WithMultipleSheets, WithTitle {
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
            $event->sheet->getDelegate()->getStyle('A11:AF11')->applyFromArray($estilos_titulos_tabla_contenido)->getAlignment()->setWrapText(true)->setHorizontal('center');
            $event->sheet->getDelegate()->getStyle('A12:J300')->getAlignment()->setWrapText(true)->setHorizontal('center');

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
            if($this->tipo_pregunta == 1)
                $event->sheet->setCellValue('c9','1. IDENTIFICACIÓN.');           
            elseif($this->tipo_pregunta == 2)
                $event->sheet->setCellValue('c9','2. SERVICIOS Y PRESTACIONES.');           
            elseif($this->tipo_pregunta == 3)
                $event->sheet->setCellValue('c9','2. SERVICIOS Y PRESTACIONES.');           
            elseif($this->tipo_pregunta == 4)
                $event->sheet->setCellValue('c9','3. RECURSOS DE LA COMUNIDAD.');           
            elseif($this->tipo_pregunta == 5)
                $event->sheet->setCellValue('c9','3. RECURSOS DE LA COMUNIDAD.');           
            elseif($this->tipo_pregunta == 6)
                $event->sheet->setCellValue('c9','4. DERECHOS Y PARTICIPACIÓN DE NIÑOS, NIÑAS Y ADOLESCENTES.');
            elseif($this->tipo_pregunta == 7)
                $event->sheet->setCellValue('c9','5. HERRAMIENTAS Y PROYECCIÓN DEL ROL DE CO GARANTE.');
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
        if($this->tipo_pregunta == 1){
            $sql = DB::select("
            select  lb.IDEN_NOMBRE, DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                (CASE WHEN lb.IDEN_SEXO = 1 THEN 'Femenino' ELSE 'Masculino' END)  as sexo, 
                lb.IDEN_EDAD, 
                 (CASE WHEN lb.IDEN_FONO IS NULL THEN 'Sin información' ELSE lb.IDEN_FONO END) AS Telefono,
                 (CASE WHEN  lb.IDEN_CORREO IS NULL THEN 'Sin información' ELSE lb.IDEN_CORREO end) as Correo,
                 (CASE WHEN lb.IDEN_INTERNET = 1 THEN 'Si' ELSE 'No' end) as IDEN_INTERNET , 
                (CASE WHEN lb.IDEN_ELECTRONICOS = 1 THEN 'Si' ELSE 'No' end) as IDEN_ELECTRONICOS,
                 (CASE WHEN lb.IDEN_HOGAR_NNA = 1 THEN 'Si' ELSE 'No' end) as IDEN_HOGAR_NNA,
                 (CASE WHEN lb.IDEN_CANT_RANG_1 IS NULL THEN 0 ELSE lb.IDEN_CANT_RANG_1 END),
                 (CASE WHEN lb.IDEN_CANT_RANG_2 IS NULL THEN 0 ELSE lb.IDEN_CANT_RANG_2 END),
                 (CASE WHEN lb.IDEN_CANT_RANG_3 IS NULL THEN 0 ELSE lb.IDEN_CANT_RANG_3 END),
                 (CASE WHEN lb.IDEN_CANT_RANG_4 IS NULL THEN 0 ELSE lb.IDEN_CANT_RANG_4 END),
                (CASE WHEN lb.IDEN_CALLE IS NULL THEN 'Sin información' ELSE lb.IDEN_CALLE end) AS calle,
                (CASE WHEN lb.IDEN_NUMERO IS NULL THEN 'Sin información' ELSE lb.IDEN_NUMERO END) AS NUMERO,
                (CASE WHEN lb.IDEN_BLOCK IS NULL THEN 'Sin información' ELSE lb.IDEN_BLOCK end) AS Bloc,
                (CASE WHEN lb.IDEN_DEPARTAMENTO IS NULL THEN 'Sin información' ELSE lb.IDEN_DEPARTAMENTO END) AS Departamento,
                lb.IDEN_COMUNA,lb.IDEN_COMUNA
                from ai_lb_identificacion lb
                where lb.IDEN_PRO_AN_ID = ".$this->parametro);
                return collect($sql);
        }else if($this->tipo_pregunta == 2){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre,preg.lb_pre_nom as servicios,
                CASE WHEN res.sc_preg1 = 1 THEN 'X' END as nivel_Comunal, 
                CASE WHEN res.sc_preg2 = 1 THEN 'X' END as cercano,
                CASE WHEN res.sc_preg3 = 1 THEN 'X' END as utiliza,
                res.SC_MESYEAR
                from AI_LB_SERVICIOS_COMUNALES res 
                INNER JOIN ai_lb_identificacion lb ON res.sc_ident_id = lb.iden_id
                inner join AI_LB_PREGUNTAS preg on res.sc_id_servicio = PREG.LB_PRE_ID
                where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and res.sc_tipo = ".$this->fase. "  order by  lb.iden_nombre asc, preg.LB_PRE_ID asc");
                
                $sqlOtro = DB::select("Select iden_nombre,otro_descripcion from ai_lb_identificacion lb left join AI_LINEA_BASE_OTRO otro ON (lb.iden_id = otro.otro_iden_id and otro.otro_tipo = '2.1') 
                where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and otro.ID_OTRO_LINEA_BASE = ".$this->fase);
                foreach ($sql as $key => $row){
                    foreach ($sqlOtro as $row2){
                        if($row->iden_nombre == $row2->iden_nombre){
                            $sql[$key]->otro = $row2->otro_descripcion;
                        }
                    }
                }
            return collect($sql);
        }if($this->tipo_pregunta == 3){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre,preg.lb_pre_nom as programa,
            CASE WHEN res.sp_preg1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.sp_preg2 = 1 THEN 'X' END as participacion,
            res.sp_mesyear
            from AI_LB_SERVICIOS_PRES res 
            INNER JOIN ai_lb_identificacion lb ON res.sp_ident_id = lb.iden_id
            inner join AI_LB_PREGUNTAS preg on res.sp_id_programas = PREG.LB_PRE_ID
            where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and res.sp_tipo = ".$this->fase. "order by  lb.iden_nombre asc, preg.LB_PRE_ID asc");
            
            $sqlOtro = DB::select("Select iden_nombre,otro_descripcion from ai_lb_identificacion lb left join AI_LINEA_BASE_OTRO otro ON (lb.iden_id = otro.otro_iden_id and otro.otro_tipo = '2.2') 
                where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and otro.ID_OTRO_LINEA_BASE = ".$this->fase);
                foreach ($sql as $key => $row){
                    foreach ($sqlOtro as $row2){
                        if($row->iden_nombre == $row2->iden_nombre){
                            $sql[$key]->otro = $row2->otro_descripcion;
                        }
                    }
                }

            return collect($sql);
        }if($this->tipo_pregunta == 4){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre,
                   preg.lb_pre_nom as bienes,
            CASE WHEN res.org_bc_preg1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.org_bc_preg2 = 1 THEN 'X' END as cercano,
            CASE WHEN res.org_bc_preg3 = 1 THEN 'X' END as familia_utilizado,
            CASE WHEN res.org_bc_preg4 = 1 THEN 'X' END as existe_comunidad,
            res.org_bc_mesyear         
            from AI_LB_BIENES_COMUNITARIOS res 
            INNER JOIN ai_lb_identificacion lb ON res.ORG_BC_IDENT_ID = lb.iden_id
            inner join AI_LB_PREGUNTAS preg on res.ORG_ID_BIENES = PREG.LB_PRE_ID
            where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and res.org_bc_tipo = ".$this->fase. " order by  lb.iden_nombre asc, preg.LB_PRE_ID asc");

            $sqlOtro = DB::select("Select iden_nombre,otro_descripcion from ai_lb_identificacion lb left join AI_LINEA_BASE_OTRO otro ON (lb.iden_id = otro.otro_iden_id and otro.otro_tipo = '3.1') 
            where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and otro.ID_OTRO_LINEA_BASE = ".$this->fase);
            foreach ($sql as $key => $row){
                foreach ($sqlOtro as $row2){
                    if($row->iden_nombre == $row2->iden_nombre){
                        $sql[$key]->otro = $row2->otro_descripcion;
                    }
                }
            }

            return collect($sql);
        }if($this->tipo_pregunta == 5){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre,
                   preg.lb_pre_nom as bienes,
            CASE WHEN res.org_preg1 = 1 THEN 'X' END as nivel_Comunal, 
            CASE WHEN res.org_preg2 = 1 THEN 'X' END as cercano,
            CASE WHEN res.org_preg3 = 1 THEN 'X' END as familia_utilizado,
            res.org_mesyear,
            CASE WHEN res.org_preg4 = 1 THEN 'X' END as existe_comunidad, 
            CASE WHEN res.org_preg5 = 1 THEN 'X' END as dirigente         
            from AI_LB_ORG_COMUNITARIA res 
            INNER JOIN ai_lb_identificacion lb ON res.org_ident_id = lb.iden_id
            inner join AI_LB_PREGUNTAS preg on res.ORG_ID_ORG = PREG.LB_PRE_ID
            where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and res.ORG_TIPO = ".$this->fase . " order by  lb.iden_nombre asc, preg.LB_PRE_ID asc");

            $sqlOtro = DB::select("Select iden_nombre,otro_descripcion from ai_lb_identificacion lb left join AI_LINEA_BASE_OTRO otro ON (lb.iden_id = otro.otro_iden_id and otro.otro_tipo = '3.2') 
            where lb.IDEN_PRO_AN_ID =" .$this->parametro ." and otro.ID_OTRO_LINEA_BASE = ".$this->fase);
            foreach ($sql as $key => $row){
                foreach ($sqlOtro as $row2){
                    if($row->iden_nombre == $row2->iden_nombre){
                        $sql[$key]->otro = $row2->otro_descripcion;
                    }
                }
            }

            return collect($sql);
        }if($this->tipo_pregunta == 6){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre, 
                   (case when res.der_preg1 = 1 then 'Muy en desacuerdo' when res.der_preg1 = 2 then 'En desacuerdo' when res.der_preg1 = 3 then 'De acuerdo' when res.der_preg1 = 4 then 'Muy de acuerdo'  END) AS Respuesta_1,
                   (case when res.der_preg2 = 1 then 'Muy en desacuerdo' when res.der_preg2 = 2 then 'En desacuerdo'  when res.der_preg2 = 3 then 'De acuerdo' when res.der_preg2 = 4 then 'Muy de acuerdo'  END) AS Respuesta_2,
                   (case when res.der_preg3 = 1 then 'Muy en desacuerdo' when res.der_preg3 = 2 then 'En desacuerdo'  when res.der_preg3 = 3 then 'De acuerdo' when res.der_preg3 = 4 then 'Muy de acuerdo'  END) AS Respuesta_3,
                   (case when res.der_preg4 = 1 then 'Muy en desacuerdo' when res.der_preg4 = 2 then 'En desacuerdo'  when res.der_preg4 = 3 then 'De acuerdo' when res.der_preg4 = 4 then 'Muy de acuerdo'  END) AS Respuesta_4,
                   (case when res.der_preg5 = 1 then 'Muy en desacuerdo' when res.der_preg5 = 2 then 'En desacuerdo'  when res.der_preg5 = 3 then 'De acuerdo' when res.der_preg5 = 4 then 'Muy de acuerdo'  END) AS Respuesta_5,
                    (case when res.der_preg7 = 1 then 'Muy en desacuerdo' when res.der_preg7 = 2 then 'En desacuerdo'  when res.der_preg7 = 3 then 'De acuerdo' when res.der_preg7 = 4 then 'Muy de acuerdo'  END) AS Respuesta_7    
                from AI_LB_DERECHOS_NINOS res 
            INNER JOIN ai_lb_identificacion lb ON res.der_ident_id = lb.iden_id where lb.IDEN_PRO_AN_ID =" .$this->parametro." and res.der_id_linea_base = ".$this->fase . " order by  lb.iden_nombre asc, lb.IDEN_ID DESC");
            return collect($sql);
        }if($this->tipo_pregunta == 7){
            $sql = DB::select("select DECODE (
                LENGTH (lb.IDEN_RUN || '-' || lb.IDEN_DV),
                16,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 12, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 15, 2),
                15,  SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 11, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 14, 2),
                10,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                    || '.'
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 3)
                    || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 9, 2),
                9,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 8, 2),
                8,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 7, 2),
                7,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 6, 2),
                6,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || '.'
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 5, 2),
                5,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 3)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 4, 2),
                4,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 2)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 3, 2),
                3,    SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 1, 1)
                   || SUBSTR (lb.IDEN_RUN || '-' || lb.IDEN_DV, 2, 2)) IDEN_RUN,
                   lb.iden_nombre, 
                   (case when res.cont_preg1 = 1 then 'Muy en desacuerdo' when res.cont_preg1 = 2 then 'En desacuerdo' when res.cont_preg1 = 3 then 'De acuerdo' when res.cont_preg1 = 4 then 'Muy de acuerdo'  END) AS Respuesta_1,
                   (case when res.cont_preg2 = 1 then 'Muy en desacuerdo' when res.cont_preg2 = 2 then 'En desacuerdo'  when res.cont_preg2 = 3 then 'De acuerdo' when res.cont_preg2 = 4 then 'Muy de acuerdo'  END) AS Respuesta_2,
                   (case when res.cont_preg3 = 1 then 'Muy en desacuerdo' when res.cont_preg3 = 2 then 'En desacuerdo'  when res.cont_preg3 = 3 then 'De acuerdo' when res.cont_preg3 = 4 then 'Muy de acuerdo'  END) AS Respuesta_3,
                   (case when res.cont_preg4 = 1 then 'Muy en desacuerdo' when res.cont_preg4 = 2 then 'En desacuerdo'  when res.cont_preg4 = 3 then 'De acuerdo' when res.cont_preg4 = 4 then 'Muy de acuerdo'  END) AS Respuesta_4,
                   (case when res.cont_preg5 = 1 then 'Muy en desacuerdo' when res.cont_preg5 = 2 then 'En desacuerdo'  when res.cont_preg5 = 3 then 'De acuerdo' when res.cont_preg5 = 4 then 'Muy de acuerdo'  END) AS Respuesta_5,
                   (case when res.cont_preg6 = 1 then 'Muy en desacuerdo' when res.cont_preg6 = 2 then 'En desacuerdo'  when res.cont_preg6 = 3 then 'De acuerdo' when res.cont_preg6 = 4 then 'Muy de acuerdo'  END) AS Respuesta_6,
                   (case when res.cont_preg7 = 1 then 'Muy en desacuerdo' when res.cont_preg7 = 2 then 'En desacuerdo'  when res.cont_preg7 = 3 then 'De acuerdo' when res.cont_preg7 = 4 then 'Muy de acuerdo'  END) AS Respuesta_7                from AI_LB_CONT_PROYECTO res 
                INNER JOIN ai_lb_identificacion lb ON res.cont_ident_id = lb.iden_id where lb.IDEN_PRO_AN_ID =" .$this->parametro." and res.cont_id_linea_base = ".$this->fase . " order by  lb.iden_nombre asc, lb.IDEN_ID DESC");
            return collect($sql);
        }    
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
            $titulos_excel = ['Nombres y apellidos', 
            'RUT',
            'Sexo',
            'Edad',
            'Teléfono', 
            'Correo', 
            '¿Usted o alguien de su hogar cuenta con acceso a internet?', 
            '¿Usted o alguien de su hogar cuenta con equipos que permitan la comunicación a distancia? (Teléfono, Tablet, Notebook, PC)',
            '¿En su hogar viven niños, niñas y adolescentes (entre 0 y 17 años)?',
            '0-3 años',
            '4-5 años',
            '6-13 años',
            '14-17 años',
            'Calle', 
            'N°',
            'Bloc',
            'Depto',
            'Comuna'
            ];
        }
        elseif($this->tipo_pregunta == 2){
            $titulos_excel = ['Rut', 
            'Nombre',
            '2.1. Respecto a Servicios Comunales.',
            '¿Conoces en tu comuna?',
            '¿Está cercano a tu vivienda? (a menos de 15 min. caminando)', 
            '¿Alguien de tu hogar o tú lo han utilizado o acudido?', 
            '¿Cuándo fue la última vez? (presencial o virtual)', 
            'Otra. ¿Cuál?'
           
        ];
        }
        elseif($this->tipo_pregunta == 3){
            $titulos_excel = ['Rut', 
            'Nombre',
            '2.2. Respecto a Programas Sociales, Subsidios o Becas.',
            '¿Conoces en la comuna?',
            '¿Alguien de tu hogar o tú han participado o sido beneficiado?', 
            '¿Cuándo fue la última vez? (presencial o virtual)', 
            'Otra. ¿Cuál?'
           
        ];
        }
        elseif($this->tipo_pregunta == 4){
            $titulos_excel = ['Rut', 
            'Nombre',
            '3.1. Respecto a Bienes Comunitarios de acceso gratuito.',
            '¿Es importante que exista en la comunidad?',
            '¿Conoces en tu sector?',
            '¿Está cercano a tu vivienda? (a menos de 15 min. caminando)', 
            '¿Alguien de tu hogar o tú lo han utilizado?', 
            '¿Cuándo fue la última vez? (presencial o virtual)',
            'Otra. ¿Cuál?'
           
        ];
        }
        elseif($this->tipo_pregunta == 5){
            $titulos_excel = ['Rut', 
            'Nombre',
            '3.2. Respecto a Organizaciones Comunitarias.',
            '¿Es importante su presencia en la comunidad?',
            '¿Conoces en la comuna?',
            '¿Participas o has participado en ella?', 
            '¿Cuándo fue la última vez que participaste? (presencial o virtual)',
            '¿La organización funciona cerca de tu vivienda? (a menos de 15 min. caminando)',
            '¿Conoces a alguno(a) de sus dirigentes?', 
           'Otra. ¿Cuál?'
        ];
        }
        elseif($this->tipo_pregunta == 6){
            $titulos_excel = ['Rut', 
            'Nombre',
            '4.1. Conozco los derechos de los niños, niñas y adolescentes.',
            '4.2. Los deberes de los niños, niñas y adolescentes son más importantes que sus derechos.',
            '4.3. Sé que acciones debo llevar a cabo en caso de conocer una vulneración de derechos',
            '4.4. La familia es la única que tiene el deber de proteger a los niños, niñas y adolescentes.', 
            '4.5. Las organizaciones comunitarias deberían realizar un importante trabajo con los niños, niñas y adolescentes de la comunidad.',
            '4.6. Las actividades que se desarrollan en mi comunidad (recreativas, deportivas, culturales, entre otras) deberían convocar e involucrar a niños, niñas y adolescentes.'
           
        ];
        }
        elseif($this->tipo_pregunta == 7){
            $titulos_excel = ['Rut', 
            'Nombre',
            '5.1. Conozco los principales problemas y riesgos que afectan el bienestar de los niños, niñas y adolescentes en mi comunidad.',
            '5.2. Sé identificar los problemas de mi comunidad y nombrar sus causas.',
            '5.3. Sé proponer soluciones para intentar resolver los problemas existentes en mi comunidad.',
            '5.4. Sé a qué representantes de la comunidad debo recurrir para resolver problemas que puedan surgir en mi entorno o sector más cercano.',
            '5.5. Sé cómo establecer un diálogo con los representantes de mi comunidad, para resolver los problemas que puedan surgir en mi entorno o sector más cercano.',
            '5.6. Tengo interés en seguir participando permanentemente en organizaciones que desarrollan iniciativas en mi comunidad',
            '5.7. Confío en el trabajo de las organizaciones comunitarias de la comuna.'
        ];
        }        
        return $titulos_excel;
    }    

    public function sheets(): array{
        $sheets = [];
        foreach(range(1, 7, 1) as $tipo){
            $sheets[] =  new descargaLineaBaseExport_2021($this->parametro, $this->fase, $tipo);
        }

        return $sheets;
    }
    
    public function title(): string{
        $titulo = '';
        if($this->tipo_pregunta == 1){
            $titulo = "I Identificacion";
        }elseif($this->tipo_pregunta == 2){
            $titulo = "II SP Servicios Comunales";
        }
        elseif($this->tipo_pregunta == 3){
            $titulo = "II SP PGM  Soc y Prestaciones";
        }
        elseif($this->tipo_pregunta == 4){
            $titulo = "III RC Bienes Comunitarios.";
        }
        elseif($this->tipo_pregunta == 5){
            $titulo = "III RC Org Comunitarias";
        }
        elseif($this->tipo_pregunta == 6){
            $titulo = "IV Dcho y Part de niños";
        }
        elseif($this->tipo_pregunta == 7){
            $titulo = "V Continuidad del Proyecto";
        }
        return $titulo;
    }
}
//FIN CZ SPRINT 70