<?php

namespace Recruitment\Cart;

use http\Exception\InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /** @var float */
    private $totalPrice;

    public function __construct(Product $product, int $quantity)
    {
        if ($product->getMinimumQuantity() > $quantity) {
            throw new \InvalidArgumentException();
        }

        $this->totalPrice = $product->getUnitPrice() * $quantity;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        if ($this->product->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException();
        }

        $this->quantity = $quantity;
        $this->totalPrice = $this->product->getUnitPrice() * $quantity;

        return $this;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

}