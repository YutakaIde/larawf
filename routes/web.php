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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/workflow/project', 'ProjectController');
Route::resource('/workflow/workflow', 'WorkflowLogController');
Route::resource('/workflow/file', 'FileController');

Route::get('workflow/task/{id}', 'TaskController@finish');
