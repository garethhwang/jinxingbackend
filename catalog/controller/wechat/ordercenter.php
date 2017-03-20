<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/12
 * Time: 20:13
 */
class ControllerWechatOrdercenter extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("订单中心");

        $this->session->data["nav"]="order";
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


        //$this->response->setOutput($this->load->view('wechat/ordercenter', $data));
    }

    public function getPendingList()
    {
        $this->document->setTitle("待支付订单");

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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $data['column_product'] = "商品";
        $data['column_model'] = "型号";
        $data['column_quantity'] = "数量";
        $data['column_price'] = "单品价格";
        $data['column_total'] = "单品小计";

        $this->load->model('wechat/ordercenter');
        $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($data["openid"]);
        $log = new Log('api.log');
        $log->write($data['customer_id']);
        if(!isset($data['customer_id'])){

            $data['orders']= array();

            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));

            return ;

        }


        $allorderids= $this->model_wechat_ordercenter->getAllPendingOrderid($data['customer_id']);

        foreach ($allorderids as $order_id)
        {
            $log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);
            $order_info['total']=floatval( $order_info['total']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }
            $data['orders'][] = array_merge($order_info, $product_info, $order_totals);

        }

        $this->session->data["nav"]="order";
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $data['pay_href'] = $this->url->link('wechat/orderDetail');
        $data['detail_href'] = $this->url->link('wechat/orderDetail');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        if(!isset($data['orders'])){

            $data['orders'] = array();

        }

         $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
         );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        /*if(isset($data['orders'])){
            $this->response->setOutput($this->load->view('wechat/orderto', $data));
        }else{
            $this->response->setOutput($this->load->view('wechat/noorder', $data));
        }*/
    }

    public function getPaidList()
    {
        $this->document->setTitle("已支付未完成订单");

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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $data['column_product'] = "商品";
        $data['column_model'] = "型号";
        $data['column_quantity'] = "数量";
        $data['column_price'] = "单品价格";
        $data['column_total'] = "单品小计";

        //$data['openid']='oKe2EwVNWJZA_KzUHULhS1gX6tZQ';

        $this->load->model('wechat/ordercenter');
        $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($data["openid"]);
        $log = new Log('api.log');
        $log->write($data['customer_id']);
        if(!isset($data['customer_id'])){
            $data['orders']= array();

            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));

            return ;
        }

        $allorderids= $this->model_wechat_ordercenter->getAllPaidOrderid($data['customer_id']);

        foreach ($allorderids as $order_id)
        {
            $log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);

            $order_info['total']=floatval( $order_info['total']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $data['orders'][] = array_merge($order_info, $product_info, $order_totals);

        }

        $this->session->data["nav"]="order";
       // $data['footer'] = $this->load->controller('common/wechatfooter');
       // $data['header'] = $this->load->controller('common/wechatheader');
        $data['detail_href'] = $this->url->link('wechat/orderDetail');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        if(!isset($data['orders'])){

            $data['orders'] = array();

        }


             $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));

       /* if(isset($data['orders'])){
            $this->response->setOutput($this->load->view('wechat/orderpaid', $data));
        }else{
            $this->response->setOutput($this->load->view('wechat/noorder', $data));
        }*/
    }

    public function getCompletedList()
    {
        $this->document->setTitle("已完成订单");

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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);


        $data['column_product'] = "商品";
        $data['column_model'] = "型号";
        $data['column_quantity'] = "数量";
        $data['column_price'] = "单品价格";
        $data['column_total'] = "单品小计";

        $this->load->model('wechat/ordercenter');
        $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($data["openid"]);
        $log = new Log('api.log');
        $log->write($data['customer_id']);
        if(!isset($data['customer_id'])){
            $data['orders']= array();

            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));

            return ;
        }

        $allorderids= $this->model_wechat_ordercenter->getAllCompletedOrderid($data['customer_id']);

        foreach ($allorderids as $order_id)
        {
            $log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);

            $order_info['total']=floatval( $order_info['total']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $data['orders'][] = array_merge($order_info, $product_info, $order_totals);

        }

        $this->session->data["nav"]="order";
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $data['detail_href'] = $this->url->link('wechat/orderDetail');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        if(!isset($data['orders'])){

            $data['orders'] = array();

        }


        $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
        
        /*if(isset($data['orders'])){
            $this->response->setOutput($this->load->view('wechat/ordercompleted', $data));
        }else{
            $this->response->setOutput($this->load->view('wechat/noorder', $data));
        }*/

    }

    public function getAllList()
    {
        $this->document->setTitle("所有订单");

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

        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);


        $data['column_product'] = "商品";
        $data['column_model'] = "型号";
        $data['column_quantity'] = "数量";
        $data['column_price'] = "单品价格";
        $data['column_total'] = "单品小计";

        $this->load->model('wechat/ordercenter');
        $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($data["openid"]);
        $log = new Log('api.log');
        $log->write($data['customer_id']);
        if(!isset($data['customer_id'])){
            $data['orders']= array();

            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));

            return ;
        }


        $allorderids = $this->model_wechat_ordercenter->getAllOrderid($data['customer_id']);

        foreach ($allorderids as $order_id)
        {
            //$log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);
            $order_info['total']=floatval( $order_info['total']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }
            $data['orders'][] = array_merge($order_info, $product_info, $order_totals);

        }


        /*$pendingorderids = $this->model_wechat_ordercenter->getAllPendingOrderid($data['customer_id']);

        foreach ($pendingorderids as $order_id)
        {
            $log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }
            $data['pendingorders'][] = array_merge($order_info, $product_info, $order_totals);
        }

        $paidorderids = $this->model_wechat_ordercenter->getAllPaidOrderid($data['customer_id']);
        $completeorderids =  $this->model_wechat_ordercenter->getAllCompletedOrderid($data['customer_id']);

        $allorderids = array_merge($paidorderids, $completeorderids);

        foreach ($allorderids as $order_id)
        {
            $log->write($order_id['order_id']);
            $this->load->model('wechat/ordercenter');
            $order_info = $this->model_wechat_ordercenter->getOrder($order_id['order_id']);

            $products = $this->model_wechat_ordercenter->getOrderProducts($order_id['order_id']);
            $product_info = array();

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_wechat_ordercenter->getOrderOptions($order_id['order_id'], $product['order_product_id']);

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

            $totals = $this->model_wechat_ordercenter->getOrderTotals($order_id['order_id']);

            foreach ($totals as $total) {
                $order_totals['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $data['otherorders'][] = array_merge($order_info, $product_info, $order_totals);

        }*/

        $this->session->data["nav"]="order";
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $data['pay_href'] = $this->url->link('wechat/orderDetail');
        $data['detail_href'] = $this->url->link('wechat/orderDetail');
        $data['service_tel'] = WECHAT_SERVICE_TEL;

        if(!isset($data['orders'])){

            $data['orders'] = array();

        }

            $response = array(
                'code'  => 0,
                'message'  => "",
                'data' =>array(),
            );
            $response["data"] = $data;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));




        /*if(isset($data['pendingorders']) || isset($data['otherorders'])){
            $this->response->setOutput($this->load->view('wechat/orderall', $data));
        }else{
            $this->response->setOutput($this->load->view('wechat/noorder', $data));
        }*/

    }

    public function delete(){

        $log = new Log("wechat.log");


        $this->document->setTitle("删除订单");

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

        //$data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';
        $order_id = $this->request->json('order_id', 0);

        $this->load->model('wechat/ordercenter');

        $data['customer_id'] = $this->model_wechat_ordercenter->getCustomeridByOpenid($data["openid"]);
        if(!isset($data['customer_id'])){
            $data['customer_id'] = "0";
        }

       // $log->write("CUSTOMERid=". $data['customer_id']);

        $allorderids= $this->model_wechat_ordercenter->getAllPendingOrderid($data['customer_id']);

        foreach ($allorderids as $id){

            if ($order_id == $id['order_id']) {

                $this->load->model('extension/total/coupon');

                $this->model_extension_total_coupon->unconfirm($order_id);

            }
        }
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "affiliate_transaction` WHERE order_id = '" . (int)$order_id . "'");

        // Gift Voucher
        $this->load->model('extension/total/voucher');

        $this->model_extension_total_voucher->disableVoucher($order_id);


        $response = array(
            'code'  => 0,
            'message'  => "已成功删除该订单",
            'data' =>array(),
        );
        //$response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));



    }
}