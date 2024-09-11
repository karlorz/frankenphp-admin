<?php
// src/Controller/MonsterController.php
namespace App\Controller;

use App\Entity\Monster;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MonsterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/custom/monsters/random', name: 'get_random_monster', methods: ['GET'])]
    #[OA\Get(
        path: '/api/custom/monsters/random',
        summary: 'Get a random monster',
        description: 'Returns a random monster',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(ref: '#/components/schemas/Monster')
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    public function getRandomMonster(): JsonResponse
    {
        $monsters = $this->entityManager->getRepository(Monster::class)->findAll();
        $randomMonster = $monsters[array_rand($monsters)];
        return $this->json($randomMonster);
    }

    #[Route('/api/custom/monsters/count', name: 'get_monster_count', methods: ['GET'])]
    #[OA\Get(
        path: '/api/custom/monsters/count',
        summary: 'Get the count of monsters',
        description: 'Returns the total number of monsters',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'count', type: 'integer')
                    ]
                )
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    public function getMonsterCount(): JsonResponse
    {
        $count = $this->entityManager->getRepository(Monster::class)->count([]);
        return $this->json(['count' => $count]);
    }
}