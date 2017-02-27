<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:37
 */
class ControllerWechatWechatwelcome extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("金杏健康");

        $data['footer'] = $this->load->controller('common/wechatfooter');
        $data['header'] = $this->load->controller('common/wechatheader');
        $data["appid"]=AppID;

        $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));




        //$this->response->setOutput($this->load->view('wechat/wechatwelcome', $data));

    }

}