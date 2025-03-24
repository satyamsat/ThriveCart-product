<?php 
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CartApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed the database with valid products
        Product::insert([
            ['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95],
            ['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95],
            ['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95],
        ]);
    }

    #[Test]
    public function it_returns_correct_total_for_cart()
    {
        $response = $this->getJson('/cart?products=B01,G01');
        $response->assertStatus(200)
                 ->assertJson(['total' => 37.85]);
    }

    #[Test]
    public function it_returns_error_for_invalid_product_code()
    {
        $response = $this->getJson('/cart?products=INVALID_CODE');
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'Invalid product codes: INVALID_CODE',
                 ]);
    }
}