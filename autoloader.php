<?php
spl_autoload_register(function ($class_name) {
    $root = dirname(__DIR__);
    $file = $root . '/visitors/includes/' . str_replace('\\', '/', $class_name) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});
