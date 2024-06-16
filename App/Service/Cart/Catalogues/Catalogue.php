<?php

namespace App\Service\Cart\Catalogues;

use App\Model\Product;

/**
 * Made an interface for theoretical case when there's different product catalogues exists
 */
abstract class Catalogue
{
    /** @var Product[]  */
    public array $products;
}