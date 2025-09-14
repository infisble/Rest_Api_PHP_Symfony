<?php
namespace App\MessageHandler;

use App\Entity\Author;
use App\Message\DeleteAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteAuthorHandler
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(DeleteAuthor $msg): void
    {
        $a = $this->em->getRepository(Author::class)->find($msg->id);
        if (!$a) { return; }
        $this->em->remove($a);
        $this->em->flush();
    }
}
