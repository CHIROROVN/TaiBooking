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

Route::get('/', function () {
	return redirect('ortho/menus');
    // return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::any('/password/change', 'HomeController@change');


Route::get('/profile', 'HomeController@profile');


/**
 * ortho
 */
Route::group(['prefix' => 'ortho', 'namespace' => 'Backend\Ortho'], function () 
{
	Route::get('/', function(){
		return redirect()->route('ortho.menus.index');
	});

	// menu
	Route::get('menus', ['as' => 'ortho.menus.index', 'uses' => 'MenuController@index']);

	// user
	Route::get('users', ['as' => 'ortho.users.index', 'uses' => 'UserController@index']);
	Route::get('users/regist', ['as' => 'ortho.users.regist', 'uses' => 'UserController@getRegist']);
	Route::post('users/regist', ['as' => 'ortho.users.regist', 'uses' => 'UserController@postRegist']);
	Route::get('users/edit/{id}', ['as' => 'ortho.users.edit', 'uses' => 'UserController@getEdit']);
	Route::post('users/edit/{id}', ['as' => 'ortho.users.edit', 'uses' => 'UserController@postEdit']);
	Route::get('users/delete/{id}', ['as' => 'ortho.users.delete', 'uses' => 'UserController@getDelete']);

	// belong
	Route::get('belongs', ['as' => 'ortho.belongs.index', 'uses' => 'BelongController@index']);
	Route::get('belongs/regist', ['as' => 'ortho.belongs.regist', 'uses' => 'BelongController@getRegist']);
	Route::post('belongs/regist', ['as' => 'ortho.belongs.regist', 'uses' => 'BelongController@postRegist']);
	Route::get('belongs/edit/{id}', ['as' => 'ortho.belongs.edit', 'uses' => 'BelongController@getEdit']);
	Route::post('belongs/edit/{id}', ['as' => 'ortho.belongs.edit', 'uses' => 'BelongController@postEdit']);
	Route::get('belongs/delete/{id}', ['as' => 'ortho.belongs.delete', 'uses' => 'BelongController@getDelete']);
	Route::get('belongs/orderby-top', ['as' => 'ortho.belongs.orderby.top', 'uses' => 'BelongController@orderby_top']);
	Route::get('belongs/orderby-last', ['as' => 'ortho.belongs.orderby.last', 'uses' => 'BelongController@orderby_last']);
	Route::get('belongs/orderby-up', ['as' => 'ortho.belongs.orderby.up', 'uses' => 'BelongController@orderby_up']);
	Route::get('belongs/orderby-down', ['as' => 'ortho.belongs.orderby.down', 'uses' => 'BelongController@orderby_down']);

	// area
	Route::get('areas', ['as' => 'ortho.areas.index', 'uses' => 'AreaController@index']);
	Route::get('areas/regist', ['as' => 'ortho.areas.regist', 'uses' => 'AreaController@getRegist']);
	Route::post('areas/regist', ['as' => 'ortho.areas.regist', 'uses' => 'AreaController@postRegist']);
	Route::get('areas/edit/{id}', ['as' => 'ortho.areas.edit', 'uses' => 'AreaController@getEdit']);
	Route::post('areas/edit/{id}', ['as' => 'ortho.areas.edit', 'uses' => 'AreaController@postEdit']);
	Route::get('areas/delete/{id}', ['as' => 'ortho.areas.delete', 'uses' => 'AreaController@getDelete']);
	Route::get('areas/orderby-top', ['as' => 'ortho.areas.orderby.top', 'uses' => 'AreaController@orderby_top']);
	Route::get('areas/orderby-last', ['as' => 'ortho.areas.orderby.last', 'uses' => 'AreaController@orderby_last']);
	Route::get('areas/orderby-up', ['as' => 'ortho.areas.orderby.up', 'uses' => 'AreaController@orderby_up']);
	Route::get('areas/orderby-down', ['as' => 'ortho.areas.orderby.down', 'uses' => 'AreaController@orderby_down']);

	// clinic
	Route::any('clinics', ['as' => 'ortho.clinics.index', 'uses' => 'ClinicController@index']);
	Route::get('clinics/regist', ['as' => 'ortho.clinics.regist', 'uses' => 'ClinicController@getRegist']);
	Route::post('clinics/regist', ['as' => 'ortho.clinics.regist', 'uses' => 'ClinicController@postRegist']);
	Route::get('clinics/edit/{id}', ['as' => 'ortho.clinics.edit', 'uses' => 'ClinicController@getEdit']);
	Route::post('clinics/edit/{id}', ['as' => 'ortho.clinics.edit', 'uses' => 'ClinicController@postEdit']);
	Route::get('clinics/delete/{id}', ['as' => 'ortho.clinics.delete', 'uses' => 'ClinicController@getDelete']);

	// inspections
	Route::get('inspections', ['as' => 'ortho.inspections.index', 'uses' => 'InspectionController@index']);
	Route::get('inspections/regist', ['as' => 'ortho.inspections.regist', 'uses' => 'InspectionController@getRegist']);
	Route::post('inspections/regist', ['as' => 'ortho.inspections.regist', 'uses' => 'InspectionController@postRegist']);
	Route::get('inspections/edit/{id}', ['as' => 'ortho.inspections.edit', 'uses' => 'InspectionController@getEdit']);
	Route::post('inspections/edit/{id}', ['as' => 'ortho.inspections.edit', 'uses' => 'InspectionController@postEdit']);
	Route::get('inspections/delete/{id}', ['as' => 'ortho.inspections.delete', 'uses' => 'InspectionController@getDelete']);
	Route::get('inspections/orderby-top', ['as' => 'ortho.inspections.orderby.top', 'uses' => 'InspectionController@orderby_top']);
	Route::get('inspections/orderby-last', ['as' => 'ortho.inspections.orderby.last', 'uses' => 'InspectionController@orderby_last']);
	Route::get('inspections/orderby-up', ['as' => 'ortho.inspections.orderby.up', 'uses' => 'InspectionController@orderby_up']);
	Route::get('inspections/orderby-down', ['as' => 'ortho.inspections.orderby.down', 'uses' => 'InspectionController@orderby_down']);

	// insurances
	Route::get('insurances', ['as' => 'ortho.insurances.index', 'uses' => 'InsuranceController@index']);
	Route::get('insurances/regist', ['as' => 'ortho.insurances.regist', 'uses' => 'InsuranceController@getRegist']);
	Route::post('insurances/regist', ['as' => 'ortho.insurances.regist', 'uses' => 'InsuranceController@postRegist']);
	Route::get('insurances/edit/{id}', ['as' => 'ortho.insurances.edit', 'uses' => 'InsuranceController@getEdit']);
	Route::post('insurances/edit/{id}', ['as' => 'ortho.insurances.edit', 'uses' => 'InsuranceController@postEdit']);
	Route::get('insurances/delete/{id}', ['as' => 'ortho.insurances.delete', 'uses' => 'InsuranceController@getDelete']);
	Route::get('insurances/orderby-top', ['as' => 'ortho.insurances.orderby.top', 'uses' => 'InsuranceController@orderby_top']);
	Route::get('insurances/orderby-last', ['as' => 'ortho.insurances.orderby.last', 'uses' => 'InsuranceController@orderby_last']);
	Route::get('insurances/orderby-up', ['as' => 'ortho.insurances.orderby.up', 'uses' => 'InsuranceController@orderby_up']);
	Route::get('insurances/orderby-down', ['as' => 'ortho.insurances.orderby.down', 'uses' => 'InsuranceController@orderby_down']);
    
    //Services
	Route::get('services', ['as' => 'ortho.services.index', 'uses' => 'ServiceController@index']);
	Route::get('services/regist', ['as' => 'ortho.services.regist', 'uses' => 'ServiceController@getRegist']);
	Route::post('services/regist', ['as' => 'ortho.services.regist', 'uses' => 'ServiceController@postRegist']);
	Route::get('services/edit/{id}', ['as' => 'ortho.services.edit', 'uses' => 'ServiceController@getEdit']);
	Route::post('services/edit/{id}', ['as' => 'ortho.services.edit', 'uses' => 'ServiceController@postEdit']);
	Route::get('services/delete/{id}', ['as' => 'ortho.services.delete', 'uses' => 'ServiceController@delete']);
	Route::get('services/orderby-top', ['as' => 'ortho.services.orderby.top', 'uses' => 'ServiceController@orderby_top']);
	Route::get('services/orderby-last', ['as' => 'ortho.services.orderby.last', 'uses' => 'ServiceController@orderby_last']);
	Route::get('services/orderby-up', ['as' => 'ortho.services.orderby.up', 'uses' => 'ServiceController@orderby_up']);
	Route::get('services/orderby-down', ['as' => 'ortho.services.orderby.down', 'uses' => 'ServiceController@orderby_down']);

	//Equipments
	Route::get('equipments', ['as' => 'ortho.equipments.index', 'uses' => 'EquipmentController@index']);
	Route::get('equipments/regist', ['as' => 'ortho.equipments.regist', 'uses' => 'EquipmentController@getRegist']);
	Route::post('equipments/regist', ['as' => 'ortho.equipments.regist', 'uses' => 'EquipmentController@postRegist']);
	Route::get('equipments/edit/{id}', ['as' => 'ortho.equipments.edit', 'uses' => 'EquipmentController@getEdit']);
	Route::post('equipments/edit/{id}', ['as' => 'ortho.equipments.edit', 'uses' => 'EquipmentController@postEdit']);
	Route::get('equipments/delete/{id}', ['as' => 'ortho.equipments.delete', 'uses' => 'EquipmentController@delete']);
	Route::get('equipments/orderby-top', ['as' => 'ortho.equipments.orderby.top', 'uses' => 'EquipmentController@orderby_top']);
	Route::get('equipments/orderby-last', ['as' => 'ortho.equipments.orderby.last', 'uses' => 'EquipmentController@orderby_last']);
	Route::get('equipments/orderby-up', ['as' => 'ortho.equipments.orderby.up', 'uses' => 'EquipmentController@orderby_up']);
	Route::get('equipments/orderby-down', ['as' => 'ortho.equipments.orderby.down', 'uses' => 'EquipmentController@orderby_down']);

	//3dct
	Route::get('xray_3dct/regist', ['as' => 'ortho.xrays.x3dct.regist', 'uses' => 'X3dctController@getRegist']);
	Route::post('xray_3dct/regist', ['as' => 'ortho.xrays.x3dct.regist', 'uses' => 'X3dctController@postRegist']);
	Route::get('xray_3dct/edit', ['as' => 'ortho.xrays.x3dct.edit', 'uses' => 'X3dctController@getRegist']);
	Route::post('xray_3dct/edit', ['as' => 'ortho.xrays.x3dct.edit', 'uses' => 'X3dctController@postRegist']);

	// xrays
	Route::any('xrays', ['as' => 'ortho.xrays.index', 'uses' => 'XrayController@index']);
	Route::get('xrays/regist', ['as' => 'ortho.xrays.regist', 'uses' => 'XrayController@getRegist']);
	Route::post('xrays/regist', ['as' => 'ortho.xrays.regist', 'uses' => 'XrayController@postRegist']);
	Route::get('xrays/edit/{id}', ['as' => 'ortho.xrays.edit', 'uses' => 'XrayController@getEdit']);
	Route::post('xrays/edit/{id}', ['as' => 'ortho.xrays.edit', 'uses' => 'XrayController@postEdit']);
	Route::get('xrays/delete/{id}', ['as' => 'ortho.xrays.delete', 'uses' => 'XrayController@getDelete']);
	Route::get('xrays/detail/{id}', ['as' => 'ortho.xrays.detail', 'uses' => 'XrayController@getDetail']);
	Route::get('xrays/search', ['as' => 'ortho.xrays.search', 'uses' => 'XrayController@getSearch']);
	Route::get('xrays/get-day', ['as' => 'ortho.xrays.get.day', 'uses' => 'XrayController@getDay']);

	// patients
	Route::any('patients', ['as' => 'ortho.patients.index', 'uses' => 'PatientController@index']);
	Route::get('patients/regist', ['as' => 'ortho.patients.regist', 'uses' => 'PatientController@getRegist']);
	Route::post('patients/regist', ['as' => 'ortho.patients.regist', 'uses' => 'PatientController@postRegist']);
	Route::get('patients/edit/{id}', ['as' => 'ortho.patients.edit', 'uses' => 'PatientController@getEdit']);
	Route::post('patients/edit/{id}', ['as' => 'ortho.patients.edit', 'uses' => 'PatientController@postEdit']);
	Route::get('patients/delete/{id}', ['as' => 'ortho.patients.delete', 'uses' => 'PatientController@getDelete']);
	Route::get('patients/detail/{id}', ['as' => 'ortho.patients.detail', 'uses' => 'PatientController@getDetail']);
	Route::get('patients/ajax/autocomplete-patient', ['as' => 'ortho.patients.autocomplete.patient', 'uses' => 'PatientController@AutoCompletePatient']);

	// brothers patient
	Route::any('patients/brothers/{patient_id}', ['as' => 'ortho.patients.brothers.index', 'uses' => 'BrotherController@index']);
	Route::get('patients/brothers/regist/{patient_id}', ['as' => 'ortho.patients.brothers.regist', 'uses' => 'BrotherController@getRegist']);
	Route::post('patients/brothers/regist/{patient_id}', ['as' => 'ortho.patients.brothers.regist', 'uses' => 'BrotherController@postRegist']);
	Route::get('patients/brothers/edit/{id}/{patient_id}', ['as' => 'ortho.patients.brothers.edit', 'uses' => 'BrotherController@getEdit']);
	Route::post('patients/brothers/edit/{id}/{patient_id}', ['as' => 'ortho.patients.brothers.edit', 'uses' => 'BrotherController@postEdit']);
	Route::get('patients/brothers/delete/{id}/{patient_id}', ['as' => 'ortho.patients.brothers.delete', 'uses' => 'BrotherController@getDelete']);
	Route::get('patients/brothers/ajax/autocomplete-patient', ['as' => 'ortho.patients.brothers.autocomplete.patient', 'uses' => 'BrotherController@AutoCompletePatient']);

	// communications patient (com)
	Route::any('patients/communications/{patient_id}', ['as' => 'ortho.patients.communications.index', 'uses' => 'CommunicationController@index']);
	Route::get('patients/communications/regist/{patient_id}', ['as' => 'ortho.patients.communications.regist', 'uses' => 'CommunicationController@getRegist']);
	Route::post('patients/communications/regist/{patient_id}', ['as' => 'ortho.patients.communications.regist', 'uses' => 'CommunicationController@postRegist']);
	Route::get('patients/communications/edit/{id}/{patient_id}', ['as' => 'ortho.patients.communications.edit', 'uses' => 'CommunicationController@getEdit']);
	Route::post('patients/communications/edit/{id}/{patient_id}', ['as' => 'ortho.patients.communications.edit', 'uses' => 'CommunicationController@postEdit']);
	Route::get('patients/communications/delete/{id}/{patient_id}', ['as' => 'ortho.patients.communications.delete', 'uses' => 'CommunicationController@getDelete']);
	Route::get('patients/communications/detail/{id}/{patient_id}', ['as' => 'ortho.patients.communications.detail', 'uses' => 'CommunicationController@getDetail']);

	//treatment1
	Route::get('treatment1', ['as' => 'ortho.treatments.treatment1.index', 'uses' => 'treatment1Controller@index']);
	Route::get('treatment1/regist', ['as' => 'ortho.treatments.treatment1.regist', 'uses' => 'treatment1Controller@getRegist']);
	Route::post('treatment1/regist', ['as' => 'ortho.treatments.treatment1.regist', 'uses' => 'treatment1Controller@postRegist']);
	Route::get('treatment1/edit/{id}', ['as' => 'ortho.treatments.treatment1.edit', 'uses' => 'treatment1Controller@getEdit']);
	Route::post('treatment1/edit/{id}', ['as' => 'ortho.treatments.treatment1.edit', 'uses' => 'treatment1Controller@postEdit']);

	// auth
	Route::get('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@getLogin']);
	Route::post('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@postLogin']);
	Route::get('/logout', ['as' => 'ortho.logout', 'uses' => 'AuthController@getLogout']);
	Route::get('/change-password/{id}', ['as' => 'ortho.change.password', 'uses' => 'AuthController@getChangePassword']);
	Route::post('/change-password/{id}', ['as' => 'ortho.change.password', 'uses' => 'AuthController@postChangePassword']);
});