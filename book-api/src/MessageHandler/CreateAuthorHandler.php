<?php
namespace App\MessageHandler;

use App\Entity\Author;
use App\Message\CreateAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateAuthorHandler
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(CreateAuthor $msg): void
    {
        $a = (new Author())->setName($msg->dto->name);
        $this->em->persist($a);
        $this->em->flush();
    }
}
