<?php


namespace App\Core\Message;


abstract class Message implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return [
            "class" => static::class,
            "data" => \Closure::bind(function ($message) {
                return get_object_vars($message);
            }, $this, static::class)($this)
        ];
    }

    public function __toString()
    {
        return static::class;
    }
}
