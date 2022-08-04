<?php

namespace App\Controller\OpenApi;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/client', methods: 'post')]
class CreateClientController extends AbstractController
{
    #[Route(methods: 'post')]
    public function create(Request $request): JsonResponse
    {

    }

    #[Route(methods: 'get')]
    public function get(int $id, ClientRepository $repository): JsonResponse
    {
        if (!$client = $repository->find($id)) {
            throw new NotFoundHttpException(sprintf('Client with id #%d not found', $id));
        }

        // TODO symfony serializer needed
        return new JsonResponse([]);
    }
}