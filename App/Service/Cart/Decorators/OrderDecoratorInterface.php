<?php

namespace App\Service\Cart\Decorators;

use App\Model\Order;

interface OrderDecoratorInterface
{
    public function decorate(Order $order);
}