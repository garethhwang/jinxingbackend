<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/19
 * Time: 13:42
 */
class ControllerWechatRegistersuccess extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("金杏健康");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "home";
        $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		//$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/registersuccess', $data));
    }
}