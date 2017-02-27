<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/14
 * Time: 20:31
 */
class ControllerWechatVisit extends Controller
{
    private $error = array();
    public function index() {

        $get_return=array();
        if (isset($this->request->get["code"])) {
            $get_return = $this->load->controller('wechat/userinfo/getUsertoken');

        } else {
            if(isset($this->session->data['openid'])){
                $get_return["openid"] = $this->session->data['openid'];
            }
            else{
                $this->error['warning'] = "微信信息没有获取到！";
            }
        }

        if (isset($get_return["openid"])) {
            $data["openid"] = $get_return["openid"];
        } else {
            $data["openid"] = "";
            $this->error['warning'] = "微信信息没有！";

        }

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->document->setTitle("回访调查");

        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('wechat/visit', $data));
    }

    public function add(){

    }
}