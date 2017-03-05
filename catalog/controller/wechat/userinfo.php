<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 22:08
 */
class ControllerWechatUserinfo extends Controller
{
    private $error = array();

    public function index()
    {
        $get_return = array();
        $code = $this->request->json('code', '');

        if ( $code != "" ) {
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
            $this->error['warning'] = "微信信息没有获取到！";

        }

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        /*$this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        if (!isset($data['customer_id'])) {
            $this->response->redirect($this->url->link('wechat/register', '', true));
        }*/

        if(!isset($data["openid"])){
            $data["openid"]="";
        }

        if(!isset($data["nickname"])){
            $data["nickname"]="";
        }

        if(!isset($data["department"])){
            $data["department"]="";
        }

        if(!isset($data["telephone"])){
            $data["telephone"]="";
        }

        if(!isset($data["email"])){
            $data["email"]="";
        }

        if(!isset($data["productiondate"])){
            $data["productiondate"]="";
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        //$data['footer'] = $this->load->controller('common/footer');
        //$data['header'] = $this->load->controller('common/header');
        //$data['edit'] = $this->url->link('account/edit', true);
        $this->response->setOutput($this->load->view('wechat/userinfo', $data));


    }

    /*public function add(){
        $this->load->model('wechat/userinfo');
        $data["wechat_id"]=$this->request->post["wechat_id"];
        $data["subscribe"]=$this->request->post["subscribe"];
        $data["openid"]=$this->request->post["openid"];
        $data["nickname"]=$this->request->post["nickname"];
        $data["sex"]=$this->request->post["sex"];
        $data["city"]=$this->request->post["city"];
        $data["country"]=$this->request->post["country"];
        $data["province"]=$this->request->post["province"];
        $data["wlanguage"]=$this->request->post["wlanguage"];
        $data["headimgurl"]=$this->request->post["headimgurl"];
        $data["unionid"]=$this->request->post["unionid"];
        $data["remark"]=$this->request->post["remark"];
        $data["groupid"]=$this->request->post["groupid"];
        $this->model_wechat_userinfo->addWechatUser($data);
        $json['success']=$this->request->post["wechat_id"];

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }*/

    public function getUsertoken()
    {
        $this->document->setTitle("个人信息");
        $log = new Log("wechat.log");

        $code = $this->request->json('code', 0);

        $log = new Log("wechat.log");
        $log->write("getUsertoken code=" . $code);

        //$this->session->data['shipping_method']['cost'];
        $get_url = sprintf(WECHAT_USERTOKEN, AppID, AppSecret, $code);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        $log->write("openidopenid=".$get_return["openid"]);

        if (isset($get_return["openid"])) {
            $log->write("getUsertoken openid = " . $get_return["openid"]);
            $this->session->data['openid'] = $get_return["openid"];
        } else {
            if(isset($this->session->data['openid'])){
                $get_return["openid"] = $this->session->data['openid'];
                $log->write("getUsertoken isset openid openid = " . $get_return["openid"]);
            }
            else{
                $this->error['warning'] = "微信信息没有获取到！";
                $log->write("getUsertoken no wechat openid");
            }
        }
        return $get_return;
    }

}
