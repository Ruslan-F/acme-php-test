<?php

namespace App\Model;

/**
 * Represents abstract Product for purchase, which later converts to Cart->product[] => Order->OrderLine[]
 */
readonly class Product
{
    public string $code;
    public string $name;
    public int $price;

    public function __construct(string $code, string $name, int $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }
}