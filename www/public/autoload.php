<?php

spl_autoload_register('autoload');

function autoload(string $class): void
{
    $root = realpath(__DIR__ . '/../');
    $class = str_replace('App', 'src', $class);
    $filepath = $root . '/' . str_replace('\\', '/', $class) . '.php';

    require_once $filepath;
}
