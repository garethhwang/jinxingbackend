<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 17:46
 */
class ControllerWechatVaccine extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("疫苗接种表");
        $data["jxsession"] = $this->load->controller('account/authentication');
        if(empty($data["jxsession"])) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($data["jxsession"]),true);

       // $data['footer'] = $this->load->controller('common/wechatfooter');
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
	
        //$this->response->setOutput($this->load->view('wechat/vaccine', $data));
    }

    public function free()
    {
        $this->document->setTitle("疫苗接种表");
        $data["jxsession"] = $this->load->controller('account/authentication');
        if(empty($data["jxsession"])) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($data["jxsession"]),true);

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

       // $this->response->setOutput($this->load->view('wechat/vaccinefree', $data));
    }

}
