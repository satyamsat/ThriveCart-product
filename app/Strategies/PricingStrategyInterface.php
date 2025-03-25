<?php

namespace App\Strategies;

use App\Models\Product;

interface PricingStrategyInterface
{
    /**
     * @param \App\Models\Product $product
     * @param int $quantity
     * @return float
     */
    public function calculatePrice(Product $product, int $quantity): float;
}
