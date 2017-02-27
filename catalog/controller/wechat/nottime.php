<?php
class ControllerWechatNottime extends Controller
{
    private $error = array();

    public function index()
    {
        $data["error_warning"] = "";
        $get_return = array();
        if (isset($this->request->get["code"])) {
            $get_return = $this->load->controller('wechat/userinfo/getUsertoken');

        } else {
            if(isset($this->session->data['openid'])){
                $get_return["openid"] = $this->session->data['openid'];
            }
            else{
                $this->error['warning'] = "微信信息没有获取到！";
            }
        }

        if (isset($get_return["openid"])) {
            $data["openid"] = $get_return["openid"];
        } else {
            $data["openid"] = "";
            $data["error_warning"] = "微信信息没有获取到！";
        }

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        if (!isset($data['customer_id'])) {
            $this->response->redirect($this->url->link('wechat/register', '', true));
        }



        $this->document->setTitle("提示");

        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $this->response->setOutput($this->load->view('wechat/nottime', $data));

    }
}