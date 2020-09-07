<?php

namespace Larangular\EntityStatus\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Larangular\EntityStatus\Contracts\EntityStatusDescriptions;
use Larangular\EntityStatus\Models\EntityStatus;

trait HasStatus {

    abstract public function entityStatusDescriptions(): EntityStatusDescriptions;

    public function status(): MorphOne {
        return $this->morphOne(EntityStatus::class, 'entity');
    }

    public function setEntityStatus($value) {
        $s = $this->status()->firstOrNew([]);
        $s->status = $value;
        $s->save();
        return $this;
    }

}
