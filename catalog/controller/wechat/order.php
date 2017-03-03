<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/12
 * Time: 20:13
 */
class ControllerWechatOrder extends Controller
{
    private $error = array();


     public function validcoupon()
    {


            $product_id = $this->request->json('product_id', 0);

            //$data['product_id'] = $product_id;
            $this->session->data['coupon_product_id'] = $product_id;

            $couponcode =  $this->request->json('couponcode', 0);

        if(isset($couponcode)){
            $this->load->model('extension/total/coupon');

            //$log->write("couponcode=".$couponcode);
            $validcoupon = $this->model_extension_total_coupon->getCoupon($couponcode);

            //$log->write("validcoupon=".$validcoupon["code"]);
            if($validcoupon){
                $response = array(
                    'code'  => 1,
                    'message'  => "折扣券成功启用",
                    'data' =>array(),
                );
                $this->session->data['coupon'] = $couponcode;
            } else{
                $response = array(
                    'code'  => 0,
                    'message'  => "无效折扣券",
                    'data' =>array(),
                );
            }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));


        }


       
    } 


    public function index()
    {
        $this->document->setTitle("下单支付");

        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $this->error['warning'] = "微信信息没有获取到！";
        }

        $this->load->model('wechat/userinfo');
        /*$data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        if (!isset($data['customer_id'])) {
            $data['isnotregist'] = "1";
            $data['customer_id'] = "";
        }
        else{
            $data['isnotregist'] = "0" ;
        }*/

        if(!isset($this->session->data['openid'])){
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }

        //$data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        $data['customer'] = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);

        $this->load->model('account/address');
        $data['address'] = $this->model_account_address->getAddress( $data['customer']["address_id"]);
        if(!isset($data['address'])){
            $data['address'] = array();
        }


        $product_id= $this->request->json('product_id', 0);

        /*if(isset($this->request->get['product_id'])) {
            $data['product_id'] = $this->request->get['product_id'];
        }*/


        //$data['footer'] = $this->load->controller('common/wechatfooter');
       // $data['header'] = $this->load->controller('common/wechatheader');

        $this->load->model('catalog/product');
        $data['product'] = $this->model_catalog_product->getProduct($product_id);

        if(isset($data['product']['price'])){
            $data['product']['price'] = floatval($data['product']['price']);
        }

        $data["provs_data"] = json_encode($this->load->controller('wechat/wechatbinding/getProvince'));
        $data["citys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getCity'));
        $data["dists_data"] = json_encode($this->load->controller('wechat/wechatbinding/getDistrict'));
        $data['action'] = $this->url->link('wechat/order/addOrder', '&product_id=' . $product_id, true);
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        $this->load->model('catalog/product');
        $data['product'] = $this->model_catalog_product->getProduct($product_id);

        if(isset($data['product']['price'])){
            $data['product']['price'] = floatval($data['product']['price']);
        }
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        //$data["provs_data"] = json_encode($this->load->controller('wechat/wechatbinding/getProvince'));
        //$data["citys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getCity'));
       //$data["dists_data"] = json_encode($this->load->controller('wechat/wechatbinding/getDistrict'));
        //$data['action'] = $this->url->link('wechat/order/addOrder', '&product_id=' . $product_id, true);

        $result = array(
            'name' => $data['product']['name'],
            'price' =>  $data['product']['price'],
            'realname' => $data['customer']['realname'],
            'telephone' => $data['customer']['telephone'],
            'city'  =>  $data['address']['city'],
            'addres_1' => $data['address']['address_1'],
            'service_tel' => $data['service_tel']

        );

          $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
        );
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));



        //$this->response->setOutput($this->load->view('wechat/order', $data));
    }

    public function addOrder(){
        $log = new Log("wechat.log");

        $this->document->setTitle("金杏健康");

        $this->load->model('wechat/ordercenter');

        if(isset($this->session->data['openid'])) {
            $data['openid'] = $this->session->data['openid'];
        }

        if(isset($this->session->data['customer_id'])) {
            $data['customer_id'] = $this->session->data['customer_id'];
        }else{
            $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($this->session->data['openid']);
        }


        $data['productCount'] = $this->request->json('productCount',1);
        $data['telephone'] = $this->request->json('telephone',1);
        $data['realname'] = $this->request->json('realname','renxiaopeng');
        $data['address'] = $this->request->json('address','北京');
        $data['shipping_address_1'] = $this->request->json('shipping_address_1','北京');
        $data['shipping_date'] = $this->request->json('shipping_date','2017-1-4');
        $data['product_id'] = $this->request->json('product_id',50);
        $product_id = $data['product_id'];


        /*if(isset($productCount)){
            $data['productCount'] = $productCount;
            $log->write("wechat/orderDetail        222222222");
        } else {
            $data['productCount'] = '1';
            $log->write("wechat/orderDetail        1111111111");
        }

        $log->write("wechat/orderDetail        orderCount = ".$data['productCount']);

        if(isset($telephone)){
            $data['telephone'] = $telephone;
        } else {
            $data['telephone'] = '12312341234';
        }

        if(isset($realname)){
            $data['realname'] = $realname;
        }else{
            $data['realname']='renxiaopeng';
        }

        if(isset($address)){
            $data['address'] = $address;
        }else {
            $data['address'] = '北京';
        }

        if(isset($shipping_address_1)){
            $data['shipping_address_1'] = $shipping_address_1;
        }else{
            $data['shipping_address_1'] = 'aaaaaaaaaaaa';
        }

        if(isset($shipping_date)){
            $data['shipping_date'] = $shipping_date;
        }else{
            $data['shipping_date'] = '2017-1-4 14:00:00';
        }

        if(isset($product_id)) {
            $data['product_id'] = $product_id;
            $product_id = $product_id;
        }else{
            $data['product_id'] = '50';
            $product_id = '50';
        }*/


        $data['invoice_prefix']='INV-2013-00';
        $data['store_id'] = '0';
        $data['store_name'] = '金杏健康';
        $data['store_url'] = 'http://opencart.meluo.net/';
        $data['customer_group_id'] = '1';
        $data['email'] = 'sallyxie@meluo.net';
        $data['payment_realname'] = $data['realname'];
        $data['payment_company'] = '11111';
        $data['payment_address_1'] = '111111';
        $data['payment_address_2'] = '1111111';
        $data['payment_city'] = '11111';
        $data['payment_postcode'] = '1111111111';
        $data['payment_country'] = 'China';
        $data['payment_country_id'] = '44';
        $data['payment_zone'] = 'Anhui';
        $data['payment_zone_id'] = '684';
        $data['payment_address_format'] = '';
        $data['payment_custom_field'] = '[]';
        $data['payment_method'] = '货到付款';
        $data['payment_code'] = 'cod';
        $data['shipping_realname'] = $data['realname'];
        $data['shipping_address_2'] = '1111111';
        $data['shipping_city'] = $data['address'];
        $data['shipping_postcode'] = '1111111111';
        $data['shipping_country'] = 'China';
        $data['shipping_country_id'] = '44';
        $data['shipping_zone'] = '北京';
        $data['shipping_zone_id'] = '684';
        $data['shipping_address_format'] = '';
        $data['shipping_custom_field'] = '[]';
        $data['shipping_method'] = '固定运费率';
        $data['shipping_code'] = 'flat.flat';
        $data['comment'] = '';
        $data['affiliate_id'] = '0';
        $data['commission'] = '0';
        $data['marketing_id'] = '0';
        $data['tracking'] = '';
        $data['language_id'] = '2';
        $data['currency_id'] = '5';
        $data['currency_code'] = 'CNY';
        $data['currency_value'] = '1';
        $data['ip'] = '123.112.87.158';
        $data['forwarded_ip'] = '';
        $data['user_agent'] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0';
        $data['accept_language'] = 'zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3';
        $data['fax'] = '';

        $this->load->model('catalog/product');
        $log = new Log('api.log');
        $log->write("product_id");
        $log->write($product_id);
        $product_info = $this->model_catalog_product->getProduct($product_id);

        $log->write("product_info price");
        $log->write($product_info['price']);

        $data['total'] = $product_info['price'];

        $data['products'][]=array(
            'product_id' => $product_info['product_id'],
            'name' => $product_info['name'],
            'model' => $product_info['model'],
            'quantity' => $data['productCount'],
            'price' => floatval($product_info['price']),
            'total' => $product_info['price'],
            'tax' => '0',
            'option' => array(),
            'reward' => '0'
        );
        $log->write($data['productCount']);
        $log->write($product_info['price']);
        $log->write($product_info['price']*$data['productCount']);

        $data['totals'][]=array(
            'code' => 'sub_total',
            'title' => '小计',
            'value' => $product_info['price']*$data['productCount'],
            'sort_order' => '1'
        );
        $data['totals'][]=array(
            'code' => 'shipping',
            'title' => '固定运费率',
            'value' => '0',
            'sort_order' => '3'
        );
        $data['totals'][]=array(
            'code' => 'total',
            'title' => '总计',
            'value' => $product_info['price']*$data['productCount'],
            'sort_order' => '9'
        );

       

         $this->load->model('extension/total/coupon');
        if(isset($this->session->data['coupon'])){
            $log->write("coupon".$this->session->data['coupon']);
            $coupon_info = $this->model_extension_total_coupon->getCoupon($this->session->data['coupon']);
            if($coupon_info['type'] == 'F'){
                $data["coupontype"] = "F";
            }
            if($coupon_info['type'] == 'P'){
                $data["coupontype"] = "P";
            }
            $data = $this->model_extension_total_coupon-> getTotal($data);
            $data['discount'] = $coupon_info['discount'];
            $data['lastprice'] = floatval($data['total']);
            //$log->write("lastprice".$data['total']);
            unset($this->session->data['coupon']);
        }else{
            $data["coupontype"] = "";
            $data['discount'] = "0";
            $data['lastprice'] = $data['products'][0]['price'];
        }


        $this->load->model('checkout/order');
        $json['order_id']=$this->model_checkout_order->addOrder($data);
        $data['order_id']=$json['order_id'];

        // Set the order history

         $order_status_id = $this->request->json('order_status_id');

        if (isset($order_status_id)) {
            $order_status_id = $order_status_id;
            $data['order_status_id'] = $order_status_id;
        } else {
            $order_status_id = '1';
            $data['order_status_id'] = '1';
        }

        $this->model_checkout_order->addOrderHistory($json['order_id'], $order_status_id);


        /**  pay for product */
        ini_set('date.timezone', 'Asia/Shanghai');
        //获取用户openid
        $tools = new JsApiPay();
        $openId = $this->session->data['openid'];
        $title=$data['products'][0]['name'];
        $price=(int) $data['lastprice']*100;

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
        $order = WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->GetJsApiParameters($order);
        $data["wxpay"] = $jsApiParameters;

        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');

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