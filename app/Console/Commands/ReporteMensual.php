<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\reportes\descargarReportesObjetivosTareasExportable;
use App\Exports\reportes\descargarReportesResultadosNcfasExportable;
use App\Exports\reportes\descargarReportesRespuestasTerapiafamiliarExportable;
use App\Exports\reportes\descargarReportesIntegrantesGfamiliarExportable;

class ReporteMensual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportesMensual:generar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar reportes mensuales para Administrador Central';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Excel::store(new descargarReportesObjetivosTareasExportable(), "reportes/Objetivos_Tareas_".date('mY').".xlsx");
        \Excel::store(new descargarReportesRespuestasTerapiafamiliarExportable(), "reportes/Respuestas_Terapia_Familiar_".date('mY').".xlsx");
        \Excel::store(new descargarReportesIntegrantesGfamiliarExportable(), "reportes/Integrantes_Grupo_Familiar_".date('mY').".xlsx");
        \Excel::store(new descargarReportesResultadosNcfasExportable(), "reportes/Resultados_NCFAS_".date('mY').".csv");
    }
}
