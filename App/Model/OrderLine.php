<?php

namespace App\Model;

/**
 * Represents Order->OrderLine associated with Product can be used further to generate InvoiceLine
 * - OrderLine represents A SINGLE product unit, (no quantity) with it's discounted price
 * - InvoiceLine should be created from a grouped OrderLines by orderLine->product->code + orderLine->endPrice
 */
class OrderLine
{
    public readonly Product $product;
    /** @var int currency (atomic) price afet all decorators (discounts) applied */
    public int $endPrice;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->endPrice = $product->price;
    }
}