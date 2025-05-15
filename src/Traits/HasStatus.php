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

    public function entityStatusWhereKey(string $key) {
        return $this->morphOne(EntityStatus::class, 'entity')->where('key', $key);
    }

    public function entityStatus(string $key, $value = null, $message = null) {
        $slugKey = Str::slug($key);
        $existing = $this->entityStatuses()->where('key', $slugKey)->first();

        if (is_null($value)) {
            return $existing;
        }

        if ($existing) {
            $existing->update([
                'status' => $value,
                'message' => $message,
            ]);
            return $existing;
        }

        //firstOrNew pops entity_type, id...
        $s = $this->entityStatuses()->firstOrNew(['key' => $slugKey]);
        $s->status = $value;
        $s->message = $message;
        $s->save();

        return $s;
    }

    public function setEntityStatus(string $key, $value) {
        return $this->entityStatus($key, $value);
    }

}
