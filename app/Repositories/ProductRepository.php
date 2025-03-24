<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findByCode(string $code): ?Product
    {
        return Product::where('code', $code)->first();
    }
}
