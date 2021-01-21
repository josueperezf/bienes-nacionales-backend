<?php
use Illuminate\Http\Request;
Route::resource('marcas','MarcaController');
Route::resource('personas','PersonaController');
Route::resource('subcoordinacions','SubcoordinacionController');
Route::resource('unidadAdministrativas','UnidadAdministrativaController');
Route::get('unidadAdministrativas/ConDependenciaAlmacen/{id}','UnidadAdministrativaController@ConDependenciaAlmacen');
Route::resource('dependenciaUsuarias','DependenciaUsuariaController');
Route::get('dependenciaUsuarias/porUnidadAdministrativa/{id}','DependenciaUsuariaController@porUnidadAdministrativa');
Route::get('tipoDependenciaUsuarias/porUnidadAdministrativa/{id}','TipoDependenciaUsuariaController@porUnidadAdministrativa');
Route::get('denominacions/porCategoria/{id}','DenominacionController@porCategoria');
Route::resource('biens','BienController');
Route::resource('movimientos','MovimientoController');
Route::get('detalleTipoMovimientos/porTipoMovimiento/{id}','DetalleTipoMovimientoController@porTipoMovimiento');
Route::post('reportes/inventario','ReportesController@inventario');
