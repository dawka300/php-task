<?php

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class Cart
{
    /** @var Item[] */
    private $items;

    /** @var float */
    private $totalPrice = 0;

    /** @var Order */
    private $order;

    /** @return  Item[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getItem($key): Item
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        throw new OutOfBoundsException;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function addProduct(Product $product, int $quantity = 1): self
    {
        $this->totalPrice += $product->getUnitPrice() * $quantity;
        $this->items[$product->getId()] = new Item($product, $quantity);

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if (isset($this->items[$product->getId()])) {
            $this->totalPrice -= $product->getUnitPrice() * $this->items[$product->getId()]->getQuantity();
            unset($this->items[$product->getId()]);
        }

        return $this;
    }

    public function setQuantity(Product $product, int $quantity): self
    {
        if (!isset($this->items[$product->getId()])) {
            $this->addProduct($product, $quantity);
        }
        $totalItemPriceBefore = $this->items[$product->getId()]->getTotalPrice();
        $this->items[$product->getId()]->setQuantity($quantity);
        $totalItemPriceAfter = $this->items[$product->getId()]->getTotalPrice();
        $this->totalPrice += $totalItemPriceAfter - $totalItemPriceBefore;

        return $this;
    }

    /** to powinna byc osobna klasa */
    public function checkout(int $id): Order
    {
        $this->order = new Order($id, $this->items, $this->totalPrice);

        $this->items = [];
        $this->totalPrice = 0;

        return $this->order;
    }

}