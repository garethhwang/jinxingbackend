<?php
class ControllerAccountJxlogin extends Controller
{

    public function validcode() {

        $telephone = $this->request->json('telephone');

        if(isset($telephone)){

            $code = rand(100000 ,999999);

            $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "157827");

            $this->cache->set($telephone, $code);

            if ($sms == 1) {
                $response = array(
                    'code'  => 0,
                    'message'  => "验证码发送成功",
                    'data' =>array(),
                );
            } else if ($sms == 2){
                $response = array(
                    'code'  => 1020,
                    'message'  => "验证码发送超过上限，亲，明天再试喔",
                    'data' =>array(),
                );
            }else {
                $response = array(
                    'code'  => 1021,
                    'message'  => "验证码发送失败，请稍后",
                    'data' =>array(),
                );
            }

        }else{
            $response = array(
                'code'  => 1023,
                'message'  => "无效手机号",
                'data' =>array(),
            );
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function index() {
        $log = new Log("wechat.log");

        $data["jxsession"] = $this->load->controller('account/authentication');
        $code = $this->request->json("code");

        /*if(empty($data["jxsession"])) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }*/
        //$customer_info = json_decode($this->cache->get($data["jxsession"]),true);

        $date = date("Y-m-d h:i:sa");
        $data['telephone'] = $this->request->json('telephone', '');
        $data['smscode'] = $this->request->json('smscode');

        $postdata  = array(
            'telephone' => $data['telephone'],
            'smscode'  => $data['smscode'],
        );



        if ( $this->cache->get($postdata["telephone"]) != $postdata["smscode"]) {
            $data['isnotright'] = '1';
        } else {
            $data['isnotright'] = '0';
            $this->load->model('account/customer');
            $customer_info = $this->model_account_customer->getCustomerByTelephone($data['telephone']);
            if(!empty($customer_info["customer_id"])) {
                $data["jxsession"] = md5($customer_info["customer_id"].$customer_info["telephone"].$date);
                if(!empty($customer_info["wechat_id"])){
                    $this->load->model('wechat/userinfo');
                    $wechat_info = $this->model_wechat_userinfo->getUserInfoByWechatId($customer_info["wechat_id"]);
                    $info = array_merge($customer_info,$wechat_info);
                    $this->cache->set($data["jxsession"], json_encode($info));
                    $log->write("aaaaaaaa");
                }else {
                    if(!empty($code)) {
                        $code_info = $this->getWechat($code);
                        $this->model_account_customer->updateWechatCustomer($code_info["wechat_id"],$data['telephone']);
                        $data["jxsession"] = $this->authWechat($code_info["openid"]);
                        $log->write("bbbbbbbbbbb");
                    }else {
                        $this->cache->set($data["jxsession"], json_encode($customer_info));
                        $log->write("cccccccc");
                    }
                }
            }else {
                if(!empty($code)) {
                    $code_info = $this->getWechat($code);
                    $postdata["wechat_id"] = $code_info["wechat_id"] ;
                }else {
                    $postdata["wechat_id"] = "" ;
                }
                $this->load->model('account/customer');
                $customer_id = $this->model_account_customer->addNotWechatCustomer($postdata);
                $info = $this->model_account_customer->getCustomer($customer_id);
                $data["jxsession"] = md5($customer_id.$info["telephone"].$date);
                $this->cache->set($data["jxsession"], $info);
                $log->write("ddddddddd");
            }
            if(empty($customer_info["realname"])) {
                $data["edit"] = 1;
            }else {
                $data["edit"] = 0;
            }

            /*$this->load->model('wechat/userinfo');
            $customer_info = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);
            $this->load->model('account/address');
            $customer_address = $this->model_account_address->getAddress($customer_info["address_id"],$customer_info["customer_id"]);
            $data = array_merge($customer_info,$customer_address);
            $this->cache->set($jxsession, json_encode($data));*/

            $this->customer->weblogin($data['telephone']);

        }


        if($data['isnotright'] == '1'){
            $response = array(
                'code'  => 1030,
                'message'  => "验证码不正确",
                'data' =>array(),
            );
        }else{
            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
        //$this->response->setOutput($this->load->view('account/wechatregister', $data));

    }




    function sendTemplateSMS($to,$datas,$tempId) {

        //global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
        $rest = new REST(serverIP,serverPort,softVersion);
        $rest->setAccount(accountSid,accountToken);
        $rest->setAppId(appId);

        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            //echo "result error!";
            return 0;
        }
        if($result->statusCode == "0") {
            $result->TemplateSMS;
            //echo "Sendind TemplateSMS success!";
            //获取返回信息
            // $smsmessage = $result->TemplateSMS;
            //echo "dateCreated:".$smsmessage->dateCreated."<br/>";
            //echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
            return 1;
        }else if($result->statusCode == "160040"){
            return 2;
        }else{
            //echo "error code :" . $result->statusCode ."<br/>";
            //echo "error msg :" . $result->statusMsg."<br/>";
            return 0;
        }
    }


    function getWechat($code) {

        if ($this->cache->get($code)) {
            $codeinfo = $this->cache->get($code);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];

        }else {

            $get_url = sprintf(WECHAT_USERTOKEN, AppID, AppSecret, $code);
            $get_return = file_get_contents($get_url);
            $get_return = (array)json_decode($get_return);
            $data["openid"] = $get_return["openid"];
            $this->load->model('wechat/userinfo');
            if (isset($get_return["openid"])) {

                $wechatid = $this->model_wechat_userinfo->isUserValid($get_return["openid"]);
                if (isset($wechatid)) {
                    $data["wechat_id"] = $wechatid;

                } else {
                    $wechatinfo = $this->getUser($get_return["access_token"], $get_return["openid"]);
                    $data["wechat_id"] = $this->model_wechat_userinfo->addWechatUser($wechatinfo);
                }
                $this->cache->set($code, json_encode(array('openid' => $get_return["openid"], 'wechat_id' => $data["wechat_id"])));

            } else {
                $data["wechat_id"] = "";
            }

        }

        $codeinfo = json_decode($this->cache->get($code),true);
        return  $codeinfo;
    }

    private function getUser($accesstoken, $openid)
    {
        $get_url = sprintf(WECHAT_GETUSERINFO, $accesstoken, $openid);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        return $get_return;
    }

    public function authWechat($openid) {

        $date = date("Y-m-d h:i:sa");
        $this->load->model('wechat/userinfo');
        $customer_info = $this->model_wechat_userinfo->getCustomerByWechat($openid);
        $jxsession = md5($customer_info["customer_id"].$customer_info["telephone"].$date);
        $this->load->model('account/address');
        $customer_address = $this->model_account_address->getAddress($customer_info["address_id"],$customer_info["customer_id"]);
        $data = array_merge($customer_info,$customer_address);
        $this->cache->set($jxsession, json_encode($data));
        return $jxsession;

    }



}