<?php

namespace App\Service\Cart\Catalogues;


use App\Model\Product;

/**
 * AFAI - there can be a lot of product-lists / catalogues (one per shop/cart if there's a lot of shops)
 */
class Widget extends Catalogue
{
    /**
     * IRL - this should be an ORM collection / scope to filter specific products by Catalogue->id / database scheme name, etc.
     */
    public function __construct()
    {
        $this->products = [
            new Product('R01', 'Red Widget', 3295),
            new Product('G01', 'Green Widget', 2495),
            new Product('B01', 'Blue Widget', 795),
        ];
    }
}