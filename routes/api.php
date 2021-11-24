<?php

use App\Http\Middleware\CheckIsAdmin;
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

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'], function () {
    
    Route::resource('roles', 'RoleController')->except([
        'create', 'edit'
    ]);

    Route::resource('user', 'UserController')->except([
        'create', 'edit', 'show'
    ]);
    
    Route::resource('ueb', 'UebController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('cultivo', 'CultivosController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('ausencias', 'AusenciasController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('quimicos', 'QuimicosController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('valores', 'ValoresController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('energias', 'EnergiaController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('maquinas', 'MaquinasController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('siembra', 'SiembraController')->except([
        'create', 'edit', 'show'
    ]);
    Route::resource('toneladas', 'ToneladasController')->except([
        'create', 'edit', 'show'
    ]);
    Route::get('/verify', 'UserController@verify');
    Route::post('email/verify', 'UserController@verifyEmail');

});

Route::post('login', 'Api\UserController@login');

Route::any('/{any}', function () {
    return view('welcome');
  })->where('any', '.*');