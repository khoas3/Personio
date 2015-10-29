<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require dirname(__FILE__).'/Libraries/Loader.php';
require dirname(__FILE__).'/Libraries/BaseController.php';
require dirname(__FILE__).'/Libraries/View.php';
require dirname(__FILE__).'/Libraries/Vacation.php';
//use Personio\Libraries\Loader;

$loader = new Loader();
$controller = $loader->createController();
$controller->executeAction();



