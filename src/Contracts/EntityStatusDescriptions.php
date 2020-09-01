<?php

namespace Larangular\EntityStatus\Contracts;

interface EntityStatusDescriptions {
    public function descriptions(): array;

    public function getDescription(int $index): ?string;
}
