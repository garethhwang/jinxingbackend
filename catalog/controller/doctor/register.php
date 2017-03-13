<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/12
 * Time: 23:25
 */
class ControllerDoctorRegister extends Controller
{
    private $error = array();

    public function validcode()
    {
        $telephone = $this->request->json('telephone');

        if(isset($telephone)){

            $code = rand(100000 ,999999);

            $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "157827");

            //$log->write("smscode=".$code);

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

    public function index()
    {
        $log = new Log("wechat.log");


        $data['telephone'] = $this->request->json('telephone', '');
        $data['smscode'] = $this->request->json('smscode', 1);
        /*$data['realname'] = $this->request->json('realname', '');
        $data['barcode'] = $this->request->json('barcode', '');
        $data['birthday'] = $this->request->json('birthday', '');
        $data['department'] = $this->request->json('department', '');
        $data['pregnantstatus'] =  $this->request->json('pregnantstatus', '');
        $data['height'] = $this->request->json('height', 1);
        $data['weight'] = $this->request->json('weight', '');
        $data['lastmenstrualdate'] = $this->request->json('lastmenstrualdate', '');
        $data['gravidity'] = $this->request->json('gravidity', '');
        $data['parity'] = $this->request->json('parity', '');
        $data['vaginaldelivery'] = $this->request->json('vaginaldelivery', '');
        $data['aesarean'] = $this->request->json('aesarean', '');
        $data['spontaneousabortion'] = $this->request->json('spontaneousabortion', '');
        $data['drug_inducedabortion'] = $this->request->json('drug_inducedabortion', '');
        $data['highrisk'] = $this->request->json('highrisk', '');
        $data['highriskfactor'] = $this->request->json('highriskfactor', '');
        $data['householdregister'] = $this->request->json('householdregister', '');
        $data['district'] = $this->request->json('district', '');
        $data['address_1'] = $this->request->json('address_1','');
        $data['agree'] = $this->request->json('agree', '');*/


        $postdata  = array(
            'telephone' => $data['telephone'],
            'smscode'  => $data['smscode'],
            /*'realname'  => $data['realname'] ,
            'barcode'  => $data['barcode'],
            'birthday' => $data['birthday'],
            'department' => $data['department'],
            'height'   => $data['height'],
            'weight'   => $data['weight'],
            'pregnantstatus' => $data['pregnantstatus'],
            'lastmenstrualdate' => $data['lastmenstrualdate'],
            'gravidity' => $data['gravidity'],
            'parity' => $data['parity'],
            'vaginaldelivery' => $data['vaginaldelivery'],
            'aesarean' => $data['aesarean'],
            'spontaneousabortion' => $data['spontaneousabortion'],
            'drug_inducedabortion'=> $data['drug_inducedabortion'],
            'highrisk' => $data['highrisk'],
            'highriskfactor' => $data['highriskfactor'],
            'householdregister' => $data['householdregister'],
            'district' => $data['district'],
            'address_1' => $data['address_1'],
            'agree' => $data['agree'],*/
        );



        if ($this->cache->get($postdata["telephone"]) != $postdata["smscode"]) {
            $data['isnotright'] = '1';
        } else {
            $data['isnotright'] = '0';

            $this->load->model('doctor/doctor');

            $telephone_info = $this->model_doctor_doctor->getTelephone();

            //$log->write("telephone=". $telephone_info);
            for($i=0;$i<count($telephone_info);$i++){
                if($data['telephone'] == $telephone_info["$i"]["telephone"]) {

                    $log->write("telephone=1111111");
                    $doctor_info = $this->model_doctor_doctor->getCustomerByTelephone($data['telephone']);
                    $data["doctor_id"] = $doctor_info["doctor_id"] ;

                }

            }
            if(!isset( $data["doctor_id"])) {

                //$data["doctor_id"] = $this->model_doctor_doctor->addDoctor($postdata);

            }

            //$this->customer->wechatlogin($data["openid"]);
            //unset($this->session->data['guest']);
            //$this->response->redirect($this->url->link('wechat/registersuccess', '', true));
        }

        //$data["provs_data"] = json_encode($this->load->controller('wechat/wechatbinding/getProvince'));
        //$data["citys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getCity'));
        //$data["dists_data"] = json_encode($this->load->controller('wechat/wechatbinding/getDistrict'));
        //$data["allcitys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getAllCity'));
        //$data["deps_data"] = json_encode($this->load->controller('wechat/wechatbinding/getOffice'));


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

