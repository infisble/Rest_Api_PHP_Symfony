<?php
namespace App\Controller;

use App\Dto\BookDto;
use App\Http\EntityJson;
use App\Message\CreateBook;
use App\Message\DeleteBook;
use App\Message\UpdateBook;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/api/books')]
class BookController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(BookRepository $repo): JsonResponse
    {
        $items = array_map(EntityJson::book(...), $repo->findBy([], ['id' => 'ASC']));
        return $this->json($items);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getOne(int $id, BookRepository $repo): JsonResponse
    {
        $b = $repo->find($id);
        return $b ? $this->json(EntityJson::book($b)) : $this->json(['error'=>'Not found'],404);
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] BookDto $dto, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new CreateBook($dto));
        return new JsonResponse(['status'=>'accepted'], 202);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] BookDto $dto, BookRepository $repo, MessageBusInterface $bus): JsonResponse
    {
        if (!$repo->find($id)) return $this->json(['error'=>'Not found'],404);
        $bus->dispatch(new UpdateBook($id, $dto));
        return new JsonResponse(['status'=>'accepted'], 202);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, BookRepository $repo, MessageBusInterface $bus): JsonResponse
    {
        if (!$repo->find($id)) return $this->json(['error'=>'Not found'],404);
        $bus->dispatch(new DeleteBook($id));
        return new JsonResponse(['status'=>'accepted'], 202);
    }
}
