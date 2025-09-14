<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $title;

    public ?string $description = null;

    /** @var int[] */
    #[Assert\All([new Assert\Type('integer')])]
    public array $authorIds = [];
}
