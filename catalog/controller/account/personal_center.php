<?php
class ControllerAccountPersonalCenter extends Controller
{

    private $error = array();

    public function index()
    {
        $log = new Log("wechat.log");

        $this->load->model('wechat/userinfo');

	//$this->session->data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';
        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
            $log->write("123456=" . $this->session->data['openid']);

        }
        else{
            $data["openid"] = "";
            $log->write("654321=" . $this->session->data['openid']);
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
        }/*else{
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }*/
	
        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $data = $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);
        $log->write("用户号码=" . $data["customer_id"]);

        if (!isset($data['address_id'])){
            $data['address_id'] = "";
        }
        if (!isset($data['department'])){
            $data['department'] = "";
        }

        $this->load->model('account/address');
        $temp = $this->model_account_address->getAddress($data['address_id']);
        $data['householdregister'] = $temp['householdregister'];
        $data['district'] = $temp['city'];
        $data['address_1'] = $temp['address_1'];

        $this->load->model('clinic/clinic');
        if ($data["department"] != NULL) {
            $data["department"] = $this->ConvertDepartment($data["department"]);
            $log->write("department=" . $data["department"]);
        } else {
            $data["department"] = "";
        }

        if (!isset($data['customer_id'])) {
            $data['height'] = "";
            $data['weight'] = "";
            $data['birthday'] = "";
            $data['barcode'] = "";
            $data['bmiindex'] = "";
            $data['bmitype'] = "";
            $data['pregnantstatus'] = "";
            $data['lastmenstrualdate'] = "";
            $data['edc'] = "";
            $data['gravidity'] = "";
            $data['vaginaldelivery'] = "";
            $data['parity'] = "";
            $data['aesarean'] = "";
            $data['spontaneousabortion'] = "";
            $data['drug_inducedabortion'] = "";
            $data['fetal'] = "";
            $data['highrisk'] = "";
            $data['highriskfactor'] = "";
            $data['headimgurl'] = "";
            $data['realname'] = "";
            $data['nickname'] = "";
            $data['department'] = "";
            $data['telephone'] = "";
            $data['productiondate'] = "";
            $data['householdregister'] = "";
            $data['district'] = "";
            $data['address_1'] = "";

            $this->error['warning'] = "PersonalCenter： userinfo 为空";
            $log->write($this->error['warning']);
        }


        if (!isset($data['barcode'])) {
            $data['barcode'] = '';
        }

        if (!isset($data['birthday'])) {
            $data['birthday'] = '';
        }


        if (!isset( $data['height'])) {
            $data['height'] = '';
        }

        if (!isset( $data['weight'])) {
            $data['weight'] = '';
        }

        if (!isset($data['bmiindex'])) {

            $data['bmiindex'] = '';
        }

        if (!isset($data['bmitype'])) {

            $data['bmitype'] = '';
        }

        if (!isset($data['pregnantstatus'])) {

            $data['pregnantstatus'] = '';
        }


        if (!isset($data['lastmenstrualdate'])) {

            $data['lastmenstrualdate'] = '';
        }

        if (!isset( $data['edc'])) {

            $data['edc'] = '';
        }

        if (!isset($data['gravidity'])) {

            $data['gravidity'] = '';
        }

        if (!isset($data['parity'])) {

            $data['parity'] = '';
        }

        if (!isset($data['vaginaldelivery'])) {

            $data['vaginaldelivery'] = '';
        }

        if (!isset( $data['aesarean'] )) {

            $data['aesarean'] = '';
        }

        if (!isset($data['spontaneousabortion'] )) {

            $data['spontaneousabortion'] = '';
        }

        if (!isset($data['drug_inducedabortion'])) {

            $data['drug_inducedabortion'] = '';
        }

        if (!isset($data['fetal'])) {

            $data['fetal'] = '';
        }



        $this->document->setTitle("基本信息");
        $this->session->data["nav"] = "personal_center";
        //$data['header'] = $this->load->controller('common/wechatheader');
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        $data['userinfo_url'] = $this->url->link('wechat/userinfo', '', true);

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        //$this->load->model('clinic/clinic');
        //$data["departmentlist"] = $this->model_clinic_clinic->getOffices();

        $result  = array(
            'error_warning' =>  $data['error_warning'], 
            'headimgurl' =>  $data['headimgurl'],
            'realname' =>  $data['realname'],
            'telephone' =>  $data['telephone'],
            'barcode' =>  $data['barcode'],
            'department' =>  $data['department'],
            'pregnantstatus' =>  $data['pregnantstatus'],
            'birthday' =>  $data['birthday'],
            'height' =>  $data['height'],
            'weight' =>  $data['weight'],
            'bmitype' =>  $data['bmitype'],
            'bmiindex' =>  $data['bmiindex'],
            'lastmenstrualdate' =>  $data['lastmenstrualdate'],
            'gravidity' =>  $data['gravidity'],
            'parity' =>  $data['parity'],
            'edc' =>  $data['edc'],
            'vaginaldelivery' =>  $data['vaginaldelivery'],
            'aesarean' =>  $data['aesarean'],
            'spontaneousabortion' =>  $data['spontaneousabortion'],
            'drug_inducedabortion' =>  $data['drug_inducedabortion'],
            'highriskfactor' =>  $data['highriskfactor'],
            'highrisk' =>  $data['highrisk'],
            'district' =>  $data['district'],
            'address_1' =>  $data['address_1'],
            'householdregister' =>  $data['householdregister'],
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

    public function ConvertDepartment($department)
    {
        $temp_arr = explode(",", $department);
        $this->load->model('wechat/userinfo');
        if (count($temp_arr) == 3) {
            $cityName = $this->model_wechat_userinfo->getCityName($temp_arr[0]);
            $districtName = $this->model_wechat_userinfo->getDistrictName($temp_arr[1]);
            $officeName = $this->model_wechat_userinfo->getOfficeName($temp_arr[2]);
            return $cityName . "市" . $districtName . "区" . $officeName;
        }

    }
}
