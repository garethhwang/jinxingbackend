<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:37
 */
class ControllerWechatHelp extends Controller
{
    private $error = array();

    public function index()
    {

        $get_return=array();


        /*$code = $this->request->json('code');

        if(isset($code)){
            $get_return=$this->load->controller('wechat/userinfo/getUsertoken');

        }
        else{
            $data["error_warning"]="关注微信公众号后打开！";
        }

        $data["openid"]=$get_return["openid"];*/


        $this->session->data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';


        if (isset($this->session->data['openid'])) {
            //$log->write("PersonalCenter openid:".$this->session->data['openid']);
            $data['openid']=$this->session->data['openid'];
            $this->error['warning'] = "";
        } else {
            $data['openid'] = "";
            $this->error['warning'] = "PersonalCenter： 微信信息没有获取到！";
            //$log->write($this->error['warning']);
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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        if (!isset($data['customer_id'])) {
            $this->response->redirect($this->url->link('wechat/register', '', true));
        }

        //$this->load->model('account/customer');
        //$query=$this->model_account_customer->getWechatId();

        //$log->write("wechatid:=".$data["openid"]);

        //$this->load->model('wechat/userinfo');
        //$wechat = $this->model_wechat_userinfo->getUserInfo($data["openid"]);
       // foreach ($query as $key){
            //if ($wechat['wechat_id'] == $key) {
            //    break;
       // }else{
        //        $this->response->redirect($this->url->link('wechat/register', '', true));
        //    }

       // }



        $this->document->setTitle("帮助手册");

        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $this->load->model('wechat/help');
        $data["faq"]=$this->model_wechat_help->getFaq();

        $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/help', $data));

    }

    public function add(){
        $this->response->setOutput("add");
    }
}