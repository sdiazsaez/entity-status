<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Routes;

use Illuminate\Support\Facades\Route;
use Msd\Permissions\Http\Controllers\Roles\ComponentGateway as Gateway;

class EntityRoutes {

    public static function routes(): void {
        Route::get('role', [
            Gateway::class,
            'index',
        ])
             ->name('role.index');

        /*
        Route::get('metadata/{metadata}', [
            Gateway::class,
            'show',
        ])
             ->name('metadata.show');
*/
        Route::post('role', [Gateway::class, 'store'])
             ->name('role.store');

        Route::match(['put', 'patch'], 'role/{metadata}', [Gateway::class, 'store'])
             ->name('role.update');

    }

}
