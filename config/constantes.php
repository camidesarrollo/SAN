<?php

/**
 * Created by PhpStorm.
 * User: jmarquez
 * Date: 26-10-2018
 * Time: 9:30
 */
return [
	/*
	|
	| Valores Referentes al Sistema
	|
	*/
	// constantes api sit mds
	'sit_url'					=> env('SIT_URL', ''),
	'sit_serid'					=> env('SIT_SERID', ''),
	'sit_mapid'					=> env('SIT_MAPID', ''),
	'sit_ext'					=> env('SIT_EXT', ''),
	'sit_regext'				=> env('SIT_REGEXT', ''),
	'sit_filvis'				=> env('SIT_FILVIS', ''),
    'app_url'				    => env('APP_URL', ''),
	

	// constantes sso
	'sso_aid'					=> env('SSO_AID', ''),
	'sso_url'					=> env('SSO_URL', ''),
	'sso_ws'					=> env('SSO_WS', ''),
	'sso_rol'					=> env('SSO_ROL', ''),
    //INICIO DC SPRINT 67
    'sso_aplicacion'			=> env('SSO_APLICACION', ''),
    //FIN DC SPRINT 67
	// constantes api mds
	'client_secret'				=> env('client_secret', ''),
	'client_id'					=> env('client_id', ''),
	'client_api_uri'			=> env('CLIENT_API_URI', ''),
	
	'app_mds'					=> 'http://www.mds.cl',
	'sesion_individual'			=> 8,
	'sesion_grupal'				=> 4,
	'sesion_max'				=> 12,
	'sesion_tipos'				=> ['I'=>'Individual','G'=>'Grupal', 'C'=>'Seguimiento', 'R'=>'Retroalimentación y Egreso'],
	'sesion_sin_estado'			=> 'Por Asignar',
	'caso_origen'				=> ['1'=>'Predictivo','2'=>'Manual','3'=>'Experto'],
	'cupo_terapeuta'			=> 25,
	'sesion_duracion'			=> 1, // horas
	'sesion_inicio'				=> '08:00:00',
	'sesion_fin'				=> '19:00:00',
	'perfil_coordinador'		=> 2, //3,
	'perfil_gestor'				=> 3,
	'perfil_terapeuta'			=> 4, //4,
	'perfil_sectorialista'		=> 5, //4,
	'perfil_super_usuario'		=> 6, //4,
	'perfil_administrador_central' => 7, //4,
	'perfil_gestor_comunitario' => 8,
	'perfil_gestor_comunitario_PC' => 9,
	'perfil_coordinador_regional' => 10,
	'nombre_perfil_terapeuta'	=> 'terapeuta',
	'nombre_perfil_coordinado'	=> 'coordinador',
	'origen_manual'				=> 2,
	'tipo_coordinador'			=> 'coordinador',
	'tipo_terapeuta'			=> 'terapeuta',
	'tipo_externo'				=> 'externo',
	'sesion_seguimiento'        => 1,
	'sesion_retroalimentación'  => 1,
	
	'tipo_experto'				=> 'experto',
	'tipo_facilitador'			=> 'facilitador',
	'tipo_gestor'				=> 'gestor',
	'tipo_administrador'		=> 'administrador',
	
	'sesion_dias_minimo'		=> 8,
	'url_cartola'				=> env('URL_CARTOLA', ''),
	'url_ultimos_beneficios'    => env('URL_ULTIMO_BENEFICIO',''),
	'url_historico_beneficios'    => env('URL_HISTORICO_BENEFICIOS',''),
	
	//Constantes estados
	//'estado_planificado'        => 1,
	'estado_finalizado'         => 2,
	//'estado_descartado'         => 8,
	//'estado_rechazado'          => 9,
	'en_prediagnostico'         => 10,
	'en_diagnostico'            => 1,
	'en_elaboracion_paf'        => 3,
	'en_ejecucion_paf'          => 4,
	'en_cierre_paf'             => 5,
	'en_seguimiento_paf'        => 6,
	'egreso_paf'                => 7,
	'rechazado_por_gestor'      => 8,
	'rechazado_por_familiares'  => 9,
	'en_ejecucion_ter_ncfas'    => 11,

	'familia_intervenida_sename' 		=> 20,
	'nna_vulneracion_derechos' 			=> 21,
	'nna_presenta_medida_proteccion' 	=> 22,
	'familia_no_aplica' 				=> 23,
	'familia_inubicable' 				=> 24,
	'familia_rechaza_oln' 				=> 25,
	'familia_renuncia_oln' 				=> 26,
	'direccion_incorrecta' 				=> 27,
	'direccion_desactualizada' 			=> 28,
	'nna_vulneracion_derecho_delito' 	=> 29,
	'nna_vulneracion_derecho_no_delito' => 30,
	
	//Constantes documentos
	'documento_consentimiento_diagnostico' => 'Consentimiento Informado para el Uso de los Datos en el Marco de la Participacion en las Oficias Locales de la Niñez.docx',
	'firma_plan_terapia_familiar' => 'Firma Plan Terapia Familiar (PTF).pdf',
	// CZ SPRINT 74  
	'firma_plan_terapia_familiar_2021' => 'Firma Plan Terapia Familiar (PTF)_2021_VF.pdf',
	'Encuesta_de_percepción_de_NNA_GCOM' => 'NNA participación OLN 2021.pdf',
	// CZ SPRINT 74  
	//Constantes estados alertas
	'alt_sin_gestionar' 		=> 1,
	'alt_en_espera_de_atencion' => 2,
	'alt_en_ejecucion' 			=> 3,
	'alt_continua_monitoreo' 	=> 4,
	'alt_resuelta' 				=> 5,
	'alt_no_resuelta' 			=> 6,
	'alt_no_corresponde' 		=> 7,
	
	
	//Constantes alternativa NCFAS
	'ncfas_al_no_aplica'           => 1,
	'ncfas_al_clara_fortaleza'     => 2,
	'ncfas_al_leve_Fortaleza'      => 3,
	'ncfas_al_linea_base_adecuado' => 4,
	'ncfas_al_problema_leve'       => 5,
	'ncfas_al_problema_moderado'   => 6,
	'ncfas_al_problema_serio'      => 7,
	'ncfas_al_sin_informacion'     => 8,
	
	//Constantes fase NCFAS
	'ncfas_fs_ingreso' => 1,
	'ncfas_fs_cierre' => 3,
	// INCIO CZ SPRINT 56
	// 'ncfas_fs_cierre_ptf' => 2,
	// FIN CZ SPRINT 56 
	
	//Dimension encuesta
	'a_entorno' 							=> 1,
	'b_competencias_parentales' 			=> 2,
	'c_interacciones_familiares' 			=> 3,
	'd_proteccion_familiar' 				=> 4,
	'e_bienestar_del_niño/a' 				=> 5,
	'f_vida_social_comunitaria' 			=> 6,
	'g_autonomia' 							=> 7,
	'h_salud_familiar' 						=> 8,
	'i_ambivalencia_cuidador_niño/a' 		=> 9,
	'j_preparacion_para_la_reunificacion' 	=> 10,

	//Constantes Terapias
	'gtf_invitacion' 						=> 3,
	'gtf_diagnostico' 						=> 4,
	'gtf_ejecucion' 						=> 5,
	'gtf_seguimiento' 						=> 6,
	'gtf_familia_rechaza_participacion'     => 7,
	'gtf_Familia_no_aplica'     			=> 8,
	'gtf_nna_presenta_vulneracion_derechos' => 9,
	'gtf_familia_no_asiste'                 => 10,
	'gtf_familia_renuncia_a_la_tf'          => 11,
	'gtf_egreso'          					=> 12,

	'url_runificador' 			=> env('URL_RUNIFICADOR', ''),

	//Tipos de preguntas
	'preguntas_nfcfas' => 1,

	//Constantes estados programa
	'sin_gestionar'   => 2,
	'pendiente'       => 8,
	'abandono_programa_servicio' => 9,	
	'no_corresponde'  => 6,
	'dev_resuelta'  => 7,

	//Constantes Evaluacion Terapia
	'evaluacion_inicial' 		=> 1,
	'evaluacion_cierre' 		=> 2,
	'evaluacion_seguimiento' 	=> 3,
	'ofuscacion_run' 			=> env('OFUSCACION_RUN', ''),
	
	'cobertura_inicial_gestor' 	=> 40,
	// 'cobertura_inicial_terapeuta' 	=> 40,
	'cobertura_inicial_terapeuta' 	=> 25,

	'seguimiento_caso_llamada' => 1,
	'seguimiento_caso_visita' => 2,
	'seguimiento_caso_revision' =>3,
	'seguimiento_terapia_llamada' => 2,
	'seguimiento_terapia_visita' => 3,
	'seguimiento_terapia_revision' => 4,
	
	'parentesco_por_definir' => 99,
	'brecha_abierta' => 1,
	'brecha_cerrada' => 0,

	//Constantes estados tareas objetivos
	'est_tarea_vigente' => 1,
	'est_tarea_en_ejecucion' => 2,
	'est_tarea_finalizada' => 3,
	'est_tarea_no_vigente' => 4,

	//Usuarios de prueba
	'gestor_prueba' => 5,

	//Estados del seguimiento de casos desestimados
	'NNA_ha_sido_ingresado_al_programa_de_protección' => 8,
	'NNA_derivado_a_oferta_especializada' => 9,
	'NNA_ha_sido_ingresado_al_programa' => 10,

	'ID_sistema_fuente' => env('ID_SISTEMA_FUENTE', ''),
	'ID_negocio' => env('ID_NEGOCIO', ''),
	'ID_negocio_vigencia' => env('ID_NEGOCIO_VIGENCIA', ''),
	'key_ws_reg_dir' => env('KEY_TOKEN_WS_REG_DIR',''),
	'pass_ws_reg_dir' => env('PASS_TOKEN_WS_REG_DIR',''),
	'key_ws_val' => env('KEY_WS_VAL_TOKEN',''),
	'pass_ws_val' => env('PASS_WS_VAL_TOKEN',''),
	'tk_ws_reg_dir_exp' => env('TOKEN_WS_REG_DIR_EXP',''),
	'tk_ws_exp' => env('TOKEN_WS_EXP',''),
	'url_registrar_direccion' => env('URL_REGISTRAR_DIRECCION', ''),
	'url_verificacion_direccion' => env('URL_VERIFICACION_DIRECCION', ''),
	'url_actualizacion_estado_direccion' => env('URL_ACTUALIZACION_ESTADO_DIRECCION', ''),


	'activar_maestro_direcciones' => env('MAESTRO_DIRECCIONES', ''),

	// GESTOR COMUNITARIO
	'identificacion_comunidad' => 1,
	'plan_estrategico' => 2,
	'carta_compromiso_comunidad' => 5,
	'linea_base' => 6,
	'matriz_identificación_problemas' => 7,
	'matriz_priorización_problemas' => 8,
	'matriz_factores_protectores' => 9,
	'informe_dpc' => 10,
	'linea_salida' => 11,
    'informe_plan_estrategico' => 12,
    //INICIO DC
    'desestimado' => 4,
    'finalizado' => 3,
    //FIN DC

	//TIPO DE DOCUMENTOS GESTOR COMUNITARIO
	'tip_carta_compromiso_comunidad' => 1,
	'tip_acta_constitucion_grupo_accion' => 2,
	'tip_acta_reunion_grupo_accion' => 3,
	'tip_acta_reunion_asamblea_comunitaria' => 4,
         //inicio CH
	'tip_acta_listas_asistencias' => 5,
	'tip_materiales' => 6,
	'tip_asentamientos_consentimientos' => 7,
        // fin ch
	'cantidad_caracteres_TextArea_GCM' => 2000,

	'reporte_mensual' => true,

	'dias_habilitado_btn_descartar_nomina' => 20,
	'repositorio_coordinador' => env('REPOSITORIO_COORDINADOR', ''),
];
