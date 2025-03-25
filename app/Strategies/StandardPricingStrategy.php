<?php

namespace App\Strategies;

use App\Models\Product;

class StandardPricingStrategy implements PricingStrategyInterface
{
    /**
     * @param \App\Models\Product $product
     * @param int $quantity
     * @return float
     */
    public function calculatePrice(Product $product, int $quantity): float
    {
        if ($product->code === 'R01' && $quantity > 1) {
            $fullPriceCount = ceil($quantity / 2);
            $halfPriceCount = floor($quantity / 2);
            $price = ($fullPriceCount * $product->price) + ($halfPriceCount * ($product->price / 2));
            return floor($price * 100) / 100;
        }

        return round($quantity * $product->price,2);
    }
}
