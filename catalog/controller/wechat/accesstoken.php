<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/9
 * Time: 21:42
 */
class ControllerWechatAccesstoken extends Controller
{
    private $error = array();

    public function index() {
        $this->load->model('wechat/accesstoken');
        $wechatinfo=$this->model_wechat_accesstoken->getAccesstoken();
        date_default_timezone_set('PRC');
        $currenttime=date('Y-m-d H:i:s');
        $accesstoken="";
        if(strtotime($currenttime)<strtotime($wechatinfo['deadline'])){
            $accesstoken=$wechatinfo['accesstoken'];
        }
        else{
            $tokenjson=$this->getLatestAccesstoken();
            $accesstoken=$tokenjson['access_token'];
        }
        if(!isset($this->error['warning'])){
            $this->response->setOutput($accesstoken);
        }
        else{
            $this->response->setOutput($this->error['warning']);
        }
    }

    public function wechaterror(){
        if(isset($this->request->get['errcode'])){
            $errcode=$this->request->get['errcode'];
            if($errcode=="40014"){
                $tokenjson=$this->getLatestAccesstoken();
                $accesstoken=$tokenjson['access_token'];
            }
        }

    }

    private function getLatestAccesstoken(){
        $get_url=sprintf(WECHAT_ACCESSTOKEN,AppID,AppSecret);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        if(!isset($get_return['access_token']) ){
            $this->error['warning']=$get_return['errmsg'];
            return $get_return;
        }
        $deadline=date('Y-m-d H:i:s',strtotime(" +".($get_return['expires_in']-180)." second"));
        $this->model_wechat_accesstoken->editAccesstoken($get_return['access_token'],$deadline);
        return $get_return;
    }


}