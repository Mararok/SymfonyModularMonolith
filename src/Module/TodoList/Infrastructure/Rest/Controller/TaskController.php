<?php

namespace App\Module\TodoList\Infrastructure\Rest\Controller;

use App\Core\Account\AccountContextController;
use App\Core\Domain\Exception\NotFoundException;
use App\Core\Rest\Controller\CommandQueryController;
use App\Module\TodoList\Application\Command\Task\AssignUserCommand;
use App\Module\TodoList\Application\Command\Task\CreateCommand;
use App\Module\TodoList\Application\Query\Task\GetListQuery;
use App\Module\TodoList\Application\Query\Task\FindByIdQuery;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
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
     * @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      format="application/json",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="name", type="string", example="test_name")
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
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     *
     * @SWG\Response(
     *      response=200,
     *      description="Returns selected entity by id",
     * )
     * @SWG\Response(
     *      response=404,
     *      description="When selected entity doesn't exists",
     * )
     * @param int $id
     * @return Response
     * @throws Throwable
     */
    public function getById(int $id): Response
    {
        $entity = $this->executeQuery(new FindByIdQuery(TaskId::create($id)));


        return $this->jsonResponse($entity);
    }

    /**
     * @Route("/{id}:assignUser", name="assign_user", methods={"POST"})
     * @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      format="application/json",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="userId", type="integer", example=1)
     *      )
     * )
     * @SWG\Response(
     *      response=200,
     *      description="AssignedUserToTask",
     * )
     * @param Request $request
     * @return Response
     */
    public function assignUser(Request $request): Response
    {
        $this->executeCommand(new AssignUserCommand(
            TaskId::create($request->attributes->get("id")),
            UserId::create($request->request->get("userId")))
        );
        return Response::create("", Response::HTTP_OK);
    }

    /**
     * @Route("", name="list", methods={"GET"})
     * @SWG\Response(
     *      response=200,
     *      description="Returns entity list",
     * )
     * @return Response
     * @throws Throwable
     */
    public function list(): Response
    {
        $result = $this->executeQuery(new GetListQuery());
        $entities = iterator_to_array($result);
        return $this->jsonResponse($entities);
    }
}
