<?php

namespace App\Module\User\Infrastructure\Rest\Controller;

use App\Core\Account\AccountContextController;
use App\Core\Domain\Exception\NotFoundException;
use App\Core\Rest\Controller\CommandQueryController;
use App\Module\User\Application\Command\User\Create\CreateCommand;
use App\Module\User\Application\Query\User\FindAll\FindAllQuery;
use App\Module\User\Application\Query\User\FindById\FindByIdQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Throwable;


/**
 * @Route("/user/users", name="user_users_")
 * @SWG\Tag(name="User")
 */
class UserController extends CommandQueryController implements AccountContextController
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
     *      description="Creates user",
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
     * @SWG\Response(
     *      response=200,
     *      description="Returns entity list",
     * )
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
        $entity = $this->executeQuery(new FindByIdQuery($id));
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $this->jsonResponse($entity);
    }
}
