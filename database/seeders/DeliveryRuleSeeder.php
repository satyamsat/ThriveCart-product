<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryShippingRule;

class DeliveryRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryShippingRule::insert([
            ['min_amount' => 0, 'delivery_cost' => 4.95],    // Below $50 → $4.95
            ['min_amount' => 50, 'delivery_cost' => 2.95],   // $50 - $89.99 → $2.95
            ['min_amount' => 90, 'delivery_cost' => 0.00],   // $90+ → Free delivery
        ]);
    }
}
