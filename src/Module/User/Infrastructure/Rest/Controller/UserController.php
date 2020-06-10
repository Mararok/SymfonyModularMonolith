<?php

namespace App\Module\User\Infrastructure\Rest\Controller;

use App\Core\Account\AccountContextController;
use App\Core\Domain\Exception\NotFoundException;
use App\Core\Rest\Controller\CommandQueryController;
use App\Module\User\Application\Command\User\CreateCommand;
use App\Module\User\Application\Query\User\GetListQuery;
use App\Module\User\Application\Query\User\GetByIdQuery;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
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
     *          @SWG\Property(property="name", type="string", example="test_name"),
     *          @SWG\Property(property="email", type="string", example="test@test.com")
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
        $this->executeCommand(new CreateCommand(
            $request->request->get("name", ""),
            $request->request->get("email", "")
        ));
        return Response::create("", Response::HTTP_CREATED);
    }

    /**
     * @Route("", name="get_list", methods={"GET"})
     * @SWG\Response(
     *      response=200,
     *      description="Returns entity list",
     * )
     * @return Response
     * @throws Throwable
     */
    public function getList(): Response
    {
        $result = $this->executeQuery(new GetListQuery());
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
        $entity = $this->executeQuery(new GetByIdQuery(UserId::create($id)));
        return $this->jsonResponse($entity);
    }
}
