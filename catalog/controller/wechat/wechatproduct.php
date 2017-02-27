<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:37
 */
class ControllerWechatWechatproduct extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("商品详情");

        $data['footer'] = $this->load->controller('common/wechatfooter');
        $data['header'] = $this->load->controller('common/wechatheader');

        $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

       // $this->response->setOutput($this->load->view('wechat/wechatproduct', $data));

    }

}