<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require dirname(__FILE__).'/vendor/autoload.php';

use Personio\Libraries\Loader;

$loader = new Loader();
$controller = $loader->createController();
$controller->executeAction();



