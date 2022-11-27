<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // $ip = request()->ip();
    // echo $ip;
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    return \Illuminate\Support\Str::random(32);
});

$prefix = 'api/v1';

$router->group(['prefix' => $prefix], function () use ($router) {

    $router->get('/version', function () use ($router) {
        echo "Timesheet Version 1.0.0";
    });

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/signin', 'API\AuthController@signin');
        $router->post('/signout', 'API\AuthController@signout');
        $router->post('refresh', 'API\AuthController@refresh');
        $router->get('verify/{token}', 'API\AuthController@verify');
    });

    $router->group(['middleware' => ['jwt.auth', 'emp.has.company']], function () use ($router) {

        $router->group(['prefix' => 'company'], function () use ($router) {
            $router->get('/create', ['middleware' => 'permission:company,create', 'uses' => 'API\CompanyController@create']);
            $router->get('/read', ['middleware' => 'permission:company,read', 'uses' => 'API\CompanyController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:company,read', 'uses' => 'API\CompanyController@read']);
            $router->get('/update', ['middleware' => 'permission:company,update', 'uses' => 'API\CompanyController@update']);
        });

        $router->group(['prefix' => 'role'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:role,create', 'uses' => 'API\RoleController@create']);
            $router->get('/read', ['middleware' => 'permission:role,read', 'uses' => 'API\RoleController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:role,read', 'uses' => 'API\RoleController@read']);
            $router->post('/update', ['middleware' => 'permission:role,update', 'uses' => 'API\RoleController@update']);
            $router->post('/delete', ['middleware' => 'permission:role,delete', 'uses' => 'API\RoleController@delete']);
        });

        $router->group(['prefix' => 'branch'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:branch,create', 'uses' => 'API\BranchController@create']);
            $router->get('/read', ['middleware' => 'permission:branch,read', 'uses' => 'API\BranchController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:branch,read', 'uses' => 'API\BranchController@read']);
            $router->post('/update', ['middleware' => 'permission:branch,update', 'uses' => 'API\BranchController@update']);
            $router->post('/delete', ['middleware' => 'permission:branch,delete', 'uses' => 'API\BranchController@delete']);
        });

        $router->group(['prefix' => 'permission'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:permission,create', 'uses' => 'API\PermissionController@create']);
            $router->get('/read', ['middleware' => 'permission:permission,read', 'uses' => 'API\PermissionController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:permission,read', 'uses' => 'API\PermissionController@read']);
            $router->post('/update', ['middleware' => 'permission:permission,update', 'uses' => 'API\PermissionController@update']);
            $router->post('/delete', ['middleware' => 'permission:permission,delete', 'uses' => 'API\PermissionController@delete']);
        });

        $router->group(['prefix' => 'application'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:application,create', 'uses' => 'API\ModuleAppController@create']);
            $router->get('/read', ['middleware' => 'permission:application,read', 'uses' => 'API\ModuleAppController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:application,read', 'uses' => 'API\ModuleAppController@read']);
            $router->post('/update', ['middleware' => 'permission:application,update', 'uses' => 'API\ModuleAppController@update']);
            $router->post('/delete', ['middleware' => 'permission:application,delete', 'uses' => 'API\ModuleAppController@delete']);
        });

        $router->group(['prefix' => 'department'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:department,create', 'uses' => 'API\DepartmentController@create']);
            $router->get('/read', ['middleware' => 'permission:department,read', 'uses' => 'API\DepartmentController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:department,read', 'uses' => 'API\DepartmentController@read']);
            $router->post('/update', ['middleware' => 'permission:department,update', 'uses' => 'API\DepartmentController@update']);
            $router->post('/delete', ['middleware' => 'permission:department,delete', 'uses' => 'API\DepartmentController@delete']);
        });

        $router->group(['prefix' => 'job-title'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:job-title,create', 'uses' => 'API\JobTitleController@create']);
            $router->get('/read', ['middleware' => 'permission:job-title,read', 'uses' => 'API\JobTitleController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:job-title,read', 'uses' => 'API\JobTitleController@read']);
            $router->post('/update', ['middleware' => 'permission:job-title,update', 'uses' => 'API\JobTitleController@update']);
            $router->post('/delete', ['middleware' => 'permission:job-title,delete', 'uses' => 'API\JobTitleController@delete']);
        });

        $router->group(['prefix' => 'job-type'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:job-type,create', 'uses' => 'API\JobTypeController@create']);
            $router->get('/read', ['middleware' => 'permission:job-type,read', 'uses' => 'API\JobTypeController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:job-type,read', 'uses' => 'API\JobTypeController@read']);
            $router->post('/update', ['middleware' => 'permission:job-type,update', 'uses' => 'API\JobTypeController@update']);
            $router->post('/delete', ['middleware' => 'permission:job-type,delete', 'uses' => 'API\JobTypeController@delete']);
        });

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->post('/create', ['middleware' => 'permission:user,create', 'uses' => 'API\UserController@create']);
            $router->get('/read', ['middleware' => 'permission:user,read', 'uses' => 'API\UserController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:user,read', 'uses' => 'API\UserController@read']);
            $router->post('/update', ['middleware' => 'permission:user,update', 'uses' => 'API\UserController@update']);
            $router->post('/delete', ['middleware' => 'permission:user,delete', 'uses' => 'API\UserController@delete']);
            $router->get('/trashed', ['middleware' => 'permission:user,read', 'uses' => 'API\UserController@trashed']);
            $router->get('/profile', 'API\UserController@profile');
        });

        $router->group(['prefix' => 'permission-user'], function () use ($router) {
            $router->get('/read', 'API\PermissionUserController@read');
            $router->post('/create', ['middleware' => 'permission:permission-user,create', 'uses' => 'API\PermissionUserController@AssignPermission']);
        });

        $router->group(['prefix' => 'employee'], function () use ($router) {
            $router->get('/read', ['middleware' => 'permission:employee,read', 'uses' => 'API\EmployeeController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:employee,read', 'uses' => 'API\EmployeeController@read']);
            $router->post('/create', ['middleware' => 'permission:employee,create', 'uses' => 'API\EmployeeController@create']);
            $router->post('/update', ['middleware' => 'permission:employee,update', 'uses' => 'API\EmployeeController@update']);
            $router->post('/delete', ['middleware' => 'permission:employee,delete', 'uses' => 'API\EmployeeController@delete']);
            $router->get('/trashed', ['middleware' => 'permission:employee,read', 'uses' => 'API\EmployeeController@trashed']);
        });

        $router->group(['prefix' => 'project'], function () use ($router) {
            $router->get('/read', ['middleware' => 'permission:project,read', 'uses' => 'API\ProjectController@read']);
            $router->get('/read/{id}', ['middleware' => 'permission:project,read', 'uses' => 'API\ProjectController@read']);
            $router->post('/create', ['middleware' => 'permission:project,create', 'uses' => 'API\ProjectController@create']);
            $router->post('/update', ['middleware' => 'permission:project,update', 'uses' => 'API\ProjectController@update']);
            $router->post('/delete', ['middleware' => 'permission:project,delete', 'uses' => 'API\ProjectController@delete']);

            // Tag by Project
            $router->group(['prefix' => 'tag'], function () use ($router) {
                $router->get('/read', ['middleware' => 'permission:tag,read', 'uses' => 'API\TagController@read']);
                $router->get('/read/{id}', ['middleware' => 'permission:tag,read', 'uses' => 'API\TagController@read']);
                $router->post('/create', ['middleware' => 'permission:tag,create', 'uses' => 'API\TagController@create']);
                $router->post('/update', ['middleware' => 'permission:tag,update', 'uses' => 'API\TagController@update']);
                $router->post('/delete', ['middleware' => 'permission:tag,delete', 'uses' => 'API\TagController@delete']);
            });

            // Assign Dept by Project
            $router->group(['prefix' => 'assign'], function () use ($router) {
                $router->post('/create', ['middleware' => 'permission:project,create', 'uses' => 'API\ProjectController@assing_dept']);

                $router->get('/read', ['middleware' => 'permission:project,read', 'uses' => 'API\ProjectController@read_assing_dept']);

                $router->get('/read/{id}', ['middleware' => 'permission:project,read', 'uses' => 'API\ProjectController@read_assing_dept']);
                // $router->get('/read', ['middleware' => 'permission:project,read', 'uses' => 'API\ProjectController@read_assing_dept']);

            });
        });

        $router->group(['prefix' => 'timesheet'], function () use ($router) {
            $router->get('/my-timesheet', ['middleware' => 'permission:timesheet,read', 'uses' => 'API\TimesheetController@myTimesheet']);
            $router->post('/create', ['middleware' => 'permission:timesheet,create', 'uses' => 'API\TimesheetController@create']);
            $router->post('/submit', ['middleware' => 'permission:timesheet,update', 'uses' => 'API\TimesheetController@update']);
        });
    });
});
