<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'domain'        => config('admin.route.domain'),
], function (Router $router) {
    // 首页
    $router->get('/', 'HomeController@index')->name('admin.home');
    // 筛选条件
    $router->get('/selector/prizes-groups', 'SelectorController@prizeGroups');
    $router->get('/selector/materials', 'SelectorController@materials');
    // 会员
    $router->resource('users', UserController::class);
    // 抽奖组
    $router->resource('prizes-groups', PrizesGroupController::class);
    $router->resource('prizes', PrizesController::class);
    $router->resource('prizes-logs', PrizesLogController::class);
    $router->resource('materials', MaterialsController::class);
});
