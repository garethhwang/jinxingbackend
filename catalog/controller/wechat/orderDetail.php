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

        $this->document->setTitle("金杏健康");

        $this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
            $this->error['warning'] = "微信信息没有获取到！";
        }


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

        $order_id = $this->request->json('order_id', 0);


        if (isset($order_id)) {
            $this->load->model('wechat/ordercenter');
            $data['order_id']=$order_id;
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id);

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

                    $product_info['products'][] = array(
                        'order_product_id' => $product['order_product_id'],
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'href' => $this->url->link('catalog/product/edit', 'product_id=' . $product['product_id'], true)
                    );
                }
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

            /**  pay for product */
            ini_set('date.timezone', 'Asia/Shanghai');
            //获取用户openid
            $tools = new JsApiPay();

            $this->session->data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';
            $openId = $this->session->data['openid'];
            $title=$data['products'][0]['name'];
            $price=(int)$data['lastprice']*100;

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

}