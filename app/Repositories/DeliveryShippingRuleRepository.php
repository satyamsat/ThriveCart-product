<?php

namespace App\Repositories;

use App\Models\DeliveryShippingRule;

class DeliveryShippingRuleRepository
{
    /**
     * @param float $subtotal
     * @return DeliveryShippingRule|null
     */
    public function getApplicableRule(float $subtotal): ?DeliveryShippingRule
    {
        return DeliveryShippingRule::where('min_amount', '<=', $subtotal)
            ->orderBy('min_amount', 'desc')
            ->first();
    }
}
