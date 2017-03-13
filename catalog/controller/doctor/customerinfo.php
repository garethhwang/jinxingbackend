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

        $result  = array(
            'realname' =>  $customer_info['realname'],
            'headimgurl' =>  $customer_info['headimgurl']
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

}