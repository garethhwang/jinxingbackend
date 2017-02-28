<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 17:46
 */
class ControllerWechatRegisterterms extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("用户服务协议");

        //$data['header'] = $this->load->controller('common/wechatheader');

         $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		//$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/registerterms', $data));
    }


}