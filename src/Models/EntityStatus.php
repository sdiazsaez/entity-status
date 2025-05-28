<?php

namespace Larangular\EntityStatus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\RoutingController\Model as RoutingModel;

class EntityStatus extends Model {

    use RoutingModel;

    protected $fillable = [
        'key',
        'entity_type',
        'entity_id',
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

    public function setKeyAttribute($value) {
        $this->attributes['key'] = Str::slug($value);
    }

    public function setStatusAttribute($value) {
        $this->attributes['status'] = $value;
        $this->attributes['description'] = $this->getDescription($value);
    }

    public function updateDescription($value) {
        $this->attributes['description'] = $this->getDescription($value);
        $this->save();
    }

    private function getDescription($value) {
        if (empty($this->entity_type) || empty($this->entity_id)) {
            return ''; // o alguna descripción por defecto
        }

        $e = $this->entity()->first();
        if (!$e) {
            return '';
        }
        $sd = $e->entityStatusDescriptions($this->attributes['key']);
        return $sd->getDescription($value);
    }

    private function getDescription($value) {
        if (empty($this->entity_type) || empty($this->entity_id)) {
            return '';
        }

        $entity = $this->entity()->first();
        if (!$entity) {
            return '';
        }

        // Try model-defined description provider first
        if (method_exists($entity, 'entityStatusDescriptions')) {
            $provider = $entity->entityStatusDescriptions($this->attributes['key']);
            return $provider->getDescription($value);
        }

        // Fallback: use enum defined in config
        $enumClass = config("entity-status.enums.{$this->attributes['key']}");
        if (is_string($enumClass) && class_exists($enumClass) && method_exists($enumClass, 'getLabel')) {
            return $enumClass::getLabel($value) ?? (string) $value;
        }

        return (string) $value;
    }


}

