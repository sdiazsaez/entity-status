<?php
/**
 * Copyright (c) 2022. Simon Diaz <sdiaz@sdshost.ml>
 */

namespace Larangular\EntityStatus\Http\Controllers;

use Illuminate\Http\Request;
use Larangular\EntityStatus\Http\Requests\StoreEntityStatusRequest;
use Larangular\EntityStatus\Models\EntityStatus;
use Larangular\EntityStatus\Traits\HasStatus;
use Larangular\RoutingController\MakeResponse;

class EntityProviderGateway {

    use MakeResponse;

    public function model() {
        return EntityStatus::class;
    }


    public function index($entity, Request $request) {
        if (!instance_has_trait($entity, HasStatus::class)) {
            return [];
        }

        // Check if 'key' query parameter exists
        if ($request->filled('key')) {
            $key = $request->query('key');

            // Fetch the specific entity status by key
            $entityStatus = $entity->entityStatusWhereKey($key)->first();

            // Return 404 if no entity status is found
            if (!$entityStatus) {
                return response()->json([
                    'message' => 'Entity status not found for the provided key.',
                ], 404);
            }

            return $this->makeResponse($entityStatus);
        }

        return $this->makeResponse($entity->entityStatuses()->get());
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
