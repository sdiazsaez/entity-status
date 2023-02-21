<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Http\Controllers;

use Larangular\EntityStatus\Http\Requests\StoreEntityStatusRequest;
use Larangular\EntityStatus\Models\EntityStatus;
use Larangular\EntityStatus\Traits\HasStatus;
use Larangular\RoutingController\MakeResponse;

class EntityGateway {

    use MakeResponse;

    public function model() {
        return EntityStatus::class;
    }

    public function index($entityStatus) {
        if (!instance_has_trait($entityStatus, HasStatus::class)) {
            return [];
        }

        return $this->makeResponse($entityStatus->entityStatuses()->get());
    }

    public function show($entity, EntityStatus $entityStatus) {
        return $this->makeResponse($entityStatus);
    }

    public function store(StoreEntityStatusRequest $request, $entity) {
        $validated = $request->validated();
        $entity->entityStatus($validated['key'], $validated['status'], @$validated['message'] ?? null);
        return $this->makeResponse($entity->entityStatus($validated['key']));
    }

}
