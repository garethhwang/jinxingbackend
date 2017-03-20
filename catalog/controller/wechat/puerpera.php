<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/12
 * Time: 15:47
 */
class ControllerWechatPuerpera extends Controller
{
    //private $error = array();


    public function validcode()
    {
        $telephone = $this->request->json('telephone');

        if (isset($telephone)) {

            $code = rand(100000, 999999);

            $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "157827");

            //$log->write("smscode=".$code);

            $this->cache->set($telephone, $code);

            if ($sms == 1) {
                $response = array(
                    'code' => 0,
                    'message' => "验证码发送成功",
                    'data' => array(),
                );
            } else if ($sms == 2) {
                $response = array(
                    'code' => 1020,
                    'message' => "验证码发送超过上限，亲，明天再试喔",
                    'data' => array(),
                );
            } else {
                $response = array(
                    'code' => 1021,
                    'message' => "验证码发送失败，请稍后",
                    'data' => array(),
                );
            }

        } else {
            $response = array(
                'code' => 1023,
                'message' => "无效手机号",
                'data' => array(),
            );
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }

    public function index()
    {
        $log = new Log("wechat.log");


        if (isset($this->session->data['openid'])) {
            $data["openid"] = $this->session->data['openid'];
        } else {
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code", "");
        if ($code) {
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code);
            $codeinfo = json_decode($codeinfo, true);
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



        //$data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

        //SMS
        /*if(isset($telephone) && !isset($smscode )) {
           // $telephone = $_POST['telephone'];

            $code = rand(100000 ,999999);

            $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "151750");

            $log->write("smscode=".$code);

            $this->cache->set($telephone, $code);

                if ($sms == 1) {
                    $msgid = 1;
                    $html = '验证码发送成功';
                } else if ($sms == 2){
                    $msgid = 2;
                    $html = '验证码发送超过上限，亲，明天再试喔';
                }else {
                    $msgid = 0;
                    $html = '验证码发送失败，请稍后';
                }

             echo $output = json_encode(array('msgid' => $msgid, 'html' => $html));
            return  $output ;
        }*/


        //$data["openid"] = "oKe2EwWLwAU7EQu7rNof5dfG1U8g";


        $data['telephone'] = $this->request->json('telephone', '');
        $data['smscode'] = $this->request->json('smscode', 0);
        $data['realname'] = $this->request->json('realname', '');
        $data['babybirth'] = $this->request->json('babybirth', '');
        $data['district'] = $this->request->json('district', '');
        $data['address_1'] = $this->request->json('address_1', '');


        $postdata = array(
            'telephone' => $data['telephone'],
            'realname' => $data['realname'],
            'smscode' => $data['smscode'],
            'babybirth' => $data['babybirth'],
            'district' => $data['district'],
            'address_1' => $data['address_1'],
        );

        //$log->write("telephone=".$postdata["telephone"]."address_1=".$postdata["address_1"]."realname=".$postdata["realname"]);

        $this->load->language('wechat/register');
        $this->document->setTitle("金杏健康");
        $this->load->model('account/customer');

        $this->load->model('wechat/userinfo');
        $temp = $this->model_wechat_userinfo->getUserInfo($data["openid"]);

        if(!$temp){
            $response = array(
                'code'  => 1031,
                'message'  => "请您在微信客户端进行注册",
                'data' =>array(),
            );
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        } else {
            $postdata["wechat_id"] = $temp["wechat_id"];
        }

        if ($this->cache->get($postdata["telephone"]) != $postdata["smscode"]) {
            $data['isnotright'] = '1';
        } else {
            $data['isnotright'] = '0';
            $this->model_account_customer->addPuerpera($postdata);
            $this->customer->wechatlogin($data["openid"]);
            unset($this->session->data['guest']);
            //$log->write("telephone=".$this->request->post["telephone"]."smscode=".$this->cache->get($this->request->post["telephone"])."isnotright=".$data['isnotright']);
            //$this->response->redirect($this->url->link('wechat/registersuccess', '', true));
        }

        //$log->write("telephone=".$this->request->post["telephone"]."smscode=".$this->cache->get($this->request->post["telephone"])."isnotright=".$data['isnotright']);
        /*$this->model_account_customer->addNonpregnant($this->request->post);
        $this->customer->nonpregnantlogin($data["openid"]);
        unset($this->session->data['guest']);
        $this->response->redirect($this->url->link('wechat/registersuccess', '', true));*/

        //$data['entry_realname'] = $this->language->get('entry_realname');
        //$data['entry_telephone'] = $this->language->get('entry_telephone');
        //$data['entry_address_1'] = $this->language->get('entry_address');


        //$data['button_continue'] = $this->language->get('button_continue');
        //$data['button_upload'] = $this->language->get('button_upload');

        /*if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['realname'])) {
            $data['error_realname'] = $this->error['realname'];
        } else {
            $data['error_realname'] = '';
        }

        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }


        if (isset($this->error['address_1'])) {
            $data['error_address_1'] = $this->error['address_1'];
        } else {
            $data['error_address_1'] = '';
        }

        if (isset($this->request->post['realname'])) {
             $data['realname'] = $this->request->post['realname'];
         } else {
             $data['realname'] = '';
         }


         if (isset($this->request->post['telephone'])) {
             $data['telephone'] = $this->request->post['telephone'];
         } else {
             $data['telephone'] = '';
         }


         if (isset($this->request->post['address_1'])) {
             $data['address_1'] = $this->request->post['address_1'];
         } else {
             $data['address_1'] = '';
         }*/


        //$data['action'] = $this->url->link('wechat/wechatbinding', '', true);
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');


        //$data["provs_data"] = json_encode($this->getProvince());
        //$data["citys_data"] = json_encode($this->getCity());
        //$data["dists_data"] = json_encode($this->getDistrict());

        if ($data['isnotright'] == '1') {
            $response = array(
                'code' => 1030,
                'message' => "验证码不正确",
                'data' => array(),
            );
        } else {
            $response = array(
                'code' => 0,
                'message' => "",
                'data' => array(),
            );
            $response["data"] = $data;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        // $this->response->setOutput($this->load->view('wechat/wechatbinding', $data));

    }

    function sendTemplateSMS($to,$datas,$tempId)
    {

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

}