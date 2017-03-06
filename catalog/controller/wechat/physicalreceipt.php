<?php

class ControllerWechatPhysicalReceipt extends Controller
{
    private $error = array();


    public function submit(){

        $log = new Log("wechat.log");
        //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';
        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code","");
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code,true);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
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


        /*if(!isset($this->session->data['openid'])){
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

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);


        $test['receipt_text'] = '{"receipt":[
{"id":"1","name":"心脏病","flag":"1", "detail":[{"key":"心率失常","value":"无"},{"key":"心功能异常","value":"无"},{"key":"其它","value":"无"}]},
{"id":"2","name":"高血压","flag":"1", "detail":{"key":"血压数值","value":"无"}}, 
{"id":"3","name":"糖尿病","flag":"1", "detail":[{"key":"餐后2小时血糖值","value":"无"},{"key":"用药治疗","value":"无"}]} ,
{"id":"4","name":"肾病","flag":"1", "detail": [{"key":"肾炎","value":"无"},{"key":"肾炎伴肾功能损害","value":"无"},{"key":"肾炎伴高血压，蛋白尿，肾功能不全","value":"无"}]},
{"id":"5","name":"肝病","flag":"1", "detail": [{"key":" ALT数值","value":"无"},{"key":" ALT数值","value":"无"},{"key":"慢性肝炎病毒携带者","value":"无"},{"key":"肝硬化","value":"无"},{"key":"肝内胆汁淤积症","value":"无"}]},
{"id":"6","name":"甲状腺功能异常","flag":"1", "detail": [{"key":"甲亢 ","value":"无"},{"key":"甲减或低下","value":"无"},{"key":"甲状腺疾病","value":"无"}]},
{"id":"7","name":"血液系统疾病","flag":"1","detail": [{"key":"贫血HGB数值","value":"无"},{"key":"血小板异常数值","value":"无"},{"key":"再生障碍性贫血/白血病","value":"无"}]},
{"id":"8","name":"其他","flag":"1","detail": [{"key":"精神疾病","value":"无"},{"key":"血型不合","value":"无"},{"key":"免疫系统疾病","value":"无"},{"key":"结核","value":"无"},{"key":"哮喘","value":"无"},{"key":"肿瘤","value":"无"},{"key":"性病","value":"无"},{"key":"其它","value":"无"}]}]}';
        $data['receipt'] = json_decode($test['receipt_text'], true)['receipt'];


        $switch = $this->request->json('switch',array());


        foreach($switch as $key){
            if($key == "heart"){
                $switch['0'] = "1";
            }elseif ($key == "hyper"){
                $switch['1'] = "1";
            }elseif ($key == "GI"){
                $switch['2'] = "1";
            }elseif ($key == "neph"){
                $switch['3'] = "1";
            }elseif ($key == "hepa"){
                $switch['4'] = "1";
            }elseif ($key == "thy"){
                $switch['5'] = "1";
            }elseif ($key == "bloods"){
                $switch['6'] = "1";
            }elseif ($key == "otherelse"){
                $switch['7'] = "1";
            }
        }
        for ($i = 0; $i <8; $i++){
            if( $switch[$i] != "1" || !isset($switch[$i])){
                $switch[$i] = "0";
            }
        }

        /*$log->write("总数：".count($switch)."第一个：".$switch['0'].
            "第二个：".$switch['1'].
            "第三个：".$switch['2'].
            "第四个：".$switch['3'].
            "第五个：".$switch['4'].
            "第六个：".$switch['5'].
            "第七个：".$switch['6'].
            "第八个：".$switch['7']);*/

        $heartdisease = $this->request->json('heartdisease', array());
        $nephropathy = $this->request->json('nephropathy', array());
        $hepatopathy = $this->request->json('hepatopathy', array());
        $thyroid = $this->request->json('thyroid', array());
        $blood = $this->request->json('blood', array());
        $others = $this->request->json('others', array());



            $xzb = $this->request->json('xzb','无');
            $gxy = $this->request->json('gxy','无');
            $tnb = $this->request->json('tnb','无');
            $cure = $this->request->json('cure','无');
            $alt = $this->request->json('alt','无');
            $ast = $this->request->json('ast','无');
            $hgb = $this->request->json('hgb','无');
            $xqb = $this->request->json('xqb','无');
            $other = $this->request->json('other','无');

        //$log->write("qitajibing" . $other);


                if ($switch['0'] == "1") {
                    foreach ($heartdisease as $key) {
                        for ($i = 0; $i < count($data['receipt'][0]['detail']); $i++) {
                            if ($key == $data['receipt'][0]['detail'][$i]['key']) {
                                $data['receipt'][0]['detail'][$i]['value'] = "是";
                                if ($key == $data['receipt'][0]['detail'][2]['key']) {
                                    $data['receipt'][0]['detail'][2]['value'] = $xzb;
                                }
                            }
                        }
                    }
                } else {
                    $data['receipt'][0]['flag'] = "0";
                }

                if ($switch['1'] == "1") {

                    $data['receipt'][1]['detail']['value'] = $gxy;
                } else {
                    $data['receipt'][1]['flag'] = "0";
                }


                if ($switch['2'] == "1") {
                    $data['receipt'][2]['detail'][0]['value'] = $tnb;
                    $data['receipt'][2]['detail'][1]['value'] = $cure;

                } else {
                    $data['receipt'][2]['flag'] = "0";
                }

                if ($switch['3'] == "1") {
                    foreach ($nephropathy as $key) {
                        for ($i = 0; $i < count($data['receipt'][3]['detail']); $i++) {
                            if ($key == $data['receipt'][3]['detail'][$i]['key']) {
                                $data['receipt'][3]['detail'][$i]['value'] = "是";
                            }
                        }
                    }
                } else {
                    $data['receipt'][3]['flag'] = "0";
                }


                if ($switch['4'] == "1") {

                    $data['receipt'][4]['detail'][0]['value'] = $alt;
                    $data['receipt'][4]['detail'][1]['value'] = $ast;

                    foreach ($hepatopathy as $key) {
                        for ($i = 2; $i < count($data['receipt'][4]['detail']); $i++) {
                            if ($key == $data['receipt'][4]['detail'][$i]['key']) {
                                $data['receipt'][4]['detail'][$i]['value'] = "是";
                            }
                        }
                    }
                } else {
                    $data['receipt'][4]['flag'] = "0";
                }

                if ($switch['5'] == "1") {
                    foreach ($thyroid as $key) {
                        for ($i = 0; $i < count($data['receipt'][5]['detail']); $i++) {
                            if ($key == $data['receipt'][5]['detail'][$i]['key']) {
                                $data['receipt'][5]['detail'][$i]['value'] = "是";
                            }
                        }
                    }
                } else {
                    $data['receipt'][5]['flag'] = "0";
                }


                if ($switch['6'] == "1") {
                    foreach ($blood as $key) {

                        if ($key == $data['receipt'][6]['detail'][0]['key']) {
                            $data['receipt'][6]['detail'][0]['value'] = $hgb;
                        } else if ($key == $data['receipt'][6]['detail'][1]['key']) {

                            $data['receipt'][6]['detail'][1]['value'] = $xqb;

                        } else if ($key == $data['receipt'][6]['detail'][2]['key']) {

                            $data['receipt'][6]['detail'][2]['value'] = "是";
                        }
                    }
                } else {
                    $data['receipt'][6]['flag'] = "0";
                }

                if ($switch['7'] == "1") {
                    foreach ($others as $key) {
                        for ($i = 0; $i < count($data['receipt'][7]['detail']); $i++) {
                            if ($key == $data['receipt'][7]['detail'][$i]['key']) {
                                $data['receipt'][7]['detail'][$i]['value'] = "是";
                                if ($key == $data['receipt'][7]['detail'][7]['key']) {
                                    $data['receipt'][7]['detail'][7]['value'] = $other;
                                }
                            }
                        }
                    }
                } else {
                    $data['receipt'][7]['flag'] = "0";
                }

            $temp = array(
                'receipt' => $data['receipt']
            );


            $result = array(

                'receipt_id' => '1',
                'customer_id' => $data['customer_id'],
                'receipt_text' => json_encode($temp, JSON_UNESCAPED_UNICODE)
            );

            $this->load->model('wechat/physicalreceipt');
            $this->model_wechat_physicalreceipt->addReceiptHistory($result);
            $record = $this->model_wechat_physicalreceipt->getRecord($data['customer_id']);
            $this->load->model('account/customer');
            if ($record == '1') {
                $this->model_account_customer->updateReceiptDate($data, '20');
            }
            if ($record == '2') {
                $this->model_account_customer->updateReceiptDate($data, '34');
            }
            //$log->write("record=".$record);
            $this->session->data['success'] = "1";

            $data =array(
                'receipttext' => $result,
                'record' => $record,
                'success' => $this->session->data['success']
            );


        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));


        //$this->response->redirect($this->url->link('wechat/physicalreceipt', '', true));
    }


    public function index()
    {
        $log = new log('wechat.log');

        $data["error_warning"] = "";
        $get_return = array();
        //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code","");
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code,true);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
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


        /*if(!isset($this->session->data['openid'])){
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

        //$log->write("openid is ".$data['openid']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        //$log->write("open id is ".$data["openid"]." ,customer id is ".$data['customer_id']);
        if (!isset($data['customer_id'])) {
            $data['isnotregist'] = "1" ;
            $data['customer_id'] = " ";
        }
        else{
            $data['isnotregist'] = "0";
        }

        if(!isset($data['ispregnant'])){
            $data['ispregnant'] = "";
        }
        if($data['ispregnant'] == "0" ){
            $data["pregnant"] = "0";
        }else{
            $data["pregnant"] = "1";
        }

        if(!isset($data['highrisk'])){
            $data['highrisk'] = "";
        }
        if($data['highrisk'] == "否" || $data['highrisk'] == NULL){
            $data["ishighrisk"] = "0";
        }
        else{
            $data['ishighrisk'] = "1";
        }



        if (!isset($data['receiptdate'])) {
            $data['receiptdate'] = date("Y-m-d",strtotime("+10 week"));
        }


        if (!isset($data['lastmenstrualdate'])) {
            $data['lastmenstrualdate'] = date("Y-m-d");
        }

        $data['last'] = date_create($data['lastmenstrualdate']);
        //$data['last'] = date_format($data['last'] , "Y-m-d");

        $data['firststart'] = date_modify($data['last'],"+10 weeks");$data['firststart'] = date_format($data['firststart'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);
        $data['firstend'] = date_modify($data['last'],"+11 weeks");$data['firstend'] = date_format($data['firstend'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);
        $data['secondstart'] = date_modify($data['last'],"+20 weeks");$data['secondstart'] = date_format($data['secondstart'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);
        $data['secondend'] = date_modify($data['last'],"+21 weeks");$data['secondend'] = date_format($data['secondend'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);
        $data['thirdstart'] = date_modify($data['last'],"+34 weeks");$data['thirdstart'] = date_format($data['thirdstart'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);
        $data['thirdend'] = date_modify($data['last'],"+35 weeks");$data['thirdend'] = date_format($data['thirdend'],"Y-m-d");$data['last'] = date_create($data['lastmenstrualdate']);



        //$log->write("last=".$data['last']);

        if (date("Y-m-d") < $data['receiptdate']) {
            $data['isnottime'] = "1" ;
            //$this->response->redirect($this->url->link('wechat/nottime', '', true));;
        }
        else{
            $data['isnottime'] = "0" ;
        }



        //$data['button_continue'] = $this->language->get('button_continue');

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
        $data['receipt'] = json_decode($test['receipt_text'], true)['receipt'];
        /* $data['xzb'] = $data['receipt'][0]['detail'][2]['value'];
         $data['gxy'] = $data['receipt'][1]['detail']['value'];
         $data['tnb'] = $data['receipt'][2]['detail'][0]['value'];
         $data['alt'] = $data['receipt'][4]['detail'][0]['value'];
         $data['ast'] = $data['receipt'][4]['detail'][1]['value'];
         $data['hgb'] = $data['receipt'][6]['detail'][0]['value'];
         $data['xqb'] = $data['receipt'][6]['detail'][1]['value'];
         $data['other'] = $data['receipt'][7]['detail'][7]['value'];*/

        //$log->write("receiptdate is ".$data["receiptdate"]);
        //$this->load->model('wechat/physicalreceipt');
        //$data['submit']=$this->model_wechat_physicalreceipt->getDateAdd($data['customer_id']);

        //$this->response->setOutput($this->load->view('wechat/physicalreceipt', $data));


        $this->load->model('wechat/physicalreceipt');
        $num = $this->model_wechat_physicalreceipt->getRecord($data['customer_id']);
        //$log->write("num=".$num);

        $firstreceipt= date_create($data['lastmenstrualdate']);
        $firstreceipt= date_modify($firstreceipt, "+11 weeks");
        $firstreceipt= date_format($firstreceipt, "Y-m-d");
        $firstreceipts= date_create($data['lastmenstrualdate']);
        $firstreceipts= date_modify($firstreceipts, "+21 weeks");
        $firstreceipts= date_format($firstreceipts, "Y-m-d");
        $first= date_create($data['lastmenstrualdate']);
        $first= date_modify($first, "+20 weeks");
        $first= date_format($first, "Y-m-d");
        if (!$num && date("Y-m-d")>=$firstreceipt && date("Y-m-d")<$firstreceipts ) {

            $this->load->model('wechat/physicalreceipt');
            $this->model_wechat_physicalreceipt->addReceiptNullHistory();
            $this->load->model('account/customer');
            $this->model_account_customer->updateReceiptDate($data, '20');
            if(date("Y-m-d")<$first) {
                $data['isnottime'] = "1";
            }
        }


        $secondreceipts= date_create($data['lastmenstrualdate']);
        $secondreceipts= date_modify($secondreceipts, "+35 weeks");
        $secondreceipts= date_format($secondreceipts, "Y-m-d");
        $second= date_create($data['lastmenstrualdate']);
        $second= date_modify($second, "+34 weeks");
        $second= date_format($second, "Y-m-d");

        if (date("Y-m-d") >= $firstreceipts && date("Y-m-d") < $secondreceipts) {
            if (!$num) {
                $this->load->model('wechat/physicalreceipt');
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->load->model('account/customer');
                $this->model_account_customer->updateReceiptDate($data, '34');
            }
            if ($num == '1') {
                $this->load->model('wechat/physicalreceipt');
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->load->model('account/customer');
                $this->model_account_customer->updateReceiptDate($data, '34');
            }
            if(date("Y-m-d")<$second){
                $data['isnottime'] = "1" ;

            }

        }


        if (date("Y-m-d") >= $secondreceipts) {
            if (!$num) {
                $this->load->model('wechat/physicalreceipt');
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
            }
            if ($num == '1') {
                $this->load->model('wechat/physicalreceipt');
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
            }
            if ($num == '2') {
                $this->load->model('wechat/physicalreceipt');
                $this->model_wechat_physicalreceipt->addReceiptNullHistory();
            }
            $data['isnottime'] = "2" ;
        }



        /*if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $switch = array();
            foreach($this->request->post['switch'] as $key){
                if($key == "heart"){
                    $switch['0'] = "1";
                }elseif ($key == "hyper"){
                    $switch['1'] = "1";
                }elseif ($key == "GI"){
                    $switch['2'] = "1";
                }elseif ($key == "neph"){
                    $switch['3'] = "1";
                }elseif ($key == "hepa"){
                    $switch['4'] = "1";
                }elseif ($key == "thy"){
                    $switch['5'] = "1";
                }elseif ($key == "bloods"){
                    $switch['6'] = "1";
                }elseif ($key == "otherelse"){
                    $switch['7'] = "1";
                }
            }
            for ($i = 0; $i <8; $i++){
                if( $switch[$i] != "1" || !isset($switch[$i])){
                    $switch[$i] = "0";
                }
            }

            /*$log->write("总数：".count($switch)."第一个：".$switch['0'].
                "第二个：".$switch['1'].
                "第三个：".$switch['2'].
                "第四个：".$switch['3'].
                "第五个：".$switch['4'].
                "第六个：".$switch['5'].
                "第七个：".$switch['6'].
                "第八个：".$switch['7']);





                if ($switch['0'] == "1") {
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

                if ($switch['1'] == "1") {

                    $data['receipt'][1]['detail']['value'] = $this->request->post['gxy'];
                } else {
                    $data['receipt'][1]['flag'] = "0";
                }


                if ($switch['2'] == "1") {
                    $data['receipt'][2]['detail'][0]['value'] = $this->request->post['tnb'];
                    $data['receipt'][2]['detail'][1]['value'] = $this->request->post['cure'];

                } else {
                    $data['receipt'][2]['flag'] = "0";
                }

                if ($switch['3'] == "1") {
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


                if ($switch['4'] == "1") {

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

                if ($switch['5'] == "1") {
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


                if ($switch['6'] == "1") {
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

                if ($switch['7'] == "1") {
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

            $temp = array(
                'receipt' => $data['receipt']
            );


            $result = array(

                'receipt_id' => '1',
                'customer_id' => $data['customer_id'],
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
            $record = $this->model_wechat_physicalreceipt->getRecord($data['customer_id']);
            $this->load->model('account/customer');
            if ($record == '1') {
                $this->model_account_customer->updateReceiptDate($data, '20');
            }
            if ($record == '2') {
                $this->model_account_customer->updateReceiptDate($data, '34');
            }
            $log->write("record=".$record);
            $this->cache->set($success, "1");
            //$this->session->data['success'] = $this->language->get('text_add');
            $this->response->redirect($this->url->link('wechat/physicalreceipt', '', true));
        }*/


        $this->load->model('wechat/physicalreceipt');
        $data["historyrecord"]= $this->model_wechat_physicalreceipt->getRecord($data['customer_id']);
        $log->write("historyrecord=".$data["historyrecord"]);


        if(!isset($this->session->data['success'])){
            $data["success"] = "0";
        }else if($this->session->data['success'] == "1"){
            $data["success"] = "1";
            unset($this->session->data['success']);
        }

        /*if(!isset($this->cache->get($success))){
            $data["success"] = "0";

        }else if($this->cache->get($success) == "1"){
            $data["success"] = "1";
            $this->cache->delete($success);
        }*/

           //$log->write("success=".$data["success"]);

            $this->document->setTitle("回访调查");
            //$data['footer'] = $this->load->controller('common/wechatfooter');
            //$data['header'] = $this->load->controller('common/wechatheader');

        $result  = array(
            'isnotregist' => $data['isnotregist'],
            'ispregnant' =>$data['ispregnant'],
            'pregnant' =>$data["pregnant"],
            'ishighrisk' =>$data["ishighrisk"],
            'success' =>$data["success"],
            'receipt' =>$data['receipt'],
            'receiptdate' =>$data['receiptdate'],
            'isnottime' =>$data['isnottime'],
            //'last' =>$data['last'],
            'firststart' => $data['firststart'],
            'firstend' => $data['firstend'],
            'secondstart' => $data['secondstart'] ,
            'secondend' => $data['secondend'] ,
            'thirdstart' => $data['thirdstart'] ,
            'thirdend' => $data['thirdend'] ,
            'historyrecord' =>$data["historyrecord"],
            'customer_id' =>  $data['customer_id'],
            /*'realname' =>  $data['realname'],
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
            //'district' =>  $data['district'],
            //'address_1' =>  $data['address_1'],
            //'householdregister'   =>  $data['householdregister'],
           // 'footer' => $data['footer'],
            //'header' => $data['header'],*/
        );
        if($data['isnotregist'] == "1"){
            $response = array(
                'code'  => 1011,
                'message'  => "如果您是孕妇用户，请注册后使用本功能，如果您是非孕妇用户，请直接访问健康服务",
                'data' =>array(
                ),
            );

        }elseif ( $data["pregnant"] == "0"){
            $response = array(
                'code'  => 1012,
                'message'  => "您不是孕妇，不需要进行回访调查喔",
                'data' =>array(),
            );

        } elseif ( $data["ishighrisk"] == "0"){
            $response = array(
                'code'  => 1013,
                'message'  => "您不是高危孕妇，不需要进行回访调查喔",
                'data' =>array(),
            );

        }elseif ( $data["success"] == "1"){
            $response = array(
                'code'  => 1014,
                'message'  => "本次回访调查已成功提交！",
                'data' =>array(),
            );

        }elseif ( $data["isnottime"] == "1"){
            $response = array(
                'code'  => 1015,
                'message'  => "您未到下次回访时间，请耐心等待哦",
                'data' =>array(),
            );

        }elseif ( $data["isnottime"] == "2"){
            $response = array(
                'code'  => 1016,
                'message'  => "您的回访调查已结束！",
                'data' =>array(),
            );

        }else{
            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );

        }
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
            //$this->response->setOutput($this->load->view('wechat/physicalreceipt', $data));
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
