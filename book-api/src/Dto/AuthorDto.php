<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    public string $name;
}
