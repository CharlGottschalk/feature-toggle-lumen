<?php

use Illuminate\Support\Facades\Route;
use CharlGottschalk\FeatureToggleLumen\Http\Controllers\FeaturesController;
use CharlGottschalk\FeatureToggleLumen\Http\Middleware\SanitizeInput;

/*
 * Routes for checking features
 */
$this->app->router->group(['prefix' => 'is'], function () {
    $this->app->router->post('/enabled', [
        'as' => 'features.toggle.is.enabled',
        'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\FeaturesController@enabled'
    ]);

    $this->app->router->post('/enabled-for', [
        'as' => 'features.toggle.is.enabled.for',
        'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\FeaturesController@enabledFor'
    ]);
});

/*
 * Routes for managing features
 */
$this->app->router->get('/', [
    'as' => 'features.toggle.index',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@index'
]);
$this->app->router->post('/show', [
    'as' => 'features.toggle.show',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@show'
]);
$this->app->router->post('/disable', [
    'as' => 'features.toggle.disable',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@disable'
]);
$this->app->router->post('/enable', [
    'as' => 'features.toggle.enable',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@enable'
]);
$this->app->router->post('/toggle', [
    'as' => 'features.toggle.toggle',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@toggle'
]);
$this->app->router->post('/delete', [
    'as' => 'features.toggle.delete',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@delete'
]);
$this->app->router->post('/store', [
    'as' => 'features.toggle.store',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@store'
]);
$this->app->router->post('/{id}/update', [
    'as' => 'features.toggle.update',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@update'
]);
$this->app->router->post('/attach', [
    'as' => 'features.toggle.attach',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@attach'
]);
$this->app->router->post('/detach', [
    'as' => 'features.toggle.detach',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@detach'
]);
$this->app->router->post('/sync', [
    'as' => 'features.toggle.sync',
    'uses' => 'CharlGottschalk\FeatureToggleLumen\Http\Controllers\ManagerController@sync'
]);
