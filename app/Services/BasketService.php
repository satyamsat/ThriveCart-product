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
    
    /**
     * @param \App\Repositories\ProductRepository $productRepository
     * @param \App\Repositories\DeliveryShippingRuleRepository $shippingRuleRepository
     * @param \App\Strategies\PricingStrategyInterface $pricingStrategy
     */
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
     * @param string $productCode
     * @return void
     */
    public function add(string $productCode): void
    {
        $this->basket[] = $productCode;
    }

    /**
     * @param array $productCodes
     * @return void
     */
    public function addMultiple(array $productCodes): void    
    {
        foreach ($productCodes as $code) {
            $this->add($code);
        }
    }

    /**
     * @return float|int
     */
    public function total(): float|int 
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
     * @param array $productCodes
     * @return float|int
     */
    public function getTotal(array $productCodes): float|int   
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
     * @param mixed $subtotal
     * @return float
     */
    protected function calculateDelivery($subtotal): float
    {
        $shipping = $this->shippingRuleRepository->getApplicableRule($subtotal);
        return $shipping ? $shipping->delivery_cost : 4.95;
    }
}
