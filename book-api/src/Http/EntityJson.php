<?php
namespace App\Http;

use App\Entity\Author;
use App\Entity\Book;

final class EntityJson
{
    public static function author(Author $a): array
    {
        return [
            'id' => $a->getId(),
            'name' => $a->getName(),
            'bookIds' => array_map(fn($b) => $b->getId(), $a->getBooks()->toArray()),
        ];
    }

    public static function book(Book $b): array
    {
        return [
            'id' => $b->getId(),
            'title' => $b->getTitle(),
            'description' => $b->getDescription(),
            'authorIds' => array_map(fn($a) => $a->getId(), $b->getAuthors()->toArray()),
        ];
    }
}
