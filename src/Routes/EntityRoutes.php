<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Routes;

use Illuminate\Support\Facades\Route;
use Larangular\EntityStatus\Http\Controllers\EntityGateway as Gateway;

class EntityRoutes {

    public static function routes(): void {
        $key = 'entity-status';
        Route::get($key, [
            Gateway::class,
            'index',
        ])
             ->name($key . '.index');

        Route::get($key . '/{entityStatus}', [
            Gateway::class,
            'show',
        ])
             ->name($key . '.show');

        Route::post($key, [
            Gateway::class,
            'store',
        ])
             ->name($key . '.store');

        Route::match([
            'put',
            'patch',
        ], $key . '/{entity}', [
            Gateway::class,
            'store',
        ])
             ->name($key . '.update');

    }

}
