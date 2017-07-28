<?php
class ControllerWechatEvaluate extends Controller
{


    public function index()
    {

        $log = new Log("wechat.log");

        $jxsession = $this->load->controller('account/authentication');
        if(empty($jxsession)) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($jxsession),true);
        $data["order_id"] = $this->request->json('order_id', 0);

        $this->load->model('wechat/ordercenter');
        $order_info = $this->model_wechat_ordercenter->getOrder($data["order_id"]);
        $data["doctor_id"] = $order_info["doctor_id"];
        $data["customer_id"] = $order_info["customer_id"] ;

        $data["jxsession"] = $jxsession;
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }

    public function submit()
    {

        $log = new Log("wechat.log");

        $jxsession = $this->load->controller('account/authentication');
        if(empty($jxsession)) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($jxsession),true);
        $data["order_id"] = $this->request->json('order_id');

        $this->load->model('wechat/ordercenter');
        $order_info = $this->model_wechat_ordercenter->getOrder($data["order_id"]);

        $data["doctor_id"] = $order_info["doctor_id"];
        $data["customer_id"] = $order_info["customer_id"] ;
        $data["evaluate_text"] = $this->request->json('evaluate_text',"");
        $data["starrating"] = $this->request->json('starrating');
        $data["evaluate_tag"] = $this->request->json('evaluate_tag',"");
        $data["jxsession"] = $jxsession;
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        $postdata = array(
            'customer_id' => $data["customer_id"] ,
            'order_id' => $data["order_id"] ,
            'doctor_id' => $data["doctor_id"] ,
            'evaluate_text' => $data["evaluate_text"] ,
            'starrating' => $data["starrating"],
            'evaluate_tag' => $data["evaluate_tag"]
        );

        $this->load->model('wechat/ordercenter');
        $evaluate_info = $this->model_wechat_ordercenter->getOrderEvaluate($data['order_id']);
        if(!empty($evaluate_info)) {

            $response = array(
                'code'  => 1070,
                'message'  => "该订单已评价。",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;

        }
        $this->load->model('doctor/doctor');
        $this->model_doctor_doctor->addDoctorEvaluate($postdata);
        $doctor_info = $this->model_doctor_doctor->getDoctor($data["doctor_id"]);
        if(empty($doctor_info["starrating"])) {
            $starrating = round($data["starrating"] ,1) ;
        }else {
            $starrating = round(($data["starrating"]+$doctor_info["starrating"])/2,1);
        }
        $this->model_doctor_doctor->editDoctorStarrating($starrating ,$data["doctor_id"]);

        $this->load->model('wechat/ordercenter');
        $this->model_wechat_ordercenter->UpdateOrderStatusToComplete($data["order_id"]);


        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));


        //$this->response->setOutput($this->load->view('wechat/orderDetail', $data));
    }



}
