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

        $log = new Log("wechat.log");
        $code = $this->request->get["code"];
        $code = $this->request->get["code"];
        $log->write("code=".$code);
        $codes = $_GET["code"];
        $log->write("code=".$codes);


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
        }
        $data['service_tel'] = WECHAT_SERVICE_TEL;


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

        /*$this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);


        $data['advisetext'] = $this->request->json('advisetext', '');

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
