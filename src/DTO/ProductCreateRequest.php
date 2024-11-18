<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    public ?float $price = null;

    #[Assert\Length(max: 1000)]
    public ?string $description = null;

    public function __construct(?string $name, ?float $price, ?string $description)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}
