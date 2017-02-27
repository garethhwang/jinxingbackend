<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/3
 * Time: 20:04
 */
class ControllerCommonWechatheader extends Controller
{
    public function index()
    {
        $data["title"] = $this->document->getTitle();
        return $this->load->view('common/wechatheader', $data);
    }
}