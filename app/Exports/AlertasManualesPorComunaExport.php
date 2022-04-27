<?php

namespace App\Exports;

use DB;
//use Maatwebsite\Excel\Concerns\FromCollection;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//use App\Modelos\{AlertaTipo, OfertaAlerta, Ofertas};
//use Session;

//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;

//use Maatwebsite\Excel\Concerns\WithEvents;
//use Maatwebsite\Excel\Concerns\RegistersEventListeners;
//use Maatwebsite\Excel\Events\BeforeExport;
//use Maatwebsite\Excel\Events\BeforeWriting;
//use Maatwebsite\Excel\Events\BeforeSheet;
//use Maatwebsite\Excel\Events\AfterSheet;

//use PhpOffice\PhpSpreadsheet\Style\Fill;

//use Maatwebsite\Excel\Concerns\WithCustomStartCell;
//use Maatwebsite\Excel\Concerns\WithMapping;
//use Maatwebsite\Excel\Concerns\WithTitle;

class AlertasManualesPorComunaExport implements FromView {

public function __construct($parametro) {
		$this->parametro = $parametro;
	}

//class AlertasManualesPorComunaExport implements FromCollection, WithCustomStartCell, WithHeadings, WithTitle {

public function view(): View {

  	$sql = "select 
				comu.com_nom com_nom,
				count(am.ale_man_id) total
				from ai_alerta_manual am
				left join ai_comuna comu on comu.com_id = am.com_id
				GROUP BY comu.com_nom
				order by 2 desc";

	$registros_reporte = collect(DB::select($sql));

	return view('reportes.excel_alertas_territoriales_por_comuna', ["registros_reporte" => $registros_reporte]);

}

	/*public function startCell()
    {
        return 'B2';
    }

	public function title(): string
    {
        return 'Nombre de la Página';
    }

	public function headings(): array
    {
        return  ['Comuna', 'Total'];
    }


public function collection()
    {


    	$sql = "select 
				comu.com_nom com_nom,
				count(am.ale_man_id) total
				from ai_alerta_manual am
				left join ai_comuna comu on comu.com_id = am.com_id
				GROUP BY comu.com_nom
				order by 2 desc";

		return collect(DB::select($sql));


    }*/


}