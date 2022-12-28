<?php

namespace Larangular\EntityStatus\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Larangular\EntityStatus\Contracts\EntityStatusDescriptions;
use Larangular\EntityStatus\Models\EntityStatus;

trait HasStatus {

    abstract public function entityStatusDescriptions(string $key): EntityStatusDescriptions;

    public function entityStatusMorph(): MorphOne {
        return $this->morphOne(EntityStatus::class, 'entity');
    }

    public function entityStatusMorphWhereKey(string $key) {
        return $this->morphOne(EntityStatus::class, 'entity')->where('key', $key);
    }

    public function entityStatus(string $key, $value = null, $message = null) {
        $w = ['key' => Str::slug($key)];
        return is_null($value)
            ? $this->status()->where($w)->first()
            : $this->status()->updateOrCreate($w, ['status' => $value, 'message' => $message]);
    }

    public function setEntityStatus(string $key, $value) {
        return $this->entityStatus($key, $value);
    }

}
