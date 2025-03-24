<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 8, 2); // Minimum order amount
            $table->decimal('delivery_cost', 8, 2); // Cost for this rule
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_shipping_rules');
    }
};
