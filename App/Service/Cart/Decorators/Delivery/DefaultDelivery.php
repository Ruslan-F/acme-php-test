<?php

namespace App\Service\Cart\Decorators\Delivery;

use App\Model\Order;
use App\Service\Cart\Decorators\OrderDecoratorInterface;

/**
 * LIMITS is currency (atomic) cart-total-limits as key and currency (atomic) delivery cost as value
 */
const LIMITS = [9000 => 0, 5000 => 295];
/**
 * default delivery price
 */
const DEFAULT_DELIVERY_PRICE = 495;

class DefaultDelivery implements OrderDecoratorInterface
{
    public function decorate(Order $order): Order
    {
        $productLinesDecoratedTotal = 0;
        foreach ($order->orderLines as $orderLine) {
            $productLinesDecoratedTotal += $orderLine->endPrice;
        }

        $desc = LIMITS;
        krsort($desc); // in case LIMITS has chaotic key order
        foreach ($desc as $limit => $delivery) {
            if ($productLinesDecoratedTotal >= $limit) {
                $order->deliveryLine = $delivery;
                return $order;
            }
        }
        $order->deliveryLine = DEFAULT_DELIVERY_PRICE;
        return $order;
    }
}
