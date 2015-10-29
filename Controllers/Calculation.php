<?php

//namespace Personio\Controllers;

class CalculationController extends BaseController {
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
    }

    public function index()
    {
        if (!empty($_POST))
        {
            $s = new \DateTime('2015-10-29');
            $e = new \DateTime('2015-12-29');
            $c = new Vacation($s, $e);
            $c->calculate();
        }
        $this->view->output('test');
    }
}