<?php

error_reporting(-1);
ini_set('display_errors', 'On');

//require dirname(__FILE__).'/Libraries/VacationCalculation.php';
//use Personio\Libraries\VacationCalculation;
//
//$s = new \DateTime('2015-10-29');
//$e = new \DateTime('2015-12-29');
//$c = new VacationCalculation($s, $e);
//$c->calculate();
require dirname(__FILE__).'/Libraries/Loader.php';
require dirname(__FILE__).'/Libraries/BaseController.php';
require dirname(__FILE__).'/Libraries/View.php';
require dirname(__FILE__).'/Libraries/VacationCalculation.php';
//use Personio\Libraries\Loader;

$loader = new Loader(); //create the loader object
$controller = $loader->createController(); //creates the requested controller object based on the 'controller' URL value
$controller->executeAction();



