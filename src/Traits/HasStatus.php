<?php

namespace Larangular\EntityStatus\Traits;

use Illuminate\Support\Str;
use Larangular\EntityStatus\Contracts\EntityStatusDescriptions;
use Larangular\EntityStatus\Models\EntityStatus;

trait HasStatus {

    abstract public function entityStatusDescriptions(string $key): EntityStatusDescriptions;

    public function entityStatuses() {
        return $this->morphMany(EntityStatus::class, 'entity');
    }

    public function entityStatusesWhereKey(string $key) {
        return $this->entityStatuses()->where('key', $key);
    }

    public function entityStatus(string $key, $value = null, $message = null) {
        $w = ['key' => Str::slug($key)];
        return is_null($value)
            ? $this->entityStatuses()->where($w)->first()
            : $this->entityStatuses()->updateOrCreate($w, ['status' => $value, 'message' => $message]);
    }

    public function setEntityStatus(string $key, $value) {
        return $this->entityStatus($key, $value);
    }

}
