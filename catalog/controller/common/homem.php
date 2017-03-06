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
        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code","");
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code,true);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
        }/*else{
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }*/
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

        for ($i = 0; $i < count($data['banners']); $i++) {
            $data['banners'][$i]['image'] = "image/" . $data['banners'][$i]['image'];
        }




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
