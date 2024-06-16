<?php

namespace App\Service\Cart;

use App\Model\Order;
use App\Service\Cart\Catalogues\Catalogue;
use App\Service\Cart\Decorators\OrderDecoratorInterface;

/**
 * Cart service represents shopping cart instance for specific shop (specific Catalogue).
 */
class Cart
{
    private Catalogue $catalogue;
    private OrderDecoratorInterface $deliveryDecorator;

    /** @var $offersDecorators OrderDecoratorInterface[] */
    private array $offersDecorators = [];

    private array $orderCodesVsQuantities = [];

    /**
     * @param Catalogue $catalogue - represents a list of products available for this shop / cart
     * @param array $offersDecorators - represents a LIST of decorators that myst be applied to Cart->Order.
     * @param OrderDecoratorInterface $deliveryDecorator - a single delivery decorator that adds delivery line to Cart->Order
     *
     * There's also a setter for both decorators here for theoretical case if user switch region or urgency (affects delivery)
     * or if user changes any other variables that may invalidate or change offers list.
     * Offers & Delivery implemented as decorators that expect Order model to decorate it's OrderLines based on Cart->products
     * This allows to keep the original prices of products and re-apply different decorator later.
     * Offers applied to Order object by reference one by one, and only depend on it's state,
     * so there's no need for extra controlling point / complexity layer like strategy manager.
     */
    public function __construct(Catalogue $catalogue, array $offersDecorators, OrderDecoratorInterface $deliveryDecorator)
    {
        $this->catalogue = $catalogue;
        $this->deliveryDecorator = $deliveryDecorator;
        $this->offersDecorators = $offersDecorators;
    }

    /**
     * Is an example method that can be called on Cart instance if offers list should be updated
     * @param OrderDecoratorInterface[] $offersDecorators
     * @return void
     */
    public function setOffersDecorators(array $offersDecorators)
    {
        $this->offersDecorators = $offersDecorators;
        $this->total(); // update endPrices
    }

    /**
     * Is an example method that can be called on Cart instance if offers list should be updated
     * @param OrderDecoratorInterface $deliveryDecorator
     * @return void
     */
    public function setDeliveryChargeStrategy(OrderDecoratorInterface $deliveryDecorator)
    {
        $this->deliveryDecorator = $deliveryDecorator;
        $this->total(); // update endPrices
    }

    /**
     * Add item to cart and call total() method to re-apply all discounts (in case some of their rules became valid)
     * @param string $productCode
     * @param int $quantity
     * @return void
     */
    public function add(string $productCode, int $quantity = 1): void
    {
        $this->orderCodesVsQuantities[$productCode] = array_key_exists($productCode, $this->orderCodesVsQuantities) ? $this->orderCodesVsQuantities[$productCode] : 0;
        $this->orderCodesVsQuantities[$productCode] += $quantity;
        $this->total();
    }

    /**
     * - creates new Order model, passing Cart's list of selected and available products (orderCodesVsQuantities vs catalogue)
     * then decorates this Order with decorators in a loop and returns it's total
     *
     * @return int
     */
    public function total(): int
    {
        $order = new Order($this->orderCodesVsQuantities, $this->catalogue);

        foreach ($this->offersDecorators as $decorator) {
            $decorator->decorate($order);
        }

        $this->deliveryDecorator->decorate($order);

        return $order->total();
    }
}