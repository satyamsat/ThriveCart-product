<?php

namespace App\Repositories;

use App\Models\DeliveryShippingRule;

class DeliveryShippingRuleRepository
{
    public function getApplicableRule(float $subtotal): ?DeliveryShippingRule
    {
        return DeliveryShippingRule::where('min_amount', '<=', $subtotal)
            ->orderBy('min_amount', 'desc')
            ->first();
    }
}
