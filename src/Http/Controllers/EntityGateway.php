<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Http\Controllers;

use Larangular\EntityStatus\Http\Requests\StoreEntityStatusRequest;
use Larangular\EntityStatus\Models\EntityStatus;
use Larangular\EntityStatus\Traits\HasStatus;
use Larangular\RoutingController\MakeResponse;
use Msd\Permissions\Http\Requests\StoreEntityRoleRequest;
use Msd\Permissions\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class EntityGateway {

    use MakeResponse;

    public function model() {
        return EntityStatus::class;
    }

    public function index($entityStatus) {
        if (!instance_has_trait($entityStatus, HasStatus::class)) {
            return [];
        }

        return $this->makeResponse($entityStatus->entityStatus()
                                                ->get());
    }

    public function show($metable, $metadata) {
        return $this->makeResponse($metadata);
    }

    public function store(StoreEntityStatusRequest $request, $entity) {
        $validated = $request->validated();

        if (!is_array($validated['role_id'])) {
            $validated['role_id'] = [$validated['role_id']];
        }

        $entity->entityStatus($validated['key'], $validated['status'], $validated['message']);
        return $this->makeResponse($entity->entityStatus($validated['key']));
    }


}
