<?php

namespace Larangular\EntityStatus\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Larangular\EntityStatus\Models\EntityStatus;

trait HasStatus {

    abstract public function entityStatusDescriptions();

    public function status(): MorphOne {
        return $this->morphOne(EntityStatus::class, 'entity');
    }

}
