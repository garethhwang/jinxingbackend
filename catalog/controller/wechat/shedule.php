<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 16:11
 */
class ControllerWechatShedule extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("产检计划");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";


        $num = $this->request->json('num', 1);

        $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
        );
        //$response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));


        //$this->response->setOutput($this->load->view('shedule/shedule'.$num, $data));
    }

}