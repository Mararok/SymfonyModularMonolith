<?php


namespace App\Core\Rest\Controller;


use App\Core\Message\Query\Query;
use App\Core\Message\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class QueryController implements Controller
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param Query $query
     * @return mixed
     * @throws \Throwable
     */
    protected function executeQuery(Query $query)
    {
        return $this->queryBus->handle($query);
    }

    protected function jsonResponse($data = null, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return JsonResponse::create($data, $status, $headers)
            ->setEncodingOptions(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
    }
}
