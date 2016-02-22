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
/*** Rutas para administrador ***/
Route::resource('admin/usuarios','UsersController');
Route::resource('admin/actividades','ActividadesController');
Route::resource('admin/matriculas','MatriculasController');
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
/*** Rutas para tesorera ***/
Route::resource('tesorera/egresos','EgresosController');
Route::resource('tesorera/rubros','RubrosController');
Route::resource('tesorera/ingresos','IngresosController');
Route::post('tesorera/egresos/rubroNuevo', 'RubrosController@crearconajax');
/*** Rutas para tesorera ***/
Route::resource('cajera/cobros','CobrosController');
Route::resource('cajera/retiros','RetirosController');
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

/**/
Route::get('secretaria/reporte', 'PdfController@invoice');