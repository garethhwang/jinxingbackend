<?php

class ControllerWechatTestPhysical extends Controller
{
    private $error = array();

    public function index()
    {
        $get_return = array();

        $data['button_continue'] = $this->language->get('button_continue');

        //$this->load->model('wechat/physicalreceipt');
        //$test = $this->model_wechat_physicalreceipt->getReceipt(1);
        $test['receipt_text'] = '{"receipt":[
{"id":"1","name":"心脏病","flag":"1", "detail":[{"key":"心率失常","value":"无"},{"key":"心功能异常","value":"无"},{"key":"其它","value":"无"}]},
{"id":"2","name":"高血压","flag":"1", "detail":{"key":"血压数值","value":"无"}}, 
{"id":"3","name":"糖尿病","flag":"1", "detail":[{"key":"餐后2小时血糖值","value":"无"},{"key":"用药治疗","value":"无"}]} ,
{"id":"4","name":"肾病","flag":"1", "detail": [{"key":"肾炎","value":"无"},{"key":"肾炎伴肾功能损害","value":"无"},{"key":"肾炎伴高血压，蛋白尿，肾功能不全","value":"无"}]},
{"id":"5","name":"肝病","flag":"1", "detail": [{"key":" ALT数值","value":"无"},{"key":" ALT数值","value":"无"},{"key":"慢性肝炎病毒携带者","value":"无"},{"key":"肝硬化","value":"无"},{"key":"肝内胆汁淤积症","value":"无"}]},
{"id":"6","name":"甲状腺功能异常","flag":"1", "detail": [{"key":"甲亢 ","value":"无"},{"key":"甲减或低下","value":"无"},{"key":"甲状腺疾病","value":"无"}]},
{"id":"7","name":"血液系统疾病","flag":"1","detail": [{"key":"贫血HGB数值","value":"无"},{"key":"血小板异常数值","value":"无"},{"key":"再生障碍性贫血/白血病","value":"无"}]},
{"id":"8","name":"其他","flag":"1","detail": [{"key":"精神疾病","value":"无"},{"key":"血型不合","value":"无"},{"key":"免疫系统疾病","value":"无"},{"key":"结核","value":"无"},{"key":"哮喘","value":"无"},{"key":"肿瘤","value":"无"},{"key":"性病","value":"无"},{"key":"其它","value":"无"}]}]}';
        $data['receipt']=json_decode($test['receipt_text'], true)['receipt'];
       /* $data['xzb'] = $data['receipt'][0]['detail'][2]['value'];
        $data['gxy'] = $data['receipt'][1]['detail']['value'];
        $data['tnb'] = $data['receipt'][2]['detail'][0]['value'];
        $data['alt'] = $data['receipt'][4]['detail'][0]['value'];
        $data['ast'] = $data['receipt'][4]['detail'][1]['value'];
        $data['hgb'] = $data['receipt'][6]['detail'][0]['value'];
        $data['xqb'] = $data['receipt'][6]['detail'][1]['value'];
        $data['other'] = $data['receipt'][7]['detail'][7]['value'];*/

        //$this->load->model('wechat/physicalreceipt');
        //$data['submit']=$this->model_wechat_physicalreceipt->getDateAdd($data['customer_id']);


        $this->load->model('wechat/physicalreceipt');
        $this->load->model('account/customer');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {


            if ($this->request->post['heart'] == 1) {
                foreach ($this->request->post['heartdisease'] as $key) {
                    for ($i = 0; $i < count($data['receipt'][0]['detail']); $i++) {
                        if ($key == $data['receipt'][0]['detail'][$i]['key']) {
                            $data['receipt'][0]['detail'][$i]['value'] = "是";
                            if ($key == $data['receipt'][0]['detail'][2]['key']) {
                                $data['receipt'][0]['detail'][2]['value'] = $this->request->post['xzb'];
                            }
                        }
                    }
                }
            } else {
                $data['receipt'][0]['flag'] = "0";
            }

            if ($this->request->post['hyper'] == 1) {

                $data['receipt'][1]['detail']['value'] = $this->request->post['gxy'];
            } else {
                $data['receipt'][1]['flag'] = "0";
            }


            if ($this->request->post['GI'] == 1) {
                $data['receipt'][2]['detail'][0]['value'] = $this->request->post['tnb'];
                $data['receipt'][2]['detail'][1]['value'] = $this->request->post['cure'];

            } else {
                $data['receipt'][2]['flag'] = "0";
            }

            if ($this->request->post['neph'] == 1) {
                foreach ($this->request->post['nephropathy'] as $key) {
                    for ($i = 0; $i < count($data['receipt'][3]['detail']); $i++) {
                        if ($key == $data['receipt'][3]['detail'][$i]['key']) {
                            $data['receipt'][3]['detail'][$i]['value'] = "是";
                        }
                    }
                }
            } else {
                $data['receipt'][3]['flag'] = "0";
            }


            if ($this->request->post['hepa'] == 1) {

                $data['receipt'][4]['detail'][0]['value'] = $this->request->post['alt'];
                $data['receipt'][4]['detail'][1]['value'] = $this->request->post['ast'];

                foreach ($this->request->post['hepatopathy'] as $key) {
                    for ($i = 2; $i < count($data['receipt'][4]['detail']); $i++) {
                        if ($key == $data['receipt'][4]['detail'][$i]['key']) {
                            $data['receipt'][4]['detail'][$i]['value'] = "是";
                        }
                    }
                }
            } else {
                $data['receipt'][4]['flag'] = "0";
            }

            if ($this->request->post['thy'] == 1) {
                foreach ($this->request->post['thyroid'] as $key) {
                    for ($i = 0; $i < count($data['receipt'][5]['detail']); $i++) {
                        if ($key == $data['receipt'][5]['detail'][$i]['key']) {
                            $data['receipt'][5]['detail'][$i]['value'] = "是";
                        }
                    }
                }
            } else {
                $data['receipt'][5]['flag'] = "0";
            }


            if ($this->request->post['bloods'] == 1) {
                foreach ($this->request->post['blood'] as $key) {

                    if ($key == $data['receipt'][6]['detail'][0]['key']) {
                        $data['receipt'][6]['detail'][0]['value'] = $this->request->post['hgb'];
                    } else if ($key == $data['receipt'][6]['detail'][1]['key']) {

                        $data['receipt'][6]['detail'][1]['value'] = $this->request->post['xqb'];

                    } else if ($key == $data['receipt'][6]['detail'][2]['key']) {

                        $data['receipt'][6]['detail'][2]['value'] = "是";
                    }
                }
            } else {
                $data['receipt'][6]['flag'] = "0";
            }

            if ($this->request->post['otherelse'] == 1) {
                foreach ($this->request->post['others'] as $key) {
                    for ($i = 0; $i < count($data['receipt'][7]['detail']); $i++) {
                        if ($key == $data['receipt'][7]['detail'][$i]['key']) {
                            $data['receipt'][7]['detail'][$i]['value'] = "是";
                            if ($key == $data['receipt'][7]['detail'][7]['key']) {
                                $data['receipt'][7]['detail'][7]['value'] = $this->request->post['other'];
                            }
                        }
                    }
                }
            } else {
                $data['receipt'][7]['flag'] = "0";
            }


            $temp['receipt']=$data['receipt'];
            $result = array(

                'receipt_id' =>  '1' ,
                'customer_id' =>  $data['customer_id'],
                'receipt_text' => json_encode($temp, JSON_UNESCAPED_UNICODE)
            );

            if (isset($this->request->post['xzb'])) {
                $data['xzb'] = $this->request->post['xzb'];
            } else {
                $data['xzb'] = '无';
            }

            if (isset($this->request->post['gxy'])) {
                $data['gxy'] = $this->request->post['gxy'];
            } else {
                $data['gxy'] = '无';
            }

            if (isset($this->request->post['tnb'])) {
                $data['tnb'] = $this->request->post['tnb'];
            } else {
                $data['tnb'] = '无';
            }


            if (isset($this->request->post['alt'])) {
                $data['alt'] = $this->request->post['alt'];
            } else {
                $data['alt'] = '无';
            }

            if (isset($this->request->post['ast'])) {
                $data['ast'] = $this->request->post['ast'];
            } else {
                $data['ast'] = '无';
            }

            if (isset($this->request->post['hgb'])) {
                $data['hgb'] = $this->request->post['hgb'];
            } else {
                $data['hgb'] = '无';
            }

            if (isset($this->request->post['xqb'])) {
                $data['xqb'] = $this->request->post['xqb'];
            } else {
                $data['xqb'] = '无';
            }

            if (isset($this->request->post['other'])) {
                $data['other'] = $this->request->post['other'];
            } else {
                $data['other'] = '无';
            }


            $this->load->model('wechat/physicalreceipt');
            $this->model_wechat_physicalreceipt->addReceiptHistory($result);
            $record=$this->model_wechat_physicalreceipt->getRecord($data['customer_id']);
            $this->load->model('account/customer');
            if($record=='1'){
                $this->model_account_customer->updateReceiptDate($data, '20');
            }
            if($record=='2'){
                $this->model_account_customer->updateReceiptDate($data, '34');
            }


            //$this->session->data['success'] = $this->language->get('text_add');
            $this->response->redirect($this->url->link('wechat/userinfo', '', true));


        }

        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $this->response->setOutput($this->load->view('wechat/physicalreceipt', $data));
    }


    public function delete() {
        $get_return = array();
        if (isset($this->request->get["code"])) {
            $get_return = $this->load->controller('wechat/userinfo/getUsertoken');

        } else {
            $data["error_warning"] = "关注微信公众号后打开！";
        }

        $data["openid"] = $get_return["openid"];
        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/physicalreceipt');

        if (isset($this->request->get['receipt_history_id']) ) {
            $this->model_wechat_physicalreceipt->deleteReceiptHistory($this->request->get['receipt_history_id']);


            $this->session->data['success'] = $this->language->get('text_delete');


            $this->response->redirect($this->url->link('wechat/physicalreceipt', '', true));
        }

        //$this->getList();
    }

}
