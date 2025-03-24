<?php 

namespace App\Services;
use App\Repositories\ProductRepository;
use App\Repositories\DeliveryShippingRuleRepository;
use App\Strategies\PricingStrategyInterface;

class BasketService
{
    protected $basket = [];
    protected ProductRepository $productRepository;
    protected DeliveryShippingRuleRepository $shippingRuleRepository;
    protected PricingStrategyInterface $pricingStrategy;

    public function __construct(
        ProductRepository $productRepository,
        DeliveryShippingRuleRepository $shippingRuleRepository,
        PricingStrategyInterface $pricingStrategy
    ) {
        $this->productRepository = $productRepository;
        $this->shippingRuleRepository = $shippingRuleRepository;
        $this->pricingStrategy = $pricingStrategy;
    }

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
            $product = $this->productRepository->findByCode($code);
            if(!$product){
                continue;
            }
            $subtotal += $this->pricingStrategy->calculatePrice($product, $quantity);
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
     * Calculate delivery cost based on rules.
     */
    protected function calculateDelivery($subtotal)
    {
        $shipping = $this->shippingRuleRepository->getApplicableRule($subtotal);
        return $shipping ? $shipping->delivery_cost : 4.95;
    }
}
