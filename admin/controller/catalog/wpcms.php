<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/13
 * Time: 22:55
 */
class ControllerCatalogWpcms extends Controller
{
    private $error = array();
    public function index() {
        $this->response->setOutput("test");
    }
}