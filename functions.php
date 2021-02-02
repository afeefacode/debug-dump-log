<?php

use Afeefa\Component\Debug\Debug;

// put in a useless default argument in order to allow
// the ide to cursor into the function brackets
function debug_dump($arguments): void
{
    Debug::dump(...func_get_args());
}

// put in a useless default argument in order to allow
// the ide to cursor into the function brackets
function debug_log($arguments): void
{
    Debug::log(...func_get_args());
}

function debug_log_info(): void
{
    Debug::log_info();
}
