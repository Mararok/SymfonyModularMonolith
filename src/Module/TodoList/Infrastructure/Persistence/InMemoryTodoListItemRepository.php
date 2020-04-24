<?php


namespace App\Module\TodoList\Infrastructure\Persistence;


use App\Module\TodoList\Domain\TodoListItem;
use App\Module\TodoList\Domain\TodoListItemRepository;

class InMemoryTodoListItemRepository implements TodoListItemRepository
{
    /**
     * @var array
     */
    private $list;

    public function __construct(array $list)
    {
        $this->list = [];
        foreach ($list as $item) {
            $this->list[$item->getId()] = $item;
        }
    }

    public function findAll(): \Iterator
    {
        return new \ArrayIterator($this->list);
    }

    public function findById(int $id): ?TodoListItem
    {
        return isset($this->list[$id]) ? $this->list[$id] : null;
    }
}
