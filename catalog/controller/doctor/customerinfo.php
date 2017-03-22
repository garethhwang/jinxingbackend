<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/13
 * Time: 19:36
 */

class ControllerDoctorCustomerinfo extends Controller
{


    public function index()
    {
        $log = new Log("wechat.log");

        $this->load->model('account/customer');

        $customer_info = $this->model_account_customer->getCustomerInfo();

        //var_dump($customer_info);

        /*$result  = array(
            'realname' =>  $customer_info['realname'],
            'headimgurl' =>  $customer_info['headimgurl']
        );*/

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $customer_info;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/edituser', $data));
    }


    public function all()
    {
        //$log = new Log("wechat.log");
        $customer_id = $this->request->json('customer_id', '');

        $this->load->model('account/customer');

        $customer = $this->model_account_customer->getCustomer($customer_id);


        if (!isset($customer['customer_id'])){
            $customer['customer_id'] = "";
        }
        if (!isset($customer['address_id'])){
            $customer['address_id'] = "";
        }
        if(!isset($customer['physical_id'])){
            $customer['physical_id'] = "";
        }


        $this->load->model('account/physical');
        $physical = $this->model_account_physical->getPhysical($customer['physical_id'],$customer['customer_id']);
        $this->load->model('account/address');
        $address = $this->model_account_address->getAddress($customer['address_id'],$customer['customer_id']);
        $data = array_merge($customer,$physical,$address);
        $data['district'] = $address['city'];

        $this->load->model('clinic/clinic');
        if ($data["department"] != NULL) {
            $data["department"] = $this->ConvertDepartment($data["department"]);
            //$log->write("department=" . $data["department"]);
        } else {
            $data["department"] = "";
        }

        if (!isset($data['customer_id'])) {
            $data['height'] = "";
            $data['weight'] = "";
            $data['birthday'] = "";
            $data['babybirth'] = "";
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

        }


        if (!isset($data['barcode'])) {
            $data['barcode'] = '';
        }

        if (!isset($data['birthday'])) {
            $data['birthday'] = '';
        }

        if (!isset($data['babybirth'])) {
            $data['babybirth'] = '';
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

        if (!isset($data['district'])) {

            $data['district'] = '';
        }

        if (!isset($data['address_1'])) {

            $data['address_1'] = '';
        }


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