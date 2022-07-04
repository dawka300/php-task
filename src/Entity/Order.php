<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /** @var int */
    private $id;

    /** @var Item[] */
    private $items;

    /** @var float */
    private $total_price;

    public function __construct(int $id, array $items, float $totalPrice)
    {
        $this->id = $id;
        $this->items = $items;
        $this->total_price = $totalPrice;
    }

    public function getDataForView(): array
    {
        $array = get_object_vars($this);
        $result = [];
        foreach ($array['items'] as $value) {
            $result[] = [
                'id' => $value->getProduct()->getId(),
                'quantity' => $value->getQuantity(),
                'total_price' => $value->getTotalPrice()
            ];
        }

        $array['items'] = $result;

        return $array;
    }


}