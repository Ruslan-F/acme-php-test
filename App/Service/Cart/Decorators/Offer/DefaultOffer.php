<?php

namespace App\Service\Cart\Decorators\Offer;

use App\Model\Order;
use App\Service\Cart\Decorators\OrderDecoratorInterface;

class DefaultOffer implements OrderDecoratorInterface
{
    public function decorate(Order $order): Order
    {
        /**
         * @var $firsts - is a dynamic list of first-pair of R01 that has not yet discounted its second pair
         * when second pair discount is resolved (in a loop) - first pair $first[key] sets to false,
         * So if order has four R01 products - 2 of them will go full price, other 2 - half price.
         */
        $firsts = [];

        foreach ($order->orderLines as $orderLine) {
            if (array_key_exists($orderLine->product->code, $firsts) && $firsts[$orderLine->product->code] === true) {
                $orderLine->endPrice = intdiv($orderLine->product->price, 2);
                $firsts[$orderLine->product->code] = false;
            } else {
                if ($orderLine->product->code === 'R01') {
                    $firsts[$orderLine->product->code] = true;
                }
                $orderLine->endPrice = $orderLine->product->price;
            }
        }

        return $order;
    }
}