<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/12
 * Time: 20:13
 */
class ControllerWechatOrderDetail extends Controller
{
    private $error = array();

    public function index()
    {

        $log = new Log("wechat.log");
        $this->document->setTitle("金杏健康");

        //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        /*if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code","");
        //$log->write("code=".$code);
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code);
            $codeinfo=json_decode($codeinfo,true);
            $temp["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
            //$log->write("78687y898989openid=".$data["openid"]);
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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);*/

        $jxsession = $this->load->controller('account/authentication');


        //$log_file  = '/home/work/www/BeJinXingJK/www/system/storage/logs/test.txt';


        if(empty($jxsession)) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array()
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }

        $customer_info = json_decode($this->cache->get($jxsession),true);

        //if($f  = file_put_contents($log_file, $customer_info, FILE_APPEND)){}
        //$log->write("openid = ".$customer_info["openid"]);



        $order_id = $this->request->json('order_id', 0);


        if (isset($order_id)) {
            $this->load->model('wechat/ordercenter');
            $data['order_id']=$order_id;
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id);

            //$log->write("totaL44444" . $order_info['total']);


            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id);

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id, $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $option['value'],
                            'type' => $option['type']
                        );
                    } else {
                        $upload_info = $this->model_wechat_ordercenter->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $option_data[] = array(
                                'name' => $option['name'],
                                'value' => $upload_info['name'],
                                'type' => $option['type'],
                                'href' => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
                            );
                        }
                    }
                    }

                    $product_info['products'][] = array(
                        'order_product_id' => $product['order_product_id'],
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'total' => $product['total'],
                        'href' => $this->url->link('catalog/product/edit', 'product_id=' . $product['product_id'], true)
                    );

            }

            $order_totals = array();

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $product_info['products'][0]['price']=floatval($product_info['products'][0]['price']);
            $product_info['products'][0]['total']=floatval($product_info['products'][0]['total']);


            $data = array_merge($order_info, $product_info, $order_totals);

            $data['shipping_city'] = $this->ConvertPosition($data['shipping_city']);

            $this->load->model('extension/total/coupon');
            $coupon_info = $this->model_extension_total_coupon->getCouponInfo($order_id,$order_info['customer_id']);
            if($coupon_info){
                if($coupon_info['type'] == 'F'){
                    $data["coupontype"] = "F";
                }
                if($coupon_info['type'] == 'P'){
                    $data["coupontype"] = "P";
                }
                //$coupon = $this->model_extension_total_coupon-> getTotal($product_info['products'][0], $coupon_info['code'],$product_info['products'][0]['product_id'],$order_info['customer_id']);
                $data['discount'] =  floatval($coupon_info['discount']);
                $data['lastprice'] = floatval($order_info['total']);
                //$log->write("lastprice".$data['lastprice']);
                //unset($this->session->data['coupon']);
            }else{
                $data["coupontype"] = "";
                $data['discount'] = "0";
                $data['lastprice'] = $product_info['products'][0]['price'];
            }

            if($product_info['products'][0]['product_id'] == 68) {
                $data['lastprice'] =0.01;
            }

            $data["jxsession"] = $jxsession;


            /**  pay for product */
            ini_set('date.timezone', 'Asia/Shanghai');
            //获取用户openid
            $tools = new JsApiPay();

            //$this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';
            if(empty($customer_info['openid'])){

                $response = array(
                    'code'  => 1035,
                    'message'  => "请在微信客户端支付",
                    'data' =>array(),
                );

                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($response));
                return ;

            }


            $openId = $customer_info['openid'];
            $title=$data['products'][0]['name'];
            $price=(int)($data['lastprice']*100);


            //②、统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody($title);
            $input->SetAttach($title);
            $input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
            $input->SetTotal_fee((int)$price);
            $input->SetTime_start(date("YmdHis"));
            $input->SetGoods_tag("test");
            $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $input->SetAppid('wx5ce715491b2cf046');
            $order = WxPayApi::unifiedOrder($input);

            $jsApiParameters = $tools->GetJsApiParameters($order);
            $data["wxpay"] = $jsApiParameters;
        }

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

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

    public function ConvertPosition($position){
        $temp_arr = explode(",", $position);
        $this->load->model('clinic/clinic');
        if (count($temp_arr) == 3) {
            $provinceName = $this->model_clinic_clinic->getProvince($temp_arr[0]);
            $cityName = $this->model_clinic_clinic->getCity($temp_arr[1]);
            $districtName = $this->model_clinic_clinic->getDistrict($temp_arr[2]);
            if($provinceName == $cityName){
                return $cityName."市".$districtName.'区';
            } else {
                return $provinceName."省".$cityName."市".$districtName.'区';
            }

        }

    }



}
