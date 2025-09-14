<?php
namespace App\Message;

use App\Dto\BookDto;

class CreateBook { public function __construct(public BookDto $dto) {} }
class UpdateBook { public function __construct(public int $id, public BookDto $dto) {} }
class DeleteBook { public function __construct(public int $id) {} }
