<?php

use App\Modelos\{Usuarios, Persona, Liceo, Region, Provincia, Comuna, Perfil, Caso};
/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register web routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | contains the "web" middleware group. Now create something great!f
 |
 */
 
// RRUIZ 14052019
// se agregan rutas para limpiar cache, config y views
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    echo "cache limpio";
});
    Route::get('/clear-config', function() {
    $exitCode = Artisan::call('config:clear');
     echo "config limpio";
    });
        
        Route::get('/clear-view', function() {
    $exitCode = Artisan::call('view:clear');
    echo "view limpio";
        });
            
            Route::get('carga', function() {
	//$Region = Region::with('comunas')->where('reg_cod','13')->get();
	$Region = Region::with('comunas')->where('reg_cod','13')->first();
	dd ($Region->toJson(JSON_PRETTY_PRINT));
	//return $Region->toJson(JSON_PRETTY_PRINT);
            });
                
                Route::get('test2', function() {
	//return response()->json(true);
	
	$resultado = Persona::where('per_run',3445043)->first()
		->casos();
	dd($resultado);
                });
                    Route::post('/buscarDirecciones', 'AlertaController@buscarDireccion');
                    Route::post('/actualizarEstado', 'AlertaController@actualizarEstado');
                    Route::post('/guardarDireccion', 'AlertaController@guardarDireccion');
                    Route::post('/eliminarDireccion', 'AlertaController@eliminarDireccion');
                    
                    Route::get('/cartola', 'PruebaController@cartola');
                    
                    Route::get('/', 'HomeController@index')
	->name('index');
                    
                    Route::get('/main', 'HomeController@main')
	->name('main');
                    
                    Route::get('/casos/listarObjetivosPaf/', 'CasoController@listarObjetivosPaf')
 	->name('casos.listarObjetivosPaf');
                    
                    Route::get('/casos/getVigentes/', 'CasoController@getVigentes')
 	->name('casos.getNumVigentes');
                    
 	Route::get('/casos/selEstadoTarea/', 'CasoController@selEstadoTarea')
 	->name('casos.updEstadoTarea');
                    
                    Route::get('/casos/listarObjetivosEjecucionPaf/', 'CasoController@listarObjetivosEjecucionPaf')
 	->name('casos.listarObjetivosEjecucionPaf');
                    
                    Route::get('/casos/recuperarDataTarea/', 'CasoController@recuperarDataTarea')
 	->name('casos.recuperarDataTarea');
                    
                    Route::post('/casos/guardarDescripcionObjetivo/', 'CasoController@guardarDescripcionObjetivo')->name('casos.guardarDescripcionObjetivo');
                    
                    Route::post('/casos/guardarObjetivoPrincipal/', 'CasoController@guardarObjetivoPrincipal')
 	->name('casos.guardarObjetivoPrincipal');
                    
                    Route::post('/casos/actualizarTarea/', 'CasoController@actualizarTarea')
 	->name('casos.actualizarTarea');
                    
                    
                    Route::get('/casos/finalizarTarea/', 'CasoController@finalizarTarea')
 	->name('casos.finalizarTarea');
                    
                    Route::get('/casos/listarTareas/', 'CasoController@listarTareas')
 	->name('casos.listarTareas');
                    
                    Route::get('/casos/accionesObjetivo/', 'CasoController@accionesObjetivo')
 	->name('casos.accionesObjetivo');
                    
                    Route::post('/casos/guardar/sesiones/obj/tar', 'CasoController@guardarSesionesObjTarPaf')
 	->name('casos.guardar.sesion.ojb.tar');
                    
 Route::get('/casos/listar/sesiones/tareas', 'CasoController@listarSesionesTareas')
 	->name('casos.listar.sesiones.tareas');
                    
 Route::get('/casos/busquedaInteractiva/{run?}', 'CasoController@busquedaInteractiva')
	 ->name('casos.busquedaInteractiva');
	 
                    Route::post('/casos/registrar/tareas/comprometidads', 'CasoController@registrarTareasComprometidas')
	 ->name('registrar.tareas.comprometidas');
                    // Getting Json Data
                    Route::get('data/casos/asignados', 'CasoController@dataCasosAsignados')
	->name('data.casos.asignados');
                    
                    Route::get('/casos/registrados', 'CasoController@vistaCasosRegistrados')
	->name('vista.casos.registrados');
                    
                    Route::get('/data/casos/registrados', 'CasoController@dataCasosRegistrados')
	->name('data.casos.registrados');
                    
                    Route::get('/casos/egresados', 'CasoController@vistaCasosEgresados')
	->name('vista.casos.egresados');
                    
                    Route::get('/data/casos/egresados', 'CasoController@dataCasosEgresados')
	->name('data.casos.egresados');
                    
                    
                    // Oficina Local NNA
                    /*Route::get('/casos/oficinaLocal', 'CasoController@casosOficinaLocal')
	->name('vista.casos.oficina_local');
                     
                     Route::get('/data/casos/oficinaLocal/', 'CasoController@vistaCasosOficinaLocal')
	->name('data.casos.oficina_local');*/
                    Route::get('/casos/oficinaLocal', 'CasoController@oficinaLocal')->name('casos.oficinaLocal');
                    
                    Route::get('/casos/comunales', 'CasoController@casosComunales')->name('casos.comunales');
                    
                    Route::get('/casos/listarNNA', 'CasoController@listarNNA')->name('casos.listarNNA');

                    Route::get('/casos/obtenerCantidadAlerta', 'CasoController@obtenerCantidadAlertasNNA')->name('casos.obtenerCantidadAlerta');
                    
                    Route::get('/casos/listarNNAComunales', 'CasoController@listarNNAComunales')->name('casos.listarNNAComunales');
                    
                    // Asignar NNA
                    /*Route::get('/casos/administracion', 'CasoController@casosAdministracion')
	->name('vista.casos.administracion');
                     Route::get('/data/casos/administracion/', 'CasoController@vistaCasosAdministracion')
	->name('data.casos.administracion');
                     Route::get('/data/casos/administracion/gestor', 'CasoController@vistaGestores')
	->name('data.casos.administracion.gestor');
                     Route::get('/casos/administracion/asignargestor/{nna?}/{id_usu?}', 'CasoController@asignarGestor')
	->name('casos.administracion.asignargestor')->where(['nna' => '[0-9]+', 'id_usu' => '[0-9]+']);*/
                    Route::get('/casos/asignarNNA', 'CasoController@asignarNNA')->name('casos.asignarNNA');
                    
                    Route::get('/casos/listarAsignarNNA/{i?}', 'CasoController@listarAsignarNNA')->name('casos.listarAsignarNNA');
                    
                    Route::get('/casos/listarAsignarNNADOS/{i?}', 'CasoController@listarAsignarNNADOS')->name('casos.listarAsignarNNADOS');
                    
                    
                    
                    Route::get('/casos/listarAsignadosGestor/{i?}', 'CasoController@listarAsignadosGestores')->name('casos.listarAsignadosGestor');
                    
                    Route::get('/casos/asignarNNAaGestor', 'CasoController@asignarGestor')->name('casos.asignarNNAaGestor');
                    //INICIO CZ SPRINT 68 
                    Route::get('/casos/reasignarNNAaGestor', 'CasoController@reasignarGestor')->name('casos.reasignarNNAaGestor');
                    //FIN CZ SPRINT 68 
                    
                    Route::get('/casos/asignados', 'CasoController@vistaCasosAsignados')
	->name('vista.casos.asignados');
                    
                    Route::post('/caso/asignar-gestor', 'CasoController@asignarGestor')
    ->name('coordinador.caso.asignar.gestor');
                    
                    Route::get('/casos/manual', 'CasoController@mostrarFrmManuales')
	->name('coordinador.caso.manual');
                    
                    Route::post('/casos/manual/ingresar', 'CasoController@ingresarManuales')
	->name('coordinador.caso.manual.ingresar');
                    
                    Route::get('/casos/buscar', 'CasoController@showBuscar')
	->name('terapeuta.caso.buscar');
                    
                    // casos
                    Route::get('/casos/descarga/documento/{archivo}', 'CasoController@descargaDocumento')
	->name('casos.descarga.documento');
                    
                    Route::get('/casos/form/diagnostico', 'CasoController@guardarFormDiagnostico')
    ->name('casos.form.diagnostico');
                    
                    Route::get('/casos/cambio/estado', 'CasoController@cambioEstadoCaso')
	->name('casos.cambio.estado');
                    
                    Route::get('/casos/guardar_obs_prediagnostico', 'CasoController@guardarObsPreDiagnostico')
	->name('casos.guardar_obs_prediagnostico');
                    
                    Route::get('/casos/guardar_fecha_prediagnostico', 'CasoController@guardarFechaPreDiagnostico')
	->name('casos.guardar_fecha_prediagnostico');
                    
                    Route::get('/casos/prediagnostico', 'CasoController@preDiagnostico')
	->name('casos.prediagnostico');
                    
// INICIO CZ SPRINT 63 Casos ingresados a ONL
// INICIO CZ SPRINT SPRINT 67
    Route::get('/caso/{run?}/{idcaso?}', 'CasoController@ficha')
->name('coordinador.caso.ficha')->where('run', '[0-9]+')->where('cas_id', '[0-9]+');
        //                 Route::get('/caso/{run?}', 'CasoController@ficha')
    // ->name('coordinador.caso.ficha')->where('run', '[0-9]+');
    //->name('coordinador.caso.ficha')->middleware('validar.ficha');
// FIN CZ SPRINT 63 Casos ingresados a ONL

    
	
                    // INICIO CZ SPRINT 60
                    Route::get('get/data/caso/actualizarEstadoDireccion', 'CasoController@actualizarEstadoDireccion')->name('actualizar.estado.direccion');
                    //FIN CZ SPRINT 60
                    
                    //Inicio Andres F.
                    //Route::get('/caso/correo', 'CasoController@envioCorreo')
                    //    ->name('correo'); //Esta era la función de prueba que se comenta para que no quedes disponible
                    //Fin Andres F.
// INICIO CZ SPRINT 63 Casos ingresados a ONL
Route::get('/atencion-nna/{run?}/{idcaso?}', 'CasoController@atencionNNA')
    ->name('atencion-nna')->where('run', '[0-9]+');
        //                 Route::get('/atencion-nna/{run?}', 'CasoController@atencionNNA')
    // ->name('atencion-nna')->where('run', '[0-9]+');
// FIN CZ SPRINT 63 Casos ingresados a ONL	
Route::get('/historial-nna/{run?}/{idcaso?}', 'CasoController@historialNNA')
->name('historial-nna')->where('run', '[0-9]+');
//                 Route::get('/historial-nna/{run?}', 'CasoController@historialNNA')
// ->name('historial-nna')->where('run', '[0-9]+');
// FIN CZ SPRINT 63 Casos ingresados a ONL

                    
                    Route::get('/casos/cartola/{run?}', 'CasoController@generarCartolaRsh')
	->name('caso.cartola')->where('run', '[0-9]+');
                    
                    Route::get('/casos/ficha-rapida/{run?}','CasoController@fichaRapida')
    ->name('casos.ficha.rapida')->where('run', '[0-9]+');
                    
                    Route::post('/caso/verificar', 'CasoController@verificar')
    ->name('coordinador.caso.verificar');
                    
                    Route::post('/caso/asignar', 'CasoController@asignar')
    ->name('coordinador.caso.asignar');
                    
                    Route::post('/caso/agregarcontacto', 'CasoController@agregarContacto')
	->name('coordinador.caso.agregar.contacto');
                    
                    Route::get('/caso/datacontacto/{id}', 'CasoController@dataContacto')
	->name('coordinador.caso.data.contacto')->where('id', '[0-9]+');
                    //inicio AF
                    Route::get('/caso/actualizacategoria', 'CasoController@actualizacategoria')
                    ->name('coordinador.caso.actualiza.categoria');
                    //fin AF
                    Route::post('/caso/editarcontacto', 'CasoController@editarContacto')
	->name('coordinador.caso.editar.contacto');
                    
                    Route::get('/caso/datadireccion', 'CasoController@dataDireccion')
	->name('coordinador.caso.data.direccion');
                    
                    Route::post('/caso/editardiraccion', 'CasoController@editarDireccion')
	->name('coordinador.caso.editar.direccion');
                    
                    Route::post('/caso/asignacionmasiva', 'CasoController@asignacionMasiva')
	->name('coordinador.caso.asignacion.masiva');
                    
                    Route::post('/caso/rechazar', 'CasoController@rechazar')
	->name('gestor.caso.rechazar');
                    
                    Route::get('ultimosbeneficios/{run?}', 'CasoController@ultimosBeneficios')
	->name('ultimosbeneficios')->where('run', '[0-9]+');
                    
                    Route::get('historicobeneficios/{run?}', 'CasoController@historicoBeneficios')
	->name('historicobeneficios')->where('run', '[0-9]+');
                    
                    Route::get('listar/casos/desestimados', 'CasoController@listarCasosDesestimados')
	->name('listar.casos.desestimados');
    //INICIO CZ SPRINT 72 
                    Route::get('obtener/estados/desestimados', 'CasoController@getEstadosDesestimados')
                    ->name('obtener.estados.desestimados');
                    //FIN CZ SPRINT 72 
                    Route::get('/data/casos/desestimados', 'CasoController@dataCasosDesestimados')
	->name('data.casos.desestimados');
                    
                    Route::get('egreso/casos/desestimados', 'CasoController@egresoCasosDesestimados')
	->name('egreso.casos.desestimados');
                    
                    Route::get('/programaByProyecto/{id}', 'CasoController@programaSeguimiento')->name('programa.seguimiento');
                    
                    Route::get('/cargar/formulario/seguimiento/casos/desestimados', 'CasoController@cargarFormularioSeguimientoCasosDesestimados')->name('cargar.formulario.seguimiento.casos.desestimados');
                    
                    Route::get('casos/verificar/opd', 'CasoController@nomGesVerificarOpd')
	->name('casos.verificar.opd');
                    
                    /*
 * Agregar nueva  direccion al Caso
 * */
                    Route::get('/caso/agregar/direccion', 'CasoController@agregarDireccion')
	->name('caso.agregar.direccion');
                    
                    Route::get('/provincias/porregion/{id_region?}', 'ProvinciaController@porRegion')
	->name('provincias.por.region');
                    
                    Route::get('/comunas/porprovincia/{id_provincia?}', 'ComunaController@porProvincia')
	->name('comunas.por.provincia');
                    
                    //derivar caso
                    Route::get('/casos/{caso}/derivar', 'CasoController@derivarShow')->name('derivar.show')
	->where('caso', '[0-9]+');
                    Route::post('/casos/{caso}/derivar', 'CasoController@derivarActualizar')->name('derivar.actualizar')
	->where('caso', '[0-9]+');
                    
                    //agenda
                    Route::get('/agendas/{caso?}', 'AgendaController@show')->name('agendas.mostrar')->where('caso', '[0-9]+');
                    Route::get('/agendas/generar', 'AgendaController@generar')->name('agendas.generar');
                    Route::get('/agendas/generar_grupal', 'AgendaController@generarGrupal')->name('agendas.grupal');
                    
                    // Diagnostico - NFAS
                    Route::get('/diagnostico/{caso}', 'DiagnosticoController@show')->name('caso.diagnostico')->where('caso', '[0-9]+');
                    
                    Route::get('/diagnostico/grabar', 'DiagnosticoController@grabarDiagnostico')->name('caso.diagnostico.grabar');
                    
                    Route::post('/diagnostico/cambiar/fase', 'DiagnosticoController@cambiarFase')->name('caso.diagnostico.cambiar.fase');
                    
                    Route::post('/frm/encuesta', 'DiagnosticoController@frmGrabarDiagnostico')->name('frm.encuesta');
                    
                    // sesiones
                    Route::get('/casos/{caso}/sesiones', 'SesionController@mainIndividuales')->name('sesiones.index')
	->where('caso', '[0-9]+');
                    Route::post('/casos/{caso}/sesiones', 'SesionController@grabarIndividuales')->name('sesiones.grabar')
	->where('caso', '[0-9]+');
                    Route::get('/casos/{caso}/sesiones/{ses_id}', 'SesionController@show')->name('sesiones.show')
	->where(['caso' => '[0-9]+', 'ses_id' => '[0-9]+']);
                    Route::post('/casos/{caso}/sesiones/{ses_id}', 'SesionController@actualizar')->name('sesiones.actualizar')
	->where(['caso' => '[0-9]+', 'ses_id' => '[0-9]+']);
                    
                    Route::get('/casos/sesiones/validar/{caso_id?}', 'SesionController@valSesionesIndividualesNNA')->name('sesiones.individuales.validar')
    ->where(['caso_id' => '[0-9]+']);
                    
                    Route::get('docpaf/{id?}', 'CasoController@listarDocPaf')->name('doc.paf');
                    
                    // sesiones grupales
                    Route::get('/sesiones/grupales/main', 'SesionController@showGrupal')->name('sesiones.grupal.index');
                    Route::post('/sesiones/grupales', 'SesionController@crearGrupal')->name('sesiones.grupal.crear');
                    //Route::post('/sesiones/grupales/{gru_id}', 'SesionController@actualizarGrupal')->name('sesiones.grupal.actualizar');
                    Route::get('/sesiones/grupales', 'SesionController@getSesionesGrupales')->name('sesiones.grupal.listar');
                    Route::get('/sesiones/grupales/crear/{gru_id?}', 'SesionController@getFormGrupal')->name('sesiones.grupal.form');
                    
                    Route::get('/sesiones/grupales/asignar/{gru_id?}', 'SesionController@getFormAsignar')->name('sesiones.grupal.form.asignar');
                    Route::post('/sesiones/grupales/asignar/{gru_id?}', 'SesionController@asignarGrupal')->name('sesiones.grupal.asignar');
                    
                    Route::get('/sesiones/listar/', 'SesionController@getSesionesIndividuales')->name('sesiones.listar');
                    
                    Route::get('/casos/sesiones/{ses_id?}', 'SesionController@show')->name('sesiones.showFrm')
	->where(['ses_id' => '[0-9]+']);
                    
                    
                    Route::get('sesiones/grupales/validar/{caso_id?}', 'SesionController@valSesionesGrupalesNNA')->name('sesiones.grupal.validar')
	->where(['caso_id' => '[0-9]+']);
                    
                    //Reportes
                    Route::get('/coordinador/casos/reportes', 'PruebaController@show')->name('coordinador.caso.reporte');
                    
                    Route::get('/rsh/{run}', 'PruebaController@rsh');
                    Route::get('/rsh2/{run}', 'PruebaController@rsh2');
                    
                    // login
                    Route::get('/login', 'LoginController@index')->name('login');
                    Route::get('/logout/', 'LoginController@logout')->name('logout');
                    
                    // usuarios
                    Route::get('/administrador/usuarios/', 'UsuarioController@listar')->name('usuarios.index');
                    Route::get('/administrador/usuario/grabar/{id}', 'UsuarioController@showFormGrabar')->name('usuarios.show');
                    Route::post('/administrador/usuario/grabar/', 'UsuarioController@aGrabar')->name('usuarios.update');
                    Route::post('/administrador/usuario/pass/', 'UsuarioController@aPass');
                    Route::post('/administrador/api/usuarios/get-usuarios', 'UsuarioController@apiGetUsuario')->name('usuarios.api');
                    
                    // parametros
                    Route::post('/administrador/api/parametros/get-parametros', 'ParametroController@apiGetParametro');
                    Route::get('/adm/sistema/parametro/', 'AdmController@indexParametro');
                    Route::post('/adm/sistema/parametro/editar/', 'AdmController@aEditar');
                    Route::get('/adm/sistema/parametro/agregar/{id}', 'AdmController@agregar');
                    Route::post('/adm/sistema/parametro/agregar/', 'AdmController@aAgregar');
                    Route::get('/adm/sistema/parametro/agregarmantenedor/', 'AdmController@agregarMantenedor');
                    Route::post('/adm/sistema/parametro/agregarmantenedor/', 'AdmController@aAgregarMantenedor');
                    
                    
                    //administrador
                    Route::get('/administrador/main', 'AdmController@main');
                    //parametros
                    Route::get('/administrador/mantenedores/parametros/', 'ParametroController@listar');
                    //acciones
                    Route::get('/administrador/mantenedores/parametros/grabar/{id}', 'ParametroController@grabar');
                    Route::post('/administrador/mantenedores/parametros/grabar/', 'ParametroController@aGrabar');
                    Route::get('/administrador/mantenedores/parametros/ingresar/{id_padre}', 'ParametroController@ingresar');
                    Route::get('/administrador/mantenedores/mantenedor/ingresar/', 'ParametroController@grabarMantenedor');
                    Route::post('/administrador/mantenedores/mantenedor/grabar/', 'ParametroController@aGrabarMantenedor');
                    
                    Route::get('file/{adj_id}', 'FileController@getFile')->name('adjunto');
                    
                    // Mantenedor de Ofertas
                    Route::get('ofertas/main', 'OfertasController@main')->name('ofertas.main');
                    Route::get('ofertas/mapa', 'OfertasController@mapa')->name('ofertas.mapa');
                    Route::get('ofertas/listar', 'OfertasController@listarOfertas')->name('ofertas.listar');
                    Route::get('ofertas/crear/{prog_id?}','OfertasController@crearOferta')->name('ofertas.crear');
                    Route::post('ofertas/insertar', 'OfertasController@insertarOferta')->name('ofertas.insertar');
                    Route::get('ofertas/editar/{ofe_id?}', 'OfertasController@editarOferta')->name('ofertas.editar');
                    Route::post('ofertas/actualizar', 'OfertasController@actualizarOferta')->name('ofertas.actualizar');
                    Route::get('ofertasprogramas','OfertasController@reportePorPrograma')->name('ofertas.programas');
                    
                    Route::get('ofertasalertas','OfertasController@reportePorTipoAlerta')->name('ofertas.alertas');
                    
                    
                    Route::get('ofertas/mapa/exportable', 'OfertasController@descargarMapaExportable')->name('ofertas.mapa.exportable');
                    // Route::get('ofertas/listar1/{id?}', 'OfertasController@listarComunaPrograma')->name('ofertas.listar1');
                    
                    Route::get('buscaresponsable/{id?}', 'OfertasController@buscarResponsable')->name('buscar.responsable');
                    
                    Route::get('ofertasnombre', 'OfertasController@OfertasNombre')->name('ofertas.nombre');
                    
                    // Mantenedor de Acciones
                    Route::get('accion/main', 'AccionController@main')->name('accion.main');
                    Route::get('accion/listar', 'AccionController@listarAccion')->name('accion.listar');
                    Route::get('accion/crear/{acc_id?}', 'AccionController@crearAccion')->name('accion.crear');
                    
                    // Dimensiones
                    Route::get('dimension/listar/resultado', 'DimensionController@resultadoNCFAS')->name('dimension.listar.resultado');
                    Route::get('dimension/main', 'DimensionController@main')->name('dimension.main');
                    Route::get('dimension/listar', 'DimensionController@listarDimension')->name('dimension.listar');
                    Route::get('dimension/crear/{dim_id?}', 'DimensionController@crearDimension')->name('dimension.crear');
                    Route::post('dimension/insertar', 'DimensionController@insertarDimension')->name('dimension.insertar');
                    Route::post('dimension/actualizar', 'DimensionController@actualizarDimension')->name('dimension.actualizar');
                    
                    // Mantenedor de Alertas
                    Route::get('alertas/listar', 'AlertaController@index')->name('alertas.listar');
                    Route::get('alertas', 'AlertaController@listarAlertas')->name('alertas');
                    Route::get('alertas/filtro/{id?}', 'AlertaController@listarAlertasFiltro')->name('alertas.filtro');
                    Route::get('alertas/tipo/validar', 'AlertaController@validarIngresoTipoAlerta')
	->name('alertas.tipo.validar');
                    
                    // Validar AT Run asignado a Gestor
                    
                    Route::get('alertas/validar/gestor/run', 'AlertaController@permisoAgregarAT')->name('validar.gestor.run');
                    
                    Route::get('alertas/crear/{run?}', 'AlertaController@crearAlertas')->name('alertas.crear');
                    //Route::get('alertas/crear', 'AlertaController@crearAlertas')->name('alertas.crear');
                    
                    Route::get('alerta/editar/{id?}', 'AlertaController@editarAlerta')->name('alerta.editar');
                    
                    Route::post('/alerta/oferta', 'AlertaController@ofertaRegistrar')->name('alertas.oferta');
                    
                    Route::get('/misalertas', 'AlertaController@misalertas')->name('misalertas');
                    
                    Route::get('/rut/{rut?}', 'AlertaController@getRut')->name('alertas.rut');
                    Route::get('alertastipo', 'AlertaController@alertatipo')->name('alertas.tipo');
                    Route::get('alertaTipoReg/{id?}', 'AlertaController@alertaTipoReg')->name('alertas.tipo.reg');
                    
                    Route::get('ofertatipo/{ids?}/{cod_com?}', 'AlertaController@ofertas')->name('ofertas.tipo');
                    
                    // Alertas Externas
                    // Route::get('/alertas/', 'AlertaController@index')->name('alertas.index');
                    Route::post('/alertas/frm', 'AlertaController@registrarAlerta')->name('alertas.registrar');
                    
                    Route::get('/alertas/listar/nnasinrun/', 'AlertaController@listarNNAsinRun')->name('alertas.listar.sinrun');
                    
                    Route::get('/alertas/consulta/nnasinrun/', 'AlertaController@consultaNNAsinRun')->name('alertas.consulta.sinrun');
                    
                    Route::post('elaborarpaf', 'AlertaController@elaborarPaf')->name('elaborar.paf');
                    
                    Route::get('/elaborarpaf/desplegar/asignar', 'AlertaController@listarProgramaIntegrante')
	->name('elaborarpaf.desplegar.asignar');
                    
                    Route::get('/elaborarpaf/desplegar/guardar', 'AlertaController@guardarAsignacionPrograma')
	->name('elaborarpaf.desplegar.guardar');
                    
                    Route::get('/elaborarpaf/desplegar/desestimar', 'AlertaController@desestimarAsignacionPrograma')
	->name('elaborarpaf.desplegar.desestimar');
                    
                    // ------------------------ASIGNAR Y DESESTIMAR PROGRAMAS SIN ALERTAS-------------
                    
                    Route::get('/asignar/programas/sinalertas','ProgramaController@guardarAsignacionProgramaSinAlertas')
	->name('asignar.programas.sinalertas');
                    
                    Route::get('/listar/programas/sinalertas','ProgramaController@listarAsignacionProgramaSinAlertas')
	->name('listar.programas.sinalertas');
                    
                    Route::get('/desestimar/programas/sinalertas','ProgramaController@desestimarAsignacionProgramaSinAlertas')
	->name('desestimar.programas.sinalertas');
	
                    // ----------------------FIN ASIGNAR Y DESESTIMAR PROGRAMAS SIN ALERTAS-----------
                    
                    
                    // Route::post('/elaborarpaf', 'AlertaController@elaborarPaf')->name('doc.paf');
                    Route::post('enviararh','AlertaController@enviararh')->name('enviararh');
                    
                    Route::post('enviararhcons','AlertaController@enviararhcons')->name('enviararhcons');
                    
                    Route::get('/problematicas/{dim_id?}', 'AlertaController@getProblematica')->name('alertas.problematica');
                    
                    Route::get('/imprimirpaf/{run?}/{cas_id?}','AlertaController@imprimir')->name('imprimir.paf')->where('run', '[0-9]+');
                    
                    Route::post('enviararh', 'AlertaController@enviararh')->name('enviararh');
                    
                    // Mantenedor de Programa
                    // rruiz 09052019 => se encierran las rutas con middleware auth
                    Route::group(['middleware' => ['auth', 'verificar.configuracion.comuna']], function () {
	Route::get('programa/main', 'ProgramaController@main')->name('programa.main');
	Route::get('programa/listar/{prog_id?}', 'ProgramaController@listarPrograma')->name('programa.listar');
	Route::get('programa/crear/{prog_id?}', 'ProgramaController@crearPrograma')->name('programa.crear');
	Route::post('programa/insertar', 'ProgramaController@insertarPrograma')->name('programa.insertar');
	Route::post('programa/actualizar', 'ProgramaController@actualizarPrograma')->name('programa.actualizar');
	Route::get('programa/eliminar_establecimiento/', 'ProgramaController@eliminarEstablecimiento')->name('programa.eliminar_establecimiento');
	Route::get('programa/comuna', 'ProgramaController@listarProgramaXcomuna')->name('programa.comuna');
	Route::get('programa/brecha_nna/{id_brecha?}/{cas_id?}/{grup_fam_id?}', 'ProgramaController@buscarBrechaNna')->name('brechaPorNna');
	Route::get('programa/generar_brecha/{prog_id?}/{cas_id?}/{grup_fam_id?}/{id_alerta?}', 'ProgramaController@generarBrecha')->name('generarBrecha');
	Route::get('programa/guardar_observacion_brecha/{id_brecha?}/{observacion?}', 'ProgramaController@guardarObservacionBrecha')->name('guardarObservacionBrecha');
	Route::get('programa_con_brechas', 'ProgramaController@listarProgramasConBrechas')->name('listarProgramasConBrechas');
	Route::get('vistaProgramasConBrechas', 'ProgramaController@vistaProgramasConBrechas')->name('vistaProgramasConBrechas');
	Route::get('listarBrechas/{id_brecha?}', 'ProgramaController@listarBrechas')->name('listarBrechas');
	Route::get('finalizarBrecha/{id_brecha_integrante?}', 'ProgramaController@finalizarBrecha')->name('finalizarBrecha');
	Route::get('BitacoraBrecha/{id_brecha?}', 'ProgramaController@BitacoraBrecha')->name('BitacoraBrecha');
	Route::get('grabarBrecha/{id_brecha?}/{bitacora?}', 'ProgramaController@grabarBrecha')->name('grabarBrecha');
                        
	//Administrador Central
	Route::get('intervenciones', 'CasoController@filtrarIntervenciones')->name('intervenciones');
	Route::get('ExcelIntervenciones', 'ReporteController@descargarIntervencionesExport')->name('ExcelIntervenciones');
                        
                        
                    });
                        
                        
                        
                        //Ficha
                        Route::get('/firma/consentimiento', 'CasoController@firmaConsentimiento')->name('firma.consentimiento');
                        
                        Route::post('adjuntapaf/', 'CasoController@adjuntapaf')->name('adjuntapaf');
                        
                        Route::post('listarpaf/', 'CasoController@listarPaf')->name('listar.paf');
                        
                        Route::get('validancfas/', 'CasoController@validancfas')->name('valida.ncfas');
                        
                        //inicio dc
                        
                        Route::get('getDefinicion/', 'CasoController@getDefinicion')->name('get.definicion');
                        
                        Route::get('plan.estrategico/', 'GestionComunitariaController@insPlanEstrategico')->name('plan.estrategico');
                        
                        Route::get('getPlanEstrategico/', 'GestionComunitariaController@getPlanEstrategico')->name('get.plan.estrategico');
                        
                        Route::get('getAnexosPec/', 'GestionComunitariaController@getAnexosPec')->name('get.anexos.pec');
                        
                        Route::get('getEstrategiaPlan/', 'GestionComunitariaController@getEstrategiaPlan')->name('get.estrategia.plan');
                        
                        Route::get('obtenerPlanEstrategico/', 'GestionComunitariaController@obtenerPlanEstrategico')->name('obtener.plan.estrategico');
                        
                        Route::get('getActividadPlanEstrategico/', 'GestionComunitariaController@getActividadPlanEstrategico')->name('get.actividad.plan.estrategico');
                        
                        Route::get('getActividadInf/', 'GestionComunitariaController@getActividadInf')->name('get.actividad.inf');
                        
                        Route::get('editPlanEstrategico/', 'GestionComunitariaController@editPlanEstrategico')->name('edit.plan.estrategico');
                        
                        Route::get('editActividadPe/', 'GestionComunitariaController@editActividadPe')->name('edit.actividad.pe');
                        
                        Route::get('deleteActividadPe/', 'GestionComunitariaController@deleteActividadPe')->name('delete.actividad.pe');
                        
                        //INICIO DC SPRINT 63
                        Route::post('guardarInformePe', 'GestionComunitariaController@guardarInformePe')->name('guardar.informe.pe');
                        //FIN DC SPRINT 63
                        
                        Route::get('getInformePec/', 'GestionComunitariaController@getInformePec')->name('get.informe.pec');
                        
                        Route::get('doc1AnexoPEC/', 'GestionComunitariaController@doc')->name('descarga.anexo.pec');
                        
                        Route::get('eliminaAnexoPec/', 'GestionComunitariaController@eliminaAnexoPec')->name('elimina.anexo.pec');
                        
                        Route::get('getDatosPec/', 'GestionComunitariaController@getDatosPec')->name('get.datos.pec');
                        
                        //INICIO DC SPRINT 63
                        Route::post('guardarDatosPec/', 'GestionComunitariaController@guardarDatosPec')->name('guardar.datos.pec');
                        //FIN DC SPRINT 63
                        
                        Route::get('verificaEstadoPec/', 'GestionComunitariaController@verificaEstadoPec')->name('verifica.estado.pec');
                        
                        Route::get('validaObjetivos/', 'GestionComunitariaController@validaObjetivos')->name('valida.objetivos');
                        
                        Route::get('getPlazo/', 'GestionComunitariaController@getPlazo')->name('get.plazo');
                        
                        Route::get('getEstado/', 'GestionComunitariaController@getEstado')->name('get.estado');
                        
                        Route::get('getEstadoTera/', 'GestionComunitariaController@getEstadoTera')->name('get.estadoTera');
                        
                        Route::get('getEstadoNNA/', 'GestionComunitariaController@getEstadoNNA')->name('get.estadoNNA');
                        
                        //fin dc
                        
                        Route::get('validadoccons/', 'CasoController@validadoccons')->name('valida.doc.cons');
                        
                        Route::get('/pruebas', 'AlertaController@prueba')->name('pruebas');
                        
                        Route::get('validaralertaspendientes','CasoController@validarAlertasPendientes')
	->name('validar.alertas.pendientes');
                        
                        //Notificaciones
                        Route::get('/buscar/notificaciones','NotificacionesController@Notificaciones')
	->name('buscar.notificaciones');
                        
                        //Grupo Familiar
                        Route::get('/listar/grupo/familiar','CasoGrupoFamiliarController@listarGrupoFamiliar')->name('listar.grupo.familiar');
                        Route::get('/listar/grupo/familiarAraña','CasoGrupoFamiliarController@listarGrupoFamiliarAraña')->name('listar.grupo.familiarAraña');
                        Route::get('/formulario/acciones/familiar', 'CasoGrupoFamiliarController@accionesFormularioFamiliar')
	->name('formulario.acciones.familiar');
	
                        Route::get('listarsegprest/{id?}', 'CasoController@listarSegPrest')->name('listarsegprest');
                        
                        Route::get('listarsegprestsinat/{id?}', 'CasoController@listarSegPrestSinAt')->name('listarsegprestasinat');
                        
                        Route::get('ver/familiar','GrupoFamiliarController@verFamiliar')->name('ver.familiar');
                        
                        //Route::get('listarsegprest/{id?}', 'CasoController@listarSegPrest')->name('listarsegprest');
                        
                        Route::get('seguimiento/ver/historial/prestacion','CasoController@verHistorialEstadosPrestacion')
	->name('seguimiento.ver.historial.prestacion');
                        
                        Route::get('seguimiento/ver/historial/prestacion/sinat','CasoController@verHistorialEstadosPrestacionSinAT')
	->name('seguimiento.ver.historial.prestacion.sin.at');
                        
                        Route::get('validar/parentesco/integrante','CasoController@validarParentescoIntegrante')
	->name('validar.parentesco.integrante');
	
                        // BOTONERA PROCESOS ATENCION NNA
                        
                        Route::get('proceso/atencion/caso','CasoController@procesoAtencionCaso')
	->name('proceso.atencion.caso');
                        
                        Route::get('listar/visitas/diagnostico','CasoController@listarVisitasDiagnostico')
	->name('listar.visitas.diagnostico');
                        
                        Route::get('/formulario/acciones/visitas','CasoController@accionesFormularioVisitas')
	->name('formulario.acciones.visitas');
                        
                        Route::get('/consulta/runificador', 'CasoController@runificador')
	->name('consulta.runificador');
                        
	
    // INICIO CZ SPRINT 63 Casos ingresados a ONL
                        Route::get('ObtenerNNA', 'CasoController@obtenerNNA')->name('consulta.obtenerNNA');
    // INICIO CZ SPRINT 63 Casos ingresados a ONL                    
                        //TEST
                        
                        Route::get('/test_prueba', 'PruebaController@test_prueba')->name('test_prueba');
                        
                        Route::get('/configuracion/comuna/aplicar', 'LoginController@AplicarConfiguracionDeComuna')->name('configuracion.comuna.aplicar');
                        
                        Route::get('/configuracion/comuna/modificar',  function(){
        Session::put('configurar_comuna', true);
        
        return redirect()->route('main');
                        })->name('configuracion.comuna.modificar');
                        
                        
                        Route::get('atencion-nna/proceso/atencion/verificarDiagnostico/{caso_id}','CasoController@verificarDiagnostico')
	->name('proceso.atencion.verificarDiagnostico');
                        
                        Route::get('atencion-nna/proceso/atencion/verificarElaborarPaf/{caso_id}','CasoController@verificarElaborarPaf')
	->name('proceso.atencion.verificarElaborarPaf');
                        
                        Route::get('atencion-nna/proceso/atencion/verificarEvaluacionPaf/{caso_id}','CasoController@verificarEvaluacionPaf')
	->name('proceso.atencion.verificarEvaluacionPaf');
                        
                        Route::get('atencion-nna/proceso/atencion/verificarEgresoPaf/{caso_id}','CasoController@verificarEgresoPaf')
	->name('proceso.atencion.verificarEgresoPaf');
                        
                        Route::get('atencion-nna/proceso/atencion/verificarEjecucionPaf/{caso_id}','CasoController@verificarEjecucionPaf')
	->name('proceso.atencion.verificarEjecucionPaf');
	
                        Route::post('enviarencsati','AlertaController@enviarencsati')->name('enviarencsati');
                        
                        // SEGUIMIENTO PAF
                        
	Route::get('data/seguimiento/pendientes','CasoController@dataProgAleTarAcPen')
	->name('data.seguimiento.pendientes');
                        
	Route::get('data/seguimiento/tareas/pendientes','CasoController@dataTarPen')
	->name('data.seguimiento.tar.pen');
                        
	Route::get('data/seguimiento/derivaciones/pendientes','CasoController@dataDerPen')
	->name('data.seguimiento.der.pen');
                        
	Route::get('data/seguimiento/alertas/pendientes','CasoController@dataAlePen')
	->name('data.seguimiento.ale.pen');
                        
	Route::get('ingreso/reporte/seguimiento','CasoController@ingresoRptSeg')
	->name('ingreso.rpt.seg');
                        
	Route::get('ficha/registro/seguimiento','CasoController@levantarFichaRegistroSeguimiento')
	->name('ficha.registro.seguimiento');
                        
	Route::get('ultimo/reporte/seguimiento','CasoController@ultimoRepSeg')->name('ultimo.reporte.seguimiento');
                        
                        // FIN SEGUIMIENTO PAF
                        
                        //TERAPEUTA
                        // INICIO CZ SPRINT 63 Casos ingresados a ONL
                        Route::get('/gestion-terapia-familiar/{run?}/{idcaso?}', 'CasoController@gestionTerapiaFamiliar')->name('gestion-terapia-familiar')->where('run', '[0-9]+');
                        // FIN CZ SPRINT 63 Casos ingresados a ONL
                        
                        Route::get('proceso/terapia/caso','TerapiaController@procesoTerapiaCaso')->name('proceso.terapia.caso');
                        
                        Route::get('proceso/datos/sesiones','CasoController@getDatosSesiones')->name('listar.datos.sesiones');
                        // INICIO CZ SPRINT 69
                        Route::get('proceso/datos/sesiones_2021','TerapiaController@getDatosSesiones_2021')->name('listar.datos.sesiones_2021');
                        // FIN CZ SPRINT 69
                        //inicio ch
                        Route::get('proceso/datos/sesionesfm','CasoController@getDatosSesionFamiliar')->name('listar.datos.sesionesfm');
                        // INICIO CZ SPRINT 69
                        Route::get('proceso/datos/sesionesfm_2021','TerapiaController@getDatosSesionFamiliar_2021')->name('listar.datos.sesionesfm_2021');
                        // FIN CZ SPRINT 69
                        //fin ch
                        
                        
                        // PLANIFICACIÓN DE SESIONES DE TERAPIA
                        //INGRESO FICHA
                        Route::get('planificar/sesiones-terapia-familiar/nna','TerapiaController@sesionesTerapiaFamiliar')->name('planificarSesionesTerapiaFamiliarNNA');
                        
                        //INGRESO MENU
                        Route::get('planificar/sesiones-terapia-familiar/','TerapiaController@sesionesTerapiaFamiliar')->name('planificarSesionesTerapiaFamiliar');
                        
                        Route::get('get-sesiones-terapia-familiar','TerapiaController@getSesionesTerapiaFamiliar')->name('getSesionesTerapiaFamiliar');
                        
                        Route::post('guardar-sesiones-terapia-familiar','TerapiaController@insertarSesionesTerapiaFamiliar')->name('registrarSesionesTerapiaFamiliar');
                        
                        Route::get('eliminar-sesiones-terapia-familiar','TerapiaController@eliminarSesionesTerapiaFamiliar')->name('eliminarSesionesTerapiaFamiliar');
                        
                        Route::get('planificar/sesiones-terapia-familiar/validar','TerapiaController@validarRunSesionTerapia')->name('planificar.sesionesTerapiaFamiliar.validar');
                        // PLANIFICACIÓN DE SESIONES DE TERAPIA
                        
                        Route::post('documentoinvitacionterapia','TerapiaController@documentoInvitacionTerapia')->name('documento.invitacion.terapia');
                        
                        Route::post('documentoencsatter','TerapiaController@documentoEncSatTer')->name('documento.enc.sat.ter');
                        
                        Route::post('documento/carta/renuncia','TerapiaController@documentoRenuncia')->name('documento.carta.renuncia');
                        
                        Route::get('/terapia/asignar_terapeuta', 'TerapiaController@asignarTerapeuta')
                        ->name('terapia.asignar_terapeuta');
                        
                        Route::get('/terapia/re_asignar_terapeuta', 'TerapiaController@reAsignarTerapeuta')
                        ->name('terapia.re_asignar_terapeuta');
                        
                        Route::get('data/terapia/asignar_terapeuta/', 'TerapiaController@dataAsignarTerapeuta')
                        ->name('data.terapia.asignar_terapeuta');
                        
                        Route::get('data/terapia/asignar_terapeuta/crearTerapia', 'TerapiaController@crearTerapia')
                        ->name('data.terapia.asignar_terapeuta.crear_terapia');
                        
                        Route::get('data/terapia/asignar_terapeuta/justificacionTerapia', 'TerapiaController@justificacionTerapia')
                        ->name('data.terapia.asignar_terapeuta.justificacion_terapia');
                        
                        Route::get('data/terapia/asignar_terapeuta/nombreGestor', 'TerapiaController@nombreGestor')
                        ->name('data.terapia.asignar_terapeuta.nombreGestor');
                        
                        Route::get('consultar/pau/trab/fam/ter', 'TerapiaController@consultarPauFrabFamTer')
                        ->name('consultar.pau.trab.fam.ter');
                        
                        Route::get('buscar/definicion/problema', 'TerapiaController@buscarDefinicionProblema')
                        ->name('buscar.definicion.problema');
                        
                        Route::post('guardar/definicion/problema', 'TerapiaController@guardarDefinicionProblema')
                        ->name('guardar.definicion.problema');
                        
                        Route::post('guardar/pauta/trabajo/fam/ter','TerapiaController@guardarPauTrabFamTer')
                        ->name('guardar.pauta.trabajo.fam.ter');
                        
                        Route::get('buscar/descripcion/funcionamiento', 'TerapiaController@buscarDescripcionFuncionamiento')
                        ->name('buscar.descripcion.funcionamiento');
                        
                        Route::post('guardar/descripcion/funcionamiento', 'TerapiaController@guardarDescripcionFuncionamiento')->name('guardar.descripcion.funcionamiento');
                        
                        Route::post('guardar/documento/genograma', 'TerapiaController@guardarDocumentoGenograma')->name('guardar.documento.genograma');
                        
                        Route::get('gestion/terapia/verificar/diagnostico','TerapiaController@verificarDiagnostico')->name('gestion.terapia.verificar.diagnostico');
                        
                        Route::get('gestion/terapia/verificar/ejecucion','TerapiaController@verificarEjecucion')->name('gestion.terapia.verificar.ejecucion');
                        
                        Route::get('gestion/terapia/verificar/seguimiento','TerapiaController@verificarSeguimiento')->name('gestion.terapia.verificar.seguimiento');
                        
                        Route::get('gestion/terapia/verificar/invitacion','TerapiaController@verificarInvitacion')->name('gestion.terapia.verificar.invitacion');
                        
                        Route::get('/terapia/cambio/estado', 'TerapiaController@cambioEstadoTerapia')
	->name('terapia.cambio.estado');
                        
                        Route::get('/terapia/cambio/bitacora', 'TerapiaController@cambioBitacoraTerapia')
	->name('terapia.cambio.bitacora');
                        
                        
                        Route::post('guardar/documento/plan/terapia', 'TerapiaController@guardarDocumentoPlanTerapia')->name('guardar.documento.plan.terapia');
                        
                        Route::get('listar/historial/plan/terapia', 'TerapiaController@listarHistorialPlanTerapiaFamiliar')
	->name('listar.historial.plan.terapia');
                        
                        Route::get('/terapia/listarPtfSesion', 'TerapiaController@listarPtfSesion')
                        ->name('terapia.listarPtfSesion');
                        // INICIO CZ SPRINT 69
                        Route::get('/terapia/listarPtfSesion_2021', 'TerapiaController@listarPtfSesion_2021')
                        ->name('terapia.listarPtfSesion_2021');
                        // FIN CZ SPRINT 69
                        Route::get('/terapia/listarPtfTaller', 'TerapiaController@listarPtfTaller')
                        ->name('terapia.listarPtfTaller');
                        
                        Route::post('/terapia/guardarPtfDetalle', 'TerapiaController@guardarPtfDetalle')
                        ->name('terapia.guardarPtfDetalle');
                        // INICIO CZ SPRINT 69
                        Route::post('/terapia/guardarPtfDetalle_2021', 'TerapiaController@guardarPtfDetalle_2021')
                        ->name('terapia.guardarPtfDetalle_2021');
                       // FIN CZ SPRINT 69
                        
                        Route::get('gestion-terapia-familiar/evaluacion/{tera_id}', 'EvaluacionController@show')->name('gestion-terapia-familiar.evaluacion')->where('tera_id', '[0-9]+');
                        
                        Route::post('gestion-terapia-familiar/evaluacion/guardar/temporal', 'EvaluacionController@guardarEvaluacionTemporal')->name('gestion-terapia-familiar.evaluacion.guardar.temporal');
                        
                        Route::post('gestion-terapia-familiar/evaluacion/finalizar', 'EvaluacionController@finalizarEvaluacionTerapia')->name('gestion-terapia-familiar.evaluacion.finalizar');
                        
                        // INICIO CZ SPRINT 57
                        Route::post('gestion-terapia-familiar/evaluacion/guardarMotivoTF', 'EvaluacionController@guardarRespuestaEvaluacionMotivoTF')->name('gestion-terapia-familiar.evaluacion.MotivoTF');
                        //FIN CZ SPRINT 57
                        
                        /*Route::post('/diagnostico/grabar', 'DiagnosticoController@grabarDiagnostico')->name('caso.diagnostico.grabar');*/
                        
                        Route::get('/terapia/listarDetalleSeguimiento', 'TerapiaController@listarDetalleSeguimiento')
                        ->name('listar.detalle.seguimiento');
                        
                        Route::get('/formulario/acciones/detalle/seguimiento','TerapiaController@accionesFormularioDetalleSeguimiento')
	->name('formulario.acciones.detalle.seguimiento');
                        
                        Route::get('/casosBitacora/{cas_id?}', 'CasoController@casosBitacora')->name('casos.bitacoraCaso');
                        
                        Route::get('/casos/bitacora/terapia/{cas_id?}', 'TerapiaController@verBitacoraEstadosTerapia')->name('casos.bitacora.terapia');
                        
                        
                        // rptAlertasTerritorialesPorComuna
                        Route::get('rptVistaAlertasTerritorialesPorComuna', 'ReporteController@rptVistaAlertasTerritorialesPorComuna')
                        ->name('rptVistaAlertasTerritorialesPorComuna');
                        
                        //Route::get('rptDataAlertasTerritorialesPorComuna', 'ReporteController@rptDataAlertasTerritorialesPorComuna')->name('rptDataAlertasTerritorialesPorComuna');
                        Route::get('rptDataAlertasTerritorialesPorComuna/{i?}/{ini?}/{fin?}', 'ReporteController@rptDataAlertasTerritorialesPorComuna')->name('rptDataAlertasTerritorialesPorComuna');
                        
                        //Route::get('rptExportAlertasTerritorialesPorComuna', 'ReporteController@descargarAlertasTerritorialesPorComunaExportable')->name('rptExportAlertasTerritorialesPorComuna');
                        Route::get('rptExportAlertasTerritorialesPorComuna/{i?}/{ini?}/{fin?}', 'ReporteController@descargarAlertasTerritorialesPorComunaExportable')->name('rptExportAlertasTerritorialesPorComuna');
                        
                        // rptAlertasTerritorialesPorNna
                        Route::get('rptVistaAlertasTerritorialesPorNna', 'ReporteController@rptVistaAlertasTerritorialesPorNna')
                        ->name('rptVistaAlertasTerritorialesPorNna');
                        
                        //Route::get('rptDataAlertasTerritorialesPorNna', 'ReporteController@rptDataAlertasTerritorialesPorNna')->name('rptDataAlertasTerritorialesPorNna');
                        Route::get('rptDataAlertasTerritorialesPorNna/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@rptDataAlertasTerritorialesPorNna')->name('rptDataAlertasTerritorialesPorNna');
                        
                        //Route::get('rptExportAlertasTerritorialesPorNna', 'ReporteController@descargarAlertasTerritorialesPorNnaExportable')->name('rptExportAlertasTerritorialesPorNna');
                        Route::get('rptExportAlertasTerritorialesPorNna/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@descargarAlertasTerritorialesPorNnaExportable')->name('rptExportAlertasTerritorialesPorNna');
                        
                        //Route::get('rptDataAlertasChileCreceContigo', 'ReporteController@rptDataAlertasChileCreceContigo')->name('rptDataAlertasChileCreceContigo');
                        Route::get('rptDataAlertasChileCreceContigo/{i?}', 'ReporteController@rptDataAlertasChileCreceContigo')->name('rptDataAlertasChileCreceContigo');
                        
                        //Route::get('rptExportAlertasChileCreceContigo', 'ReporteController@descargarAlertasChileCreceContigoExportable')->name('rptExportChileCreceContigo');
                        Route::get('rptExportAlertasChileCreceContigo/{i?}', 'ReporteController@descargarAlertasChileCreceContigoExportable')->name('rptExportChileCreceContigo');
                        
                        // rptRutAsignadoGestor
                        Route::get('rptVistaRutAsignadoGestor', 'ReporteController@rptVistaRutAsignadoGestor')
                        ->name('rptVistaRutAsignadoGestor');
                        // CZ SPRINT 75
                        Route::get('rptDataRutAsignadoGestor', 'ReporteController@rptDataRutAsignadoGestor')->name('rptDataRutAsignadoGestor');
                        // Route::get('rptDataRutAsignadoGestor/{i?}/{ini?}/{fin?}', 'ReporteController@rptDataRutAsignadoGestor')->name('rptDataRutAsignadoGestor');
                        // CZ SPRINT 75
                        Route::get('rptDataRutAsignadoTerapeuta/{i?}/{ini?}/{fin?}', 'ReporteController@rptDataRutAsignadoTerapeuta')->name('rptDataRutAsignadoTerapeuta');
                        
                        //Route::get('rptExportRutAsignadoGestor', 'ReporteController@descargarRutAsignadoGestorExportable')->name('rptExportRutAsignadoGestor');
                         // CZ SPRINT 75
                        Route::get('rptExportRutAsignadoGestor/{i?}/{ini?}/{fin?}/{tipo?}', 'ReporteController@descargarRutAsignadoGestorExportable')->name('rptExportRutAsignadoGestor');
                         // CZ SPRINT 75
                        Route::get('rptExportRutAsignadoTerapeuta/{i?}/{ini?}/{fin?}', 'ReporteController@descargarRutAsignadoTerapeutaExportable')->name('rptExportRutAsignadoTerapeuta');
                        
                        // rptDesestimacionDeCasoGestor
                        Route::get('rptVistaDesestimacionDeCasoGestor', 'ReporteController@rptVistaDesestimacionDeCasoGestor')
                        ->name('rptVistaDesestimacionDeCasoGestor');
                        
                        //Route::get('rptExportDesestimacionDeCasoGestor', 'ReporteController@descargarrptDesestimacionDeCasoGestorExportable')->name('rptExportDesestimacionDeCasoGestor');
                        Route::get('rptExportDesestimacionDeCasoGestor/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptDesestimacionDeCasoGestorExportable')->name('rptExportDesestimacionDeCasoGestor');
                        
                        Route::get('reportes', 'ReporteController@mainReportes')->name('reportes');
                        
                        Route::get('reportes/cargar', 'ReporteController@procesarReportes')->name('reportes.cargar');
                        
                        Route::get('data/reporte/gestion','CasoController@dataReporteGestion')->name('data.reporte.gestion');
                        
                        //Route::get('rptExportDesestimacionDeCasoTerapeuta', 'ReporteController@descargarrptDesestimacionDeCasoTerapeutaExportable')->name('rptExportDesestimacionDeCasoTerapeuta');
                        Route::get('rptExportDesestimacionDeCasoTerapeuta/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptDesestimacionDeCasoTerapeutaExportable')->name('rptExportDesestimacionDeCasoTerapeuta');
                        
                        //Route::get('rptExportEstadoActividadGestionCaso', 'ReporteController@descargarrptEstadoCasoActividadGestionCasoExportable')->name('rptExportEstadoActividadGestionCaso');
                        Route::get('rptExportEstadoActividadGestionCaso/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptEstadoCasoActividadGestionCasoExportable')->name('rptExportEstadoActividadGestionCaso');
                        
                        //Route::get('rptDataMapaOfertas', 'ReporteController@rptDataMapaOfertas')->name('rptDataMapaOfertas');
                        Route::get('rptDataMapaOfertas/{i?}', 'ReporteController@rptDataMapaOfertas')->name('rptDataMapaOfertas');
                        
                        //Route::get('rptExportMapaOfertas', 'ReporteController@descargarrptMapaOfertasExportable')->name('rptExportMapaOfertas');
                        Route::get('rptExportMapaOfertas/{i?}', 'ReporteController@descargarrptMapaOfertasExportable')->name('rptExportMapaOfertas');
                        
                        //Route::get('rptExportEstadoAvance', 'ReporteController@descargarrptEstadoAvanceExportable')->name('rptExportEstadoAvance');
                        Route::get('rptExportEstadoAvance/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptEstadoAvanceExportable')->name('rptExportEstadoAvance');
                        
                        //Route::get('rptExportEstadoAvanceTerapia', 'ReporteController@descargarrptEstadoAvanceTerapiaExportable')->name('rptExportEstadoAvanceTerapia');
                        Route::get('rptExportEstadoAvanceTerapia/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptEstadoAvanceTerapiaExportable')->name('rptExportEstadoAvanceTerapia');
                        
                        //Route::get('rptDataAlertasTerritorialesInfoTipoAlerta', 'ReporteController@rptDataAlertasTerritorialesInfoTipoAlerta')->name('rptDataAlertasTerritorialesInfoTipoAlerta');
                        Route::get('rptDataAlertasTerritorialesInfoTipoAlerta/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@rptDataAlertasTerritorialesInfoTipoAlerta')->name('rptDataAlertasTerritorialesInfoTipoAlerta');
                        
                        //Route::get('rptExportAlertasTerritorialesInfoTipoAlerta', 'ReporteController@descargarrptAlertasTerritorialesInfoTipoAlertaExportable')->name('rptExportAlertasTerritorialesInfoTipoAlerta');
                        Route::get('rptExportAlertasTerritorialesInfoTipoAlerta/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@descargarrptAlertasTerritorialesInfoTipoAlertaExportable')->name('rptExportAlertasTerritorialesInfoTipoAlerta');
                        
                        //Route::get('rptExportEstadoSeguimientoGestionCasos', 'ReporteController@descargarrptEstadoSeguimientoGestionCasosExportable')->name('rptExportEstadoSeguimientoGestionCasos');
                        Route::get('rptExportEstadoSeguimientoGestionCasos/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptEstadoSeguimientoGestionCasosExportable')->name('rptExportEstadoSeguimientoGestionCasos');
                        
                        //Route::get('rptExportEstadoSeguimientoGestionTerapias', 'ReporteController@descargarrptEstadoSeguimientoGestionTerapiasExportable')->name('rptExportEstadoSeguimientoGestionTerapias');
                        Route::get('rptExportEstadoSeguimientoGestionTerapias/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptEstadoSeguimientoGestionTerapiasExportable')->name('rptExportEstadoSeguimientoGestionTerapias');
                        
                        //Route::get('rptExportGestionCasoTerapia', 'ReporteController@descargarrptGestionCasoTerapiaExportable')->name('rptExportGestionCasoTerapia');
                        Route::get('rptExportGestionCasoTerapia/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptGestionCasoTerapiaExportable')->name('rptExportGestionCasoTerapia');
                        
                        Route::get('alertasSinNomina', 'AlertaController@listarAlertasSinNomina')->name('alertasSinNomina');
                        
                        Route::get('alertas/listarSinNomina', 'AlertaController@indexAlertasSinNomina')->name('listarSinNomina');
                        
                        //Route::get('rptPrioridadAlerta', 'ReporteController@rptPrioridadAlerta')->name('rptPrioridadAlerta');
                        Route::get('rptPrioridadAlerta/{i?}', 'ReporteController@rptPrioridadAlerta')->name('rptPrioridadAlerta');
                        
                        //INICIO DC
                        Route::get('listar/rptGestionComunitariaBitacora', 'ReporteController@rptGestionComunitariaBitacora')->name('listar.rptGestionComunitariaBitacora');
                        
                        Route::get('listar/rptPlanComunalBitacora', 'ReporteController@rptPlanComunalBitacora')->name('listar.rptPlanComunalBitacora');
                        
                        Route::get('listar/rptGestionComunitariaDocumentos', 'ReporteController@rptGestionComunitariaDocumentos')->name('listar.rptGestionComunitariaDocumentos');
                        
                        Route::get('listar/rptPlanComunalDocumentos', 'ReporteController@rptPlanComunalDocumentos')->name('listar.rptPlanComunalDocumentos');
                        
                        Route::get('rptGestionComunitariaBitacora', 'ReporteController@rptGestionComunitariaBitacora')->name('rptGestionComunitariaBitacora');
                        
                        Route::get('rptExportGestionComunitariaBitacora/{i?}', 'ReporteController@rptExportGestionComunitariaBitacora')->name('rptExportGestionComunitariaBitacora');
                        
                        Route::get('rptExportPlanComunalBitacora/{i?}', 'ReporteController@rptExportPlanComunalBitacora')->name('rptExportPlanComunalBitacora');
                        
                        Route::get('rptExportGestionComunitariaDocumentos/{i?}', 'ReporteController@rptExportGestionComunitariaDocumentos')->name('rptExportGestionComunitariaDocumentos');
                        
                        Route::get('rptExportPlanComunalDocumentos/{i?}', 'ReporteController@rptExportPlanComunalDocumentos')->name('rptExportPlanComunalDocumentos');
                        
                        Route::get('rptExportGestionComunitariaEtapas/{i?}', 'ReporteController@rptExportGestionComunitariaEtapas')->name('rptExportGestionComunitariaEtapas');
                        
                        Route::get('rptTiemposIntervencionTF/{i?}', 'ReporteController@rptTiemposIntervencionTF')->name('listar.rptTiemposIntervencionTF');
                        
                        Route::get('rptTiemposIntervencion/{i?}', 'ReporteController@rptTiemposIntervencion')->name('listar.rptTiemposIntervencion');
                        
                        Route::get('rptExportTiemposIntervencion/{i?}/{ini?}/{fin?}/{caso?}/{gestor?}', 'ReporteController@rptExportTiemposIntervencion')->name('rptExportTiemposIntervencion');
                        
                        Route::get('rptExportTiemposIntervencionTF/{i?}/{ini?}/{fin?}/{caso?}/{gestor?}', 'ReporteController@rptExportTiemposIntervencionTF')->name('rptExportTiemposIntervencionTF');
                        //FIN DC
                        
                        //Route::get('rptExportPrioridadAlerta', 'ReporteController@descargarrptPrioridadAlertaExportable')->name('rptExportPrioridadAlerta');
                        Route::get('rptExportPrioridadAlerta/{i?}', 'ReporteController@descargarrptPrioridadAlertaExportable')->name('rptExportPrioridadAlerta');
                        
                        //Route::get('rptDetalleAlertasTerritoriales', 'ReporteController@rptDetalleAlertasTerritoriales')->name('rptDetalleAlertasTerritoriales');
                        Route::get('rptDetalleAlertasTerritoriales/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@rptDetalleAlertasTerritoriales')->name('rptDetalleAlertasTerritoriales');
                        
                        //Route::get('rptExportDetalleAlertasTerritoriales', 'ReporteController@descargarrptDetalleAlertasTerritorialesExportable')->name('rptExportDetalleAlertasTerritoriales');
                        Route::get('rptExportDetalleAlertasTerritoriales/{i?}/{tip?}/{ini?}/{fin?}', 'ReporteController@descargarrptDetalleAlertasTerritorialesExportable')->name('rptExportDetalleAlertasTerritoriales');
                        
                        //Route::get('rptDetalleAlertasChcc', 'ReporteController@rptDetalleAlertasChcc')->name('rptDetalleAlertasChcc');
                        Route::get('rptDetalleAlertasChcc/{i?}', 'ReporteController@rptDetalleAlertasChcc')->name('rptDetalleAlertasChcc');
                        
                        //Route::get('rptExportDetalleAlertasChcc', 'ReporteController@descargarrptDetalleAlertasChccExportable')->name('rptExportDetalleAlertasChcc');
                        Route::get('rptExportDetalleAlertasChcc/{i?}', 'ReporteController@descargarrptDetalleAlertasChccExportable')->name('rptExportDetalleAlertasChcc');
                        
                        //Route::get('rptMapaOfertaBrecha', 'ReporteController@rptMapaOfertaBrecha')->name('rptMapaOfertaBrecha');
                        Route::get('rptMapaOfertaBrecha/{i?}/{ini?}/{fin?}', 'ReporteController@rptMapaOfertaBrecha')->name('rptMapaOfertaBrecha');
                        
                        //Route::get('rptExportMapaOfertaBrecha', 'ReporteController@descargarrptMapaOfertaBrechaExportable')->name('rptExportMapaOfertaBrecha');
                        Route::get('rptExportMapaOfertaBrecha/{i?}/{ini?}/{fin?}', 'ReporteController@descargarrptMapaOfertaBrechaExportable')->name('rptExportMapaOfertaBrecha');
                        
                        Route::get('reportes/main/fecha', 'ReporteController@reporteFecha')->name('reportes.fecha');
                        
                        Route::get('reportes/alerta/lista', 'ReporteController@reporteAlertaLista')->name('reportes.alerta.lista');
                        
                        Route::get('reportes/gestion/usuarios/', 'ReporteController@mainGestionUsuarios')->name('reportes.gestion.usuarios');
                        
                        Route::get('reportes/usuarios/perfil', 'ReporteController@mainUsuariosPerfil')->name('reportes.usuarios.perfil');
                        
                        Route::get('reportes/usuarios/oln', 'ReporteController@mainUsuariosOln')->name('reportes.usuarios.oln');
                        
                        
                        Route::get('gestionar/usuarios/oln', 'ReporteController@gestionarUsuariosOln')->name('gestionar.usuarios.oln');
                        
                        Route::get('get/comunas', 'ReporteController@getComunas')->name('get.comunas');
                        //INICIO CZ SPRINT 72 
                        Route::get('get/regiones', 'ReporteController@getRegion')->name('get.regiones');
                        //FIN CZ SPRINT 72 
                        Route::get('get/comunas/usuarios', 'ReporteController@getComunasUsuario')->name('get.comuna.usuario');
                        
                        Route::get('guardar/usuario', 'ReporteController@guardarUsuario')->name('guardar.usuario');
                        
						//INICIO DC SPRINT 66
						
                        Route::get('ver/sso', 'ReporteController@verSSO')->name('ver.sso');
                        
                        Route::get('guardar/sso', 'ReporteController@guardarSSO')->name('guardar.sso');
                        
                        Route::get('vigencia/sso', 'ReporteController@vigenciaSSO')->name('vigencia.sso');
                        
                        Route::get('addvigencia/sso', 'ReporteController@addVigenciaSSO')->name('addVigencia.sso');
                        
                        Route::get('add/institucion', 'ReporteController@addInstitucion')->name('add.institucion');
                        
                        Route::get('get/instituciones', 'ReporteController@getInstituciones')->name('get.instituciones');
                        
                        Route::get('verificar/casos', 'ReporteController@verificarCasos')->name('verificar.casos');
                        
                        
						//FIN DC SPRINT 66
						
                        Route::get('guardar/comunas', 'ReporteController@guardarComunas')->name('guardar.comunas');
                        
                        Route::get('quitar/comunas', 'ReporteController@quitarComunas')->name('quitar.comunas');
                        
                        Route::get('reportes/usuarios/rpt2/oln', 'ReporteController@rptUsuarioOln2')->name('rpt.usuario.oln2');
                        
                        Route::get('get/usuario', 'ReporteController@getUsuario')->name('get.usuario');
                        
                        Route::get('editar/usuario', 'ReporteController@editarUsuario')->name('editar.usuario');
                        
                        Route::get('reportes/usuarios/data', 'ReporteController@procesarUsuarioReportes')->name('reportes.usuarios.cargar');
                        
                        Route::get('reportes/usuarios/rpt/perfil/{id?}', 'ReporteController@rptUsuarioPerfil')->name('rpt.usuario.perfil');
                        
                        Route::get('lista/usuarios/perfil', 'ReporteController@listUsuarioPerfil')->name('lista.usuario.perfil');
                        
                        Route::get('reportes/usuarios/rpt/oln/{id?}', 'ReporteController@rptUsuarioOln')->name('rpt.usuario.oln');
                        
                        Route::get('reportes/usuarios/perfil/export/{id?}', 'ReporteController@descargarUsuariosPorPerfil')->name('usuario.perfil.export');
                        
                        Route::get('reportes/usuarios/rpt/oln/{id?}', 'ReporteController@rptUsuarioOln')->name('rpt.usuario.oln');
                        
                        Route::get('reportes/usuarios/oln/export/{id?}', 'ReporteController@descargarUsuariosPorOln')->name('usuario.oln.export');
                        
                        Route::get('reportes/descargar', 'ReporteController@mainDescargar')->name('reportes.descargar');
                        
                        Route::get('reportes/descargar/rpt/objetivo/{file?}', 'ReporteController@descargarReportesObjetivosTareas')->name('reportes.objetivos.tareas');
                        
                        Route::get('reportes/descargar/rpt/ncfas/{file?}', 'ReporteController@descargarReportesResultadosNcfas')->name('reportes.resultados.ncfas');
                        
                        Route::get('reportes/descargar/rpt/integrantes/gfamiliar/{file?}', 'ReporteController@descargarReportesIntegrantesGfamiliar')->name('reportes.integrantes.gfamiliar');
                        
                        Route::get('reportes/descargar/rpt/respuestas/terapiafamiliar/{file?}', 'ReporteController@descargarReportesRespuestasTerapiafamiliar')->name('reportes.respuestas.terapiafamiliar');
                        
                        Route::get('reportes/descargar/reportes/mensual', 'ReporteController@listadoReporteMensual')->name('descargar.reportes.mensual');
                        
                        Route::get('nomprog', 'ProgramaController@nomProg')
                        ->name('nombre.programa');
                        
                        Route::get('/casos/gestionar/prestaciones', 'CasoController@gestionarPrestaciones')
	->name('casos.gestionar.prestaciones');
                        
                        Route::get('/casos/gestionar/prestaciones/estados', 'CasoController@cambiarEstadoDerivacion')
	->name('casos.gestionar.prestaciones.estados');
                        
                        // INICIO CZ SPRINT 56
                        Route::get('/casos/gestionar/prestaciones/ver/estados', 'CasoController@verEstadoDerivacion')
                        ->name('casos.gestionar.prestaciones.ver.estados');
                        // FIN CZ SPRINT 56
                        
                        Route::get('/casos/gestionar/prestaciones/listar', 'CasoController@listarDerivacionesAsignadas')->name('casos.gestionar.prestaciones.listar');
                        
                        Route::get('rptExportAlertasTerritoriales', 'ReporteController@descargarAlertasTerritorialesExport')->name('rptExportAlertasTerritoriales');
                        
                        Route::get('/imprimir/ncfas', 'DiagnosticoController@generaPdfNcfas')->name('imprimir.ncfas');
                        
                        Route::get('listar/detalle/seguimiento/casos/desestimados', 'CasoController@listarDetalleSeguimientoCasosDesestimados')
	->name('listar.detalle.seguimiento.casos.desestimados');
                        
                        // Pausar/Reiniciar Caso
                        
                        Route::post('/pausar/caso', 'CasoController@pausarReiniciarCaso')
	->name('pausar.caso');
                        
                        
                        // Registro de sesion de devolución
                        Route::get('/casos/guardarSesionDevolucion/', 'CasoController@guardarSesionDevolucion')->name('casos.guardarSesionDevolucion');
                        Route::get('/casos/guardarSesDevPreguntas/', 'CasoController@guardarSesDevPreguntas')->name('casos.guardarSesDevPreguntas');
                        Route::get('/casos/listarSesionDevolucion/', 'CasoController@listarSesionDevolucion')->name('casos.listarSesionDevolucion');
                        
                        Route::post('/casos/guardar/desestimacion/nomina', 'CasoController@guardarDesestimacionNomina')->name('casos.guardar.desestimacion.nomina');
                        
                        // Documentos de Apoyo para el Gestor
                        
                        Route::get('casos/documentos','CasoController@documentosGestionCasos')->name('documentos.gestor.casos');
                        
                        //---------------------------- GESTOR COMUNITARIO -------------------------------------
                        Route::get('/planComunal', 'GestionComunitariaController@planIndex')->name('plan.comunal');
                        
                        Route::get('/bitacora/crear', 'GestionComunitariaController@crearBitacora')->name('bitacora.crear');
                        
                        Route::post('/bitacora/registrar', 'GestionComunitariaController@registrarBitacora')->name('bitacora.registrar');
                        
                        Route::get('listar/bitacora/data', 'GestionComunitariaController@listarBitacoraData')->name('listar.bitacora.data');
                        
                        Route::get('bitacora/editar/', 'GestionComunitariaController@editarBitacora')->name('bitacora.editar');
                        
                        Route::get('bitacora/listar/actividades', 'GestionComunitariaController@listarActividad')->name('listar.actividad');
                        
                        
                        Route::get('actividad/form/editar', 'GestionComunitariaController@actividadEditar')->name('actividad.form.editar');
                        
                        Route::get('/actividades/crear', 'GestionComunitariaController@crearActividad')->name('crear.actividad');
                        
                        Route::post('/actividades/registrar', 'GestionComunitariaController@registrarActividad')->name('registrar.actividad');
                        
                        Route::get('listar/proceso/anual', 'GestionComunitariaController@listarProcesoAnual')->name('listar.proceso.anual');
                        
                        Route::get('listar/proceso/anual/data', 'GestionComunitariaController@listarProcesoAnualData')->name('listar.proceso.anual.data');
                        
                        // INICIO CZ SPRINT 56
                        Route::get('listar/proceso/obtenerComentarioDesestimacion', 'GestionComunitariaController@obtenerComentarioDesestimacion')->name('listar.proceso.obtenerComentarioDesestimacion');
                        //FIN CZ SPRINT 56
                        
                        // INICIO CZ SPRINT 61
                        Route::get('listar/proceso/anual/planComunal', 'GestionComunitariaController@listarProcesoAnualPlanComunal')->name('listar.proceso.anual.planComunal');
                        // FIN CZ SPRINT 61

                        Route::post('verificar/proceso/anual', 'GestionComunitariaController@verificarProcesoAnual')->name('verificar.proceso.anual');
                        
                        Route::post('crear/proceso/anual', 'GestionComunitariaController@crearProcesoAnual')->name('crear.proceso.anual');
                        
                        Route::get('gestion/proceso/anual', 'GestionComunitariaController@gestionProcesoAnual')->name('gestion.proceso.anual');
                        
                        Route::get('cambio/estado/proceso', 'GestionComunitariaController@cambioEstadoProceso')->name('cambio.estado.proceso');
                        
                        Route::get('documentos/data', 'GestionComunitariaController@documentosData')->name('documentos.data');
                        
                        Route::post('cargar/documentos','GestionComunitariaController@cargarDocumentos')->name('cargar.documentos');
                        
                        //inicio dc
                        Route::post('cargar/cargarDocumentosPEC','GestionComunitariaController@cargarDocumentosPEC')->name('cargar.documentosPEC');
                        //fin dc
                        //inicio ch
                        Route::get('documentos/datahistorial', 'GestionComunitariaController@gethistorialData')->name('hist.documentos.data');
                        
                        Route::post('cargar/documentoshistorial','GestionComunitariaController@cargarhistorialDoc')->name('hist.doc.cargar');
                        //fin ch
                        Route::get('diagnostico/data/priorizada', 'GestionComunitariaController@dataIdentificacionPrioritaria')->name('identificacion.priorizada');
                        
                        Route::get('diagnostico/mostrar/priorizada', 'GestionComunitariaController@getDataIdentComuna')->name('identificacion.priorizada.mostrar');
                        
                        Route::post('diagnostico/registrar/priorizada', 'GestionComunitariaController@registrarIdentComuna')->name('identificacion.priorizada.registrar');
                        
                        Route::get('diagnostico/listado/organizacion/{id?}', 'GestionComunitariaController@listarOrganizacionesFuncionales')->name('listar.organizacion.data');
                        
                        Route::get('diagnostico/registrar/organizacion', 'GestionComunitariaController@agregarOrganizacionFuncional')->name('registrar.organizacion.data');
                        
                        Route::post('diagnostico/eliminar/organizacion', 'GestionComunitariaController@eliminarOrganizacionFuncional')->name('eliminar.organizacion.data');
                        
                        Route::get('diagnostico/data/organizacion', 'GestionComunitariaController@dataIdentificacionOrganizacion')->name('organizacion.funcionales');
                        
                        Route::get('diagnostico/data/instituciones', 'GestionComunitariaController@dataInstitucionesServicios')->name('instituciones.servicios');
                        
                        Route::post('diagnostico/registrar/instituciones', 'GestionComunitariaController@agregarInstitucionesServicios')->name('registrar.instituciones.data');
                        
                        Route::post('diagnostico/eliminar/instituciones', 'GestionComunitariaController@eliminarInstitucionesServicios')->name('eliminar.instituciones.data');
                        
                        Route::get('diagnostico/listado/instituciones/{id?}', 'GestionComunitariaController@listarInstitucionesServicios')->name('listar.instituciones.data');
                        
                        Route::get('diagnostico/data/bienes', 'GestionComunitariaController@dataBienesComunitarios')->name('bienes.comunes');
                        
                        Route::post('diagnostico/registrar/bienes', 'GestionComunitariaController@agregarBienesComunes')->name('registrar.bienes.data');
                        
                        Route::post('diagnostico/eliminar/bienes', 'GestionComunitariaController@eliminarBienesComunes')->name('eliminar.bienes.data');
                        
                        Route::get('diagnostico/listado/bienes/{id?}', 'GestionComunitariaController@listarBienesComunes')->name('listar.bienes.data');
                        
                        //---------------------------- GESTOR COMUNITARIO -------------------------------------
                        
                        
                        Route::get('validar/guardar/direccion', 'AlertaController@valida_reg_grabado')
	->name('validar.guardar.direccion');
                        
                        Route::get('generar/token/seguridad', 'AlertaController@generarTokenSeguridad')
	->name('generar.token.seguridad');
                        
                        
                        //---------------------------- GC / DIAGNOSTICO PARTICIPATIVO -------------------------------------
                        
                        // FACTORES DE RIESGO SOCIONATURALES
                        Route::get('listar/socio/naturales', 'GestionComunitariaController@listarSocioNaturales')
	->name('listar.socio.naturales');
                        
                        // FACTORES DE RIESGO INFRAESTRUCTURA
                        Route::get('listar/riesgo/infraestructura', 'GestionComunitariaController@listarRiesgoInfraEstructura')
                        ->name('listar.riesgo.infraestructura');
                        
                        //FACTORES DE RIESGO SOCIOCOMUNITARIOS
                        Route::get('listar/riesgo/sociocomunitarios', 'GestionComunitariaController@listarRiesgoSocioComunitarios')
                        ->name('listar.riesgo.sociocomunitarios');
                        
                        //FACTORES PROTECTORES INFRAESTRTUCTURA **
                        Route::get('listar/protectores/infraestructura', 'GestionComunitariaController@listarProtectoresInfraEstructura')
                        ->name('listar.protectores.infraestructura');
                        
                        // FACTORES PROTECTORES SOCIOCOMUNITARIOS
                        Route::get('listar/protectores/sociocomunitarios', 'GestionComunitariaController@listarProtectoresSocioComunitarios')
                        ->name('listar.protectores.sociocomunitarios');
                        
                        // GUARDAR FACTORES
                        Route::post('guardar/factores', 'GestionComunitariaController@guardarRespuestaFactor')
                        ->name('guardar.factores');
                        
                        Route::get('diagnostico/buscar/organizacion', 'GestionComunitariaController@editarOrganizacionFuncional')->name('buscar.organizacion.data');
                        
                        Route::get('diagnostico/buscar/instituciones', 'GestionComunitariaController@editarInstitucionesServicios')->name('buscar.instituciones.data');
                        
                        Route::get('diagnostico/buscar/bienes', 'GestionComunitariaController@editarBienesComunes')->name('buscar.bienes.data');
                        
                        
                        //------------------------------- LINEA DE BASE -----------------------------------
                        
                        // LISTADO DE PARTICIPANTES LINEA BASE
                        Route::get('listar/linea/base', 'GestionComunitariaController@listarLineaBase')->name('listar.linea.base');
                        
                        Route::get('listar/linea/base_2021', 'GestionComunitariaController@listarLineaBase_2021')->name('listar.linea.base_2021');
                        // GUARDAR REGISTRO LINEA DE BASE
                        Route::post('guardar/linea/base', 'GestionComunitariaController@guardarLineaBase')->name('guardar.linea.base');
                        
                        Route::post('guardar/linea/base_2021', 'GestionComunitariaController@guardarLineaBase_2021')->name('guardar.linea.base_2021');

                        
                        // EDITAR REGISTRO LINEA DE BASE
                        Route::get('editar/linea/ident', 'GestionComunitariaController@editarLineaIdent')->name('editar.linea.ident');
                        
                        Route::get('editar/linea/ident_2021', 'GestionComunitariaController@editarLineaIdent_2021')->name('editar.linea.ident_2021');
                        
                        // ELIMINAR REGISTRO LINEA DE BASE
                        Route::get('eliminar/linea/base', 'GestionComunitariaController@eliminarLineaBase')->name('eliminar.linea.base');
                        Route::get('eliminar/linea/base_2021', 'GestionComunitariaController@eliminarLineaBase_2021')->name('eliminar.linea.base_2021');
                        
                        // LISTAR PREGUNTAS (SERVICIOS, PROGRAMAS, BIENES Y ORGANIZACIONES) LINEA DE BASES
                        Route::get('listar/encuesta', 'GestionComunitariaController@listarPreguntasServicios')->name('listar.preguntas.servicios');
                        
                        Route::get('listar/encuesta/servicios_2021', 'GestionComunitariaController@listarPreguntasServicios_2021')->name('listar.preguntas.servicios_2021');
                        
                        // LISTAR PREGUNTAS DE DERECHOS Y PARTICIPACION LINEA DE BASE
                        Route::get('listar/encuesta/participacion', 'GestionComunitariaController@listarPreguntasParticipacion')->name('listar.preguntas.participacion');
                        Route::get('listar/encuesta/participacion_2021', 'GestionComunitariaController@listarPreguntasParticipacion_2021')->name('listar.preguntas.participacion_2021');
                        
                        Route::get('listar/encuesta/continuidad_proyecto_2021', 'GestionComunitariaController@listarPreguntasContinuidadProyecto_2021')->name('listar.preguntas.continuidad_proyecto_2021');
                        //DESCARGAR LINEA BASE
                        Route::get('/descargarLineaBase/{lin_bas_id}', 'GestionComunitariaController@descargarLineaBase')->name('descargar.linea.base');
                        // INICIO CZ SPRINT 68
                        Route::get('/descargarLineaBase_2021/{id}/{tipo}/{pro_an_id}', 'GestionComunitariaController@descargarLineaBase_2021')->name('descargar.linea.base_2021');
                        // FIN CZ SPRINT 68
                        //inicio CH
                        Route::get('/descargarLineaBaseCSV/{id?}/{fas?}/', 'ReporteController@rptLineaBase')->name('reporte.lineabase');
                        // INICIO CZ SPRINT 68
                        Route::get('/descargarLineaBase2021CSV/{id?}/{fas?}/', 'ReporteController@rptLineaBase_2021')->name('reporte.lineabase_2021');
                        
                        Route::get('/obtener/otro_2021', 'GestionComunitariaController@getOtro_2021')->name('obtener.otro_2021');
                        
                        // FIN CZ SPRINT 68
                        //fin CH
                        //------------------------------- LINEA BASE -----------------------------------
                        
                        //inicio ch
                        //-------------------------------LINEA DE SALIDA---------------------------------
                        // LISTADO DE PARTICIPANTES LINEA SALIDA
                        Route::get('listar/linea/salida', 'GestionComunitariaController@listarLineaSalida')->name('listar.linea.salida');
                        Route::get('listar/linea/salida_3021', 'GestionComunitariaController@listarLineaSalida_2021')->name('listar.linea.salida_2021');
                        
                        // GUARDAR REGISTRO LINEA DE SALIDA
                        Route::post('guardar/linea/salida', 'GestionComunitariaController@guardarLineaSalida')->name('guardar.linea.salida');
                        
                        // EDITAR REGISTRO LINEA DE SALIDA
                        Route::get('editar/linea/identls', 'GestionComunitariaController@editarLineaIdentLs')->name('editar.linea.identls');
                        
                        // ELIMINAR REGISTRO LINEA DE SALIDA
                        Route::get('eliminar/linea/salida', 'GestionComunitariaController@eliminarLineaSalida')->name('eliminar.linea.salida');
                        
                        // LISTAR PREGUNTAS (SERVICIOS, PROGRAMAS, BIENES Y ORGANIZACIONES) LINEA DE SALIDA
                        Route::get('listar/encuestals', 'GestionComunitariaController@listarPreguntasServiciosLs')->name('listar.preguntas.serviciosls');
                        
                        // LISTAR PREGUNTAS DE DERECHOS Y PARTICIPACION LINEA DE SALIDA
                        Route::get('listar/encuesta/participacionls', 'GestionComunitariaController@listarPreguntasParticipacionLs')->name('listar.preguntas.participacionls');
                        
                        //DESCARGAR LINEA SALIDA
                        Route::get('/descargarLineaSalida/{lin_bas_id}', 'GestionComunitariaController@descargarLineaSalida')->name('descargar.linea.salida');
                        
                        //-------------------------------LINEA DE SALIDA---------------------------------
                        //fin ch
                        
                        //---------------------------- GC / DIAGNOSTICO PARTICIPATIVO -------------------------------------
                        
                        
                        Route::post('terapias/comprometidas', 'TerapiaController@registrarNumeroSesionesTFComprometidas')->name('terapias.comprometidas');
                        //inicio ch
                        Route::get('terapias/vercomprometidas', 'TerapiaController@verNumeroSesionesTFComprometidas')->name('verterapias.comprometidas');
                        //fin ch
                        
                        Route::get('gestor/comunitario/cambio/estado', 'GestionComunitariaController@cambiarEstadoGestorComunitario')->name('gestor.comunitario.cambio.estado');
                        
                        
                        
                        //---------- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA ---------------------
                        
                        Route::get('matriz/identificacion/problema/nna', 'GestionComunitariaController@listarMatrizIdentificacionProblema')->name('matriz.identificacion.problema.nna');
                        
                        Route::get('formulario/matriz/identificacion/problema/nna', 'GestionComunitariaController@levantarFormularioMatrizIdentificacionProblema')->name('formulario.matriz.identificacion.problema.nna');
                        
                        Route::get('guardar/formulario/matriz/identificacion/problema/nna', 'GestionComunitariaController@guardarFormularioMatrizIdentificacionProblema')->name('guardar.formulario.matriz.identificacion.problema.nna');
                        
                        //---------- MATRIZ IDENTIFICACIÓN DE PROBLEMAS QUE CONSTITUYEN UN FACTOR DE RIESGO PARA LOS NNA ---------------------
                        
                        
                        //----------------------------- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO ---------------------------------
                        
                        Route::get('listar/matriz/rango/etario', 'GestionComunitariaController@listarMatrizRangoEtario')->name('listar.matriz.rango.etario');
                        
                        Route::get('listar/problemas/matriz/rango/etario', 'GestionComunitariaController@listarProblemasPriorizados')->name('listar.problemas.matriz.rango.etario');
                        
                        Route::get('cargar/matriz/rango/etario', 'GestionComunitariaController@cargarMatrizRangoEtario')->name('cargar.matriz.rango.etario');
                        
                        Route::get('registrar/matriz/rango/etario', 'GestionComunitariaController@regitrarDataMatrizRangoEtario')->name('registrar.matriz.rango.etario');
                        
                        Route::get('priorizar/problema/matriz/rango/etario', 'GestionComunitariaController@priorizarProblemaMatrizRangoEtario')->name('priorizar.problema.matriz.rango.etario');
                        
                        //----------------------------- MATRIZ DE PRIORIZACIÓN DE PROBLEMAS POR RANGO ETARIO ---------------------------------
                        
                        
                        //------------------------------- MATRIZ FACTORES PROTECTORES -----------------------------------
                        
                        Route::get('listar/matriz/factores', 'GestionComunitariaController@listarMatrizFactores')->name('listar.matriz.factores');
                        
                        Route::post('guardar/matriz/factores', 'GestionComunitariaController@guardarMatrizFactores')->name('guardar.matriz.factores');
                        
                        Route::get('editar/matriz/factores', 'GestionComunitariaController@editarMatrizFactores')->name('editar.matriz.factores');
                        
                        Route::get('eliminar/matriz/factores', 'GestionComunitariaController@eliminarMatrizFactores')->name('eliminar.matriz.factores');
                        
                        Route::get('reporte/matriz/factores/{id?}', 'GestionComunitariaController@descargarReporteMatrizFactores')->name('reporte.matriz.factores');
                        
                        Route::get('reporte/matriz/identificacion/{id?}', 'GestionComunitariaController@descargarReporteMatrizIdentProb')->name('reporte.matriz.identificacion');
                        
                        Route::get('reporte/matriz/rango/etario/{id?}', 'GestionComunitariaController@descargarReporteMatrizRangoEtario')->name('reporte.matriz.rango.etario');
                        
                        Route::get('reporte/plan/estrategico/{id?}', 'GestionComunitariaController@descargarReportePlanEstrategico')->name('reporte.plan.estrategico');
                        
                        Route::get('reporte/inf/plan/estrategico/{id?}', 'GestionComunitariaController@descargaReporteInfPlanEstrategico')->name('reporte.infPlan.estrategico');
                        
                        Route::get('informe/plan/estrategico/{id?}', 'GestionComunitariaController@descargarInformePlanEstrategico')->name('informe.plan.estrategico');
                        
                        //INICIO DC
                        Route::get('informe/dpc/{id?}', 'GestionComunitariaController@descargarInformeDPC')->name('informe.dpc');
                        
                        Route::get('finalizar/pec', 'GestionComunitariaController@finalizarPec')->name('finalizar.pec');
                        //FIN DC
                        
                        //------------------------------- MATRIZ FACTORES PROTECTORES -----------------------------------||||||| .r1654
                        
                        Route::get('vet/alertas/porLogro', 'CasoController@porcentajeLogro')->name('validar.porcentaje.logro');
                        
                        Route::get('actualizar/alertas/mitigada', 'CasoController@updMitigar')->name('upd.alerta.mitigar');
                        
                        //INICIO DC
                        Route::get('actualizar/alertas/NoMitigada', 'CasoController@updNoMitigar')->name('upd.alerta.noMitigar');
                        //FIN DC
                        
                        Route::get('listar/alertas/enAtencion', 'CasoController@getEnAtencion')->name('listar.alerta.enAtencion');
                        
                        Route::get('listar/alertas/estados', 'CasoController@getAlertaEstados')->name('listar.alerta.estados');
                        
                        Route::get('listar/alertas/verVinculacion/objetivo', 'CasoController@verVinculacion')->name('listar.alerta.verVinculacion');
                        
                        Route::get('listar/alertas/vincular/objetivo', 'CasoController@vincularObjetivo')->name('casos.vincularObjetivo');
 
//afsp63
Route::get('get/data/nna/casos/anteriores/{run_nna?}', 'CasoController@obtieneCasosAnteriores')->name('get.casos.anteriores');
//afsp63

                      
                        Route::get('listar/alertas/detectada/diagnostico', 'CasoController@listarAlertaDetectada')->name('listar.alerta.detectada');
                        
                        Route::get('listar/alertas/asociadas/diagnostico', 'CasoController@listarAlertaPriorizada')->name('listar.alerta.priorizada');
                        
                        //INICIO DC
                        
                        Route::get('listar/dimension/vinculada', 'CasoController@listarDimensionVinculada')->name('listar.dimension.vinculada');
                        
                        Route::get('listar/alerta/addObjetivo', 'CasoController@alertaAddObjetivo')->name('listar.alerta.addObjetivo');
                        //FIN DC
                        
                        Route::get('listar/alertas/asociadas/tipo', 'AlertaController@listarAlertasporTipo')->name('alertas.asociadas.tipo');
                        
                        Route::get('desestimar/alertas/asociadas/tipo', 'AlertaController@desestimarAlertasporTipo')->name('desestimar.alertas.tipo');
                        
                        Route::get('listar/pausar/caso', 'CasoController@listadoHistorialPausaCaso')->name('listar.pausar.caso');
                        
                        Route::get('get/data/alerta/validar', 'AlertaController@validarNnaAlerta')->name('validar.nna.alerta');
                        
                        //INICIO DC
                        Route::get('get/data/alerta/actualizaCantComp', 'CasoController@actualizaCantComp')->name('validar.actualizaCantComp');
                        Route::get('get/data/alerta/actualizaPorLog', 'CasoController@actualizaPorLog')->name('validar.actualizaPorLog');
                        //FIN DC
                        
                        Route::get('listar/alerta/diagnostico', 'CasoController@listarAlertasDiagnostico')->name('listar.diagnostico.alertas');
                        
                        Route::get('get/data/nna/alerta', 'CasoController@getDataNnaAlerta')->name('get.data.nna.alerta');
                        
                        Route::get('diagnostico/listar/alertas/detectadas', 'CasoController@diagnosticoListarAlertasDetectadas')->name('diagnostico.listar.alertas.detectadas');
                        
                        Route::get('diagnostico/listar/alertas/vinculadas', 'CasoController@diagnosticoListarAlertasVinculadas')->name('diagnostico.listar.alertas.vinculadas');
                        
                        Route::post('vincular/alerta/dimension', 'CasoController@vincularAlertaDimension')->name('vincular.alerta.dimension');
                        
                        Route::get('get/data/alerta/buscarAlertaReg', 'AlertaController@buscarAlertaReg')->name('buscar.alertaReg');
                        // INICIO CZ SPRINT 55
                        Route::get('get/data/alerta/buscarDireccionPersona', 'AlertaController@direccionPersona')->name('buscar.direccionPersona');
                        Route::get('get/data/alerta/region', 'AlertaController@getRegion')->name('buscar.region');
                        // FIN CZ SPRINT 55
                        Route::get('get/data/alerta/eliminarAlertaReg', 'AlertaController@eliminarDireccion')->name('eliminar.alertaReg');
                        
                        Route::get('get/data/alerta/estadoAlertaReg', 'AlertaController@actualizarEstado')->name('estado.alertaReg');
                        
                        Route::get('get/data/alerta/guardarAlertaReg', 'AlertaController@guardarDireccion')->name('guardar.alertaReg');
                        
                        //------------------------------ INFORME DIAGNÓSTICO PARTICIPATIVO ----------------------------------------//
                        
                        Route::get('data/guardarProblematica', 'GestionComunitariaController@guardarProblematica')->name('guardar.problematica');
                        
                        Route::get('data/cargarProblematica', 'GestionComunitariaController@cargarProblematica')->name('cargar.problematica');
                        
                        Route::get('data/informe/diagnostico', 'GestionComunitariaController@dataInformeDiagnostico')->name('data.informe.diagnostico');
                        
                        Route::post('registrar/informe/diagnostico', 'GestionComunitariaController@resgristrarInformeDPC')->name('registrar.informe.diagnostico');
                        
                        Route::get('listar/informe/integrantes', 'GestionComunitariaController@listarIntegrantesDPC')->name('listar.informe.integrantes');
                        
                        Route::post('registrar/informe/integrantes', 'GestionComunitariaController@resgistrarIntegrantesInforme')->name('registrar.informe.integrantes');
                        
                        Route::get('editar/informe/integrantes', 'GestionComunitariaController@editarIntegrantesDPC')->name('editar.informe.integrantes');
                        
                        Route::post('eliminar/informe/integrantes', 'GestionComunitariaController@eliminarIntegrantesInforme')->name('eliminar.informe.integrantes');
                        
                        Route::get('listar/informe/anexos', 'GestionComunitariaController@listarInformeAnexos')->name('listar.informe.anexos');
                        
                        Route::post('cargar/documento/anexos', 'GestionComunitariaController@cargarInformeAnexos')->name('cargar.documento.anexos');
                        
                        Route::get('listar/informe/caracteristicas', 'GestionComunitariaController@listarInformeCaracGenerales')->name('listar.informe.caracteristicas');
                        
                        Route::post('registrar/informe/caracteristicas', 'GestionComunitariaController@registrarInformeCaractGenerales')->name('registrar.informe.caracteristicas');
                        
                        Route::get('editar/informe/caracteristicas', 'GestionComunitariaController@editarInformeCaractGenerales')->name('editar.informe.caracteristicas');
                        
                        Route::post('eliminar/informe/caracteristicas', 'GestionComunitariaController@eliminarInformeCaractGenerales')->name('eliminar.informe.caracteristicas');
                        
                        Route::get('listar/informe/ejecucion', 'GestionComunitariaController@listarInformeEjecucion')->name('listar.informe.ejecucion');
                        
                        Route::post('registrar/informe/ejecucion', 'GestionComunitariaController@registrarInformeEjecucion')->name('registrar.informe.ejecucion');
                        
                        Route::get('editar/informe/ejecucion', 'GestionComunitariaController@editarInformeEjecucion')->name('editar.informe.ejecucion');
                        
                        Route::post('eliminar/informe/ejecucion', 'GestionComunitariaController@eliminarInformeEjecucion')->name('eliminar.informe.ejecucion');
                        
                        //INICIO DC SPRINT 67
                        Route::get('despriorizar/problematica', 'GestionComunitariaController@despriorizarProblematica')->name('despriorizar.problematica');
                        
                        Route::get('verifica/priorizacion', 'GestionComunitariaController@verificaPriorizacion')->name('verifica.priorizacion');
                        
						//FIN DC SPRINT 67
						
                        //------------------------------ INFORME DIAGNÓSTICO PARTICIPATIVO ----------------------------------------//
                        
                        //------------------------------ DOCUMENTACION COORDINADOR --------------------------------------------//
                        
                        Route::get('documentacion/main','CasoController@viewDocumentacion')->name('documentacion.index');
                        
                        Route::post('coordinador/cargar/documento', 'CasoController@cargarInformeAnexos')->name('coordinador.cargar.documento');
                        
                        Route::get('listar/coordinador/documentos/protocolo','CasoController@listarCoordinadorDocumentosProtocolo')->name('listar.coordinador.protocolo');//ch
                        
                        //INICIO DC
                        Route::get('listar/coordinador/documentos/protocolo2','CasoController@listarCoordinadorDocumentosProtocolo2')->name('listar.coordinador.protocolo2');
                        //FIN DC
                        
                        Route::get('listar/coordinador/documentos/actas','CasoController@listarCoordinadorDocumentosActas')->name('listar.coordinador.actas');//ch
                        
                        Route::get('listar/coordinador/documentos/materiales','CasoController@listarCoordinadorDocumentosMateriales')->name('listar.coordinador.materiales');//ch
                        // INICIO CZ SPRINT 66
                        Route::get('revertir_estado', 'CasoController@revertir_estado')->name('revertir_estado');
     
                        Route::get('estadosCaso', 'CasoController@estadoCaso')->name('estadoCaso');  
                        Route::get('estadosTerapia', 'CasoController@estadoTerapia')->name('estadoTerapia');  
                        Route::post('revertir_estado_caso', 'CasoController@revertir_estado_caso')->name('revertir_estado_caso');         
                        Route::post('revertir_estado_terapia', 'CasoController@revertir_estado_terapia')->name('revertir_estado_terapia'); 
                        
                        Route::get('traspaso_nna', 'CasoController@traspaso_nna')->name('traspaso_nna');    
                        Route::get('obtenerGestor', 'CasoController@obtenerUsuario')->name('obtenerUsuario');     
                        Route::get('listarCaso', 'CasoController@listarCaso')->name('listarCaso');    
                        Route::post('traspasar_nna', 'CasoController@traspasar_nna')->name('traspasar_nna');
                        // FIN CZ SPRINT 66
                        // INICIO  CZ SPRINT 67
                        Route::post('eliminarDocumento', 'GestionComunitariaController@eliminarDocumento')->name('eliminarDocumento');
                        Route::post('eliminarAnexo', 'GestionComunitariaController@eliminarAnexo')->name('eliminarAnexo');
                        Route::post('eliminarBitacora', 'GestionComunitariaController@eliminarBitacora')->name('eliminarBitacora');
                        Route::post('eliminarActividad', 'GestionComunitariaController@eliminarActividad')->name('eliminarActividad');
                        Route::post('realizadopec', 'GestionComunitariaController@realizadopec')->name('realizadopec');
                        Route::post('norealizadopec', 'GestionComunitariaController@norealizadopec')->name('norealizadopec');
                        Route::post('/bitacora/editarDatosBitacora', 'GestionComunitariaController@editarDatosBitacora')->name('bitacora.datos.editar');
                        //CZ SPRINT 73 -->
                        Route::get('resumenNNA/{run?}', 'CasoController@resumenNNA')->name('coordinador.caso.resumenNNA')->where('run', '[0-9]+');    
                        Route::get('/data/casos/desestimadoNNA', 'CasoController@casoDesestimado')
                        ->name('data.casos.desestimadoNNA');
                        Route::get('/data/casos/gestionNNA', 'CasoController@casoGestion')
                        ->name('data.casos.gestionNNA');
                        Route::get('/data/nnaNomina', 'CasoController@nnaNomina')
                        ->name('data.nnaNomina');
                        Route::get('testServicio', 'CasoController@test')
                        ->name('testServicio');
                      //CZ SPRINT 73 -->  
                      //CZ SPRINT 74 -->
                      Route::get('/data/notificaciones', 'CasoController@notificacion')
                      ->name('data.notificacion');         
                      Route::get('/data/notificacion_tipo_intervencion', 'CasoController@notificacionTiempoIntervencion')
                      ->name('data.notificacion_tipo_intervencion'); 
                      Route::get('/data/notificacionAsignacionToastr', 'CasoController@notificacionAsignacionToastr')
                      ->name('data.notificacionAsignacionToastr');                                                 
                      Route::get('cambiarEstadoNotificacion', 'CasoController@cambiarEstadoNotificacion')
                      ->name('cambiarEstadoNotificacion');
                      Route::get('/data/notificacionAsignacionTabla', 'CasoController@notificacionAsignacionTabla')
                      ->name('data.notificacionAsignacionTabla');             
                      Route::get('/data/cantidadNotificaciones', 'CasoController@cantidadNotificaciones')
                      ->name('data.cantidadNotificaciones');
                      Route::get('/data/notificacionTiempoIntervencionTabla', 'CasoController@notificacionTiempoIntervencionTabla')
                      ->name('data.notificacionTiempoIntervencionTabla'); 
                      Route::get('/data/cantidadNotificacionesTiempo', 'CasoController@cantidadNotificaciones_Tiempo')
                      ->name('data.cantidadNotificacionesTiempo'); 
                      //CZ SPRINT 74 -->
                      //CZ SPRINT 75
                      Route::get('administrar/oln', 'AdministracionController@administrarOLN')
                      ->name('administrar.oln'); 
                      Route::get('/data/oln', 'AdministracionController@getOLN')
                      ->name('get.oln'); 
                      Route::post('administar/habilitarOLN', 'AdministracionController@habilitarOLN')
                      ->name('administar.habilitarOLN'); 
                      Route::post('administar/deshabilitarOLN', 'AdministracionController@deshabilitarOLN')
                      ->name('administar.deshabilitarOLN'); 
                    // CZ SPRINT 77      
                    Route::get('administar/agrupar_caso', 'AdministracionController@agruparCaso')
                    ->name('administar.agrupar_caso');         
                    Route::get('get/casosComuna', 'AdministracionController@casosComuna')
                    ->name('get.casosComuna');  
                    Route::post('administar/unificarCaso', 'AdministracionController@unificarCaso')
                    ->name('administar.unificarCaso'); 
                    Route::get('administar/guardar_usuario', 'AdministracionController@guardarUsuario')
                    ->name('administar.guardar_usuario'); 
                    Route::get('administar/asignar_roles', 'AdministracionController@asignarRolesUsuario')
                    ->name('administar.asignar_roles'); 
                    Route::get('administar/eliminar_vigencia', 'AdministracionController@eliminarVigencia')
                    ->name('administar.eliminar_vigencia'); 
                    Route::get('/data/casos/listarCasosGestion', 'AdministracionController@listarCasosGestion')
                    ->name('data.casos.listarCasosGestion');
                    Route::get('validar/asignacion_caso_periodo', 'CasoController@validarAsignacionCasoPeriodo')
                    ->name('validar.asignacion_caso_periodo');
                    Route::post('cargar/documentosPercepcion','GestionComunitariaController@cargarDocPercepcion')->name('percepcion.doc.cargar');
                    Route::get('/getdocpercepcion','GestionComunitariaController@getDocPercepcion')->name('get.doc.percepcion');
                    Route::post('eliminarDocPercepion', 'GestionComunitariaController@eliminarDocPercepion')->name('eliminarDocPercepion');