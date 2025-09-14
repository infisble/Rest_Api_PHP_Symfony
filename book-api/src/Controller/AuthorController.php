<?php
namespace App\Controller;

use App\Dto\AuthorDto;
use App\Http\EntityJson;
use App\Message\CreateAuthor;
use App\Message\DeleteAuthor;
use App\Message\UpdateAuthor;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/api/authors')]
class AuthorController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(AuthorRepository $repo): JsonResponse
    {
        $items = array_map(EntityJson::author(...), $repo->findBy([], ['id' => 'ASC']));
        return $this->json($items);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getOne(int $id, AuthorRepository $repo): JsonResponse
    {
        $a = $repo->find($id);
        return $a ? $this->json(EntityJson::author($a)) : $this->json(['error'=>'Not found'],404);
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] AuthorDto $dto, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new CreateAuthor($dto));
        return new JsonResponse(['status'=>'accepted'], 202);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] AuthorDto $dto, AuthorRepository $repo, MessageBusInterface $bus): JsonResponse
    {
        if (!$repo->find($id)) return $this->json(['error'=>'Not found'],404);
        $bus->dispatch(new UpdateAuthor($id, $dto));
        return new JsonResponse(['status'=>'accepted'], 202);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, AuthorRepository $repo, MessageBusInterface $bus): JsonResponse
    {
        if (!$repo->find($id)) return $this->json(['error'=>'Not found'],404);
        $bus->dispatch(new DeleteAuthor($id));
        return new JsonResponse(['status'=>'accepted'], 202);
    }
}
