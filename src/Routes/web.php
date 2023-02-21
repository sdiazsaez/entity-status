<?php

use Larangular\EntityStatus\Http\Controllers\EntityGateway;

Route::group([
    'prefix'     => 'api/entity-status/',
    'middleware' => 'api',
    'namespace'  => 'Larangular\EntityStatus\Http\Controllers',
    'as'         => 'larangular.api.entity-status.',
], static function () {
    Route::resource('status', EntityGateway::class);
});
