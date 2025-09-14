<?php
namespace App\MessageHandler;

use App\Entity\Book;
use App\Message\UpdateBook;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateBookHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private AuthorRepository $authors
    ) {}

    public function __invoke(UpdateBook $msg): void
    {
        $b = $this->em->getRepository(Book::class)->find($msg->id);
        if (!$b) { return; }

        $b->setTitle($msg->dto->title);
        $b->setDescription($msg->dto->description);

        $linked = $this->authors->findBy(['id' => $msg->dto->authorIds]);
        $b->setAuthors($linked);

        $this->em->flush();
    }
}
