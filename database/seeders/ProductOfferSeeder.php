<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductOffer;

class ProductOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductOffer::insert([
            'product_id' => 1, // Assuming the Red Widget has ID 1
            'offer_type' => 'buy_one_get_half',
            'required_quantity' => 2, 
            'discount_percentage' => 50.00, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
