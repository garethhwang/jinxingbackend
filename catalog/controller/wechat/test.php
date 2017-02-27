<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/13
 * Time: 22:28
 */
class ControllerWechatTest extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("金杏健康");

        $data['footer'] = $this->load->controller('common/wechatfooter');
        $data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";
        $this->response->setOutput($this->load->view('wechat/test', $data));
    }

}