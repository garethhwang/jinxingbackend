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


    public function jsapisign() {
        $url = $this->request->json("url", "");
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        //$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        //$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
          "appId"     => AppID,
          "nonceStr"  => $nonceStr,
          "timestamp" => $timestamp,
          "url"       => $url,
          "signature" => $signature,
          "rawString" => $string
        );
        $this->response->setOutput(json_encode($signPackage));
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        $this->load->model('wechat/accesstoken');
        $wechatjsapiinfo=$this->model_wechat_accesstoken->getJSAPIAccesstoken();
        date_default_timezone_set('PRC');
        $currenttime=date('Y-m-d H:i:s');
        $ticket="";
        if(isset($wechatjsapiinfo['deadline']) && strtotime($currenttime)<strtotime($wechatjsapiinfo['deadline'])){
            $ticket = $wechatjsapiinfo['ticket'];
        } else {
            $accesstoken="";
            $tokenjson=$this->getLatestAccesstoken();
            $accesstoken=$tokenjson['access_token'];

            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accesstoken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $deadline = time() + 7000;
                $this->model_wechat_accesstoken->editJSAPIAccesstoken($ticket, $deadline);
            }
        }

        return $ticket;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
 


}
