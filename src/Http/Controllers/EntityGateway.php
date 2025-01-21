<?php

namespace Larangular\EntityStatus\Http\Controllers;

use Larangular\EntityStatus\Models\EntityStatus;
use Larangular\RoutingController\{Contracts\IGatewayModel, Controller};

class EntityGateway extends Controller implements IGatewayModel {

    public function model() {
        return EntityStatus::class;
    }
}
