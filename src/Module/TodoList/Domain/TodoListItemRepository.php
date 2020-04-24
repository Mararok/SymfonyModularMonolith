<?php


namespace App\Module\TodoList\Domain;


interface TodoListItemRepository
{
    public function findAll(): \Iterator;
    public function findById(int $id): ?TodoListItem;
}
