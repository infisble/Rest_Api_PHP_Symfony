<?php
namespace App\MessageHandler;

use App\Entity\Author;
use App\Message\UpdateAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateAuthorHandler
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(UpdateAuthor $msg): void
    {
        $a = $this->em->getRepository(Author::class)->find($msg->id);
        if (!$a) { return; }
        $a->setName($msg->dto->name);
        $this->em->flush();
    }
}
