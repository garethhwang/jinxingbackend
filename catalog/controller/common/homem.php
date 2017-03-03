<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/16
 * Time: 20:02
 */
class ControllerCommonHomem extends Controller
{
    private $error = array();

    public function index()
    {
        $log = new Log("wechat.log");
        $data["error_warning"] = "";
        $get_return = array();
        $code = $this->request->json('code', 0);
        if (isset($code)) {
            $get_return = $this->load->controller('wechat/userinfo/getUsertoken');

        } else {
            if (isset($this->session->data['openid'])) {
                $get_return["openid"] = $this->session->data['openid'];
            } else {
                $this->error['warning'] = "微信信息没有获取到！";
            }
        }

        if (isset($get_return["openid"])) {
            $data["openid"] = $get_return["openid"];
        } else {
            $data["openid"] = "";
            $data["error_warning"] = "微信信息没有获取到！";
            $log->write($data["error_warning"]);
        }

        $data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

        if (isset($this->request->get['route'])) {
            $this->document->addLink($this->config->get('config_url'), 'canonical');
        }

        $this->document->setTitle("金杏健康");
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "home";
        //$data['footer'] = $this->load->controller('common/wechatfooter');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }


        $this->load->model('design/banner');
        $data['banners'] = $this->model_design_banner->getBanner(7);


		$response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

		return;


        //$this->response->setOutput($this->load->view('common/homem', $data));
    }
}
