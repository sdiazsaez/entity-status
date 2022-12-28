<?php

namespace Larangular\EntityStatus\Observers;

use Larangular\EntityStatus\Models\EntityStatus;
use Msd\BuyoutOrders\Models\BuyoutOrder;
use Msd\Helpers\Pricing\PricingHelper;
use Msd\Proffers\Models\ProfferSelection;
use Msd\Quotes\Models\Quote;

class EntityStatusObserver {

    public function saved(EntityStatus $e): void {
        $e->entity->touch();
    }

    public function deleted(EntityStatus $e): void {
        $e->entity->touch();
    }

}
