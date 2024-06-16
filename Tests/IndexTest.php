<?php

use App\Service\Cart\Decorators\Delivery\DefaultDelivery;
use App\Service\Cart\Decorators\Offer\DefaultOffer;
use App\Service\Cart\Cart;
use App\Service\Cart\Catalogues\Widget;

require __DIR__ . '/../vendor/autoload.php';

class IndexTest extends PHPUnit\Framework\TestCase
{
    public function testScenario1()
    {
        $cart = new Cart(new Widget(), [new DefaultOffer()], new DefaultDelivery());

        $cart->add('B01');
        $cart->add('G01');

        $this->assertEquals(3785, $cart->total());
    }

    public function testScenario2()
    {
        $cart = new Cart(new Widget(), [new DefaultOffer()], new DefaultDelivery());

        $cart->add('R01');
        $cart->add('R01');

        $this->assertEquals(5437, $cart->total());
    }

    public function testScenario3()
    {
        $cart = new Cart(new Widget(), [new DefaultOffer()], new DefaultDelivery());

        $cart->add('R01');
        $cart->add('G01');

        $this->assertEquals(6085, $cart->total());
    }

    public function testScenario4()
    {
        $cart = new Cart(new Widget(), [new DefaultOffer()], new DefaultDelivery());

        $cart->add('B01');
        $cart->add('B01');
        $cart->add('R01');
        $cart->add('R01');
        $cart->add('R01');

        $this->assertEquals(9827, $cart->total());
    }
}
