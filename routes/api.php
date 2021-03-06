<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// general api routes
Route::group(['middleware'=>'auth:api'], function() {

	Route::post('password/reset', 'UserController@passwordReset');
	Route::get('logout', 'UserController@logout');
	Route::get('user/index', 'UserController@index');
	Route::post('user/edit', 'UserController@edit');
	Route::get('get_person', 'UserController@get_person');
	Route::get('audit_log/index', 'AuditLogController@index');
	Route::get('audit_log/utilization', 'AuditLogController@utilization');
	Route::get('configuration/index', 'ConfigurationController@index');
	Route::match(['get', 'post'],'configuration/edit', 'ConfigurationController@edit');
	Route::get('sms_template/index', 'SmsTemplateController@index');
	Route::match(['get', 'post'],'sms_template/edit', 'SmsTemplateController@edit');
	Route::get('hmo/index', 'HmoController@index');
	Route::match(['get', 'post'],'hmo/edit', 'HmoController@edit');
	Route::post('hmo/add', 'HmoController@add');
	Route::get('medical_package/index', 'MedicalPackageController@index');
	Route::match(['get', 'post'],'medical_package/edit', 'MedicalPackageController@edit');
	Route::post('consultant_type/add', 'ConsultantTypeController@add');
	Route::get('consultant_type/index', 'ConsultantTypeController@index');
	Route::match(['get', 'post'],'consultant_type/edit', 'ConsultantTypeController@edit');
	Route::get('consultant_type', 'ConsultantTypeController@list');
	Route::get('hmo_consultant_type_pf/delete', 'HmoConsultantTypePfController@delete');
	Route::get('report/income', 'ReportController@income');
	Route::patch('pcp/toggle_show_pf', 'PatientCareProviderController@toggle_show_pf');
});


// physician scopes
Route::group(['middleware'=>['auth:api','scope:physician']], function() {
	Route::get('physician/get_patient_visit', 'PhysicianController@get_patient_visit');
	Route::get('physician/get_practitioner_px', 'PhysicianController@get_practitioner_px');
	Route::get('physician/get_other_physician', 'PhysicianController@get_other_physician');
	Route::post('physician/set_professional_fee', 'PhysicianController@set_professional_fee');
	Route::get('physician/dashboard', 'PhysicianController@get_dashboard_data');
});



// patient scopes
Route::group(['middleware'=>['auth:api','scope:patient']], function() {

	Route::get('get_patient_orders', 'PatientController@get_patient_orders');
	// Route::get('get_person', 'PatientController@get_person');
});


// tpi scopes
Route::group(['middleware'=>['auth:api','scope:tpi']], function() {
	Route::post('his_posts', 'ImportController@his_posts');
	Route::get('get_professional_fee', 'PhysicianController@get_professional_fee');
	Route::get('get_follow_up_pf', 'PhysicianController@get_follow_up_pf');
	Route::post('set_pcp_transaction', 'PhysicianController@set_pcp_transaction');
});
