<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Modelos\{AlertaTipo, OfertaAlerta, Ofertas};
use Session;
use DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\Fill;

use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AlertasExport implements FromView, WithHeadings, WithCustomStartCell,WithEvents{
	
	public function headings(): array
    {
        return  ['Prestaciónn', 'Programa','Sector', 'Institución', 'Responsable','Oportunidad de acceso','Horario de Atencion','Cupos'];
    }

    public function startCell(): string
    {
        return 'A6';
    }

    // public function collection()
    // {
    //     return collect([
    //         [$respuesta]
    //     ]);
    // }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event) {

				$styleArrayUno = [
                'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                'argb' => 'ebebeb'
                 ]
                 ],
                 'font' => [
                 'bold' => true
                  ]
  				];

  				$styleArrayDos = [
	            'color' => ['argb' => '000000'],
	            'font' => array(
				'name' => 'Calibri',
				'size' => 20,
				'bold' => false,
				'color' => ['argb' => '000000'],
				),
				'blackgroud-color'  => ['argb' => 'fff'],
			    ];

			    $styleArrayTres = [
	            'color' => ['argb' => '000000'],
	            'font' => array(
				'name' => 'Calibri',
				'size' => 14,
				'bold' => false,
				'color' => ['argb' => '000000'],
				),
				'blackgroud-color'  => ['argb' => 'fff'],
			    ];

                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle('A6:O6')->applyFromArray($styleArrayUno);
                $event->sheet->setCellValue('B2', 'Mapa de Oferta Local')->getStyle('B2')->applyFromArray($styleArrayDos);

                $event->sheet->setCellValue('B3', 'Sistema Alerta Niñez')->getStyle('B3')->applyFromArray($styleArrayTres);
            },
        ];
    }

    public function view(): View{
		$respuesta = array();
		$res01 = AlertaTipo::all();
		$defecto = "Sin información";
		
		if (count($res01) == 0){
			$respuesta["estado"] = false;
			$respuesta["respuesta"] = "No existen datos para mostrar.";
			
		}else if (count($res01) > 0){
			$respuesta["estado"] = true;
			
			foreach($res01 as $c01 => $v01){
				$respuesta["respuesta"][$c01] = array($res01[$c01]->ale_tip_nom => "");
				
				$res02 = DB::table("ai_ofertas_alerta_tipo oat")->join("ai_ofertas_comuna oc", "oat.ofe_id","=","oc.ofe_id")
					->whereIn("oc.com_id", explode(",", session()->all()["com_id"]))->where("oat.ale_tip_id","=", $res01[$c01]->ale_tip_id)->get();
			
				$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom] = array();
				if (count($res02) > 0){
					foreach($res02 as $c02 => $v02){
						$res03 = DB::table("ai_ofertas o")->join("ai_programa p", "o.prog_id", "=", "p.prog_id")
							->join("ai_dimension d", "p.dim_id", "=", "d.dim_id")->join("ai_usuario u", "o.usu_resp","=", "u.id")
							->join("ai_institucion i", "u.id_institucion", "=", "i.id_ins")->where("o.ofe_id", "=", $v02->ofe_id)
							->get();
						
						if (count($res03) > 0){
							$ofe_nom     = $defecto;
							$pro_nom     = $defecto;
							$dim_nom     = $defecto;
							$inst_nom    = $defecto;
							$resp_nom    = $defecto;
							$opo_acc     = $defecto;
							$ofe_hor_ate = $defecto;
							$ofe_cup     = $defecto;
							
							foreach ($res03 as $c03 => $v03){
								if ($v03->ofe_nom != "" && isset($v03->ofe_nom)){ //Nombre Prestación
									$ofe_nom = $v03->ofe_nom;
								}
								
								if ($v03->pro_nom != "" && isset($v03->pro_nom)){ // Nombre Programa
									$pro_nom = $v03->pro_nom;
								}
								
								if ($v03->dim_nom != "" && isset($v03->dim_nom)){ //Nombre Sector
									$dim_nom = $v03->dim_nom;
								}
								
								if ($v03->nom_ins != "" && isset($v03->nom_ins)){ //Nombre Institución
									$inst_nom = $v03->nom_ins;
								}
								
								if ($v03->nombres != "" && isset($v03->nombres) && $v03->apellido_paterno != "" && isset($v03->apellido_paterno)
								   && $v03->apellido_materno != "" && isset($v03->apellido_materno)){ //Nombre Responsable
									$resp_nom = $v03->nombres." ".$v03->apellido_paterno." ".$v03->apellido_materno;
								}
								
								if ($v03->ofe_hor_ate != "" && isset($v03->ofe_hor_ate)){ //Horario de Atención
									$ofe_hor_ate = $v03->ofe_hor_ate;
								}
								
								if ($v03->ofe_cup != "" && isset($v03->ofe_cup)){ //Cantidad de Cupos
									$ofe_cup = $v03->ofe_cup;
								}
							}
						
							$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][$c02] = array(
									"ofe_nom"     => $ofe_nom,
									"pro_nom"     => $pro_nom,
									"dim_nom"     => $dim_nom,
									"inst_nom"    => $inst_nom,
									"resp_nom"    => $resp_nom,
									"opo_acc"     => $opo_acc,
									"ofe_hor_ate" => $ofe_hor_ate,
									"ofe_cup"     => $ofe_cup,
							);
						}else if (count($res03) == 0){
							$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][$c02] = array(
									"ofe_nom"     => $defecto,
									"pro_nom"     => $defecto,
									"dim_nom"     => $defecto,
								    "inst_nom"    => $defecto,
								    "resp_nom"    => $defecto,
								    "opo_acc"     => $defecto,
									"ofe_hor_ate" => $defecto,
									"ofe_cup"     => $defecto,
							);
						}
					}
				}else if (count($res02) == 0){
					$respuesta["respuesta"][$c01][$res01[$c01]->ale_tip_nom][0] = array(
						    "ofe_nom"     => $defecto,
						    "pro_nom"     => $defecto,
						    "dim_nom"     => $defecto,
						    "inst_nom"    => $defecto,
						    "resp_nom"    => $defecto,
						    "opo_acc"     => $defecto,
						    "ofe_hor_ate" => $defecto,
						    "ofe_cup"     => $defecto,
					);
				}
			}
		}

		return view('alertas.alertas_exportar', ["respuesta" => $respuesta]);
	}

}