<?php
class ControllerAccountPersonalCenter extends Controller
{

    private $error = array();

    public function index()
    {
        $log = new Log("wechat.log");

        /*$this->load->model('wechat/userinfo');
	    //$this->session->data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';
        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->load->controller('wechat/userinfo/getUsertoken');
            $log->write("123456=" . $this->session->data['openid']);
        }
        else{
            $data["openid"] = "";
            //$log->write("654321=" . $this->session->data['openid']);
        }
        //wechat
        $code = $this->request->json("code","");
        $log->write("code=" . $code);
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code,true);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
            $log->write("openidid=" .  $data["openid"]);
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
	
        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);*/

        $data["jxsession"] = $this->load->controller('account/authentication');
        if(empty($data["jxsession"])) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($data["jxsession"]),true);


        if (!isset($customer_info['customer_id'])){
            $customer_info['customer_id'] = "";
        }
        if (!isset($customer_info['address_id'])){
            $customer_info['address_id'] = "";
        }
        if (!isset($customer_info['department'])){
            $customer_info['department'] = "";
        }

        $this->load->model('account/address');
        $temp = $this->model_account_address->getAddress($customer_info['address_id'],$customer_info['customer_id']);
        if(!empty($temp)){
            $customer_info['householdregister'] = $temp['householdregister'];
            $customer_info['district'] = $this->ConvertPosition($temp['city']);
            $customer_info['address_1'] = $temp['address_1'];
        } else {
            $customer_info['householdregister'] = "";
            $customer_info['district'] = "";
            $customer_info['address_1'] = "";
        }


        if (!empty($customer_info["department"])) {
            $customer_info["department"] = $this->ConvertDepartment($customer_info["department"]);

        } else {
            $customer_info["department"] = "";
        }

        if (!isset($customer_info['customer_id'])) {
            $customer_info['height'] = "";
            $customer_info['weight'] = "";
            $customer_info['birthday'] = "";
            $customer_info['barcode'] = "";
            $customer_info['bmiindex'] = "";
            $customer_info['bmitype'] = "";
            $customer_info['pregnantstatus'] = "";
            $customer_info['lastmenstrualdate'] = "";
            $customer_info['edc'] = "";
            $customer_info['gravidity'] = "";
            $customer_info['vaginaldelivery'] = "";
            $customer_info['parity'] = "";
            $customer_info['aesarean'] = "";
            $customer_info['spontaneousabortion'] = "";
            $customer_info['drug_inducedabortion'] = "";
            $customer_info['fetal'] = "";
            $customer_info['highrisk'] = "";
            $customer_info['highriskfactor'] = "";
            $customer_info['headimgurl'] = "";
            $customer_info['realname'] = "";
            $customer_info['nickname'] = "";
            $customer_info['department'] = "";
            $customer_info['telephone'] = "";
            $customer_info['productiondate'] = "";
            $customer_info['householdregister'] = "";
            $customer_info['district'] = "";
            $customer_info['address_1'] = "";

            //$this->error['warning'] = "PersonalCenter： userinfo 为空";
            //$log->write($this->error['warning']);
        }


        if (!isset($customer_info['barcode'])) {
            $customer_info['barcode'] = '';
        }

        if (!isset($customer_info['birthday'])) {
            $customer_info['birthday'] = '';
        }


        if (!isset($customer_info['height'])) {
            $customer_info['height'] = '';
        }

        if (!isset($customer_info['weight'])) {
            $customer_info['weight'] = '';
        }

        if (!isset($customer_info['bmiindex'])) {

            $customer_info['bmiindex'] = '';
        }

        if (!isset($customer_info['bmitype'])) {

            $customer_info['bmitype'] = '';
        }

        if (!isset($customer_info['pregnantstatus'])) {

            $customer_info['pregnantstatus'] = '';
        }


        if (!isset($customer_info['lastmenstrualdate'])) {

            $customer_info['lastmenstrualdate'] = '';
        }

        if (!isset($customer_info['edc'])) {

            $customer_info['edc'] = '';
        }

        if (!isset($customer_info['gravidity'])) {

            $customer_info['gravidity'] = '';
        }

        if (!isset($customer_info['parity'])) {

            $customer_info['parity'] = '';
        }

        if (!isset($customer_info['vaginaldelivery'])) {

            $customer_info['vaginaldelivery'] = '';
        }

        if (!isset($customer_info['aesarean'] )) {

            $customer_info['aesarean'] = '';
        }

        if (!isset($customer_info['spontaneousabortion'] )) {

            $customer_info['spontaneousabortion'] = '';
        }

        if (!isset($customer_info['drug_inducedabortion'])) {

            $customer_info['drug_inducedabortion'] = '';
        }

        if (!isset($customer_info['fetal'])) {

            $customer_info['fetal'] = '';
        }


        $customer_info['userinfo_url'] = $this->url->link('wechat/userinfo', '', true);

        if (isset($this->error['warning'])) {
            $customer_info['error_warning'] = $this->error['warning'];
        } else {
            $customer_info['error_warning'] = '';
        }
        //$this->load->model('clinic/clinic');
        //$customer_info["departmentlist"] = $this->model_clinic_clinic->getOffices();

        //$log->write( $customer_info['barcode']. $customer_info['height'].$customer_info['lastmenstrualdate'].$customer_info['aesarean'].$customer_info['address_1']);

        $result  = array(
            'jxsession' => $data["jxsession"],
            'error_warning' =>  $customer_info['error_warning'],
            'headimgurl' =>  $customer_info['headimgurl'],
            'realname' =>  $customer_info['realname'],
            'telephone' =>  $customer_info['telephone'],
            'barcode' =>  $customer_info['barcode'],
            'department' =>  $customer_info['department'],
            'pregnantstatus' =>  $customer_info['pregnantstatus'],
            'birthday' =>  $customer_info['birthday'],
            'height' =>  $customer_info['height'],
            'weight' =>  $customer_info['weight'],
            'bmitype' =>  $customer_info['bmitype'],
            'bmiindex' =>  $customer_info['bmiindex'],
            'lastmenstrualdate' =>  $customer_info['lastmenstrualdate'],
            'gravidity' =>  $customer_info['gravidity'],
            'parity' =>  $customer_info['parity'],
            'edc' =>  $customer_info['edc'],
            'vaginaldelivery' =>  $customer_info['vaginaldelivery'],
            'aesarean' =>  $customer_info['aesarean'],
            'spontaneousabortion' =>  $customer_info['spontaneousabortion'],
            'drug_inducedabortion' =>  $customer_info['drug_inducedabortion'],
            'highriskfactor' =>  $customer_info['highriskfactor'],
            'highrisk' =>  $customer_info['highrisk'],
            'district' =>  $customer_info['district'],
            'address_1' =>  $customer_info['address_1'],
            'householdregister' =>  $customer_info['householdregister'],
            );



	    $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $result;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));


        //$this->response->setOutput($this->load->view('account/personal_center', $data));
        //$this->response->setOutput($this->load->view('account/wechatregister',$data));
    }

    public function ConvertDepartment($department){
        $temp_arr = explode(",", $department);
        $this->load->model('wechat/userinfo');
        if (count($temp_arr) == 3) {
            $cityName = $this->model_wechat_userinfo->getCityName($temp_arr[0]);
            $districtName = $this->model_wechat_userinfo->getDistrictName($temp_arr[1]);
            $officeName = $this->model_wechat_userinfo->getOfficeName($temp_arr[2]);
            return $cityName . "市" . $districtName . "区" . $officeName;
        }

    }

    public function ConvertPosition($position){
        $temp_arr = explode(",", $position);
        $this->load->model('clinic/clinic');
        if (count($temp_arr) == 3) {
            $provinceName = $this->model_clinic_clinic->getProvince($temp_arr[0]);
            $cityName = $this->model_clinic_clinic->getCity($temp_arr[1]);
            $districtName = $this->model_clinic_clinic->getDistrict($temp_arr[2]);
            if($provinceName == $cityName){
                return $cityName."市".$districtName.'区';
            } else {
                return $provinceName."省".$cityName."市".$districtName.'区';
            }

        }

    }
}
