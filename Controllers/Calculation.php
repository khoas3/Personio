<?php

//namespace Personio\Controllers;

class CalculationController extends BaseController {
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
    }

    public function index()
    {
        // If method is POST
        if (!empty($_POST))
        {
            if($_POST['hire_date'] && $_POST['calculation_date']){
                $s = new \DateTime($_POST['hire_date']);
                $e = new \DateTime($_POST['calculation_date']);
                $c = new Vacation($s, $e);
                $ret = $c->calculate();
                echo json_encode($ret);
            }
            exit(die);
        }

        $this->view->output('test');
    }
}