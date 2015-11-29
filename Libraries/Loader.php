<?php

namespace Personio\Libraries;


class Loader {
    private $controllerName;
    private $controllerClass;
    private $action;
    private $urlValues;

    // Store the URL request values on object creation
    public function __construct() {
        $this->urlValues = $_GET;

        if ($this->urlValues['controller'] == "") {
            $this->controllerName = "Default";
            $this->controllerClass = "DefaultController";
        } else {
            $this->controllerName = ucfirst(strtolower($this->urlValues['controller']));
            $this->controllerClass = ucfirst(strtolower($this->urlValues['controller'])) . "Controller";
        }

        if ($this->urlValues['action'] == "") {
            $this->action = "index";
        } else {
            $this->action = $this->urlValues['action'];
        }
    }

    // Factory method which establishes the requested controller as an object
    public function createController() {
        //check our requested controller's class file exists and require it if so
        if (file_exists("Controllers/" . $this->controllerName . ".php")) {
//            use 'Personio\Controllers\\'.$this->controllerName.'Controller';
//            require("Controllers/" . $this->controllerName . ".php");
        }

        // Does the class exist?
        if (class_exists($this->controllerClass)) {
            $parents = class_parents($this->controllerClass);

            // Does the class inherit from the BaseController class?
            if (in_array("BaseController",$parents)) {
                // Does the requested class contain the requested action as a method?
                if (method_exists($this->controllerClass,$this->action))
                {
                    return new $this->controllerClass($this->action,$this->urlValues);
                }
            }
        }
        return false;
    }
}