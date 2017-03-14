<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Rutas generales
# Ruta para el index
Route::get('/', 'FrontController@index');
# Ruta para el escritorio
Route::get('escritorio', 'DashboardController@escritorio');
# Ruta para el Login
Route::resource('log','LogController');
# Ruta para Cerrar Sesión
Route::get('logout', 'LogController@logout');
# Ruta para Modificar Perfil
Route::get('perfil', 'UserGeneralController@actualizarPerfil');
Route::post('perfil/guardar', 'UserGeneralController@guardarPerfil');
# Ruta para obtener las instituciones de un usuario
Route::get('usuario/instituciones', 'UserGeneralController@institucionesUsuario');
Route::post('usuario/buscar', 'UserGeneralController@buscar');
// Rutas para el administrador
Route::resource('admin/usuarios','UsersController');
Route::resource('admin/actividades','ActividadesController');
Route::get('admin/matricula/crear', 'MatriculasController@crearMatricula');
Route::resource('admin/pensiones','PensionesController');
Route::resource('admin/cobros/ordinarios','CobrosOrdinariosController');
Route::resource('admin/cobros/extraordinarios','CobrosExtraordinariosController');
Route::resource('admin/cobros/otros','OtrosCobrosController');
Route::resource('admin/autorizacion','CodigoAutorizacionController');
Route::resource('admin/ingresos','AdminIngresosController');
Route::get('admin/divisiones/{id_institucion}', 'InstitucionDetalleController@divisionesInstitucion');
Route::get('admin/matriculas/{id_institucion}/{anio}', 'MatriculasController@listaMatriculas');
Route::get('admin/pensiones/{id_detalle_institucion}/{anio}', 'PensionesController@listaPensiones');
Route::get('admin/actividades/listar/{id_detalle_institucion}', 'ActividadesController@listaActividades');
Route::get('admin/cobros/ordinarios/listar/{id_institucion}', 'CobrosOrdinariosController@listaCobros');
Route::get('admin/cobros/otros/listar/{id_institucion}', 'OtrosCobrosController@listaCobros');
Route::get('admin/retirar/{id_cajera}', 'RetirosController@retiroAdmin');
Route::post('admin/retirar/actualizar', 'RetirosController@store');
Route::get('admin/divisiones_select/{id_institucion}', 'InstitucionDetalleController@detalleInstitucionParaSelect');
Route::post('admin/matricula/guardar', 'MatriculasController@guardarMatricula');
Route::get('admin/comprobante/crear', 'ConfiguracionController@definirComprobantes');
Route::post('admin/comprobante/guardar', 'ConfiguracionController@guardarComprobante');
Route::get('admin/configuracion', 'ConfiguracionController@configuracionEmpresa');
Route::post('admin/configuracion/guardar', 'ConfiguracionController@guardarConfiguracionEmpresa');
Route::get('admin/usuario/modulos', 'UsersController@modulosUsuario');
Route::get('admin/usuario/lista', 'UsersController@listaUsuarios');
Route::get('admin/usuario/{id_usuario}/modulos', 'UsersController@listaModulosUsuario');
Route::post('admin/usuario/modulos/grabar', 'UsersController@grabarModulosUsuario');
Route::get('admin/cobros/extraordinarios/listar/{id_institucion}', 'CobrosExtraordinariosController@listaCobros');
Route::get('admin/cobros/extraordinarios/eliminar/{id_cobro}', 'CobrosExtraordinariosController@eliminarCobro');
Route::get('admin/matricula/editar', 'MatriculasController@editarMatricula');
Route::get('admin/matricula/institucion/{id_institucion}/detalle', 'InstitucionDetalleController@detalleInstitucion');
Route::get('admin/matricula/{id_matricula}/categorias', 'MatriculasController@recuperarCategoriasAdmin');
Route::post('admin/matricula/editar/guardar', 'MatriculasController@guardarEdicionMatricula');
Route::get('admin/matricula/resumen/{batch}', 'MatriculasController@mostrarResumenMatricula');
Route::get('admin/matricula/temp/resumen/{batch}', 'MatriculasController@mostrarResumenMatriculaTemp');
Route::get('admin/comprobante/listar', 'ConfiguracionController@listarComprobantes');
# Reportes
Route::get('admin/reporte/balance_ingresos_egresos',
  ['as' => 'admin.reporte.balance_ingresos_egresos', 'uses' => 'ReportesAdminController@balanceIngresosEgresos']);
Route::post('admin/reporte/balance_ingresos_egresos/procesar',
  ['as' => 'admin.reporte.balance_ingresos_egresos.procesar', 'uses' => 'ReportesAdminController@balanceIngresosEgresosProcesar']);
Route::get('admin/reportes/ListaIngresos','AdminReporteListarIngresos@index');
Route::resource('admin/reportes/ListaIngresos/procesar','AdminReporteListarIngresos');
Route::get('admin/categorias/{id_detalle_institucion}', 'CategoriasController@categoriasDivision');
Route::get('admin/reportes/IngresosCategoria','AdminReporteIngresosCategoria@index');
Route::post('admin/reportes/IngresosCategoria/procesar','AdminReporteIngresosCategoria@procesar');
Route::get('admin/reportes/IngresosTotales','AdminReporteIngresosTotales@index');
Route::post('admin/reportes/IngresosTotales/procesar','ReportesAdminController@ReporteIngresosTotales');
Route::get('admin/reportes/ListaEgresos','AdminReporteListarEgresos@index');
Route::post('admin/reportes/ListaEgresos/procesar','AdminReporteListarEgresos@procesar');
Route::get('admin/rubros','RubrosController@listaRubros');
Route::get('admin/reportes/EgresosRubro','AdminReporteEgresosRubro@index');
Route::post('admin/reportes/EgresosRubro/procesar','AdminReporteEgresosRubro@procesarReporte');
Route::get('admin/reportes/EgresosTotales','AdminReporteEgresosTotales@index');
Route::post('admin/reportes/EgresosTotales/procesar','AdminReporteEgresosTotales@procesarReporteTotal');
Route::get('admin/reportes/AlumnosDeudores','AdminReporteAlumnosDeudores@index');
Route::post('admin/reportes/AlumnosDeudores/procesar','ReportesAdminController@ReporteAlumnosDeudores');
Route::get('admin/grados/{id_detalle_institucion}','GradosController@gradosDivision');
Route::get('admin/reportes/CuentaAlumno','AdminReporteCuentaAlumno@index');
Route::post('admin/reportes/CuentaAlumno/procesar','AdminReporteCuentaAlumno@procesar');
Route::get('admin/reportes/ingresos_cajera', 'ReportesAdminController@ingresosPorCajera');
Route::post('admin/reportes/ingresos_cajera/procesar', 'ReportesAdminController@procesarIngresosPorCajera');
Route::get('admin/reportes/cuenta_alumno', 'ReportesAdminController@cuentaDeAlumno');
Route::post('admin/reportes/cuenta_alumno/procesar', 'ReportesAdminController@procesarCuentaDeAlumno');
Route::get('admin/reportes/cuenta_alumno/{nro_documento}/periodos', 'ReportesAdminController@periodosAlumno');
Route::get('admin/reportes/deudas_alumno', 'ReportesAdminController@deudasDeAlumno');
Route::post('admin/reportes/deudas_alumno/procesar', 'ReportesAdminController@procesarDeudasDeAlumno');
Route::get('admin/matricula/detalle_institucion/{id_detalle}/matriculas', 'InstitucionDetalleController@recuperarTodasMatriculas');
Route::get('admin/alumno/{nro_documento}/datos', 'AlumnosController@recuperarAlumno');
Route::post('admin/autorizacion/guardar','CodigoAutorizacionController@store');
Route::get('admin/autorizacion/listar/autorizaciones/{nro_documento}/{fecha_creacion?}','CodigoAutorizacionController@listar');
Route::get('admin/autorizacion/eliminar/{id_autorizacion}', 'CodigoAutorizacionController@eliminar');
Route::post('admin/actividades/grabar','ActividadesController@store');
Route::get('admin/actividades/resumen/{batch}','ActividadesController@mostrarResumenActividad');

// Rutas para tesorera
Route::resource('tesorera/egresos','EgresosController');
Route::resource('tesorera/rubros','RubrosController');
Route::resource('tesorera/ingresos','IngresosController');
Route::post('tesorera/egresos/rubroNuevo', 'RubrosController@crearconajax');
Route::get('tesorera/retirar/{id_cajera}', 'RetirosController@retiroTesorera');
Route::post('tesorera/retirar/actualizar', 'RetirosController@store');
Route::get('tesorera/rubro/listar', 'RubrosController@listaRubros');
Route::post('tesorera/egresos/crear_egreso', 'EgresosController@crearEgreso');
Route::get('tesorera/egreso/listar_fecha', 'EgresosController@listarEgresosPorFecha');
Route::post('tesorera/egresos/actualizar/{id_egreso}', 'EgresosController@actualizar');
Route::resource('tesorera/rubro/fixed_listar','RubrosController@fixed_index');
Route::post('tesorera/crear/egresos/rubro/crear', 'EgresosController@egresoRubroCrear');
Route::get('tesorera/administrar/rubros', 'RubrosController@administrarRubros');
Route::post('tesorera/administrar/rubros/crear', 'RubrosController@crearRubro');
Route::get('tesorera/administrar/rubros/actualizar/{id_rubro}', 'RubrosController@actualizarRubro');
Route::get('tesorera/administrar/rubros/eliminar/{id_rubro}', 'RubrosController@eliminarRubro');
Route::post('tesorera/saldo_inicial/crear', 'ConfiguracionController@registrarSaldoInicial');
Route::get('tesorera/registrar/ingresos', 'IngresosController@ingresosAdicionales');
Route::post('tesorera/registrar/ingresos/guardar', 'IngresosController@registrarIngresosAdicionales');
# Reportes
Route::get('tesorera/reporte/balance_ingresos_egresos', 'ReportesTesoreraController@mostrarBalanceIngresosEgresos');
Route::post('tesorera/reporte/balance_ingresos_egresos/procesar', 'ReportesTesoreraController@balanceIngresosEgresos');
Route::get('tesorera/reportes/ListaIngresos', 'AdminReporteListarIngresos@index');
Route::resource('tesorera/reportes/ListaIngresos/procesar','AdminReporteListarIngresos');
Route::get('tesorera/divisiones/{id_institucion}', 'InstitucionDetalleController@divisionesInstitucion');
Route::get('tesorera/reportes/IngresosCategoria', 'AdminReporteIngresosCategoria@index');
Route::resource('tesorera/reportes/IngresosCategoria/procesar','AdminReporteIngresosCategoria');
Route::get('tesorera/reportes/IngresosTotales', 'AdminReporteIngresosTotales@index');
Route::resource('tesorera/reportes/IngresosTotales/procesar','AdminReporteIngresosTotales');
Route::get('tesorera/reportes/ListaEgresos', 'AdminReporteListarEgresos@index');
Route::resource('tesorera/reportes/ListaEgresos/procesar','AdminReporteListarEgresos');
Route::get('tesorera/rubros','RubrosController@listaRubros');
Route::get('tesorera/reportes/EgresosRubro', 'AdminReporteEgresosRubro@index');
Route::resource('tesorera/reportes/EgresosRubro/procesar','AdminReporteEgresosRubro');
Route::get('tesorera/reportes/EgresosTotales', 'AdminReporteEgresosTotales@index');
Route::get('tesorera/reportes/Saldo', 'TesoreraReporteSaldo@index');
// Rutas para cajera
Route::resource('cajera/cobros','CobrosController');
Route::resource('cajera/retiros','RetirosController');
Route::get('cajera/buscar/deudas/{codigo}', 'CobrosController@buscarDeudas');
Route::post('cajera/cobro/guardar', 'CobrosController@guardarCobro');
Route::post('cajera/cobro/extraordinario/guardar', 'CobrosController@guardarCobroExtraordinario');
Route::post('cajera/retiro/confirmacion', 'RetirosController@confirmar');
Route::get('cajera/configuracion/impresora', 'ConfiguracionController@cajeraImpresora');
Route::post('cajera/configuracion/impresora/guardar', 'ConfiguracionController@guardarCajeraImpresora');
Route::post('cajera/cobro/multiple/guardar', 'CobrosController@guardarCobroMultiple');
Route::get('cajera/comprobante/{id_institucion}/{tipo_comprobante}/{json?}', 'CobrosController@buscarComprobante');
Route::get('cajera/comprobante/numero/{id_institucion}/{tipo_comprobante}/{serie_comprobante}', 'CobrosController@buscarNumeroComprobante');
Route::get('cajera/generar/ingreso', 'CobrosController@generarIngreso');
Route::get('cajera/generar/ingreso/buscar/{codigo}', 'CobrosController@buscarDatosParaCobro');
Route::post('cajera/generar/ingreso/grabar', 'CobrosController@grabarIngreso');
Route::post('cajera/generar/ingreso/imprimir', 'CobrosController@imprimirComprobante');
Route::post('cajera/generar/ingreso/grabar_extraordinario', 'CobrosController@grabarIngresoExtraordinario');
Route::post('cajera/generar/ingreso/imprimir_extraordinario', 'CobrosController@imprimirComprobanteExtraordinario');
Route::post('cajera/generar/ingreso/imprimir_multiple', 'CobrosController@imprimirComprobanteMultiple');
# Reportes
Route::get('cajera/reporte/procesar','CajeraReporteCobros@index');
/*
Route::post('cajera/reporte/generar',
  ['as' => 'cajera.reporte.generar', 'uses' => 'CajeraReporteCobros@generar']);
*/
Route::post('cajera/reporte/generar', 'CajeraReporteCobros@generar');
// Rutas para secretaria
Route::resource('secretaria/alumnos','AlumnosController');
Route::get('secretaria/alumno/matricular','AlumnosController@matricular');
Route::get('secretaria/alumno/{dni}', 'AlumnosController@datosAlumno');
Route::get('secretaria/alumno/categorias/{dni}', 'AlumnosController@categoriasAlumno');
Route::get('secretaria/alumno/deudas/agregar','AlumnosController@agregarDeuda');
Route::get('secretaria/alumno/deudas/listar','AlumnosController@deudas');
Route::get('secretaria/alumno/deudas/cancelar','AlumnosController@cancelarDeudaActividad');
Route::get('secretaria/alumno/deudas/amortizacion','AlumnosController@amortizacion');
Route::get('secretaria/alumno/divisiones/{id_institucion}', 'InstitucionDetalleController@divisionesInstitucion');
Route::get('secretaria/alumno/grados/{id_detalle_institucion}', 'InstitucionDetalleController@gradosDetalle');
Route::get('secretaria/alumno/matriculas/{id_detalle_institucion}', 'InstitucionDetalleController@matriculas');
Route::get('secretaria/alumno/lista_deudas/{dni}', 'AlumnosController@listaDeudasAlumno');
Route::get('secretaria/alumno/lista_actividades/{dni}', 'AlumnosController@listaDeudasActividadesAlumno');
Route::get('secretaria/alumno/amortizar_deudas/{dni}', 'AlumnosController@amortizarDeudaAlumno');
Route::post('secretaria/alumno/deudas/crear','AlumnosController@agregarDeudasAlumno');
Route::post('secretaria/alumno/deudas/eliminar_actividad','AlumnosController@EliminarDeudaActividad');
Route::post('secretaria/alumno/deudas/eliminar_descontar_deuda','AlumnosController@EliminarDescontarDeuda');
Route::post('secretaria/alumno/amortizarDeuda','AlumnosController@CrearAmortizacion');
Route::get('secretaria/matricular/alumno/{nro_documento}/datos', 'AlumnosController@datosAlumnoParaMatricula');
Route::get('secretaria/matricular/institucion/{id_institucion}/detalle', 'InstitucionDetalleController@detalleInstitucion');
Route::get('secretaria/matricular/detalle_institucion/{id_detalle}/grados_matriculas', 'InstitucionDetalleController@recuperarGradosYMatriculas');
Route::get('secretaria/matricular/matricula/{id_matricula}/pensiones', 'MatriculasController@recuperarPensiones');
Route::post('secretaria/matricular/crear', 'AlumnosController@crearMatricula');
Route::get('secretaria/matricular/reporte/{categorias}/{nro_documento}/{id_grado}', 'AlumnosController@reporteMatricula');
Route::get('secretaria/ciclo/cerrar', 'CicloController@index');
Route::get('secretaria/ciclo/cerrar/institucion/{id_institucion}/detalle', 'InstitucionDetalleController@detalleInstitucion');
Route::get('secretaria/ciclo/cerrar/detalle_institucion/{id_detalle}/matriculas', 'InstitucionDetalleController@recuperarMatriculas');
Route::post('secretaria/ciclo/cerrar/guardar', 'CicloController@cerrarCiclo');
Route::get('secretaria/alumno/deudas/anteriores/agregar', 'AlumnosController@agregarDeudasAnteriores');
Route::get('secretaria/alumno/deudas/{id_matricula}/categorias', 'MatriculasController@recuperarCategorias');
Route::post('secretaria/alumno/deudas/anteriores/crear', 'AlumnosController@crearDeudasAnteriores');
Route::get('secretaria/alumno/deudas/anteriores/detalle_institucion/{id_detalle}/matriculas', 'InstitucionDetalleController@recuperarTodasMatriculas');
# Reportes
Route::get('secretaria/procesar/reporte/deudas_por_grado', 'ReportesSecretariaController@procesarDeudasPorGrado');
Route::get('secretaria/periodo/programar', 'MatriculasController@programarPeriodos');
Route::post('secretaria/periodo/crear', 'MatriculasController@crearMatriculaPensiones');
Route::get('secretaria/matriculas/recuperar/{id_institucion}', 'MatriculasController@recuperarMatriculas');
Route::get('secretaria/reportes/cuenta_alumno', 'ReportesSecretariaController@cuentaDeAlumno');
Route::resource('secretaria/reportes/procesar','AdminReporteCuentaAlumno');
Route::resource('secretaria/reportes/EgresosTotales/procesar','AdminReporteEgresosTotales');
Route::get('secretaria/reportes/cuenta_alumno/{nro_documento}/periodos', 'ReportesSecretariaController@periodosAlumno');
Route::post('secretaria/reportes/cuenta_alumno/procesar', 'ReportesSecretariaController@procesarCuentaDeAlumno');
Route::get('secretaria/reportes/deudas_alumno', 'ReportesAdminController@deudasDeAlumno');
Route::get('secretaria/reportes/deudas_por_grado', 'AdminReporteAlumnosDeudores@index');
Route::get('secretaria/divisiones/{id_institucion}', 'InstitucionDetalleController@divisionesInstitucion');
Route::get('secretaria/grados/{id_detalle_institucion}','GradosController@gradosDivision');
// Rutas temporales (inhabilitar luego de utilizar)
# Route::get('temp', function () { return view('temp.one'); });
