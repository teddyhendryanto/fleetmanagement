<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['web']], function(){
  Route::get('/', 'HomeController@index');
  Route::get('/home', 'HomeController@index')->name('home');

  Route::get('/markAsRead/{notification_id}','NotificationController@markAsRead')->name('notifications.markAsRead');
  Route::get('/markAllAsRead','NotificationController@markAllAsRead')->name('notifications.markAllAsRead');

  // Setup
  Route::prefix('setups')->group(function(){
    Route::resource('notifications','NotificationController',['only' => ['index','create','store','edit','update','destroy']]);
    Route::post('notifications_datatable','NotificationController@getNotificationsDatatable')->name('notifications.ajax.datatable');
    Route::post('notifications_assign_show','NotificationController@assignShow')->name('notifications.ajax.assignShow');
    Route::post('notifications_assign_store','NotificationController@assignStore')->name('notifications.assignStore');
  });

  // Admin Index
  Route::get('users','UserController@index')->name('users.index'); //->middleware('permission:role-list,role-create,role-edit,role-delete');
  Route::post('users_datatable','UserController@getUsersDatatable')->name('users.ajax.datatable');
  Route::get('users/create','UserController@create')->name('users.create'); //->middleware('permission:role-create');
  Route::post('users/create','UserController@store')->name('users.store'); //->middleware('permission:role-create');
  Route::get('users/{id}','UserController@show')->name('users.show');
  Route::get('users/{id}/edit','UserController@edit')->name('users.edit'); //->middleware('permission:role-edit');
  Route::put('users/{id}','UserController@update')->name('users.update'); //->middleware('permission:role-edit');
  Route::delete('users/{id}','UserController@destroy')->name('users.destroy'); //->middleware('permission:role-delete');

  // Role
  Route::get('roles','RoleController@index')->name('roles.index');//->middleware('permission:role-list,role-create,role-edit,role-delete');
  Route::post('roles_datatable','RoleController@getRolesDatatable')->name('roles.ajax.datatable');
  Route::get('roles/create','RoleController@create')->name('roles.create');//->middleware('permission:role-create');
  Route::post('roles/create','RoleController@store')->name('roles.store');//->middleware('permission:role-create');
  Route::get('roles/{id}','RoleController@show')->name('roles.show');
  Route::get('roles/{id}/edit','RoleController@edit')->name('roles.edit');//->middleware('permission:role-edit');
  Route::put('roles/{id}','RoleController@update')->name('roles.update');//->middleware('permission:role-edit');
  Route::delete('roles/{id}','RoleController@destroy')->name('roles.destroy');//->middleware('permission:role-delete');

  // Permission
  Route::get('permissions','PermissionController@index')->name('permissions.index'); //->middleware('permission:role-list,role-create,role-edit,role-delete');
  Route::post('permissions_datatable','PermissionController@getPermissionsDatatable')->name('permissions.ajax.datatable');
  Route::get('permissions/create','PermissionController@create')->name('permissions.create'); //->middleware('permission:role-create');
  Route::post('permissions/create','PermissionController@store')->name('permissions.store'); //->middleware('permission:role-create');
  Route::get('permissions/{id}','PermissionController@show')->name('permissions.show');
  Route::get('permissions/{id}/edit','PermissionController@edit')->name('permissions.edit'); //->middleware('permission:role-edit');
  Route::put('permissions/{id}','PermissionController@update')->name('permissions.update'); //->middleware('permission:role-edit');
  Route::delete('permissions/{id}','PermissionController@destroy')->name('permissions.destroy'); //->middleware('permission:role-delete');

  Route::prefix('expedition')->group(function(){
    Route::prefix('setup')->group(function(){
      Route::resource('vehicle_classes','Expedition\VehicleClassController', ['except' => ['show']]);

      Route::resource('vehicles','Expedition\VehicleController', ['except' => ['show','destroy']]);
      Route::get('vehicles/delete/{id}','Expedition\VehicleController@delete')->name('vehicles.delete');
      Route::post('vehicles/show/vehicle','Expedition\VehicleController@show')->name('vehicles.show');

      Route::resource('areas','Expedition\AreaController', ['except' => ['show']]);
      Route::resource('customer_addons','Expedition\CustomerAddOnController', ['except' => ['show']]);
      Route::resource('costs','Expedition\CostController', ['except' => ['show']]);

      Route::resource('cost_settings','Expedition\CostSettingController', ['except' => ['show','destroy']]);
      Route::post('cost_settings/getCost','Expedition\CostSettingController@getCost')->name('cost_settings.getCost');
      Route::get('cost_settings/delete/{id}','Expedition\CostSettingController@delete')->name('cost_settings.delete');
      Route::post('cost_settings/show/cost','Expedition\CostSettingController@show')->name('cost_settings.show');

      Route::resource('employees','Expedition\EmployeeController', ['except' => ['show','destroy']]);
      Route::get('employees/delete/{id}','Expedition\EmployeeController@delete')->name('employees.delete');
      Route::post('employees/show/employee','Expedition\EmployeeController@show')->name('employees.show');

      Route::resource('etoll_cards','Expedition\EtollCardController', ['except' => ['show']]);
      Route::post('etoll_cards/getSiteAttribute','Expedition\EtollCardController@getSiteAttribute')->name('etoll_cards.ajax.getSiteAttribute');
      Route::post('etoll_cards/checkDuplicateNik','Expedition\EtollCardController@checkDuplicateNik')->name('etoll_cards.ajax.checkDuplicateNik');
      Route::post('etoll_cards/checkDuplicateVehicle','Expedition\EtollCardController@checkDuplicateVehicle')->name('etoll_cards.ajax.checkDuplicateVehicle');
      Route::post('etoll_cards/checkDuplicateEtoll','Expedition\EtollCardController@checkDuplicateEtoll')->name('etoll_cards.ajax.checkDuplicateEtoll');
      Route::post('etoll_cards/checkDuplicateEtollUpdate','Expedition\EtollCardController@checkDuplicateEtollUpdate')->name('etoll_cards.ajax.checkDuplicateEtollUpdate');
    });
  });

  Route::get('notif/{status}','NotifController@index')->name('notif.index');
});
