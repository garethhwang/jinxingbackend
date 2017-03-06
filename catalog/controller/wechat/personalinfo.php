<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 12:55
 */
class ControllerWechatPersonalinfo extends Controller
{
    private $error = array();

    public function index()
    {

        $data["error_warning"] = "";
        $log = new Log('wechat.log');
        $get_return = array();
        //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

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


        /*if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
            //$data["wechat_id"]= $this->cache->get($this->session->data['openid']);
        }
        else{
            $data["openid"] = "";
            $this->error['warning'] = "微信信息没有获取到！";
        }*/
        /*if(!isset($this->session->data['openid'])){
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }*/

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        //$log->write("open id is ".$data["openid"]." ,customer id is ".$data['customer_id']);
        if (!isset($data['customer_id'])) {
            $data['isnotregist'] = "1" ;
            $data['customer_id'] = " ";
        }
        else{
            $data['isnotregist'] = "0" ;
        }

        if(!isset($data['ispregnant'])){
            $data['ispregnant'] = "";
        }
        if($data['ispregnant'] == "0" ){
            $data["pregnant"] = "0";
        }else{
            $data["pregnant"] = "1";
        }



        $this->document->setTitle("个人信息");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
       // $data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"]="personal_center";

        if($data['isnotregist'] == "1"){
            $response = array(
                'code'  => 1011,
                'message'  => "如果您是孕妇用户，请注册后使用本功能，如果您是非孕妇用户，请直接访问健康服务",
                'data' => array(
                ),
            );

        }elseif ( $data["pregnant"] == "0"){
            $response = array(
                'code'  => 1012,
                'message'  => "此功能仅面向孕/产妇开放，如果您是孕/产妇用户，请完善资料后进入；如果您是非孕/产妇用户，请您移步其他功能区",
                'data' =>array(
                ),
            );

        }else{
            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );


           // $response["data"] = $data;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/personalinfo', $data));
    }
}
