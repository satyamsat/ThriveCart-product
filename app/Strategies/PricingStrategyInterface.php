<?php

namespace App\Strategies;

use App\Models\Product;

interface PricingStrategyInterface
{
    public function calculatePrice(Product $product, int $quantity): float;
}
