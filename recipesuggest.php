<?php

/*
 * (c) 2013 Joseph Ray <joe@joeray.me>
 */

require 'vendor/autoload.php';

$container = require 'services.php';

$cli = new \RecipeSuggester\Cli($container);
exit($cli->run($argv));
