<?php
declare(strict_types=1);

namespace event;

use Closure;
use Exception;

function listen(?string $name = null, ?Closure $callback = null)
{
    static $collection = [];

    if ($name === null && $callback === null) {
        return $collection;
    }

    $collection[$name][] = $callback;
}

/**
 * @throws Exception
 */
function emit(string $name, array $args = [])
{
    $events = listen();

    if (!\array_key_exists($name, $events)) {
        throw new Exception(\sprintf('"%s" named event does not exists', $name));
    }

    foreach ($events[$name] as $event) {
        if (\is_callable($event)) {
            \call_user_func_array($event, $args);
        }
    }
}
