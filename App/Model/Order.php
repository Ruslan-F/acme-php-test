<?php

namespace App\Model;

use App\Service\Cart\Catalogues\Catalogue;

/**
 * Represents Cart->Order - an entity that's created on Cart->total() call
 */
class Order
{
    private Catalogue $catalogue;

    /** @var $orderLines OrderLine[] */
    public array $orderLines = [];
    public int $deliveryLine;

    public function __construct(array $codesVsQuantities, Catalogue $catalogue)
    {
        $this->catalogue = $catalogue;

        foreach ($codesVsQuantities as $code => $quantity) {
            $this->addOrderLine($code, $quantity);
        }
    }

    /**
     * -
     * @param string $code
     * @param int $quantity
     * @return bool
     */
    public function addOrderLine(string $code, int $quantity): bool
    {
        $targetIndex = array_search($code, array_column($this->catalogue->products, 'code'));

        if ($targetIndex === false) {
            return false;
        }

        $i = 0;

        while ($i !== $quantity) {
            $this->orderLines[] = new OrderLine($this->catalogue->products[$targetIndex]);
            $i += 1;
        }

        return true;
    }

    /**
     * - is a simple reducer method
     * @return int
     */
    public function total(): int
    {
        $sub = 0;

        foreach ($this->orderLines as $line) {
            $sub += $line->endPrice;
        }

        return $sub + $this->deliveryLine;
    }
}