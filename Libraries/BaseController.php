<?php

//namespace Personio\Libraries;


abstract class BaseController {
    protected $urlValues;
    protected $action;
    protected $model;
    protected $view;

    public function __construct($action, $urlValues) {
        $this->action = $action;
        $this->urlValues = $urlValues;

        // Establish the view object
        $this->view = new View(get_class($this), $action);
    }

    //executes the requested method
    public function executeAction() {
        return $this->{$this->action}();
    }
}