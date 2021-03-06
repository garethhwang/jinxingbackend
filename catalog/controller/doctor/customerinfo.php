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

        $this->load->model('account/customer');

        $customer_info = $this->model_account_customer->getCustomerInfo();

        //var_dump($customer_info);

        /*$result  = array(
            'realname' =>  $customer_info['realname'],
            'headimgurl' =>  $customer_info['headimgurl']
        );*/

        $result = array(
            'jxsession' => $data["jxsession"],
            'doctor_info'=> $customer_info
        );

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/edituser', $data));
    }


    public function all()
    {
        $log = new Log("wechat.log");
        $customer_id = $this->request->json('customer_id', '');

        $this->load->model('account/customer');

        $customer = $this->model_account_customer->getCustomer($customer_id);

        if(!$customer){
            $customer = array();
        }

        if(isset($customer['wechat_id'])) {
            $this->load->model('wechat/userinfo');
            $wechat = $this->model_wechat_userinfo->getUserInfoByWechatId($customer['wechat_id']);
        } else {
            $wechat = array();
        }

        if(isset($customer['physical_id'])) {
            $this->load->model('account/physical');
            $physical = $this->model_account_physical->getPhysical($customer['physical_id'], $customer['customer_id']);
        } else {
            $physical = array();
        }


        if(isset($customer['address_id'])) {
            $this->load->model('account/address');
            $address = $this->model_account_address->getAddress($customer['address_id'], $customer['customer_id']);
        } else {
            $address = array();
        }


         $data = array_merge($wechat,$customer,$physical,$address);

         //$log->write("1111111=".$data);

        if (empty($data)) {
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
            $data['city'] = "";
            $data['address_1'] = "";
            $log->write("123456789");
        }


        if ($data['department']) {
            $data["department"] = $this->ConvertDepartment($data['department']);
            //$log->write("department=" . $data["department"]);
        } else {
            $data["department"] = "";
        }



        $result  = array(
            'headimgurl' =>  $data['headimgurl'],
            'realname' =>  $data['realname'],
            'telephone' =>  $data['telephone'],
            'barcode' =>  $data['barcode'],
            'department' =>  $data['department'],
            'pregnantstatus' =>  $data['pregnantstatus'],
            'birthday' =>  $data['birthday'],
            'babybirth' => $data['babybirth'],
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
            'district' =>  $data['city'],
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