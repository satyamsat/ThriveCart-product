<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BasketService;
use App\Validators\ProductValidator;
use App\Models\Product;

class CartController extends Controller
{
    protected $basketService;
    protected $productValidator;

    public function __construct(ProductValidator $productValidator, BasketService $basketService)
    {
        $this->productValidator = $productValidator;

        // Initialize Basket Service
        $this->basketService = $basketService;
    }

    /**
     * Handle GET request to calculate total basket price.
     * Example: /api/basket?products=B01,R01,R01
     */
    public function getTotal(Request $request)
    {
        // Validate request format
        $validator = $this->productValidator->validateRequest($request->all());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $productCodes = explode(',', $request->query('products'));

        $invalidProducts = $this->productValidator->validateProductExistence($request->query('products'));
        if ($invalidProducts) {
            return response()->json(['error' => 'Invalid product codes: ' . implode(',', $invalidProducts)], 400);
        }
        
        // Add products to basket
        $totalPrice = $this->basketService->getTotal($productCodes);

        // Return total price
        return response()->json([
           'total' => $totalPrice
        ]);
    }
}
