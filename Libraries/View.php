<?php

//namespace Personio\Libraries;


class View {
    protected $viewFile;

    //establish view location on object creation
    public function __construct($controllerClass, $action) {
        $controllerName = str_replace("Controller", "", $controllerClass);
        $this->viewFile = "Views/" . $controllerName . "/" . $action . ".php";
    }

    // Output the view
    public function output($viewModel) {
        if (file_exists($this->viewFile)) {
            //we're not using a template view so just output the method's view directly
            require($this->viewFile);
        }

    }
}