<?php

namespace Larangular\EntityStatus\Contracts;

interface EntityStatusDescriptions {
    public function getDescription($key): ?string;
}
