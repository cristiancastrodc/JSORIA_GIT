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

/*** Ruta para el index ***/
Route::get('/', 'FrontController@index');
/*** Ruta para el escritorio ***/
Route::get('escritorio', 'DashboardController@escritorio');
/*** Ruta para el Login ***/
Route::resource('log','LogController');
/*** Ruta para Cerrar Sesión ***/
Route::get('logout', 'LogController@logout');
/*** Ruta para Modificar Perfil ***/
Route::get('perfil', 'UserGeneralController@actualizarPerfil');
Route::post('perfil/guardar', 'UserGeneralController@guardarPerfil');

/*** Rutas para administrador ***/
Route::resource('admin/usuarios','UsersController');
Route::resource('admin/actividades','ActividadesController');
/*
Route::resource('admin/matriculas','MatriculasController');
*/
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
/* Reportes */
Route::get('admin/reporte/balance_ingresos_egresos',
  ['as' => 'admin.reporte.balance_ingresos_egresos', 'uses' => 'ReportesAdminController@balanceIngresosEgresos']);
Route::post('admin/reporte/balance_ingresos_egresos/procesar',
  ['as' => 'admin.reporte.balance_ingresos_egresos.procesar', 'uses' => 'ReportesAdminController@balanceIngresosEgresosProcesar']);

/***********************************************************************************/
/*** Rutas para tesorera ***/
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
/* Reportes */
Route::get('tesorera/reporte/balance_ingresos_egresos', 'ReportesTesoreraController@balanceIngresosEgresos');

/***********************************************************************************/
/*** Rutas para cajera ***/
Route::resource('cajera/cobros','CobrosController');
Route::resource('cajera/retiros','RetirosController');
Route::get('cajera/buscar/deudas/{codigo}', 'CobrosController@buscarDeudas');
Route::post('cajera/cobro/guardar', 'CobrosController@guardarCobro');
Route::post('cajera/cobro/extraordinario/guardar', 'CobrosController@guardarCobroExtraordinario');
Route::post('cajera/retiro/confirmacion', 'RetirosController@confirmar');
Route::get('cajera/configuracion/impresora', 'ConfiguracionController@cajeraImpresora');
Route::post('cajera/configuracion/impresora/guardar', 'ConfiguracionController@guardarCajeraImpresora');
Route::post('cajera/cobro/multiple/guardar', 'CobrosController@guardarCobroMultiple');
Route::get('cajera/comprobante/{id_institucion}/{tipo_comprobante}', 'CobrosController@buscarComprobante');
Route::get('cajera/comprobante/{id_institucion}/{tipo_comprobante}/{serie_comprobante}', 'CobrosController@buscarNumeroComprobante');
Route::get('cajera/generar/ingreso', 'CobrosController@generarIngreso');

/*** Rutas para secretaria ***/
Route::resource('secretaria/alumnos','AlumnosController');
Route::get('secretaria/alumno/matricular','AlumnosController@matricular');
Route::get('secretaria/alumno/{dni}', 'AlumnosController@datosAlumno');
Route::get('secretaria/alumno/categorias/{dni}', 'AlumnosController@categoriasAlumno');
Route::get('secretaria/alumno/deudas/agregar','AlumnosController@agregarDeuda');
Route::get('secretaria/alumno/deudas/listar','AlumnosController@deudas');
Route::get('secretaria/alumno/deudas/cancelar','AlumnosController@cancelarDeudaActividad');
Route::get('secretaria/alumno/deudas/amortizacion','AlumnosController@amortizacion');
Route::resource('secretaria/ciclo/cerrar','CicloController');
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
// Reportes
Route::get('secretaria/generar/reporte/deudas_por_grado', 'ReportesSecretariaController@deudasPorGrado');
Route::get('secretaria/procesar/reporte/deudas_por_grado', 'ReportesSecretariaController@procesarDeudasPorGrado');

/*** Rutas de reportes ***/
/**/
//Route::get('secretaria/reportes', 'PdfController@index');
//Route::post('secretaria/reportes/procesar', 'PdfController@invoice');
Route::get('secretaria/reportes', 'AdminReporteCuentaAlumno@index');
Route::resource('secretaria/reportes/procesar','AdminReporteCuentaAlumno');

Route::get('admin/reportes/ListaIngresos','AdminReporteListarIngresos@index');
Route::resource('admin/reportes/ListaIngresos/procesar','AdminReporteListarIngresos');
Route::get('admin/categorias/{id_detalle_institucion}', 'CategoriasController@categoriasDivision');

Route::get('admin/reportes/IngresosCategoria','AdminReporteIngresosCategoria@index');
Route::resource('admin/reportes/IngresosCategoria/procesar','AdminReporteIngresosCategoria');
Route::get('admin/reportes/IngresosTotales','AdminReporteIngresosTotales@index');
Route::resource('admin/reportes/IngresosTotales/procesar','AdminReporteIngresosTotales');

Route::get('admin/reportes/ListaEgresos','AdminReporteListarEgresos@index');
Route::resource('admin/reportes/ListaEgresos/procesar','AdminReporteListarEgresos');
Route::get('admin/rubros','RubrosController@listaRubros');

Route::get('admin/reportes/EgresosRubro','AdminReporteEgresosRubro@index');
Route::resource('admin/reportes/EgresosRubro/procesar','AdminReporteEgresosRubro');

Route::get('admin/reportes/EgresosTotales','AdminReporteEgresosTotales@index');
Route::resource('admin/reportes/EgresosTotales/procesar','AdminReporteEgresosTotales');

Route::get('admin/reportes/AlumnosDeudores','AdminReporteAlumnosDeudores@index');
Route::resource('admin/reportes/AlumnosDeudores/procesar','AdminReporteAlumnosDeudores');
Route::get('admin/grados/{id_detalle_institucion}','GradosController@gradosDivision');

Route::get('admin/reportes/CuentaAlumno','AdminReporteCuentaAlumno@index');
Route::resource('admin/reportes/CuentaAlumno/procesar','AdminReporteCuentaAlumno');

Route::get('cajera/reporte/procesar','CajeraReporteCobros@index');

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
Route::resource('secretaria/reportes/EgresosTotales/procesar','AdminReporteEgresosTotales');

Route::get('tesorera/reportes/Saldo', 'TesoreraReporteSaldo@index');
/*** Rutas temporales (inhabilitar luego de utilizar) ***/
/*
Route::get('temp', function ()
{
  return view('temp.one');
});
*/