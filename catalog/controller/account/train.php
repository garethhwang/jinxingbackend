<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/4/20
 * Time: 18:43
 */
class ControllerAccountT extends Controller {
    public function index() {
        $telephone = $this->request->json('telephone');

        if(isset($telephone)){

            $code = rand(100000 ,999999);

            $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "157827");

            $this->cache->set($telephone, $code);

            if ($sms == 1) {
                $response = array(
                    'code'  => 0,
                    'message'  => "通知发送成功",
                    'data' =>array(),
                );
            } else if ($sms == 2){
                $response = array(
                    'code'  => 1020,
                    'message'  => "通知发送超过上限，亲，明天再试喔",
                    'data' =>array(),
                );
            }else {
                $response = array(
                    'code'  => 1021,
                    'message'  => "通知发送失败，请稍后",
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