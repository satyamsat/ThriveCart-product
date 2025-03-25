<?php
namespace App\Http\Controllers;

use App\Services\BasketService;
use App\Http\Requests\ProductRequest;

class CartController extends Controller
{
    /**
     * @param \App\Services\BasketService $basketService
     */
    public function __construct(protected BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    /**
    * @param ProductRequest $request
    *
    * @return \Illuminate\Http\JsonResponse 
    */
    public function getTotalCartPrice(ProductRequest $request)
    {
        $productCodes = explode(',', $request->input('products'));
        
        // Return total price
        return response()->json([
           'total' => $this->basketService->getTotal($productCodes)
        ]);
    }
}
