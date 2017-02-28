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
        if (isset($_GET['code'])) {
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

        $data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

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

         $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/personalinfo', $data));
    }
}