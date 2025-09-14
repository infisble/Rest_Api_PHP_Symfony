<?php
namespace App\MessageHandler;

use App\Entity\Book;
use App\Message\CreateBook;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateBookHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private AuthorRepository $authors
    ) {}

    public function __invoke(CreateBook $msg): void
    {
        $b = (new Book())
            ->setTitle($msg->dto->title)
            ->setDescription($msg->dto->description);

        $linked = $this->authors->findBy(['id' => $msg->dto->authorIds]);
        $b->setAuthors($linked);

        $this->em->persist($b);
        $this->em->flush();
    }
}
