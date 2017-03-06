<?php
/**
 * Created by PhpStorm.
 * User: 任晓鹏
 * Date: 2017/1/20
 * Time: 17:59
 */

class ControllerWechatOrderStatusUpdate extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("金杏健康");
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
            $codeinfo = $this->cache->get($code);
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
        $order_id = $this->request->json('order_id');

        if (isset($order_id)) {
            $this->load->model('wechat/ordercenter');
            $order_id=$order_id;
            $data['order_id']=$order_id;
            $this->model_wechat_ordercenter->UpdateOrderStatusToPaid($order_id);
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id);
            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id);

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id, $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array(
                            'name'  => $option['name'],
                            'value' => $option['value'],
                            'type'  => $option['type']
                        );
                    } else {
                        $upload_info = $this->model_wechat_ordercenter->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $option_data[] = array(
                                'name'  => $option['name'],
                                'value' => $upload_info['name'],
                                'type'  => $option['type'],
                                'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
                            );
                        }
                    }
                }

                $product_info['products'][] = array(
                    'order_product_id' => $product['order_product_id'],
                    'product_id'       => $product['product_id'],
                    'name'    	 	   => $product['name'],
                    'model'    		   => $product['model'],
                    'option'   		   => $option_data,
                    'quantity'		   => $product['quantity'],
                    'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'href'     		   => $this->url->link('catalog/product/edit','product_id=' . $product['product_id'], true)
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
            $data = array_merge($order_info, $product_info, $order_totals);

            $this->load->model('extension/total/coupon');
            $coupon_info = $this->model_extension_total_coupon->getCouponInfo($order_id);
            if($coupon_info){
                if($coupon_info['type'] == 'F'){
                    $data["coupontype"] = "F";
                }
                if($coupon_info['type'] == 'P'){
                    $data["coupontype"] = "P";
                }
                $coupon = $this->model_extension_total_coupon-> getTotal($order_info);
                $data['discount'] = $coupon_info['discount'];
                $data['lastprice'] = floatval($coupon['total']);
                unset($this->session->data['coupon']);
            }else{
                $data["coupontype"] = "";
                $data['discount'] = "0";
                $data['lastprice'] = $product_info['products'][0]['price'];
            }
        }

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