<?php

class ControllerWechatAdvisesuccess extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("投诉建议");

        //$data['header'] = $this->load->controller('common/wechatheader');

	$response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		//$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/advisesuccess', $data));
    }
}
