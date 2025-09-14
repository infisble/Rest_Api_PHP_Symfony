<?php
namespace App\MessageHandler;

use App\Entity\Book;
use App\Message\DeleteBook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteBookHandler
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(DeleteBook $msg): void
    {
        $b = $this->em->getRepository(Book::class)->find($msg->id);
        if (!$b) { return; }
        $this->em->remove($b);
        $this->em->flush();
    }
}
