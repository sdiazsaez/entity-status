<?php

namespace Larangular\EntityStatus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\RoutingController\Model as RoutingModel;

class EntityStatus extends Model {

    use RoutingModel;

    protected $fillable = [
        'status',
        'description',
        'message',
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $installableConfig = InstallableConfig::config('Larangular\EntityStatus\EntityStatusServiceProvider');
        $this->connection = $installableConfig->getConnection('entity_status');
        $this->table = $installableConfig->getName('entity_status');
        $this->timestamps = $installableConfig->getTimestamp('entity_status');
    }

    public function entity(): MorphTo {
        return $this->morphTo('entity');
    }

    public function scopeTypeWithStatus($query, $type, $status) {
        return $query->where([
            'type'   => $type,
            'status' => $status,
        ]);
    }

    public function setStatusAttribute($value) {
        $this->attributes['status'] = $value;
        $this->attributes['description'] = $this->getDescription($value);
    }

    private function getDescription($value) {
        $e = $this->entity()
                  ->first();
        $sd = $e->entityStatusDescriptions();
        return $sd->getDescription($value);
    }

}

