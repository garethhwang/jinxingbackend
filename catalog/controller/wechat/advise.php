<?php

class ControllerWechatAdvise extends Controller
{
    private $error = array();

    public function index()
    {
        $log = new Log('wechat.log');

        $this->load->model('wechat/userinfo');

        if (isset($this->session->data['openid'])) {
            $log->write("PersonalCenter openid:".$this->session->data['openid']);
            $data['openid']=$this->session->data['openid'];
            $this->error['warning'] = "";
        } else {
            $data['openid'] = "";
            $this->error['warning'] = "PersonalCenter： 微信信息没有获取到！";
            $log->write($this->error['warning']);
        }

        $data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data= $this->model_wechat_userinfo->getCustomerByWechat($data['openid']);


        $data['advisetext'] = $this->request->json('advisetext','');

        $this->model_wechat_userinfo->addAdvise($data,$data["customer_id"]);

        

        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $this->model_wechat_userinfo->addAdvise($this->request->post,$data["customer_id"]);

        }*/
        //$data['action'] = $this->url->link('wechat/advisesuccess', '', true);
        $this->document->setTitle("投诉建议");

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"]="personal_center";

        $result  = array(
            'advisetext' => $data['advisetext'],
            'customer_id' => $data['customer_id'],
            );

        $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
        );
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/advise', $data));
    }
}
