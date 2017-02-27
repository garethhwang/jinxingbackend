<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/28
 * Time: 22:41
 */
class ControllerProductTest extends Controller
{
    public function index()
    {
        $log = new Log("wechat.log");
        ini_set('date.timezone', 'Asia/Shanghai');
        //获取用户openid
        $tools = new JsApiPay();
        $openId = "oKe2EwVNWJZA_KzUHULhS1gX6tZQ";

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->GetJsApiParameters($order);

        $data["wxpay"] = $jsApiParameters;
        $data["prepay_id"] = $order['prepay_id'];
        $timeStamp = time();
        $data["timeStamp"] = "$timeStamp";
        $jsapi = new WxPayJsApiPay();
        $data["nonceStr"] = WxPayApi::getNonceStr();
        $data["paySign"] = $jsapi->MakeSign();
        $data["appid"] = AppID;
        $log->write(__CLASS__ . " " . __FUNCTION__ . "prepay_id: " . $data['prepay_id']);
        $log->write(__CLASS__ . " " . __FUNCTION__ . "timeStamp: " . $data["timeStamp"]);
        $log->write(__CLASS__ . " " . __FUNCTION__ . "nonceStr: " . $data["nonceStr"]);
        $log->write(__CLASS__ . " " . __FUNCTION__ . "paySign: " . $data["paySign"]);
        $this->response->setOutput($this->load->view('product/test', $data));

    }
}