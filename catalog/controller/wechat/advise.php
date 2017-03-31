<?php

class ControllerWechatAdvise extends Controller
{
    private $error = array();

    public function index()
    {
       // $log = new Log('wechat.log');


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

        //$data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);


        $data['advisetext'] = $this->request->json('advisetext', '');

        $this->model_wechat_userinfo->addAdvise($data, $data["customer_id"]);
        $data['service_tel'] = WECHAT_SERVICE_TEL;


        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $this->model_wechat_userinfo->addAdvise($this->request->post,$data["customer_id"]);

        }*/
        //$data['action'] = $this->url->link('wechat/advisesuccess', '', true);
        $this->document->setTitle("投诉建议");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";

        $result = array(
            'advisetext' => $data['advisetext'],
            'customer_id' => $data['customer_id'],
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

        //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        $log = new Log('wechat.log');

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


        $data['service_tel'] = WECHAT_SERVICE_TEL;


        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);
        $asd = $this->load->controller('account/authentication/Wechat');
        $log ->write("asd=".$asd) ;
        //$this->model_wechat_userinfo->insertinto();


        /*$data['advisetext'] = $this->request->json('advisetext', '');

        $this->model_wechat_userinfo->addAdvise($data, $data["customer_id"]);
        $data['service_tel'] = WECHAT_SERVICE_TEL;*/


        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $this->model_wechat_userinfo->addAdvise($this->request->post,$data["customer_id"]);

        }*/
        //$data['action'] = $this->url->link('wechat/advisesuccess', '', true);
        $this->document->setTitle("投诉建议");
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";

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
