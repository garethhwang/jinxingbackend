<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 19:08
 */
class ControllerWechatVaccinemenu extends Controller
{
    private $error = array();

    public function index()
    {
        $get_return = array();
        $this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
            $this->error['warning'] = "微信信息没有获取到！";
        }


        if(!isset($this->session->data['openid'])){
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        //$this->load->model('wechat/userinfo');
        //$data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);
        //$lastmenstrualdate = date_format($data["lastmenstrualdate"],"Y-m-d");


        $this->document->setTitle("疫苗接种表");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";

	$response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));


        //$this->response->setOutput($this->load->view('wechat/vaccinemenu', $data));
    }
}
