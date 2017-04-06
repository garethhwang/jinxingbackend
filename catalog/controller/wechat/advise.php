<?php

class ControllerWechatAdvise extends Controller
{
    private $error = array();

    public function index()
    {
        $log = new Log('wechat.log');


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
        /*if(isset($this->session->data['openid'])){
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

        $data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);*/


        $data['advisetext'] = $this->request->json('advisetext', '');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        $this->model_wechat_userinfo->addAdvise($data, $customer_info["customer_id"]);


        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $this->model_wechat_userinfo->addAdvise($this->request->post,$data["customer_id"]);

        }*/
        //$data['action'] = $this->url->link('wechat/advisesuccess', '', true);
        $this->document->setTitle("投诉建议");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";

        $result = array(
            'jxsession' => $data["jxsession"],
            'advisetext' => $data['advisetext'],
            'customer_id' => $customer_info['customer_id'],
            'service_tel' => $data['service_tel'],
        );

        $response = array(
            'code' => 0,
            'message' => "",
            'data' => array(),
        );
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/advise', $data));
    }

    public function show(){


        $log = new Log('wechat.log');


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

        /*$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';


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
            $codeinfo = $this->cache->get($code);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
        }else{
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

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);*/

        //$this->model_wechat_userinfo->insertinto();


        /*$data['advisetext'] = $this->request->json('advisetext', '');

        $this->model_wechat_userinfo->addAdvise($data, $data["customer_id"]);
        $data['service_tel'] = WECHAT_SERVICE_TEL;*/


        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $this->model_wechat_userinfo->addAdvise($this->request->post,$data["customer_id"]);

        }*/
        //$data['action'] = $this->url->link('wechat/advisesuccess', '', true);
        //$this->document->setTitle("投诉建议");
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        $response = array(
            'code' => 0,
            'message' => "",
            'data' => array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));


    }

}
