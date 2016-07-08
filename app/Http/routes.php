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
	Route::get('xrays/3dct/{patient_id}/regist', ['as' => 'ortho.xrays.x3dct.regist', 'uses' => 'X3dctController@getRegist']);
	Route::post('xrays/3dct/{patient_id}/regist', ['as' => 'ortho.xrays.x3dct.regist', 'uses' => 'X3dctController@postRegist']);
	Route::get('xrays/3dct/{patient_id}/edit/{id}', ['as' => 'ortho.xrays.x3dct.edit', 'uses' => 'X3dctController@getEdit']);
	Route::post('xrays/3dct/{patient_id}/edit/{id}', ['as' => 'ortho.xrays.x3dct.edit', 'uses' => 'X3dctController@postEdit']);
	Route::get('xrays/3dct/{patient_id}/delete/{id}', ['as' => 'ortho.xrays.x3dct.delete', 'uses' => 'X3dctController@getDelete']);

	// xrays
	Route::any('xrays', ['as' => 'ortho.xrays.index', 'uses' => 'XrayController@index']);
	Route::get('xrays/{patient_id}/regist', ['as' => 'ortho.xrays.regist', 'uses' => 'XrayController@getRegist']);
	Route::post('xrays/{patient_id}/regist', ['as' => 'ortho.xrays.regist', 'uses' => 'XrayController@postRegist']);
	Route::get('xrays/{patient_id}/edit/{id}', ['as' => 'ortho.xrays.edit', 'uses' => 'XrayController@getEdit']);
	Route::post('xrays/{patient_id}/edit/{id}', ['as' => 'ortho.xrays.edit', 'uses' => 'XrayController@postEdit']);
	Route::get('xrays/{patient_id}/delete/{id}', ['as' => 'ortho.xrays.delete', 'uses' => 'XrayController@getDelete']);
	Route::get('xrays/{patient_id}/detail', ['as' => 'ortho.xrays.detail', 'uses' => 'XrayController@getDetail']);
	Route::get('xrays/search', ['as' => 'ortho.xrays.search', 'uses' => 'XrayController@getSearch']);
	Route::get('xrays/get-day', ['as' => 'ortho.xrays.get.day', 'uses' => 'XrayController@getDay']);
	Route::get('xrays/ajax/autocomplete-patient', ['as' => 'ortho.xrays.autocomplete.patient', 'uses' => 'XrayController@AutoCompletePatient']);

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
	Route::get('treatment1', ['as' => 'ortho.treatments.treatment1.index', 'uses' => 'Treatment1Controller@index']);
	Route::get('treatment1/regist', ['as' => 'ortho.treatments.treatment1.regist', 'uses' => 'Treatment1Controller@getRegist']);
	Route::post('treatment1/regist', ['as' => 'ortho.treatments.treatment1.regist', 'uses' => 'Treatment1Controller@postRegist']);
	Route::get('treatment1/edit/{id}', ['as' => 'ortho.treatments.treatment1.edit', 'uses' => 'Treatment1Controller@getEdit']);
	Route::post('treatment1/edit/{id}', ['as' => 'ortho.treatments.treatment1.edit', 'uses' => 'Treatment1Controller@postEdit']);
	Route::get('treatment1/delete/{id}', ['as' => 'ortho.treatments.treatment1.delete', 'uses' => 'Treatment1Controller@delete']);

	Route::get('treatment1/orderby-top', ['as' => 'ortho.treatments.treatment1.orderby.top', 'uses' => 'Treatment1Controller@orderby_top']);
	Route::get('treatment1/orderby-last', ['as' => 'ortho.treatments.treatment1.orderby.last', 'uses' => 'Treatment1Controller@orderby_last']);
	Route::get('treatment1/orderby-up', ['as' => 'ortho.treatments.treatment1.orderby.up', 'uses' => 'Treatment1Controller@orderby_up']);
	Route::get('treatment1/orderby-down', ['as' => 'ortho.treatments.treatment1.orderby.down', 'uses' => 'Treatment1Controller@orderby_down']);

	//Shifts
	Route::get('shifts', ['as' => 'ortho.shifts.index', 'uses' => 'ShiftController@index']);
	Route::get('shifts/edit/{id}', ['as' => 'ortho.shifts.edit', 'uses' => 'ShiftController@getEdit']);
	Route::post('shifts/edit/{id}', ['as' => 'ortho.shifts.edit', 'uses' => 'ShiftController@postEdit']);
	Route::get('shifts/setting', ['as' => 'ortho.shifts.setting', 'uses' => 'ShiftController@getSetting']);
	Route::post('shifts/setting', ['as' => 'ortho.shifts.setting', 'uses' => 'ShiftController@postSetting']);
	Route::get('shifts/search', ['as' => 'ortho.shifts.search', 'uses' => 'ShiftController@search']);

	Route::get('shifts/list-edit', ['as' => 'ortho.shifts.list_edit', 'uses' => 'ShiftController@getSListEdit']);
	Route::post('shifts/list-edit', ['as' => 'ortho.shifts.list_edit', 'uses' => 'ShiftController@postSListEdit']);

	//Facility
	Route::get('clinics/{clinic_id}/facility', ['as' => 'ortho.facilities.index', 'uses' => 'FacilityController@index']);
	Route::get('clinics/{clinic_id}/facility/regist', ['as' => 'ortho.facilities.regist', 'uses' => 'FacilityController@getRegist']);
	Route::post('clinics/{clinic_id}/facility/regist', ['as' => 'ortho.facilities.regist', 'uses' => 'FacilityController@postRegist']);
	Route::get('clinics/{clinic_id}/facility/edit/{id}', ['as' => 'ortho.facilities.edit', 'uses' => 'FacilityController@getEdit']);
	Route::post('clinics/{clinic_id}/facility/edit/{id}', ['as' => 'ortho.facilities.edit', 'uses' => 'FacilityController@postEdit']);
	Route::get('clinics/{clinic_id}/facility/delete/{id}', ['as' => 'ortho.facilities.delete', 'uses' => 'FacilityController@delete']);

	Route::get('clinics/{clinic_id}/facility/orderby-top', ['as' => 'ortho.facilities.orderby.top', 'uses' => 'FacilityController@orderby_top']);
	Route::get('clinics/{clinic_id}/facility/orderby-last', ['as' => 'ortho.facilities.orderby.last', 'uses' => 'FacilityController@orderby_last']);
	Route::get('clinics/{clinic_id}/facility/orderby-up', ['as' => 'ortho.facilities.orderby.up', 'uses' => 'FacilityController@orderby_up']);
	Route::get('clinics/{clinic_id}/facility/orderby-down', ['as' => 'ortho.facilities.orderby.down', 'uses' => 'FacilityController@orderby_down']);

	//Clinic Service
	Route::get('clinics/{clinic_id}/services', ['as' => 'ortho.clinics.services.index', 'uses' => 'ClinicServiceController@index']);

	//Clinic Service Template
	Route::get('clinics/{clinic_id}/services/{service_id}/templates', ['as' => 'ortho.clinics.services.template_list', 'uses' => 'ServiceTemplateController@index']);
	// Route::get('clinics/{clinic_id}/services/{service_id}/regist', ['as' => 'ortho.clinics.services.template_regist', 'uses' => 'ServiceTemplateController@getRegist']);
	// Route::post('clinics/{clinic_id}/services/{service_id}/regist', ['as' => 'ortho.clinics.services.template_regist', 'uses' => 'ServiceTemplateController@postRegist']);
	Route::get('clinics/{clinic_id}/services/{service_id}/update/{id}', ['as' => 'ortho.clinics.services.template_edit', 'uses' => 'ServiceTemplateController@getEdit']);
	Route::post('clinics/{clinic_id}/services/{service_id}/update/{id}', ['as' => 'ortho.clinics.services.template_edit', 'uses' => 'ServiceTemplateController@postEdit']);
	Route::get('clinics/{clinic_id}/services/{service_id}/delete/{id}', ['as' => 'ortho.clinics.services.template_delete', 'uses' => 'ServiceTemplateController@delete']);

	//Clinic Booking Template
	 Route::get('clinics/{clinic_id}/booking/templates', ['as' => 'ortho.clinics.booking.templates.index', 'uses' => 'BookingTemplateController@index']);
	  Route::get('clinics/{clinic_id}/booking/templates/regist', ['as' => 'ortho.clinics.booking.templates.regist', 'uses' => 'BookingTemplateController@getRegist']);
	 Route::post('clinics/{clinic_id}/booking/templates/regist', ['as' => 'ortho.clinics.booking.templates.regist', 'uses' => 'BookingTemplateController@postRegist']);
	 Route::get('clinics/{clinic_id}/booking/templates/edit/{id}', ['as' => 'ortho.clinics.booking.templates.edit', 'uses' => 'BookingTemplateController@getEdit']);
	 Route::post('clinics/{clinic_id}/booking/templates/edit/{id}', ['as' => 'ortho.clinics.booking.templates.edit', 'uses' => 'BookingTemplateController@postEdit']);
	 Route::get('clinics/{clinic_id}/booking/templates/delete/{id}', ['as' => 'ortho.clinics.booking.templates.delete', 'uses' => 'BookingTemplateController@delete']);

	Route::get('clinics/{clinic_id}/booking/templates/orderby-top/{id?}', ['as' => 'ortho.booking.templates.orderby.top', 'uses' => 'BookingTemplateController@orderby_top']);
	Route::get('clinics/{clinic_id}/booking/templates/orderby-last/{id?}', ['as' => 'ortho.booking.templates.orderby.last', 'uses' => 'BookingTemplateController@orderby_last']);
	Route::get('clinics/{clinic_id}/booking/templates/orderby-up/{id?}', ['as' => 'ortho.booking.templates.orderby.up', 'uses' => 'BookingTemplateController@orderby_up']);
	Route::get('clinics/{clinic_id}/booking/templates/orderby-down/{id?}', ['as' => 'ortho.booking.templates.orderby.down', 'uses' => 'BookingTemplateController@orderby_down']);


	// interviews (1st)
	Route::any('interviews', ['as' => 'ortho.interviews.index', 'uses' => 'InterviewController@index']);
	Route::get('interviews/set', ['as' => 'ortho.interviews.set', 'uses' => 'InterviewController@getSet']);
	Route::post('interviews/set', ['as' => 'ortho.interviews.set', 'uses' => 'InterviewController@postSet']);
	Route::get('interviews/regist', ['as' => 'ortho.interviews.regist', 'uses' => 'InterviewController@getRegist']);
	Route::post('interviews/regist', ['as' => 'ortho.interviews.regist', 'uses' => 'InterviewController@postRegist']);
	Route::get('interviews/edit/{id}', ['as' => 'ortho.interviews.edit', 'uses' => 'InterviewController@getEdit']);
	Route::post('interviews/edit/{id}', ['as' => 'ortho.interviews.edit', 'uses' => 'InterviewController@postEdit']);
	Route::get('interviews/delete/{id}', ['as' => 'ortho.interviews.delete', 'uses' => 'InterviewController@getDelete']);
	Route::get('interviews/detail/{patient_id}', ['as' => 'ortho.interviews.detail', 'uses' => 'InterviewController@getDetail']);

	//List1
	Route::get('list1_list', ['as' => 'ortho.bookings.list1_list', 'uses' => 'BookingController@list1_list']);

	// bookings
	Route::any('bookings/booking-monthly', ['as' => 'ortho.bookings.booking.monthly', 'uses' => 'BookingController@bookingMonthly']);

	Route::any('bookings/booking-daily', ['as' => 'ortho.bookings.booking.daily', 'uses' => 'BookingController@bookingDaily']);
	
	Route::any('bookings/booking-result-calendar', ['as' => 'ortho.bookings.booking.result.calendar', 'uses' => 'BookingController@bookingResultCalendar']);
	
	Route::get('bookings/booking-detail/{id}', ['as' => 'ortho.bookings.booking.detail', 'uses' => 'BookingController@bookingDetail']);

	Route::get('bookings/booking-edit/{id}', ['as' => 'ortho.bookings.booking.edit', 'uses' => 'BookingController@getEdit']);
	Route::post('bookings/booking-edit/{id}', ['as' => 'ortho.bookings.booking.edit', 'uses' => 'BookingController@postEdit']);

	Route::get('bookings/booking-regist/{id}', ['as' => 'ortho.bookings.booking.regist', 'uses' => 'BookingController@getRegist']);
	Route::post('bookings/booking-regist/{id}', ['as' => 'ortho.bookings.booking.regist', 'uses' => 'BookingController@postRegist']);

	Route::get('bookings/booking-1st-regist', ['as' => 'ortho.bookings.booking.1st.regist', 'uses' => 'BookingController@get1stRegist']);
	Route::post('bookings/booking-1st-regist', ['as' => 'ortho.bookings.booking.1st.regist', 'uses' => 'BookingController@post1stRegist']);

	Route::get('bookings/booking-change/{id}', ['as' => 'ortho.bookings.booking.change', 'uses' => 'BookingController@getChangeDate']);	
	Route::post('bookings/booking-change/{id}', ['as' => 'ortho.bookings.booking.change', 'uses' => 'BookingController@postChangeDate']);

	Route::any('bookings/booking-search', ['as' => 'ortho.bookings.booking_search', 'uses' => 'BookingController@bookingSearch']);
	
	Route::get('bookings/booking-change/{id}/confirm', ['as' => 'ortho.bookings.booking.change.confirm', 'uses' => 'BookingController@getConfirm']);
	Route::post('bookings/booking-change/{id}/confirm', ['as' => 'ortho.bookings.booking.change.confirm', 'uses' => 'BookingController@postConfirm']);
	
	Route::get('bookings/booking-result-list', ['as' => 'ortho.bookings.booking.result.list', 'uses' => 'BookingController@bookingResultList']);

	// Route::any('bookings', ['as' => 'ortho.bookings.index', 'uses' => 'BookingController@index']);
	// Route::get('bookings/set', ['as' => 'ortho.bookings.set', 'uses' => 'BookingController@getSet']);
	// Route::post('bookings/set', ['as' => 'ortho.bookings.set', 'uses' => 'BookingController@postSet']);
	// Route::get('bookings/regist', ['as' => 'ortho.bookings.regist', 'uses' => 'BookingController@getRegist']);
	// Route::post('bookings/regist', ['as' => 'ortho.bookings.regist', 'uses' => 'BookingController@postRegist']);
	// Route::get('bookings/edit/{id}', ['as' => 'ortho.bookings.edit', 'uses' => 'BookingController@getEdit']);
	// Route::post('bookings/edit/{id}', ['as' => 'ortho.bookings.edit', 'uses' => 'BookingController@postEdit']);
	// Route::get('bookings/delete/{id}', ['as' => 'ortho.bookings.delete', 'uses' => 'BookingController@getDelete']);



	// auth
	Route::get('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@getLogin']);
	Route::post('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@postLogin']);
	Route::get('/logout', ['as' => 'ortho.logout', 'uses' => 'AuthController@getLogout']);
	Route::get('/change-password/{id}', ['as' => 'ortho.change.password', 'uses' => 'AuthController@getChangePassword']);
	Route::post('/change-password/{id}', ['as' => 'ortho.change.password', 'uses' => 'AuthController@postChangePassword']);
});