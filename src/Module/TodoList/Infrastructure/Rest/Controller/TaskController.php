<?php

namespace App\Module\TodoList\Infrastructure\Rest\Controller;

use App\Core\Account\AccountContextController;
use App\Core\Domain\Exception\NotFoundException;
use App\Core\Rest\Controller\CommandQueryController;
use App\Module\TodoList\Application\Command\Task\CreateTask\CreateCommand;
use App\Module\TodoList\Application\Query\Task\FindAll\FindAllQuery;
use App\Module\TodoList\Application\Query\Task\FindById\FindByIdQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Throwable;


/**
 * @Route("/todo-list/tasks", name="todolist_tasks_")
 * @SWG\Tag(name="TodoList")
 */
class TaskController extends CommandQueryController implements AccountContextController
{
    /**
     * @Route("", name="create", methods={"POST"})
     *
     * @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      format="application/json",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="name", type="string", example="test_task")
     *      )
     * )
     * @SWG\Response(
     *      response=201,
     *      description="Creates task",
     * )
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $this->executeCommand(new CreateCommand($request->request->get("name")));
        return Response::create("", Response::HTTP_CREATED);
    }

    /**
     * @Route("", name="list", methods={"GET"})
     * @return Response
     * @throws Throwable
     */
    public function list(): Response
    {
        $result = $this->executeQuery(new FindAllQuery());
        $entities = iterator_to_array($result);
        return $this->jsonResponse($entities);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     * @throws Throwable
     */
    public function getById(int $id): Response
    {
        $entity = $this->executeQuery(new FindByIdQuery($id));
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $this->jsonResponse($entity);
    }
}
