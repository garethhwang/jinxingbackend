<?php

class ControllerWechatWechatbinding extends Controller
{
    private $error = array();

    public function validcode()
    {
            $telephone = $this->request->json('telephone');

            if(isset($telephone)){

                $code = rand(100000 ,999999);

                $sms = $this->sendTemplateSMS($telephone, array($code, '5'), "151750");

                //$log->write("smscode=".$code);

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

            }else{

                 $msgid = 3;
                 $html = '无效手机号码';

            }

        $data = array(
            'msgid' => $msgid ,
            'html' => $html
        );

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

           
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }

    public function index()
    {
        $log = new Log("wechat.log");

        $data["openid"] = "";
	    $code = $this->request->json('code');
        //wechat
        if (isset($code)) {
            try {
                $get_return = $this->load->controller('wechat/userinfo/getUsertoken');
                $this->load->model('wechat/userinfo');
                if (isset($get_return["openid"])) {
                    $data["openid"] = $get_return["openid"];
                    $log->write("register openid:" . $get_return["openid"]);
                    $wechatid = $this->model_wechat_userinfo->isUserValid($get_return["openid"]);
                    if (isset($wechatid)) {
                        $data["wechat_id"] = $wechatid;
                    } else {
                        $wechatinfo = $this->getUser($get_return["access_token"], $get_return["openid"]);
                        $data["wechat_id"] = $this->model_wechat_userinfo->addWechatUser($wechatinfo);
                    }
                    $log->write("register wechat_id:" . $data["wechat_id"]);
                } else {
                    $log->write("register 没有取到openid");
                    $this->error["error_warning"] = $get_return["errmsg"];
                    $data["wechat_id"] = "";
                }
            } catch (Exception $e) {
                $this->error["error_warning"] = $e->getMessage();
                $data["wechat_id"] = "";
                $this->response->setOutput($e->getMessage());
            }
        } else if (isset($this->session->data['openid'])) {
            $get_return["openid"] = $this->session->data['openid'];
            $data["openid"] = $get_return["openid"];

        } else if (isset($this->request->post['wechat_id'])) {
            $data['wechat_id'] = $this->request->post['wechat_id'];
        } else {
            $data['wechat_id'] = '';
        }

	$data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

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


        $data['telephone'] = $this->request->json('telephone', '');
        $data['smscode'] = $this->request->json('smscode', 0);
        $data['realname'] = $this->request->json('realname', '');
        $data['pregnantstatus'] =  $this->request->json('pregnantstatus', '');
        $data['district'] = $this->request->json('district', '');
        $data['address_1'] = $this->request->json('address_1','');

        $postdata  = array(
            'telephone' => $data['telephone'],
            'realname'  => $data['realname'],
            'smscode'  => $data['smscode'],
            'pregnantstatus' => $data['pregnantstatus'],
            'district' => $data['district'],
            'address_1' => $data['address_1'],
            );

        $this->load->language('wechat/register');
        $this->document->setTitle("金杏健康");
        $this->load->model('account/customer');

            $this->load->model('wechat/userinfo');
            $temp = $this->model_wechat_userinfo->getUserInfo($data["openid"]);
            $postdata["wechat_id"] = $temp["wechat_id"];

            if($this->cache->get($postdata["telephone"]) !=  $postdata["smscode"]){
                             $data['isnotright'] = '1';
            }else{
                $data['isnotright'] = '0';
                $this->model_account_customer->addNonpregnant($postdata);
                $this->customer->nonpregnantlogin($data["openid"]);
                unset($this->session->data['guest']);
                //$log->write("telephone=".$this->request->post["telephone"]."smscode=".$this->cache->get($this->request->post["telephone"])."isnotright=".$data['isnotright']);
                //$this->response->redirect($this->url->link('wechat/registersuccess', '', true));
            }

            //$log->write("telephone=".$this->request->post["telephone"]."smscode=".$this->cache->get($this->request->post["telephone"])."isnotright=".$data['isnotright']);
            /*$this->model_account_customer->addNonpregnant($this->request->post);
            $this->customer->nonpregnantlogin($data["openid"]);
            unset($this->session->data['guest']);
            $this->response->redirect($this->url->link('wechat/registersuccess', '', true));*/
        
        $data['entry_realname'] = $this->language->get('entry_realname');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_address_1'] = $this->language->get('entry_address');


        //$data['button_continue'] = $this->language->get('button_continue');
        //$data['button_upload'] = $this->language->get('button_upload');

        if (isset($this->error['warning'])) {
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

       /* if (isset($this->request->post['realname'])) {
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

	    $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

       // $this->response->setOutput($this->load->view('wechat/wechatbinding', $data));

    }


    /*private function validate()
    {

        if ((utf8_strlen(trim($this->request->post['realname'])) < 1) || (utf8_strlen(trim($this->request->post['realname'])) > 32)) {
            $this->error['realname'] = $this->language->get('error_realname');
        }

        if ($this->model_account_customer->getTotalNonpregnantByWechat($this->request->post['wechat_id'])) {
            if ($this->request->post['wechat_id']) {
                $this->error['warning'] = $this->language->get('error_wechat_exists');
            }
        }


        if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }


        if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
            $this->error['address_1'] = $this->language->get('error_address');
        }

        return !$this->error;
    }*/

    public function getProvince()
    {
        $this->load->model('wechat/bind');
        $returndata = $this->model_wechat_bind->getProvinces();

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $returndata;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function getCity()
    {
        $this->load->model('wechat/bind');
        $allprovince = $this->model_wechat_bind->getProvinces();
        foreach ($allprovince as $province) {
            $city = $this->model_wechat_bind->getCities($province["id"]);
            $returndata[$province["id"]] =$city;
        }
        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $returndata;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function getAllCity()
    {
        $this->load->model('wechat/bind');
        $returndata = $this->model_wechat_bind->getAllCities();
        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $returndata;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }


    public function getDistrict()
    {
        $this->load->model('wechat/bind');
        $allcities = $this->model_wechat_bind->getAllCities();
        foreach ($allcities as $city) {
            $district = $this->model_wechat_bind->getDistricts($city["id"]);
            $returndata[$city["id"]] = $district;
        }
        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $returndata;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function getOffice(){
        $this->load->model('wechat/bind');
        $this->load->model('clinic/clinic');
        $allDistricts = $this->model_wechat_bind->getAllDistricts();
        foreach ($allDistricts as $district) {
            $office = $this->model_clinic_clinic->getOffice($district["id"]);
            $returndata[$district["id"]] = $office;
        }
        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $returndata;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    private function getUser($accesstoken, $openid)
    {
        $get_url = sprintf(WECHAT_GETUSERINFO, $accesstoken, $openid);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        return $get_return;
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

    private function getAddress(){

        $this->load->model('wechat/bind');

        $allprovince = $this->model_wechat_bind->getProvinces();
        foreach ($allprovince as $province) {
            $city = $this->model_wechat_bind->getCities($province["id"]);
            $allcity[$province["id"]] =$city;
        }


        $allcities = $this->model_wechat_bind->getAllCities();
        foreach ($allcities as $city) {
            $district = $this->model_wechat_bind->getDistricts($city["id"]);
            $alldistrict[$city["id"]] = $district;
        }

        $this->load->model('clinic/clinic');
        $allDistricts = $this->model_wechat_bind->getAllDistricts();
        foreach ($allDistricts as $district) {
            $office = $this->model_clinic_clinic->getOffice($district["id"]);
            $alloffice[$district["id"]] = $office;
        }

        $data =array(
            'province' => $allprovince,
            'city' =>  $allcity,
            'district' => $alldistrict,
            'office' => $alloffice
        );

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }











}
