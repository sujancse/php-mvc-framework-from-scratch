<?php

use Core\Application;
use Core\Database\Connection;
use Core\Database\QueryBuilder;

$app = new Application();

$app->bind('config', require 'config/config.php');

try {
    $app->bind('database', new QueryBuilder(
        Connection::make($app->get('config')['database'])
    ));
} catch (Error | Exception $exception) {
    echo $exception->getMessage();
}

return $app;
