<?php
namespace App\Message;

use App\Dto\AuthorDto;

class CreateAuthor { public function __construct(public AuthorDto $dto) {} }
class UpdateAuthor { public function __construct(public int $id, public AuthorDto $dto) {} }
class DeleteAuthor { public function __construct(public int $id) {} }
