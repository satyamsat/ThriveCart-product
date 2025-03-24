<?php
namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductValidator
{
    public function validateRequest(array $inputs)
    {
        return Validator::make($inputs, [
            'products' => ['required', 'string'], // Accepts a comma-separated string
        ]);
    }

    /**
     * Validate if all product codes exist in the database.
     */
    public function validateProductExistence(string $productCodes)
    {
        $codesArray = explode(',', $productCodes); // Convert string to array
        $existingProducts = Product::whereIn('code', $codesArray)->pluck('code')->toArray();
        $invalidProducts = array_diff($codesArray, $existingProducts);

        return !empty($invalidProducts) ? $invalidProducts : null;
    }
}
