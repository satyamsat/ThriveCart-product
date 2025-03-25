<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\ProductRepository;

class ProductRequest extends FormRequest
{
    protected $productRepository;

    /**
    * 
    * @param \App\Repositories\ProductRepository $productRepository
    */
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    /**
    * 
    * @return bool
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
    * 
    * @return array{products: string}
    */
    public function rules(): array
    {
        return [
            'products' => 'required|string',
        ];
    }

    /**
    * 
    * @return void
    */
    protected function prepareForValidation()
    {
        $invalidProducts = $this->validateProductExistence($this->input('products'));

        if (!empty($invalidProducts)) {
            $this->merge(['invalid_products' => $invalidProducts]);
        }
    }
    /**
    * 
    * @param mixed $validator
    * @return void
    */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('invalid_products')) {
                $validator->errors()->add('products', 'Invalid product codes: ' . implode(',', $this->input('invalid_products')));
            }
        });
    }
    /**
    * 
    * @param string $productCodes
    * @return string[]
    */
    private function validateProductExistence(string $productCodes): array
    {
        $codesArray = explode(',', $productCodes);
        $invalidProducts = [];

        foreach ($codesArray as $code) {
            if (!$this->productRepository->exists($code)) {
                $invalidProducts[] = $code;
            }
        }

        return $invalidProducts;
    }
}
