<?php
class ControllerAccountJxedit extends Controller
{

    public function index() {


        $data["jxsession"] = $this->load->controller('account/authentication');
        if($data["jxsession"] == 0) {
            $data["login"] = 0 ;
        }else {
            $data["login"] = 1 ;
        }
        $customer_info = json_decode($this->cache->get($data["jxsession"]),true);

        $data['realname'] = $this->request->json('realname', '');
        $data['district'] = $this->request->json('district', '');
        $data['address_1'] = $this->request->json('address_1','');

        if(!empty($customer_info["customer_id"])) {
            $postdata  = array(
                'realname'  => $data['realname'],
                'district' => $data['district'],
                'address_1' => $data['address_1'],
            );
            $this->load->model('account/customer');
            $this->model_account_customer->editNotWechatCustomer($postdata, $customer_info["telephone"]);
            $this->load->model('account/physical');
            $this->model_account_physical->editPhysical($customer_info["physical_id"], $postdata, $customer_info["customer_id"]);
            $this->load->model('account/address');
            $this->model_account_address->editAddress($customer_info["address_id"], $postdata, $customer_info["customer_id"] );

            $info = $this->model_account_customer->getCustomerByTelephone($customer_info["telephone"]);
            $this->cache->set($data['jxsession'], json_encode($info));

        }

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