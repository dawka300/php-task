<?php

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    /** @var int */
    private $id;

    /** @var float */
    private $unitPrice;

    /** @var int */
    private $minimumQuantity;

    public function getMinimumQuantity(): ?int
    {
        return $this->minimumQuantity;
    }

    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if ($minimumQuantity < 1) {
            throw new InvalidArgumentException('The quantity must be larger than 0');
        }
        $this->minimumQuantity = $minimumQuantity;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        if ($unitPrice <= 0) {
            throw new InvalidUnitPriceException('The price has to be larger than 0');
        }
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

}