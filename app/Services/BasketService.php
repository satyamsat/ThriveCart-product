<?php 

namespace App\Services;
use App\Models\Product;
use App\Models\DeliveryShippingRule;

class BasketService
{
    protected $basket = [];

    /**
     * Add a single product code to the basket.
     */
    public function add(string $productCode)
    {
        $this->basket[] = $productCode;
    }

    /**
     * Add multiple products at once.
     */
    public function addMultiple(array $productCodes)
    {
        foreach ($productCodes as $code) {
            $this->add($code);
        }
    }

    /**
     * Get the total cost of the basket, applying discounts and delivery rules.
     */
    public function total()
    {
        $subtotal = 0;
        $productCount = array_count_values($this->basket);
        
        // Apply product prices
        foreach ($productCount as $code => $quantity) {
            $product = Product::where('code',$code)->first();
            if(!$product){
                continue;
            }
            $subtotal += $this->applyOffers($product, $quantity);
        }

        //If subtotal is zero 
        if($subtotal === 0){
            return 0;
        }

        // Apply delivery charges
        $deliveryCost = $this->calculateDelivery($subtotal);
        return round($subtotal + $deliveryCost, 2);
    }

    /**
     * New method: Get total price for multiple products at once.
     */
    public function getTotal(array $productCodes)
    {
        // Reset basket before processing
        $this->basket = [];
        
        if(count($productCodes) === 0){
            return (int) 0;
        }

        // Add multiple products
        $this->addMultiple($productCodes);
        
        // Return the total price
        return $this->total();
    }

    /**
     * Apply offers (e.g., buy one get second half price).
     */
    protected function applyOffers($product, $quantity)
    {
        $price = $product->price;
        
        if ($product->code === 'R01' && $quantity > 1) {
            // Find the number of full-price and half-price items
            $fullPriceCount = ceil($quantity / 2);  
            $halfPriceCount = floor($quantity / 2); 
            $total =  ($fullPriceCount * $price) + ($halfPriceCount * ($price / 2));
            return bcdiv($total, '1', 2);
        }
        return round($quantity * $price,2);
    }

    /**
     * Calculate delivery cost based on rules.
     */
    protected function calculateDelivery($subtotal)
    {
        $shipping = DeliveryShippingRule::where('min_amount','<=',$subtotal)->orderBy('min_amount', 'desc')->first();
        if($shipping){
            return $shipping->delivery_cost;
        }
        return 4.95; // Default to free delivery if no rule applies
    }
}
