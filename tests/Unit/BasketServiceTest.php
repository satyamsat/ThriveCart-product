<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\BasketService;
use App\Repositories\ProductRepository;
use App\Repositories\DeliveryShippingRuleRepository;
use App\Strategies\PricingStrategyInterface;
use App\Models\Product;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class BasketServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductRepository|MockInterface $productRepository;
    protected DeliveryShippingRuleRepository|MockInterface $shippingRuleRepository;
    protected PricingStrategyInterface|MockInterface $pricingStrategy;
    protected BasketService $basketService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock repositories
        $this->productRepository = app(ProductRepository::class);
        $this->shippingRuleRepository = app(DeliveryShippingRuleRepository::class);
        $this->pricingStrategy = app(PricingStrategyInterface::class);

        // Seed the database with valid products
        Product::insert([
            ['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95],
            ['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95],
            ['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95],
        ]);

        $this->basketService = new BasketService(
            $this->productRepository,
            $this->shippingRuleRepository,
            $this->pricingStrategy
        );
    }

    #[Test]
    public function it_calculates_total_for_valid_products()
    {
        $total = $this->basketService->getTotal(['B01', 'G01']);

        $this->assertEquals(37.85, $total);
    }

    #[Test]
    public function it_applies_discount_for_buy_one_get_second_half_price()
    {
        $total = $this->basketService->getTotal(['R01', 'R01']); 
        $this->assertEquals(54.37, $total);
    }

    #[Test]
    public function it_returns_zero_when_no_products_are_added()
    {
        $total = $this->basketService->getTotal([]);

        $this->assertEquals(0, $total);
    }

    #[Test]
    public function it_handles_invalid_product_codes()
    {
        $total = $this->basketService->getTotal(['INVALID_CODE']);

        $this->assertEquals(0, $total); // Should return 0 as the product is invalid
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}