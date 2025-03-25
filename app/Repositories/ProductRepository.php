<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * @param string $code
     * @return Product|null
     */
    public function findByCode(string $code): ?Product
    {
        return Product::where('code', $code)->first();
    }

    /**
     * @param string $productCode
     * @return bool
     */
    public function exists(string $productCode): bool
    {
        return Product::where('code', $productCode)->exists();
    }
}
