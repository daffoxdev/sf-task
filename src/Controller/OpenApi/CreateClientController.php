<?php

namespace App\Controller\OpenApi;

use App\Constants\SerializerGroup;
use App\Dto\ClientDto;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/api/client')]
class CreateClientController extends AbstractController
{
    #[Route(methods: 'post')]
    public function create(
        Request $request,
        ClientDto $clientDto,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {

        $violations = $validator->validate($clientDto);

        $response = [
            'client_dto' => $clientDto,
            'violations' => $violations
        ];

        $json = $serializer->serialize($response, 'json', [
//            'groups' => [SerializerGroup::AIRLINE_AUTOCOMPLETE_SEARCH]
        ]);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route(path: '{id}', methods: 'get')]
    public function get(int $id, ClientRepository $repository): JsonResponse
    {
        if (!$client = $repository->find($id)) {
            throw new NotFoundHttpException(sprintf('Client with id #%d not found', $id));
        }

        // TODO symfony serializer needed
        return new JsonResponse([]);
    }
}