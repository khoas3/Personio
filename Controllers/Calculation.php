<?php

namespace Personio\Controllers;

use Personio\Libraries\BaseController;
use Personio\Libraries\Vacation;

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
                $start_vacation = (!empty($_POST['start_vacation'][0])) ? $_POST['start_vacation'] : [];
                $end_vacation = (!empty($_POST['end_vacation'][0])) ? $_POST['end_vacation'] : [];
                $vacation = new Vacation($hire_date, $calc_date);
                $vacation->calculate();
                $vacation->subtractVacation($start_vacation, $end_vacation);
                $result = $vacation->getVacation();
                echo json_encode($result);
            }
            exit(die);
        }

        $this->view->output('test');
    }
}