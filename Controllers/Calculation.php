<?php

//namespace Personio\Controllers;

//use Personio\Libraries\BaseController;

class CalculationController extends BaseController {
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
    }

    public function index()
    {
        $this->view->output('test');
    }
}