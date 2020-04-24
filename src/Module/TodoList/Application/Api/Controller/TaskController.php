<?php

namespace App\Module\TodoList\Application\Api\Controller;

use App\Module\TodoList\Domain\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/todolist/tasks", name="todolist_tasks_list")
     * @return Response
     */
    public function list(): Response
    {
        $entities = iterator_to_array($this->repository->findAll());
        return JsonResponse::create($entities)
            ->setEncodingOptions(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
    }

    /**
     * @Route("/todolist/tasks/{id}", name="todolist_tasks_get_by_id")
     * @param int $id
     * @return Response
     */
    public function getById(int $id): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity) {
            throw new NotFoundHttpException('The task does not exist');
        }

        return JsonResponse::create($entity)
            ->setEncodingOptions(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
    }
}
