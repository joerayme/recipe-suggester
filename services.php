<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

$container = new Pimple();

$container['logger'] = function ($c) {
    $logger = new Monolog\Logger('main_logger');

    $handler = new Monolog\Handler\StreamHandler('php://stdout');
    $handler->setFormatter(new Monolog\Formatter\LineFormatter("%message%\n"));
    $logger->pushHandler($handler);

    return $logger;
};

$container['recipe.parser'] = function ($c) {
    return new \RecipeSuggester\Parser\Recipe\Json();
};

$container['ingredient.parser'] = function ($c) {
    return new RecipeSuggester\Parser\Ingredient\Csv();
};

return $container;
