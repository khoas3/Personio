<?php

//namespace Personio\Controllers;

class CalculationController extends BaseController {
    /**
     * @param $action
     * @param $urlValues
     */
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
    }

    /**
     * Calculate employee's vacation.
     */
    public function index()
    {
        // If method is POST
        if (!empty($_POST))
        {
            if($_POST['hire_date'] && $_POST['calculation_date']){
                $hire_date = trim($_POST['hire_date']);
                $calc_date = trim($_POST['calculation_date']);
                $vacation = new Vacation($hire_date, $calc_date);
                $vacation->calculate();
                $result = $vacation->getVacation();
                echo json_encode($result);
            }
            exit(die);
        }

        $this->view->output('test');
    }
}