<?php

namespace App\Module\TodoList\Infrastructure\Rest\Controller;

use App\Core\Account\AccountContextController;
use App\Core\Message\Command\CommandBus;
use App\Core\Message\Query\QueryBus;
use App\Module\TodoList\Application\Command\Task\CreateTask\CreateCommand;
use App\Module\TodoList\Application\Query\Task\FindAll\FindAllQuery;
use App\Module\TodoList\Application\Query\Task\FindById\FindByIdQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/todo-list/tasks", name="todolist_tasks_")
 */
class TaskController extends AbstractController implements AccountContextController
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     * @return Response
     * @throws Throwable
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $this->commandBus->handle(new CreateCommand($data["name"]));
        return Response::create("", 201);
    }

    /**
     * @Route("", name="list", methods={"GET"})
     * @return Response
     * @throws Throwable
     */
    public function list(): Response
    {
        $result = $this->queryBus->handle(new FindAllQuery());
        $entities = iterator_to_array($result);
        return JsonResponse::create($entities)
            ->setEncodingOptions(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     * @throws Throwable
     */
    public function getById(int $id): Response
    {

        $entity = $result = $this->queryBus->handle(new FindByIdQuery($id));
        if (!$entity) {
            throw new NotFoundHttpException('The task does not exist');
        }

        return JsonResponse::create($entity)
            ->setEncodingOptions(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
    }
}
